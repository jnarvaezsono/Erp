<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Security extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Security/M_Security");
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    public function Buttons() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);

        
        $d['listButton'] = $this->loadButton();
        $data['tabbuttons'] = $this->load->view('Parameters/Security/V_Form_Button', $d,true);
        
        $data['roles'] = $this->M_Security->GetRoles();
        $this->load->view('Parameters/Security/V_Panel_Button', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, ALERTIFY_JS, ICHECK_JS);
        
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Permissions() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);

        
        $d['listmenus'] = $this->loadMenus();
        $data['tabmenus'] = $this->load->view('Parameters/Security/V_Form', $d,true);
        
        $data['roles'] = $this->M_Security->GetRoles();
        $this->load->view('Parameters/Security/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, ALERTIFY_JS, ICHECK_JS);
        
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function loadRolMenus(){
        $result = $this->M_Security->loadRolMenus($this->rol);
        echo json_encode(array('res'=>$result));
    }
    
    function loadRolButton(){
        $result = $this->M_Security->loadRolButton($this->rol);
        echo json_encode(array('res'=>$result));
    }
    
    function loadButton(){
        $buttons = $this->M_Security->loadButton();
        
        $array = array();
        foreach ($buttons as $m) {
            $array[$m->title][] = array('name'=>$m->description, 'id_button'=>$m->id_button);
        }
        return $array;
    }
            
    function loadMenus(){
        $menus = $this->M_Security->GetMenu(3);
        $array = array();
        foreach ($menus as $m) {
            $array[$m->id_menu]['title'] = $m->title;
            $array[$m->id_menu]['type'] = $m->type;
        }
        
        $menus = $this->M_Security->GetMenu(1);
        foreach ($menus as $m) {
            $array[$m->id_menu]['title'] = $m->title;
            $array[$m->id_menu]['type'] = $m->type;
        }
        
        foreach ($array as $id_menu => $sub) {
            if($sub['type'] == 3){
                $array[$id_menu]['child'] = $this->LoadChild($id_menu);
            }
        }
        
        
        return $array;
    }
    
    function LoadChild($root){
        $child = $this->M_Security->GetMenu(false,$root);
        
        $arraChild = array();
        foreach ($child as $m) {
            $arraChild[$m->id_menu]['title'] = $m->title;
            $arraChild[$m->id_menu]['type'] = $m->type;
        }
        
        foreach ($arraChild as $id_menu => $sub) {
            if($sub['type'] == 4){
                $arraChild[$id_menu]['child'] = $this->LoadChild($id_menu);
            }
        }
        
        return $arraChild;
    }
    
    function changePermissions(){
        switch ($this->option) {
            case 'add':
                $result = $this->M_Security->SaveData('sys_roles_menu',array('id_roles'=>$this->rol,'id_menu'=>$this->menu));
                break;
            case 'remove':
                $result = $this->M_Security->RemoveRolesMenu($this->rol,$this->menu);
                break;

            default:
                break;
        }
        
        echo $result;
    }
    
    function changePermissionsButton(){
        switch ($this->option) {
            case 'add':
                $result = $this->M_Security->SaveData('sys_roles_button',array('id_rol'=>$this->rol,'id_button'=>$this->button));
                break;
            case 'remove':
                $result = $this->M_Security->RemoveRolesButton($this->rol,$this->button);
                break;

            default:
                break;
        }
        
        echo $result;
    }
    
}
