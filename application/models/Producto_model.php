<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_productos() {
        $this->db->select('p.*, c.nombre as categoria_nombre, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('producto p');
        $this->db->join('categoria c', 'p.categoria_id = c.id', 'left');
        $this->db->join('usuario u', 'p.usuario_actualizacion_id = u.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_producto($data) {
        $this->db->insert('producto', $data);
        return $this->db->insert_id();
    }

    public function get_producto_by_id($id) {
        $this->db->select('p.*, c.nombre as categoria_nombre, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('producto p');
        $this->db->join('categoria c', 'p.categoria_id = c.id', 'left');
        $this->db->join('usuario u', 'p.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_producto($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('producto', $data);
    }

    public function delete_producto($id) {
        // Obtener el producto antes de eliminarlo para acceder a la ruta de la imagen
        $this->db->where('id', $id);
        $producto = $this->db->get('producto')->row();
    
        if ($producto) {
            // Verificar si el producto tiene una imagen
            if (!empty($producto->imagen)) {
                $imagen_path = $producto->imagen;
                // Verificar si el archivo de imagen existe en el servidor
                if (file_exists($imagen_path)) {
                    unlink($imagen_path);  // Eliminar la imagen del servidor
                }
            }
    
            // Proceder a eliminar el producto de la base de datos
            $this->db->where('id', $id);
            return $this->db->delete('producto');
        } else {
            return false;  // Retornar false si el producto no existe
        }
    }    

    public function update_stock($producto_id, $nuevo_stock) {
        $this->db->where('id', $producto_id);
        $this->db->update('producto', array('stock' => $nuevo_stock));
    }
    
    public function get_productos_por_categoria($categoria_id) {
        $this->db->select('*');
        $this->db->from('producto');
        $this->db->where('categoria_id', $categoria_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_productos_activos_por_categoria($categoria_id) {
        $this->db->select('p.*, c.nombre as categoria_nombre');
        $this->db->from('producto p');
        $this->db->join('categoria c', 'p.categoria_id = c.id', 'left');
        $this->db->where('p.categoria_id', $categoria_id);
        $this->db->where('p.estado', 'activo'); // Asegura que solo se obtengan productos activos
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_productos_by_estado($estado) {
        $this->db->select('p.*, c.nombre as categoria_nombre, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('producto p');
        $this->db->join('categoria c', 'p.categoria_id = c.id', 'left');
        $this->db->join('usuario u', 'p.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('p.estado', $estado);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function buscar_producto($query)
    {
        $this->db->like('nombre', $query);
        return $this->db->get('producto')->result();
    }

}
?>
