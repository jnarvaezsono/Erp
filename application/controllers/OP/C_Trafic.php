<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Trafic extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("OP/M_Trafic");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(FULL_CALENDAR_CSS, FULL_SCHELUDER_CSS, SELECT2_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $array['areas'] = $this->M_Trafic->ListarAreas();
        $array['clientes'] = $this->M_Trafic->ListarClientes();
        $array['usuarios'] = $this->M_Trafic->ListarUsuarios();
        $this->load->view('OP/Trafic/V_Program', $array);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(MOMENT, FULL_CALENDAR_JS, FULL_SCHELUDER_JS, LOCALE, SELECT2_JS, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ListTraficData($cliente, $area, $usuario,$rol) {
        $resp = $this->M_Trafic->ListTraficData($cliente, $area, $usuario, $rol);
        echo json_encode($resp);
    }

    function ListTraficTask($cliente, $area, $usuario, $rol) {
        $resp = $this->M_Trafic->ListTraficTask($cliente, $area, $usuario, $rol);
        echo json_encode($resp);
    }

    function CreateXls($archivo = 0) {
//        setlocale(LC_TIME, "spanish");
        require_once(dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel.php');
        require_once dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel/IOFactory.php';
        include dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';

        if ($archivo) {
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$archivo");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: private", false);


            $archivo = dirname(__FILE__) . "/../../includes/phpexcel/temp/" . $archivo;
            $archivo = file_get_contents($archivo);
            echo $archivo;
            exit;
        }

        $archivo = dirname(__FILE__) . "/../../includes/phpexcel/temp/Trafico.xls";

        copy(dirname(__FILE__) . "/../../includes/phpexcel/plantillas/Trafico.xlsx", $archivo);

        try {

            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo(PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

       
        $style = array('font' => array('bold' => true, 'color' => array('rgb' => 'ffffff'), 'size' => 8, 'name' => 'Arial',),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY),
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,),), 'fill'
        );

        $days = $this->current_week(date('Y-m-d'));

        $A = $objPHPExcel->getActiveSheet(0);
        $A->setCellValue('A1', " TRAFICO SEMANA DESDE ");
        $A->setCellValue('J6', "")->getStyle("J6")->applyFromArray(array('fill'=>array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => 'b6ef9e',), 'endcolor' => array('rgb' => 'b6ef9e',),)));
        $A->setCellValue('K6', "Activo");
        $A->setCellValue('J7', "")->getStyle("J7")->applyFromArray(array('fill'=>array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => 'b5bbc8',), 'endcolor' => array('rgb' => 'b5bbc8',),)));
        $A->setCellValue('K7', "Anulado");
        $A->setCellValue('J8', "")->getStyle("J8")->applyFromArray(array('fill'=>array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => '265e0f',), 'endcolor' => array('rgb' => '265e0f',),)));
        $A->setCellValue('K8', "Enviado Cliente");
        $A->setCellValue('J9', "")->getStyle("J9")->applyFromArray(array('fill'=>array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => '222d32',), 'endcolor' => array('rgb' => '222d32',),)));
        $A->setCellValue('K9', "Cerrado");
        $A->setCellValue('J10', "")->getStyle("J10")->applyFromArray(array('fill'=>array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => 'dd4b39',), 'endcolor' => array('rgb' => 'dd4b39',),)));
        $A->setCellValue('K10', "Cancelado");
        

        $arraCab = array('B', 'C', 'D', 'E', 'F', 'G', 'H');

        foreach ($days as $key => $value) {
            $A->setCellValue("{$arraCab[$key]}5", strftime("%A, %d de %B", strtotime($value)));
        }
        //$A->mergeCells("A8:C8"); 

        $user = $this->M_Trafic->ListTraficData($this->input->post('cliente'), $this->input->post('area'), $this->input->post('usuarios'), $this->input->post('rol'),true);
        $y = 6;
        $contUsuario = 1;
        foreach ($user as $v) {
            $A->setCellValue("A{$y}", $v->title);
            $arrDupli = '';
            $i = 0;
            $ini = $y;
            foreach ($days as $fecha) {
                $task = $this->M_Trafic->ListTask($v->id, $fecha, $arrDupli);

                foreach ($task as $t) {

                    $style['fill'] = $this->CargueStyle($t->id_estado);

                    if ($arrDupli != '') {
                        $arrDupli .= ',' . $t->id_tarea;
                    } else {
                        $arrDupli = $t->id_tarea;
                    }
                    $A->setCellValue("{$arraCab[$i]}{$y}", $t->descripcion)->getStyle("{$arraCab[$i]}{$y}")->applyFromArray($style);

                    if ($t->dif_entrega > 0) {
                        for ($index = 1; $index <= $t->dif_entrega; $index++) {
                            if (array_key_exists($i + $index, $arraCab)) {
                                $letraFin = $arraCab[$i + $index];
                            }
                        }
                        $A->mergeCells("{$arraCab[$i]}{$y}:{$letraFin}{$y}");
                    }
                    $y++;
                }
                $i++;
            }
            $A->mergeCells("A{$ini}:A{$y}");
            $y++;
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'Trafico.xls');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }

    function CargueStyle($id_estado) {
        switch ($id_estado) {
            case 1:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => 'b6ef9e',), 'endcolor' => array('rgb' => 'b6ef9e',),);
                break;
            case 4:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID,'rotation' => 90, 'startcolor' => array('rgb' => 'b5bbc8',), 'endcolor' => array('rgb' => 'b5bbc8',),);
                break;
            case 11:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID,'rotation' => 90, 'startcolor' => array('rgb' => '265e0f',), 'endcolor' => array('rgb' => '265e0f',),);
                break;
            case 13:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID,'rotation' => 90, 'startcolor' => array('rgb' => '222d32',), 'endcolor' => array('rgb' => '222d32',),);
                break;
            case 14:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID,'rotation' => 90, 'startcolor' => array('rgb' => 'dd4b39',), 'endcolor' => array('rgb' => 'dd4b39',),);
                break;
            default:
                $styleCss = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'rotation' => 90, 'startcolor' => array('rgb' => '2a1447',), 'endcolor' => array('rgb' => '2a1447',),);
                break;
        }
        
        return $styleCss;
    }

}
