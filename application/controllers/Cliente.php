<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->model('Categoria_model');
        $this->load->model('Categoria_model');
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $this->load->vars($data); // Hace que $categorias esté disponible en todas las vistas cargadas
    }

    public function cotizador3d() {
        $this->load->view('cliente/header');
        $this->load->view('cliente/navbar');
        $this->load->view('cliente/cotizador3d');
        $this->load->view('cliente/footer');
    }
    
    public function index() {
        $this->home();
    }
    
    public function home() {
        // Obtener solo las categorías activas con el conteo de productos activos
        $data['categorias'] = $this->Categoria_model->get_categorias_activas_con_conteo_productos();

        $this->load->view('cliente/header');
        $this->load->view('cliente/navbar');
        $this->load->view('cliente/home', $data);
        $this->load->view('cliente/footer');
    }

    public function productos() {
        $data['productos'] = $this->Producto_model->get_productos_by_estado('activo');
        $data['categorias'] = $this->Categoria_model->get_all_categorias();

        $this->load->view('cliente/header');
        $this->load->view('cliente/navbar');
        $this->load->view('cliente/productos', $data);
        $this->load->view('cliente/footer');
    }

    public function producto_detalle($id) {
        $producto = $this->Producto_model->get_producto_by_id($id);
    
        if (!$producto) {
            redirect('cliente/productos'); // Redirige si el producto no se encuentra
        }
    
        $data['producto'] = $producto;
        
        $this->load->view('cliente/header');
        $this->load->view('cliente/navbar');
        $this->load->view('cliente/producto_detalle', $data);
        $this->load->view('cliente/footer');
    }
    
    public function productos_por_categoria($categoria_id) {
        $data['categoria'] = $this->Categoria_model->get_categoria_by_id($categoria_id);
        $data['productos'] = $this->Producto_model->get_productos_activos_por_categoria($categoria_id); // Usar el método para obtener solo productos activos
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
    
        $this->load->view('cliente/header');
        $this->load->view('cliente/navbar');
        $this->load->view('cliente/categoria_producto', $data);
        $this->load->view('cliente/footer');
    }
}
?>
