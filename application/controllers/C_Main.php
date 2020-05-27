<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Main extends Controller {
        
    public function __construct() { 
        parent::__construct();
    }

    public function index(){
        if ($this->session->has_userdata('IdUser')) {
                header('Location: ' . base_url()."OP/C_Control");
        }else{
            $this->load->library('Googleplus');
            //Create Google Btn
            $contents['login_url'] = $this->googleplus->loginURL();
            $this->load->view('Login/V_Login',$contents);
        }
    }
    
    function ChangePassword(){
        echo json_encode(array("res" => $this->M_Main->ChangePassword()));
    }
    
    function Login(){
        echo json_encode(array("res" => $this->M_Main->Validar_User()));
    }
    
    function LoginToGoogle(){
        $this->load->library('Googleplus');
        
        if (isset($_GET['code'])) {
            
            $this->googleplus->getAuthenticate();

            $validate = $this->M_Main->Validar_User($this->googleplus->getUserInfo());

            if($validate == "OK"){
                header('Location: ' . base_url()."C_Panel");
            }else{
                header('Location: ' . base_url());
            }
        }else{
            echo "nada papá";
        }
    }
    
    function ForgotToPassword(){
        $emailTo = $this->input->post("email");
        
        $validate = $this->M_Main->ValidateForgot($emailTo);

        if($validate > 0){
            $cc = "";
            $subject = "Recuperar contraseña";
            $html = $this->load->view("Login/V_Email_Template",array("id"=>$validate),true);
//            $html = "<h2>Recuperar Contraseña</h2><hr><br> <a href='".base_url()."C_Service/ForgotToPassword/".$validate."'>Clic AQUI<a>";

            $res = $this->SendEmail($emailTo,$cc,$subject,$html);
        }else{
            $res = "EMPTY";
        }
        echo $res;     
    }
    
    function Logout(){
        $this->session->sess_destroy();
        header('Location: ' . base_url());
    }
    
    function LoadNotifications(){
        if ($this->session->has_userdata('IdUser')){
            $result = $this->M_Main->LoadNotifications();
            $html = $this->load->view('Template/V_Notification',$result,true);
            echo json_encode(array('rows'=>$html,'cont'=>$result['num'],'res'=>'OK'));
        }else{
            echo json_encode(array('res'=>'Login'));
        }
    }
    
    function DeleteNotification(){
        $result = $this->M_Main->DeleteNotification();
        
        echo json_encode($result);
    }
    
    function Ethics(){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array();
        $this->load->view('Template/V_Header', $Header);

        $this->load->view('Template/V_Ethics');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array();
        $this->load->view('Template/V_Footer', $Footer);
    }
   
}
