<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->check_login();
        $this->check_role(['admin', 'empleado']);
        $this->load->model('Venta_model');
        $this->load->model('Usuario_model');
        $this->load->model('Actividad_model');
    }

    private function check_login() {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            redirect('auth/login');
        } else {
            // Verificar el estado directamente desde la base de datos
            $user = $this->Usuario_model->get_usuario_by_id($this->session->userdata('user_id'));
            if ($user->estado != 'activo') {
                $this->session->set_flashdata('error', 'Tu cuenta está inactiva. Revisa tu correo para confirmar tu cuenta.');
                redirect('auth/login');
            }
            // Guardar los datos del usuario en la sesión
            $this->session->set_userdata('imagen', $user->imagen);
            $this->session->set_userdata('nombre', $user->nombre);
            $this->session->set_userdata('apellido', $user->apellido);
        }
    }

    private function check_role($roles) {
        $user_role_id = $this->session->userdata('rol_id');
        $allowed_roles = $this->Usuario_model->get_roles_by_names($roles);
    
        if (!in_array($user_role_id, $allowed_roles)) {
            $this->session->set_flashdata('error', 'No tienes permiso para acceder a esta página.');
            redirect('auth/login');
        }
    }    

    public function dashboard() {
        // Obtener el usuario actual
        $data['usuario'] = $this->Usuario_model->get_usuario_by_id($this->session->userdata('user_id'));
    
        // Obtener las ventas de hoy
        $data['ventas_hoy'] = $this->Venta_model->get_ventas_count_by_period('hoy');
    
        // Obtener los ingresos de hoy
        $data['ingresos_hoy'] = $this->Venta_model->get_ingresos_by_period('hoy');
    
        // Obtener los clientes de hoy
        $data['clientes_hoy'] = $this->Usuario_model->get_clientes_count_by_period('hoy');
    
        // Obtener todas las ventas (opcional, si lo necesitas en la vista)
        $data['ventas'] = $this->Venta_model->get_all_ventas();
    
        // Obtener todos los clientes activos (opcional, si lo necesitas en la vista)
        $data['clientes'] = $this->Usuario_model->get_all_clientes();
    
        // Obtener los productos más vendidos
        $data['top_selling_products'] = $this->Venta_model->get_top_selling_products(5);
    
        // Obtener las actividades recientes
        $data['actividades'] = $this->Actividad_model->obtener_actividades_recientes(5);
    
        // Cargar las vistas y pasar los datos
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/template/navbar', $data);
        $this->load->view('admin/template/dashboard', $data); // Pasas los datos de hoy a la vista
        $this->load->view('admin/template/footer');
    }
    
    public function index() {
        $this->dashboard();
    }
}
?>
