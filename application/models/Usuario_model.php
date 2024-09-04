<?php
class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_usuarios() {
        // Obteniendo todos los usuarios junto con el nombre del rol
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_usuario($data) {
        $this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    public function get_usuario_by_id($id) {
        $this->db->select('u.*, r.nombre as rol_nombre, r.id as rol_id, ua.nombre as actualizador_nombre, ua.apellido as actualizador_apellido');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id', 'left');
        $this->db->join('usuarios ua', 'u.usuario_actualizacion_id = ua.id', 'left');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
        
        $usuario = $query->row();
    
        // Si no hay imagen, dejar el campo vacío
        if (empty($usuario->imagen)) {
            $usuario->imagen = '';
        }
    
        return $usuario;
    }
    
    public function update_usuario($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('usuarios', $data);
    }

    public function delete_usuario($id) {
        $this->db->delete('usuarios', array('id' => $id));
    }

    public function get_usuario_by_email($email) {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id', 'left');
        $this->db->where('u.email', $email);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_usuarios_by_estado($estado) {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id', 'left');
        $this->db->where('u.estado', $estado);
        $query = $this->db->get();
        return $query->result();
    }

    // Método para verificar si un email ya existe
    public function email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }

    // Método para obtener los roles por nombres, necesario para la función check_role
    public function get_roles_by_names($role_names) {
        $this->db->select('id');
        $this->db->from('roles');
        $this->db->where_in('nombre', $role_names);
        $query = $this->db->get();
        $result = $query->result();

        // Extraer solo los IDs en un array
        $role_ids = [];
        foreach ($result as $row) {
            $role_ids[] = $row->id;
        }

        return $role_ids;
    }

    public function get_usuarios_by_rol($rol_id) {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id');
        $this->db->where('u.rol_id', $rol_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_usuarios_by_estado_y_rol($estado, $rol_id) {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id', 'left');
        $this->db->where('u.estado', $estado);
        $this->db->where('u.rol_id', $rol_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_usuarios_by_rol_activos($rol_id) {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id');
        $this->db->where('u.rol_id', $rol_id);
        $this->db->where('u.estado', 'activo');
        $query = $this->db->get();
        return $query->result();
    }    
    
    public function get_all_clientes() {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id');
        $this->db->where('u.rol_id', 3); // Asumiendo que 3 es el rol_id para "cliente"
        $this->db->where('u.estado', 'activo'); // Filtra solo los clientes activos
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_all_empleados() {
        $this->db->select('u.*, r.nombre as rol_nombre');
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.rol_id = r.id');
        $this->db->where_in('u.rol_id', [1, 2]); // Asumiendo que 1 es el rol_id para "admin" y 2 para "empleado"
        $this->db->where('u.estado', 'activo'); // Filtra solo los empleados/admin activos
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_clientes_count_by_period($period) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('usuarios');
        $this->db->where('rol_id', 3); // Asumiendo que el rol_id 3 es para clientes
    
        if ($period == 'hoy') {
            $this->db->where('DATE(fecha_creacion)', 'CURDATE()', FALSE);
        } elseif ($period == 'este_mes') {
            $this->db->where('MONTH(fecha_creacion)', 'MONTH(CURDATE())', FALSE);
            $this->db->where('YEAR(fecha_creacion)', 'YEAR(CURDATE())', FALSE);
        } elseif ($period == 'este_año') {
            $this->db->where('YEAR(fecha_creacion)', 'YEAR(CURDATE())', FALSE);
        }
    
        $query = $this->db->get();
        return $query->row()->total;
    }    
    
    private function calcular_porcentaje_clientes($filterOption) {
        $current_total = $this->get_clientes_count_by_period($filterOption);
    
        // Definir el periodo anterior para calcular la diferencia
        if ($filterOption == 'hoy') {
            $previous_total = $this->get_clientes_count_by_period('ayer');
        } elseif ($filterOption == 'este_mes') {
            $previous_total = $this->get_clientes_count_by_period('el_mes_pasado');
        } elseif ($filterOption == 'este_año') {
            $previous_total = $this->get_clientes_count_by_period('el_año_pasado');
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
