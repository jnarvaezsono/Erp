<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Chargue extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListarCategoriasRadicador() {

        $result = $this->db->select('*')
                ->from('sys_categoria')
                ->where('id_estado', 1)
                ->where('id_categoria not in (14,15,16,17) ')
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }

    function infoBill($bill) {
        $result = $this->db->select('*')
                ->from('facturacion')
                ->where('factura_id', $bill)
                ->get();

        return $result->row();
    }

    function ListaPresupuestos($categoria, $ppto = false, $fecha_ini, $fecha_fin, $id_cliente) {

        $factura_avisosList = array();
        switch ($categoria) {
            case '1'://aviso
                $this->db->from('radicador_presup_aviso');
                break;
            case '2'://clas
                $this->db->from('radicador_clasificado');
                break;
            case '3'://revista
                $this->db->from('radicador_revista');
                break;
            case '4'://radio
                $this->db->from('radicador_radio');
                break;
            case '5'://tv
                $this->db->from('radicador_television');
                break;
            case '6'://externa
                $this->db->from('radicador_externa');
                break;
            case '7'://interna
                $this->db->from('radicador_interna');
                break;
            case '8'://exterior
                $this->db->from('radicador_publicidad_exterior');
                break;
            case '9'://impreso
                $this->db->from('radicador_impresos');
                break;
            case '10'://articulo
                $this->db->from('radicador_articulos_publicitarios');
                break;

            default:
                break;
        }

        if ($ppto) {
            $this->db->where("num_presup", $ppto);
        } else {
            $this->db->where("fecha_presup between '$fecha_ini' AND '$fecha_fin' ");
        }

        $this->db->where("est_id in (4,47)");
        $this->db->where("cargado", 0);

        if ($id_cliente != "all")
            $this->db->where("id_clie", $id_cliente);

        $res = $this->db->select('*')->get();

        $result = $res->result();

        foreach ($result as $value) {

            $facttura_avisos = (object) array(
                        'fecha_presup' => $value->fecha_presup,
                        'num_presup' => $value->num_presup,
                        'numorden' => $value->numorden,
                        'numcotizacion' => $value->numcotizacion,
                        'id_clie' => $value->id_clie,
                        'cod_sap_clie' => $value->cod_sap_clie,
                        'nmb_clie' => utf8_encode($value->nmb_clie),
                        'id_prov' => $value->id_prov,
                        'cod_sap_prov' => $value->cod_sap_prov,
                        'nmb_prov' => $value->nmb_prov,
                        'cebe_tposerv' => $value->cebe_tposerv,
                        'nmb_tposerv' => utf8_encode($value->nmb_tposerv),
                        'nmb_camp' => utf8_encode($value->nmb_camp),
                        'nmb_prod' => utf8_encode($value->nmb_prod),
                        'nmb_medio' => utf8_encode($value->nmb_medio),
                        'estado' => $value->estado,
                        'no_orden_prov' => $value->no_orden_prov,
                        'dependencia' => utf8_encode($value->dependencia),
                        'detalle' => utf8_encode($value->detalle),
                        'num_fact' => $value->num_fact,
                        'valor' => $value->valor,
                        'des' => $value->des,
                        'valor_desc' => $value->valor_desc,
                        'iva' => $value->iva,
                        'valor_iva' => $value->valor_iva,
                        'valor_menos_desc' => $value->valor_menos_desc,
                        'valor_mas_iva' => $value->valor_mas_iva,
                        'total' => $value->total,
                        'spa' => $value->spa,
                        'valor_spa' => $value->valor_spa,
                        'iva_spa' => $value->iva_spa,
                        'valor_iva_spa' => $value->valor_iva_spa,
                        'info_facturacion' => $value->info_facturacion,
                        'est_id' => $value->est_id,
                        'tpo_prod' => $value->tpo_prod,
                        'serv_cebe_detalle' => $value->serv_cebe_detalle,
                        'serv_nombre_detalle' => utf8_encode($value->serv_nombre_detalle),
                        'valor_unitario' => $value->valor_unitario,
                        'total_detalle' => $value->total_detalle,
                        'cantidad' => $value->cantidad,
                        'num_fact2' => $value->num_fact2,
                        'unidad' => $value->unidad,
                        'ret' => $value->ret,
            );
            $factura_avisosList[] = $facttura_avisos;
        }

        return $factura_avisosList;
    }

    function infoRet($ret) {
        $result = $this->db->select('*')
                ->from('cat_retefuente')
                ->where('rete_id', $ret)
                ->get();

        return $result->row();
    }

    function SaveImportDetail($array) {
        $this->db->truncate('sys_factura_cargue');
        if ($this->db->insert_batch('sys_factura_cargue', $array)) {
            return 1;
        } else {
            return 0;
        }
    }

    function ListBill($tipo) {

        if ($tipo == 'E') {
            $this->db->order_by('factura', 'desc');
        } else {
            $this->db->order_by('factura', 'asc');
        }

        $result = $this->db->select('*,CONVERT((bruto+iva), UNSIGNED INTEGER) valor_base,SUBSTRING(TRIM(proveedor),1,50) proveedor')
                ->from('sys_factura_cargue')
                ->get();

        return array('result' => $result->result(), 'num' => $result->num_rows());
    }

    function infoConsecutive() {
        $result = $this->db->select('cons_cargue_interna as c_i,cons_cargue_mandato as c_m')
                ->from('sys_data_billing')
                ->get();

        return $result->row();
    }

    

}
