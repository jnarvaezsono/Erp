<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Client extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function ListClientProvsAll($id){

        $result = $this->db->select("*")
                ->from("sys_clients c")
                ->join("sys_status s", "c.id_status = s.id_status")
                ->where("id_client", $id)
                ->order_by("c.nombre")
                ->get();
        
  
        return $result->row();
        
    }
    
    function ListDepartaments($id = null) {

        if (!empty($id)) {
            $this->db->where("codigo", $id);
        }

        $result = $this->db->select("*")
                ->from("sys_departamento")
                ->order_by("nombre")
                ->get();
        
        if (!empty($id)) {
            return $result->row();
        }else{
            return $result->result();
        }
    }
    
    function ListCitys($id = null, $dpto = false) {

        if (!empty($id)) {
            $this->db->where("codigo", $id);
        }
        
        if($dpto){
            $this->db->where("departamento", $dpto);
        }

        $result = $this->db->select("c.*,d.nombre as departamento")
                ->from("sys_ciudades c")
                ->join("sys_departamento d","c.departamento = d.codigo")
                ->order_by("nombre")
                ->get();
        
        if (!empty($id)) {
            return $result->row();
        }else{
            return $result->result();
        }
    }

    function ListClientAll($id = null) {

        if (!empty($id)) {
            $this->db->where("id_client", $id);
        }

        $result = $this->db->select("*")
                ->from("sys_clients c")
                ->join("sys_status s", "c.id_status = s.id_status")
                ->where('c.cliente',1)
                ->order_by("c.nombre")
                ->get();
        
        if (!empty($id)) {
            return $result->row();
        }else{
            return $result->result();
        }
        
        
    }

    function ListProveedortAll($id = null) {

        if (!empty($id)) {
            $this->db->where("id_client", $id);
        }

        $result = $this->db->select("*")
                ->from("sys_clients c")
                ->join("sys_status s", "c.id_status = s.id_status")
                ->where('c.proveedor',1)
                ->order_by("c.nombre")
                ->get();
        
        if (!empty($id)) {
            return $result->row();
        }else{
            return $result->result();
        }
        
        
    }
    
    function ListTipoDocumento(){
        $result = $this->db->select("*")
                ->from("sys_tipo_documento ")
                ->order_by('nombre_tipo_documento')
                ->get();
        return $result->result();
    }
    
    function ListObligaciones(){
        $result = $this->db->select("*")
                ->from("sys_obligaciones_dian ")
                ->order_by('descripcion')
                ->get();
        return $result->result();
    }
    
    function ListTipoPersona(){
        $result = $this->db->select("*")
                ->from("sys_tipo_persona ")
                ->get();
        return $result->result();
    }

    public function UpdateClient() {

        $this->db->where("id_client", $this->id_client);
        
        unset($_POST['id_client']);
        
        $result = $this->db->update("sys_clients", $_POST);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function CreateClient() {
        
        $result = $this->db->insert("sys_clients", $_POST);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function DeleteClient() {
        $this->db->where("id_client",$this->id_client);
        $res = $this->db->update("sys_clients",array("id_status"=>4));
        
        return ($res)?"OK":"ERROR : ".$this->db->last_query();
    }

}
