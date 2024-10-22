<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->model('Venta_model'); // Asegúrate de cargar el modelo de ventas aquí
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
        $data['usuarios'] = $this->Usuario_model->get_usuarios_by_estado('activo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/usuarios', $data);
        $this->load->view('admin/template/footer');
    }

    public function inactivos() {
        $data['usuarios'] = $this->Usuario_model->get_usuarios_by_estado('inactivo');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/inactivos', $data);
        $this->load->view('admin/template/footer');
    }

    public function agregar() {
        $this->check_permissions();

        if ($this->session->userdata('rol') == 'empleado') {
            $this->session->set_flashdata('error', 'No tienes permiso para realizar esta acción.');
            redirect('usuarios');
        }

        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/agregar_usuario');
        $this->load->view('admin/template/footer');
    }

    public function guardar() {
        $this->check_permissions();

        // Comienza la transacción
        $this->db->trans_start();

        // Validaciones y verificación del rol
        $this->form_validation->set_rules('nombre_usuario', 'Nombre', 'required|alpha');
        $this->form_validation->set_rules('apellido_usuario', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('segundo_apellido_usuario', 'Segundo Apellido', 'alpha');
        $this->form_validation->set_rules('email_usuario', 'Correo Electrónico', 'required|valid_email');
        $this->form_validation->set_rules('rol_usuario', 'Rol', 'required');
        $this->form_validation->set_rules('estado_usuario', 'Estado', 'required');
        
        $rol = $this->input->post('rol_usuario');

        if (!in_array($rol, ['admin', 'empleado', 'cliente'])) {
            $this->session->set_flashdata('error', 'Rol inválido seleccionado.');
            $this->agregar();
            return;
        }

        if ($rol == 'admin' || $rol == 'empleado') {
            $this->form_validation->set_rules('telefono_usuario', 'Teléfono', 'required|regex_match[/^[0-9]{8,10}$/]');
            $this->form_validation->set_rules('direccion_usuario', 'Dirección', 'required');
        } else {
            $this->form_validation->set_rules('telefono_usuario', 'Teléfono', 'regex_match[/^[0-9]{8,10}$/]');
            $this->form_validation->set_rules('direccion_usuario', 'Dirección');
        }
        
        if ($this->form_validation->run() == FALSE) {
            $this->agregar();
        } else {
            // Verificar si el correo ya existe
            $email = $this->input->post('email_usuario');
            if ($this->Usuario_model->email_exists($email)) {
                $this->session->set_flashdata('error', 'El correo electrónico ya está registrado.');
                $this->agregar();
                return;
            }

            // Continuar con la inserción si no existe el correo
            $password = $this->generate_random_password();
            $data_usuario = array(
                'nombre' => strtoupper($this->input->post('nombre_usuario')),
                'apellido' => strtoupper($this->input->post('apellido_usuario')),
                'segundo_apellido' => strtoupper($this->input->post('segundo_apellido_usuario')),
                'fecha_nacimiento' => $this->input->post('fecha_nacimiento_usuario'),
                'email' => $this->input->post('email_usuario'),
                'contraseña' => password_hash($password, PASSWORD_DEFAULT),
                'rol' => $rol, // Cambiado a `rol`
                'telefono' => $this->input->post('telefono_usuario') ?: null,
                'direccion' => $this->input->post('direccion_usuario') ?: null,
                'fecha_contratacion' => $this->input->post('fecha_contratacion_usuario'),
                'estado' => $this->input->post('estado_usuario')
            );            

            $usuario_id = $this->Usuario_model->insert_usuario($data_usuario);

            // Configuración para enviar correo
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_user' => 'alvarez.brandon.13353@gmail.com',
                'smtp_pass' => 'zklx pgpn mlwm drgj',
                'smtp_port' => 465,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'newline' => "\r\n"
            );

            $this->load->library('email', $config);
            $this->email->initialize($config);

            $this->email->from('alvarez.brandon.13353@gmail.com', '3D Print Shop');
            $this->email->to($email);
            $this->email->subject('Tu nueva cuenta en 3D Print Shop');
            $this->email->message('Tu cuenta ha sido creada. Tu contraseña es: ' . $password);

            // Intentar enviar el correo
            if (!$this->email->send()) {
                // Si el correo no se puede enviar, se hace rollback
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'No se pudo registrar el usuario porque el correo no pudo ser enviado.');
                redirect('usuarios/agregar');
                return;
            }

            // Si todo es exitoso, completa la transacción
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'No se pudo completar la operación.');
            } else {
                $this->session->set_flashdata('success', 'Usuario registrado con éxito y correo enviado.');
            }

            redirect('usuarios');
        }
    }

    public function editar($id) {
        $this->check_permissions();

        if ($this->session->userdata('rol_id') == 2) {
            $this->session->set_flashdata('error', 'No tienes permiso para realizar esta acción.');
            redirect('usuarios');
        }

        $data['usuario'] = $this->Usuario_model->get_usuario_by_id($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/editar_usuario', $data);
        $this->load->view('admin/template/footer');
    }

    public function actualizar() {
        $this->check_permissions();

        if ($this->session->userdata('rol_id') == 2) {
            $this->session->set_flashdata('error', 'No tienes permiso para realizar esta acción.');
            redirect('usuarios');
        }

        $id = $this->input->post('id');
        $usuario_anterior = $this->Usuario_model->get_usuario_by_id($id);

        // Comienza la transacción
        $this->db->trans_start();

        // Reglas de validación para los campos
        $this->form_validation->set_rules('nombre_usuario', 'Nombre', 'required|alpha');
        $this->form_validation->set_rules('apellido_usuario', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('segundo_apellido_usuario', 'Segundo Apellido', 'alpha');
        $this->form_validation->set_rules('edad_usuario', 'Edad', 'numeric');
        $this->form_validation->set_rules('email_usuario', 'Correo Electrónico', 'required|valid_email');
        $this->form_validation->set_rules('rol_usuario', 'Rol', 'required');
        $this->form_validation->set_rules('estado_usuario', 'Estado', 'required');
        
        $rol_id = $this->input->post('rol_usuario');

        if ($rol_id == 1 || $rol_id == 2) { // Admin o empleado
            $this->form_validation->set_rules('telefono_usuario', 'Teléfono', 'required|regex_match[/^[0-9]{8,10}$/]');
            $this->form_validation->set_rules('direccion_usuario', 'Dirección', 'required');
        } else {
            $this->form_validation->set_rules('telefono_usuario', 'Teléfono', 'regex_match[/^[0-9]{8,10}$/]');
            $this->form_validation->set_rules('direccion_usuario', 'Dirección');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->editar($id);
        } else {
            $data_usuario = array(
                'nombre' => strtoupper($this->input->post('nombre_usuario')),
                'apellido' => strtoupper($this->input->post('apellido_usuario')),
                'segundo_apellido' => strtoupper($this->input->post('segundo_apellido_usuario')),
                'fecha_nacimiento' => $this->input->post('fecha_nacimiento_usuario'), // Asegúrate de que esto esté presente
                'email' => $this->input->post('email_usuario'),
                'rol' => $this->input->post('rol_usuario'),
                'telefono' => $this->input->post('telefono_usuario'),
                'direccion' => $this->input->post('direccion_usuario'),
                'fecha_contratacion' => $this->input->post('fecha_contratacion_usuario'),
                'estado' => $this->input->post('estado_usuario'),
                'usuario_actualizacion_id' => $this->session->userdata('user_id')
            );                     

            if ($usuario_anterior->email != $this->input->post('email_usuario')) {
                $new_password = $this->generate_random_password();
                $data_usuario['contraseña'] = password_hash($new_password, PASSWORD_DEFAULT);

                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_user' => 'alvarez.brandon.13353@gmail.com',
                    'smtp_pass' => 'zklx pgpn mlwm drgj',
                    'smtp_port' => 465,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'newline' => "\r\n"
                );

                $this->load->library('email', $config);
                $this->email->initialize($config);

                $this->email->from('alvarez.brandon.13353@gmail.com', '3D Print Shop');
                $this->email->to($this->input->post('email_usuario'));
                $this->email->subject('Confirmación de Actualización y Nueva Contraseña');
                $this->email->message('Tu información ha sido actualizada exitosamente. Tu nueva contraseña es: ' . $new_password);

                if (!$this->email->send()) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', 'No se pudo actualizar el usuario porque el correo no pudo ser enviado.');
                    redirect('usuarios/editar/' . $id);
                    return;
                }
            }

            $this->Usuario_model->update_usuario($id, $data_usuario);

            // Completa la transacción
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'No se pudo completar la operación.');
            } else {
                $this->session->set_flashdata('success', 'Usuario actualizado con éxito.');
            }

            redirect('usuarios');
        }
    }

    public function eliminar($id) {
        $this->check_permissions();

        if ($this->session->userdata('rol_id') == 2) {
            $this->session->set_flashdata('error', 'No tienes permiso para realizar esta acción.');
            redirect('usuarios');
        }

        // Comprobar si el usuario es un cliente y si tiene ventas asociadas
        $cliente_tiene_ventas = $this->Venta_model->cliente_tiene_ventas($id);

        if ($cliente_tiene_ventas) {
            $this->session->set_flashdata('error', 'No se puede eliminar este cliente porque tiene ventas asociadas.');
            redirect('usuarios');
            return;
        }

        // Comienza la transacción
        $this->db->trans_start();

        $this->Usuario_model->delete_usuario($id);

        // Completa la transacción
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'No se pudo eliminar el usuario.');
        } else {
            $this->session->set_flashdata('success', 'Usuario eliminado con éxito.');
        }

        redirect('usuarios');
    }

    public function ver($id) {
        $this->check_permissions();
        $data['usuario'] = $this->Usuario_model->get_usuario_by_id($id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/ver_usuario', $data);
        $this->load->view('admin/template/footer');
    }

    public function ver_ajax($id) {
        $this->check_permissions();
        $this->db->select('u.*, ua.nombre as actualizador_nombre, ua.apellido as actualizador_apellido');
        $this->db->from('usuario u');
        $this->db->join('usuario ua', 'u.usuario_actualizacion_id = ua.id', 'left');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
        echo json_encode($query->row());
    }

    private function generate_random_password($length = 10) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    public function empleados() {
        $this->check_permissions();
        $data['empleados'] = $this->Usuario_model->get_usuarios_by_rol_activos('empleado'); 
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/empleados', $data);
        $this->load->view('admin/template/footer');
    }

    public function clientes() {
        $this->check_permissions();
        $data['clientes'] = $this->Usuario_model->get_usuarios_by_rol_activos('cliente'); 
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/clientes', $data);
        $this->load->view('admin/template/footer');
    }

    public function empleados_inactivos() {
        $this->check_permissions();
        $data['empleados'] = $this->Usuario_model->get_usuarios_by_estado_y_rol('inactivo', 'empleado'); 
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/empleados_inactivos', $data);
        $this->load->view('admin/template/footer');
    }

    public function clientes_inactivos() {
        $this->check_permissions();
        $data['clientes'] = $this->Usuario_model->get_usuarios_by_estado_y_rol('inactivo', 'cliente'); 
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/usuario/clientes_inactivos', $data);
        $this->load->view('admin/template/footer');
    }

    public function buscar_cliente_ajax() {
        $this->load->model('Usuario_model');
        $query = $this->input->get('query'); // Obtener el término de búsqueda

        $clientes = $this->Usuario_model->buscar_clientes($query); // Llamar al método en el modelo

        // Crear un array solo con los nombres y apellidos
        $resultados = [];
        foreach ($clientes as $cliente) {
            $resultados[] = [
                'label' => $cliente->nombre . ' ' . $cliente->apellido, // Nombre completo para el autocompletado
                'value' => $cliente->id // ID del cliente para el valor del input
            ];
        }

        echo json_encode($resultados); // Retornar los resultados en formato JSON
    }

    public function guardar_cliente_ajax() {
        $this->form_validation->set_rules('nombre_cliente', 'Nombre', 'required|alpha');
        $this->form_validation->set_rules('apellido_cliente', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('email_cliente', 'Correo Electrónico', 'required|valid_email');
    
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
        } else {
            // Verificar si el correo ya existe
            $email = $this->input->post('email_cliente');
            if ($this->Usuario_model->email_exists($email)) {
                echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado.']);
                return;
            }
    
            // Generar contraseña aleatoria
            $password = $this->generate_random_password();
    
            // Preparar datos del cliente
            $data_cliente = array(
                'nombre' => strtoupper($this->input->post('nombre_cliente')),
                'apellido' => strtoupper($this->input->post('apellido_cliente')),
                'email' => $email,
                'telefono' => $this->input->post('telefono_cliente') ?: null,
                'direccion' => $this->input->post('direccion_cliente') ?: null,
                'rol' => 'cliente',
                'estado' => 'activo',
                'contraseña' => password_hash($password, PASSWORD_DEFAULT)
            );
    
            // Comenzar la transacción
            $this->db->trans_start();
    
            // Insertar cliente
            $cliente_id = $this->Usuario_model->insert_cliente($data_cliente);
    
            if ($cliente_id) {
                // Configuración para enviar correo
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_user' => 'alvarez.brandon.13353@gmail.com',
                    'smtp_pass' => 'zklx pgpn mlwm drgj',
                    'smtp_port' => 465,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'newline' => "\r\n"
                );
    
                $this->load->library('email', $config);
                $this->email->initialize($config);
    
                $this->email->from('alvarez.brandon.13353@gmail.com', '3D Print Shop');
                $this->email->to($email);
                $this->email->subject('Tu nueva cuenta en 3D Print Shop');
                $this->email->message('Tu cuenta ha sido creada. Tu contraseña es: ' . $password);
    
                // Intentar enviar el correo
                if (!$this->email->send()) {
                    $this->db->trans_rollback();
                    echo json_encode(['success' => false, 'message' => 'Error al registrar el cliente. El correo no pudo ser enviado.']);
                    return;
                }
    
                // Completar la transacción
                $this->db->trans_complete();
    
                if ($this->db->trans_status() === FALSE) {
                    echo json_encode(['success' => false, 'message' => 'Error al insertar el cliente.']);
                } else {
                    // Mensaje de éxito en flashdata
                    $this->session->set_flashdata('success', 'Cliente registrado con éxito y correo enviado.');
                    echo json_encode(['success' => true, 'redirect' => site_url('usuarios')]); // Redirigir a la lista de usuarios
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al insertar el cliente.']);
            }
        }
    }    
    
}
?>
