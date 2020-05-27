<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Filed extends VS_Model {

    public function __construct() {
        parent::__construct();
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function GetPptoCompleteInfo($ini = false, $fin = false, $id = false) {

        if ($fin)
            $this->db->limit($fin, $ini);
        
        if($id)
            $this->db->where('id_radicado',$id);
        
        if(!empty($this->input->get('search[value]'))){
            $this->db->like('d.id_radicado', trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.fecha',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('c.nombre',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.factura',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.valor',  trim($this->input->get('search[value]'))); 
        }
        
        $result = $this->db->select('d.id_radicado AS id,DATE_FORMAT(d.fecha, "%Y-%m-%d") AS fecha,d.factura,valor,e.est_nombre AS estado,e.est_color,id_estado,
                                    c.nombre AS proveedor,c.documento ,d.id_prov, d.faltante ')
                        ->from('sys_radicado d')
                        ->join('cat_estados e', 'd.id_estado = e.est_id')
                        ->join('sys_clients c ', 'd.id_prov = c.id_client','left')
                        ->order_by('d.id_radicado', 'desc')
                        ->get();
        if($id){
            return $result->row();
        }else{
            return array("result" => $result->result(), "num" => $result->num_rows());
        }
    }
    
    function GetTotals($id){
        $result = $this->db->select('ifnull(sum(valor),0) as valor_total')
                        ->from('sys_radicado_detalle')
                        ->where('id_radicado', $id)
                        ->get();
        return $result->row();
    }
    
    function GetDetails($id){
        $result = $this->db->select('id_detalle, id_radicado, orden,tipo,valor')
                        ->from('sys_radicado_detalle')
                        ->where('id_radicado', $id)
                        ->get();
        return $result->result();
    }
}
