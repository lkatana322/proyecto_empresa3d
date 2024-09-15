<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Categoria_model');
        $this->check_login();
    }

    private function check_login() {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            redirect('auth/login');
        }
    }

    private function check_permissions() {
        $user_role = $this->session->userdata('rol'); // Obtener el rol del usuario desde la sesión
        if ($user_role == 'cliente') { // Verificar si el rol es 'cliente'
            $this->session->set_flashdata('error', 'No tienes permiso para realizar esta acción.');
            redirect('admin'); // Redirige al dashboard si intentan acceder
        }
    }    
    
    public function index() {
        $this->check_permissions();
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/categoria/categorias', $data);
        $this->load->view('admin/template/footer');
    }

    public function inactivas() {
        $this->check_permissions();
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('inactivo'); // Solo categorías inactivas
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/categoria/categorias_inactivas', $data);
        $this->load->view('admin/template/footer');
    }    

    public function agregar() {
        $this->check_permissions();
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/categoria/agregar_categoria');
        $this->load->view('admin/template/footer');
    }

    public function guardar() {
        // Configuración para la subida de archivos
        $config['upload_path'] = './assets_admin/categorias/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB máximo
        $config['file_name'] = uniqid() . '_' . $_FILES['imagen_categoria']['name'];
    
        $this->load->library('upload', $config);
    
        if ($this->upload->do_upload('imagen_categoria')) {
            $upload_data = $this->upload->data();
            $imagen = 'assets_admin/categorias/' . $upload_data['file_name']; // Guardar la ruta relativa
        } else {
            // Log de errores
            log_message('error', $this->upload->display_errors());
            $imagen = NULL;
            $this->session->set_flashdata('error', 'Error al subir la imagen: ' . $this->upload->display_errors());
            redirect('categorias/agregar');
            return;
        }
    
        $data_categoria = array(
            'nombre' => $this->input->post('nombre_categoria'),
            'descripcion' => $this->input->post('descripcion_categoria'),
            'imagen' => $imagen,
            'estado' => $this->input->post('estado_categoria')
        );
    
        $this->Categoria_model->insert_categoria($data_categoria);
        $this->session->set_flashdata('success', 'Categoría agregada con éxito.');
        redirect('categorias');
    }
    
    public function editar($id) {
        $this->check_permissions();
        $data['categoria'] = $this->Categoria_model->get_categoria_by_id($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/categoria/editar_categoria', $data);
        $this->load->view('admin/template/footer');
    }

    public function actualizar() {
        $this->check_permissions();
        $id = $this->input->post('id');
    
        $this->form_validation->set_rules('nombre_categoria', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion_categoria', 'Descripción', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->editar($id);
        } else {
            // Inicializa $imagen como NULL
            $imagen = $this->input->post('imagen_actual');
    
            // Verifica si se ha subido una nueva imagen
            if (!empty($_FILES['imagen_categoria']['name'])) {
                $config['upload_path'] = './assets_admin/categorias/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = 2048; // 2MB máximo
                $config['file_name'] = uniqid() . '_' . $_FILES['imagen_categoria']['name'];
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('imagen_categoria')) {
                    $upload_data = $this->upload->data();
                    $imagen = 'assets_admin/categorias/' . $upload_data['file_name'];
                } else {
                    // Puedes manejar los errores de subida aquí si es necesario
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->editar($id);
                    return;
                }
            }
    
            $data_categoria = array(
                'nombre' => $this->input->post('nombre_categoria'),
                'descripcion' => $this->input->post('descripcion_categoria'),
                'imagen' => $imagen, // Usa la imagen nueva o la imagen actual si no se subió ninguna
                'estado' => $this->input->post('estado_categoria'),
                'usuario_actualizacion_id' => $this->session->userdata('user_id')
            );
    
            $this->Categoria_model->update_categoria($id, $data_categoria);
            $this->session->set_flashdata('success', 'Categoría actualizada con éxito.');
            redirect('categorias');
        }
    }    
    
    public function eliminar($id) {
        $this->check_permissions();
    
        // Verificar si la categoría tiene productos asociados
        $this->load->model('Producto_model');  // Asegúrate de tener este modelo
        $productos_asociados = $this->Producto_model->get_productos_por_categoria($id);
    
        if (!empty($productos_asociados)) {
            $this->session->set_flashdata('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        } else {
            // Si no hay productos asociados, procedemos con la eliminación
            $this->Categoria_model->delete_categoria($id);
            $this->session->set_flashdata('success', 'Categoría eliminada con éxito.');
        }
    
        redirect('categorias');
    }     

    public function ver_ajax($id) {
        $this->db->select('c.*, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('categoria c');
        $this->db->join('usuario u', 'c.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        echo json_encode($query->row());
    }
    
    public function listar() {
        $data['categorias'] = $this->Categoria_model->get_all_categorias();
        $this->load->view('cliente/categorias', $data);
    }
    
    public function get_categoria_by_producto()
    {
        $producto_id = $this->input->get('producto_id');
        $categoria = $this->Categoria_model->get_categoria_by_producto($producto_id);
        
        if ($categoria) {
            echo json_encode(['categoria' => $categoria]);
        } else {
            echo json_encode(['categoria' => null]);
        }
    }
    
    
}
?>
