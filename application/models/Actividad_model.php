<?php
class Actividad_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Método para registrar una actividad
    public function registrar_actividad($usuario_id, $accion, $descripcion) {
        $data = array(
            'usuario_id' => $usuario_id,
            'accion' => $accion,
            'descripcion' => $descripcion,
            'fecha_hora' => date('Y-m-d H:i:s')
        );
        $this->db->insert('actividades', $data);
    }

    // Método para obtener las actividades recientes
    public function obtener_actividades_recientes($limite = 7) {
        $this->db->select('a.*, u.nombre as usuario_nombre, u.apellido as usuario_apellido');
        $this->db->from('actividades a');
        $this->db->join('usuarios u', 'a.usuario_id = u.id');
        $this->db->order_by('a.fecha_hora', 'DESC');
        $this->db->limit($limite);
        $query = $this->db->get();
        return $query->result();
    }

}
