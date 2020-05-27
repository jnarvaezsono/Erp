<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Order_Cost extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function GetPptoCompleteInfo($ini = false, $fin = false, $id, $fecha_ini, $fecha_fin, $proveedor){
        if ($fin)
            $this->db->limit($fin, $ini);
        
        if (!empty($this->input->get('search[value]'))) {
            $this->db->like('ordcos_id', $this->input->get('search[value]'));
            $this->db->or_like('e.est_nombre', trim($this->input->get('search[value]')));
            $this->db->or_like('p.nombre', trim($this->input->get('search[value]')));
            $this->db->or_like('c.nombre', trim($this->input->get('search[value]')));
            $this->db->or_like('ca.camp_nombre', trim($this->input->get('search[value]')));
            $this->db->or_like('o.ordcos_valor', trim($this->input->get('search[value]')));
        }
        
        if ($id != 'all')
            $this->db->where('ordcos_id', $id);

        if ($proveedor != 'all')
            $this->db->where('o.pvcl_id_prov', $proveedor);

        if ($fecha_ini != "all")
            $this->db->where("o.ordcos_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

        $result = $this->db->select('ordcos_id AS id,o.ordcos_fecha as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,ordcos_valor as valor,ordcos_total as total,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,o.num_impresiones as impresiones,'
                        . 'pr.pdcl_nombre as producto,c.documento,o.ordcos_noorden,s.nombre as servicio,ordcos_observa as observacion,ordcos_desc as descuento,ordcos_iva as iva, ordcos_guia, no_presup ,if(o.tipo = "I","INTERNA","EXTERNA") as tipo ')
                ->from('ord_costos o')
                ->join('cat_estados e', 'o.est_id = e.est_id', 'left')
                ->join('sys_clients c ', 'o.pvcl_id_clie = c.id_client', 'left')
                ->join('sys_clients p ', 'o.pvcl_id_prov = p.id_client', 'left')
                ->join('cat_campanas ca ', 'o.camp_id = ca.camp_id', 'left')
                ->join('usuarios u', 'o.usr_id = u.usr_id','left')
                ->join('cat_prodsclies pr', 'o.prod_id = pr.pdcl_id', 'left')
                ->join('sys_tipo_servicio s', 'o.tpsv_id = s.id_tipo_servicio', 'left')
                ->order_by('o.ordcos_id', 'desc')
                ->get();
                
                
        return array("result" => $result->result(), "num" => $result->num_rows());
    }
    
    function Copy($order){
        $this->db->trans_begin();
        $newOrder = '';
        $fecha = date('Y-m-d');
        
        $rs = $this->db->select('*')
            ->from('ord_costos')
            ->where('ordcos_id', $order)
            ->get()->row();
        
        unset($rs->ordcos_id);
        $rs->ordcos_fecha = $fecha;
        $rs->presup_fechacrea = date('Y-m-d H:i:s');
        $rs->usr_id = $this->session->UserMedios;
        $rs->usr_id_mod = $this->session->UserMedios;
        $rs->est_id = 1;
        $rs->num_impresiones = -1;
        $rs->ordcos_nimpre = null;
        $rs->ordcos_nimpreo = null;
        $rs->ordcos_formapago = null;
        $rs->ordcos_fechentre = null;
        $rs->ordcos_descage = null;
        $rs->num_impresiones = -1;
        $rs->ordcos_noorden = null;
        $rs->ordcos_guia = null;
        $rs->no_presup = null;
        
        $this->db->insert('ord_costos', $rs);
        $newOrder = $this->db->insert_id();
        
        $rsdet = $this->db->select('*')
            ->from('det_ordcostos')
            ->where('ordcos_id', $order)
            ->get();
        
        $array = array();
        foreach ($rsdet->result() as $d) {
            $array[] = array(
                'ordcos_id' => $newOrder,
                'dordcos_valor' => $d->dordcos_valor,
                'dordcos_detalle' => $d->dordcos_detalle,
                'dordcos_cant' => $d->dordcos_cant,
                'tpsv_id' => $d->tpsv_id,
                'dordcos_iva' => $d->dordcos_iva,
                'dordcos_total' => $d->dordcos_total
            );
        }

        if (count($array) > 0) {
            $this->db->insert_batch('det_ordcostos', $array);
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $res = array('res' => "Error");
        } else {
            $res = array('res' => "OK", "id" => $newOrder);
            $this->db->trans_commit();
        }
        return $res;
    }
    
    function SelectRow($table,$field_id,$ppto,$select = false){
        
        if(!$select)
            $select = '*';
        
        $result = $this->db->select($select)
                ->from($table)
                ->where($field_id, $ppto)
                ->get();
        
        return $result->row();
    }
    
    function GetOrderDupli(){
        $result = $this->db->select('ordcos_id as id')
                        ->from('ord_costos o')
                        ->where('ordcos_fecha >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)')
                        //->where('est_id NOT IN (7, 39, 9999, 1)')
                        ->order_by('ordcos_id','desc')
                        ->get();
        return $result->result();
    }
    
    function GetOrder($id){
        $result = $this->db->select('ordcos_id AS id,e.est_nombre AS estado,ordcos_valor as valor,ordcos_total as total,ordcos_iva as iva,ordcos_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, prod_id as producto, camp_id as campana, tpsv_id as servicio, ordcos_noorden as presupuestos, ordcos_observa as observacion, e.est_id as id_estado,no_presup as ppto2, ordcos_guia, o.tipo')
                        ->from('ord_costos o')
                        ->join('cat_estados e', 'o.est_id = e.est_id')
                        ->where('ordcos_id', $id)
                        ->get();
        return $result->row();
    }
    
    function ListDetail($id){
        $result = $this->db->select('d.dordcos_id AS id_detalle,d.dordcos_valor AS valor,d.dordcos_detalle AS detalle,d.ordcos_id AS orden,d.dordcos_cant AS cantidad,
                                            d.dordcos_total AS total,t.nombre AS servicio')
                        ->from('det_ordcostos d ')
                        ->join('sys_tipo_servicio t', 'd.tpsv_id = t.id_tipo_servicio','left')
                        ->where('d.ordcos_id', $id)
                        ->get();
        
        return $result->result();
    }

    function Receivable() {
        $result = $this->db->query("SELECT c.*,e.est_nombre AS estado,cl.nombre AS cliente,cp.camp_nombre AS campana,pr.pdcl_nombre AS producto,u.usr_nombre as usuario,c.ordcos_fecha as fecha  FROM ord_costos c 
                                    JOIN cat_estados e ON c.est_id = e.est_id
                                    left JOIN sys_clients cl ON c.pvcl_id_clie = cl.id_client
                                    left JOIN cat_campanas cp ON c.camp_id = cp.camp_id
                                    LEFT JOIN cat_prodsclies pr ON c.prod_id = pr.pdcl_id 
                                    LEFT JOIN usuarios u ON c.usr_id = u.usr_id
                                    WHERE  IFNULL(c.no_presup,'') != '' order by c.ordcos_fecha desc ");

        return $result->result();
    }
    
    function AddObs($id,$obs){
        $data = array('ordcos_guia' => $obs);
        $this->db->where('ordcos_id', $id);
        $result = $this->db->update('ord_costos', $data);
        if ($result) {
            return 'OK';
        } else {
            return 'Error: ' . $this->db->last_query();
        }
    }
    
    function UpdateStatus($id, $status) {
            
            $rs = $this->db->select('*')
                ->from('ord_costos')
                ->where('ordcos_id', $id)
                ->get()->row();
        
            if ($rs->est_id != 9999 && $rs->est_id != 39) { // pregunto si no esta facturado.
                $data['est_id'] = $status;
            }
            
            if ($status == 5) {
                $data['num_impresiones'] = $rs->num_impresiones + 1;
            }
            
            $data['usr_id_mod'] = $this->session->UserMedios;
            
            $this->db->where('ordcos_id', $id);
            $result = $this->db->update('ord_costos', $data);
            
            if($result){
                return 'OK';
            }else{
                return 'Error '.$this->db->last_query();
            }
            
    }

    function GetDetail($id){
        $result = $this->db->select('dordcos_detalle as detalle,dordcos_cant as cantidad,dordcos_total as total,dordcos_valor as valor')
                        ->from('det_ordcostos')
                        ->where('ordcos_id', $id)
                        ->get();
        
        return $result->result();
    }
    
    function ListarCampana($id = false) {

        if ($id)
            $this->id_cliente = $id;

        $result = $this->db->select('*')
                ->from('cat_campanas')
                ->where('pvcl_id', $this->id_cliente)
                ->where('est_id', 1)
                ->order_by('camp_nombre')
                ->get();

        return $result->result();
    }
    
    function ListarRubro($id = false) {

        if ($id)
            $this->id_cliente = $id;

        $result = $this->db->select('*')
                ->from('cat_prodsclies')
                ->where('pvcl_id', $this->id_cliente)
                ->where('est_id', 1)
                ->order_by('pdcl_nombre')
                ->get();

        return $result->result();
    }

    function CargarTipoServicio($id = false, $status = false) {
        if ($id)
            $this->db->where('id_categoria', $id);
        
        if ($status)
            $this->db->where('id_estado', $status);

        $result = $this->db->select('`id_tipo_servicio`, UPPER(`nombre`) as nombre, `descripcion`, `tpsv_cebe`, `id_estado`, `id_categoria`')
                ->from('sys_tipo_servicio')
                ->group_by('tpsv_cebe')
                ->order_by('nombre')
                ->get();

        return $result->result();
    }
    
    function LoadServices($tipo){
        
        $result = $this->db->select('`id_tipo_servicio`, UPPER(`nombre`) as nombre, s.descripcion, `tpsv_cebe`, s.id_estado, c.id_categoria, c.descripcion as tabla')
                ->from('sys_tipo_servicio s')
                ->join('sys_categoria c','s.id_categoria = c.id_categoria')
                ->where("s.tipo",$tipo)
                ->order_by('nombre')
                ->get();
        return $result->result();
    }
    
    function UpdateInfo($order,$data) {
   
        $this->db->where('ordcos_id', $order);
        $result = $this->db->update('ord_costos', $data);
      
        if($result){
            $res = "OK";
        }else{
            $res = "ERROR ".$this->db->last_query();
        }
        return $res;
    }
    
    function ValorTotal($id){
        $result = $this->db->select('ordcos_valor,
                (ordcos_valor * (ordcos_desc / 100)) AS descuento,
                ((ordcos_valor - (ordcos_valor * (ordcos_desc / 100))) * (ordcos_iva / 100)) AS iva,
                ((ordcos_valor - (ordcos_valor * (ordcos_desc / 100))) + ((ordcos_valor - (ordcos_valor * (ordcos_desc / 100))) * (ordcos_iva / 100))) AS total,pvcl_id_clie')
                ->from('ord_costos')
                ->where('ordcos_id', $id)
                ->get();
        
        return $result->row();
    }
    
    function DeleteDetail($id,$id_detalle){
        $this->db->where('dordcos_id',$id_detalle);
        $result = $this->db->delete('det_ordcostos');
      
        if($result){
            $res = "OK";
            
            $result = $this->db->select('SUM(dordcos_total) AS valor')
                ->from('det_ordcostos')
                ->where('ordcos_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    function UpdateDetail($data,$id,$id_detalle){
        $this->db->where('dordcos_id',$id_detalle);
        $result = $this->db->update('det_ordcostos', $data);
      
        if($result){
            $res = "OK";
            
            $result = $this->db->select('SUM(dordcos_total) AS valor')
                ->from('det_ordcostos')
                ->where('ordcos_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    function GetPPtos($row){
        
        $result = $this->db->select('num_presup as ppto, fecha_presup as fecha')
                ->from('lista_internas_externas')
                ->where('id_clie', $row->cliente)
                ->where('camp_id', $row->campana)
                ->where('pdcl_id', $row->producto)
                ->where('tpsv_id', $row->servicio)
                ->order_by('num_presup')
                ->get();
        
        return $result->result();
        
    }
    
    function InsertInfo($data){
        $result = $this->db->insert('ord_costos', $data);
        if($result){
            $id = $this->db->insert_id();
            $res = array('res'=>'OK','id'=>$id);
        }else{
            $res = array('res'=>"ERROR ".$This->db->last_query(),'id'=>'0');
        }
        return $res;
    }
    
    function AddDetail($data,$id){
        $result = $this->db->insert('det_ordcostos', $data);
      
        if($result){
            $res = "OK";
            $id_detalle = $this->db->insert_id();
            
            $result = $this->db->select('SUM(dordcos_total) AS valor')
                ->from('det_ordcostos')
                ->where('ordcos_id', $id)
                ->get();
            
            $res = array('res'=> "OK" ,'valor'=>$result->row()->valor, 'id_detalle'=>$id_detalle);
        }else{
            $res = array('res'=> "ERROR ".$This->db->last_query());
        }
        return $res;
    }
    
    
}
