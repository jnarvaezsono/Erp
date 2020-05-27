<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListUser($id = null) {

        if (!empty($id)) {
            $this->db->where("id_users", $id);
        }

        $result = $this->db->select("u.*,s.id_roles, s.description as rol,e.description as status,e.color,e.id_status")
                ->from("sys_users u")
                ->join("sys_status e", "u.status = e.id_status")
                ->join("sys_roles s", "u.rol = s.id_roles")
                ->order_by("u.name")
                ->get();
        
        if (!empty($id)) {
            return $result->row();
        }else{
            return $result->result();
        }
    }

    function ListRolAll($id = null) {

        if (!empty($id)) {
            $this->db->where("id_roles", $id);
        }

        $result = $this->db->select("r.id_roles, r.description as rol, r.status, s.* ")
                ->from("sys_roles r")
                ->join("sys_status s", "r.status = s.id_status")
                ->order_by("r.description")
                ->get();

        return $result->result();
    }

    function CreateUser() {
        $data = array("name" => $this->name,"id_area"=> $this->id_area,"cc"=>$this->cc, "user" => $this->user, "rol" => $this->rol, "password" => md5(md5($this->password)), "email" => $this->email, "status" => 1, "last_entry" => date("Y-m-d H:i:s"),"last_date"=>'2017-01-01', "avatar" => $this->avatar);
        $result = $this->db->insert("sys_users", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ValidaCorreo() {
        $result = $this->db->select(" u.id_users,u.email")
                ->from("sys_users u")
                ->where("u.email", $this->email)
                ->get();
        if ($result->num_rows() > 0) {
            return "NO";
        } else {
            return "OK";
        }
    }
    
    function ListAreasAll(){
        $result = $this->db->select('*')
                ->from('cat_area')
                ->order_by('nmb_are')
                ->get();
                
        return $result->result();
    }
    
  function Changestatus() {
        $this->db->where("id_users",$this->id_user);       
        $res = $this->db->update("sys_users",array("status"=>$this->status,"last_entry"=>date("Y-m-d H:i:s"))); 
        return ($res)?"OK":"ERROR : ".$this->db->last_query();
    }
    
    function ListUsers($id) {

        $result = $this->db->select("*")
                ->from("sys_roles")
                ->where("id_users", $id)                
                ->get();
        return $result->row();
    }  
   
    function ResetPass(){
        $data = array(
            "password" => md5(md5(123456789)),
            "last_date" => date('2017-01-01'), 
            "last_entry" => date("Y-m-d H:i:s")
        );
        
        $this->db->where("id_users",$this->id_user);       
        $res = $this->db->update("sys_users",$data); 
        return ($res)?"OK":"ERROR : ".$this->db->last_query();
    }
    
}
