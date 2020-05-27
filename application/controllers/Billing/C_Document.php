<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Document extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Billing/M_Document');
    }

    public function Panel() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, RANGOPICKER_CSS, ICHECK_CSS_RED, DATEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2);
        $this->load->view('Template/V_Header', $Header);

        $data = array();
        foreach ($this->M_Document->LoadButtonPermissions("DOC") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $this->load->view('Billing/Document/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, MOMENT, RANGOPICKER_JS, ICHECK_JS, DATEPICKER_JS, ALERTIFY_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable() {
        $rows = $this->M_Document->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), false);
        $rows2 = $this->M_Document->GetPptoCompleteInfo(false, false, false);

        $btns = $this->M_Document->LoadButtonPermissions("DOC");

        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        $array = array();
        foreach ($rows['result'] as $v) {

            $btn = '<div class="btn-group btnI' . $v->id . '" >
                        <button  type="button" class="btn1-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs btn-left">' . $v->estado . '</button>
                            <button type="button" class="btn2-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';

            $btn .= '<ul class="dropdown-menu u-' . $v->id . '" role="menu">';
            $btn .= '<li onclick="printPdf(' . $v->id . ')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn .= (isset($BtnEditDoc) && ($v->id_estado == 1)) ? '<li onclick="EditPpto(' . $v->id . ')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>' : '';
            $btn .= (isset($BtnAnuleDoc) && (($v->id_estado == 1) || ($v->id_estado == 5))) ? '<li onclick="Anule(' . $v->id . ',\'' . $v->tipo . '\',' . $v->doc . ')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>' : '';
            $btn .= '</ul></div>';


            $array[] = array($btn, $v->id, $v->fecha, $v->tipo, $v->doc, explode(' ', $v->usuario)[0], '$ ' . number_format($v->total, 2, ',', '.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }

    function PrintDoc($doc) {
        $result = $this->M_Document->GetPptoCompleteInfo(false, false, $doc);
        $html = $this->load->view('Billing/Document/V_Pdf', $result);
    }

    function Anule() {
        $result = $this->M_Document->UpdateStatus($this->input->post('id'), $this->input->post('status'));

        if ($this->input->post('tpo_doc') == 'costo') {
            $this->M_Document->enableOrderCost($this->input->post('id_doc'));
        } else if ($this->input->post('tpo_doc') == 'gasto') {
            $this->M_Document->enableOrderGast($this->input->post('id_doc'));
        } else {
            $this->M_Document->enableOrderExt($this->input->post('id_doc'), 0);
        }

        //$this->M_Document->UpdateInfo($this->input->post('id'),array('id_doc'=>NULL,'pvcl_id'=>NULL,'docequi_valor'=>0,'docequi_total'=>0,'docequi_detalle'=>NULL));

        echo json_encode(array('res' => $result));
    }

    function UpdatePrint() {
        $this->M_Document->UpdateStatus($this->input->post('id'), $this->input->post('status'));
    }

    public function NewP() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);

        $this->load->view('Template/V_Header', $Header);
        
        $result['ant'] = $this->M_Document->GetClose_Old(false);
        $result['act'] = $this->M_Document->GetClose_Old(true);
        
        $this->load->view('Billing/Document/V_Form_New',$result);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);

        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Edit($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);

        $this->load->view('Template/V_Header', $Header);

        $data['id'] = $id;
        $data['row'] = $this->M_Document->GetDoc($id);
        $data['proveedores'] = $this->M_Document->ListarProveedoresNew($data['row']->pvcl_id);
        $this->load->view('Billing/Document/V_Form_Update', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);

        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function LoadOrder() {
        if ($this->input->post('tipo') == 'costo') {
            $data['orders'] = $this->M_Document->GetOrdCost();
        } elseif ($this->input->post('tipo') == 'gasto') {
            $data['orders'] = $this->M_Document->GetOrdGast();
        }
        echo json_encode($data);
    }

    function LoadOrderE() {

        $result = $this->M_Document->GetOrdExt($this->input->post('order'));

        if ($result['num'] > 0):
            $order = $result['result'];

            if ($order->doc == 0) {
                switch ($order->tpo_doc) {
                    case "aviso":
                        $table = 'presup_avisos';
                        $field_id = 'psav_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, psav_valor as valor,"" as detalle';
                        $where_status = 'psav_estado in (4,5,7)';
                        $table_det = 'det_avisos';
                        $select_detail = 'detavi_detalle as detalle';
                        break;
                    case "clasificado":
                        $table = 'presup_clasificados';
                        $field_id = 'pscf_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, pscf_valor as valor,"" as detalle';
                        $where_status = 'pscf_estado in (4,5,7)';
                        $table_det = 'det_clasi';
                        $select_detail = 'dclasi_detalle as detalle';
                        break;
                    case "revista":
                        $table = 'presup_revis';
                        $field_id = 'psrev_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, psrev_valor as valor,"" as detalle';
                        $where_status = 'psrev_estado in (4,5,7)';
                        $table_det = 'det_revis';
                        $select_detail = 'drevis_detalle as detalle';
                        break;
                    case "radio":
                        $table = 'presup_radio';
                        $field_id = 'psrad_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, psrad_valor as valor,"" as detalle';
                        $where_status = 'psrad_estado in (4,5,7)';
                        $table_det = 'det_radio';
                        $select_detail = 'drad_detalle as detalle';
                        break;
                    case "television":
                        $table = 'presup_tv';
                        $field_id = 'pstv_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, pstv_valor as valor,"" as detalle';
                        $where_status = 'pstv_estado in (4,5,7)';
                        $table_det = 'det_tv';
                        $select_detail = 'dtv_detalle as detalle';
                        break;
                    case "externa":
                        $table = 'presup_prode';
                        $field_id = 'psex_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, psex_valor as valor,"" as detalle';
                        $where_status = 'psex_estado in (4,5,7)';
                        $table_det = 'det_prode';
                        $select_detail = 'dprode_detalle as detalle';
                        break;
                    case "publicidad_exterior":
                        $table = 'publicidad_exterior';
                        $field_id = 'pubext_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, pubext_valor as valor,"" as detalle';
                        $where_status = 'est_id in (4,5,7)';
                        $table_det = 'det_pubext';
                        $select_detail = 'dpubext_detalle as detalle';
                        break;
                    case "impresos":
                        $table = 'impresos';
                        $field_id = 'imp_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, imp_valor as valor,"" as detalle';
                        $where_status = 'est_id in (4,5,7)';
                        $table_det = 'det_impresos';
                        $select_detail = 'dimp_observacion as detalle';
                        break;
                    case "articulos_publicitarios":
                        $table = 'art_publi';
                        $field_id = 'artp_id';
                        $select = $order->ord_id . ' as order,nombre as proveedor, pvcl_id_prov as id_prov, artp_valor as valor,"" as detalle';
                        $where_status = 'est_id in (4,5,7)';
                        $table_det = 'det_artpub';
                        $select_detail = 'dartp_caracteristicas as detalle';
                        break;

                    default:
                        break;
                }
                $rs = $this->M_Document->infoPresup($select, $table, $field_id, $order->doc_id, $where_status);

                if ($rs['num'] > 0):
                    $info = $rs['result'];
                    $rsDetail = $this->M_Document->infoDetailPresup($select_detail, $table_det, $field_id, $order->doc_id);

                    foreach ($rsDetail as $v) {
                        $info->detalle .= $v->detalle . ' | ';
                    }

                    $data = array('res' => 'success', 'datos' => $info);
                else:
                    $data = array('res' => 'warning', 'msg' => 'Asegurate que la orden no este activa y el proveedor pertenezca al regimen simplificado');
                endif;
            }else {
                $data = array('res' => 'warning', 'msg' => 'Esta Orden ya esta asignada a un documento equivalente');
            }
        else:
            $data = array('res' => 'error', 'msg' => 'Este numero de orden no existe');
        endif;

        echo json_encode($data);
    }

    function InsertInfo() {
        
        $result = $this->M_Document->InsertInfo($_POST);

        if ($this->input->post('tpo_doc') == 'costo') {
            $this->M_Document->disableOrderCost($this->input->post('id_doc'));
        } elseif ($this->input->post('tpo_doc') == 'gasto') {
            $this->M_Document->disableOrderGast($this->input->post('id_doc'));
        } else {
            $this->M_Document->enableOrderExt($this->input->post('id_doc'), 1);
        }

        echo json_encode($result);
    }

    function UpdateInfo() {
        $docequi_id = $this->input->post('docequi_id');

        unset($_POST['docequi_id']);

        $row = $this->M_Document->GetDoc($docequi_id);

        if ($row->id_doc != $this->input->post('id_doc')) {
            if ($row->tpo_doc == 'costo') {
                $this->M_Document->enableOrderCost($row->id_doc);
            } elseif ($row->tpo_doc == 'gasto') {
                $this->M_Document->enableOrderGast($row->id_doc);
            } else {
                $this->M_Document->enableOrderExt($row->id_doc, 0);
            }

            if ($this->input->post('tpo_doc') == 'costo') {
                $this->M_Document->disableOrderCost($this->input->post('id_doc'));
            } elseif ($this->input->post('tpo_doc') == 'gasto') {
                $this->M_Document->disableOrderGast($this->input->post('id_doc'));
            } else {
                $this->M_Document->enableOrderExt($this->input->post('id_doc'), 1);
            }
        }

        $result = $this->M_Document->UpdateInfo($docequi_id, $_POST);

        echo json_encode(array('res' => $result));
    }

    function LoadDetail() {

        if ($this->input->post('tipo') == 'costo') {
            $data = $this->M_Document->GetOrdCost($this->input->post('order'));
        } elseif ($this->input->post('tipo') == 'gasto') {
            $data = $this->M_Document->GetOrdGast($this->input->post('order'));
        } 
        echo json_encode($data);
    }
    
    function GetMonthClose(){
        $data = $this->M_Document->GetLastPeriodo();
        echo json_encode(array('periodo_new'=>$data->periodo_new,'periodo_old'=>$data->periodo_old));
    }
    
    function Close(){
        $result = $this->M_Document->GetDocEnable($this->input->post('periodo_new'));
        if($result['num'] > 0){
            $res = 'WARNING';
            $msg = 'Aún hay documentos equivalentes activos en el periodo '.$this->input->post('periodo_new');
        }else{
            $data = array(
                'id_user' => $this->session->IdUser,
                'tipo' => 'doc',
                'periodo' => $this->input->post('periodo_new')
            );
            $rs = $this->M_Document->SaveData('sys_cierre',$data);
            if($rs > 0){
                $res = 'OK';
                $msg = 'Cierre ejecutado correctamente';
            }else{
                $res = 'ERROR';
            }
        }
        
        echo json_encode(array('res'=>$res,'msg'=>$msg));
    }

}
