<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Preorden extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function GetPptoCompleteInfoOrden($ini = false, $fin = false, $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor) {

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
                        ->from('pre_orden_clasificado a')
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
                        ->from('pre_orden_clasificado c')
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
                        ->from('pre_orden_revista c')
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
                        ->from('pre_orden_radio r')
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
                        ->from('pre_orden_tv tv')
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
                        ->from('pre_orden_externa et')
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
                        ->from('pre_orden_interna i')
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
                        ->from('pre_orden_exterior pe')
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
                        ->from('pre_orden_impreso im')
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
                        ->from('pre_orden_articulo ap')
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

    function AddDetail($table, $data, $ppto, $table_det, $select) {

        $result = $this->db->insert($table, $data);

        if ($result) {
            $res = "OK";
            $id_detalle = $this->db->insert_id();
            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where('id_preorden', $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor, 'id_detalle' => $id_detalle);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
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

    function UpdateDetail($table, $data, $ppto, $table_det, $select, $field_id_detalle, $id_detalle) {

        $this->db->where($field_id_detalle, $id_detalle);
        $result = $this->db->update($table, $data);

        if ($result) {
            $res = "OK";

            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where('id_preorden', $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
    }

    function DeleteDetail($ppto, $table_det, $select, $field_id_detalle, $id_detalle) {

        $this->db->where($field_id_detalle, $id_detalle);
        $result = $this->db->delete($table_det);

        if ($result) {
            $res = "OK";

            $result = $this->db->select($select)
                    ->from($table_det)
                    ->where('id_preorden', $ppto)
                    ->get();

            $res = array('res' => "OK", 'valor' => $result->row()->valor);
        } else {
            $res = array('res' => "ERROR " . $This->db->last_query());
        }
        return $res;
    }

    function UpdateStatusOrden($tipo, $ppto, $status) {
        $this->db->trans_begin();

        switch ($tipo) {
            case 1:
                $rs = $this->db->select('*')
                                ->from('pre_orden_aviso')
                                ->where('psav_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psav_estado, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['psav_estado'] = $status;
                }

                $this->db->where('psav_id', $ppto);
                $result = $this->db->update('pre_orden_aviso', $data);
                break;
            case 2:
                $rs = $this->db->select('*')
                                ->from('pre_orden_clasificado')
                                ->where('pscf_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->pscf_estado, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['pscf_estado'] = $status;
                }

                $this->db->where('pscf_id', $ppto);
                $result = $this->db->update('pre_orden_clasificado', $data);
                break;
            case 3:
                $rs = $this->db->select('*')
                                ->from('pre_orden_revista')
                                ->where('psrev_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psrev_estado, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['psrev_estado'] = $status;
                }

                $this->db->where('psrev_id', $ppto);
                $result = $this->db->update('pre_orden_revista', $data);
                break;
            case 4:
                $rs = $this->db->select('*')
                                ->from('pre_orden_radio')
                                ->where('psrad_id', $ppto)
                                ->get()->row();

                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->psrad_estado, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['psrad_estado'] = $status;
                }

                $this->db->where('psrad_id', $ppto);
                $result = $this->db->update('pre_orden_radio', $data);
                break;
            case 5:
                $rs = $this->db->select('*')
                                ->from('pre_orden_tv')
                                ->where('pstv_id', $ppto)
                                ->get()->row();

                $data['usr_id_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->pstv_estado, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['pstv_estado'] = $status;
                }

                $this->db->where('pstv_id', $ppto);
                $result = $this->db->update('pre_orden_tv', $data);
                break;
            case 6:
                $rs = $this->db->select('*')
                                ->from('pre_orden_externa')
                                ->where('psex_id', $ppto)
                                ->get()->row();


                if (($status == 5 && $rs->psex_estado == 1)) {
                    $this->db->where('psex_id', $ppto);
                    $result = $this->db->update('pre_orden_externa', array('psex_estado' => $status, 'num_impresiones' => $rs->num_impresiones + 1));
                } elseif ($status == 9999) {
                    $this->db->where('psex_id', $ppto);
                    $result = $this->db->update('pre_orden_externa', array('psex_estado' => $status));
                }
                break;
            case 7:
                $rs = $this->db->select('*')
                                ->from('pre_orden_interna')
                                ->where('psin_id', $ppto)
                                ->get()->row();


                if (($status == 5 && $rs->psin_estado == 1)) {
                    $this->db->where('psin_id', $ppto);
                    $result = $this->db->update('pre_orden_interna', array('psin_estado' => $status, 'num_impresiones' => $rs->num_impresiones + 1));
                } elseif ($status == 9999) {
                    $this->db->where('psin_id', $ppto);
                    $result = $this->db->update('pre_orden_interna', array('psin_estado' => $status));
                }

                break;
            case 8:
                $rs = $this->db->select('*')
                                ->from('pre_orden_exterior')
                                ->where('pubext_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('pubext_id', $ppto);
                $result = $this->db->update('pre_orden_exterior', $data);
                break;
            case 9:
                $rs = $this->db->select('*')
                                ->from('pre_orden_impreso')
                                ->where('imp_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('imp_id', $ppto);
                $result = $this->db->update('pre_orden_impreso', $data);
                break;
            case 10:
                $rs = $this->db->select('*')
                                ->from('pre_orden_articulo')
                                ->where('artp_id', $ppto)
                                ->get()->row();


                $data['usr_mod'] = $this->session->UserMedios;

                if ($status == 5) {
                    $data['num_impresiones'] = $rs->num_impresiones + 1;
                }

                if (!in_array($rs->est_id, array(4, 38, 9999, 47, 39)) || $status == 38) {
                    $data['est_id'] = $status;
                }

                $this->db->where('artp_id', $ppto);
                $result = $this->db->update('pre_orden_articulo', $data);
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

    function GetDetailPpto($tipo, $ppto) {
        switch ($tipo) {
            case 1:
                $result = $this->db->select('d.*,t.tinta_nombre as tinta,p.pagina_nombre as pagina')
                        ->from('det_avisos d')
                        ->join('cat_tintas t', 'd.tinta_id = t.tinta_id', 'left')
                        ->join('cat_paginaperiod p', 'd.pagina_id = p.pagina_id', 'left')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 2:
                $result = $this->db->select('d.*')
                        ->from('det_clasi d')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 3:
                $result = $this->db->select('d.*,t.tinta_nombre as tinta')
                        ->from('det_revis d')
                        ->join('cat_tintas t', 'd.tinta_id = t.tinta_id', 'left')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 4:
                $result = $this->db->select('d.*,p.progr_nombre as programa, e.emis_nombre as emisora')
                        ->from('det_radio d')
                        ->join('cat_programasr p', 'd.progr_id = p.progr_id', 'left')
                        ->join('cat_emisoras e', 'd.emis_id = e.emis_id', 'left')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 5:
                $result = $this->db->select('d.*')
                        ->from('det_tv d')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 6:
                $result = $this->db->select('d.*')
                        ->from('det_prode d')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 7:
                $result = $this->db->select('dpsin_detalle as detalle,dpsin_cant as cantidad,dpsin_total as valor')
                        ->from('det_prodi d')
                        ->where('id_preorden', $ppto)
                        ->get();
                break;
            case 8:
                $result = $this->db->select('d.*,p.pieza_nombre as pieza')
                        ->from('det_pubext d')
                        ->join('cat_piezas p', 'd.pieza_id = p.pieza_id', 'left')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 9:
                $result = $this->db->select('d.*,p.elem_nombre as elemento,c.concp_nmb as concepto')
                        ->from('det_impresos d')
                        ->join('cat_elementos p', 'd.elemento_id = p.elem_id', 'left')
                        ->join('cat_concepto c', 'd.concp_id = c.concp_id', 'left')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;
            case 10:
                $result = $this->db->select('d.*')
                        ->from('det_artpub d')
                        ->where('d.id_preorden', $ppto)
                        ->get();
                break;

            default:
                break;
        }
        return $result->result();
    }
    
    function GetPpto($ppto, $tipo, $tabla) {
        switch ($tipo) {
            case "1":
                $result = $this->db->select('*')
                        ->from($tabla.' a')
                        ->where('psav_id', $ppto)
                        ->get();
                break;
            case "2":
                $result = $this->db->select('curdate() as pscf_fecha,pvcl_id_clie,pvcl_id_clie as cliente,pdcl_id,camp_id,pvcl_id_prov,tpsv_id,pscf_observacion,pscf_valor,pscf_desc,pscf_spa,pscf_iva,pscf_ivaspa,pscf_total,pscf_total  as total,pscf_comentario,medio_id,usr_id,usr_id_mod,pscf_numorden,pscf_numcotizacion')
                        ->from($tabla.' c')
                        ->where('pscf_id', $ppto)
                        ->get();
                break;
            case "3":
                $result = $this->db->select('*')
                        ->from($tabla.' re')
                        ->where('psrev_id', $ppto)
                        ->get();
                break;
            case "4":
                $result = $this->db->select('curdate() as psrad_fecha,pvcl_id_clie,pvcl_id_clie as cliente,pdcl_id,camp_id,pvcl_id_prov,tpsv_id,r.psrad_observa,r.psrad_comentario,r.psrad_valor,r.psrad_desc,r.psrad_iva,r.psrad_ivaspa,
                                            r.psrad_spa,r.psrad_total,r.psrad_total as total,r.medio_id,r.usr_id,r.usr_mod,r.psrad_numorden,r.psrad_numcotizacion')
                        ->from($tabla.' r')
                        ->where('psrad_id', $ppto)
                        ->get();
                break;
            case "5":
                $result = $this->db->select('*')
                        ->from($tabla.' tv')
                        ->where('pstv_id', $ppto)
                        ->get();
                break;
            case "6":
                $result = $this->db->select('*')
                        ->from($tabla.' et')
                        ->where('psex_id', $ppto)
                        ->get();
                break;
            case "7":
                $result = $this->db->select('*')
                        ->from($tabla.' i')
                        ->where('psin_id', $ppto)
                        ->get();
                break;
            case "8":
                $result = $this->db->select('*')
                        ->from($tabla.' pe')
                        ->where('pubext_id', $ppto)
                        ->get();
                break;
            case "9":
                $result = $this->db->select('*')
                        ->from($tabla.' im')
                        ->where('imp_id', $ppto)
                        ->get();
                break;
            case "10":
                $result = $this->db->select('*')
                        ->from($tabla.' ap')
                        ->where('artp_id', $ppto)
                        ->get();
                break;
            default:
                break;
        }

        return $result->row();
    }

    function InsertInfo($table, $data) {

        $result = $this->db->insert($table, $data);
        
        $id = $this->db->insert_id();
            
        return $id;
    }
    
    function UpdateOrder($ord_id, $data) {
        $this->db->where('ord_id', $ord_id);
        $this->db->update('ordenes', $data);
    }
    
    function InsertDetail($table_Det,$field_id,$data,$pre_orden){
        $this->db->where('id_preorden',$pre_orden);
        $this->db->update($table_Det,$data);
    }
    
    function UpdateOrdProveedor($id_ppto,$preorden,$tipo){
        $this->db->where('id_preorden', $preorden);
        $this->db->where('tpo_doc', $tipo);
        $result = $this->db->update('ordenes', array('doc_id'=>$id_ppto));
    }
    
    function Copy($tipo, $ppto) {
        $this->db->trans_begin();
        $newppto = '';
        $fecha = date('Y-m-d');

        switch ($tipo) {
            case 2:
                $rs = $this->db->select('*')
                                ->from('pre_orden_clasificado')
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
                    $rs->pscf_observacion .= ' Duplicado de la preorden ' . $ppto;

                    $this->db->insert('pre_orden_clasificado', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_clasi')
                            ->where('id_preorden', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'id_preorden' => $newppto,
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
            case 4:
                $rs = $this->db->select('*')
                                ->from('pre_orden_radio')
                                ->where('psrad_id', $ppto)
                                ->get()->row();

                    unset($rs->psrad_id);
                    $rs->psrad_fecha = $fecha;
                    $rs->presup_fechacrea = date('Y-m-d H:i:s');
                    $rs->usr_id = $this->session->UserMedios;
                    $rs->usr_mod = $this->session->UserMedios;
                    $rs->psrad_estado = 1;
                    $rs->num_impresiones = -1;
                    $rs->psrad_observa .= ' Duplicado de la preorden ' . $ppto;

                    $this->db->insert('pre_orden_radio', $rs);
                    $newppto = $this->db->insert_id();

                    $rsdet = $this->db->select('*')
                            ->from('det_radio')
                            ->where('id_preorden', $ppto)
                            ->get();
                    $array = array();
                    foreach ($rsdet->result() as $d) {
                        $array[] = array(
                            'id_preorden' => $newppto,
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

                    $orden = $this->db->query('insert into ordenes (id_preorden,ord_fecha,usr_id,ord_fechaimp,tpo_doc,ord_observacion,pvcl_id_prov) '
                            . 'select ' . $newppto . ',"' . $fecha . '","' . $this->session->UserMedios . '","' . $fecha . '",tpo_doc,concat(ord_observacion," Duplicado de la orden ",ord_id),pvcl_id_prov from ordenes where id_preorden = ' . $ppto . ' and tpo_doc = "radio" ');
                
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


}
