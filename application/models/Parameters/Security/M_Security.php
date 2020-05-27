<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Security extends VS_Model {

    public function __construct() {
        parent::__construct();
        
    }

    function GetRolMenu() {
        $result = $this->db->select("*")
                ->from("sys_roles_menu")
                ->get();
        return $result->result();
    }

    function GetMenu($type = false, $root = false) {
        
        if($type)
            $this->db->where('type',$type);
        
        if($root)
            $this->db->where('root',$root);
        
        $result = $this->db->select("*")
                ->from("sys_menu")
//                ->where("id_menu <> 56")
                ->where("status",1)
                ->get();
        return $result->result();
    }

    function GetRoles() {
        $result = $this->db->select("*")
                ->from("sys_roles")
//                ->where("id_roles <> 1")
                ->where("status", 1)
                ->order_by("description")
                ->get();
        return $result->result();
    }
    
    function loadRolMenus($rol){
        $result = $this->db->select("*")
                ->from("sys_roles_menu")
                ->where("id_roles",$rol)
                ->get();
        return $result->result();
    }
    
    function loadRolButton($rol){
        $result = $this->db->select("*")
                ->from("sys_roles_button")
                ->where("id_rol",$rol)
                ->get();
        return $result->result();
    }
    
    function RemoveRolesMenu($rol,$menu){
        $this->db->where('id_roles',$rol);
        $this->db->where('id_menu',$menu);
        $result = $this->db->delete('sys_roles_menu');
        $res = 0;
        if($result){
            $res = 1;
        }
        return $res;
    }
    
    function RemoveRolesButton($rol,$button){
        $this->db->where('id_rol',$rol);
        $this->db->where('id_button',$button);
        $result = $this->db->delete('sys_roles_button');
        $res = 0;
        if($result){
            $res = 1;
        }
        return $res;
    }
    
    function loadButton(){
        $result = $this->db->select("*")
                ->from("sys_button")
                ->order_by('title,description ')
                ->get();
        return $result->result();
    }

}
