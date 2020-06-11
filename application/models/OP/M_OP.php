<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_OP extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListarCampana($id = false) {

        if ($id)
            $this->id_cliente = $id;

        $result = $this->db->select('*')
                ->from('cat_campanas')
                ->where('pvcl_id', $this->id_cliente)
                ->where('est_id', 1)
                ->order_by('camp_nombre')
                ->get();

        return $result->result();
    }

    function ListarRubro($id = false) {

        if ($id)
            $this->id_cliente = $id;

        $result = $this->db->select('*')
                ->from('cat_prodsclies')
                ->where('pvcl_id', $this->id_cliente)
                ->where('est_id', 1)
                ->order_by('pdcl_nombre')
                ->get();

        return $result->result();
    }

    function ListarContacto($id = false) {

        if ($id)
            $this->id_cliente = $id;

        $result = $this->db->select('*')
                ->from('cat_contclies')
                ->where('pvcl_id', $this->id_cliente)
                ->where('est_id', 1)
                ->order_by('cont_nombre')
                ->get();

        return $result->result();
    }

    function ListarModalidadCobro($id = false) {
        if ($id)
            $this->db->where('id_modalidad_cobro', $id);

        $result = $this->db->select('*')
                ->from('sys_modalidad_cobro')
                ->where('id_estado',1)
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }

    function ListarAreas($id = false, $array = false) {
        if ($id)
            $this->db->where('id_area', $id);

        if ($array)
            $this->db->where_in("id_area", $array);

        $result = $this->db->select('*')
                ->from('sys_area')
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }
    
    function IsDuplicatePhoto($task){
        $result = $this->db->select('*')
                ->from('sys_tareas_op')
                ->where('id_duplicado',$task)
                ->where('id_tarifa_servicio in (250,251)')
                ->get();

        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function ListarMyTask($ini = false, $fin = false, $cliente, $op, $task, $estado, $usuario, $area, $maestro, $modalidad, $descripcion) {

        if ($fin)
            $this->db->limit($fin, $ini);

        if ($maestro == 'FALSE') {
            $this->db->where("(t.id_responsable LIKE '".$this->session->IdUser."' OR t.id_responsable LIKE '".$this->session->IdUser.",%'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser."'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser.",%') ");
        } else {
            if ($usuario != "all") {
                $this->db->where("(t.id_responsable LIKE '".$usuario."' OR t.id_responsable LIKE '".$usuario.",%'
                        OR t.id_responsable LIKE '%,".$usuario."'
                        OR t.id_responsable LIKE '%,".$usuario.",%') ");
                
            }
        }
        
        if(isExecutive($this->session->IdRol) || isExecutiveChild($this->session->IdRol)){
            switch ($this->session->IdRol) {
                case 24: // rol de jose bolaño
                case 23:
                    $this->db->where(" u.rol in (2,13,23,24) ");//ejecutivos olimpica
                    break;
                case 2: // ejecutivos olimpica
                case 7:// ejecutivos otras cuentas
                    $this->db->where(" (u.id_users = ".$this->session->IdUser.") or (t.notificados LIKE '".$this->session->IdUser."' OR t.notificados LIKE '".$this->session->IdUser.",%'
                        OR t.notificados LIKE '%,".$this->session->IdUser."'
                        OR t.notificados LIKE '%,".$this->session->IdUser.",%') ");//ejecutivos olimpica
                    break;
                case 25:// rol de maria paula
                case 30:
                    $this->db->where('u.rol in (7,13,25,30)');//ejecutivos otras cuentas
                    break;
                case 13:
                case 1:
                    $this->db->where('u.rol in (2,7,13,23,24,25,16,1,30)');//ejecutivos all
                    break;

                default:
                    break;
            }
        }
        
        switch ($this->session->IdRol) {
                case 26: // rol de joe 
                    $this->db->where("o.id_cliente <> 1339");
                    break;

                default:
                    break;
        }

        if ($area != "all")
            $this->db->where("t.area_responsable", $area);
        
        if ($op != "all")
            $this->db->where("t.id_op", $op);

        if ($task != "all")
            $this->db->where("t.id_tarea", $task);
        
        if ($cliente != "all")
            $this->db->where("o.id_cliente", $cliente);
        
        if ($modalidad != "all")
            $this->db->where("t.modalidad_cobro", $modalidad);
        
        if ($descripcion != "all")
            $this->db->where("t.descripcion like '%". rawurldecode(trim(str_replace('%20',' ',$descripcion)))."%' ");

        if ($estado == "PENDIENTE") {
            $estado = 13;
            $this->db->where("t.id_estado", $estado);
            $this->db->where("t.modalidad_cobro != 'BONO' ");
            $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");
            $this->db->where(" t.presupuesto is null ");
        }else if ($estado == "COBRADAS") {
            $this->db->where(" t.presupuesto is not null ");
            $this->db->where("t.modalidad_cobro != 'BONO' ");
            $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");
        }elseif($estado == "VENCIDA"){
            $this->db->where(' t.fecha_entrega <= NOW() AND t.id_estado NOT IN (14,13,8,5,4,3,2) ');
        }else if ($estado != "all"){
            if($estado == 1){
                $this->db->where("t.id_estado in(1,11,15,16,17,18,19,20,21) ");
            }else{
                $this->db->where("t.id_estado", $estado);
            }
        }

        $result = $this->db->select('t.id_tarea,t.id_op,un.descripcion AS unidad,c.descripcion AS categoria,DATE_FORMAT(t.fecha_creacion, "%Y%-%m%-%d") as fecha_creacion,t.fecha_entrega,t.fecha_cierre,t.descripcion,s.description AS estado,t.id_estado,s.color,t.tiempo_estimado,f_responsables(t.id_responsable) AS responsable, cl.nombre,t.presupuesto, u.name as creador,DATEDIFF(t.fecha_entrega,CURRENT_DATE()) as dias,t.modalidad_cobro,ca.camp_nombre')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_categoria c', 't.id_categoria = c.id_categoria', 'left')
                ->join('sys_status s', 't.id_estado = s.id_status')
                ->join('sys_unidad_negocio un', 't.id_unidad = un.id_unidad','left')
                ->join('sys_clients cl', 'o.id_cliente = cl.id_client')
                ->join('cat_campanas ca', 'ca.camp_id = o.id_campana')
                ->join('sys_users u','o.id_user = u.id_users')
                ->order_by("t.id_tarea", "desc")
                ->get();
         
//            echo $this->db->last_query();
        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function SelectMyTask($cliente = false, $op = false, $task = false, $estado = false, $usuario = false, $area = false, $maestro, $modalidad= false, $descripcion) {

        if ($maestro == 'FALSE') {
            
            $this->db->where("(t.id_responsable LIKE '".$this->session->IdUser."' OR t.id_responsable LIKE '".$this->session->IdUser.",%'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser."'
                        OR t.id_responsable LIKE '%,".$this->session->IdUser.",%') ");
            
        } else {
            if ($usuario != "all") {
                $this->db->where("t.id_responsable", $usuario);
            }
        }
        
        if(isExecutive($this->session->IdRol) || isExecutiveChild($this->session->IdRol)){
            switch ($this->session->IdRol) {
                case 24: // rol de jose bolaño
                case 23:
                    $this->db->where(" u.rol in (2,13,23,24) ");//ejecutivos olimpica
                    break;
                case 2: // ejecutivos olimpica
                case 7:// ejecutivos otras cuentas
                    $this->db->where(" (u.id_users = ".$this->session->IdUser.") or (t.notificados LIKE '".$this->session->IdUser."' OR t.notificados LIKE '".$this->session->IdUser.",%'
                        OR t.notificados LIKE '%,".$this->session->IdUser."'
                        OR t.notificados LIKE '%,".$this->session->IdUser.",%') ");//ejecutivos olimpica
                    break;
                case 25:// rol de maria paula
                case 30:// rol de maria paula
                    $this->db->where('u.rol in (7,13,25,30)');//ejecutivos otras cuentas
                    break;
                case 13:
                case 1:
                    $this->db->where('u.rol in (2,7,13,23,24,25,30)');//ejecutivos all
                    break;

                default:
                    break;
            }
            
        }
        
        if ($area != "all")
            $this->db->where("t.area_responsable", $area);

        if ($op != "all")
            $this->db->where("t.id_op", $op);

        if ($task != "all")
            $this->db->where("t.id_tarea", $task);

        if ($modalidad != "all")
            $this->db->where("t.modalidad_cobro", $modalidad);
        
        if ($estado == "PENDIENTE") {
            $estado = 13;
            $this->db->where("t.id_estado", $estado);
            $this->db->where("t.modalidad_cobro != 'BONO' ");
            $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");
            $this->db->where(" t.presupuesto is null ");
        }else if ($estado == "COBRADAS") {
            $this->db->where(" t.presupuesto is not null ");
            $this->db->where("t.modalidad_cobro != 'BONO' ");
            $this->db->where(" IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0) NOT LIKE '%,251,%' ");
        }elseif($estado == "VENCIDA"){
            $this->db->where(' t.fecha_entrega <= NOW() AND t.id_estado NOT IN (13,8,5,4,3,2) ');
        }else if ($estado != "all"){
            $this->db->where("t.id_estado", $estado);
        }
        
        if ($cliente != "all")
            $this->db->where("o.id_cliente", $cliente);
        
        if ($descripcion != "all")
            $this->db->where("t.descripcion like '%".rawurldecode(trim(str_replace('%20',' ',$descripcion)))."%' ");

        $result = $this->db->select('t.*')
                ->from('sys_tareas_op t')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_users u','o.id_user = u.id_users')
                ->order_by("t.id_tarea", "desc")
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function ListarTaskNotified($ini, $fin, $op, $task, $estado, $usuario) {

        if ($fin)
            $this->db->limit($fin, $ini);

        if ($usuario != "all") {
            $this->db->where("t.id_responsable", $usuario);
        }
        
        if ($op != "all")
            $this->db->where("t.id_op", $op);

        if ($task != "all")
            $this->db->where("t.id_tarea", $task);

       if ($estado == "PENDIENTE") {
            $estado = 13;
            $this->db->where("t.id_estado", $estado);
            $this->db->where(" t.presupuesto is null ");
        }else if($estado == "VENCIDA"){
            $this->db->where(' t.fecha_entrega <= NOW() AND t.id_estado NOT IN (13,8,5,4,3,2) ');
        }else if ($estado != "all"){
            $this->db->where("t.id_estado", $estado);
        }

        $result = $this->db->select('t.id_tarea,t.id_op,un.descripcion AS unidad,c.descripcion AS categoria,DATE_FORMAT(t.fecha_creacion, "%Y%-%m%-%d") as fecha_creacion,t.fecha_entrega,t.fecha_cierre,t.descripcion,s.description AS estado,t.id_estado,s.color,t.tiempo_estimado,f_responsables(t.id_responsable) AS responsable, cl.nombre,t.presupuesto, u.name as creador,DATEDIFF(t.fecha_entrega,CURRENT_DATE()) as dias')
                ->from('sys_tareas_op t')
                ->join('sys_categoria c', 't.id_categoria = c.id_categoria', 'left')
                ->join('sys_status s', 't.id_estado = s.id_status')
                ->join('sys_unidad_negocio un', 't.id_unidad = un.id_unidad','left')
                ->join('sys_op o','t.id_op = o.id_op')
                ->join('sys_clients cl', 'o.id_cliente = cl.id_client')
                ->join('sys_users u','o.id_user = u.id_users')
                ->where("(t.notificados LIKE '".$this->session->IdUser."' OR t.notificados LIKE '".$this->session->IdUser.",%'
                        OR t.notificados LIKE '%,".$this->session->IdUser."'
                        OR t.notificados LIKE '%,".$this->session->IdUser.",%')
                        ")
                ->order_by("t.id_tarea", "desc")
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function free_result() {
        while (mysqli_more_results($this->db) && mysqli_next_result($this->db)) {
            $dummyResult = mysqli_use_result($this->db);
            if ($dummyResult instanceof mysqli_result) {
                mysqli_free_result($this->db);
            }
        }
    }

    function ListarTareasOP($op) {

        $result = $this->db->select('t.*,c.descripcion AS desc_categoria, a.descripcion as area, e.description AS estado ,e.color, f_responsables(t.id_responsable) as name,DATEDIFF(t.fecha_entrega,CURRENT_DATE()) as dias')
                ->from('sys_tareas_op t')
                ->join('sys_categoria c', 't.id_categoria = c.id_categoria', 'left')
                ->join('sys_area a', 't.area_responsable = a.id_area', 'left')
                ->join('sys_status e', 't.id_estado = e.id_status')
                ->where('id_op', $op)
                ->get();
//        echo $this->db->last_query();
        return $result->result();
    }

    function CargarTipoServicio($id = false) {
        if ($id)
            $this->db->where('id_categoria', $id);

        $result = $this->db->select('`id_tipo_servicio`, UPPER(`nombre`) as nombre, `descripcion`, `tpsv_cebe`, `id_estado`, `id_categoria`')
                ->from('sys_tipo_servicio')
                ->order_by('nombre')
                ->get();

        return $result->result();
    }

    function ListarMedios($id = false) {
        if ($id)
            $this->db->where('medio_id', $id);

        $result = $this->db->select('*')
                ->from('cat_medios')
                ->where('estadoregistro', 1)
                ->order_by('medio_nombre')
                ->get();

        return $result->result();
    }

    function ListarPaginas($id = false) {
        if ($id)
            $this->db->where('pagina_id', $id);

        $result = $this->db->select('*')
                ->from('cat_paginaperiod')
                ->where('est_id', 1)
                ->order_by('pagina_nombre')
                ->get();

        return $result->result();
    }
    
    function CreateTarifa($name, $tipo = false){
        $data = array('descripcion'=>$name);
        if($tipo){
            $data['tipo'] = $tipo;
        }
        $result = $this->db->insert('sys_tarifas_servicio',$data);
        return $this->db->insert_id();
    }

    function ListarTarifas($id = false,$btl = false, $digital = false) {
        if ($id)
            $this->db->where('id_tarifa_servicio', $id);
        
        if($btl){
            $this->db->where('sub_tipo','Btl');
        }else{
            $this->db->where('ifnull(sub_tipo,"") <> "Btl" ');
        }

        $result = $this->db->select('*')
                ->from('sys_tarifas_servicio')
                ->order_by('tipo,descripcion')
                ->get();
       
        return $result->result();
    }

    function ListarTintas($id = false) {
        if ($id)
            $this->db->where('tinta_id', $id);

        $result = $this->db->select('`tinta_id`, UPPER(`tinta_nombre`) as tinta_nombre, `tinta_fecha`, `usr_id`, `usr_mod`, `est_id`')
                ->from('cat_tintas')
                ->where('est_id', 1)
                ->order_by('tinta_nombre')
                ->get();
        
        return $result->result();
    }

    function ListarCanales($id = false) {
        if ($id)
            $this->db->where('id_canal', $id);

        $result = $this->db->select('*')
                ->from('sys_canales')
                ->where('id_estado', 1)
                ->order_by('nombre')
                ->get();

        return $result->result();
    }

    function ListarPiezas($id = false) {
        if ($id)
            $this->db->where('pieza_id', $id);

        $result = $this->db->select('*')
                ->from('cat_piezas')
                ->where('est_id', 1)
                ->order_by('pieza_nombre')
                ->get();

        return $result->result();
    }

    function ListarElementos($id = false) {
        if ($id)
            $this->db->where('elem_id', $id);

        $result = $this->db->select('*')
                ->from('cat_elementos')
                ->where('est_id', 1)
                ->order_by('elem_nombre')
                ->get();

        return $result->result();
    }

    function ListarConceptos($id = false) {
        if ($id)
            $this->db->where('concp_id', $id);

        $result = $this->db->select('*')
                ->from('cat_concepto')
                ->where('estado_id', 1)
                ->order_by('concp_nmb')
                ->get();

        return $result->result();
    }

    function ListarCiudades($id = false) {
        if ($id)
            $this->db->where('id_ciudad', $id);

        $result = $this->db->select('*')
                ->from('sys_ciudades')
                ->where('id_estado', 1)
                ->order_by('nombre')
                ->get();

        return $result->result();
    }

    function ListarUsuariosArea($area = false) {

        if ($area)
            $this->db->where("id_area", $area);

        $result = $this->db->select('*')
                ->from('sys_users')
                ->where('status', 1)
                ->order_by('name')
                ->get();

        return $result->result();
    }

    function ListarEmisoras($id = false) {

        if ($id)
            $this->db->where('emis_id', $id);

        $result = $this->db->select('*')
                ->from('cat_emisoras')
                ->where('emis_estado', 1)
                ->order_by('emis_nombre')
                ->get();

        return $result->result();
    }

    function SelectOP($op = false, $cliente = false, $estado = false, $creador = false, $descripcion = false) {
        
        if ($op != "all")
            $this->db->where("id_op", $op);

        if ($cliente != "all")
            $this->db->where("id_cliente", $cliente);

        if ($estado != "all"){
            if ($estado == 1){
                $this->db->where(" (id_estado = 15 or id_estado = 1) ");
            }else{
                $this->db->where("id_estado", $estado);
            }
        }
        
        if ($descripcion != "all")
            $this->db->where("descripcion_op like '%". rawurldecode(trim(str_replace('%20',' ',$descripcion)))."%' ");

        
        if(in_array($this->session->IdRol,array(7,2))){
            $this->db->where("id_user", $this->session->IdUser);
        }elseif ($creador != "all"){
            $this->db->where("id_user", $creador);
        }
        
        $result = $this->db->select('*')
                ->from('sys_op')
                ->get();

        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function GetListTableOP($ini = false, $fin = false, $op, $cliente, $estado, $creador, $descripcion) {
        
        if ($fin)
            $this->db->limit($fin, $ini);

        if ($op != "all")
            $this->db->where("id_op", $op);

        if ($cliente != "all")
            $this->db->where("id_cliente", $cliente);

        if ($estado != "all"){
            if ($estado == 1){
                $this->db->where(" (id_estado = 15 or id_estado = 1) ");
            }else{
                $this->db->where("id_estado", $estado);
            }
        }
        
        if ($descripcion != "all")
            $this->db->where("descripcion_op like '%". rawurldecode(trim(str_replace('%20',' ',$descripcion)))."%' ");

        
        if(in_array($this->session->IdRol,array(7,2))){//ejecutivos olimpica y otras cuentas
            $this->db->where("id_user", $this->session->IdUser);
        }elseif ($creador != "all"){
            $this->db->where("id_user", $creador);
        }
        
        if(TeamOlimipica($this->session->IdRol)){
            $this->db->where("id_cliente", 1339);
        }else if(TeamOther($this->session->IdRol)){
            $this->db->where("id_cliente <> 1339");
        }
        
        $result = $this->db->select('id_op,cliente,campana,rubro,fecha_creacion,fecha_cierre,contacto,estado,id_op,color,creador,descripcion_op')
                ->from('view_lista_op')
                ->get();
//        echo $this->db->last_query();
        return array("result" => $result->result(), "num" => $result->num_rows());
    }

    function CrearOp($data) {

        $result = $this->db->insert('sys_op', $data);


        if ($result) {
            return array('res' => 'OK', 'id' => $this->db->insert_id());
        } else {
            return array('res' => $this->db->last_query());
        }
    }

    function ActualizarOp($id, $data) {

        $this->db->where('id_op', $id);
        $result = $this->db->update('sys_op', $data);


        if ($result) {
            return array('res' => 'OK', 'id' => $this->db->insert_id());
        } else {
            return array('res' => $this->db->last_query());
        }
    }

    function GetInfoOp($id) {
        $result = $this->db->select('*')
                ->from('sys_op')
                ->join('sys_status', 'sys_status.id_status = sys_op.id_estado')
                ->where('id_op', $id)
                ->get();
        return $result->row();
    }

    function SaveTask($data) {
        $result = $this->db->insert('sys_tareas_op', $data);

        if ($result) {
            $id = $this->db->insert_id();
            $asignada = $this->ListarResponsable(false, explode(',', $data['id_responsable']));
            $old = array();
            $area = $this->buscarNombrePorID('area_responsable', $data['area_responsable'], $old);
            return array('res' => 'OK', 'id' => $id, 'creativo' => (empty($asignada->name))?'<b>SIN ASIGNAR</b>':$asignada->name, 'tipo' => $data['modalidad_cobro'],'fecha_entrega'=>$data['fecha_entrega'],'descripcion'=>strip_tags(mb_substr($data['descripcion'],0,70)),'area'=>$area['area_responsable']);
        } else {
            return array('res' => $this->db->last_query());
        }
    }

    function ListarResponsable($id_user = false, $array = false) {
        if ($id_user)
            $this->db->where("id_users", $id_user);

        if ($array)
            $this->db->where_in("id_users", $array);

        $result = $this->db->select('GROUP_CONCAT(name SEPARATOR ", ") as name')
                ->from("sys_users")
                ->where("status", 1)
                ->order_by("name")
                ->get();


        return $result->row();
    }

    function SaveTask2() {
        $result = $this->db->insert('sys_tareas_op', $_POST);

        if ($result) {
            $id = $this->db->insert_id();
            $asignada = $this->ListarUsuarios($this->id_responsable);

            return array('res' => 'OK', 'id' => $id, 'creativo' => $asignada->name);
        } else {
            return array('res' => $this->db->last_query());
        }
    }

    function createArrayNew() {
        $row_now = array();
//        foreach ($_POST as $clave => $valor):
//            $this->$clave = $valor;
//            $row_now[$clave] = 
//        endforeach;
    }

    function UpdateTask() {

        $id_tarea = $this->id_tarea;
        
        
        unset($_POST['id_tarea']);
        
        $tarifa_servicio = '';
        if (isset($_POST['id_tarifa_servicio'])) {
            if (isset($_POST['tarifa_new'])) {
                if ($_POST['tarifa_new'] != '') {
                    $tarifa_servicio = $this->M_OP->CreateTarifa($_POST['tarifa_new'], 'OTRO');
                }
            }
        }
        unset($_POST['tarifa_new']);
        
        if($tarifa_servicio != ''){
            $_POST['id_tarifa_servicio'] = str_replace('new,', '', $_POST['id_tarifa_servicio']);
            $_POST['id_tarifa_servicio'] = str_replace(',new', '', $_POST['id_tarifa_servicio']);
            $_POST['id_tarifa_servicio'] = str_replace('new', '', $_POST['id_tarifa_servicio']);
            $_POST['id_tarifa_servicio'] = ($_POST['id_tarifa_servicio'] == '')?$tarifa_servicio:$_POST['id_tarifa_servicio'].','.$tarifa_servicio;
        }
        
        $array = array();

        $res = $this->db->select('*')
                ->from('sys_tareas_op')
                ->where('id_tarea', $id_tarea)
                ->get();

        $fila_old = $res->row();

        $this->db->where("id_tarea", $id_tarea);
        $result = $this->db->update('sys_tareas_op', $_POST);
        
        //crear comentario para historial

        $fila_new = array();
        $old = array();
        $new = array();

        if ($fila_old->id_categoria == $this->id_categoria) {
//            $fila_new = $this->createArrayNew();
            foreach ($_POST as $key => $value):

//                if (isset($_POST[$key]) AND isset($fila_old[$key])) {
                if ($_POST[$key] == '' && $fila_old->$key == 0) {
                    unset($fila_new[$key]);
                    unset($fila_old->$key);
                } elseif ($_POST[$key] != $fila_old->$key) { // Identifica los campos que fueron modificados
                    $old[$key] = $fila_old->$key;
                    $new[$key] = $_POST[$key];
                }

            endforeach;
        } else {
            $old['id_categoria'] = $fila_old->id_categoria;
            $new['id_categoria'] = $_POST['id_categoria'];
        }

        foreach ($old as $key => $value) {
            $old = $this->buscarNombrePorID($key, $value, $old, "old");
        }

        foreach ($new as $key => $value) {
            $new = $this->buscarNombrePorID($key, $value, $new, "new");
        }

        if (count($old) && count($new)) {
            $texto = "";
            foreach ($old as $key => $value) {
                $texto .= strtoupper(str_replace('_', ' ', $key)) . " Cambio De <b>" . (empty($value) ? 'Vacio' : $value) . "</b> A <b>" . (empty($new[$key]) ? 'Vacio' : $new[$key]) . "</b><br / >";
            }
            $data = array(
                "id_tarea" => $id_tarea,
                "id_user" => $this->session->IdUser,
                "tipo" => "TEXTO",
                "texto" => $texto,
                "update" => 1
            );
            $result = $this->M_OP->NewComment($data);
        }
        
        if(!empty($this->id_responsable)){
            
            $resOp = $this->db->select('*')
                ->from('sys_tareas_op')
                ->where('id_op', $this->id_op)
                ->where('id_responsable', '')
                ->get();
            
            if($resOp->num_rows() <= 0){
                $this->UpdateStatusOP(array("id_estado" => 1));
            }
        }else{
            $this->UpdateStatusOP(array("id_estado" => 15));
        }
        

        if ($result) {
            return array('res' => 'OK');
        } else {
            return array('res' => $this->db->last_query());
        }
    }

    function buscarNombrePorID($tipo, $id, &$array, $tipo_info = false) {

        switch ($tipo) {
            case 'area_responsable':
                $res = $this->db->select('descripcion')->from('sys_area')->where('id_area', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->descripcion : 'Vacio';
                break;
            case 'id_responsable':
                if(!empty($id)){
                    $res = $this->db->select('GROUP_CONCAT(u.name SEPARATOR ", ") as responsables')->from('sys_users u')->where('u.id_users in (' . $id . ')')->get();
                    $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->responsables : 'Vacio';
                }else{
                    $array[$tipo] = 'SIN ASIGNAR';
                }
                break;
            case 'modalidad_cobro':
                $res = $this->db->select('descripcion')->from('sys_modalidad_cobro')->where('descripcion', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->descripcion : 'Vacio';
                break;
            case 'id_tipo_servicio':
                $res = $this->db->select('nombre')->from('sys_tipo_servicio')->where('id_tipo_servicio', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->nombre : 'Vacio';
                break;
            case 'id_medio':
                $res = $this->db->select('medio_nombre')->from('cat_medios')->where('medio_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->medio_nombre : 'Vacio';
                break;
            case 'id_pagina':
                $res = $this->db->select('pagina_nombre')->from('cat_paginaperiod')->where('pagina_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->pagina_nombre : 'Vacio';
                break;
            case 'id_tinta':
                $res = $this->db->select('tinta_nombre')->from('cat_tintas')->where('tinta_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->tinta_nombre : 'Vacio';
                break;
            case 'id_ciudad':
                $res = $this->db->select('nombre')->from('sys_ciudades')->where('id_ciudad', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->nombre : 'Vacio';
                break;
            case 'id_emisora':
                $res = $this->db->select('emis_nombre')->from('cat_emisoras')->where('emis_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->emis_nombre : 'Vacio';
                break;
            case 'id_programa':
                $res = $this->db->select('progr_nombre')->from('cat_programasr')->where('progr_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->progr_nombre : 'Vacio';
                break;
            case 'id_elemento':
                $res = $this->db->select('elem_nombre')->from('cat_elementos')->where('elem_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->elem_nombre : 'Vacio';
            case 'id_concepto':
                $res = $this->db->select('concp_nmb')->from('cat_concepto')->where('concp_id', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->concp_nmb : 'Vacio';
            case 'id_canal':
                $res = $this->db->select('nombre')->from('sys_canales')->where('id_canal', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->nombre : 'Vacio';
                break;
            case 'id_categoria':
                $res = $this->db->select('descripcion')->from('sys_categoria')->where('id_categoria', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->descripcion : 'Vacio';
                break;
            case 'id_tarifa_servicio':
                if(!empty($id)){
                    $res = $this->db->select('GROUP_CONCAT(descripcion SEPARATOR ", ") as descripcion')->from('sys_tarifas_servicio')->where('id_tarifa_servicio in (' . $id . ')')->get();
                    $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->descripcion : 'Vacio';
                }
                $array[$tipo] = '';
                break;
            case 'id_unidad':
                $res = $this->db->select('descripcion')->from('sys_unidad_negocio')->where('id_unidad', $id)->get();
                $array[$tipo] = ($res->num_rows() > 0) ? $res->row()->descripcion : 'Vacio';
                break;
            case 'notificados':
                if (empty($id)) {
                    $array[$tipo] = 'Ninguno';
                } else {
                    $res = $this->db->select('GROUP_CONCAT(u.name SEPARATOR ", ") as notificados')->from('sys_users u')->where('u.id_users in (' . $id . ')')->get();
                    $array[$tipo] = $res->row()->notificados;
                }
                break;

            default:
                $array[$tipo] = $id;
                break;
        }
        return $array;
    }

    function GetStatusTask($id_tarea) {
        $result = $this->db->select('*')
                ->from('sys_tareas_op')
                ->where('id_tarea', $id_tarea)
                ->get();
        return $result->row();
    }

    function DeleteTask() {

        $row = $this->GetStatusTask($this->id_tarea);

        if ($row->id_estado == 1) {
            $this->db->where('id_tarea', $this->id_tarea);
            $result = $this->db->update('sys_tareas_op', array('id_estado' => 4));

            if ($result) {
                return array('res' => 'OK');
            } else {
                return array('res' => "error", "msg" => $this->db->last_query());
            }
        } else {
            $status = $this->ListStatusAll($row->id_estado);
            return array('res' => "not-active", "msg" => "La tarea debe estar activa para ser anulada", "est" => $status->description);
        }
    }

    function DeleteFileTask($id, $archivo) {
        $this->db->where("id_tarea", $id);
        $this->db->where("nombre", $archivo);

        $this->db->delete("sys_adjuntos_op");
    }

    function Guardar_adjunto($datos) {
        if ($this->db->insert('sys_adjuntos_op', $datos)) {

            $dato_h = array('realizo' => $this->session->userdata('IdUser'),
                'id_tarea' => $datos['id_tarea'],
                'datos' => serialize(array(
                    'adjunto' => 'Nuevo Adjunto ' . $datos['nombre'])));

            $this->db->insert('sys_historial_tareas', $dato_h);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function CloseTask($data) {
        $this->db->where("id_tarea", $this->id_tarea);

        $result = $this->db->update("sys_tareas_op", $data);
        return $result;
    }
    
    function CloseTaskMasiv(){
        
        $result = $this->db->select("*")
                ->from("sys_tareas_op t")
                ->where("t.id_op", $this->id_op)
                ->where("t.id_estado <> 13 ")
                ->get();
        
        foreach ($result->result() as $value) {
            
            $this->db->where("id_tarea", $value->id_tarea);
            $data = array(
                "id_estado" => 13, //cerrado
                "fecha_cierre" => date('Y-m-d H:i:s'),
                "user_cierre" => $this->session->IdUser
            );
            $this->db->update("sys_tareas_op", $data);
            
            $data = array(
                "id_tarea" => $value->id_tarea,
                "id_user" => $this->session->IdUser,
                "tipo" => "TEXTO",
                "texto" => "Cambio de estado a CERRADA",
                "update" => 1
            );
            $this->NewComment($data);
        }
        
        
    }

    function TaskOpActive() {
        $result = $this->db->select("*")
                ->from("sys_tareas_op t")
                ->where("t.id_op", $this->id_op)
                ->where("t.id_estado in (1,11,12,15,16,17,18,19,20,21,22)")
                ->get();
        return array("num" => $result->num_rows(), "rows" => $result->result());
    }

    function TaskOpTV() {
        $result = $this->db->select("*")
                ->from("sys_tareas_op t")
                ->where("t.id_op", $this->id_op)
                ->where("t.id_categoria",5)
                ->get();
        return array("num" => $result->num_rows(), "rows" => $result->result());
    }
    
    function TaskOpStatus($status) {
        $result = $this->db->select("*")
                ->from("sys_tareas_op t")
                ->where("t.id_op", $this->id_op)
                ->where("t.id_estado",$status)
                ->get();
        return array("num" => $result->num_rows(), "rows" => $result->result());
    }

    function TaskOpEnable($task = false) {
        
        if($task)
            $this->id_tarea = $task;

//        $data = array('id_tipo_servicio' => $this->t_servicio, 'id_categoria' => $this->id_categoria);
//        $this->db->where("id_tarea", $this->id_tarea);
//        $this->db->update('sys_tareas_op', $data);

        $result = $this->db->select("t.*,o.id_op,o.id_cliente,o.id_rubro AS producto,o.id_campana,o.fecha_cierre AS fecha_cierre_op,o.id_estado as estado_op ")
                ->from("sys_tareas_op t")
                ->join("sys_op o", "t.id_op = o.id_op")
                ->where("t.id_tarea", $this->id_tarea)
                ->get();

        return array("num" => $result->num_rows(), "rows" => $result->row());
    }

    function UpdateStatusOP($data) {
        $this->db->where("id_op", $this->id_op);
        
        $result = $this->db->update("sys_op", $data);
        return $result;
    }

    function LoadSelect($tabla, $campo, $valor = false) {

        if ($valor)
            $this->valor = $valor;

        if ($tabla == "sys_tipo_servicio") {
            $this->db->where('id_estado', 1);
        }else if ($tabla == "sys_users") {
            $this->db->where('status', 1);
        } else {
            $this->db->where('est_id', 1);
        }

        if (!empty($this->valor))
            $this->db->where($campo, $this->valor);

        $result = $this->db->select('*')
                ->from($tabla)
                ->get();

        return $result->result();
    }

    function LoadCategoria($valor) {

        $result = $this->db->select('c.id_categoria,c.descripcion')
                ->from('sys_unidad_categoria u')
                ->join('sys_categoria c', 'u.id_categoria = c.id_categoria')
                ->where('u.id_unidad', $valor)
                ->where('c.id_estado', 1)
                ->get();

        return $result->result();
    }

    function ListCategoria($tipo) {
        
        foreach ($tipo as $value) {
            $this->db->like('tipo',$value);
        }
        
        $result = $this->db->select('*')
                ->from('sys_categoria c')
                ->where('c.id_estado', 1)
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }

    function IntoTarea($id) {
        $result = $this->db->select("DATE_ADD(CURRENT_DATE(),INTERVAL 1 DAY) AS entrega_pos, t.* ")
                ->from("sys_tareas_op t")
                ->where("t.id_tarea ", $id)
                ->get();
        return $result->row();
    }

    function InfoOP($id) {
        $result = $this->db->select("*")
                ->from("sys_op")
                ->join('cat_provsclies', 'pvcl_id = id_cliente')
                ->join('cat_campanas', 'camp_id = id_campana')
                ->join('cat_prodsclies', 'id_rubro = pdcl_id')
                ->where("id_op", $id)
                ->get();
        return $result->row();
    }

    function ListarComentarios($id) {
        $result = $this->db->select("*")
                ->from("sys_comentario c")
                ->join("sys_users u", "c.id_user = u.id_users")
                ->where("c.id_tarea", $id)
                ->order_by('c.fecha', 'desc')
                ->get();
        return $result->result();
    }
    
    function ValidateTaskPhoto($task){
        $result = $this->db->select('*')
                ->from('sys_tareas_op t')
                ->where('id_tarea',$task)
                ->where('id_duplicado is not null')
                ->where(" IFNULL(`t`.`id_tarifa_servicio`,0) LIKE '251' AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '251,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '%,251'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '%,251,%' ")
                ->where(" IFNULL(`t`.`id_tarifa_servicio`,0) LIKE '250' AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '250,%'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '%,250'
                        AND IFNULL(`t`.`id_tarifa_servicio`,0)  LIKE '%,250,%' ")
                ->get();
        return $result->num_rows();
    }

    function NewComment($data) {
        $result = $this->db->insert("sys_comentario", $data);
        if ($result) {
            return "OK";
        } else {
            return "Error: " . $this->db->last_query();
        }
    }

    function NewAdjunto($data) {
        $result = $this->db->insert("sys_adjuntos_op", $data);
        if ($result) {
            return "OK";
        } else {
            return "Error: " . $this->db->last_query();
        }
    }

    function InfoOpUser($id_tarea) {
        $result = $this->db->select('t.*,o.id_user')
                ->from('sys_tareas_op t')
                ->join('sys_op o', 't.id_op = o.id_op')
                ->where('t.id_tarea', $id_tarea)
                ->get();
        return $result->row();
    }

    function CargarMailsUser($cadena) {
        $result = $this->db->select('*')
                ->from('sys_users')
                ->where('id_users in (' . $cadena . ') ')
                ->get();

        return $result->result();
    }

    function ListarUnidades() {
        $result = $this->db->select('*')
                ->from('sys_unidad_negocio')
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }

    function ListarAdjuntosTareas($id_tarea, $duplicado) {

        //if (!empty($duplicado)) {
            //$this->db->where('id_tarea = ' . $id_tarea . ' or id_tarea = ' . $duplicado);
        //} else {
            $this->db->where('id_tarea', $id_tarea);
        //}

        $result = $this->db->select('concat(id_tarea,"/",nombre) as url,nombre,tipo,fecha')
                ->from('sys_adjuntos_op')
                ->order_by('fecha')
                ->get();

        return $result->result();
    }

    function InfoGeneratePpto($id_op) {
        $result = $this->db->select("*")
                ->from("view_list_task_ppto")
                ->where("id_op", $id_op)
                ->get();

        return $result->result();
    }
    
    function VerificarPPtoMedios($tipo,$ppto){
        switch ($tipo) {
            case "1":
                $table = "presup_avisos";
                $id = 'psav_id';
                break;
            case "2":
                $table = "presup_clasificados";
                $id = 'pscf_id';
                break;
            case "3":
                $table = "presup_revis";
                $id = 'psrev_id';
                break;
            case "4":
                $table = "presup_radio";
                $id = 'psrad_id';
                break;
            case "5":
                $table = "presup_tv";
                $id = 'pstv_id';
                break;
            case "6":
                $table = "presup_prode";
                $id = 'psex_id';
                break;
            case "7":
                $table = "presup_prodi";
                $id = 'psin_id';
                break;
            case "8":
                $table = "publicidad_exterior";
                $id = "pubext_id";
                break;
            case "9":
                $table = "impresos";
                $id = "imp_id";
                break;
            case "10":
                $table = "art_publi";
                $id = "artp_id";
                break;
            default:
                break;
        }
        
        $result = $this->db->select('*')
                ->from($table)
                ->where($id,$ppto)
                ->get();
        
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function CreatePpto($table, $data, $tarea, $ppto, $_servicio, $create_ppto) {
        if(!$create_ppto){
            $result = $this->db->insert($table, $data);
            $id = $this->db->insert_id();
        }else{
            $result = true;
            $id = $create_ppto;
        }
        
        if ($result) {
            
            if ($table != "presup_prodi" && !$create_ppto) {
                $fecha = date('Y-m-d');
                $array = array("doc_id" => $id, "ord_fecha" => $fecha, "usr_id" => 92, "num_impresiones" => "-1", "ord_fechaimp" => $fecha);
                switch ($table) {
                    case "presup_avisos":
                        $array['tpo_doc'] = "aviso";
                        break;
                    case "presup_clasificados":
                        $array['tpo_doc'] = "clasificado";
                        break;
                    case "presup_revis":
                        $array['tpo_doc'] = "revista";
                        break;
                    case "presup_radio":
                        $array['tpo_doc'] = "radio";
                        break;
                    case "presup_tv":
                        $array['tpo_doc'] = "television";
                        break;
                    case "presup_prode":
                        $array['tpo_doc'] = "externa";
                        break;
                    case "presup_prodi":
                        $array['tpo_doc'] = "interna";
                        break;
                    case "publicidad_exterior":
                        $array['tpo_doc'] = "publicidad_exterior";
                        break;
                    case "impresos":
                        $array['tpo_doc'] = "impresos";
                        break;
                    case "art_publi":
                        $array['tpo_doc'] = "articulos_publicitarios";
                        break;
                    default:
                        break;
                }

                $this->db->insert("ordenes", $array);
            }

            $this->db->where("id_tarea", $tarea);

            if (!empty($ppto)) {
                $idppto = $ppto . $id;
            }else{
                $idppto = $id;
            }

            $result = $this->db->update("sys_tareas_op", array("presupuesto" => $idppto));

            return array("res" => "OK", "ppto" => $idppto, "id"=>$id);
        } else {
            return array("res" => "ERROR DE_MEDIOS :" . $this->db->last_query());
        }
    }
    
    function DetailPptoTask($ppto,$tipo,$servicio,$id_tarea){
        $this->db->insert("sys_tarea_ppto", array('id_tarea'=>$id_tarea,'ppto'=>trim($ppto),'categoria'=>$tipo,'servicio'=>$servicio));
    }

    function UpdateTaskPpto($d, $id, $task=false) {
        
        if($task)
            $this->id_tarea = $task;
        
        $this->db->where('id_tarea', $this->id_tarea);
        $result = $this->db->update("sys_tareas_op", $d);
        
//        if(!empty($d->id_responsable)){
//            $this->db->where("id_op", $this->id_op);
//        
//            $result = $this->db->update("sys_op", array("id_estado" => 1));
//        }
        
        return array("res" => "OK", "ppto" => $id);
    }

    function ChangeStatus() {
        $data = array("id_estado" => $this->input->post("id_estado"));

        if ($this->input->post("id_estado") == 4 || $this->input->post("id_estado") == 14)
            $data['motivo_anulacion'] = $this->input->post("motivo");

        $this->db->where("id_tarea", $this->input->post("id_tarea"));
        $res = $this->db->update("sys_tareas_op", $data);

        return $res;
    }

    function CrearCampana($data) {
        $result = $this->db->insert('cat_campanas', $data);

        return $this->db->insert_id();
    }
    
    function CrearProducto($data) {
        $result = $this->db->insert('cat_prodsclies', $data);

        return $this->db->insert_id();
    }

    function AddTime() {
        $this->db->where('id_tarea', $this->id_tarea);
        $result = $this->db->update('sys_tareas_op', array('tiempo_estimado' => $this->hora));

        if ($result) {
            return "OK";
        } else {
            return "Error: " . $this->db->last_query();
        }
    }

    function MaxIdtask() {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(id_tarea) AS `maxid` FROM `sys_tareas_op`')->row();
        if ($row) {
            $maxid = $row->maxid; 
        }
        return $maxid;
    }
    
    function SelectTaskEmail($maxId){
        $result = $this->db->select('*')
                ->from('sys_tareas_op')
                ->where('id_tarea > '.$maxId)
                ->get();

        return $result->result();
    }

    function ListCreatorOP() {
        $result = $this->db->query('SELECT * FROM sys_users s WHERE s.rol IN(SELECT r.id_rol FROM sys_roles_button r WHERE r.id_button = 6)');

        return $result->result();
    }
    
    function SaveImportTask($array){
        if($this->db->insert_batch('sys_tareas_op', $array)){
            return $this->db->insert_id();
        }else{
            return 0;
        }
    }
    
    function SearchTarifa($desc,$tipo){
        $result = $this->db->select('*')
                ->from('sys_tarifas_servicio')
                ->where('descripcion',trim($desc))
                ->where('tipo',$tipo)
                ->get();

        if($result->num_rows() > 0){
            return $result->row()->id_tarifa_servicio;
        }else{
            return $this->CreateTarifa(trim($desc),$tipo);
        }
    }
    
    function SearchDigital($nombre){
        $result = $this->db->select('*')
                ->from('sys_users')
                ->where('name',trim($nombre))
                ->get();

        if($result->num_rows() > 0){
            return $result->row()->id_users;
        }else{
            return '';
        }
    }
    
    function TaskOP($op){
        $result = $this->db->select('t.*,u.descripcion AS unidad')
                ->from('sys_tareas_op t')
                ->join('sys_unidad_negocio u','t.id_unidad = u.id_unidad')
                ->where('id_op', $op)
                ->where('id_estado not in (4,14) ')
                ->get();
        return $result->result();
    }

}
