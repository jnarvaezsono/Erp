<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VS_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function Params() {
        $result = $this->db->select("*")
                ->from("sys_parameter")
                ->get();
        return $result->row();
    }

    function ListStatusAll($id = null) {
        if (!empty($id)) {
            $this->db->where("id_status", $id);
        }
        $result = $this->db->select("*")
                ->from("sys_status")
                ->order_by("description")
                ->get();

        if (!empty($id)) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function LoadIcons() {
        $result = $this->db->select("*")
                ->from("sys_icon")
                ->order_by("icon")
                ->get();
        return $result->result();
    }

    function ListAuxManintenance() {
        $result = $this->db->select("*")
                ->from("sys_users")
                ->where("rol", 5)
                ->order_by("name")
                ->get();

        return $result->result();
    }

    function ListarUsuarios($id_user = false, $id_area = false, $array = false, $rol = false) {

        if ($id_user)
            $this->db->where("id_users", $id_user);

        if ($id_area)
            $this->db->where("id_area", $id_area);

        if ($rol)
            $this->db->where("rol", $rol);

        if ($array)
            $this->db->where_in("id_area", $array);

        $result = $this->db->select("*")
                ->from("sys_users")
                ->where("status", 1)
                ->order_by("name")
                ->get();

        if ($id_user) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function LoadButtonPermissions($application) {
        $result = $this->db->select("*")
                ->from("sys_roles_button r")
                ->join("sys_button b", "b.id_button = r.id_button")
                ->where("b.application", $application)
                ->where("r.id_rol", $this->session->IdRol)
                ->get();

        return $result->result();
    }

    function CreateNotification($arrayUser, $sms, $url) {

        $array = array();
        foreach ($arrayUser as $v) {
            $array[] = array("texto" => $sms, "id_users" => $v, "url" => $url);
        }
        $rs = $this->db->insert_batch('sys_notificacion', $array);
    }

    function Tmp($id_tarea, $texto, $op = false) {
        $this->db->truncate("sys_tmp_email");
        if ($op) {
            $this->db->insert("sys_tmp_email", array("id_tarea" => $id_tarea, "id_op" => $op, "texto" => $texto, "usuario" => $this->session->NameUser, "creador" => $this->session->IdUser, "url" => base_url() . "OP/C_OP/Info/" . $op));
        } else {
            $this->db->insert("sys_tmp_email", array("id_tarea" => $id_tarea, "id_op" => null, "texto" => $texto, "usuario" => $this->session->NameUser, "creador" => $this->session->IdUser, "url" => base_url() . "OP/C_OP/Task/" . $id_tarea));
        }
    }

    function getResolution($id) {
        $result = $this->db->select('*')
                ->from('cat_resoluciones')
                ->where("resol_id", $id)
                ->get();

        return $result->row();
    }

    function InfoDpto($name) {
        $result = $this->db->select('*')
                ->from('sys_departamento')
                ->where("nombre", $name)
                ->get();

        return $result->row();
    }

    function InfoCity($name, $departamento) {
        $result = $this->db->select('*')
                ->from('sys_ciudades')
                ->where("nombre", $name)
                ->where("departamento", $departamento)
                ->get();

        return $result->row();
    }

    function ListarClientes($id_cliente = false) {

        if ($id_cliente) {
            $this->db->where('pvcl_id', $id_cliente);
        } else {
            if (TeamOlimipica($this->session->IdRol)) {
                $this->db->where('pvcl_id = 1339 ');
            } else if (TeamOther($this->session->IdRol)) {
                $this->db->where('pvcl_id != 1339 ');
            }
        }

        $result = $this->db->select('*')
                ->from('cat_provsclies')
                ->where('es_cliente', 1)
                ->order_by('pvcl_nombre')
                ->get();


        if ($id_cliente) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function ListarClientesNew($id_cliente = false, $lock = false, $all = false) {

        if ($lock) {
            $this->db->where('id_status', 1);
        }
		
		
        if ($id_cliente) {
                $this->db->where('id_client', $id_cliente);
        } else {
            if(!$all){
                if (TeamOlimipica($this->session->IdRol)) {
                        $this->db->where('id_client = 1339 ');
                } else if (TeamOther($this->session->IdRol)) {
                        $this->db->where('id_client != 1339 ');
                }
            }
        }
		
		
        $result = $this->db->select('*')
                ->from('sys_clients')
                ->where('cliente', 1)
                ->order_by('nombre')
                ->get();


        if ($id_cliente) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function GetPptoT($id) {
        $result = $this->db->select('*')
                ->from('all_presup')
                ->where("id", $id)
                ->get();

        return $result->row();
    }

    function ListarProveedoresNew($id_cliente = false) {

        if ($id_cliente) {
            $this->db->where('id_client', $id_cliente);
        }

        $result = $this->db->select('*')
                ->from('sys_clients')
                ->where('proveedor', 1)
                ->where('id_status', 1)
                ->order_by('nombre')
                ->get();


        if ($id_cliente) {
            return $result->row();
        } else {
            return $result->result();
        }
    }

    function ListarProveedor() {
        $result = $this->db->select('*')
                ->from('cat_provsclies')
                ->where('es_proveedor', 1)
                ->order_by('pvcl_nombre')
                ->get();

        return $result->result();
    }

    function ListarCategorias($id = false) {

        if ($id)
            $this->db->where('id_categoria', $id);

        $result = $this->db->select('*')
                ->from('sys_categoria')
                ->where('id_estado', 1)
                ->order_by('descripcion')
                ->get();

        return $result->result();
    }

    function DeleteNotificationAll($id_tarea) {
        $this->db->where(" url like '%C_OP/Task/" . $id_tarea . "%' ");
        $this->db->where("id_users", $this->session->IdUser);
        $this->db->delete("sys_notificacion");
    }

    function LoadUserTeam($rol) {
        if ($rol == 24) { //ejecutivos olimpica
            $this->db->where('rol in (2,23,13) ');
        } else if ($rol == 25 || $rol == 30) {// ejecutivos otras cuentas
            $this->db->where('rol in (7,13,30)');
        } else if ($rol == 13 || $rol == 1) {// ejecutivos otras cuentas
            $this->db->where('rol in (2,7,23,24,25,30) ');
        } else if ($rol == 8) {// Director Creativo Olimpica
            $this->db->where('rol', 3);
        } else if ($rol == 26) {// Director Creativo Otras Cuentas
            $this->db->where('rol', 6);
        } else if ($rol == 27) {// Director Creativo Digital
            $this->db->where('rol', 9);
        } else if ($rol == 11) {// Gerencia de medios
            $this->db->where('rol', 4);
        } else if ($rol == 5) {// Gerencia de medios
            $this->db->where('rol in (8,3,26,6,27,9,19) ');
        } else if ($rol == 16) {
            $this->db->where('rol', 10);
        }

        $res = $this->db->select('*')
                ->from('sys_users')
                ->where('status', 1)
                ->get();

        return $res->result();
    }

    function LoadDayNotWorking() {
        $result = $this->db->select('*')
                ->from('sys_festivos')
                ->order_by('fecha')
                ->get();

        $array = array();
        foreach ($result->result() as $r) {
            $array[] = $r->fecha;
        }
        return $array;
    }

    function SaveData($table, $data) {
        $result = $this->db->insert($table, $data);
        $res = 0;
        if ($result) {
            $res = $this->db->insert_id();
        }
        return $res;
    }

    function RemoveData($table, $field, $id) {
        $this->db->where($field, $id);
        $result = $this->db->delete($table);
        $res = 0;
        if ($result) {
            $res = 1;
        }
        return $res;
    }

    function UpdateData($table, $field, $id, $data) {
        $this->db->where($field, $id);
        $result = $this->db->update($table, $data);
        $res = 0;
        if ($result) {
            $res = 1;
        }
        return $res;
    }

    function InfoDataBilling() {
        $res = $this->db->select('*')
                ->from('sys_data_billing')
                ->get();

        return $res->row();
    }

    function select($table, $order) {
        $res = $this->db->select('*')
                ->from($table)
                ->order_by($order)
                ->get();

        return $res->result();
    }

    function lockClient($id_cliente, $status) {
        $this->db->where('id_client', $id_cliente);
        $this->db->update('sys_clients', array('id_status' => $status));
    }

    function getTotalPptoOc($id_cliente, $ppto = false) {

        if ($ppto)
            $this->db->where('id != ' . $ppto);

        $rsP = $this->db->select('SUM(total) AS total')
                        ->from('all_presup p')
                        ->where('p.id_cliente', $id_cliente)
                        ->where('p.estado NOT IN (9999,47)')
                        ->where('p.id_servicio NOT IN (82,83,84,85,86,87,94,96,97,98,99,100,101,103)')// excluir diseño
                        ->get()->row();


        $rsOC = $this->db->select('SUM(c.ordcos_total) AS total')
                        ->from('ord_costos c')
                        ->where('c.pvcl_id_clie', $id_cliente)
                        ->where('c.est_id NOT IN (9999,39)')
                        ->where('c.tpsv_id NOT IN (82,83,84,85,86,87,94,96,97,98,99,100,101,103)')// excluir diseño
                        ->get()->row();

        $total = $rsP->total + $rsOC->total;

        return $total;
    }

    function festivos() {
        $rs = $this->db->select('fecha')
                ->from('sys_festivos')
                ->get();

        return $rs->result();
    }
} 