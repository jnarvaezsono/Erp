<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Document extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function GetPptoCompleteInfo($ini = false, $fin = false, $doc = false) {

        if ($fin)
            $this->db->limit($fin, $ini);
        
        if($doc)
            $this->db->where('docequi_id',$doc);
        
        if(!empty($this->input->get('search[value]'))){
            $this->db->like('d.docequi_id', trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.docequi_fecha',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.id_doc',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('u.usr_nombre',  trim($this->input->get('search[value]'))); 
            $this->db->or_like('d.docequi_total',  trim($this->input->get('search[value]'))); 
        }
        
        $result = $this->db->select('d.docequi_id AS id,d.docequi_fecha AS fecha,d.tpo_doc AS tipo,d.id_doc AS doc,d.docequi_total AS total,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,
                                    concat(u.usr_nombre," ",u.usr_apellido) as usuario,d.docequi_hora AS hora,d.docequi_detalle AS detalle,d.num_impresiones AS impresiones,d.docequi_formapago AS forma_pago,
                                    d.docequi_valor AS valor,d.docequi_fechacreacion AS fecha_creacion,c.nombre AS cliente,c.documento  ')
                        ->from('docequi d')
                        ->join('cat_estados e', 'd.est_id = e.est_id')
                        ->join('sys_clients c ', 'd.pvcl_id = c.id_client','left')
                        ->join('usuarios u', 'd.usr_id = u.usr_id','left')
                        ->order_by('d.docequi_id', 'desc')
                        ->get();
        
        return array("result" => $result->result(), "num" => $result->num_rows());
    }
    
    function GetDoc($id){
        $rs = $this->db->select('d.*,e.est_nombre AS estado')
            ->from('docequi d')
            ->join('cat_estados e', 'd.est_id = e.est_id')
            ->where('docequi_id', $id)
            ->get();
        return $rs->row();
    }
    
    function InsertInfo($data){
        $result = $this->db->insert('docequi', $data);
        if($result){
            $id = $this->db->insert_id();
            $res = array('res'=>'OK','id'=>$id);
        }else{
            $res = array('res'=>"ERROR ".$This->db->last_query(),'id'=>'0');
        }
        return $res;
    }
    
    function UpdateStatus($id, $status) {
        $this->db->trans_begin();
        
        $rs = $this->db->select('*')
            ->from('docequi')
            ->where('docequi_id', $id)
            ->get()->row();
                
        $data['usr_mod'] = $this->session->UserMedios;

        if ($status == 5) {
            $data['num_impresiones'] = $rs->num_impresiones + 1;
        }
        if($rs->est_id != 9999 && $rs->est_id != 39){
            $data['est_id'] = $status;
        }
        
        $this->db->where('docequi_id', $id);
        $result = $this->db->update('docequi', $data);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $res = "Error";
        } else {
            $res = "OK";
            $this->db->trans_commit();
        }
        return $res;
    }
    
    function GetOrdCost($id = false){
        
        if($id)
            $this->db->where('ordcos_id',$id);
        
        $rs = $this->db->select('ordcos_id as order,c.nombre as proveedor, o.pvcl_id_prov as id_prov, ordcos_total as valor,"" as detalle')
            ->from('ord_costos o')
            ->join('sys_clients c ', 'o.pvcl_id_prov = c.id_client')
            ->where('est_id not in( 3,4,9999,38)')
            ->where('docequi','0')
            ->where('regimen','0')
            ->order_by('ordcos_id','desc')
            ->get();
        
        if($id){
            $row = $rs->row();
            
            $rsl = $this->db->select('dordcos_detalle as detalle ')
                        ->from('det_ordcostos')
                        ->where('ordcos_id',$id)
                        ->get();
            
            foreach ($rsl->result() as $value) {
                $row->detalle .= $value->detalle.' | ';
            }
            
            return $row;
            
        }else{
            return $rs->result();
        }
    }
    
    function GetOrdGast($id = false){
        
        if($id)
            $this->db->where('ordgas_id',$id);
        
        $rs = $this->db->select('ordgas_id as order,c.nombre as proveedor, o.pvcl_id as id_prov, ordgas_total as valor,"" as detalle ')
            ->from('ord_gastos o')
            ->join('sys_clients c ', 'o.pvcl_id = c.id_client')
            ->where('ordgas_estado not in( 3,4,9999,38)')
            ->where('regimen','0')
            ->where('docequi','0')
            ->order_by('ordgas_id','desc')
            ->get();
        
        if($id){
            $row = $rs->row();
            
            $rsl = $this->db->select('dordgas_detalle as detalle ')
                        ->from('det_ordgasto')
                        ->where('ordgas_id',$id)
                        ->get();
            
            foreach ($rsl->result() as $value) {
                $row->detalle .= $value->detalle.' | ';
            }
            
            return $row;
            
        }else{
            return $rs->result();
        }
    }
    
    function GetOrdExt($order){
        $result = $this->db->select('*')
                ->from('ordenes')
                ->where('ord_id',$order)
                ->get();
        return  array("result" => $result->row(), "num" => $result->num_rows());
    }
    
    function infoPresup($select,$table,$field_id,$ppto,$where_status){
        $result = $this->db->select($select)
                ->from($table.' p')
                ->join('sys_clients c', 'p.pvcl_id_prov = c.id_client')
                ->where($field_id,$ppto)
                ->where($where_status)
                ->where('regimen','0')
                ->get();
        return  array("result" => $result->row(), "num" => $result->num_rows());
    }
    
    function infoDetailPresup($select_detail,$table_det,$field_id,$ppto){
        $result = $this->db->select($select_detail)
                ->from($table_det)
                ->where($field_id,$ppto)
                ->get();
        
        return $result->result();
    }
    
    function detailOrderCosto($order){
        $rs = $this->db->select('f_detail_costo(ordcos_id) as detalle')
                ->from('ord_costos o')
                ->where('ordcos_id',$order)
                ->get();
        return $rs->row();
    }
    
    function detailOrderGasto($order){
        $rs = $this->db->select('f_detail_gasto(ordgas_id) as detalle')
                ->from('ord_gastos o')
                ->where('ordgas_id',$order)
                ->get();
        return $rs->row();
    }
    
    function UpdateInfo($docequi_id,$data){
        $this->db->where('docequi_id', $docequi_id);
        $result = $this->db->update('docequi', $data);
      
        if($result){
            $res = "OK";
        }else{
            $res = "ERROR ".$this->db->last_query();
        }
        return $res;
    }
    
    function enableOrderCost($order){
        $rs = $this->db->select('ifnull(ordcos_vlrcobrado,0) as cobrado, ifnull(ordcos_vlrfaltante, 0) as faltante, no_presup')
                ->from('ord_costos o')
                ->where('ordcos_id',$order)
                ->get();
        $row = $rs->row();
        
        if($row->cobrado > 0 && $row->faltante == 0 && !empty($row->no_presup)){
            $data['est_id'] = 39;
        }else{
            $data['est_id'] = 5;
        }
        $data['docequi'] = 0;
        
        $this->db->where('ordcos_id', $order);
        $result = $this->db->update('ord_costos', $data);
    }
    
    function disableOrderCost($order){
        $rs = $this->db->select('*')
                ->from('ord_costos o')
                ->where('ordcos_id',$order)
                ->get();
        $row = $rs->row();
        
        $data['docequi'] = 1;
        
        if($row->est_id != 9999 && $row->est_id != 39){
            $data['est_id'] = 3;
        }
        $this->db->where('ordcos_id', $order);
        $result = $this->db->update('ord_costos', $data);
    }
    
    function enableOrderGast($order){
        
        $this->db->where('ordgas_id', $order);
        $result = $this->db->update('ord_gastos', array('ordgas_estado'=>5,'docequi' => 0));
    }
    
    function enableOrderExt($order,$status){
        $this->db->where('ord_id', $order);
        $result = $this->db->update('ordenes', array('doc'=>$status));
    }
    
    function disableOrderGast($order){
        $this->db->where('ordgas_id', $order);
        $result = $this->db->update('ord_gastos', array('ordgas_estado'=>3,'docequi' => 1));
    }
    
    function GetLastPeriodo(){
         $rs = $this->db->select("DATE_FORMAT(DATE_ADD(CONCAT(periodo,'-01'), INTERVAL 1 MONTH), '%Y-%m') as periodo_new, periodo as periodo_old ")
                ->from('sys_cierre')
                ->where('tipo','doc')
                ->order_by('id','desc')
                ->limit(1,0)
                ->get();
        return $rs->row();
    }
    
    function GetDocEnable($periodo){
         $rs = $this->db->select('*')
                ->from('docequi')
                ->where("DATE_FORMAT(docequi_fecha,'%Y-%m')",$periodo)
                ->where("est_id",1)
                ->get();
        return array('num'=>$rs->num_rows(),'rows'=>$rs->result());
    }
    
    function GetClose_Old($now){
        
        if($now){
            $this->db->where("periodo = DATE_FORMAT(CURDATE(), '%Y-%m')");
        }else{
            $this->db->where("periodo = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m') ");
        }
        
        $rs = $this->db->select('*')
                ->from('sys_cierre')
                ->where('tipo','doc')
                ->get();
//        echo $this->db->last_query(); exit();
        return $rs->num_rows();
    }
    
}