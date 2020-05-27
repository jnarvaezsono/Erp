<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Sgc extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;

        $this->load->model('Sgc/M_Sgc');
    }

    public function Panel() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array();
        $this->load->view('Template/V_Header', $Header);

        $this->load->view('Sgc/V_Panel');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array();
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function ListFormat() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array();
        $this->load->view('Template/V_Header', $Header);

        $data['rows'] = $this->M_Sgc->getTypesFormats();

        $this->load->view('Sgc/V_Panel_Format', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array();
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function GetTableFormat($tipo) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['type'] = $tipo;

        switch ($tipo) {
            case 1:
                $data['title'] = 'Solicitud De Vacante';
                foreach ($this->M_Sgc->LoadButtonPermissions("FORM_VACANTE") as $btn) {
                    $data[$btn->name] = $btn->name;
                }
                break;
            case 2:
                $data['title'] = 'Solicitud De Vacaciones';
                foreach ($this->M_Sgc->LoadButtonPermissions("FORM_VACACION") as $btn) {
                    $data[$btn->name] = $btn->name;
                }
                break;

            default:
                break;
        }


        $this->load->view('Sgc/V_Control_Format', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable($tipo) {
        $rows = $this->M_Sgc->GetCompleteInfo($this->input->get('start'), $this->input->get("length"), $tipo);
        $rows2 = $this->M_Sgc->GetCompleteInfo(false, false, $tipo);

        $array = array();
        foreach ($rows['result'] as $v) {

            $btn = '<div class="btn-group btnI' . $v->id_solicitud . '"  >
                        <button  type="button" class="btn1-' . $v->id_solicitud . ' btn btn-' . $v->color . ' btn-xs btn-left">' . $v->estado . '</button>
                            <button type="button" class="btn2-' . $v->id_solicitud . ' btn btn-' . $v->color . ' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';

            $btn .= '<ul class="dropdown-menu u-' . $v->id_solicitud . '" role="menu">';

            $btn .= '<li onclick="ViewRequest(' . $v->id_solicitud . ',' . $tipo . ')"><a href="#"><i class="fa fa-fw fa-search"></i> Ver</a></li>';
            $btn .= '</ul></div>';


            $array[] = array($v->id_solicitud, $v->fecha, $v->usuario, $v->tipo, $btn);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }

    function NewP($tipo) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, ICHECK_CSS_FLAT);
        $this->load->view('Template/V_Header', $Header);

        switch ($tipo) {
            case 1:
                $folder = 'Vacante';
                $data['cargos'] = $this->M_Sgc->getCargos();
                break;
            case 2:
                $folder = 'Vacaciones';
                break;
            default:
                break;
        }

        $data['tipo'] = $tipo;
        $this->load->view('Sgc/' . $folder . '/V_Form_New', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function EditForm($id, $tipo) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, ICHECK_CSS_FLAT);
        $this->load->view('Template/V_Header', $Header);

        $data['row'] = $this->M_Sgc->GetInfo($id, $tipo);

        switch ($tipo) {
            case 1:
                $folder = 'Vacante';
                $data['cargos'] = $this->M_Sgc->getCargos();
                break;
            case 2:
                $folder = 'Vacaciones';
                break;

            default:
                break;
        }
        $data['tipo'] = $tipo;
        $data['id'] = $id;
        $this->load->view('Sgc/' . $folder . '/V_Form_Edit', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function Edit($id, $tipo) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, ICHECK_CSS_FLAT);
        $this->load->view('Template/V_Header', $Header);

        $data['row'] = $this->M_Sgc->GetInfo($id, $tipo);
        $btns = array();

        switch ($tipo) {
            case 1:
                $folder = 'Vacante';
                foreach ($this->M_Sgc->LoadButtonPermissions("FORM_VACANTE") as $btn) {
                    $data[$btn->name] = $btn->name;
                }
                break;
            case 2:
                $folder = 'Vacaciones';
                foreach ($this->M_Sgc->LoadButtonPermissions("FORM_VACACION") as $btn) {
                    $data[$btn->name] = $btn->name;
                }
                break;

            default:
                break;
        }
        $data['tipo'] = $tipo;
        $data['id'] = $id;

        $result_Coment = $this->M_Sgc->ListarComentarios($id);
        $data['comment'] = $this->load->view('Sgc/V_Comment', array("comments" => $result_Coment), true);
        $this->load->view('Sgc/' . $folder . '/V_Info_Solicitud', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ShowDay() {
        $days = $this->M_Sgc->festivos();
        foreach ($days as $v) {
            $festivos[] = $v->fecha;
        }

        $result = $this->getDiasHabiles2($this->input->post('inicio'), $this->input->post('fin'), $festivos, false, true);
        echo json_encode(array('num' => count($result)));
    }

    function InsertInfo() {

        $tipo = $this->input->post('tipo');
        unset($_POST['tipo']);

        $data = array(
            'id_usuario' => $this->session->IdUser,
            'id_tipo_formato' => $tipo
        );
        
        switch ($tipo) {
            case 1:
                $table = 'sys_solicitud_vacante';
                break;
            case 2:
                $table = 'sys_solicitud_vacaciones';
                $data['solicitado_a'] = $this->input->post('solicitado_a');
                break;
            default:
                break;
        }
        unset($_POST['solicitado_a']);

        $id = $this->M_Sgc->SaveData('sys_solicitud_formato', $data);
        $_POST['id_solicitud'] = $id;

        

        $result = $this->M_Sgc->SaveData($table, $_POST);

        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Sgc.php";
        if (SO_SERVER == 'windows') {
            $cmd = "C:/xampp/php/php.exe $ruta";
            pclose(popen("start /B " . $cmd . " --op=newrequest --tipo=" . $tipo . " --id_solicitud=" . $id . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser, "w"));
        } else {
            exec("php -q $ruta --op=newrequest --tipo=" . $tipo . "  --id_solicitud=" . $id . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser . " > /dev/null &");
        }

        echo json_encode(array('res' => ($result > 0) ? 'OK' : 'Error'));
    }

    function UpdateInfo() {

        $tipo = $this->input->post('tipo');
        $id_solicitud = $this->input->post('id_solicitud');
        unset($_POST['tipo']);
        unset($_POST['id_solicitud']);

        $data = array(
            'id_usuario_mod' => $this->session->IdUser
        );
        
        if($tipo == 2){
            $data['solicitado_a'] = $this->input->post('solicitado_a');
        }
        unset($_POST['solicitado_a']);
        
        if($tipo == 2){
            $data['ok_jefe'] = NULL;
            $data['ok_gerente'] = NULL;
            $data['ok_nomina'] = NULL;
        }
        
        $this->M_Sgc->UpdateData('sys_solicitud_formato', 'id_solicitud', $id_solicitud, $data);

        switch ($tipo) {
            case 1:
                $table = 'sys_solicitud_vacante';
                break;
            case 2:
                $table = 'sys_solicitud_vacaciones';
                break;
            default:
                break;
        }


        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Sgc.php";
        if (SO_SERVER == 'windows') {
            $cmd = "C:/xampp/php/php.exe $ruta";
            pclose(popen("start /B " . $cmd . " --op=updaterequest --tipo=" . $tipo . " --id_solicitud=" . $id_solicitud . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser, "w"));
        } else {
            exec("php -q $ruta --op=updaterequest --tipo=" . $tipo . "  --id_solicitud=" . $id_solicitud . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser . " > /dev/null &");
        }

        $array = array();
        $res = $this->db->select('*')
                ->from($table)
                ->where('id_solicitud', $id_solicitud)
                ->get();

        $fila_old = $res->row();

        $fila_new = array();
        $old = array();
        $new = array();

        foreach ($_POST as $key => $value):
            if ($_POST[$key] != $fila_old->$key) { // Identifica los campos que fueron modificados
                $old[$key] = $fila_old->$key;
                $new[$key] = $_POST[$key];
            }
        endforeach;

        foreach ($old as $key => $value) {
            $old = $this->buscarNombrePorID($key, $value, $old, "old");
        }

        foreach ($new as $key => $value) {
            $new = $this->buscarNombrePorID($key, $value, $new, "new");
        }

        if (count($old) && count($new)) {
            $texto = "";
            foreach ($old as $key => $value) {
                $texto .= strtoupper(str_replace('_', ' ', $key)) . " Cambio De <b>" . (empty($value) ? 'Vacio' : $value) . "</b> A <b>" . (empty($new[$key]) ? 'Vacio' : $new[$key]) . "</b><br / >";
            }
            $data = array(
                "id_solicitud" => $id_solicitud,
                "id_user" => $this->session->IdUser,
                "texto" => $texto
            );
            $result = $this->M_Sgc->NewComment($data);
        }
        
        $result = $this->M_Sgc->UpdateData($table, 'id_solicitud', $id_solicitud, $_POST);
        
        

        echo json_encode(array('res' => ($result > 0) ? 'OK' : 'Error'));
    }

    function buscarNombrePorID($tipo, $id, &$array, $tipo_info = false) {

        switch ($tipo) {
            case 'pc':
            case 'email':
            case 'carpetas_red':
            case 'erp':
            case 'sap':
            case 'adobe':
            case 'vpn':
            case 'ftp':
            case 'delegado':
            case 'puesto_trabajo':
                $array[$tipo] = ($id > 0) ? 'SI' : 'NO';
                break;

            default:
                $array[$tipo] = $id;
                break;
        }
        return $array;
    }

    function aproveOther() {
        $tipo = $this->input->post('tipo');
        $id_solicitud = $this->input->post('id_solicitud');

        switch ($tipo) {
            case 1:
                $data = array(
                    'ok_sistemas' => 1
                );
                $this->M_Sgc->UpdateData('sys_solicitud_vacante', 'id_solicitud', $id_solicitud, $data);
                $texto = 'Confirmó los accesos y equipos solicitados para esta vacante.';
                break;
        }

        $data = array(
            "id_solicitud" => $id_solicitud,
            "id_user" => $this->session->IdUser,
            "texto" => $texto
        );
        $result = $this->M_Sgc->NewComment($data);

        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Sgc.php";
        if (SO_SERVER == 'windows') {
            $cmd = "C:/xampp/php/php.exe $ruta";
            pclose(popen("start /B " . $cmd . " --op=aproveother --tipo=" . $tipo . " --id_solicitud=" . $id_solicitud . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser, "w"));
        } else {
            exec("php -q $ruta --op=aproveother --tipo=" . $tipo . "  --id_solicitud=" . $id_solicitud . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser . " > /dev/null &");
        }
    }

    function ChangeStatus() {
        $tipo = $this->input->post('tipo');
        $id = $this->input->post('id_solicitud');

        $data = array(
            'id_estado' => $this->input->post('id_estado'),
            'id_usuario_mod' => $this->session->IdUser
        );

        if ($this->input->post('id_estado') == 12) {
            $op = 'Noaprobado';
            if ($tipo == 2) {
                if ($this->session->IdRol == 14) {
                    $data['ok_gerente'] = NULL;
                } else if ($this->session->IdRol == 4) {
                    $data['ok_nomina'] = NULL;
                } else {
                    $data['ok_jefe'] = NULL;
                }
            }
            $txt = 'No Aprobó la solicitud <br />Motivo: '.$this->input->post('motivo');
        } elseif ($this->input->post('id_estado') == 21 || $this->input->post('id_estado') == 8) {
            $op = 'Aprobado';
            if ($tipo == 2) {
                if ($this->session->IdRol == 14) {
                    $data['ok_gerente'] = date('Y-m-d H:i:s');
                } else if ($this->session->IdRol == 4) {
                    $data['ok_nomina'] = date('Y-m-d H:i:s');
                } else {
                    $data['ok_jefe'] = date('Y-m-d H:i:s');
                }
            }
            $txt = 'Aprobó la solicitud';
        } elseif ($this->input->post('id_estado') == 4) {
            $op = 'Anulado';
            $txt = 'Anuló la solicitud';
        }



        $result = $this->M_Sgc->UpdateData('sys_solicitud_formato', 'id_solicitud', $this->input->post('id_solicitud'), $data);

        $data = array(
            "id_solicitud" => $id,
            "id_user" => $this->session->IdUser,
            "texto" => $txt
        );
        $this->M_Sgc->NewComment($data);

        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Sgc.php";
        if (SO_SERVER == 'windows') {
            $cmd = "C:/xampp/php/php.exe $ruta";
            pclose(popen("start /B " . $cmd . " --op=" . $op . " --tipo=" . $tipo . " --id_solicitud=" . $id . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser, "w"));
        } else {
            exec("php -q $ruta --op=" . $op . " --tipo=" . $tipo . " --id_solicitud=" . $id . " --creador=" . $this->session->IdUser . " --nombre=" . $this->session->NameUser . " > /dev/null &");
        }

        echo json_encode(array('res' => ($result > 0) ? 'OK' : 'Error'));
    }
    

}
