<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->model('Categoria_model');
        $this->load->model('Venta_model');
        $this->check_login();
        $this->check_permissions(); // Asegurarnos de verificar los permisos en la construcción del controlador.
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
        $data['productos'] = $this->Producto_model->get_productos_by_estado('activo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/producto/productos', $data);
        $this->load->view('admin/template/footer');
    }
    
    public function inactivos() {
        $this->check_permissions();
        $data['productos'] = $this->Producto_model->get_productos_by_estado('inactivo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/producto/productos_inactivos', $data);
        $this->load->view('admin/template/footer');
    }      
    
    public function agregar() {
        $this->check_permissions();
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/producto/agregar_producto', $data);
        $this->load->view('admin/template/footer');
    }

    public function guardar() {
        $this->check_permissions();
        $this->form_validation->set_rules('nombre_producto', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion_producto', 'Descripción', 'required');
        $this->form_validation->set_rules('precio_producto', 'Precio', 'required|numeric');
        $this->form_validation->set_rules('stock_producto', 'Stock', 'required|integer');
        $this->form_validation->set_rules('categoria_id', 'Categoría', 'required');
        $this->form_validation->set_rules('estado_producto', 'Estado', 'required');
    
        // Verificar si ya existe un producto con el mismo nombre
        $nombre_producto = $this->input->post('nombre_producto');
        $producto_existente = $this->Producto_model->get_producto_by_nombre($nombre_producto);

        if ($producto_existente) {
            // Si el producto ya existe, mostrar un mensaje de error y redirigir al formulario
            $this->session->set_flashdata('error', 'Ya existe un producto con este nombre.');
            redirect('productos/agregar');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->agregar();
        } else {
            $data_producto = array(
                'nombre' => $this->input->post('nombre_producto'),
                'descripcion' => $this->input->post('descripcion_producto'),
                'precio' => $this->input->post('precio_producto'),
                'stock' => $this->input->post('stock_producto'),
                'categoria_id' => $this->input->post('categoria_id'),
                'estado' => $this->input->post('estado_producto'),
                'usuario_actualizacion_id' => $this->session->userdata('user_id')
            );
    
            // Manejo de la subida de imagen
            if (!empty($_FILES['imagen']['name'])) {
                $config['upload_path'] = './assets_admin/productos/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('imagen')) {
                    $upload_data = $this->upload->data();
                    $data_producto['imagen'] = 'assets_admin/productos/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->agregar();
                    return;
                }
            } else {
                $data_producto['imagen'] = null; // O maneja el caso cuando no se sube imagen
            }
    
            $this->Producto_model->insert_producto($data_producto);
            $this->session->set_flashdata('success', 'Producto agregado con éxito.');
            redirect('productos');
        }
    }
    
    public function editar($id) {
        $this->check_permissions();
        $data['producto'] = $this->Producto_model->get_producto_by_id($id);
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/producto/editar_producto', $data);
        $this->load->view('admin/template/footer');
    }

    public function actualizar() {
        $this->check_permissions();
        $id = $this->input->post('id');
    
        $this->form_validation->set_rules('nombre_producto', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion_producto', 'Descripción', 'required');
        $this->form_validation->set_rules('precio_producto', 'Precio', 'required|numeric');
        $this->form_validation->set_rules('stock_producto', 'Stock', 'required|integer');
        $this->form_validation->set_rules('categoria_id', 'Categoría', 'required');
    
        // Verificar si ya existe otro producto con el mismo nombre (excluyendo el actual)
        $nombre_producto = $this->input->post('nombre_producto');
        $producto_existente = $this->Producto_model->get_producto_by_nombre($nombre_producto);

        if ($producto_existente && $producto_existente->id != $id) {
            // Si ya existe un producto con el mismo nombre (y no es el producto actual), mostrar error
            $this->session->set_flashdata('error', 'Ya existe otro producto con este nombre.');
            redirect('productos/editar/' . $id);
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->editar($id);
        } else {
            $data_producto = array(
                'nombre' => $this->input->post('nombre_producto'),
                'descripcion' => $this->input->post('descripcion_producto'),
                'precio' => $this->input->post('precio_producto'),
                'stock' => $this->input->post('stock_producto'),
                'categoria_id' => $this->input->post('categoria_id'),
                'estado' => $this->input->post('estado_producto'),
                'usuario_actualizacion_id' => $this->session->userdata('user_id')
            );
    
            // Manejo de la subida de imagen
            if (!empty($_FILES['imagen']['name'])) {
                $config['upload_path'] = './assets_admin/productos/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB
                $config['file_name'] = uniqid() . '_' . $_FILES['imagen']['name'];
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('imagen')) {
                    $upload_data = $this->upload->data();
                    $data_producto['imagen'] = 'assets_admin/productos/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->editar($id);
                    return;
                }
            }
    
            $this->Producto_model->update_producto($id, $data_producto);
            $this->session->set_flashdata('success', 'Producto actualizado con éxito.');
            redirect('productos');
        }
    }
    
    public function eliminar($id) {
        $this->check_permissions();
        
        // Verificar si el producto tiene ventas asociadas
        $tiene_ventas_asociadas = $this->Venta_model->tiene_ventas_asociadas($id);
        
        if ($tiene_ventas_asociadas) {
            $this->session->set_flashdata('error', 'No se puede eliminar el producto porque tiene ventas asociadas.');
        } else {
            // Eliminar el producto (incluyendo la eliminación de la imagen si existe)
            $this->Producto_model->delete_producto($id);
            $this->session->set_flashdata('success', 'Producto eliminado con éxito.');
        }
        
        redirect('productos');
    }    
    
    public function ver($id) {
        $this->check_permissions();
        $data['producto'] = $this->Producto_model->get_producto_by_id($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/producto/ver_producto', $data);
        $this->load->view('admin/template/footer');
    }

    public function ver_ajax($id) {
        $this->check_permissions();
        $this->db->select('p.*, c.nombre as categoria_nombre, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('producto p');
        $this->db->join('categoria c', 'p.categoria_id = c.id', 'left');
        $this->db->join('usuario u', 'p.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        echo json_encode($query->row());
    }

    public function listar() {
        $data['productos'] = $this->Producto_model->get_productos_by_estado('activo');
        $this->load->view('cliente/productos', $data);
    }    
    
    public function get_productos_by_categoria($categoria_id) {
        $productos = $this->Producto_model->get_productos_activos_por_categoria($categoria_id);
        echo json_encode($productos);
    }

    public function buscar_producto()
    {
        $query = $this->input->get('query');
        $productos = $this->Producto_model->buscar_producto($query);
        echo json_encode(['productos' => $productos]);
    }

    // Método para buscar productos según el término de búsqueda
    public function buscar_producto_ajax() {
        $query = $this->input->get('query'); // Obtener el término de búsqueda

        $this->db->like('nombre', $query);
        $this->db->limit(10);
        $resultados = $this->db->get('producto')->result();

        // Preparar el resultado
        $productos = [];
        foreach ($resultados as $producto) {
            $productos[] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio_unitario' => $producto->precio, // Asegúrate de que este campo esté disponible
                'imagen' => base_url($producto->imagen), 
                'categoria_id' => $producto->categoria_id
            ];
        }

        echo json_encode($productos); // Devolver los resultados en formato JSON
    }

}
?>
