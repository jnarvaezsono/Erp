<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sgc extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function getTypesFormats() {
        $result = $this->db->select('*')
                ->from('sys_type_formats')
                ->get();

        return $result->result();
    }

    function GetCompleteInfo($ini = false, $fin = false, $tipo) {

        if ($fin)
            $this->db->limit($fin, $ini);


        if (!empty($this->input->get('search[value]'))) {
            $this->db->like('id_solicitud', $this->input->get('search[value]'));
            $this->db->or_like('u.name', trim($this->input->get('search[value]')));
            $this->db->or_like('e.description', trim($this->input->get('search[value]')));
            $this->db->or_like('t.descripcion', trim($this->input->get('search[value]')));
            $this->db->or_like('s.fecha', trim($this->input->get('search[value]')));
        }

        switch ($tipo) {
            case 1:
                if (!in_array($this->session->IdRol, array(4, 14, 15, 1))) { //4 nomina ,14 gerencia, 15 coor sistemas, 1 admin
                    $this->db->where('s.id_usuario', $this->session->IdUser);
                }
                break;
            case 2:
                if (!in_array($this->session->IdRol, array(4, 14, 1))) { //4 nomina ,14 gerencia,
                    $this->db->where("(s.id_usuario = ".$this->session->IdUser." || (s.solicitado_a LIKE '".$this->session->IdUser."' OR s.solicitado_a LIKE '".$this->session->IdUser.",%'
                        OR s.solicitado_a LIKE '%,".$this->session->IdUser."'
                        OR s.solicitado_a LIKE '%,".$this->session->IdUser.",%'))");
                }
                break;
            default:
                break;
        }

        $result = $this->db->select('s.id_solicitud,s.fecha,u.name AS usuario,e.description AS estado,e.color,e.id_status as id_estado,t.descripcion AS tipo')
                ->from('sys_solicitud_formato s')
                ->join('sys_users u', 's.id_usuario = u.id_users')
                ->join('sys_status e', 's.id_estado = e.id_status')
                ->join('sys_type_formats t', 's.id_tipo_formato = t.id_tipo')
                ->where('s.id_tipo_formato', $tipo)
                ->order_by('s.id_solicitud', 'desc')
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function GetInfo($id, $tipo) {
        $this->db->select('s.id_solicitud,s.fecha,u.name AS usuario,s.id_usuario,e.description AS estado,e.color,e.id_status as id_estado,t.descripcion AS tipo,s.observacion,s.solicitado_a,f.*,s.ok_jefe,s.ok_nomina,s.ok_gerente')
                ->from('sys_solicitud_formato s')
                ->join('sys_users u', 's.id_usuario = u.id_users')
                ->join('sys_status e', 's.id_estado = e.id_status')
                ->join('sys_type_formats t', 's.id_tipo_formato = t.id_tipo');

        switch ($tipo) {
            case 1:
                $this->db->join('sys_solicitud_vacante f', 's.id_solicitud = f.id_solicitud');
                break;
            case 2:
                $this->db->join('sys_solicitud_vacaciones f', 's.id_solicitud = f.id_solicitud');
                break;

            default:
                break;
        }

        $result = $this->db->where('s.id_solicitud', $id)->get();

        return $result->row();
    }
    
    function NewComment($data) {
        $result = $this->db->insert("sys_history_formatos", $data);
        if ($result) {
            return "OK";
        } else {
            return "Error: " . $this->db->last_query();
        }
    }
    
    function ListarComentarios($id) {
        $result = $this->db->select("*")
                ->from("sys_history_formatos c")
                ->join("sys_users u", "c.id_user = u.id_users")
                ->where("c.id_solicitud", $id)
                ->order_by('c.fecha', 'desc')
                ->get();
        return $result->result();
    }
    
    
    function getCargos(){
        $result = $this->db->select("*")
                ->from("sys_cargos")
                ->order_by('cargo')
                ->get();
        return $result->result();
    }
}
