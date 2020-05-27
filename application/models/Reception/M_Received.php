<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Received extends VS_Model {

    public function __construct() {
        parent::__construct();
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function MaxConsecutive(){
        $result = $this->db->select("max(consecutive) as max")
                ->from("sys_received r")
                ->get();
   
        return $result->row()->max;
    }

    function ListReceived($id = false) {
        
        if($id){
            $this->db->where('addressee',$id);
            $this->db->where('r.id_status NOT IN (24,4) ');
        }else{
            $this->db->where('resend_of is null ');
        }

        $result = $this->db->select("r.*,u.*,s.*,u2.name as destino")
                ->from("sys_received r")
                ->join("sys_users u", "r.id_user = u.id_users")
                ->join("sys_users u2", "r.addressee = u2.id_users")
                ->join("sys_status s", "r.id_status = s.id_status")
                ->order_by("consecutive","desc")
                ->get();
   
        return $result->result();
        
    }

    function CreateRegister(){
        $data = array('consecutive'=>$this->MaxConsecutive() + 1,"date_received" => $this->date_received,"company"=>$this->company,"addressee"=>$this->addressee ,"type"=> $this->type,"description_register"=> $this->description_register,"sender"=>strtoupper($this->sender), "id_user" => $this->session->IdUser);
        $result = $this->db->insert("sys_received", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function UpdateReceived(){
        $data = array("id_status"=>6,"date_received" => $this->date_received,"company"=>$this->company,"addressee"=>$this->addressee,"description_register"=> $this->description_register,"type"=> $this->type,"sender"=>strtoupper($this->sender));
        $this->db->where('id',$this->id);
        $result = $this->db->update("sys_received", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function Updateobs($data,$id){
        $this->db->where('id',$id);
        $result = $this->db->update("sys_received", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
    
    function ChangeStatus(){
        
        $data = array("id_status" => $this->status);
        $this->db->where('id',$this->id);
        $result = $this->db->update("sys_received", $data);

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
                ->order_by("u.name")
                ->get();
        return $result->result();
    }
    
    function SelectConsecutive($id){
        $result = $this->db->select("r.consecutive, r.date_received,r.`type`,r.sender,r.description_register,r.company")
                ->from("sys_received r")
                ->where("r.id", $id)
                ->get();
        return $result->row();
    }
    
    function InsertConsecutive($data,$id,$resend_addressee,$resend_name,$resend_format){
        $insert = $this->db->insert('sys_received',$data);
        
        $this->db->where('id',$id);
        $result = $this->db->update('sys_received',array('resend_addressee'=>$resend_addressee,'resend_name'=>$resend_name,'resend'=>1,'resend_format'=>$resend_format));
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }
    
}
