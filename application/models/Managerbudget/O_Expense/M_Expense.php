<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Expense extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function GetPptoCompleteInfo($ini = false, $fin = false, $id, $fecha_ini, $fecha_fin, $proveedor){
        if ($fin)
            $this->db->limit($fin, $ini);
        
        if ($id != 'all')
            $this->db->where('ordgas_id', $id);

        if ($proveedor != 'all')
            $this->db->where('o.pvcl_id', $proveedor);

        if ($fecha_ini != "all")
            $this->db->where("o.ordgas_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

        $result = $this->db->select('ordgas_id AS id,o.ordgas_fecha as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,ordgas_valor as valor,ordgas_total as total,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,o.num_impresiones as impresiones,'
                        . 's.nombre as servicio,ordgas_observa as observacion,ordgas_desc as descuento,ordgas_iva as iva ')
                ->from('ord_gastos o')
                ->join('cat_estados e', 'o.ordgas_estado = e.est_id', 'left')
                ->join('sys_clients p ', 'o.pvcl_id = p.id_client', 'left')
                ->join('usuarios u', 'o.usr_id = u.usr_id','left')
                ->join('sys_tipo_servicio s', 'o.tpsv_id = s.id_tipo_servicio', 'left')
                ->order_by('o.ordgas_id', 'desc')
                ->get();
                
                
        return array("result" => $result->result(), "num" => $result->num_rows());
    }
        
    function UpdateStatus($id, $status) {
            
            $rs = $this->db->select('*')
                ->from('ord_gastos')
                ->where('ordgas_id', $id)
                ->get()->row();
        
            if ($rs->ordgas_estado != 9999) { // pregunto si no esta facturado.
                $data['ordgas_estado'] = $status;
            }
            
            if ($status == 5) {
                $data['num_impresiones'] = $rs->num_impresiones + 1;
            }
            
            $data['ordgas_usuariomod'] = $this->session->UserMedios;
            
            $this->db->where('ordgas_id', $id);
            $result = $this->db->update('ord_gastos', $data);
            
            if($result){
                return 'OK';
            }else{
                return 'Error '.$this->db->last_query();
            }
            
    }
    
    function GetDetail($id){
        $result = $this->db->select('dordgas_detalle as detalle,dordgas_cant as cantidad,dordgas_valor as total')
                        ->from('det_ordgasto')
                        ->where('ordgas_id', $id)
                        ->get();
        
        return $result->result();
    }

    function GetOrder($id){
        $result = $this->db->select('ordgas_id AS id,e.est_nombre AS estado,ordgas_valor as valor,ordgas_total as total,ordgas_iva as iva,ordgas_desc as descuento, pvcl_id as proveedor, tpsv_id as servicio, ordgas_observa as observacion, e.est_id as id_estado')
                        ->from('ord_gastos o')
                        ->join('cat_estados e', 'o.ordgas_estado = e.est_id')
                        ->where('ordgas_id', $id)
                        ->get();
        return $result->row();
    }
    
    function ListDetail($id){
        $result = $this->db->select('d.dordgas_id AS id_detalle,d.dordgas_valor AS valor,d.dordgas_detalle AS detalle,d.ordgas_id AS orden,d.dordgas_cant AS cantidad,d.dordgas_valor AS total')
                        ->from('det_ordgasto d ')
                        ->where('d.ordgas_id', $id)
                        ->get();
        
        return $result->result();
    }
    
    function UpdateInfo($order,$data) {
   
        $this->db->where('ordgas_id', $order);
        $result = $this->db->update('ord_gastos', $data);
      
        if($result){
            $res = "OK";
        }else{
            $res = "ERROR ".$this->db->last_query();
        }
        return $res;
    }
    
    function AddDetail($data,$id){
        $result = $this->db->insert('det_ordgasto', $data);
      
        if($result){
            $res = "OK";
            
            $result = $this->db->select('SUM(dordgas_valor) AS valor')
                ->from('det_ordgasto')
                ->where('ordgas_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    function ValorTotal($id){
        $result = $this->db->select('ordgas_valor,
                (ordgas_valor * (ordgas_desc / 100)) AS descuento,
                ((ordgas_valor - (ordgas_valor * (ordgas_desc / 100))) * (ordgas_iva / 100)) AS iva,
                ((ordgas_valor - (ordgas_valor * (ordgas_desc / 100))) + ((ordgas_valor - (ordgas_valor * (ordgas_desc / 100))) * (ordgas_iva / 100))) AS total')
                ->from('ord_gastos')
                ->where('ordgas_id', $id)
                ->get();
        
        return $result->row()->total;
    }
    
    function DeleteDetail($id,$id_detalle){
        $this->db->where('dordgas_id',$id_detalle);
        $result = $this->db->delete('det_ordgasto');
      
        if($result){
            $res = "OK";
            
            $result = $this->db->select('SUM(dordgas_valor) AS valor')
                ->from('det_ordgasto')
                ->where('ordgas_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    function UpdateDetail($data,$id,$id_detalle){
        $this->db->where('dordgas_id',$id_detalle);
        $result = $this->db->update('det_ordgasto', $data);
      
        if($result){
            $res = "OK";
            
            $result = $this->db->select('SUM(dordgas_valor) AS valor')
                ->from('det_ordgasto')
                ->where('ordgas_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    function InsertInfo($data){
        $result = $this->db->insert('ord_gastos', $data);
        if($result){
            $id = $this->db->insert_id();
            $res = array('res'=>'OK','id'=>$id);
        }else{
            $res = array('res'=>"ERROR ".$This->db->last_query(),'id'=>'0');
        }
        return $res;
    }

}
