<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Credit_Notes extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function ListNote($ini = false,$fin = false,$order_by,$factura,$ppto,$f_ini, $f_fin){
        if($fin && $fin != '-1')
            $this->db->limit($fin, $ini);
        
        if($factura != "all")
            $this->db->where("s.factura",$factura);
        
        if($ppto != "all")
            $this->db->where("d.ppto",$ppto);
        
        if($f_ini != "all")
            $this->db->where("s.fecha between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY) ");
        
        
        $result = $this->db->select('*,GROUP_CONCAT(d.ppto SEPARATOR ", ") as ppto')
                ->from('sys_nota_credito s')
                ->join('sys_nota_credito_detalle d','s.id_nota_credito = d.id_nota_credito')
                ->join('cat_estados','`cat_estados`.`est_id` = `s`.`id_estado`')
                ->group_by('d.id_nota_credito')
                ->order_by('s.id_nota_credito',$order_by)
                ->get();
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function SelectNote($factura = false, $ppto = false,$f_ini = false, $f_fin = false){
        
        if($factura != "all")
            $this->db->where("s.factura",$factura);
        
        if($ppto != "all")
            $this->db->where("d.ppto",$ppto);
        
        if($f_ini != "all")
            $this->db->where("s.fecha between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY)  ");
        
        $result = $this->db->select('*')
                ->from('sys_nota_credito s')
                ->join('sys_nota_credito_detalle d','s.id_nota_credito = d.id_nota_credito')
                ->group_by('d.id_nota_credito')
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function InfoFactura($factura){
        $result = $this->db->select(' c.nombre,c.documento,c.direccion,f.factura_retefuente,f.factura_id')
                ->from('facturacion f ')
                ->join('sys_clients c','f.pvcl_id = c.id_client')
                ->where('f.factura_id',$factura)
                ->get();
        
        return $result->row();
    }
 
    function InfoNote($nota){
        $result = $this->db->select('*')
                ->from('sys_nota_credito')
                ->where('id_nota_credito',$nota)
                ->get();
        return $result->row();
    }
    
    
    function InfoPptoFact($ppto,$factura){
        $result = $this->db->select('*')
                ->from('view_factura_presupuesto')
                ->where('factura_id',$factura)
                ->where('ppto',$ppto)
                ->get();
        return $result->row();
    }
    
    function InfoNoteDetail($nota){
        $result = $this->db->select('*')
                ->from('sys_nota_credito_detalle')
                ->where('id_nota_credito',$nota)
                ->get();
        return $result->result();
    }
    
    function InfoCab($id_nota){
        $result = $this->db->select('n.*,f.*,c.camp_nombre as campana,(f.factura_impresion < "2019-12-02") AS old')
                ->from('sys_nota_credito n')
                ->join('facturacion f ',' n.factura = f.factura_id ')
                ->join('cat_campanas c','c.camp_id = f.camp_id')
                ->where('n.id_nota_credito',$id_nota)
                ->get();
         
        return $result->row();
    }
    
    function GetTotalNc($nota){
        $result = $this->db->select('id_detalle,id_nota_credito,ppto,tipo,SUM(valor_bruto) AS bruto,SUM(if(d.tipo <> "interna",descuento,0))AS descuento_externa,SUM(if(d.tipo = "interna",descuento,0)) AS descuento_interna,SUM(iva) AS iva,SUM(spa) AS bruto_spa,SUM(iva_spa) AS iva_spa,SUM(total) AS total,SUM(if(iva > 0,(valor_bruto - descuento),0)) AS imp_iva')
                ->from('sys_nota_credito_detalle d')
                ->where('d.id_nota_credito',$nota)
                ->get();
        return $result->row();
    }
    
    function ListaDetailBill($nota,$bill){
        
        $result = $this->db->select('*')
                ->from('view_nota_presupuesto d')
                ->where('d.id_nota_credito', $nota)
                ->where('d.factura_id', $bill)
                ->get();

        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function GetCabPpto($ppto,$modulo){
        
        $result = $this->db->select('*')
                ->from('all_presup')
                ->where('id', $ppto)
                ->where('modulo', $modulo)
                ->get();

        return $result->row();
    }
    
    function OtherLines($nota){
        $result = $this->db->select("sum(if(tipo <> 'interna',if(spa > 0,1,0),0)) as count")
                ->from('sys_nota_credito_detalle n')
                ->where('n.id_nota_credito', $nota)
                ->get();

        return $result->row();
    }
    
    function UpdateNote($note,$data){
        //$this->db =  $this->load->database('go', TRUE);
        $this->db->where('id_nota_credito',$note);
        $this->db->update('sys_nota_credito',$data);
    }
   
}
