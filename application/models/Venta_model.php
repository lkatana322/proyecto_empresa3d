<?php
class Venta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_ventas() {
        $this->db->select('v.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido, u.nombre as usuario_nombre, u.apellido as usuario_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario c', 'v.cliente_id = c.id', 'left');
        $this->db->join('usuario u', 'v.usuario_id = u.id', 'left');
        $ventas = $this->db->get()->result();
        
        foreach ($ventas as &$venta) {
            // Obtener los productos asociados a cada venta
            $this->db->select('dp.*, p.nombre as producto_nombre');
            $this->db->from('detalle_venta dp');
            $this->db->join('producto p', 'dp.producto_id = p.id');
            $this->db->where('dp.venta_id', $venta->id);
            $venta->productos = $this->db->get()->result();
        }
    
        return $ventas;
    }    

    public function insert_venta($data) {
        $this->db->insert('venta', $data);
        return $this->db->insert_id();
    }

    public function get_venta_by_id($id) {
        $this->db->select('v.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido, u.nombre as usuario_nombre, u.apellido as usuario_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario c', 'v.cliente_id = c.id', 'left');
        $this->db->join('usuario u', 'v.usuario_id = u.id', 'left');
        $this->db->where('v.id', $id);
        $venta = $this->db->get()->row();
    
        // Asegúrate de que la propiedad 'detalles' siempre esté definida
        $venta->detalles = array(); // Inicializa la propiedad 'detalles' como un array vacío
    
        // Obtener los detalles de los productos de la venta
        $this->db->select('dp.*, p.nombre as producto_nombre');
        $this->db->from('detalle_venta dp');
        $this->db->join('producto p', 'dp.producto_id = p.id');
        $this->db->where('dp.venta_id', $id);
        $detalles = $this->db->get()->result();
    
        if (!empty($detalles)) {
            $venta->detalles = $detalles; // Asigna los detalles si existen
        }
    
        return $venta;
    }    

    public function update_venta($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('venta', $data);
    }

    public function delete_venta($id) {
        $this->db->delete('venta', array('id' => $id));
    }

    public function insert_detalle_venta($data) {
        $this->db->insert('detalle_venta', $data);
    }

    public function delete_detalles_by_venta($venta_id) {
        $this->db->delete('detalle_venta', array('venta_id' => $venta_id));
    }

    public function get_venta_detalles_by_id($id) {
        $this->db->select('v.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido, u.nombre as usuario_nombre, u.apellido as usuario_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario c', 'v.cliente_id = c.id', 'left');
        $this->db->join('usuario u', 'v.usuario_id = u.id', 'left');
        $this->db->where('v.id', $id);
        $venta = $this->db->get()->row();

        // Obtener los detalles de los productos de la venta
        $this->db->select('dp.*, p.nombre as producto_nombre');
        $this->db->from('detalle_venta dp');
        $this->db->join('producto p', 'dp.producto_id = p.id');
        $this->db->where('dp.venta_id', $id);
        $venta->detalles = $this->db->get()->result();

        return $venta;
    }

    public function get_ventas_by_estado($estado) {
        $this->db->select('v.*, u1.nombre as cliente_nombre, u1.apellido as cliente_apellido, u2.nombre as usuario_nombre, u2.apellido as usuario_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario u1', 'v.cliente_id = u1.id', 'left'); // Cliente
        $this->db->join('usuario u2', 'v.usuario_id = u2.id', 'left'); // Vendedor (admin o empleado)
        $this->db->where('v.estado', $estado);
        $query = $this->db->get();
        return $query->result();
    }      

    public function get_ventas_pendientes() {
        $this->db->select('v.*, u1.nombre as cliente_nombre, u1.apellido as cliente_apellido, u2.nombre as vendedor_nombre, u2.apellido as vendedor_apellido');
        $this->db->from('venta v');
        $this->db->join('usuario u1', 'v.cliente_id = u1.id', 'left'); // Cliente
        $this->db->join('usuario u2', 'v.usuario_id = u2.id', 'left'); // Vendedor (admin o empleado)
        $this->db->where('v.estado', 'pendiente');
        $query = $this->db->get();
        return $query->result();
    }    
    
    public function get_top_selling_products($limit = 5) {
        $this->db->select('p.nombre as producto_nombre, p.precio, SUM(dv.cantidad) as cantidad_vendida, SUM(dv.cantidad * dv.precio_unitario) as ingresos, p.imagen');
        $this->db->from('detalle_venta dv');
        $this->db->join('producto p', 'dv.producto_id = p.id', 'left');
        $this->db->group_by('dv.producto_id'); // Agrupa por producto
        $this->db->order_by('cantidad_vendida', 'DESC'); // Ordena por la cantidad vendida en orden descendente
        $this->db->limit($limit); // Limita el resultado a la cantidad de productos más vendidos que deseas mostrar
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_ventas_count_by_period($period) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('venta');
    
        if ($period == 'hoy') {
            $this->db->where('DATE(fecha_venta) = CURDATE()', NULL, FALSE);
        } elseif ($period == 'este_mes') {
            $this->db->where('MONTH(fecha_venta) = MONTH(CURDATE())', NULL, FALSE);
            $this->db->where('YEAR(fecha_venta) = YEAR(CURDATE())', NULL, FALSE);
        } elseif ($period == 'este_año') {
            $this->db->where('YEAR(fecha_venta) = YEAR(CURDATE())', NULL, FALSE);
        }
    
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function get_ingresos_by_period($period) {
        $this->db->select('SUM(total) as total_ingresos');
        $this->db->from('venta');
    
        if ($period == 'hoy') {
            $this->db->where('DATE(fecha_venta) = CURDATE()', NULL, FALSE);
        } elseif ($period == 'este_mes') {
            $this->db->where('MONTH(fecha_venta) = MONTH(CURDATE())', NULL, FALSE);
            $this->db->where('YEAR(fecha_venta) = YEAR(CURDATE())', NULL, FALSE);
        } elseif ($period == 'este_año') {
            $this->db->where('YEAR(fecha_venta) = YEAR(CURDATE())', NULL, FALSE);
        }
    
        $query = $this->db->get();
        return $query->row()->total_ingresos;
    }

    public function get_ingresos_percentage_by_period($period) {
        $current_total = $this->get_ingresos_by_period($period);

        if ($period == 'hoy') {
            $previous_period = 'ayer';
        } elseif ($period == 'este_mes') {
            $previous_period = 'el_mes_pasado';
        } elseif ($period == 'este_año') {
            $previous_period = 'el_año_pasado';
        }

        $previous_total = $this->get_ingresos_by_period($previous_period);

        if ($previous_total > 0) {
            $percentage = (($current_total - $previous_total) / $previous_total) * 100;
        } else {
            $percentage = ($current_total > 0) ? 100 : 0;
        }

        return round($percentage);
    }

    public function get_ventas_percentage_by_period($period) {
        $current_total = $this->get_ventas_count_by_period($period);

        if ($period == 'hoy') {
            $previous_period = 'ayer';
        } elseif ($period == 'este_mes') {
            $previous_period = 'el_mes_pasado';
        } elseif ($period == 'este_año') {
            $previous_period = 'el_año_pasado';
        }

        $previous_total = $this->get_ventas_count_by_period($previous_period);

        if ($previous_total > 0) {
            $percentage = (($current_total - $previous_total) / $previous_total) * 100;
        } else {
            $percentage = ($current_total > 0) ? 100 : 0;
        }

        return round($percentage);
    }

    public function tiene_ventas_asociadas($producto_id) {
        $this->db->from('detalle_venta');
        $this->db->where('producto_id', $producto_id);
        $query = $this->db->get();
    
        return $query->num_rows() > 0;
    }
    
    public function delete_detalles_by_producto($producto_id) {
        $this->db->where('producto_id', $producto_id);
        $this->db->delete('detalle_venta');
    }
    
    public function cliente_tiene_ventas($cliente_id) {
        $this->db->from('venta');
        $this->db->where('cliente_id', $cliente_id);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
    
}
?>
