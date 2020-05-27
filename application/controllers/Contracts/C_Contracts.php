<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Contracts extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Contracts/M_Contracts');
    }

    public function GetList() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['rows'] = $this->M_Contracts->GetList();
        
        $this->load->view('Contracts/V_Panel',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,MOMENT, RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Form($id = false) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,DATEPICKER_CSS,SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        if($id){
            $info = $this->M_Contracts->GetRow($id);
            if($info->parte == 'CLIENTE'){
                $result = $this->M_Contracts->ListarClientesNew();
            }else{
                $result = $this->M_Contracts->ListarProveedoresNew();
            }
            $renov = $this->M_Contracts->GetRenovation($id);
            
            $idC = $this->M_Contracts->MaxRenovation($id);
            $family = $this->M_Contracts->getFamilyContracts($id);
            foreach ($family as $f) {
                $data['history'] = $this->M_Contracts->getHistory($f->id);
                $history[$f->id] = $this->load->view('Contracts/V_Contracts_History',$data,true);
            }
            $this->load->view('Contracts/V_Form_Update',array('clientes'=>$result,'info'=>$info,'renov'=>$renov, 'id'=>$idC, 'history'=>$history));
        }else{
            $result = $this->M_Contracts->ListarClientesNew();
            $this->load->view('Contracts/V_Form',array('clientes'=>$result));
        }

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS,SELECT2_JS,DATEPICKER_JS,SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function LoadClients(){
        if($this->input->post('parte') == 'CLIENTE'){
            $result = $this->M_Contracts->ListarClientesNew();
        }else{
            $result = $this->M_Contracts->ListarProveedoresNew();
        }
        
        echo json_encode($result);
        
    }
    
    function Create(){
        $result = $this->M_Contracts->Create();
        echo json_encode(array('res'=>$result));
    }
    
    function Anule(){
        $result = $this->M_Contracts->Anule($this->input->post('id'));
        $data = array(
            "id_contrato" => $this->input->post('id'),
            "id_user" => $this->session->IdUser,
            "texto" => 'Anulación de contrato <br />Motivo: '.$this->input->post('motivo'),
        );
        $this->M_Contracts->NewHistory($data);

        $d['history'] = $this->M_Contracts->getHistory($this->input->post('id'));
        $history = $this->load->view('Contracts/V_Contracts_History',$d,true);
        
        echo json_encode(array('res'=>$result,'history'=>$history));
    }
    
    function Renovate(){
        
        $fila_old = $this->M_Contracts->GetRow($this->input->post('id'));
        $_POST['valor'] = str_replace('.', '', $_POST['valor']);
        
        $fila_new = array();
        $old = array();
        $new = array();
        foreach ($_POST as $key => $value):
            if ($_POST[$key] == '' && $fila_old->$key == 0) {
                unset($fila_new[$key]);
                unset($fila_old->$key);
            } elseif ($_POST[$key] != $fila_old->$key) { // Identifica los campos que fueron modificados
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
                "id_contrato" => $this->input->post('id'),
                "id_user" => $this->session->IdUser,
                "texto" => 'Adición de Otro si:<br />'.$texto,
            );
            $result = $this->M_Contracts->NewHistory($data);
        }
        
        $this->M_Contracts->UpdateOld($this->input->post('other'));
        unset($_POST['id']);
        $result = $this->M_Contracts->Create();
        
        echo json_encode(array('res'=>$result));
    }
    
    function Update(){
        
        $fila_old = $this->M_Contracts->GetRow($this->input->post('id'));
        $_POST['valor'] = str_replace('.', '', $_POST['valor']);
        
        $fila_new = array();
        $old = array();
        $new = array();
        foreach ($_POST as $key => $value):
            if ($_POST[$key] == '' && $fila_old->$key == 0) {
                unset($fila_new[$key]);
                unset($fila_old->$key);
            } elseif ($_POST[$key] != $fila_old->$key) { // Identifica los campos que fueron modificados
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
        
        $history = '';
        if (count($old) && count($new)) {
            $texto = "";
            foreach ($old as $key => $value) {
                $texto .= strtoupper(str_replace('_', ' ', $key)) . " Cambio De <b>" . (empty($value) ? 'Vacio' : $value) . "</b> A <b>" . (empty($new[$key]) ? 'Vacio' : $new[$key]) . "</b><br / >";
            }
            $data = array(
                "id_contrato" => $this->input->post('id'),
                "id_user" => $this->session->IdUser,
                "texto" => $texto,
            );
            $result = $this->M_Contracts->NewHistory($data);
            
            $d['history'] = $this->M_Contracts->getHistory($this->input->post('id'));
            $history = $this->load->view('Contracts/V_Contracts_History',$d,true);
        }
        
        $result = $this->M_Contracts->Update();
        
        echo json_encode(array('res'=>$result,'history'=>$history));
    }
    
    function buscarNombrePorID($tipo, $id, &$array, $tipo_info = false) {

        switch ($tipo) {
            case 'contra_parte':
                $res = $this->db->select('nombre')->from('sys_clients')->where('id_client', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->nombre : 'Vacio';
                break;
            
            default:
                $array[$tipo] = $id;
                break;
        }
        return $array;
    }
    
    function GetListTable($tipo,$ppto,$fecha_ini,$fecha_fin) {
        $rows = $this->M_Manager->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), $tipo, $ppto,$fecha_ini,$fecha_fin);
        $rows2 = $this->M_Manager->GetPptoCompleteInfo(false, false, $tipo, $ppto,$fecha_ini,$fecha_fin);
          
        foreach ($this->M_Manager->LoadButtonPermissions("PPTO") as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        
        $array = array();
        foreach ($rows['result'] as $v) { 
            
            $btn = '<div class="btn-group btnI'.$v->id.'" orden="'.$v->orden.'">
                        <button  type="button" class="btn1-'.$v->id.' btn btn-'.$v->est_color.' btn-xs">'.$v->estado.'</button>
                            <button type="button" class="btn2-'.$v->id.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
            
            $btn    .= '<ul class="dropdown-menu u-'.$v->id.'" role="menu">';
            $btn    .= '<li onclick="printPdf('.$v->id.')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn    .= (isset($BtnEditPpto) && ($v->id_estado == 1 && $v->impresiones == -1))? '<li><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>':'';
            $btn    .= (isset($BtnAnulePpto) && (($v->id_estado == 1 && $v->impresiones == -1) || ($v->id_estado == 5)))? '<li onclick="Anule('.$v->id.')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>':'';
            $btn    .= (isset($BtnDupliPpto) && ($v->id_estado == 9999 || $v->id_estado == 38) )? '<li onclick="copy('.$v->id.')"><a href="#"><i class="fa fa-fw fa-copy"></i> Duplicar</a></li>':'';
            $btn    .= (isset($BtnAddOrderPpto) && $v->id_estado == 5  )? '<li><a href="#"><i class="fa fa-fw fa-plus"></i> Add Orden</a></li>':'';
            $btn    .= '</ul></div>';
            

            $array[] = array($v->id, $v->fecha, $v->cliente, $v->proveedor, $v->campana,$v->usuario,  number_format($v->total,0,',','.'), $btn);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }
    
    function Expiration(){
        
        $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Notification.php";
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 2 MONTH)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=2M --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=2M --id_contrato=" . $value->id_contrato. " > /dev/null &");
            }
            echo "2M";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=1M --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=1M --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "1M";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 3 WEEK)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=3W --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=3W --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "3W";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 2 WEEK)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=2W --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=2W --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "2W";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 1 WEEK)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=1W --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=1W --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "1W";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 6 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=6D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=6D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "6D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 5 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=5D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=5D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "5D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 4 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=4D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=4D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "4D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 3 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=3D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=3D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "3D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 2 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=2D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=2D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "2D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY)');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=1D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=1D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "1D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration('CURRENT_DATE()');
        foreach ($result as $value) :
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --option=0D --id_contrato=" . $value->id_contrato , "w"));
            } else {
                exec("php -q $ruta --option=0D --id_contrato=" . $value->id_contrato . " > /dev/null &");
            }
            echo "0D";
        endforeach;
        
        $result = $this->M_Contracts->Expiration();
        foreach ($result as $value) :
            $this->M_Contracts->updateExpired($value->id_contrato);
           
            echo "00";
        endforeach;
    }
    
    function ShowContracts(){
        $result = $this->M_Contracts->ShowOtherContracts($this->input->post('id'));
        $table = 'Sin Datos';
        if($result['num']>0){
            $table = $this->load->view('Contracts/V_Subtable', $result,TRUE);
        }
        echo json_encode(array('table'=>$table));
    }
    
}
