<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Trafic extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function ListTraficTask($cliente,$area,$usuario, $rol){
        
        if($area != 'All'){
            $this->db->where("id_area",$area);
            if($area == 1 && $rol != 'All'){
                $this->db->where("rol in ($rol,8,19) ");//8= directores de grupo 19 = copy
            }
        }
        
        if($usuario != 'All'){
            $this->db->where("id_users in (".str_replace('-', ',', $usuario).")");
        }
        
        if($cliente != 'All'){
            $this->db->join("sys_op","view_trafic.id_op = sys_op.id_op");
            $this->db->where("sys_op.id_cliente",$cliente);
        }
        
        $result = $this->db->select("id_users as resourceId,view_trafic.descripcion_op AS title,descripcion as texto,view_trafic.fecha_creacion as start,fecha_fin as end, CONCAT('status_',view_trafic.id_estado) as className,view_trafic.description as estado,view_trafic.id_tarea,view_trafic.descripcion_op ")
                ->from("view_trafic")
                ->where("(DATE_FORMAT(view_trafic.fecha_creacion, '%Y%m') BETWEEN DATE_FORMAT('".$this->input->get('start')."', '%Y%m') AND DATE_FORMAT('".$this->input->get('end')."', '%Y%m'))
                        OR (DATE_FORMAT(view_trafic.fecha_fin, '%Y%m') BETWEEN DATE_FORMAT('".$this->input->get('start')."', '%Y%m') AND DATE_FORMAT('".$this->input->get('end')."', '%Y%m'))")
                ->get();
      
        return $result->result(); 
    }
    
    
    function ListTraficData($cliente,$area,$usuario,$rol, $group = false){
        
        if($area != 'All'){
            $this->db->where("u.id_area",$area);
            if($area == 1 && $rol != 'All'){
                if($rol == 3){
                    $this->db->where("u.rol in ($rol,8,19) ");//8= directores  olimpica 19 = copy
                }else{
                    $this->db->where("u.rol in ($rol,26,19) ");//26= directores otras cuentas 19 = copy
                }
            }
        }
        
        
        if($usuario != 'All'){
            $this->db->where("id_users in (".str_replace('-', ',', $usuario).")");
        }
        
        if($group)
            $this->db->group_by('u.id_users');
        
        if($cliente != 'All'){
            
            $res = $this->db->select("u.id_users as id,u.name as title,a.descripcion as building")
                ->from("view_trafic")
                ->join("sys_users u","view_trafic.id_users = u.id_users")
                ->join("sys_op","view_trafic.id_op = sys_op.id_op and view_trafic.id_users = u.id_users")
                ->join("sys_area a","u.id_area = a.id_area")
                ->where("sys_op.id_cliente",$cliente)
                ->get();
        
        }else{
        
            $res = $this->db->select("u.id_users as id,u.name as title,a.descripcion as building")
                    ->from("sys_users u")
                    ->join("sys_area a","u.id_area = a.id_area")
                    ->where("u.id_area not in (6,7,8,9,3)")
                    ->where("u.status",1)
                    ->order_by("name")
                    ->get();
        }
//        echo $this->db->last_query();
        return $res->result();
        
    }
    
    
    function ListOpOpen(){
        $op = $this->db->select("*")
                ->from("sys_op")
                ->where("id_estado",1)
                ->get();
        
        $task = $this->db->select("*")
                ->from("sys_tareas_op")
                ->where_in("id_estado",array("1","11"))
                ->get();
        
        return array("count_op"=>$op->num_rows(),"count_task"=>$task->num_rows());
    }
    
    function ListarAreas($id = false, $array = false){
        if($id)
            $this->db->where('id_area', $id);
        
        if($array)
            $this->db->where_in("id_area",$array);
        
        $result = $this->db->select('*')
                ->from('sys_area')
                ->where("id_area not in (6,7,8,9,3)")
                ->order_by('descripcion')
                ->get();
        
        return $result->result();
    }
    
    function ListTask($usuario,$fecha,$not_in){
        
        if($not_in != '')
            $this->db->where('t.id_tarea not in ('.$not_in.') ');
        
        $task = $this->db->select("t.id_tarea,descripcion_op as descripcion,t.fecha_creacion,t.fecha_entrega,t.id_estado,DATEDIFF(t.fecha_creacion,'".$fecha."') as dif_creacion,DATEDIFF(t.fecha_entrega,'".$fecha."') as dif_entrega")
                ->from("sys_tareas_op t")
                ->join("sys_op o","t.id_op = o.id_op")
                ->where("(t.id_responsable LIKE '".$usuario."' OR t.id_responsable LIKE '".$usuario.",%'
                        OR t.id_responsable LIKE '%,".$usuario."'
                        OR t.id_responsable LIKE '%,".$usuario.",%') ")
                ->where(' ("'.$fecha.'" BETWEEN DATE_FORMAT(t.fecha_creacion, "%Y%-%m%-%d") AND DATE_FORMAT(t.fecha_entrega, "%Y%-%m%-%d") or "'.$fecha.'" BETWEEN DATE_FORMAT(t.fecha_entrega, "%Y%-%m%-%d") AND DATE_FORMAT(t.fecha_creacion, "%Y%-%m%-%d"))')
               
                ->get();
        
        return $task->result();
    }
    
   
}
