<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Time extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function LoadTimesCab($id_user, $limit) {

        if ($limit)
            $this->db->limit($limit, 0);

        $result = $this->db->select('*')
                ->from('sys_timesheet')
                ->where('id_users', $id_user)
                ->where('fecha <= CURRENT_DATE()')
                ->order_by('fecha', 'desc')
                ->get();
        return $result->result();
    }

    function DetailTimeSheet($id_time, $detail = false) {

        if ($detail)
            $this->db->where('id_time_detail', $detail);

        $result = $this->db->select('*')
                ->from('sys_timesheet_detail d')
                ->where('d.id_time', $id_time)
                ->get();

        if ($detail) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function LoadMyTask($usuario) {
        
        if (in_array($this->session->IdRol, array('8')) && $this->session->IdUser != 45) {
            $this->db->where("id_cliente", 1339);
        } else if (in_array($this->session->IdRol, array('26'))) {
            $this->db->where("id_cliente <> 1339");
        } else {
            $this->db->where("(t.id_responsable LIKE '" . $usuario . "' OR t.id_responsable LIKE '" . $usuario . ",%'
                        OR t.id_responsable LIKE '%," . $usuario . "'
                        OR t.id_responsable LIKE '%," . $usuario . ",%') ");
        }

        $result = $this->db->select('*')
                ->from('sys_tareas_op t')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->order_by('t.id_tarea', 'desc')
                ->limit(700, 0)
                ->get(); 
//        echo $this->db->last_query();exit();
        return $result->result();
    }

    function validateDayFinished($id_time) {
        $result = $this->db->select("ifnull(SEC_TO_TIME(SUM(TIME_TO_SEC(d.TIME))) >= '08:30:00',0) as finish")
                ->from('sys_timesheet_detail d')
                ->where('d.id_time', $id_time)
                ->get();

        $rows = $result->row()->finish;

        $this->db->where('id_time', $id_time);

        if ($rows > 0) {
            $this->db->update('sys_timesheet', array('id_estado' => 9));
        } else {
            $this->db->update('sys_timesheet', array('id_estado' => 10));
        }

        return $rows;
    }

    function CreateTimes($insert) {
        $this->db->insert_batch('sys_timesheet', $insert);
    }

    function LoadrangeUser($usuario, $ini, $fin) {
        $result = $this->db->query("SELECT m.fecha as y  ,SUBSTRING(REPLACE(SEC_TO_TIME(SUM( if(d.task > 0,TIME_TO_SEC (d.TIME),0))),':','.'),1,5) AS item1 FROM sys_timesheet m
                                    join sys_timesheet_detail d ON m.id_time = d.id_time
                                    left JOIN sys_tareas_op t ON d.task = t.id_tarea
                                    WHERE m.id_users = $usuario AND m.fecha BETWEEN '$ini' AND '$fin'
                                    GROUP BY m.fecha ORDER BY d.fecha ASC");

        return array('num' => $result->num_rows(), 'rows' => $result->result());
    }

    function grafOne($ini, $fin, $all = false) {

        if (!$all)
            $this->db->group_by("d.`type`");

        $result = $this->db->select("d.`type`,COUNT(*) AS cantidad")
                        ->from("sys_timesheet_detail d")
                        ->join("sys_timesheet t ", " d.id_time = t.id_time")
                        ->where("t.fecha BETWEEN '$ini' AND '$fin'")->get();
        if (!$all) {
            return array('num' => $result->num_rows(), 'rows' => $result->result());
        } else {
            return $result->row();
        }
    }

    function grafTwo($ini, $fin, $all = false) {

        if (!$all)
            $this->db->group_by("IFNULL(c.nombre,cl.nombre)");

        $result = $this->db->select("SEC_TO_TIME( SUM(TIME_TO_SEC(d.time))) AS tiempo,IFNULL(c.nombre,cl.nombre) AS clientem,IFNULL(c.nombre,cl.nombre) AS cliente,HOUR(SEC_TO_TIME( SUM(TIME_TO_SEC(d.time)))) as hora")
                        ->from("sys_timesheet t ", " d.id_time = t.id_time")
                        ->join('sys_timesheet_detail d', 't.id_time = d.id_time')
                        ->join('sys_tareas_op o', 'o.id_tarea = d.task', 'left')
                        ->join('sys_op op', 'o.id_op = op.id_op', 'left')
                        ->join('sys_clients cl', 'op.id_cliente = cl.id_client', 'left')
                        ->join('sys_clients c', 'd.cliente = c.id_client', 'left')
                        ->where("d.`type` IN ('Tarea','Tarea Sin OP')")
                        ->where("t.fecha BETWEEN '$ini' AND '$fin'")
                        ->order_by('IFNULL(c.nombre,cl.nombre)')->get();

        if (!$all) {
            return array('num' => $result->num_rows(), 'rows' => $result->result());
        } else {
            return $result->row();
        }
    }

    function tableTree() {
        $result = $this->db->select('u.name, COUNT(t.id_time) AS dias')
                ->from('sys_timesheet t')
                ->join('sys_users u ',' t.id_users = u.id_users')
                ->where("u.status",1)
                ->where('t.id_estado = 10 AND t.num NOT IN (6, 7) AND t.festivo != 1 AND t.fecha <= CURDATE()')
                ->group_by('t.id_users')
                ->order_by('COUNT(t.id_time)','desc')
                ->get();
        
        return $result->result();
    }

    function LoadTimesClients($periodo, $id_client = false) {

        if ($id_client)
            $this->db->where('o.id_cliente', $id_client);

        $result = $this->db->select(' d.*, o.id_cliente  ,SUBSTRING(REPLACE(SEC_TO_TIME(SUM(TIME_TO_SEC (d.TIME))),":","."),1,5) AS sumtime,trim(c.nombre) as nombre')
                        ->from('sys_timesheet_detail d ')
                        ->join('sys_tareas_op t', 'd.task = t.id_tarea')
                        ->join('sys_op o', 't.id_op = o.id_op')
                        ->join('sys_clients c', 'o.id_cliente = c.id_client')
                        ->where("DATE_FORMAT(d.fecha, '%Y%m') = $periodo ")
                        ->group_by('o.id_cliente')->get();

        if ($id_client)
            return array('num' => $result->num_rows(), 'rows' => $result->row());

        return array('num' => $result->num_rows(), 'rows' => $result->result());
    }

    function getCountTotal() {
        $result = $this->db->query("SELECT * FROM sys_timesheet t 
                                    WHERE t.id_users = " . $this->session->IdUser . " 
                                    AND t.id_estado = 10  AND t.num not in (6,7)  AND t.festivo != 1 
                                    AND t.fecha <= DATE_SUB(CURDATE(),INTERVAL 2 DAY)");

        return array('num' => $result->num_rows(), 'rows' => $result->result());
    }

    function LoadTimesUser($ini, $fin, $usuario) {
        
        if ($usuario != 'ALL'){
            if($usuario == 'DIGITAL'){
                $this->db->where('u.rol in (9,27,28)');
            }else if($usuario == 'OLIMPICA'){
                $this->db->where('u.rol in (2,3,8,23,24)');
            }else if($usuario == 'OTRAS'){
                $this->db->where('u.rol in (6,7,25,26,30)');
            }else{
                $this->db->where('t.id_users', $usuario);
            }
        }

        $result = $this->db->select('u.name AS nombre,d.time AS tiempo,d.`type` AS accion,d.actividad ,IFNULL(c.nombre,cl.nombre) AS cliente,d.solicitante,d.text AS descripcion,t.fecha')
                ->from('sys_timesheet t')
                ->join('sys_users u', 't.id_users = u.id_users')
                ->join('sys_timesheet_detail d', 't.id_time = d.id_time')
                ->join('sys_tareas_op o', 'o.id_tarea = d.task', 'left')
                ->join('sys_op op', 'o.id_op = op.id_op', 'left')
                ->join('sys_clients cl', 'op.id_cliente = cl.id_client', 'left')
                ->join('sys_clients c', 'd.cliente = c.id_client', 'left')
                ->where("u.status",1)
                ->where("t.fecha BETWEEN '$ini' AND '$fin'")
                ->order_by('u.name,t.fecha')
                ->get();
//        echo $this->db->last_query();exit();
        return $result->result();
    }
    
    function loadtimesDays($ini, $fin, $usuario){
        
        if ($usuario != 'ALL'){
            if($usuario == 'DIGITAL'){
                $this->db->where('u.rol in (9,27,28)');
            }else if($usuario == 'OLIMPICA'){
                $this->db->where('u.rol in (2,3,8,23,24)');
            }else if($usuario == 'OTRAS'){
                $this->db->where('u.rol in (6,7,25,26,30)');
            }else{
                $this->db->where('t.id_users', $usuario);
            }
        }

        $result = $this->db->select('t.fecha')
                ->from('sys_timesheet t')
                ->join('sys_users u', 't.id_users = u.id_users')
                ->where("t.fecha BETWEEN '$ini' AND '$fin'")
                ->group_by('t.fecha')
                ->get();

        return $result->result();
    }
    
    function loadtimesDaysDetail($ini, $fin, $usuario){
        if ($usuario != 'ALL'){
            if($usuario == 'DIGITAL'){
                $this->db->where('u.rol in (9,27,28)');
            }else if($usuario == 'OLIMPICA'){
                $this->db->where('u.rol in (2,3,8,23,24)');
            }else if($usuario == 'OTRAS'){
                $this->db->where('u.rol in (6,7,25,26,30)');
            }else{
                $this->db->where('t.id_users', $usuario);
            }
        }

        $result = $this->db->select('t.id_users,u.name AS usuario,t.fecha,SEC_TO_TIME( SUM(TIME_TO_SEC(d.time))) as tiempo')
                ->from('sys_timesheet t')
                ->join('sys_timesheet_detail d', 't.id_time = d.id_time','left')
                ->join('sys_users u', 't.id_users = u.id_users')
                ->where("u.status",1)
                ->where("t.fecha BETWEEN '$ini' AND '$fin'")
                ->group_by('t.fecha,t.id_users')
                ->get();
        
        return $result->result();
    }

}
