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
        $result = $this->db->select('*')
                ->from('sys_tareas_op t')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->where("(t.id_responsable LIKE '" . $usuario . "' OR t.id_responsable LIKE '" . $usuario . ",%'
                        OR t.id_responsable LIKE '%," . $usuario . "'
                        OR t.id_responsable LIKE '%," . $usuario . ",%') ")
                ->order_by('t.id_tarea', 'desc')
                ->limit(10, 0)
                ->get();
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

    function LoadrangeUser($usuario, $ini, $fin) {
        $result = $this->db->query("SELECT m.fecha as y  ,SUBSTRING(REPLACE(SEC_TO_TIME(SUM( if(d.task > 0,TIME_TO_SEC (d.TIME),0))),':','.'),1,5) AS item1 FROM sys_timesheet m
                                    join sys_timesheet_detail d ON m.id_time = d.id_time
                                    left JOIN sys_tareas_op t ON d.task = t.id_tarea
                                    WHERE m.id_users = $usuario AND m.fecha BETWEEN '$ini' AND '$fin'
                                    GROUP BY m.fecha ORDER BY d.fecha ASC");

        return array('num' => $result->num_rows(), 'rows' => $result->result());
    }

    function getCountTotal() {
        $result = $this->db->query("SELECT * FROM sys_timesheet t 
                                    WHERE t.id_users = ".$this->session->IdUser." 
                                    AND t.id_estado = 10  AND t.num not in (6,7)  AND t.festivo != 1 
                                    AND t.fecha <= DATE_SUB(CURDATE(),INTERVAL 2 DAY)");
        
        return array('num' => $result->num_rows(), 'rows' => $result->result());
    }

}
