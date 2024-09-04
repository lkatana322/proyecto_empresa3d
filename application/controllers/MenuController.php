<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuController extends CI_Controller {

    public function index() {
        $this->load->view('menu_view'); // Carga la vista que creaste
    }
}
