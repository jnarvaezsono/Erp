<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Help extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Help/M_Help');
    }

    public function Panel() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, ALERTIFY_CSS2);
        $this->load->view('Template/V_Header', $Header);

        foreach ($this->M_Help->LoadButtonPermissions("HELP") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $left['row'] = $this->M_Help->getIndicators();
        $data['areas'] = $this->M_Help->select('sys_area','descripcion');
        $data['left'] = $this->load->view('Help/V_Left', $left, true);
        $data['right'] = $this->load->view('Help/V_Right', false, true);
        $this->load->view('Help/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function GetListTable() {
        
        $rows = $this->M_Help->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"));
        $all = $this->M_Help->GetPptoCompleteInfo(false,false);
        $array = array();

        foreach ($rows['result'] as $v) {
            $stars = '';
            if($v->calificacion > 0){
                for ($i = 1; $i <= $v->calificacion; $i++) {
                    $stars .= '<a href="#"><i class="fa fa-star text-yellow"></i></a>';
                }
                $rest = 5 - $v->calificacion;
                for ($i = 1; $i <= $rest; $i++) {
                    $stars .= '<a href="#"><i class="fa fa-star-o text-yellow"></i></a>';
                }
            }else{
                if($this->session->IdUser == $v->id_user):
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= '<a href="#" onclick="qualify('.$i.','.$v->id.',this)"><i class="fa fa-star-o text-yellow"></i></a>';
                    }
                else:
                    for ($i = 1; $i <= 5; $i++) {
                        $stars .= '<a href="#" onclick="qualify(0,0,this)"><i class="fa fa-star-o text-yellow"></i></a>';
                    }
                endif;
            }
            
            $check = ($v->id_status != 25)?"disabled":"";
           
            if($v->id_status == 25){
                $icon = '<i class="fa fa-warning" style="color: '.$v->color.'">';
            }elseif($v->id_status == 26){
                $icon = '<i class="fa fa-check" style="color: '.$v->color.'">';
            }elseif($v->id_status == 4){
                $icon = '<i class="fa fa-times" style="color: '.$v->color.'">';
            }
            
            $sub = '';
            if(empty($v->subservicio)):
                $sub = '<i id="war-'.$v->id.'" class="fa fa-warning text-yellow"></i>';
            endif;
            
            $array[] = array(
                '<input type="checkbox" class="ck" id="ck-'.$v->id.'" '.$check.' value="'.$v->id.'">',
                '<a href="#" onclick="openDetail('.$v->id.')" style="color: '.$v->color.'">'.$v->id.' '.$icon.'</i></a>',
                '<b><a href="#" onclick="openDetail('.$v->id.','.$v->id_status.')" style="color: '.$v->color.'">'.$v->usuario.'</a></b> - '.$sub.' '.$v->descripcion,
                $v->fecha,
                $stars
            );
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function NewT(){
        $result = $this->M_Help->SaveData('sys_tickets',$_POST);
        
        if ($result > 0) {
            $res = array('res' => 'OK', 'id' => $result);
            $data['row'] = $this->M_Help->getIndicators();
            $res['indicator'] = $this->load->view('Help/V_Left', $data, true);
            
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/SendTicket.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --op=newticket --id_ticket=" . $result . " --creador=" . $this->session->IdUser, "w"));
            } else {
                exec("php -q $ruta --op=newticket --id_ticket=" . $result . " --creador=" . $this->session->IdUser . " > /dev/null &");
            }
            
        } else {
            $res = array('res' => 'error', 'id' => '0');
        }
        
        
        echo json_encode($res);
    }
    
    function openDetail(){
        $result = $this->M_Help->GetInfo($this->input->post('id'));
        echo json_encode($result);
    }
    
    function GetTicketNotQualified(){
        $result = $this->M_Help->GetTicketNotQualified($this->session->IdUser);
        echo json_encode(array('res'=>$result));
    }
    
    function Update(){
        $result = $this->M_Help->UpdateData(
                    'sys_tickets',
                    'id_ticket',
                    $this->input->post('id'),
                    array($this->input->post('field') => $this->input->post('valor'),'id_user_mod'=>$this->session->IdUser)
        );
        
        echo json_encode(array('res'=>$result));
    }
    
    function qualify(){
         $result = $this->M_Help->UpdateData(
                    'sys_tickets',
                    'id_ticket',
                    $this->input->post('id'),
                    array($this->input->post('field') => $this->input->post('valor'),'id_user_mod'=>$this->session->IdUser)
        );
        $data['row'] = $this->M_Help->getIndicators();
        $left = $this->load->view('Help/V_Left', $data, true);
        echo json_encode(array('res'=>$result,'indicator'=>$left));
    }
    
    function CancelAndAprobe(){
        foreach ($this->input->post('tickets')as $id) {
            $result = $this->M_Help->UpdateData('sys_tickets','id_ticket',$id,array($this->input->post('field') => $this->input->post('valor'),'id_user_mod'=>$this->session->IdUser));
            
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/SendTicket.php";
            $opc = ($this->input->post('valor') == 4)?'anular':'finalizar';
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --op=".$opc." --id_ticket=" . $id . " --creador=" . $this->session->IdUser, "w"));
            } else {
                exec("php -q $ruta --op=".$opc." --id_ticket=" . $id . " --creador=" . $this->session->IdUser . " > /dev/null &");
            }
        }
        $data['row'] = $this->M_Help->getIndicators();
        $left = $this->load->view('Help/V_Left', $data, true);
        echo json_encode(array('res'=>$result,'indicator'=>$left));
    }
    
    function Loadsubservices(){
        $result = $this->M_Help->Loadsubservices($this->input->post('servicio'));
        echo json_encode(array('res'=>$result));
    }

}
