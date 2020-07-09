<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Preorden extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Managerbudget/M_Preorden');
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    public function GetList($type) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data = array('table' => $type);

        if ($type == '1') {
            foreach ($this->M_Preorden->LoadButtonPermissions("AVISO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE PRENSA';
        } elseif ($type == '2') {
            foreach ($this->M_Preorden->LoadButtonPermissions("CLASIFICADO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE CLASIFICADO';
        } elseif ($type == '3') {
            foreach ($this->M_Preorden->LoadButtonPermissions("REVISTA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE REVISTA';
        } elseif ($type == '4') {
            foreach ($this->M_Preorden->LoadButtonPermissions("RADIO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE RADIO';
        } elseif ($type == '5') {
            foreach ($this->M_Preorden->LoadButtonPermissions("TV") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE TELEVISIÓN';
        } elseif ($type == '6') {
            foreach ($this->M_Preorden->LoadButtonPermissions("EXTERNA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE PRODUCCIÓN EXTERNA';
        } elseif ($type == '7') {
            foreach ($this->M_Preorden->LoadButtonPermissions("INTERNA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE PRODUCCIÓN INTERNA';
        } elseif ($type == '8') {
            foreach ($this->M_Preorden->LoadButtonPermissions("EXTERIOR") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE PUBLICIDAD EXTERIOR';
        } elseif ($type == '9') {
            foreach ($this->M_Preorden->LoadButtonPermissions("IMPRESO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE IMPRESO';
        } elseif ($type == '10') {
            foreach ($this->M_Preorden->LoadButtonPermissions("ARTICULOS") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PREORDEN DE ARTICULOS PUBLICITARIOS';
        }

        $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
        
        if ($type == 4)
            $data['ordenes'] = $this->M_Preorden->GetPptoCompleteInfoOrden(false, false, $type, 'all', date('Y') . '-01-01', date('Y-m-d'), 'all');
        
        $this->load->view('Managerbudget/V_Panel_Orden', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, MOMENT, RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable($tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor) {
        $rows = $this->M_Preorden->GetPptoCompleteInfoOrden($this->input->get('start'), $this->input->get("length"), $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor);
        $rows2 = $this->M_Preorden->GetPptoCompleteInfoOrden(false, false, $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor);

        if ($tipo == '1') {
            $btns = $this->M_Preorden->LoadButtonPermissions("AVISO");
            $table = 'pre_orden_aviso';
        } else if ($tipo == '2') {
            $btns = $this->M_Preorden->LoadButtonPermissions("CLASIFICADO");
            $table = 'pre_orden_clasificado';
        } else if ($tipo == '3') {
            $btns = $this->M_Preorden->LoadButtonPermissions("REVISTA");
            $table = 'pre_orden_revista';
        } else if ($tipo == '4') {
            $btns = $this->M_Preorden->LoadButtonPermissions("RADIO");
            $table = 'pre_orden_radio';
        } else if ($tipo == '5') {
            $btns = $this->M_Preorden->LoadButtonPermissions("TV");
            $table = 'pre_orden_tv';
        } else if ($tipo == '6') {
            $btns = $this->M_Preorden->LoadButtonPermissions("EXTERNA");
            $table = 'pre_orden_externa';
        } else if ($tipo == '7') {
            $btns = $this->M_Preorden->LoadButtonPermissions("INTERNA");
            $table = 'pre_orden_interna';
        } else if ($tipo == '8') {
            $btns = $this->M_Preorden->LoadButtonPermissions("EXTERIOR");
            $table = 'pre_orden_exterior';
        } else if ($tipo == '9') {
            $btns = $this->M_Preorden->LoadButtonPermissions("IMPRESO");
            $table = 'pre_orden_impreso';
        } else if ($tipo == '10') {
            $btns = $this->M_Preorden->LoadButtonPermissions("ARTICULOS");
            $table = 'pre_orden_articulo';
        }

        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }

        $array = array();
        foreach ($rows['result'] as $v) {

            $btn = '<div class="btn-group btnI' . $v->id . '" order="' . $v->orden . '" >
                        <button  type="button" class="btn1-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs btn-left">' . $v->estado . '</button>
                            <button type="button" class="btn2-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';

            $btn .= '<ul class="dropdown-menu u-' . $v->id . '" role="menu">';
            $btn .= '<li onclick="printPdf(' . $v->id . ',2)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn .= ($v->id_estado == 1) ? '<li onclick="ConvertirPpto(' . $v->id . ',' . $tipo . ',\''.$table.'\')"><a href="#"><i class="fa fa-fw fa-edit"></i> Crear PPto</a></li>' : '';
            $btn .= (isset($BtnEditPpto) && ($v->id_estado == 1 && $v->impresiones == -1)) ? '<li onclick="EditPpto(' . $v->id . ',' . $tipo . ')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>' : '';
            $btn .= (isset($BtnAnulePpto) && (($v->id_estado == 1 && $v->impresiones == -1) || ($v->id_estado == 5))) ? '<li onclick="Anule(' . $v->id . ')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>' : '';
            $btn .= '</ul></div>';


            $array[] = array($v->id, $v->fecha, $v->cliente, $v->proveedor, $v->campana, explode(' ', $v->usuario)[0], $btn, number_format($v->total, 0, ',', '.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }

    function AddDetail() {

        $tipo = $this->input->post('tipo');
        $valor = $this->input->post('valor');
        $table = $this->input->post('tabla');

        unset($_POST['tipo']);
        unset($_POST['valor']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $field_id = 'psav_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';
                $ppto = $this->input->post('psav_id');
                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                unset($_POST['psav_id']);
                break;
            case 2:
                $table_det = 'det_clasi';
                $field_id = 'pscf_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $ppto = $this->input->post('pscf_id');
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';
                unset($_POST['pscf_id']);
                break;
            case 3:
                $table_det = 'det_revis';
                $field_id = 'psrev_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $ppto = $this->input->post('psrev_id');
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                unset($_POST['psrev_id']);
                break;
            case 4:
                $table_det = 'det_radio';
                $field_id = 'psrad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';
                $ppto = $this->input->post('psrad_id');
                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                unset($_POST['psrad_id']);
                break;
            case 5:
                $table_det = 'det_tv';
                $field_id = 'pstv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';
                $ppto = $this->input->post('pstv_id');
                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';
                unset($_POST['pstv_id']);
                break;
            case 6:
                $table_det = 'det_prode';
                $field_id = 'psex_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';
                $ppto = $this->input->post('psex_id');
                if ($this->input->post('ordcos_id') != 0) {
                    $ordcos_vlrcobrado = $this->input->post('ordcos_vlrcobrado');
                    unset($_POST['ordcos_vlrcobrado']);
                }
                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                unset($_POST['psex_id']);
                break;
            case 7:
                $table_det = 'det_prodi';
                $field_id = 'psin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';
                $ppto = $this->input->post('psin_id');
                if ($this->input->post('ordcos_id') != 0) {
                    $ordcos_vlrcobrado = $this->input->post('ordcos_vlrcobrado');
                    unset($_POST['ordcos_vlrcobrado']);
                }
                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                unset($_POST['psin_id']);
                break;
            case 8:
                $table_det = 'det_pubext';
                $field_id = 'pubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';
                $ppto = $this->input->post('pubext_id');
                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                unset($_POST['pubext_id']);
                break;
            case 9:
                $table_det = 'det_impresos';
                $field_id = 'imp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';
                $ppto = $this->input->post('imp_id');
                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                unset($_POST['imp_id']);
                break;
            case 10:
                $table_det = 'det_artpub';
                $field_id = 'artp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';
                $ppto = $this->input->post('artp_id');
                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                unset($_POST['artp_id']);
                break;

            default:
                break;
        }

        unset($_POST['pscf_id']);
        $_POST['id_preorden'] = $ppto;

        $reverse = '';
        $msg = '';
        $result = $this->M_Preorden->AddDetail($table_det, $_POST, $ppto, $table_det, $select);
        if ($result['res'] == 'OK') {
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Preorden->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));

            $rsRow = $this->M_Preorden->SelectRow($table, $field_id, $ppto);
            $validate = $this->ValidateCredit($rsRow->pvcl_id_clie, false, 0);
            if ($validate['res'] == 'LOCKED'):
                $_POST['id_detalle'] = $result['id_detalle'];
                $_POST['ppto'] = $ppto;
                $_POST['tipo'] = $tipo;

                $this->DeleteDetail(false);
                $reverse = 'OK';
                $msg = $validate['msg'];
            endif;
        }

        echo json_encode(array('res' => $result['res'], 'reverse' => $reverse, 'msg' => $msg));
    }

    public function NewP($tipo, $pre_order = false) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);
        if ($tipo == 5) {
            $Header['array_css'][] = FILER_CSS;
        }
        $this->load->view('Template/V_Header', $Header);


        $data['tipo'] = $tipo;
        $data['pre_order'] = $pre_order;

        $data['clientes'] = $this->M_Preorden->ListarClientesNew(false, true);
        $data['servicios'] = $this->M_Preorden->CargarTipoServicio($tipo);

        switch ($tipo) {
            case 1:
                $folder = 'Aviso';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['medios'] = $this->M_Preorden->select('cat_medios', 'medio_nombre');
                $data['paginas'] = $this->M_Preorden->select('cat_paginaperiod', 'pagina_nombre');
                $data['tintas'] = $this->M_Preorden->select('cat_tintas', 'tinta_nombre');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Prensa' : 'Nuevo Presupuesto De Prensa';
                $data['tabla'] = ($pre_order) ? 'pre_orden_aviso' : 'presup_avisos';
                break;
            case 2:
                $folder = 'Clasificado';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['medios'] = $this->M_Preorden->select('cat_medios', 'medio_nombre');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Clasificado' : 'Nuevo Presupuesto De Clasificado';
                $data['tabla'] = ($pre_order) ? 'pre_orden_clasificado' : 'presup_clasificados';
                break;
            case 3:
                $folder = 'Revista';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['medios'] = $this->M_Preorden->select('cat_medios', 'medio_nombre');
                $data['tintas'] = $this->M_Preorden->select('cat_tintas', 'tinta_nombre');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Revista' : 'Nuevo Presupuesto De Revista';
                $data['tabla'] = ($pre_order) ? 'pre_orden_revista' : 'presup_revis';
                break;
            case 4:
                $folder = 'Radio';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['emisoras'] = $this->M_Preorden->select('cat_emisoras', 'emis_nombre');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Radio' : 'Nuevo Presupuesto De Radio';
                $data['tabla'] = ($pre_order) ? 'pre_orden_radio' : 'presup_radio';
                break;
            case 5:
                $folder = 'Tv';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['medios'] = $this->M_Preorden->select('cat_medios', 'medio_nombre');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De TV' : 'Nuevo Presupuesto De TV';
                $data['tabla'] = ($pre_order) ? 'pre_orden_tv' : 'presup_tv';
                break;
            case 6:
                $folder = 'Externa';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Externa' : 'Nuevo Presupuesto De Externa';
                $data['tabla'] = ($pre_order) ? 'pre_orden_externa' : 'presup_prode';
                break;
            case 7:
                $folder = 'Interna';
                $data['ordenes'] = $this->M_Preorden->ListOrdCosto($tipo);
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Interna' : 'Nuevo Presupuesto De Interna';
                $data['tabla'] = ($pre_order) ? 'pre_orden_interna' : 'presup_prodi';
                break;
            case 8:
                $folder = 'Exterior';
                $data['piezas'] = $this->M_Preorden->select('cat_piezas', 'pieza_nombre');
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Publ.Exterior' : 'Nuevo Presupuesto De Publ.Exterior';
                $data['tabla'] = ($pre_order) ? 'pre_orden_exterior' : 'publicidad_exterior';
                break;
            case 9:
                $folder = 'Impreso';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['elementos'] = $this->M_Preorden->select('cat_elementos', 'elem_nombre');
                $data['conceptos'] = $this->M_Preorden->select('cat_concepto', 'concp_nmb');
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Impreso' : 'Nuevo Presupuesto De Impreso';
                $data['tabla'] = ($pre_order) ? 'pre_orden_impreso' : 'impresos';
                break;
            case 10:
                $folder = 'Articulo';
                $data['proveedores'] = $this->M_Preorden->ListarProveedoresNew();
                $data['title'] = ($pre_order) ? 'Nueva Pre Orden De Articulos Public.' : 'Nuevo Presupuesto De Articulos Public.';
                $data['tabla'] = ($pre_order) ? 'pre_orden_articulo' : 'art_publi';
                break;

            default:
                break;
        }


        $data['detail'] = $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Table_Detail', array('detail' => array()), true);
        $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Form_New', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);
        if ($tipo == 5) {
            $Footer['array_js'][] = FILER_JS;
        }
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function UpdateDetail() {

        $tipo = $this->input->post('tipo');
        $table = $this->input->post('tabla');
        unset($_POST['tipo']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $field_id = 'psav_id';
                $field_id_detalle = 'detavi_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';
                $ppto = $this->input->post('psav_id');
                unset($_POST['psav_id']);
                $id_detalle = $this->input->post('detavi_id');

                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                break;
            case 2:
                $table_det = 'det_clasi';
                $field_id = 'pscf_id';
                $field_id_detalle = 'dclasi_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $ppto = $this->input->post('pscf_id');
                unset($_POST['pscf_id']);
                $id_detalle = $this->input->post('dclasi_id');
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';
                break;
            case 3:
                $table_det = 'det_revis';
                $field_id = 'psrev_id';
                $field_id_detalle = 'drevis_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $ppto = $this->input->post('psrev_id');
                unset($_POST['psrev_id']);
                $id_detalle = $this->input->post('drevis_id');
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                break;
            case 4:
                $table_det = 'det_radio';
                $field_id = 'psrad_id';
                $field_id_detalle = 'drad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';
                $ppto = $this->input->post('psrad_id');
                unset($_POST['psrad_id']);
                $id_detalle = $this->input->post('drad_id');

                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                break;
            case 5:
                $table_det = 'det_tv';
                $field_id = 'pstv_id';
                $field_id_detalle = 'dtv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';
                $ppto = $this->input->post('pstv_id');
                unset($_POST['pstv_id']);
                $id_detalle = $this->input->post('dtv_id');

                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';

                break;
            case 6:
                $table_det = 'det_prode';
                $field_id = 'psex_id';
                $field_id_detalle = 'dprode_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';
                $ppto = $this->input->post('psex_id');
                unset($_POST['psex_id']);
                $id_detalle = $this->input->post('dprode_id');

                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                break;
            case 7:
                $table_det = 'det_prodi';
                $field_id = 'psin_id';
                $field_id_detalle = 'dpsin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';
                $ppto = $this->input->post('psin_id');
                unset($_POST['psin_id']);
                $id_detalle = $this->input->post('dpsin_id');

                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                break;
            case 8:
                $table_det = 'det_pubext';
                $field_id = 'pubext_id';
                $field_id_detalle = 'dpubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';
                $ppto = $this->input->post('pubext_id');
                unset($_POST['pubext_id']);
                $id_detalle = $this->input->post('dpubext_id');

                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                break;
            case 9:
                $table_det = 'det_impresos';
                $field_id = 'imp_id';
                $field_id_detalle = 'dimp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';
                $ppto = $this->input->post('imp_id');
                unset($_POST['imp_id']);
                $id_detalle = $this->input->post('dimp_id');

                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                break;
            case 10:
                $table_det = 'det_artpub';
                $field_id = 'artp_id';
                $field_id_detalle = 'dartp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';
                $ppto = $this->input->post('artp_id');
                unset($_POST['artp_id']);
                $id_detalle = $this->input->post('dartp_id');

                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                break;

            default:
                break;
        }

        $old = $this->M_Preorden->SelectRow($table_det, $field_id_detalle, $id_detalle);
        $row = $this->M_Preorden->ValorTotal($field_id, $ppto, $table, $selectTotal . ',pvcl_id_clie', true);

        $reverse = '';
        $msg = '';
        $result = $this->M_Preorden->UpdateDetail($table_det, $_POST, $ppto, $table_det, $select, $field_id_detalle, $id_detalle);
        if ($result['res'] == 'OK') {
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Preorden->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));

            if ($total > $row->total) {
                $validate = $this->ValidateCredit($row->pvcl_id_clie, false, 0);
                if ($validate['res'] == 'LOCKED'):
                    $result = $this->M_Preorden->UpdateDetail($table_det, $old, $ppto, $table_det, $select, $field_id_detalle, $id_detalle);
                    $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
                    $total = $this->M_Preorden->ValorTotal($field_id, $ppto, $table, $selectTotal);
                    $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));

                    $reverse = 'OK';
                    $msg = $validate['msg'];
                endif;
            }
        }

        echo json_encode(array('res' => $result['res'], 'reverse' => $reverse, 'msg' => $msg));
    }

    function DeleteDetail($response = true) {

        $tipo = $this->input->post('tipo');
        $ppto = $ppto = $this->input->post('ppto');
        $table = $this->input->post('tabla');

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $field_id = 'psav_id';
                $field_id_detalle = 'detavi_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';


                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                break;
            case 2:
                $table_det = 'det_clasi';
                $field_id = 'pscf_id';
                $field_id_detalle = 'dclasi_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';

                break;
            case 3:
                $table_det = 'det_revis';
                $field_id = 'psrev_id';
                $field_id_detalle = 'drevis_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                break;
            case 4:
                $table_det = 'det_radio';
                $field_id = 'psrad_id';
                $field_id_detalle = 'drad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';

                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                break;
            case 5:
                $table_det = 'det_tv';
                $field_id = 'pstv_id';
                $field_id_detalle = 'dtv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';

                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';

                break;
            case 6:
                $table_det = 'det_prode';
                $field_id = 'psex_id';
                $field_id_detalle = 'dprode_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';

                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                break;
            case 7:
                $table_det = 'det_prodi';
                $field_id = 'psin_id';
                $field_id_detalle = 'dpsin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';

                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                break;
            case 8:
                $table_det = 'det_pubext';
                $field_id = 'pubext_id';
                $field_id_detalle = 'dpubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';

                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                break;
            case 9:
                $table_det = 'det_impresos';
                $field_id = 'imp_id';
                $field_id_detalle = 'dimp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';

                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                break;
            case 10:
                $table_det = 'det_artpub';
                $field_id = 'artp_id';
                $field_id_detalle = 'dartp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';

                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                break;

            default:
                break;
        }

        $result = $this->M_Preorden->DeleteDetail($ppto, $table_det, $select, $field_id_detalle, $this->input->post('id_detalle'));
        if ($result['res'] == 'OK') {
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Preorden->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));

        }
        if ($response) {
            echo json_encode(array('res' => $result['res']));
        }
    }
    
    function Anule() {
        $result = $this->M_Preorden->UpdateStatusOrden($this->input->post('tipo'), $this->input->post('ppto'), $this->input->post('status'));
        echo json_encode(array('res' => $result));
    }
    
    function UpdateInfo() {

        $ppto = $this->input->post('ppto');
        $total = $this->input->post('total');
        $tipo = $this->input->post('tipo');
        $table = $this->input->post('tabla');
        if ($tipo != 7) {
            $this->M_Preorden->UpdateOrder($this->input->post('ord_id'), array('pvcl_id_prov' => $this->input->post('pvcl_id_prov'),'ord_observacion' => $this->input->post('ord_observacion')));
            unset($_POST['ord_observacion']);
            unset($_POST['ord_id']);
        }

        unset($_POST['tipo']);
        unset($_POST['ppto']);
        unset($_POST['total']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psav_id';
                break;
            case 2:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'pscf_id';
                break;
            case 3:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psrev_id';
                break;
            case 4:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'psrad_id';
                break;
            case 5:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'pstv_id';
                break;
            case 6:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psex_id';
                break;
            case 7:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psin_id';
                break;
            case 8:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'pubext_id';
                break;
            case 9:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'imp_id';
                break;
            case 10:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'artp_id';
                break;

            default:
                break;
        }

        $result = $this->M_Preorden->UpdateInfo($field_id, $ppto, $table, $_POST);
        echo json_encode(array('res' => $result));
    }
    
    function PrintPpto($ppto, $tipo, $ord = 0, $print = 1) {

        $result = $this->M_Preorden->GetPptoCompleteInfoOrden(false, false, $tipo, $ppto, 'all', 'all', 'all');
        $result['detail'] = $this->M_Preorden->GetDetailPpto($tipo, $ppto);
        $result['tipo'] = $tipo;
        $result['print'] = $print;

        switch ($tipo) {
            case '1':
                $html = $this->load->view('Managerbudget/Ppto/Aviso/V_Pdf_Orden', $result);
                break;
            case '2':
                $html = $this->load->view('Managerbudget/Ppto/Clasificado/V_Pdf_Orden', $result);
                break;
            case '3':
                $html = $this->load->view('Managerbudget/Ppto/Revista/V_Pdf_Orden', $result);
                break;
            case '4':
                $html = $this->load->view('Managerbudget/Ppto/Radio/V_Pdf_Orden', $result);
                break;
            case '5':
                $html = $this->load->view('Managerbudget/Ppto/Tv/V_Pdf_Orden', $result);
                break;
            case '6':
                $html = $this->load->view('Managerbudget/Ppto/Externa/V_Pdf_Orden', $result);
                break;
            case '7':
                $html = $this->load->view('Managerbudget/Ppto/Interna/V_Pdf_Orden', $result);
                break;
            case '8':
                $html = $this->load->view('Managerbudget/Ppto/Exterior/V_Pdf_Orden', $result);
                break;
            case '9':
                $html = $this->load->view('Managerbudget/Ppto/Impreso/V_Pdf_Orden', $result);
                break;
            case '10':
                $html = $this->load->view('Managerbudget/Ppto/Articulo/V_Pdf_Orden', $result);
                break;

            default:
                break;
        }
    }
    
    function UpdatePrint() {
        $this->M_Preorden->UpdateStatusOrden($this->input->post('tipo'), $this->input->post('ppto'), $this->input->post('status')); 
    }
    
    function Convertir(){
        
        $data = $this->M_Preorden->GetPpto($this->orden, $this->tipo, $this->tabla);
        
        unset($data->cliente);
        unset($data->total);
        
        switch ($this->tipo) {
            case 1:
                $cab = 'presup_avisos';
                $tpo = "aviso";
                $table_Det = "det_avisos";
                $field_id = 'psav_id';
                break;
            case 2:
                $cab = 'presup_clasificados';
                $tpo = "clasificado";
                $table_Det = "det_clasi";
                $field_id = 'pscf_id';
                break;
            case 3:
                $cab = 'presup_revis';
                $tpo = "revista";
                $table_Det = "det_revis";
                $field_id = 'psrev_id';
                break;
            case 4:
                $cab = 'presup_radio';
                $tpo = "radio";
                $table_Det = "det_radio";
                $field_id = 'psrad_id';
                break;
            case 5:
                $cab = 'presup_tv';
                $tpo = "television";
                $table_Det = "det_tv";
                $field_id = 'pstv_id';
                break;
            case 6:
                $cab = 'presup_prode';
                $tpo = "externa";
                $table_Det = "det_prode";
                $field_id = 'psex_id';
                break;
            case 7:
                $cab = 'presup_prodi';
                $tpo = "interna";
                $table_Det = "det_prodi";
                $field_id = 'psin_id';
                break;
            case 8:
                $cab = 'publicidad_exterior';
                $tpo = "publicidad_exterior";
                $table_Det = "det_pubext";
                $field_id = 'pubext_id';
                break;
            case 9:
                $cab = 'impresos';
                $tpo = "impresos";
                $table_Det = "det_impresos";
                $field_id = 'imp_id';
                break;
            case 10:
                $cab = 'art_publi';
                $tpo = "articulos_publicitarios";
                $table_Det = "det_artpub";
                $field_id = 'artp_id';
                break;
        }
        
        $id_ppto = $this->M_Preorden->InsertInfo($cab, $data);
        $this->M_Preorden->InsertDetail($table_Det,$field_id,array($field_id=>$id_ppto),$this->orden);
        $this->M_Preorden->UpdateOrdProveedor($id_ppto,$this->orden,$tpo);
        $this->M_Preorden->UpdateStatusOrden($this->tipo,$this->orden, 39); 
        echo json_encode(array('ppto'=>$id_ppto,'res'=>'OK'));
    }
    
    function CopyMasive() {
        $array = explode(',', $this->input->post('pptos'));
        sort($array);
        $tipo = $this->input->post('tipo');
        $errors = '';

        $tabla = $this->showTable($tipo);
        
        $result = array('res'=>'empty');
        foreach ($array as $value) {
            
            $row = $this->M_Preorden->GetPpto($value, $tipo, $tabla['cab']);
            $validate = $this->ValidateCredit($row->cliente, false, $row->total);
            
            if ($validate['res'] != 'LOCKED') {
                $result = $this->M_Preorden->Copy($tipo, $value);
            }else{
                if($errors != '')
                    $errors .= ',';
                    
                $errors .= $value;  
            }
                
        }
        $result['errors'] = $errors;
        echo json_encode($result);
    }
    
    function showTable($tipo){
        switch ($tipo) {
            case 1:
                $data['cab'] = 'pre_orden_aviso';
                break;
            case 2:
                $data['cab']  = 'pre_orden_clasificado';
                break;
            case 3:
                $data['cab']  = 'pre_orden_revista';
                break;
            case 4:
                $data['cab']  = 'pre_orden_radio';
                break;
            case 5:
                $data['cab']  = 'pre_orden_tv';
                break;
            case 6:
                $data['cab']  = 'pre_orden_externa';
                break;
            case 7:
                $data['cab']  = 'pre_orden_interna';
                break;
            case 8:
                $data['cab']  = 'pre_orden_exterior';
                break;
            case 9:
                $data['cab']  = 'pre_orden_impreso';
                break;
            case 10:
                $data['cab']  = 'pre_orden_articulo';
                break;

            default:
                break;
        }
        return $data;
    }

}
