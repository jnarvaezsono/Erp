<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Main extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function ListMenu() {
        $rol = $this->session->IdRol;

        $result = $this->db->select("m.*")
                ->from("sys_roles_menu t")
                ->join("sys_menu m", "t.id_menu = m.id_menu")
                ->where("t.id_roles", $rol)
                ->where("m.status", 1)
                ->where("type in (1,3)")
                ->order_by("order,title")
                ->get();

        $arrayRoot = array();
        foreach ($result->result() as $m) {

            $arrayChilds = array();
            if ($m->type == 3) {
                $arrayChilds = $this->LoadChild($m->id_menu, $rol);
            }

            $arrayRoot[$m->id_menu] = array("title" => $m->title, "url" => $m->url, "icon" => $m->icon, "type" => $m->type, "childs" => $arrayChilds);
        }

        return $arrayRoot;
    }

    function LoadChild($father, $rol) {
        $array = array();

        $result_hijo = $this->db->select("m.*")
                ->from("sys_roles_menu t")
                ->join("sys_menu m", "t.id_menu = m.id_menu")
                ->where("t.id_roles", $rol)
                ->where("m.root", $father)
                ->where("m.status", 1)
                ->where("type in (2,4)")
                ->order_by("title")
                ->get();

        foreach ($result_hijo->result() as $h) {
            $arrayChilds = array();
            if ($h->type == 4 || $h->type == 2) {
                $arrayChilds = $this->LoadChild($h->id_menu, $rol);
            }
            $array[$h->id_menu] = array("title" => $h->title, "url" => $h->url, "icon" => $h->icon, "type" => $h->type, "childs" => $arrayChilds);
        }
        return $array;
    }

    function ValidateForgot($email) {

        $this->db;

        $result = $this->db->select("*")
                ->from("sys_users u")
                ->join("sys_roles r", "u.rol = r.id_roles")
                ->join("sys_preferences_html p", "u.id_users = p.id_users", "left")
                ->where("u.email", $email)
                ->where("u.status", 1)
                ->get();

        if ($result->num_rows() > 0) {
            $reg = $result->row();

            return $reg->id_users;
        } else {
            return 0;
        }
    }

    function ChangePassword() {
        $this->db->trans_begin();

        $data = array("password" => md5($this->input->post("psw")), "last_date" => date('Y-m-d'), "last_entry" => date("Y-m-d H:i:s"));
        $this->db->where("id_users", $this->input->post("id"));
        $this->db->update("sys_users", $data);

        $result = $this->db->select("*")
                ->from("sys_users u")
                ->join("sys_roles r", "u.rol = r.id_roles")
                ->join("sys_preferences_html p", "u.id_users = p.id_users", "left")
                ->where("u.id_users", $this->input->post("id"))
                ->where("u.status", 1)
                ->get();

        if ($result->num_rows() > 0) {
            $reg = $result->row();

            $newdata = array(
                'IdUser' => $reg->id_users,
                'UserMedios' => $reg->id_users_medios,
                'NameUser' => $reg->name,
                'IdRol' => $reg->rol,
                'Rol' => $reg->description,
                'Email' => $reg->email,
                'Avatar' => $reg->avatar,
                'Skin' => $reg->skin,
                'Layout' => $reg->layout,
                'Sidebar' => $reg->sidebar,
                'ip' => $reg->ip,
                'mac' => $reg->mac_address,
                'Google' => ($data) ? true : false
            );

            $this->session->set_userdata($newdata);
            $res = "OK";
        } else {
            $res = "ERROR";
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $res;
    }

    function Validar_User($data = null) {

        $this->psw = $this->input->post("psw");

        if (!empty($this->input->post('pswnew'))):
            $this->db->where("user", $this->input->post("usr"));
            $this->db->where("password", md5($this->input->post("psw")));
            $this->db->update("sys_users", array("password" => md5($this->input->post("pswnew")), "last_date" => date('Y-m-d')));
            $this->psw = $this->input->post("pswnew");
        endif;

        if ($data):
            $this->db->where("u.email", $data['email']);
        else:
            $this->db->where("u.user", $this->input->post("usr"));
            $this->db->where("u.password", md5($this->psw));
        endif;

        $result = $this->db->select("*,u.status as activ")
                ->from("sys_users u")
                ->join("sys_roles r", "u.rol = r.id_roles")
                ->join("sys_preferences_html p", "u.id_users = p.id_users", "left")
                ->get();

        if ($result->num_rows() > 0) {

            $reg = $result->row();

            if ($reg->activ == 1) {
                
                $datetime1 = new DateTime($reg->last_date);
                $datetime2 = new DateTime(date("Y-m-d"));
                $interval = $datetime1->diff($datetime2);

                if ((int) $interval->format('%a') > 60) {
                    return "CHANGE";
                } else {
                    
//                    $rsTime = $this->db->query("SELECT * FROM sys_timesheet t 
//                                    WHERE t.id_users = ".$reg->id_users." 
//                                    AND t.id_estado = 10 AND t.num not in (6,7) AND t.festivo != 1 
//                                    AND t.fecha <=  DATE_SUB(CURDATE(),INTERVAL 2 DAY)")->num_rows();
                    
                    $this->db->where("id_users", $reg->id_users);
                    $this->db->update("sys_users", array("last_entry" => date("Y-m-d H:i:s")));

                    $newdata = array(
                        'IdUser' => $reg->id_users,
                        'UserMedios' => $reg->id_users_medios,
                        'NameUser' => $reg->name,
                        'IdRol' => $reg->rol,
                        'Rol' => $reg->description,
                        'Email' => $reg->email,
                        'Avatar' => $reg->avatar,
                        'Skin' => $reg->skin,
                        'Layout' => $reg->layout,
                        'Sidebar' => $reg->sidebar,
//                        'count_time' => $rsTime,
                        'count_time' => 0,
                        'ip' => $reg->ip,
                        'mac' => $reg->mac_address,
                        'Google' => ($data) ? true : false
                    );

                    $this->session->set_userdata($newdata);

                    $this->db->insert("sys_access_ip", array("fecha" => date("Y-m-d H:i:s"), "nombre" => $reg->name, "ip" => $this->getUserIP()));

                    return "OK";
                }
                
            }else{
                return "LOCKED";
            }
        } else {
            return "ERROR";
        }
    }

    function UpdatePreferences() {
        $this->db->where("id_users", $this->session->IdUser);
        $this->db->update("sys_preferences_html", array($this->input->post("campo") => $this->input->post("valor")));

        if ($this->input->post("campo") == "skin") {
            $this->session->set_userdata("Skin", $this->input->post("valor"));
        } else if ($this->input->post("campo") == "layout") {
            $this->session->set_userdata("Layout", $this->input->post("valor"));
        } else if ($this->input->post("campo") == "sidebar") {
            $this->session->set_userdata("Sidebar", $this->input->post("valor"));
        }
    }

    function LoadNotifications() {
        $result = $this->db->select("*")
                ->from("sys_notificacion")
                ->where("id_users", $this->session->IdUser)
                ->order_by('fecha desc')
                ->get();

        return array("rows" => $result->result(), "num" => $result->num_rows());
    }

    function DeleteNotification() {
        $this->db->where("id_notificacion", $this->input->post('id'));
        $this->db->delete("sys_notificacion");
    }

    function DeleteNotificationAllMain() {
        $this->db->query('CALL DeleteNotification();');
    }

    function getUserIP() {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

}
