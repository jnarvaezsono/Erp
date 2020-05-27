<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Service extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ForgotToPassword($id) {
        if ($this->session->has_userdata('IdRol')) {
            header('Location: ' . base_url() . "C_Panel");
        } else {
            $this->load->view('Login/V_Forgot', array("id" => $id));
        }
    }

    function Upload() {
        $dir = './Adjuntos/ckEditor/' . $this->session->IdUser;
        if (!file_exists('./Adjuntos/ckEditor/' . $this->session->IdUser)) {
            mkdir($dir, 0777, true);
        }

        $config['upload_path'] = './Adjuntos/ckEditor/' . $this->session->IdUser;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1024;
//        $config['max_width']            = 1024;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('upload')) {
            echo json_encode(array('error' => $this->upload->display_errors()));
        } else {
            $upload_data = $this->upload->data();

//            echo json_encode(array('file_name' => $upload_data['file_name']));
            echo json_encode(array('OK' => 'Archivo Cargado'));
        }
    }

    function ShowFiles() {

        $myarray = glob('./Adjuntos/ckEditor/' . $this->session->IdUser . '/*');
        usort($myarray, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));

        $this->load->view('Template/V_File_Browser', array('fileList' => $myarray));
    }

    public function DeleteNotificationAll() {
        $this->M_Main->DeleteNotificationAllMain();
    }

    function prueba() {
        $result = $this->db->query("SELECT * FROM sys_users s join sys_area a on s.id_area = a.id_area WHERE s.rol IN(3,6,8,9,10,16,17,18,19) AND s.`status` = 1 order by descripcion");

        $html = "<table border>";
        foreach ($result->result() as $value) {

            $q = $this->db->query("SELECT count(*) as cant FROM sys_tareas_op t WHERE t.fecha_creacion >='2019-10-01' and (t.id_responsable LIKE '" . $value->id_users . "' OR t.id_responsable LIKE '" . $value->id_users . ",%'
                        OR t.id_responsable LIKE '%," . $value->id_users . "'
                        OR t.id_responsable LIKE '%," . $value->id_users . ",%') ");

            $row = $q->row();

            $html .= "<tr>";
            $html .= "<td>" . $value->name . "</td>";
            $html .= "<td>" . $value->descripcion . "</td>";
            $html .= "<td>" . $row->cant . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
    }

    function radicado() {
        $result = $this->db->query('SELECT GROUP_CONCAT(r.ordfactura_id SEPARATOR ", ") AS radicados,GROUP_CONCAT(r.ord_id SEPARATOR ", ")  AS facturas,r.no_orden AS no_orden,
                                    r.tipo,r.valor_total,r.valor_bruto,sum(r.valor_cobrado) as cobrado -- ,r.valor_faltante
                                    FROM radicados r
                                    GROUP BY r.no_orden,r.tipo
                                    ORDER BY r.no_orden');

        $array = array();
        foreach ($result->result() as $v) {

            switch ($v->tipo) {
                case 'Gastos':
                    // ord_gasto
                    break;
                case 'Costos':
                    // ord costo
                    break;
                case 'aviso':
                    // orden hasta abajo
                    break;
                case 'clasificado':
                   
                    break;
                case 'articulos_publicitarios':
                    
                    break;
                case 'publicidad_exterior':
                    
                    break;
                case 'externa':

                    break;
                case 'interna':
                    
                    break;
                case 'impreso':
                    
                    break;
                case 'radio':
                    
                    break;
                case 'revista':
                    
                    break;
                case 'television':
                    
                    break;

                default:

                    break;
            }

            //$q = $this->db->query('');

            $array[$v->tipo][$v->no_orden][] = array('cobrado' => $v->valor_cobrado, 'cobrado' => $v->valor_cobrado);
        }
    }

}
