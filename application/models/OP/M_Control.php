<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Control extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function SelectIndicatorsTask($creator = false, $responsable = false){
        
        $this->db->select('s.id_status,s.description,s.hex,COUNT(t.id_tarea) AS cant')
                ->from('sys_status s')
                ->join('sys_tareas_op t','t.id_estado = s.id_status')
                ->where('s.task',1)
                ->group_by('s.id_status')
                ->order_by('s.description');
        
        if($creator)
            $this->db->join('sys_op o','t.id_op = o.id_op and o.id_user = '.$creator);
        
        if($responsable)
            $this->db->where("(t.id_responsable LIKE '".$responsable."' OR t.id_responsable LIKE '".$responsable.",%'
                        OR t.id_responsable LIKE '%,".$responsable."'
                        OR t.id_responsable LIKE '%,".$responsable.",%') ");
        
        $result = $this->db->get();
   
        return $result->result();
    }
    
    function TaskPendiente($responsable = false){
       
        if($responsable)
            $this->db->where("(t.id_responsable LIKE '".$responsable."' OR t.id_responsable LIKE '".$responsable.",%'
                        OR t.id_responsable LIKE '%,".$responsable."'
                        OR t.id_responsable LIKE '%,".$responsable.",%') ");
        
                $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");

        $result = $this->db->select('"PENDIENTE POR COBRAR" as description,COUNT(t.id_tarea) AS cant')
            ->from('sys_tareas_op t')
            ->where("t.id_estado", 13)
            ->where("t.modalidad_cobro != 'BONO' ")
            ->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ")
            ->where(" t.presupuesto is null ")->get();

        return $result->result();
    }
    
    function TaskVencida($responsable = false){
       
        if($responsable)
            $this->db->where("(t.id_responsable LIKE '".$responsable."' OR t.id_responsable LIKE '".$responsable.",%'
                        OR t.id_responsable LIKE '%,".$responsable."'
                        OR t.id_responsable LIKE '%,".$responsable.",%') ");

        $result = $this->db->select('"VENCIDA" as description,COUNT(t.id_tarea) AS cant')
            ->from('sys_tareas_op t')
            ->where(' t.fecha_entrega <= NOW() AND t.id_estado NOT IN (14,13,8,5,4,3,2) ')->get();

        return $result->result();
    }
    
    function ShowTasOtherkRes($estado,$responsable){
        
        
        if($responsable)
            $this->db->where("(t.id_responsable LIKE '".$responsable."' OR t.id_responsable LIKE '".$responsable.",%'
                        OR t.id_responsable LIKE '%,".$responsable."'
                        OR t.id_responsable LIKE '%,".$responsable.",%') ");
        
        if($estado == 'PENDIENTE'){
            $result = $this->db->select('t.*,ifnull(u.descripcion,t.descripcion) as descripcion, o.descripcion_op')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_unidad_negocio u','u.id_unidad = t.id_unidad','left')
                ->where("t.id_estado", 13)
                ->where("t.modalidad_cobro != 'BONO' ")
                ->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ")
                ->where(" t.presupuesto is null ")
                ->order_by('t.id_tarea','desc')->get();
        }else if($estado == 'VENCIDA'){
            $result = $this->db->select('t.*,ifnull(u.descripcion,t.descripcion) as descripcion, descripcion_op')
            ->from('sys_tareas_op t')
            ->join('sys_op o','t.id_op = o.id_op')
            ->join('sys_unidad_negocio u','u.id_unidad = t.id_unidad','left')
            ->where(' t.fecha_entrega <= NOW() AND t.id_estado NOT IN (14,13,8,5,4,3,2) ')
            ->order_by('t.id_tarea','desc')->get();
        }
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function SelectIndicatorsOP($creator = false){
        
        if($creator)
            $this->db->where('o.id_user',$creator);
        
        $result = $this->db->select('s.id_status,if(s.id_status = 1,"ABIERTA",s.description) as description,s.hex,COUNT(o.id_op) AS cant')
                ->from('sys_status s')
                ->join('sys_op o','o.id_estado = s.id_status')
                ->where('s.op',1)
                ->group_by('s.id_status')
                ->order_by('s.description')
                ->get();
        
        return $result->result();
    }
    
    
    function ShowOP($status,$creator){
        $result = $this->db->select('*')
                ->from('sys_op')
                ->where('id_user',$creator)
                ->where('id_estado',$status)
                ->order_by('id_op')
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function ShowTask($status,$creator){
        $result = $this->db->select('t.*,ifnull(u.descripcion,t.descripcion) as descripcion,descripcion_op')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_unidad_negocio u','u.id_unidad = t.id_unidad','left')
                ->where('t.id_estado',$status)
                ->where('o.id_user',$creator)
                ->order_by('t.id_tarea','desc')
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    
    function ShowTaskRes($status,$creator){
        $result = $this->db->select('t.*,ifnull(u.descripcion,t.descripcion) as descripcion, descripcion_op')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_unidad_negocio u','u.id_unidad = t.id_unidad','left')
                ->where('t.id_estado',$status)
                ->where("(t.id_responsable LIKE '".$creator."' OR t.id_responsable LIKE '".$creator.",%'
                        OR t.id_responsable LIKE '%,".$creator."'
                        OR t.id_responsable LIKE '%,".$creator.",%') ")
                ->order_by('t.id_tarea','desc')
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }

    function SelectMyTask($user) {
        
        $result = $this->db->select('t.*,u.name')
                ->from('sys_tareas_op t')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->join('sys_users u', 'o.id_user = u.id_users')
                ->where("(t.id_responsable LIKE '".$user."' OR t.id_responsable LIKE '".$user.",%'
                        OR t.id_responsable LIKE '%,".$user."'
                        OR t.id_responsable LIKE '%,".$user.",%') ")
                ->order_by("t.id_tarea", "desc")
                ->limit(20)
                ->get();

        return  $result->result();
    }

    function SelectMyTaskNotified() {
        
        $result = $this->db->select('t.*,u.name')
                ->from('sys_tareas_op t')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->join('sys_users u', 'o.id_user = u.id_users')
                ->where("(t.notificados LIKE '".$this->session->IdUser."' OR t.notificados LIKE '".$this->session->IdUser.",%'
                        OR t.notificados LIKE '%,".$this->session->IdUser."'
                        OR t.notificados LIKE '%,".$this->session->IdUser.",%') ")
                ->order_by("t.id_tarea", "desc")
                ->limit(20)
                ->get();

        return  $result->result();
    }

    function SelectMyTaskComment() {
        
        $result = $this->db->select("t.*,u.name,c.texto,c.tipo, DATE_FORMAT(c.fecha, '%Y%m%d') as fecha, c.adjunto, u2.name as comentarista")
                ->from('sys_tareas_op t')
                ->join('sys_comentario c', 't.id_tarea = c.id_tarea')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->join('sys_users u', 'o.id_user = u.id_users')
                ->join('sys_users u2', 'c.id_user = u2.id_users')
                ->where("(t.notificados LIKE '".$this->session->IdUser."' OR t.notificados LIKE '".$this->session->IdUser.",%'
                        OR t.notificados LIKE '%,".$this->session->IdUser."'
                        OR t.notificados LIKE '%,".$this->session->IdUser.",%') 
                            or
                        (t.id_responsable LIKE '".$this->session->IdUser."' OR t.id_responsable LIKE '".$this->session->IdUser.",%'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser."'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser.",%')
                         ")
                ->order_by("c.fecha", "desc")
                ->limit(20)
                ->get();

        return  $result->result();
    }
    
    
    
}
