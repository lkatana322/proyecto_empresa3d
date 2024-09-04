<?php
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_login();
        $this->check_permissions();
    }

    protected function check_login() {
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            redirect('auth/login');
        }
    }

    protected function check_permissions() {
        $user_role = $this->session->userdata('rol_id');
        if ($user_role == 3) { // Cliente
            $this->session->set_flashdata('error', 'No tienes permiso para acceder a esta página.');
            redirect('cliente/home'); // Redirige a la página de inicio del cliente
        }
    }
}
?>
