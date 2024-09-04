<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->library('form_validation');
    }

    public function login() {
        $this->load->view('auth/login');
    }

    public function login_action() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        $user = $this->Usuario_model->get_usuario_by_email($email);
    
        if (!$user) {
            $this->session->set_flashdata('error', 'El correo electrónico no está registrado.');
            redirect('auth/login');
        } else {
            if ($user->estado != 'activo') {
                $this->session->set_flashdata('error', 'Tu cuenta está inactiva. Revisa tu correo para confirmar tu cuenta.');
                redirect('auth/login');
            }
    
            if (password_verify($password, $user->contraseña)) {
                // Obtener el rol del usuario junto con otros datos y guardarlos en la sesión
                $this->db->select('usuarios.*, roles.nombre as rol');
                $this->db->from('usuarios');
                $this->db->join('roles', 'usuarios.rol_id = roles.id');
                $this->db->where('usuarios.email', $email);
                $query = $this->db->get();

                if ($query->num_rows() == 1) {
                    $usuario = $query->row();
                    $this->session->set_userdata('user_id', $usuario->id);
                    $this->session->set_userdata('rol_id', $usuario->rol_id); 
                    $this->session->set_userdata('rol', $usuario->rol); // Guarda el nombre del rol en la sesión
                    $this->session->set_userdata('nombre', $usuario->nombre);
                    $this->session->set_userdata('apellido', $usuario->apellido);
                    $this->session->set_userdata('segundo_apellido', $usuario->segundo_apellido);
                    $this->session->set_userdata('edad', $usuario->edad);
                    $this->session->set_userdata('imagen', $usuario->imagen);
    
                    // Redirigir según el rol del usuario
                    if ($usuario->rol_id == 1) {
                        redirect('admin/dashboard');
                    } elseif ($usuario->rol_id == 2) {
                        redirect('admin/dashboard');
                    } elseif ($usuario->rol_id == 3) {
                        redirect('cliente/home');
                    } else {
                        $this->session->set_flashdata('error', 'No tienes permiso para acceder a esta página.');
                        redirect('auth/login');
                    }
                }
            } else {
                // Contraseña incorrecta
                $this->session->set_flashdata('error', 'Contraseña incorrecta.');
                redirect('auth/login');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register() {
        $this->load->view('auth/register');
    }

    public function register_action() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('segundo_apellido', 'Segundo Apellido');
        $this->form_validation->set_rules('edad', 'Edad', 'numeric');
        $this->form_validation->set_rules('imagen', 'Imagen');
        $this->form_validation->set_rules('email', 'Correo Electrónico', 'required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[8]');
        $this->form_validation->set_rules('password_confirm', 'Confirmar Contraseña', 'required|matches[password]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/register');
        } else {
            $nombre = strtoupper($this->input->post('nombre'));
            $apellido = strtoupper($this->input->post('apellido'));
            $segundo_apellido = strtoupper($this->input->post('segundo_apellido'));
            $edad = $this->input->post('edad');
            $imagen = $this->input->post('imagen');
            $email = $this->input->post('email');
            $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
    
            $codigo_confirmacion = rand(100000, 999999);
            $codigo_expiracion = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
            $data = array(
                'nombre' => $nombre,
                'apellido' => $apellido,
                'segundo_apellido' => $segundo_apellido,
                'edad' => $edad,
                'imagen' => $imagen,
                'email' => $email,
                'contraseña' => $password,
                'rol_id' => 3,  // Definiendo 'cliente' como rol por defecto
                'estado' => 'inactivo',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'codigo_confirmacion' => $codigo_confirmacion,
                'codigo_confirmacion_expiracion' => $codigo_expiracion
            );
    
            $this->Usuario_model->insert_usuario($data);
    
            // Configuración del correo
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
            $this->email->subject('Código de Confirmación');
            
            $base_url = $this->config->item('base_url');
            $link = $base_url . 'auth/confirmar?email=' . urlencode($this->input->post('email')) . '&codigo=' . $codigo_confirmacion;
    
            $this->email->message('Tu código de confirmación es: ' . $codigo_confirmacion . '. Puedes ingresar el código en el siguiente enlace: <a href="' . $link . '">Confirmar cuenta</a>. Este código expira en 24 horas.');
    
            if ($this->email->send()) {
                $this->session->set_flashdata('success', 'Tu cuenta ha sido creada. Revisa tu correo electrónico para el código de confirmación.');
            } else {
                $this->session->set_flashdata('error', 'Tu cuenta ha sido creada, pero no se pudo enviar el correo de confirmación.');
            }
    
            redirect('auth/confirmar');
        }
    }
    
    public function confirmar() {
        $this->load->view('auth/confirmar');
    }
    
    public function confirmar_action() {
        $codigo = $this->input->post('codigo_confirmacion') ? $this->input->post('codigo_confirmacion') : $this->input->get('codigo');
        $email = $this->input->post('email') ? $this->input->post('email') : $this->input->get('email');
    
        $user = $this->Usuario_model->get_usuario_by_email($email);
    
        if ($user) {
            $current_time = date('Y-m-d H:i:s');
            if ($user->codigo_confirmacion_expiracion < $current_time) {
                $this->session->set_flashdata('error', 'El código de confirmación ha expirado.');
                redirect('auth/confirmar');
            } elseif ($user->codigo_confirmacion == $codigo) {
                $data = array(
                    'estado' => 'activo',
                    'codigo_confirmacion' => null,
                    'codigo_confirmacion_expiracion' => null
                );
                $this->Usuario_model->update_usuario($user->id, $data);
    
                $this->session->set_flashdata('success', 'Tu cuenta ha sido activada exitosamente.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'El código de confirmación es incorrecto.');
                redirect('auth/confirmar');
            }
        } else {
            $this->session->set_flashdata('error', 'Correo electrónico no encontrado.');
            redirect('auth/confirmar');
        }
    }
}
?>
