<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sent extends VS_Model {

    public function __construct() {
        parent::__construct();
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListSent() {
        
        if($this->session->IdRol != 31)
            $this->db->where('id_user',$this->session->IdUser);
        
        $result = $this->db->select("*")
                ->from("sys_sent r")
                ->join("sys_users u", "r.id_user = u.id_users")
                ->join("sys_status s", "r.id_status = s.id_status")
                ->order_by("consecutive","desc")
                ->get();

        return $result->result();
    }

    function CreateRegister(){
        $data = array(
            "date_sent" => $this->date_sent,
            "hour" => $this->hour,
            "type"=> $this->type,
            "shipping_by"=> $this->shipping_by,
            "description_register"=> $this->description_register,
            "addressee"=>strtoupper($this->addressee), 
            "response"=>$this->response,
            "company"=>$this->company,
            "id_user" => $this->session->IdUser);
        $result = $this->db->insert("sys_sent", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function UpdateSent(){
        $data = array(
            "date_sent" => $this->date_sent,
            "hour" => $this->hour,
            "type"=> $this->type,
            "shipping_by"=> $this->shipping_by,
            "company"=>$this->company,
            "response"=>$this->response,
            "description_register"=> $this->description_register,
            "addressee"=>strtoupper($this->addressee), 
            );
        $this->db->where('consecutive',$this->consecutive);
        $result = $this->db->update("sys_sent", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
    
    function AnuleUser(){
        $data = array("id_status" => 4);
        $this->db->where('consecutive',$this->consecutive);
        $result = $this->db->update("sys_sent", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
    
    function ListUsers(){
        $result = $this->db->select("*")
                ->from("sys_users u")
                ->where("u.status", 1)
                ->get();
        return $result->result();
    }
}
