<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
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

    public function index()
    {
        $this->check_permissions();
        $data['usuario'] = $this->Usuario_model->get_usuario_by_id($this->session->userdata('user_id'));
        
        // Calcular la edad basada en la fecha de nacimiento
        if ($data['usuario']->fecha_nacimiento) {
            $fecha_nacimiento = new DateTime($data['usuario']->fecha_nacimiento);
            $hoy = new DateTime();
            $edad = $hoy->diff($fecha_nacimiento)->y;
            $data['usuario']->edad = $edad;
        } else {
            $data['usuario']->edad = 'No especificado';
        }
    
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/perfil', $data);
        $this->load->view('admin/template/footer');
    }
    
    public function actualizar()
    {
        $id = $this->session->userdata('user_id');
        $usuario = $this->Usuario_model->get_usuario_by_id($id);
    
        // Validaciones de los campos
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|alpha');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido', 'alpha');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'required');
        $this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email');
    
        if ($usuario->rol == 'admin' || $usuario->rol == 'empleado') {
            $this->form_validation->set_rules('telefono', 'Teléfono', 'required|numeric');
            $this->form_validation->set_rules('direccion', 'Dirección', 'required');
        }
    
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
    
        if ($new_password || $confirm_password) {
            $this->form_validation->set_rules('current_password', 'Contraseña Actual', 'required');
            $this->form_validation->set_rules('new_password', 'Nueva Contraseña', 'required|min_length[8]|regex_match[/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'required|matches[new_password]');
        }
    
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            // Verificar la contraseña actual
            if (!empty($current_password) && !password_verify($current_password, $usuario->contraseña)) {
                $this->session->set_flashdata('error', 'La contraseña actual es incorrecta.');
                redirect('perfil');
            }
    
            // Procesar subida de la imagen
            if (!empty($_FILES['imagen']['name'])) {
                $config['upload_path'] = './assets_admin/img/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // 2MB máximo
                $config['file_name'] = 'perfil_' . $id;
    
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('imagen')) {
                    // Obtener los datos de la imagen subida
                    $upload_data = $this->upload->data();
                    $data_usuario['imagen'] = 'assets_admin/img/' . $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('perfil');
                }
            }
    
            // Asignar valores al array $data_usuario para actualizar el registro
            $data_usuario['nombre'] = strtoupper($this->input->post('nombre'));
            $data_usuario['apellido'] = strtoupper($this->input->post('apellido'));
            $data_usuario['segundo_apellido'] = strtoupper($this->input->post('segundo_apellido'));
            $data_usuario['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
            $data_usuario['email'] = $this->input->post('email');
            $data_usuario['telefono'] = $this->input->post('telefono');
            $data_usuario['direccion'] = $this->input->post('direccion');
    
            // Si se proporcionó una nueva contraseña, actualizarla
            $new_password_plain = null;
            if ($new_password) {
                $new_password_plain = $new_password; // Guardar la contraseña en texto plano
                $data_usuario['contraseña'] = password_hash($new_password, PASSWORD_DEFAULT);
            }
    
            $this->Usuario_model->update_usuario($id, $data_usuario);
    
            // Si el email ha cambiado, enviar un correo de confirmación con la nueva contraseña si corresponde
            if ($this->input->post('email') !== $this->input->post('email_original')) {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_user' => 'alvarez.brandon.13353@gmail.com',
                    'smtp_pass' => 'pesi nobu rmrd dhxm',
                    'smtp_port' => 465,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'newline' => "\r\n"
                );
    
                $this->load->library('email', $config);
                $this->email->initialize($config);
    
                $this->email->from('alvarez.brandon.13353@gmail.com', '3D Print Shop');
                $this->email->to($this->input->post('email'));
                $this->email->subject('Confirmación de Actualización');
                
                $message = 'Tu información ha sido actualizada exitosamente.';
                if ($new_password_plain) {
                    $message .= '<br>Tu nueva contraseña es: ' . $new_password_plain;
                }
    
                $this->email->message($message);
    
                if (!$this->email->send()) {
                    show_error($this->email->print_debugger());
                }
            }
    
            $this->session->set_flashdata('success', 'Perfil actualizado correctamente.');
            redirect('perfil');
        }
    }
    
}
?>
