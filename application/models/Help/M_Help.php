<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Help extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function GetPptoCompleteInfo($ini = false, $fin = false) {
        if ($fin)
            $this->db->limit($fin, $ini);

        if (!empty($this->input->get('search[value]'))) {
            $this->db->like('id_ticket', $this->input->get('search[value]'));
            $this->db->or_like('u.name', trim($this->input->get('search[value]')));
            $this->db->or_like('a.descripcion', trim($this->input->get('search[value]')));
            $this->db->or_like('t.descripcion', trim($this->input->get('search[value]')));
            $this->db->or_like('e.description', trim($this->input->get('search[value]')));
        }

        if (!groupSystem($this->session->IdRol) && !groupGerentes($this->session->IdRol)) {
            $this->db->where('t.id_user', $this->session->IdUser);
        }

        $result = $this->db->select('t.id_ticket AS id,u.name AS usuario,t.fecha,t.calificacion,t.tipo,t.prioridad,a.descripcion AS nombre_area,t.descripcion,t.observacion,e.id_status,e.description AS estado,e.hex as color,t.id_user,t.subservicio')
                ->from('sys_tickets t')
                ->join('sys_users u', 't.id_user = u.id_users')
                ->join('sys_area a', 't.id_area = a.id_area', 'left')
                ->join('sys_status e', 't.id_estado = e.id_status', 'left')
                ->order_by('t.id_ticket', 'desc')
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }
    
    function getIndicators(){
        
        if (!groupSystem($this->session->IdRol) && !groupGerentes($this->session->IdRol)) {
            $this->db->where('t.id_user', $this->session->IdUser);
        }

        $result = $this->db->select('sum(if(t.id_estado = 25,1,0)) AS pendiente,sum(if(t.id_estado = 26,1,0)) AS resuelto,sum(if(t.id_estado = 4,1,0)) AS anulado,sum(if(t.id_estado = 26,if(t.calificacion = 0,1,0),0)) AS nocalificado')
                ->from('sys_tickets t')
                ->get();

        return $result->row();
    }
    
    function GetInfo($id){
        $result = $this->db->select('*')
                ->from('sys_tickets')
                ->where('id_ticket',$id)
                ->get();
        return array("row" => $result->row(), "num" => $result->num_rows());
    }

    function GetTicketNotQualified($IdUser){
        $result = $this->db->select('*')
                ->from('sys_tickets')
                ->where('id_user',$IdUser)
                ->where('id_estado',26)
                ->where('calificacion',0)
                ->get();
        return $result->num_rows();
    }
    
    function Loadsubservices($servicio){
        $res = $this->db->select('*')
            ->from('sys_opcion_ticket')
            ->where('servicio',$servicio)
            ->order_by('descripcion')
            ->get();
        
        return $res->result();
    }
    
}
