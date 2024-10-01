<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Método para obtener las ventas
    public function obtener_ventas($fecha_inicio = null, $fecha_fin = null, $cliente_id = null) {
        $this->db->select('*');
        $this->db->from('ventas');

        // Filtrar por fechas
        if ($fecha_inicio) {
            $this->db->where('fecha_venta >=', $fecha_inicio);
        }
        if ($fecha_fin) {
            $this->db->where('fecha_venta <=', $fecha_fin);
        }
        // Filtrar por cliente si se proporciona
        if ($cliente_id) {
            $this->db->where('cliente_id', $cliente_id);
        }

        return $this->db->get()->result();
    }

    // Método para obtener productos
    public function obtener_productos($nombre_producto = null) {
        $this->db->select('*');
        $this->db->from('productos');

        // Filtrar por nombre del producto si se proporciona
        if ($nombre_producto) {
            $this->db->like('nombre', $nombre_producto);
        }

        return $this->db->get()->result();
    }

    // Puedes agregar más métodos según necesites para otros reportes
}
