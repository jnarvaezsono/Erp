<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Contracts extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function Create(){
        $_POST['id_user'] = $this->session->IdUser;
        $_POST['valor'] = str_replace('.', '', $_POST['valor']);
        $result = $this->db->insert('sys_contratos',$_POST);
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }

    function CreateRenovation($data){
        $result = $this->db->insert('sys_contratos_renovar',$data);
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }

    function Update(){
        $id = $_POST['id'];
        
        unset($_POST['renovate']);
        unset($_POST['id']);
        
        $this->db->where('id',$id);
        $result = $this->db->update('sys_contratos',$_POST);
        
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }
    
    function GetList(){
        
        if($this->session->IdRol != 14 && $this->session->IdRol != 1){
            $this->db->where('id_user',$this->session->IdUser);
        }
        
        $result = $this->db->select("c.id,c.numero,c.fecha_vencimiento,c.tipo,ifnull(ta.nombre,'SONOVISTA') AS contra_parte,c.valor,c.responsable,s.description as estado,s.color,f_otros_si(c.id) as otros,name")
                ->from('sys_contratos c')
                ->join('sys_clients ta','c.contra_parte = ta.id_client','left')
                ->join('sys_status s','c.id_estado = s.id_status')
                ->join('sys_users u','u.id_users = c.id_user')
                ->where('other is null')
                ->order_by('c.fecha','desc')
                ->get();
        return $result->result();
    }
    
    function GetRow($id){
        $result = $this->db->select("*")
                ->from('sys_contratos c')
                ->where('id',$id)
                ->get();
        return $result->row();
    }
    
    function MaxRenovation($id){
        $result = $this->db->select("MAX(id) as id")
                ->from('sys_contratos')
                ->where('id',$id)
                ->or_where('other',$id)
                ->get();
        return $result->row()->id;
    }
    
    function GetRenovation($id){
        $result = $this->db->select("*")
                ->from('sys_contratos c')
                ->join('sys_users u','u.id_users = c.id_user')
                ->where('other',$id)
                ->order_by('fecha','asc')
                ->get();
        
        return $result->result();
    }
    
    function UpdateOld($id){
        $this->db->where('id',$id);
        $this->db->or_where('other',$id);
        $this->db->update('sys_contratos s',array('old'=>1));
    }
    
    function Anule($id){
        $this->db->where('id',$id);
        $result = $this->db->update('sys_contratos s',array('id_estado'=>4));
        
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }

    function Expiration($where = false){
        
        if($where){
            $result = $this->db->select("s.*,IFNULL(s.other,s.id) AS id_contrato")
                    ->from('sys_contratos s')
                    ->where('s.id_estado = 1 and s.old = 0 and '.$where.' = s.fecha_vencimiento ')
                    ->get();
            
        }else{
            $result = $this->db->select("s.*,IFNULL(s.other,s.id) AS id_contrato")
                    ->from('sys_contratos s')
                    ->where('s.id_estado = 1 and s.old = 0 and s.fecha_vencimiento  < CURRENT_DATE() ')
                    ->get();
            
        }
        return $result->result();
        
    }
    
    function updateExpired($id){
        $this->db->where('id',$id);
        $this->db->or_where('other',$id);
        $this->db->update('sys_contratos',array('id_estado'=>8));
    }
    
    function NewHistory($data){
        $result = $this->db->insert('sys_contracts_history',$data);
        
        if($result){
            return 'OK';
        }else{
            return 'Error '.$this->db->last_query();
        }
    }
    
    function getFamilyContracts($id){
        $result = $this->db->select("*")
                ->from('sys_contratos')
                ->where('id',$id)
                ->or_where('other',$id)
                ->get();
        return $result->result();
    }
    
    function getHistory($id){
        $result = $this->db->select("*")
                ->from('sys_contracts_history h')
                ->join('sys_users u ','u.id_users = h.id_user')
                ->where('id_contrato',$id)
                ->order_by('h.fecha','desc')
                ->get();
        return $result->result();
    }
    
    function ShowOtherContracts($id){
        $result = $this->db->select("*")
                ->from('sys_contratos')
                ->where('other',$id)
                ->get();
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
}
