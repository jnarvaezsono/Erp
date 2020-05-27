<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Assign extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function ListarTask($ini = false,$fin = false,$op,$task,$cliente,$f_ini, $f_fin, $id_estado){
        if($fin)
            $this->db->limit($fin, $ini);
        
        if($op != "all")
            $this->db->where("t.id_op",$op);
        
        if($task != "all")
            $this->db->where("t.id_tarea",$task);
        
        if($cliente != "all")
            $this->db->where("o.id_cliente",$cliente);
        
        if($f_ini != "all")
            $this->db->where("t.fecha_creacion between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY) ");
        
        switch ($id_estado) {
            
            case 'Pendientes':
                $this->db->where("t.id_tarea in (SELECT t.id_tarea FROM sys_tareas_op t
                                join sys_tarea_ppto p ON t.id_tarea = p.id_tarea
                                WHERE t.modalidad_cobro != 'BONO' and IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                                AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                                AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' and p.factura IS NULL and t.id_estado not in (4,14)
                                GROUP BY t.id_tarea) ");
                break;
            
            case 'SinPresupuesto':
                $this->db->where('t.presupuesto is null');
                $this->db->where('t.modalidad_cobro != "BONO"');
                $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");
                break;
            
            case 'Facturado':
                $this->db->where('t.presupuesto is not null');
                $this->db->where('t.id_tarea not in (SELECT t.id_tarea FROM sys_tareas_op t
                                left join sys_tarea_ppto p ON t.id_tarea = p.id_tarea
                                WHERE p.factura IS NULL and t.id_estado not in (4,14)
                                GROUP BY t.id_tarea) ');
                break;

            default:
                break;
        }
        
        $result = $this->db->select('t.id_op,t.id_tarea,c.pvcl_nombre,cm.camp_nombre,t.descripcion,t.presupuesto,t.factura,e.description,t.id_categoria,t.fecha_creacion,t.fecha_cierre,concat_ppto_factura(t.id_tarea) as facturas')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('cat_provsclies c','o.id_cliente = c.pvcl_id')
                ->join('cat_campanas cm','o.id_campana = cm.camp_id')
                ->join('sys_status e','e.id_status = t.id_estado')
                ->where('t.id_estado not in (4,14)')
                ->order_by("o.id_op desc,t.id_tarea desc")
                ->get();
        

        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function SelectTask($op = false,$task = false, $cliente = false,$f_ini = false, $f_fin = false, $id_estado = false){
        
        if($op != "all")
            $this->db->where("t.id_op",$op);
        
        if($task != "all")
            $this->db->where("t.id_tarea",$task);
        
        if($cliente != "all")
            $this->db->where("o.id_cliente",$cliente);
        
        if($f_ini != "all")
            $this->db->where("t.fecha_creacion between '$f_ini' AND DATE_ADD('$f_fin', INTERVAL 1 DAY)  ");
        
        switch ($id_estado) {
            
            case 'Pendientes':
                $this->db->where('t.id_tarea in (SELECT t.id_tarea FROM sys_tareas_op t
                                left join sys_tarea_ppto p ON t.id_tarea = p.id_tarea
                                WHERE p.factura IS NULL and t.id_estado != 4
                                GROUP BY t.id_tarea) ');
                break;
            
            case 'SinPresupuesto':
                $this->db->where('t.presupuesto is null');
                break;
            
            case 'Facturado':
                $this->db->where('t.presupuesto is not null');
                $this->db->where('t.id_tarea not in (SELECT t.id_tarea FROM sys_tareas_op t
                                left join sys_tarea_ppto p ON t.id_tarea = p.id_tarea
                                WHERE p.factura IS NULL and t.id_estado != 4
                                GROUP BY t.id_tarea) ');
                break;

            default:
                break;
        }
      
        
        $result = $this->db->select('t.id_op,t.id_tarea,c.pvcl_nombre,cm.camp_nombre,t.descripcion,t.presupuesto,t.factura,e.description,t.id_categoria,t.fecha_creacion,t.fecha_cierre')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('cat_provsclies c','o.id_cliente = c.pvcl_id')
                ->join('cat_campanas cm','o.id_campana = cm.camp_id')
                ->join('sys_status e','e.id_status = t.id_estado')
                ->where('t.id_estado != 4')
                ->order_by("o.id_op desc,t.id_tarea desc")
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
   
    
    function ShowPpto(){
        $result = $this->db->select("*")
                ->from("sys_tarea_ppto")
                ->where("id_tarea",$this->id_tarea)
                ->get();
        
        return array("result"=>$result->result(),"num"=>$result->num_rows());
    }
    
    function AsignPpto(){
        $result = $this->db->query("update sys_tarea_ppto t "
                . "JOIN factura_presup p ON t.ppto = p.id_doc "
                . "SET t.factura = p.factura_id,t.categoria = p.modulo_id "
                . "WHERE t.factura IS null");
        
        if($result){
            return 'OK';
        }else{
            return $this->db->last_query();
        }
    }
    
}
