<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Middleware {

    public function check_auth() {
        $CI =& get_instance();
        $controller = $CI->router->class;
        $method = $CI->router->method;

        // Lista de controladores y métodos que no requieren autenticación
        $public_routes = [
            'auth' => ['login', 'register', 'login_action', 'register_action']
        ];

        if (!isset($public_routes[$controller]) || !in_array($method, $public_routes[$controller])) {
            if (!$CI->session->userdata('user_id')) {
                redirect('auth/login');
            }
        }
    }
}
