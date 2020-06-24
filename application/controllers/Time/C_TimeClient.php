<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_TimeClient extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Time/M_Time');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(MORRIS_CSS, DATEPICKER_CSS, OTHER_RANGOPICKER_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['users'] = $this->M_Time->ListarUsuarios();
        $data['table'] = $this->M_Time->tableTree();
        $this->load->view('Time/V_Client', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(MORRIS_JS, MORRIS_JS2, DATEPICKER_JS, MOMENT, OTHER_RANGOPICKER_JS, SELECT2_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function LoadTimesClients() {
        $data = $this->M_Time->LoadTimesClients($this->input->post('periodo'));

        echo json_encode(array('clients' => $data['rows']));
    }

    function getGrafOne() {
        $total = $this->M_Time->grafOne($this->input->post('ini'), $this->input->post('fin'), true);
        $result = $this->M_Time->grafOne($this->input->post('ini'), $this->input->post('fin'));

        $count = 1;
        $html = 0;
        $data = array();
        $title = 'De ' . strftime("%A, %d de %B", strtotime($this->input->post('ini'))) . ' A ' . strftime("%A, %d de %B", strtotime($this->input->post('fin')));
        foreach ($result['rows'] as $v) {
            $data[] = array('y' => $v->type, 'a' => $v->cantidad);

            $porc = ($v->cantidad / ($total->cantidad)) * 100;

            $html .= '<tr>
                    <td>' . $count++ . '</td>
                    <td>' . $v->type . '</td>
                    <td>' . $v->cantidad . '</td>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-primary" style="width: ' . round($porc, 2) . '%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-blue">' . round($porc, 2) . '%</span></td>
                    </tr>';
        }

        echo json_encode(array('data' => $data, 'table' => $html, 'title' => $title));
    }

    function getGrafTwo() {
        $total = $this->M_Time->grafTwo($this->input->post('ini'), $this->input->post('fin'), true);
        $result = $this->M_Time->grafTwo($this->input->post('ini'), $this->input->post('fin'));

        $count = 1;
        $html = 0;
        $data = array();
        $title = 'De ' . strftime("%A, %d de %B", strtotime($this->input->post('ini'))) . ' A ' . strftime("%A, %d de %B", strtotime($this->input->post('fin')));
        foreach ($result['rows'] as $v) {

            $data[] = array('y' => $v->cliente, 'a' => $v->hora);

            $porc = ($v->hora / ($total->hora)) * 100;

            $html .= '<tr>
                    <td>' . $count++ . '</td>
                    <td>' . $v->cliente . '</td>
                    <td>' . $v->tiempo . '</td>
                    <td>
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-success" style="width: ' . round($porc, 2) . '%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-green">' . round($porc, 2) . '%</span></td>
                    </tr>';
        }

        echo json_encode(array('data' => $data, 'table' => $html, 'title' => $title));
    }

    function LoadTimesClientsRange() {
        $result = $this->M_Time->LoadTimesClients($this->input->post('periodo'));

        $data = array();
        foreach ($result['rows'] as $v) {
            $old = $this->M_Time->LoadTimesClients($this->input->post('old'), $v->id_cliente);

            $a = 0;

            if ($old['num'] > 0) {
                $a = $old['rows']->sumtime;
            }

            $data[] = array('y' => $v->nombre, 'a' => $a, 'b' => $v->sumtime);
        }

        echo json_encode(array('clients' => $data));
    }

    function LoadrangeUser() {
        $result = $this->M_Time->LoadrangeUser($this->input->post('user'), $this->input->post('ini'), $this->input->post('fin'));

        echo json_encode(array('clients' => $result['rows']));
    }

    function downloadExcel($archivo = 0) {
        require_once(dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel.php');
        require_once dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel/IOFactory.php';
        include dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';

        if ($archivo) {
            $archivo .= '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$archivo");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: private", false);


            $ruta = dirname(__FILE__) . "/../../includes/phpexcel/temp/" . $archivo;
            $archivo = file_get_contents($ruta);
            echo $archivo;

            exit;
        } else {
            if (file_exists(dirname(__FILE__) . "/../../includes/phpexcel/temp/Timesheets.xls")) {
                unlink(dirname(__FILE__) . "/../../includes/phpexcel/temp/Timesheets.xls");
            }
        }

        $archivo = dirname(__FILE__) . "/../../includes/phpexcel/temp/Timesheets.xls";

        copy(dirname(__FILE__) . "/../../includes/phpexcel/plantillas/Timesheets.xlsx", $archivo);

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo(PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $A = $objPHPExcel->getActiveSheet(0);
        $y = 2;

        $result = $this->M_Time->LoadTimesUser($this->input->post('fecha_ini'), $this->input->post('fecha_fin'), $this->input->post('usuario'));
        $days = $this->M_Time->loadtimesDays($this->input->post('fecha_ini'), $this->input->post('fecha_fin'), $this->input->post('usuario'));
        $detail = $this->M_Time->loadtimesDaysDetail($this->input->post('fecha_ini'), $this->input->post('fecha_fin'), $this->input->post('usuario'));

        foreach ($result as $v) {
            $A->setCellValue("A$y", $v->nombre);
            $A->setCellValue("B$y", $v->fecha);
            $A->setCellValue("C$y", $v->tiempo);
            $A->setCellValue("D$y", $v->accion);
            $A->setCellValue("E$y", $v->actividad);
            $A->setCellValue("F$y", $v->cliente);
            $A->setCellValue("G$y", $v->solicitante);
            $A->setCellValue("H$y", $v->descripcion);
            $y++;
        }

        $B = $objPHPExcel->setActiveSheetIndex(1);

        $col = 1;
        foreach ($days as $v) {
            $B->setCellValueByColumnAndRow($col, 1, $v->fecha);
            $col++;
        }

        $array = array();
        $users = array();
        foreach ($detail as $value) {
            $array[$value->id_users][$value->fecha] = $value->tiempo;
            $users[$value->id_users] = $value->usuario;
        }
       
        $y = 2;
        
        foreach ($users as $key => $name) {
            
            $col = 1;
            $x = 2;

            $B->setCellValue("A$y", $name);

            foreach ($days as $v) {
                
                if(array_key_exists($v->fecha, $array[$key])){
                    $B->setCellValueByColumnAndRow($col, $y, $array[$key][$v->fecha]);
                }
                $col++;
            }
            $y++;
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'Timesheets');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }

}
