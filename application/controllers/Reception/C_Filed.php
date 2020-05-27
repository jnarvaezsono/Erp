<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Filed extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Reception/M_Filed');
    }

    public function Panel() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, RANGOPICKER_CSS, ICHECK_CSS_RED, DATEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2);
        $this->load->view('Template/V_Header', $Header);

        $data = array();
        foreach ($this->M_Filed->LoadButtonPermissions("RADICADO") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $this->load->view('Reception/Filed/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, MOMENT, RANGOPICKER_JS, ICHECK_JS, DATEPICKER_JS, ALERTIFY_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable() {
        $rows = $this->M_Filed->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), false);
        $rows2 = $this->M_Filed->GetPptoCompleteInfo(false, false, false);

        $btns = $this->M_Filed->LoadButtonPermissions("RADICADO");

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
            //$btn .= '<li onclick="printPdf(' . $v->id . ')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn .= (isset($BtnEditRad) && ($v->id_estado == 1)) ? '<li onclick="EditPpto(' . $v->id . ')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>' : '';
            $btn .= (isset($BtnAprobRad) && ($v->id_estado == 1)) ? '<li onclick="Aprobe(' . $v->id . ')"><a href="#"><i class="fa fa-fw fa-check"></i> Aprobar</a></li>' : '';
            $btn .= (isset($BtnAprobRad) && ($v->id_estado == 1)) ? '<li onclick="Anule(' . $v->id . ')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>' : '';
            $btn .= '</ul></div>';


            $array[] = array($btn, $v->id, $v->fecha, $v->proveedor, $v->tipo, $v->doc, '$' . number_format($v->total, 2, ',', '.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }
    
    public function NewP() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array( ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);

        $this->load->view('Template/V_Header', $Header);

        $this->load->view('Reception/Filed/V_Form_New');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array( ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);

        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Edit($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array( ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS);

        $this->load->view('Template/V_Header', $Header);

        $data['id'] = $id;
        $data['row'] = $this->M_Filed->GetPptoCompleteInfo(false,false,$id);
        $data['totals'] = $this->M_Filed->GetTotals($id);
        $data['details'] = $this->M_Filed->GetDetails($id);
        $data['proveedores'] = $this->M_Filed->ListarProveedoresNew();
        $this->load->view('Reception/Filed/V_Form_Update', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array( ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC);

        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function SearchOrder(){
        switch ($this->input->post('tipo')) {
            case 'externa':

                break;
            case 'costo':

                break;
            case 'gasto':

                break;

            default:
                break;
        }
    }
}
