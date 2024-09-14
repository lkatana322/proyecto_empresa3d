<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Usuario_model'); // Para obtener la lista de clientes y empleados
        $this->load->model('Producto_model'); // Para obtener la lista de productos
        $this->load->model('Categoria_model'); // Cargar el modelo de categorías
        $this->load->model('Actividad_model'); // Cargar el modelo de actividades
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
        $data['ventas'] = $this->Venta_model->get_all_ventas();
        $data['top_selling_products'] = $this->Venta_model->get_top_selling_products(10); // O la cantidad que desees mostrar
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/venta/ventas', $data);
        $this->load->view('admin/template/footer');
    }

    public function agregar() {
        $this->check_permissions();
        $data['clientes'] = $this->Usuario_model->get_all_clientes();
        $data['empleados'] = $this->Usuario_model->get_all_empleados();
        $data['productos'] = $this->Producto_model->get_productos_by_estado('activo'); 
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $data['usuario_logueado'] = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido');
        $data['rol_usuario_logueado'] = $this->session->userdata('rol');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/venta/agregar_venta', $data);
        $this->load->view('admin/template/footer');
    }

    public function guardar() {
        $this->check_permissions();
    
        // Validación básica
        $this->form_validation->set_rules('cliente_id', 'Cliente', 'required');
        $this->form_validation->set_rules('usuario_id', 'Empleado', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->agregar();  // Si la validación falla, muestra el formulario nuevamente
        } else {
            // Inicia la transacción
            $this->db->trans_begin();
    
            try {
                $cliente_id = $this->input->post('cliente_id');
                $data_venta = array(
                    'cliente_id' => !empty($cliente_id) ? $cliente_id : NULL,  // Manejo de cliente opcional
                    'usuario_id' => $this->input->post('usuario_id'),
                    'total' => 0,  // Inicialmente el total será 0, lo actualizamos luego
                    'estado' => $this->input->post('estado_venta'),
                    'usuario_actualizacion_id' => $this->session->userdata('user_id')
                );
    
                // Inserta la venta en la base de datos
                $venta_id = $this->Venta_model->insert_venta($data_venta);
    
                // Variables necesarias para calcular el total de la venta
                $productos = $this->input->post('producto_id');
                $cantidades = $this->input->post('cantidad');
                $precios_unitarios = $this->input->post('precio_unitario');
                $total_venta = 0;
                $descripcion_detalles = '';
    
                // Procesar cada producto seleccionado
                for ($i = 0; $i < count($productos); $i++) {
                    $producto = $this->Producto_model->get_producto_by_id($productos[$i]);
    
                    // Validación: Verificar si el producto está activo
                    if ($producto->estado != 'activo') {
                        throw new Exception('El producto "' . $producto->nombre . '" no está activo y no se puede vender.');
                    }
    
                    // Validación: Verificar si hay stock suficiente
                    if ($producto->stock < $cantidades[$i]) {
                        throw new Exception('La cantidad solicitada para el producto "' . $producto->nombre . '" excede el stock disponible.');
                    }
    
                    // Calcular el subtotal para ese producto
                    $subtotal = $cantidades[$i] * $precios_unitarios[$i];
                    $total_venta += $subtotal;
    
                    // Insertar los detalles de la venta
                    $detalle_venta = array(
                        'venta_id' => $venta_id,
                        'producto_id' => $productos[$i],
                        'cantidad' => $cantidades[$i],
                        'precio_unitario' => $precios_unitarios[$i],
                    );
                    $this->Venta_model->insert_detalle_venta($detalle_venta);
    
                    // Actualizar el stock del producto
                    $nuevo_stock = $producto->stock - $cantidades[$i];
                    $this->Producto_model->update_stock($productos[$i], $nuevo_stock);
    
                    // Construir la descripción para la actividad
                    $descripcion_detalles .= $producto->nombre . " (" . $cantidades[$i] . " x $" . $precios_unitarios[$i] . ") ";
                }
    
                // Actualizar el total de la venta
                $this->Venta_model->update_venta($venta_id, array('total' => $total_venta));
    
                // Si la transacción ha fallado, lanzar una excepción
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Error al realizar la transacción.');
                }
    
                // Confirmar la transacción
                $this->db->trans_commit();
    
                // Registrar la actividad
                $descripcion = 'Productos: ' . $descripcion_detalles . ' - Total: $' . $total_venta;
                $this->Actividad_model->registrar_actividad(
                    $this->session->userdata('user_id'),
                    'agregar_venta',
                    $descripcion
                );
    
                // Mostrar mensaje de éxito y redirigir
                $this->session->set_flashdata('success', 'Venta agregada con éxito.');
                redirect('ventas');
            } catch (Exception $e) {
                // En caso de error, se revierte la transacción
                $this->db->trans_rollback();
                // Mostrar el mensaje de error
                $this->session->set_flashdata('error', $e->getMessage());
                redirect('ventas/agregar');
            }
        }
    }
    
    public function editar($id) {
        $this->check_permissions();
        $data['venta'] = $this->Venta_model->get_venta_by_id($id);
        $data['clientes'] = $this->Usuario_model->get_all_clientes();
        $data['empleados'] = $this->Usuario_model->get_all_empleados();
        $data['productos'] = $this->Producto_model->get_productos_by_estado('activo'); 
        $data['categorias'] = $this->Categoria_model->get_categorias_by_estado('activo');
        $data['usuario_logueado'] = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido');
        $data['rol_usuario_logueado'] = $this->session->userdata('rol');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/venta/editar_venta', $data);
        $this->load->view('admin/template/footer');
    }

    public function actualizar() {
        $this->check_permissions();
        $id = $this->input->post('id');
    
        // Validación básica
        $this->form_validation->set_rules('cliente_id', 'Cliente', 'required');
        $this->form_validation->set_rules('usuario_id', 'Empleado', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->editar($id);
        } else {
            // Inicia la transacción
            $this->db->trans_begin();
    
            try {
                $venta_actual = $this->Venta_model->get_venta_by_id($id);
    
                $cliente_id = $this->input->post('cliente_id');
                $data_venta = array(
                    'cliente_id' => !empty($cliente_id) ? $cliente_id : NULL,
                    'usuario_id' => $this->input->post('usuario_id'),
                    'estado' => $this->input->post('estado_venta'),
                    'usuario_actualizacion_id' => $this->session->userdata('user_id')
                );
    
                // Actualizar la venta en la base de datos
                $this->Venta_model->update_venta($id, $data_venta);
    
                // Restablecer el stock de los productos en la venta original
                foreach ($venta_actual->detalles as $detalle) {
                    $producto = $this->Producto_model->get_producto_by_id($detalle->producto_id);
                    $nuevo_stock = $producto->stock + $detalle->cantidad;
                    $this->Producto_model->update_stock($detalle->producto_id, $nuevo_stock); // Devolver el stock
                }
    
                // Eliminar los detalles antiguos
                $this->Venta_model->delete_detalles_by_venta($id);
    
                // Validar y procesar nuevos productos
                $productos = $this->input->post('producto_id');
                $cantidades = $this->input->post('cantidad');
                $precios_unitarios = $this->input->post('precio_unitario');
                $total_venta = 0;
                $descripcion_detalles = '';
    
                for ($i = 0; $i < count($productos); $i++) {
                    $producto = $this->Producto_model->get_producto_by_id($productos[$i]);
    
                    // Validar si el producto está activo
                    if ($producto->estado != 'activo') {
                        throw new Exception('El producto "' . $producto->nombre . '" no está activo y no se puede vender.');
                    }
    
                    // Validar si hay suficiente stock
                    if ($producto->stock < $cantidades[$i]) {
                        throw new Exception('La cantidad solicitada para el producto "' . $producto->nombre . '" excede el stock disponible.');
                    }
    
                    $subtotal = $cantidades[$i] * $precios_unitarios[$i];
                    $total_venta += $subtotal;
    
                    // Insertar los nuevos detalles de la venta
                    $detalle_venta = array(
                        'venta_id' => $id,
                        'producto_id' => $productos[$i],
                        'cantidad' => $cantidades[$i],
                        'precio_unitario' => $precios_unitarios[$i],
                    );
                    $this->Venta_model->insert_detalle_venta($detalle_venta);
    
                    // Actualizar el stock del producto
                    $nuevo_stock = $producto->stock - $cantidades[$i];
                    $this->Producto_model->update_stock($productos[$i], $nuevo_stock);
    
                    // Construir la descripción para la actividad
                    $descripcion_detalles .= $producto->nombre . " (" . $cantidades[$i] . " x $" . $precios_unitarios[$i] . ") ";
                }
    
                // Actualizar el total de la venta
                $this->Venta_model->update_venta($id, array('total' => $total_venta));
    
                // Si la transacción falla, lanzar una excepción
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Error al realizar la transacción.');
                }
    
                // Confirmar la transacción
                $this->db->trans_commit();
    
                // Registrar la actividad
                $descripcion = 'Productos: ' . $descripcion_detalles . ' - Total: $' . $total_venta;
                $this->Actividad_model->registrar_actividad(
                    $this->session->userdata('user_id'),
                    'actualizar_venta',
                    $descripcion
                );
    
                // Mostrar mensaje de éxito y redirigir
                $this->session->set_flashdata('success', 'Venta actualizada con éxito.');
                redirect('ventas');
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $e->getMessage());
                redirect('ventas/editar/' . $id);
            }
        }
    }
    
    public function eliminar($id) {
        $this->check_permissions();
    
        $this->Venta_model->delete_detalles_by_venta($id);
        $this->Venta_model->delete_venta($id);
    
        // Registrar la actividad
        $this->Actividad_model->registrar_actividad(
            $this->session->userdata('user_id'),
            'eliminar_venta',
            'Venta eliminada'
        );
    
        $this->session->set_flashdata('success', 'Venta eliminada con éxito.');
        redirect('ventas');
    }
    
    public function ver_ajax($id) {
        $this->check_permissions();
        
        // Obtener los detalles generales de la venta
        $this->db->select('v.*, u1.nombre as cliente_nombre, u1.apellido as cliente_apellido, u2.nombre as empleado_nombre, u2.apellido as empleado_apellido, ua.nombre as actualizador_nombre, ua.apellido as actualizador_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario u1', 'v.cliente_id = u1.id', 'left'); // Cliente
        $this->db->join('usuario u2', 'v.usuario_id = u2.id', 'left'); // Vendedor (admin o empleado)
        $this->db->join('usuario ua', 'v.usuario_actualizacion_id = ua.id', 'left'); // Usuario que realizó la última actualización
        $this->db->where('v.id', $id);
        $venta = $this->db->get()->row();
        
        // Manejar caso de cliente no definido
        if (is_null($venta->cliente_id)) {
            $venta->cliente_nombre = 'Cliente no definido';
            $venta->cliente_apellido = '';
        }
        
        // Obtener los detalles de los productos en la venta
        $this->db->select('dv.*, p.nombre as producto_nombre');
        $this->db->from('detalle_venta dv');
        $this->db->join('producto p', 'dv.producto_id = p.id');
        $this->db->where('dv.venta_id', $id);
        $venta->detalles_productos = $this->db->get()->result();
        
        echo json_encode($venta);
    }     

    public function pendientes() {
        $this->check_permissions();
        $data['ventas'] = $this->Venta_model->get_ventas_by_estado('pendiente');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/venta/ventas_pendientes', $data);
        $this->load->view('admin/template/footer');
    }    
    
    public function filtrar_datos() {
        $filterOption = $this->input->post('filterOption');
        $cardType = $this->input->post('cardType');
    
        $data = array();
        
        switch ($cardType) {
            case 'ventas':
                $data['count'] = $this->Venta_model->get_ventas_count_by_period($filterOption);
                $data['percentage'] = $this->Venta_model->get_ventas_percentage_by_period($filterOption);
                break;
    
            case 'ingresos':
                $data['count'] = $this->Venta_model->get_ingresos_by_period($filterOption);
                $data['percentage'] = $this->Venta_model->get_ingresos_percentage_by_period($filterOption);
                break;
    
            case 'clientes':
                $data['count'] = $this->Usuario_model->get_clientes_count_by_period($filterOption);
                $data['percentage'] = $this->calcular_porcentaje_clientes($filterOption); // Aquí se calcula el porcentaje
                break;
    
            default:
                break;
        }
    
        echo json_encode($data);
    }
    
    private function calcular_porcentaje_clientes($filterOption) {
        // Implementa la lógica para calcular el porcentaje de variación de clientes
        // Puedes utilizar una lógica similar a la de ventas e ingresos
        // Devolviendo un valor de porcentaje adecuado para la tarjeta de clientes
    
        // Ejemplo básico:
        $current_total = $this->Usuario_model->get_clientes_count_by_period($filterOption);
    
        // Definir el periodo anterior para calcular la diferencia
        if ($filterOption == 'hoy') {
            $previous_total = $this->Usuario_model->get_clientes_count_by_period('ayer');
        } elseif ($filterOption == 'este_mes') {
            $previous_total = $this->Usuario_model->get_clientes_count_by_period('el_mes_pasado');
        } elseif ($filterOption == 'este_año') {
            $previous_total = $this->Usuario_model->get_clientes_count_by_period('el_año_pasado');
        } else {
            $previous_total = 0;
        }
    
        if ($previous_total > 0) {
            $percentage = (($current_total - $previous_total) / $previous_total) * 100;
        } else {
            $percentage = ($current_total > 0) ? 100 : 0;
        }
    
        return round($percentage);
    }
    
}
?>
