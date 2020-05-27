<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Bill extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function ListBill($ini = false,$fin = false,$order_by,$factura,$cliente,$f_ini, $f_fin){
        if($fin && $fin != '-1')
            $this->db->limit($fin, $ini);
        
        if($factura != "all")
            $this->db->where("factura_id",$factura);
        
        if($cliente != "all")
            $this->db->where("id_cliente",$cliente);
        
        if($f_ini != "all")
            $this->db->where("fecha between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY) ");
        
        
        $result = $this->db->select('*')
                ->from('view_facturas')
                ->order_by('factura_id',$order_by)
                ->get();
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function SelectBill($factura = false, $cliente = false,$f_ini = false, $f_fin = false){
        
        if($factura != "all")
            $this->db->where("factura_id",$factura);
        
        if($cliente != "all")
            $this->db->where("id_cliente",$cliente);
        
        if($f_ini != "all")
            $this->db->where("fecha between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY)  ");
        
        $result = $this->db->select('*')
                ->from('view_facturas')
                ->get();
       
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function InfoBill($factura){
        $result = $this->db->select('*')
                ->from('view_facturas')
                ->where("factura_id",$factura)
                ->get();
       
        return $result->row();
    }
    
    function InfoVal($factura){
        $result = $this->db->select('*')
                ->from('valores_facturas')
                ->where("factura_id",$factura)
                ->get();
       
        return array("result"=>$result->row(),"num"=>$result->num_rows());
    }
    
    function UpdataBill($factura_id,$data){
        $this->db->where('factura_id',$factura_id);
        $this->db->update('facturacion',$data);
    }
    
    function Retencion($id = false){
        
        if($id)
            $this->db->where('rete_id',$id);
        
        $result = $this->db->select('*')
                ->from('cat_retefuente')
                ->get();
       
        return $result->result();
    }
    
    function InfoValues($factura){
        $result = $this->db->select('*')
                ->from('valores_facturas')
                ->where("factura_id",$factura)
                ->get();
       
        return $result->row();
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
    
    function InfoDpto($name){
        $result = $this->db->select('*')
                ->from('sys_departamento')
                ->where("nombre",$name)
                ->get();
       
        return $result->row();
    }
    
    function InfoCity($name,$departamento){
        $result = $this->db->select('*')
                ->from('sys_ciudades')
                ->where("nombre",$name)
                ->where("departamento",$departamento)
                ->get();
       
        return $result->row();
    }
    
    function GetCabPpto($ppto,$modulo){
        $result = $this->db->select('*')
                ->from('all_presup')
                ->where('id', $ppto)
                ->where('modulo', $modulo)
                ->get();

        return $result->row();
    }
    
    function ListaDetailBill($factura){
        
        $result = $this->db->select('*')
                ->from('view_factura_presupuesto')
                ->where('factura_id', $factura)
                ->get();

        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function DeleteDetail($id_detalle, $ppto, $tipo){
        $this->db->where('factura_presupid',$id_detalle);
        $result = $this->db->delete('factura_presup');
        
        if($result){
            $this->M_Bill->UpdateStatusPpto($ppto, $tipo, 5);
            
            return array('res'=>'OK','id'=>$this->db->insert_id());
        }else{
            return array('res'=>"Error: ".$this->db->last_query());
        }
    }
    
    function CreateNote($data){
        $result = $this->db->insert('sys_nota_credito', $data);
        if($result){
            return $this->db->insert_id();
        }else{
            return "Error: ".$this->db->last_query();
        }
    }
    
    function CreateNoteDetail($data){
        $result = $this->db->insert('sys_nota_credito_detalle', $data);
        if($result){
            return "OK";
        }else{
            return "Error: ".$this->db->last_query();
        }
    }
        
    function UpdatePpto($tabla,$where,$id,$campo,$estado){
        $this->db->where($where,$id);
        $this->db->update($tabla,array($campo=>$estado));
    }
    
    function UpdateDetalleFactura($factura_presupid){
        $this->db->where('factura_presupid',$factura_presupid);
        $this->db->update('factura_presup',array('nota'=>1));
    }
    
    function getResolution($id){
        $result = $this->db->select('*')
                ->from('cat_resoluciones')
                ->where("resol_id",$id)
                ->get();
       
        return $result->row();
    }
    
    function getPpto($id){
        $result = $this->db->select('*')
                ->from('all_presup')
                ->where("id",$id)
                ->get();
       
        return $result->row();
    }
    
    function UpdateInfo($factura_id,$data){
        $this->db->where('factura_id', $factura_id);
        $result = $this->db->update('facturacion', $data);
      
        if($result){
            $res = "OK";
        }else{
            $res = "ERROR ".$this->db->last_query();
        }
        return $res;
    }
    
    function SaveFile($data){
        $result = $this->db->insert('sys_adjunto_factura', $data);
        
        if($result){
            $res = "OK";
        }else{
            $res = "ERROR ".$this->db->last_query();
        }
        return $res;
    }
    
    function InsertInfo($data){
        $result = $this->db->insert('facturacion', $data);
        
        if($result){
            $res = array('res'=>"OK",'id'=>$this->db->insert_id());
        }else{
            $res = array('res'=>"ERROR ".$this->db->last_query());
        }
        return $res;
    }
    
    function deleteAdjunto($id,$ruta){
        $this->db->where('id',$id);
        $result = $this->db->delete('sys_adjunto_factura');
        
        if($result){
            unlink(dirname(__FILE__) . '/../../../Adjuntos/FACTURAS/'.$ruta);
            $res = array('res'=>"OK");
        }else{
            $res = array('res'=>"ERROR ".$this->db->last_query());
        }
        return $res;
    }
    
    function sizeFile($factura_id){
        $result = $this->db->select('ifnull(SUM(size),0) as total')
                ->from('sys_adjunto_factura')
                ->where('factura_id', $factura_id)
                ->get();
        return $result->row();
    }
    
    function ListaAdjuntos($factura_id){
        $result = $this->db->select('*')
                ->from('sys_adjunto_factura')
                ->where('factura_id', $factura_id)
                ->get();
        return $result->result();
    }
    
    function GetCategorias($id = false) {

        if ($id)
            $this->db->where('id_categoria', $id);

        $result = $this->db->select('*')
                ->from('sys_categoria')
                ->like('tipo', 'P')
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }
    
    function ListarType($table,$client,$campain){
        $result = $this->db->select('*')
                ->from('view_' . $table)
                ->where('id_client',$client)
                ->where('id_campain',$campain)
                ->where_in('id_status',array(1,5))
                ->order_by('id', 'desc')
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }
    
    function GetPptoInfo($tipo, $ppto) {

        switch ($tipo) {
            case "1":
                $result = $this->db->select('psav_id AS id,a.psav_fecha as fecha,psav_valor as valor,psav_total as total,a.num_impresiones as impresiones,'
                                . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio, a.psav_numorden as orden,a.psav_numcotizacion as cotizacion,psav_observacion as observacion,psav_desc as descuento,psav_iva as iva, psav_ivaspa AS porcentaje_iva_spa,psav_spa as porcentaje_spa  ')
                        ->from('presup_avisos a')
                        ->where('psav_id', $ppto)
                        ->order_by('a.psav_id', 'desc')
                        ->get();
                break;
            case "2":
                $result = $this->db->select('c.pscf_id AS id,c.pscf_fecha as fecha,c.pscf_valor as valor,c.pscf_total as total,c.num_impresiones as impresiones,'
                                . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto,  pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,c.pscf_numorden as orden,c.pscf_numcotizacion as cotizacion,c.pscf_observacion as observacion,c.pscf_desc as descuento,c.pscf_iva as iva, c.pscf_ivaspa AS porcentaje_iva_spa,c.pscf_spa as porcentaje_spa ')
                        ->from('presup_clasificados c')
                        ->where('pscf_id', $ppto)
                        ->order_by('c.pscf_id', 'desc')
                        ->get();
                break;
            case "3":
                $result = $this->db->select('c.psrev_id AS id,c.psrev_fecha as fecha,c.psrev_valor as valor,c.psrev_total as total,c.num_impresiones as impresiones,'
                                . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto,  pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,c.psrev_numorden as orden,c.psrev_numcotizacion as cotizacion,c.psrev_observa as observacion,c.psrev_desc as descuento,c.psrev_iva as iva, c.psrev_ivaspa AS porcentaje_iva_spa,c.psrev_spa as porcentaje_spa ')
                        ->from('presup_revis c')
                        ->where('psrev_id', $ppto)
                        ->order_by('c.psrev_id', 'desc')
                        ->get();
                break;
            case "4":
                $result = $this->db->select('psrad_id AS id,psrad_fecha as fecha ,psrad_valor as valor,psrad_total as total,r.num_impresiones as impresiones, '
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto,  pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,r.psrad_numorden as orden,r.psrad_numcotizacion as cotizacion,psrad_observa as observacion,psrad_desc as descuento,psrad_iva as iva, psrad_ivaspa AS porcentaje_iva_spa,psrad_spa as porcentaje_spa')
                        ->from('presup_radio r')
                        ->where('psrad_id', $ppto)
                        ->order_by('r.psrad_id', 'desc')
                        ->get();
                
                break;
            case "5":
                $result = $this->db->select('pstv_id AS id,pstv_valor as valor,pstv_total as total,pstv_fecha as fecha,tv.num_impresiones as impresiones,'
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,tv.pstv_numorden as orden,pstv_numcotizacion as cotizacion,pstv_observacion_presup as observacion,pstv_desc as descuento,pstv_iva as iva, pstv_ivaspa AS porcentaje_iva_spa,pstv_spa as porcentaje_spa')
                        ->from('presup_tv tv')
                        ->where('pstv_id', $ppto)
                        ->order_by('tv.pstv_id', 'desc')
                        ->get();
                break;
            case "6":
                $result = $this->db->select('psex_id AS id,psex_valor as valor,psex_total as total,psex_fecha as fecha,num_impresiones as impresiones,'
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,psex_numorden as orden,psex_numcotizacion as cotizacion,psex_observacion as observacion,psex_desc as descuento,psex_iva as iva, psex_ivaspa AS porcentaje_iva_spa,psex_spa as porcentaje_spa')
                        ->from('presup_prode et')
                        ->where('psex_id', $ppto)
                        ->order_by('et.psex_id', 'desc')
                        ->get();
                break;
            case "7":
               $result = $this->db->select('psin_id AS id,i.psin_fechpresup as fecha,psin_valor as valor,psin_desc as descuento,psin_iva as iva,psin_total as total,i.num_impresiones as impresiones,'
                                . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, "" as id_proveedor, cod_ser as id_servicio,i.psin_numorden as orden, i.psin_numcotizacion as cotizacion,psin_observa as observacion,psin_iva AS porcentaje_iva_spa ')
                        ->from('presup_prodi i')
                        ->where('psin_id', $ppto)
                        ->order_by('i.psin_id', 'desc')
                        ->get();

                break;
            case "8":
                $result = $this->db->select('pubext_id AS id,pubext_valor as valor,pubext_total as total,pubext_fecha as fecha,num_impresiones as impresiones,'
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,pubext_numorden as orden,pubext_numcotizacion as cotizacion,pubext_observacion as observacion,pubext_desc as descuento,pubext_iva as iva, pubext_ivaspa AS porcentaje_iva_spa,pubext_spa as porcentaje_spa')
                        ->from('publicidad_exterior pe')
                        ->where('pubext_id', $ppto)
                        ->order_by('pe.pubext_id', 'desc')
                        ->get();
                break;
            case "9":
                $result = $this->db->select('imp_id AS id,imp_valor as valor,imp_total as total,imp_fecha as fecha,num_impresiones as impresiones,'
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio,imp_numorden as orden,imp_numcotizacion as cotizacion,imp_observacion as observacion,imp_desc as descuento,imp_iva as iva, imp_ivaspa AS porcentaje_iva_spa,imp_spa as porcentaje_spa')
                        ->from('impresos im')
                        ->where('imp_id', $ppto)
                        ->order_by('imp_id', 'desc')
                        ->get();
                break;
            case "10":
                $result = $this->db->select('artp_id AS id,artp_valor as valor,artp_total as total,artp_fecha as fecha,num_impresiones as impresiones,'
                        . ' pvcl_id_clie as id_cliente,camp_id as id_campana,pdcl_id as id_producto, pvcl_id_prov as id_proveedor, tpsv_id as id_servicio, artp_numorden as orden,artp_numcotizacion as cotizacion,artp_observacion as observacion,artp_desc as descuento,artp_iva as iva, artp_ivaspa AS porcentaje_iva_spa,artp_spa as porcentaje_spa')
                        ->from('art_publi ap')
                        ->where('artp_id', $ppto)
                        ->order_by('artp_id', 'desc')
                        ->get();
                break;
            default:
                break;
        }


        return $result->row();
    }
   
    function AddDetail($factura_id, $data, $ppto,$tipo){
        $result = $this->db->insert('factura_presup', $data);
        if($result){
            $this->M_Bill->UpdateStatusPpto($ppto, $tipo, 7);
            
            return array('res'=>'OK','id'=>$this->db->insert_id());
        }else{
            return array('res'=>"Error: ".$this->db->last_query());
        }
    }
    
    function UpdateStatusPpto($id, $type, $status) {
        switch ($type) {
            case 1:
                $data = array('psav_estado' => $status);
                $this->db->where('psav_id', $id);
                $table = 'presup_avisos';
                break;
            case 2:
                $data = array('pscf_estado' => $status);
                $this->db->where('pscf_id', $id);
                $table = 'presup_clasificados';
                break;
            case 3:
                $data = array('psrev_estado' => $status);
                $this->db->where('psrev_id', $id);
                $table = 'presup_revis';
                break;
            case 4:
                $data = array('psrad_estado' => $status);
                $this->db->where('psrad_id', $id);
                $table = 'presup_radio';
                break;
            case 5:
                $data = array('pstv_estado' => $status);
                $this->db->where('pstv_id', $id);
                $table = 'presup_tv';
                break;
            case 6:
                $data = array('psex_estado' => $status);
                $this->db->where('psex_id', $id);
                $table = 'presup_prode';
                break;
            case 7:
                $data = array('psin_estado' => $status);
                $this->db->where('psin_id', $id);
                $table = 'presup_prodi';
                break;
            case 8:
                $data = array('est_id' => $status);
                $this->db->where('pubext_id', $id);
                $table = 'publicidad_exterior';
                break;
            case 9:
                $data = array('est_id' => $status);
                $this->db->where('imp_id', $id);
                $table = 'impresos';
                break;
            case 10:
                $data = array('est_id' => $status);
                $this->db->where('artp_id', $id);
                $table = 'art_publi';
                break;

            default:
                break;
        }

        $result = $this->db->update($table, $data);
        if ($result) {
            return 'OK';
        } else {
            return 'Error: ' . $this->db->last_query();
        }
    }
    
    function UpdateBill($bill,$data){
        
        $this->db->where('factura_id',$bill);
        $this->db->update('facturacion',$data);
    }
    
    function OtherLines($bill){
        $result = $this->db->select("sum(if(modulo_id <> 7,if(vlr_spa > 0,1,0),0)) as count")
                ->from('factura_presup n')
                ->where('n.factura_id', $bill)
                ->get();

        return $result->row();
    }
    
    function CabBill($bill){
        $result = $this->db->select("c.nombre AS cliente,c.documento,c.direccion, ca.camp_nombre AS campana,f.*, u.name AS usuario")
                ->from('facturacion f')
                ->join('sys_clients c','f.pvcl_id = c.id_client','left')
                ->join('cat_campanas ca','f.camp_id = ca.camp_id','left')
                ->join('sys_users u','f.usr_id = u.id_users','left')
                ->where('f.factura_id', $bill)
                ->get();

        return $result->row();
    }
    
    function SelectAdjunto($bill){
        $result = $this->db->select('*')
                ->from('sys_adjunto_factura')
                ->where('factura_id',$bill)
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }
}
