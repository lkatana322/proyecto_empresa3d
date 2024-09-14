<?php
class Categoria_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_categorias() {
        $this->db->select('c.*, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('categoria c');
        $this->db->join('usuario u', 'c.usuario_actualizacion_id = u.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }    

    // Insertar una nueva categoría
    public function insert_categoria($data) {
        if ($this->db->insert('categoria', $data)) {
            return $this->db->insert_id();
        } else {
            return false;  // En caso de error
        }
    }

    public function update_categoria($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categoria', $data);
    }
    
    public function get_categoria_by_id($id) {
        $this->db->select('c.*, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('categoria c');
        $this->db->join('usuario u', 'c.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    // Eliminar una categoría
    public function delete_categoria($id) {
        // Obtener la categoría antes de eliminarla para acceder a la ruta de la imagen
        $this->db->where('id', $id);
        $categoria = $this->db->get('categoria')->row();
    
        if ($categoria) {
            // Verificar si la categoría tiene una imagen
            if (!empty($categoria->imagen)) {
                $imagen_path = $categoria->imagen;
                // Verificar si el archivo de imagen existe en el servidor
                if (file_exists($imagen_path)) {
                    unlink($imagen_path);  // Eliminar la imagen del servidor
                }
            }
    
            // Proceder a eliminar la categoría de la base de datos
            $this->db->where('id', $id);
            return $this->db->delete('categoria');
        } else {
            return false;  // Retornar false si la categoría no existe
        }
    }
    
    // Verificar si la categoría tiene productos asociados
    public function has_products($categoria_id) {
        $this->db->from('producto');
        $this->db->where('categoria_id', $categoria_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_categorias_con_conteo_productos() {
        $this->db->select('c.*, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido, SUM(p.stock) as total_productos');
        $this->db->from('categoria c');
        $this->db->join('producto p', 'p.categoria_id = c.id AND p.estado = "activo"', 'left');  // Solo suma stock de productos activos
        $this->db->join('usuario u', 'c.usuario_actualizacion_id = u.id', 'left');
        $this->db->group_by('c.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_categorias_by_estado($estado) {
        $this->db->select('c.*, u.nombre as actualizador_nombre, u.apellido as actualizador_apellido');
        $this->db->from('categoria c');
        $this->db->join('usuario u', 'c.usuario_actualizacion_id = u.id', 'left');
        $this->db->where('c.estado', $estado);  // Filtra por estado (activo o inactivo)
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_categorias_activas_con_conteo_productos() {
        $this->db->select('c.*, SUM(p.stock) as total_productos');
        $this->db->from('categoria c');
        $this->db->join('producto p', 'p.categoria_id = c.id AND p.estado = "activo"', 'left');
        $this->db->where('c.estado', 'activo');
        $this->db->group_by('c.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_categoria_by_producto($producto_id) {
        $this->db->select('c.nombre');
        $this->db->from('categoria c');
        $this->db->join('producto p', 'c.id = p.categoria_id');
        $this->db->where('p.id', $producto_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;  // En caso de que no se encuentre la categoría
        }
    }

}
?>
