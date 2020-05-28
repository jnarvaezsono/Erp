<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_manager extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function GetCategorias($id = false) {

        if ($id)
            $this->db->where('id_categoria', $id);

        $result = $this->db->select('*')
                ->from('sys_categoria')
                ->like('tipo', 'P')
                ->or_like('tipo', 'O')
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }
    
    function GetOrden($id){
        $result = $this->db->select('*')
                ->from('ordenes')
                ->where('ord_id',$id)
                ->get();
        
        return array("row" => $result->row(), "num" => $result->num_rows());
    }

    function SelectType($table, $id = false) {
        
        if($table == 'orden' || $table == '')
            return array("result" => array(), "num" => 0);
        
        if ($id != 'all')
            $this->db->where("id", $id);


        $result = $this->db->select('*')
                ->from('view_' . $table)
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function ListarType($ini = false, $fin = false, $table, $id) {
        if($table == 'orden' || $table == '')
            return array("result" => array(), "num" => 0);
            
        
        if ($fin)
            $this->db->limit($fin, $ini);

        if ($id != 'all')
            $this->db->where("id", $id);


        $result = $this->db->select('*')
                ->from('view_' . $table)
                ->order_by('date', 'desc')
                ->get();
        
        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function EnableRow() {

        $this->db->where($this->field_id, $this->id);

        $data = array(
            "num_impresiones" => '-1',
            $this->field_status => $this->status
        );

        $result = $this->db->update($this->table, $data);

        if ($result) {
            return "OK";
        } else {
            return "Error " . $this->db->last_query();
        }
    }

    function DisableRow() {

        $this->db->where($this->field_id, $this->id);

        $data = array(
            $this->field_status => $this->status
        );

        $result = $this->db->update($this->table, $data);

        if ($result) {
            return "OK";
        } else {
            return "Error " . $this->db->last_query();
        }
    }

    function GetPpto($ppto, $tipo, $tabla) {
        switch ($tipo) {
            case "1":
                $result = $this->db->select('psav_id AS id,e.est_nombre AS estado,psav_valor as valor,psav_total as total, e.est_id as id_estado,psav_iva as iva,psav_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, psav_numorden as orden_cliente, psav_observacion as observacion,psav_spa as spa,psav_ivaspa as iva_spa,psav_numcotizacion as cotizacion, a.medio_id as medio')
                        ->from($tabla.' a')
                        ->join('cat_estados e', 'a.psav_estado = e.est_id')
                        ->where('psav_id', $ppto)
                        ->get();
                break;
            case "2":
                $result = $this->db->select('pscf_id AS id,e.est_nombre AS estado,pscf_valor as valor,pscf_total as total, e.est_id as id_estado,pscf_iva as iva,pscf_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, pscf_numorden as orden_cliente, pscf_observacion as observacion,pscf_spa as spa,pscf_ivaspa as iva_spa,pscf_numcotizacion as cotizacion, c.medio_id as medio')
                        ->from($tabla.' c')
                        ->join('cat_estados e', 'c.pscf_estado = e.est_id')
                        ->where('pscf_id', $ppto)
                        ->get();
                break;
            case "3":
                $result = $this->db->select('psrev_id AS id,e.est_nombre AS estado,psrev_valor as valor,psrev_total as total, e.est_id as id_estado,psrev_iva as iva,psrev_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, psrev_numorden as orden_cliente, psrev_observa as observacion,psrev_spa as spa,psrev_ivaspa as iva_spa,psrev_numcotizacion as cotizacion, re.medio_id as medio')
                        ->from($tabla.' re')
                        ->join('cat_estados e', 're.psrev_estado = e.est_id')
                        ->where('psrev_id', $ppto)
                        ->get();
                break;
            case "4":
                $result = $this->db->select('psrad_id AS id,e.est_nombre AS estado,psrad_valor as valor,psrad_total as total, e.est_id as id_estado,psrad_iva as iva,psrad_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, psrad_numorden as orden_cliente, psrad_observa as observacion,psrad_spa as spa,psrad_ivaspa as iva_spa,psrad_numcotizacion as cotizacion')
                        ->from($tabla.' r')
                        ->join('cat_estados e', 'r.psrad_estado = e.est_id')
                        ->where('psrad_id', $ppto)
                        ->get();
                break;
            case "5":
                $result = $this->db->select('pstv_id AS id,e.est_nombre AS estado,pstv_valor as valor,pstv_total as total, e.est_id as id_estado,pstv_iva as iva,pstv_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, pstv_numorden as orden_cliente, pstv_observacion_presup as observacion,pstv_spa as spa,pstv_ivaspa as iva_spa,pstv_numcotizacion as cotizacion, valp_id_medio as medio')
                        ->from($tabla.' tv')
                        ->join('cat_estados e', 'tv.pstv_estado = e.est_id')
                        ->where('pstv_id', $ppto)
                        ->get();
                break;
            case "6":
                $result = $this->db->select('psex_id AS id,et.psex_formapago as forma_pago,e.est_nombre AS estado,psex_valor as valor,psex_total as total, e.est_id as id_estado,psex_iva as iva,psex_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, psex_numorden as orden_cliente, psex_observacion as observacion,psex_spa as spa,psex_ivaspa as iva_spa,psex_numcotizacion as cotizacion')
                        ->from($tabla.' et')
                        ->join('cat_estados e', 'et.psex_estado = e.est_id')
                        ->where('psex_id', $ppto)
                        ->get();
                break;
            case "7":
                $result = $this->db->select('psin_id AS id,e.est_nombre AS estado,psin_valor as valor,psin_total as total,psin_iva as iva,psin_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, cod_ser as servicio, psin_numorden as orden_cliente, psin_observa as observacion, e.est_id as id_estado,psin_numcotizacion as cotizacion')
                        ->from($tabla.' i')
                        ->join('cat_estados e', 'i.psin_estado = e.est_id')
                        ->where('psin_id', $ppto)
                        ->get();
                break;
            case "8":
                $result = $this->db->select('pubext_id AS id,e.est_nombre AS estado,pubext_valor as valor,pubext_total as total, e.est_id as id_estado,pubext_iva as iva,pubext_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, pubext_numorden as orden_cliente, pubext_observacion as observacion,pubext_spa as spa,pubext_ivaspa as iva_spa,pubext_numcotizacion as cotizacion')
                        ->from($tabla.' pe')
                        ->join('cat_estados e', 'pe.est_id = e.est_id')
                        ->where('pubext_id', $ppto)
                        ->get();
                break;
            case "9":
                $result = $this->db->select('imp_id AS id,e.est_nombre AS estado,imp_valor as valor,imp_total as total, e.est_id as id_estado,imp_iva as iva,imp_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, imp_numorden as orden_cliente, imp_observacion as observacion,imp_spa as spa,imp_ivaspa as iva_spa,imp_numcotizacion as cotizacion')
                        ->from($tabla.' im')
                        ->join('cat_estados e', 'im.est_id = e.est_id')
                        ->where('imp_id', $ppto)
                        ->get();
                break;
            case "10":
                $result = $this->db->select('artp_id AS id,e.est_nombre AS estado,artp_valor as valor,artp_total as total, e.est_id as id_estado,artp_iva as iva,artp_desc as descuento,pvcl_id_clie as cliente, pvcl_id_prov as proveedor, pdcl_id as producto, camp_id as campana, tpsv_id as servicio, artp_numorden as orden_cliente, artp_observacion as observacion,artp_spa as spa,artp_ivaspa as iva_spa,artp_numcotizacion as cotizacion')
                        ->from($tabla.' ap')
                        ->join('cat_estados e', 'ap.est_id = e.est_id')
                        ->where('artp_id', $ppto)
                        ->get();
                break;
            default:
                break;
        }

        return $result->row();
    }

    function ListDetailPpto($id, $tipo, $pre_order = false) {
        switch ($tipo) {
            case "1":
                if(!$pre_order){
                    $this->db->where('d.psav_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('detavi_id as id_detalle,detavi_titulo as titulo,detavi_tarifa as tarifa,detavi_total as total,detavi_tamano as tamano')
                        ->from('det_avisos d ')
                        ->get();
                break;
            case "2":
                
                if(!$pre_order){
                    $this->db->where('d.pscf_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                
                $result = $this->db->select('dclasi_id as id_detalle,dclasi_seccion as seccion,dclasi_detalle as detalle, dclasi_total as total')
                        ->from('det_clasi d ')
                        ->get();
                break;
            case "3":
                if(!$pre_order){
                    $this->db->where('d.psrev_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('drevis_id as id_detalle,drevis_titulo as titulo,drevis_detalle as detalle, drevis_total as total')
                        ->from('det_revis d ')
                        ->get();
                break;
            case "4":
                if(!$pre_order){
                    $this->db->where('d.psrad_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('drad_id as id_detalle,drad_frecuencia as frecuencia,drad_tarifa as tarifa,drad_total as total,emis_nombre as emisora, progr_nombre as programa')
                        ->from('det_radio d ')
                        ->join('cat_emisoras e', 'd.emis_id = e.emis_id', 'left')
                        ->join('cat_programasr r', 'd.progr_id = r.progr_id', 'left')
                        ->get();
                break;
            case "5":
                if(!$pre_order){
                    $this->db->where('d.pstv_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('dtv_id as id_detalle,dtv_programa as programa,dtv_tarifa as tarifa,dtv_total as total,dtv_fechasalida as fecha, dtv_franja as franja')
                        ->from('det_tv d ')
                        ->get();
                break;
            case "6":
                if(!$pre_order){
                    $this->db->where('d.psex_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('dprode_id as id_detalle,dprode_valor as total,dprode_detalle as detalle,d.ordcos_id AS orden_costo')
                        ->from('det_prode d ')
                        ->get();
                break;
            case "7":
                if(!$pre_order){
                    $this->db->where('d.psin_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('d.dpsin_id AS id_detalle,d.dpsin_valor AS valor,d.dpsin_detalle AS detalle,d.psin_id AS ppto,d.dpsin_cant AS cantidad,
                                            d.ordcos_id AS orden_costo,d.dpsin_total AS total,d.dpsin_ordaumento as aumento,d.dpsin_observ AS observacion,d.unidad,t.nombre AS servicio')
                        ->from('det_prodi d ')
                        ->join('sys_tipo_servicio t', 'd.tpsv_id = t.id_tipo_servicio', 'left')
                        ->get();
                break;
            case "8":
                if(!$pre_order){
                    $this->db->where('d.pubext_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('dpubext_id as id_detalle,p.pieza_nombre as pieza,dpubext_vlruni as valor,dpubext_total as total')
                        ->from('det_pubext d ')
                        ->join('cat_piezas p', 'd.pieza_id = p.pieza_id', 'left')
                        ->get();
                break;
            case "9":
                if(!$pre_order){
                    $this->db->where('d.imp_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('dimp_id as id_detalle,p.elem_nombre as elemento,dimp_valor as valor,dimp_total as total,dimp_cantidad as cantidad')
                        ->from('det_impresos d ')
                        ->join('cat_elementos p', 'd.elemento_id = p.elem_id', 'left')
                        ->get();
                break;
            case "10":
                if(!$pre_order){
                    $this->db->where('d.artp_id', $id);
                }else{
                    $this->db->where('d.id_preorden', $id);
                }
                $result = $this->db->select('dartp_id as id_detalle,dartp_valor as valor,dartp_total as total,dartp_cantidad as cantidad,dartp_producto as producto')
                        ->from('det_artpub d ')
                        ->get();
                break;
            default:
                break;
        }

        return $result->result();
    }

    function GetPptoCompleteInfo($ini = false, $fin = false, $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor) {

        if ($fin)
            $this->db->limit($fin, $ini);

        switch ($tipo) {
            case "1":

                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('psav_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', trim($this->input->get('search[value]')));
                    $this->db->or_like('psav_total', trim($this->input->get('search[value]')));
                    $this->db->or_like('c.nombre', trim($this->input->get('search[value]')));
                    $this->db->or_like('ca.camp_nombre', trim($this->input->get('search[value]')));
                    $this->db->or_like('u.usr_nombre', trim($this->input->get('search[value]')));
                    $this->db->or_like('p.nombre', trim($this->input->get('search[value]')));
                }

                if ($ppto != 'all')
                    $this->db->where('psav_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('a.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("a.psav_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('psav_id AS id,a.psav_fecha as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,psav_valor as valor,psav_total as total,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,a.num_impresiones as impresiones,'
                                . 'a.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,a.psav_numorden as orden,s.nombre as servicio,a.psav_numcotizacion as cotizacion,psav_observacion as observacion,me.medio_nombre as medio,psav_desc as descuento,psav_iva as iva, psav_ivaspa AS porcentaje_iva_spa,psav_spa as porcentaje_spa  ')
                        ->from('presup_avisos a')
                        ->join('cat_estados e', 'a.psav_estado = e.est_id')
                        ->join('sys_clients c ', 'a.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'a.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'a.camp_id = ca.camp_id')
                        ->join('usuarios u', 'a.usr_id_crea = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'a.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'a.tpsv_id = s.id_tipo_servicio', 'left')
                        ->join('cat_medios me', 'a.medio_id = me.medio_id', 'left')
                        ->order_by('a.psav_id', 'desc')
                        ->get();
                break;
            case "2":

                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('pscf_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('pscf_total', $this->input->get('search[value]'));
                    $this->db->or_like('cl.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('pscf_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('c.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("c.pscf_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('c.pscf_id AS id,c.pscf_fecha as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,c.pscf_valor as valor,c.pscf_total as total,cl.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,c.num_impresiones as impresiones,'
                                . 'c.pvcl_id_clie,pr.pdcl_nombre as producto,cl.documento,p.documento as nit_proveedor,c.pscf_numorden as orden,s.nombre as servicio,c.pscf_numcotizacion as cotizacion,c.pscf_observacion as observacion,me.medio_nombre as medio,c.pscf_desc as descuento,c.pscf_iva as iva, c.pscf_ivaspa AS porcentaje_iva_spa,c.pscf_spa as porcentaje_spa ')
                        ->from('presup_clasificados c')
                        ->join('cat_estados e', 'c.pscf_estado = e.est_id')
                        ->join('sys_clients cl ', 'c.pvcl_id_clie = cl.id_client')
                        ->join('sys_clients p ', 'c.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'c.camp_id = ca.camp_id')
                        ->join('usuarios u', 'c.usr_id = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'c.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'c.tpsv_id = s.id_tipo_servicio', 'left')
                        ->join('cat_medios me', 'c.medio_id = me.medio_id', 'left')
                        ->order_by('c.pscf_id', 'desc')
                        ->get();
                break;
            case "3":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('psrev_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('psrev_total', $this->input->get('search[value]'));
                    $this->db->or_like('cl.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('psrev_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('c.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("c.psrev_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('c.psrev_id AS id,c.psrev_fecha as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,c.psrev_valor as valor,c.psrev_total as total,cl.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,c.num_impresiones as impresiones,'
                                . 'c.pvcl_id_clie,pr.pdcl_nombre as producto,p.documento as nit_proveedor,cl.documento,c.psrev_numorden as orden,s.nombre as servicio,c.psrev_numcotizacion as cotizacion,c.psrev_observa as observacion,me.medio_nombre as medio,c.psrev_desc as descuento,c.psrev_iva as iva, c.psrev_ivaspa AS porcentaje_iva_spa,c.psrev_spa as porcentaje_spa ')
                        ->from('presup_revis c')
                        ->join('cat_estados e', 'c.psrev_estado = e.est_id')
                        ->join('sys_clients cl ', 'c.pvcl_id_clie = cl.id_client')
                        ->join('sys_clients p ', 'c.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'c.camp_id = ca.camp_id')
                        ->join('usuarios u', 'c.usr_id_crea = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'c.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'c.tpsv_id = s.id_tipo_servicio', 'left')
                        ->join('cat_medios me', 'c.medio_id = me.medio_id', 'left')
                        ->order_by('c.psrev_id', 'desc')
                        ->get();
                break;
            case "4":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('psrad_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('psrad_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('psrad_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('r.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("r.psrad_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('psrad_id AS id,psrad_fecha as fecha ,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,psrad_valor as valor,psrad_total as total,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,r.num_impresiones as impresiones, '
                                . 'r.pvcl_id_clie,pr.pdcl_nombre as producto,p.documento as nit_proveedor,c.documento,r.psrad_numorden as orden,s.nombre as servicio,r.psrad_numcotizacion as cotizacion,psrad_observa as observacion,psrad_desc as descuento,psrad_iva as iva, psrad_ivaspa AS porcentaje_iva_spa,psrad_spa as porcentaje_spa')
                        ->from('presup_radio r')
                        ->join('cat_estados e', 'r.psrad_estado = e.est_id')
                        ->join('sys_clients c ', 'r.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'r.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'r.camp_id = ca.camp_id')
                        ->join('usuarios u', 'r.usr_id = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'r.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'r.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('r.psrad_id', 'desc')
                        ->get();

                break;
            case "5":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('pstv_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('pstv_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('pstv_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('tv.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("tv.pstv_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('pstv_id AS id,e.est_nombre AS estado,pstv_valor as valor,pstv_total as total,pstv_fecha as fecha,e.est_color,e.est_id as id_estado,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,tv.num_impresiones as impresiones,'
                                . 'tv.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,tv.pstv_numorden as orden,s.nombre as servicio,pstv_numcotizacion as cotizacion,pstv_observacion_presup as observacion,pstv_desc as descuento,pstv_iva as iva, pstv_ivaspa AS porcentaje_iva_spa,pstv_spa as porcentaje_spa')
                        ->from('presup_tv tv')
                        ->join('cat_estados e', 'tv.pstv_estado = e.est_id')
                        ->join('sys_clients c ', 'tv.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'tv.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'tv.camp_id = ca.camp_id')
                        ->join('usuarios u', 'tv.usr_id_crea = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'tv.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'tv.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('tv.pstv_id', 'desc')
                        ->get();
                break;
            case "6":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('psex_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('psex_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('psex_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('et.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("et.psex_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('psex_id AS id,e.est_nombre AS estado,psex_valor as valor,psex_total as total,psex_fecha as fecha,e.est_color,e.est_id as id_estado,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,num_impresiones as impresiones,'
                                . 'et.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,psex_numorden as orden,s.nombre as servicio,psex_numcotizacion as cotizacion,psex_observacion as observacion,psex_desc as descuento,psex_iva as iva, psex_ivaspa AS porcentaje_iva_spa,psex_spa as porcentaje_spa')
                        ->from('presup_prode et')
                        ->join('cat_estados e', 'et.psex_estado = e.est_id')
                        ->join('sys_clients c ', 'et.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'et.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'et.camp_id = ca.camp_id')
                        ->join('usuarios u', 'et.usr_id_crea = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'et.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'et.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('et.psex_id', 'desc')
                        ->get();
                break;
            case "7":

                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('psin_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('psin_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('psin_id', $ppto);

                if ($fecha_ini != "all")
                    $this->db->where("i.psin_fechpresup between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('psin_id AS id,i.psin_fechpresup as fecha,e.est_nombre AS estado,e.est_color,e.est_id as id_estado,psin_valor as valor,psin_desc as descuento,psin_iva as iva,psin_total as total,c.nombre AS cliente,ca.camp_nombre AS campana,"SONOVISTA" AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,i.num_impresiones as impresiones,'
                                . 'i.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,i.psin_numorden as orden, s.nombre as servicio,i.psin_numcotizacion as cotizacion,psin_observa as observacion ')
                        ->from('presup_prodi i')
                        ->join('cat_estados e', 'i.psin_estado = e.est_id')
                        ->join('sys_clients c ', 'i.pvcl_id_clie = c.id_client')
                        ->join('cat_campanas ca ', 'i.camp_id = ca.camp_id')
                        ->join('usuarios u', 'i.usr_id_crea = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'i.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'i.cod_ser = s.id_tipo_servicio', 'left')
                        ->order_by('i.psin_id', 'desc')
                        ->get();

                break;
            case "8":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('pubext_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('pubext_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('pubext_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('et.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("et.pubext_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('pubext_id AS id,e.est_nombre AS estado,pubext_valor as valor,pubext_total as total,pubext_fecha as fecha,e.est_color,e.est_id as id_estado,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,num_impresiones as impresiones,'
                                . 'pe.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,pubext_numorden as orden,s.nombre as servicio,pubext_numcotizacion as cotizacion,pubext_observacion as observacion,pubext_desc as descuento,pubext_iva as iva, pubext_ivaspa AS porcentaje_iva_spa,pubext_spa as porcentaje_spa')
                        ->from('publicidad_exterior pe')
                        ->join('cat_estados e', 'pe.est_id = e.est_id')
                        ->join('sys_clients c ', 'pe.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'pe.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'pe.camp_id = ca.camp_id')
                        ->join('usuarios u', 'pe.usr_id = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'pe.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'pe.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('pe.pubext_id', 'desc')
                        ->get();
                break;
            case "9":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('imp_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('imp_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('imp_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('im.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("im.imp_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('imp_id AS id,e.est_nombre AS estado,imp_valor as valor,imp_total as total,imp_fecha as fecha,e.est_color,e.est_id as id_estado,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,num_impresiones as impresiones,'
                                . 'im.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,imp_numorden as orden,s.nombre as servicio,imp_numcotizacion as cotizacion,imp_observacion as observacion,imp_desc as descuento,imp_iva as iva, imp_ivaspa AS porcentaje_iva_spa,imp_spa as porcentaje_spa')
                        ->from('impresos im')
                        ->join('cat_estados e', 'im.est_id = e.est_id')
                        ->join('sys_clients c ', 'im.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'im.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'im.camp_id = ca.camp_id')
                        ->join('usuarios u', 'im.usr_id = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'im.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'im.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('imp_id', 'desc')
                        ->get();
                break;
            case "10":
                if (!empty($this->input->get('search[value]'))) {
                    $this->db->like('artp_id', $this->input->get('search[value]'));
                    $this->db->or_like('e.est_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('artp_total', $this->input->get('search[value]'));
                    $this->db->or_like('c.nombre', $this->input->get('search[value]'));
                    $this->db->or_like('ca.camp_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('u.usr_nombre', $this->input->get('search[value]'));
                    $this->db->or_like('p.nombre', $this->input->get('search[value]'));
                }

                if ($ppto != 'all')
                    $this->db->where('artp_id', $ppto);

                if ($proveedor != 'all')
                    $this->db->where('ap.pvcl_id_prov', $proveedor);

                if ($fecha_ini != "all")
                    $this->db->where("ap.artp_fecha between '$fecha_ini' AND DATE_ADD('$fecha_fin', INTERVAL 1 DAY) ");

                $result = $this->db->select('artp_id AS id,e.est_nombre AS estado,artp_valor as valor,artp_total as total,artp_fecha as fecha,e.est_color,e.est_id as id_estado,c.nombre AS cliente,ca.camp_nombre AS campana,p.nombre AS proveedor,concat(u.usr_nombre," ",u.usr_apellido) as usuario,num_impresiones as impresiones,'
                                . 'ap.pvcl_id_clie,pr.pdcl_nombre as producto,c.documento,p.documento as nit_proveedor,artp_numorden as orden,s.nombre as servicio,artp_numcotizacion as cotizacion,artp_observacion as observacion,artp_desc as descuento,artp_iva as iva, artp_ivaspa AS porcentaje_iva_spa,artp_spa as porcentaje_spa')
                        ->from('art_publi ap')
                        ->join('cat_estados e', 'ap.est_id = e.est_id')
                        ->join('sys_clients c ', 'ap.pvcl_id_clie = c.id_client')
                        ->join('sys_clients p ', 'ap.pvcl_id_prov = p.id_client', 'left')
                        ->join('cat_campanas ca ', 'ap.camp_id = ca.camp_id')
                        ->join('usuarios u', 'ap.usr_id = u.usr_id', 'left')
                        ->join('cat_prodsclies pr', 'ap.pdcl_id = pr.pdcl_id', 'left')
                        ->join('sys_tipo_servicio s', 'ap.tpsv_id = s.id_tipo_servicio', 'left')
                        ->order_by('artp_id', 'desc')
                        ->get();
                break;
            default:
                break;
        }


        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function GetDetailPpto($tipo, $ppto) {
        switch ($tipo) {
            case 1:
                $result = $this->db->select('d.*,t.tinta_nombre as tinta,p.pagina_nombre as pagina')
                        ->from('det_avisos d')
                        ->join('cat_tintas t', 'd.tinta_id = t.tinta_id', 'left')
                        ->join('cat_paginaperiod p', 'd.pagina_id = p.pagina_id', 'left')
                        ->where('d.psav_id', $ppto)
                        ->get();
                break;
            case 2:
                $result = $this->db->select('d.*')
                        ->from('det_clasi d')
                        ->where('d.pscf_id', $ppto)
                        ->get();
                break;
            case 3:
                $result = $this->db->select('d.*,t.tinta_nombre as tinta')
                        ->from('det_revis d')
                        ->join('cat_tintas t', 'd.tinta_id = t.tinta_id', 'left')
                        ->where('d.psrev_id', $ppto)
                        ->get();
                break;
            case 4:
                $result = $this->db->select('d.*,p.progr_nombre as programa, e.emis_nombre as emisora')
                        ->from('det_radio d')
                        ->join('cat_programasr p', 'd.progr_id = p.progr_id', 'left')
                        ->join('cat_emisoras e', 'd.emis_id = e.emis_id', 'left')
                        ->where('d.psrad_id', $ppto)
                        ->get();
                break;
            case 5:
                $result = $this->db->select('d.*')
                        ->from('det_tv d')
                        ->where('d.pstv_id', $ppto)
                        ->get();
                break;
            case 6:
                $result = $this->db->select('d.*')
                        ->from('det_prode d')
                        ->where('d.psex_id', $ppto)
                        ->get();
                break;
            case 7:
                $result = $this->db->select('dpsin_detalle as detalle,dpsin_cant as cantidad,dpsin_total as valor')
                        ->from('listado_detprodi')
                        ->where('psin_id', $ppto)
                        ->get();
                break;
            case 8:
                $result = $this->db->select('d.*,p.pieza_nombre as pieza')
                        ->from('det_pubext d')
                        ->join('cat_piezas p', 'd.pieza_id = p.pieza_id', 'left')
                        ->where('d.pubext_id', $ppto)
                        ->get();
                break;
            case 9:
                $result = $this->db->select('d.*,p.elem_nombre as elemento,c.concp_nmb as concepto')
                        ->from('det_impresos d')
                        ->join('cat_elementos p', 'd.elemento_id = p.elem_id', 'left')
                        ->join('cat_concepto c', 'd.concp_id = c.concp_id', 'left')
                        ->where('d.imp_id', $ppto)
                        ->get();
                break;
            case 10:
                $result = $this->db->select('d.*')
                        ->from('det_artpub d')
                        ->where('d.artp_id', $ppto)
                        ->get();
                break;

            default:
                break;
        }
        return $result->result();
    }

    function UpdateStatusPpto($tipo, $ppto, $status) {
        $this->db->trans_begin();

        switch ($tipo) {
            case 1:
                $rs = $this->db->select('*')
                                ->from('presup_avisos')
                                ->where('psav_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psav_estado, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['psav_estado'] = $status;
                }

                $this->db->where('psav_id', $ppto);
                $result = $this->db->update('presup_avisos', $data);
                break;
            case 2:
                $rs = $this->db->select('*')
                                ->from('presup_clasificados')
                                ->where('pscf_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->pscf_estado, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['pscf_estado'] = $status;
                }

                $this->db->where('pscf_id', $ppto);
                $result = $this->db->update('presup_clasificados', $data);
                break;
            case 3:
                $rs = $this->db->select('*')
                                ->from('presup_revis')
                                ->where('psrev_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psrev_estado, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['psrev_estado'] = $status;
                }

                $this->db->where('psrev_id', $ppto);
                $result = $this->db->update('presup_revis', $data);
                break;
            case 4:
                $rs = $this->db->select('*')
                                ->from('presup_radio')
                                ->where('psrad_id', $ppto)
                                ->get()->row();

                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psrad_estado, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['psrad_estado'] = $status;
                }

                $this->db->where('psrad_id', $ppto);
                $result = $this->db->update('presup_radio', $data);
                break;
            case 5:
                $rs = $this->db->select('*')
                                ->from('presup_tv')
                                ->where('pstv_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->pstv_estado, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['pstv_estado'] = $status;
                }

                $this->db->where('pstv_id', $ppto);
                $result = $this->db->update('presup_tv', $data);
                break;
            case 6:
                $rs = $this->db->select('*')
                                ->from('presup_prode')
                                ->where('psex_id', $ppto)
                                ->get()->row();

                if ($status == 9999) {
                    $det = $this->db->select('*')
                            ->from('det_prode')
                            ->where('psex_id', $ppto)
                            ->get();
                    foreach ($det->result() as $d) {
                        if ($d->ordcos_id != 0):
                            $orden = $this->db->select('*')
                                            ->from('ord_costos')
                                            ->where('ordcos_id', $d->ordcos_id)
                                            ->get()->row();
                            $v_cobrado = $orden->ordcos_vlrcobrado - $d->dprode_valor;
                            $v_faltante = $orden->ordcos_valor - $v_cobrado;

                            $data = array(
                                'ordcos_vlrcobrado' => $v_cobrado,
                                'ordcos_vlrfaltante' => ($v_faltante <= 0) ? '' : $v_faltante
                            );
                            if ($v_faltante <= 0) {
                                $data['est_id'] = 5;
                                $data['tpo_presup'] = '';
                            }

                            $porciones = explode(",", $orden->no_presup); // divido la cadena
                            $clave = array_search($ppto, $porciones); //busco la clave ó posicion del presupuesto
                            unset($porciones[$clave]); // Elimino el presupuesto
                            $cadena = implode(",", $porciones); //Armo la cadena
                            $data['no_presup'] = $cadena;

                            $this->db->where('ordcos_id', $d->ordcos_id);
                            $this->db->update('ord_costos', $data);
                        endif;
                    }
                }

                if (($status == 5 && $rs->psex_estado == 1)) {
                    $this->db->where('psex_id', $ppto);
                    $result = $this->db->update('presup_prode', array('psex_estado' => $status, 'num_impresiones' => $rs->num_impresiones + 1));
                } elseif ($status == 9999) {
                    $this->db->where('psex_id', $ppto);
                    $result = $this->db->update('presup_prode', array('psex_estado' => $status));
                }
                break;
            case 7:
                $rs = $this->db->select('*')
                                ->from('presup_prodi')
                                ->where('psin_id', $ppto)
                                ->get()->row();

                if ($status == 9999) {
                    $det = $this->db->select('*')
                            ->from('det_prodi')
                            ->where('psin_id', $ppto)
                            ->get();
                    foreach ($det->result() as $d) {
                        if ($d->ordcos_id != 0):
                            $orden = $this->db->select('*')
                                            ->from('ord_costos')
                                            ->where('ordcos_id', $d->ordcos_id)
                                            ->get()->row();
                            $v_cobrado = $orden->ordcos_vlrcobrado - $d->dpsin_valor;
                            $v_faltante = $orden->ordcos_valor - $v_cobrado;

                            $data = array(
                                'ordcos_vlrcobrado' => $v_cobrado,
                                'ordcos_vlrfaltante' => ($v_faltante <= 0) ? '' : $v_faltante
                            );
                            if ($v_faltante > 0 && $orden->est_id == 39) {
                                $data['est_id'] = 5;
                            }else if ($v_faltante <= 0) {
                                $data['est_id'] = 5;
                                $data['tpo_presup'] = '';
                            }
                           

                            $porciones = explode(",", $orden->no_presup); // divido la cadena
                            $clave = array_search($ppto, $porciones); //busco la clave ó posicion del presupuesto
                            unset($porciones[$clave]); // Elimino el presupuesto
                            $cadena = implode(",", $porciones); //Armo la cadena
                            $data['no_presup'] = $cadena;

                            $this->db->where('ordcos_id', $d->ordcos_id);
                            $this->db->update('ord_costos', $data);
                        endif;
                    }
                }

                if (($status == 5 && $rs->psin_estado == 1)) {
                    $this->db->where('psin_id', $ppto);
                    $result = $this->db->update('presup_prodi', array('psin_estado' => $status, 'num_impresiones' => $rs->num_impresiones + 1));
                } elseif ($status == 9999) {
                    $this->db->where('psin_id', $ppto);
                    $result = $this->db->update('presup_prodi', array('psin_estado' => $status));
                }

                break;
            case 8:
                $rs = $this->db->select('*')
                                ->from('publicidad_exterior')
                                ->where('pubext_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('pubext_id', $ppto);
                $result = $this->db->update('publicidad_exterior', $data);
                break;
            case 9:
                $rs = $this->db->select('*')
                                ->from('impresos')
                                ->where('imp_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('imp_id', $ppto);
                $result = $this->db->update('impresos', $data);
                break;
            case 10:
                $rs = $this->db->select('*')
                                ->from('art_publi')
                                ->where('artp_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('artp_id', $ppto);
                $result = $this->db->update('art_publi', $data);
                break;

            default:
                break;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $res = "Error";
        } else {
            $res = "OK";
            $this->db->trans_commit();
        }
        return $res;
    }

    function Copy($tipo, $ppto) {
        $this->db->trans_begin();
        $newppto = '';
        $fecha = date('Y-m-d');

        switch ($tipo) {
            case 1:
                $rs = $this->db->select('*')
                                ->from('presup_avisos')
                                ->where('psav_id', $ppto)
                                ->get()->row();

                    unset($rs->psav_id);
                    $rs->psav_fecha = $fecha;
                    $rs->psav_fechafactprov = $fecha;
                    $rs->psav_fechfact = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id_crea = $this->session->UserMedios;
                    $rs->usr_id_mod = $this->session->UserMedios;
                    $rs->psav_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->psav_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_avisos', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_avisos')
                            ->where('psav_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'psav_id' => $newppto,
                            'detavi_numcolum' => $d->detavi_numcolum,
                            'detavi_numcentim' => $d->detavi_numcentim,
                            'detavi_numavisos' => $d->detavi_numavisos,
                            'detavi_fechinser' => $d->detavi_fechinser,
                            'detavi_titulo' => $d->detavi_titulo,
                            'tinta_id' => $d->tinta_id,
                            'tariaviso_id' => $d->tariaviso_id,
                            'detavi_tarifa' => $d->detavi_tarifa,
                            'detavi_posicion' => $d->detavi_posicion,
                            'detavi_numdias' => $d->detavi_numdias,
                            'detavi_valor' => $d->detavi_valor,
                            'detavi_detalle' => $d->detavi_detalle,
                            'pagina_id' => $d->pagina_id,
                            'detavi_total' => $d->detavi_total,
                            'detavi_tamano' => $d->detavi_tamano,
                            'detavi_tpo' => $d->detavi_tpo,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_avisos', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "aviso" ');
                
                break;
            case 2:
                $rs = $this->db->select('*')
                                ->from('presup_clasificados')
                                ->where('pscf_id', $ppto)
                                ->get()->row();

                    unset($rs->pscf_id);
                    $rs->pscf_fecha = $fecha;
                    $rs->pscf_fechsfact = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_id_mod = $this->session->UserMedios;
                    $rs->pscf_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->pscf_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_clasificados', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_clasi')
                            ->where('pscf_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'pscf_id' => $newppto,
                            'dclasi_palabras' => $d->dclasi_palabras,
                            'dclasi_numavisos' => $d->dclasi_numavisos,
                            'dclasi_seccion' => $d->dclasi_seccion,
                            'dclasi_titulo' => $d->dclasi_titulo,
                            'dclasi_foto' => $d->dclasi_foto,
                            'dclasi_vlrfoto' => $d->dclasi_vlrfoto,
                            'dclasi_negrilla' => $d->dclasi_negrilla,
                            'dclasi_vlrnegrilla' => $d->dclasi_vlrnegrilla,
                            'dclasi_mayuscula' => $d->dclasi_mayuscula,
                            'dclasi_vlrmayuscula' => $d->dclasi_vlrmayuscula,
                            'dclasi_tarifa' => $d->dclasi_tarifa,
                            'dclasi_detalle' => $d->dclasi_detalle,
                            'dclasi_fondocolor' => $d->dclasi_fondocolor,
                            'dclasi_vlrfondocolor' => $d->dclasi_vlrfondocolor,
                            'dclasi_logogr' => $d->dclasi_logogr,
                            'dclasi_vlrlogogr' => $d->dclasi_vlrlogogr,
                            'dclasi_descriplogogr' => $d->dclasi_descriplogogr,
                            'dclasi_logopeq' => $d->dclasi_logopeq,
                            'dclasi_vlrlogopeq' => $d->dclasi_vlrlogopeq,
                            'dclasi_descriplogopeq' => $d->dclasi_descriplogopeq,
                            'dclasi_fechas' => $d->dclasi_fechas,
                            'dclasi_valor' => $d->dclasi_valor,
                            'dclasi_total' => $d->dclasi_total,
                            'dclasi_publi' => $d->dclasi_publi,
                            'unidad' => $d->unidad
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_clasi', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "clasificado" ');
                
                break;
            case 3:
                $rs = $this->db->select('*')
                                ->from('presup_revis')
                                ->where('psrev_id', $ppto)
                                ->get()->row();

                    unset($rs->psrev_id);
                    $rs->psrev_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id_crea = $this->session->UserMedios;
                    $rs->usr_id_mod = $this->session->UserMedios;
                    $rs->psrev_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->psrev_observa .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_revis', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_revis')
                            ->where('psrev_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'psrev_id' => $newppto,
                            'drevis_titulo' => $d->drevis_titulo,
                            'tinta_id' => $d->tinta_id,
                            'drevis_posicion' => $d->drevis_posicion,
                            'drevis_fechinser' => $d->drevis_fechinser,
                            'drevis_numavisos' => $d->drevis_numavisos,
                            'drevis_frecuencia' => $d->drevis_frecuencia,
                            'drevis_tarifa' => $d->drevis_tarifa,
                            'drevis_valor' => $d->drevis_valor,
                            'drevis_observa' => $d->drevis_observa,
                            'drevis_detalle' => $d->drevis_detalle,
                            'drevis_desc' => $d->drevis_desc,
                            'drevis_total' => $d->drevis_total,
                            'drevis_tamano' => $d->drevis_tamano,
                            'drevis_tpo' => $d->drevis_tpo,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_revis', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "revista" ');
                
                break;
            case 4:
                $rs = $this->db->select('*')
                                ->from('presup_radio')
                                ->where('psrad_id', $ppto)
                                ->get()->row();

                    unset($rs->psrad_id);
                    $rs->psrad_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_mod = $this->session->UserMedios;
                    $rs->psrad_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->psrad_observa .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_radio', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_radio')
                            ->where('psrad_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'psrad_id' => $newppto,
                            'drad_fechaini' => $d->drad_fechaini,
                            'drad_fechafin' => $d->drad_fechafin,
                            'drad_frecuencia' => $d->drad_frecuencia,
                            'drad_dias' => $d->drad_dias,
                            'drad_seg' => $d->drad_seg,
                            'drad_tarifa' => $d->drad_tarifa,
                            'drad_numcuna' => $d->drad_numcuna,
                            'drad_totalcuna' => $d->drad_totalcuna,
                            'drad_observacion' => $d->drad_observacion,
                            'drad_global' => $d->drad_global,
                            'drad_detalle' => $d->drad_detalle,
                            'progr_id' => $d->progr_id,
                            'drad_fechas' => $d->drad_fechas,
                            'drad_ciudad' => $d->drad_ciudad,
                            'emis_id' => $d->emis_id,
                            'drad_total' => $d->drad_total,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_radio', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "radio" ');
                
                break;
            case 5:
                $rs = $this->db->select('*')
                                ->from('presup_tv')
                                ->where('pstv_id', $ppto)
                                ->get()->row();

                    unset($rs->pstv_id);
                    $rs->pstv_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id_crea = $this->session->UserMedios;
                    $rs->usr_id_mod = $this->session->UserMedios;
                    $rs->pstv_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->pstv_observacion_presup .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_tv', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_tv')
                            ->where('pstv_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'pstv_id' => $newppto,
                            'dtv_canal' => $d->dtv_canal,
                            'dtv_cliente' => $d->dtv_cliente,
                            'cod_comercial' => $d->cod_comercial,
                            'dtv_producto' => $d->dtv_producto,
                            'dtv_programa' => $d->dtv_programa,
                            'dtv_referencia' => $d->dtv_referencia,
                            'dtv_hora' => $d->dtv_hora,
                            'dtv_segundo' => $d->dtv_segundo,
                            'dtv_numcomer' => $d->dtv_numcomer,
                            'dtv_numcomerd' => $d->dtv_numcomerd,
                            'dtv_tarifa' => $d->dtv_tarifa,
                            'dtv_observa' => $d->dtv_observa,
                            'dtv_bonif' => $d->dtv_bonif,
                            'dtv_valor' => $d->dtv_valor,
                            'dtv_diaspub' => $d->dtv_diaspub,
                            'dtv_detalle' => $d->dtv_detalle,
                            'dtv_fechasalida' => $d->dtv_fechasalida,
                            'dtv_frecuencia' => $d->dtv_frecuencia,
                            'dtv_franja' => $d->dtv_franja,
                            'dtv_total' => $d->dtv_total,
                            'dtv_global' => $d->dtv_global,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_tv', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "television" ');
                
                break;
            case 6:
                $rs = $this->db->select('*')
                                ->from('presup_prode')
                                ->where('psex_id', $ppto)
                                ->get()->row();

                    unset($rs->psex_id);
                    $rs->psex_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id_crea = $this->session->UserMedios;
                    $rs->usr_id_mod = $this->session->UserMedios;
                    $rs->psex_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->psex_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('presup_prode', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_prode')
                            ->where('psex_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'psex_id' => $newppto,
                            'dprode_detalle' => $d->dprode_detalle,
                            'dprode_valor' => $d->dprode_valor,
                            'dprode_iva' => $d->dprode_iva,
                            'tpsv_id' => $d->tpsv_id,
                            'unidad' => $d->unidad,
                            'ivaItem' => $d->ivaItem
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_prode', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "externa" ');
                
                break;
            case 7:
                $rs = $this->db->select('*')
                                ->from('presup_prodi')
                                ->where('psin_id', $ppto)
                                ->get()->row();

                    $data = array(
                        'psin_fechpresup' => date('Y-m-d'),
                        'pvcl_id_clie' => $rs->pvcl_id_clie,
                        'psin_fechordp' => $fecha,
                        'psin_fechfact' => $fecha,
                        'pvcl_id_prov' => 0,
                        'cod_med' => 0,
                        'pdcl_id' => $rs->pdcl_id,
                        'camp_id' => $rs->camp_id,
                        'cod_ser' => $rs->cod_ser,
                        'psin_observa' => $rs->psin_observa . ' Duplicado del Presupuesto ' . $ppto,
                        'psin_valor' => $rs->psin_valor,
                        'psin_desc' => $rs->psin_desc,
                        'psin_iva' => $rs->psin_iva,
                        'psin_total' => $rs->psin_total,
                        'psin_facturado' => $rs->psin_facturado,
                        'psin_estado' => 1,
                        'usr_id_crea' => $this->session->UserMedios,
                        'usr_id_mod' => $this->session->UserMedios,
                        'tpmone_id' => $rs->tpmone_id,
                        'num_impresiones' => -1,
                        'psin_numorden' => $rs->psin_numorden,
                        'psin_numcotizacion' => $rs->psin_numcotizacion
                    );

                    $this->db->insert('presup_prodi', $data);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_prodi')
                            ->where('psin_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'psin_id' => $newppto,
                            'dpsin_detalle' => $d->dpsin_detalle,
                            'dpsin_valor' => $d->dpsin_valor,
                            'tpsv_id' => $d->tpsv_id,
                            'dpsin_cant' => $d->dpsin_cant,
                            'dpsin_total' => $d->dpsin_total,
                            'dpsin_ordaumento' => $d->dpsin_ordaumento,
                            'dpsin_observ' => $d->dpsin_observ,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_prodi', $array);
                    }
                
                break;
            case 8:
                $rs = $this->db->select('*')
                                ->from('publicidad_exterior')
                                ->where('pubext_id', $ppto)
                                ->get()->row();

                    unset($rs->pubext_id);
                    $rs->pubext_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_mod = $this->session->UserMedios;
                    $rs->est_id = 1;
                    $rs->num_impresiones = -1;
                    $rs->pubext_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('publicidad_exterior', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_pubext')
                            ->where('pubext_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'pubext_id' => $newppto,
                            'dpubext_fecha' => $d->dpubext_fecha,
                            'pieza_id' => $d->pieza_id,
                            'dpubext_fechainicio' => $d->dpubext_fechainicio,
                            'dpubext_fechafin' => $d->dpubext_fechafin,
                            'dpubext_duracion' => $d->dpubext_duracion,
                            'dpubext_ubicacion' => $d->dpubext_ubicacion,
                            'dpubext_tamimpresion' => $d->dpubext_tamimpresion,
                            'dpubext_areavisual' => $d->dpubext_areavisual,
                            'dpubext_ciudad' => $d->dpubext_ciudad,
                            'dpubext_cantidad' => $d->dpubext_cantidad,
                            'dpubext_vlruni' => $d->dpubext_vlruni,
                            'dpubext_desc' => $d->dpubext_desc,
                            'dpubext_total' => $d->dpubext_total,
                            'dpubext_detalle' => $d->dpubext_detalle,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_pubext', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "publicidad_exterior" ');
                
                break;
            case 9:
                $rs = $this->db->select('*')
                                ->from('impresos')
                                ->where('imp_id', $ppto)
                                ->get()->row();

                    unset($rs->imp_id);
                    $rs->imp_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_mod = $this->session->UserMedios;
                    $rs->est_id = 1;
                    $rs->num_impresiones = -1;
                    $rs->imp_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('impresos', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_impresos')
                            ->where('imp_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'imp_id' => $newppto,
                            'dimp_fecha' => $d->dimp_fecha,
                            'elemento_id' => $d->elemento_id,
                            'dimp_tamano' => $d->dimp_tamano,
                            'dimp_material' => $d->dimp_material,
                            'dimp_cantidad' => $d->dimp_cantidad,
                            'dimp_pagina' => $d->dimp_pagina,
                            'dimp_acabados' => $d->dimp_acabados,
                            'dimp_area_impresion' => $d->dimp_area_impresion,
                            'dimp_area_visual' => $d->dimp_area_visual,
                            'dimp_observacion' => $d->dimp_observacion,
                            'dimp_valor' => $d->dimp_valor,
                            'dimp_desc' => $d->dimp_desc,
                            'dimp_total' => $d->dimp_total,
                            'dimp_tintas' => $d->dimp_tintas,
                            'dimp_distribucion' => $d->dimp_distribucion,
                            'dimp_gramaje' => $d->dimp_gramaje,
                            'concp_id' => $d->concp_id,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_impresos', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "impresos" ');
                
                break;
            case 10:
                $rs = $this->db->select('*')
                                ->from('art_publi')
                                ->where('artp_id', $ppto)
                                ->get()->row();

                    unset($rs->artp_id);
                    $rs->artp_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_mod = $this->session->UserMedios;
                    $rs->est_id = 1;
                    $rs->num_impresiones = -1;
                    $rs->artp_observacion .= ' Duplicado del Presupuesto ' . $ppto;

                    $this->db->insert('art_publi', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_artpub')
                            ->where('artp_id', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'artp_id' => $newppto,
                            'dartp_fecha' => date('Y-m-d'),
                            'dartp_producto' => $d->dartp_producto,
                            'dartp_tamano' => $d->dartp_tamano,
                            'dartp_material' => $d->dartp_material,
                            'dartp_tintas' => $d->dartp_tintas,
                            'dartp_cantidad' => $d->dartp_cantidad,
                            'dartp_caracteristicas' => $d->dartp_caracteristicas,
                            'dartp_observacion' => $d->dartp_observacion,
                            'dartp_valor' => $d->dartp_valor,
                            'dartp_desc' => $d->dartp_desc,
                            'dartp_total' => $d->dartp_total,
                            'unidad' => $d->unidad,
                        );
                    }

                    if (count($array) > 0) {
                        $this->db->insert_batch('det_artpub', $array);
                    }

                    $orden = $this->db->query('insert into ordenes (doc_id,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where doc_id = ' . $ppto . ' and tpo_doc = "articulos_publicitarios" ');
                
                break;

            default:
                break;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $res = array('res' => "Error");
        } else {
            $res = array('res' => "OK", "id" => $newppto);
            $this->db->trans_commit();
        }
        
        return $res;
    }

    function AddOrder($id, $type, $order) {
        switch ($type) {
            case 1:
                $data = array('psav_numorden' => $order);
                $this->db->where('psav_id', $id);
                $table = 'presup_avisos';
                break;
            case 2:
                $data = array('pscf_numorden' => $order);
                $this->db->where('pscf_id', $id);
                $table = 'presup_clasificados';
                break;
            case 3:
                $data = array('psrev_numorden' => $order);
                $this->db->where('psrev_id', $id);
                $table = 'presup_revis';
                break;
            case 4:
                $data = array('psrad_numorden' => $order);
                $this->db->where('psrad_id', $id);
                $table = 'presup_radio';
                break;
            case 5:
                $data = array('pstv_numorden' => $order);
                $this->db->where('pstv_id', $id);
                $table = 'presup_tv';
                break;
            case 6:
                $data = array('psex_numorden' => $order);
                $this->db->where('psex_id', $id);
                $table = 'presup_prode';
                break;
            case 7:
                $data = array('psin_numorden' => $order);
                $this->db->where('psin_id', $id);
                $table = 'presup_prodi';
                break;
            case 8:
                $data = array('pubext_numorden' => $order);
                $this->db->where('pubext_id', $id);
                $table = 'publicidad_exterior';
                break;
            case 9:
                $data = array('imp_numorden' => $order);
                $this->db->where('imp_id', $id);
                $table = 'impresos';
                break;
            case 10:
                $data = array('artp_numorden' => $order);
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

    function CargarTipoServicio($id = false) {
        if ($id)
            $this->db->where('id_categoria', $id);

        $result = $this->db->select('`id_tipo_servicio`, UPPER(`nombre`) as nombre, `descripcion`, `tpsv_cebe`, `id_estado`, `id_categoria`')
                ->from('sys_tipo_servicio')
                ->order_by('nombre')
                ->get();

        return $result->result();
    }

    function UpdateInfo($field_id, $ppto, $table, $data) {

        $this->db->where($field_id, $ppto);
        $result = $this->db->update($table, $data);

        if ($result) {
            $res = "OK";
        } else {
            $res = "ERROR " . $this->db->last_query();
        }
        return $res;
    }

    function InsertInfo($table, $data, $ord_observacion) {

        $result = $this->db->insert($table, $data);

        if ($result) {
            $id = $this->db->insert_id();
            $res = array('res' => 'OK', 'id' => $id);

            if ($table != "presup_prodi") {
                $fecha = date('Y-m-d');
                $array = array("doc_id" => $id, "ord_fecha" => $fecha, "usr_id" => $this->session->UserMedios, "num_impresiones" => "-1", "ord_fechaimp" => $fecha, "pvcl_id_prov" => $data['pvcl_id_prov'], "ord_observacion" => $ord_observacion);
                switch ($table) {
                    case "presup_avisos":
                    case "pre_orden_aviso":
                        $array['tpo_doc'] = "aviso";
                        break;
                    case "presup_clasificados":
                    case "pre_orden_clasificado":
                        $array['tpo_doc'] = "clasificado";
                        break;
                    case "presup_revis":
                    case "pre_orden_revista":
                        $array['tpo_doc'] = "revista";
                        break;
                    case "presup_radio":
                    case "pre_orden_radio":
                        $array['tpo_doc'] = "radio";
                        break;
                    case "presup_tv":
                    case "pre_orden_tv":
                        $array['tpo_doc'] = "television";
                        break;
                    case "presup_prode":
                    case "pre_orden_externa":
                        $array['tpo_doc'] = "externa";
                        break;
                    case "presup_prodi":
                    case "pre_orden_interna":
                        $array['tpo_doc'] = "interna";
                        break;
                    case "publicidad_exterior":
                    case "pre_orden_exterior":
                        $array['tpo_doc'] = "publicidad_exterior";
                        break;
                    case "impresos":
                    case "pre_orden_impreso":
                        $array['tpo_doc'] = "impresos";
                        break;
                    case "art_publi":
                    case "pre_orden_articulo":
                        $array['tpo_doc'] = "articulos_publicitarios";
                        break;
                    default:
                        break;
                }
                
                if(substr($table, 0, 9) == 'pre_orden'){
                    $array['id_preorden'] = $id;
                    unset($array['doc_id']);
                }
                
                $this->db->insert("ordenes", $array);

                $ord_id = $this->db->insert_id();
                $res['ord_id'] = $ord_id;
            }
        } else {
            $res = array('res' => 'error', 'msg' => "ERROR " . $This->db->last_query(), 'id' => '0');
        }
        return $res;
    }

    function AddDetail($table, $data, $field_id, $ppto, $table_det, $select) {

        $result = $this->db->insert($table, $data);

        if ($result) {
            $res = "OK";
            $id_detalle = $this->db->insert_id();
            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where($field_id, $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor, 'id_detalle' => $id_detalle);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
    }

    function UpdateDetail($table, $data, $field_id, $ppto, $table_det, $select, $field_id_detalle, $id_detalle) {

        $this->db->where($field_id_detalle, $id_detalle);
        $result = $this->db->update($table, $data);

        if ($result) {
            $res = "OK";

            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where($field_id, $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
    }

    function DeleteDetail($field_id, $ppto, $table_det, $select, $field_id_detalle, $id_detalle) {

        $this->db->where($field_id_detalle, $id_detalle);
        $result = $this->db->delete($table_det);

        if ($result) {
            $res = "OK";

            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where($field_id, $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
    }

    function ValorTotal($field_id, $ppto, $table, $selectTotal, $row = false) {

        $result = $this->db->select($selectTotal)
                ->from($table)
                ->where($field_id, $ppto)
                ->get();

        if ($row) {
            return $result->row();
        } else {
            return $result->row()->total;
        }
    }

    function SelectRow($table, $field_id, $ppto, $select = false) {

        if (!$select)
            $select = '*';

        $result = $this->db->select($select)
                ->from($table)
                ->where($field_id, $ppto)
                ->get();

        return $result->row();
    }

    function ListOrdCosto($tipo) {
        $result = $this->db->select('l.*,c.nombre')
                ->from('ord_costos l')
                ->join('sys_clients c', 'l.pvcl_id_clie = c.id_client')
                ->where("l.ordcos_fecha >= '2019-01-01' AND est_id not in( 4,9999,38) and tpsv_id != 61 and (tpo_presup is null or tpo_presup = 0 or tpo_presup = $tipo) and (ordcos_vlrfaltante > 0 or ordcos_vlrfaltante is null or ordcos_vlrfaltante = '')")
                ->order_by('ordcos_id', 'desc')
                ->get();

        return $result->result();
    }

    function ListOrdCostoExt($tipo, $servicio) {
        $result = $this->db->select('l.*,c.nombre')
                ->from('ord_costos l')
                ->join('sys_clients c', 'l.pvcl_id_clie = c.id_client')
                ->where("tpsv_id = $servicio and (ordcos_vlrfaltante > '0' or ordcos_vlrfaltante is null or ordcos_vlrfaltante = '') and (tpo_presup is null or tpo_presup in (0," . $tipo . ")) and est_id not in( 4,9999,38) ")
                ->order_by('ordcos_id', 'desc')
                ->get();

        return $result->result();
    }

    function GetDetailOrdCosto($order) {
        $result = $this->db->select('*')
                ->from('det_ordcostos')
                ->where('ordcos_id', $order)
                ->get();

        return $result->result();
    }

    function DesAsignPptoOrder($orden, $ppto, $ordcos_vlrcobrado) {
        $result = $this->db->select('*')
                ->from('ord_costos')
                ->where("ordcos_id", $orden)
                ->get();
        $row = $result->row();

        $data['ordcos_vlrcobrado'] = $row->ordcos_vlrcobrado - $ordcos_vlrcobrado;

        $data['ordcos_vlrfaltante'] = $row->ordcos_valor - $data['ordcos_vlrcobrado'];

        if ($data['ordcos_vlrfaltante'] > 0 && $row->est_id == 39) {
            $data['est_id'] = 5;
        }
        $this->db->where('ordcos_id', $orden);
        $this->db->update('ord_costos', $data);
    }

    function AsignPptoOrder($orden, $ppto, $ordcos_vlrcobrado, $tipo) {
        $result = $this->db->select('*')
                ->from('ord_costos')
                ->where("ordcos_id", $orden)
                ->get();
        $row = $result->row();

        $data['no_presup'] = (empty($row->no_presup)) ? $ppto : $row->no_presup . ',' . $ppto;
        $data['tpo_presup'] = $tipo;
        $data['usr_id_mod'] = $this->session->UserMedios;

        $data['ordcos_vlrcobrado'] = $row->ordcos_vlrcobrado + $ordcos_vlrcobrado;

        $data['ordcos_vlrfaltante'] = $row->ordcos_valor - $data['ordcos_vlrcobrado'];

        if ($data['ordcos_vlrfaltante'] <= 0) {
            $data['ordcos_vlrfaltante'] = 0;
            $data['est_id'] = 39;
        }
        $this->db->where('ordcos_id', $orden);
        $this->db->update('ord_costos', $data);
    }

    function SelecTall($id, $field, $table) {
        $result = $this->db->select('*')
                ->from($table)
                ->where($field, $id)
                ->get();
        return $result->result();
    }

    function GetRowDetailppto() {
        $result = $this->db->select('*')
                ->from($this->table)
                ->where($this->field, $this->id_detalle)
                ->get();
        return $result->row();
    }

    function GetOrdenPpto($ppto, $tipo, $pre_order = false) {
        
        if(!$pre_order){
            $this->db->where('doc_id', $ppto);
        }else{
            $this->db->where('id_preorden', $ppto);
        }
        
        $result = $this->db->select('*')
                ->from('ordenes')
                ->where('tpo_doc', $tipo)
                ->get();
        return $result->row();
    }

    function UpdateNumOrder($ord_id) {
        $result = $this->db->select('*')
                ->from('ordenes')
                ->where('ord_id', $ord_id)
                ->get();
        $row = $result->row();

        $this->db->where('ord_id', $ord_id);
        $this->db->update('ordenes', array('num_impresiones' => $row->num_impresiones + 1));
    }

    function GetBillPpto($ppto, $tipo) {
        $result = $this->db->select('*')
                ->from('factura_presup')
                ->where('id_doc', $ppto)
                ->where('modulo_id', $tipo)
                ->get();
        return $result->row();
    }

    function UpdateOrder($ord_id, $data) {
        $this->db->where('ord_id', $ord_id);
        $this->db->update('ordenes', $data);
    }

    function SaveImportDetail($array, $ppto) {
        if ($this->db->insert_batch('det_tv', $array)) {
            $id = $this->db->insert_id();

            $result = $this->db->select('SUM(dtv_total) AS valor')
                    ->from('det_tv')
                    ->where('pstv_id', $ppto)
                    ->get();

            return array('res' => $id, 'valor' => $result->row()->valor);
        } else {
            return array('res' => 0);
        }
    }

}
