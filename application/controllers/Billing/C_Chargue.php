<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Chargue extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Billing/M_Chargue');
    }

    function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(ALERTIFY_CSS, ALERTIFY_CSS2, SWEETALERT_CSS, RANGOPICKER_CSS, FILER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $this->load->view('Billing/Chargue/V_Panel');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(ALERTIFY_JS, MOMENT, SWEETALERT_JS, RANGOPICKER_JS, FILER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function Upexcelfile() {
        require_once(dirname(__FILE__) . '/../../../dist/jQuery.filer/php/class.uploader.php');

        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['files'], array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => dirname(__FILE__) . '/../../../Adjuntos/temp/', //Upload directory {String}
            'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'replace' => true, //Replace the file if it already exists  {Boolean}
            'perms' => 0777, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => null //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));

        if ($data['isComplete']) {
            $info = $data['data'];
            foreach ($info['metas'] as $value) {
                $nombre = $value['name'];
                $result['opcion'] = $this->ReadFile($nombre);
                $result['res'] = 'OK';
            }
        } else if ($data['hasErrors']) {
            $result = array();
            $result['res'] = $data['errors'];
        }

        echo json_encode($result);
    }

    function ReadFile($name) {
        require_once(dirname(__FILE__) . '/../../includes/phpexcel/Classes/PHPExcel.php');

        $file = dirname(__FILE__) . '/../../../Adjuntos/temp/' . $name;

        $Reader = PHPExcel_IOFactory::createReaderForFile($file);
        $Reader->setReadDataOnly(true);
        $objXLS = $Reader->load($file);

        $sheet = $objXLS->getSheet(0);

        $error = array();
        $details = array();
        $insert = 0;
        $row = 6;
        $loop = ($sheet->getCell("A{$row}")->getValue() == '') ? false : true;

        while ($loop) {
            if ($sheet->getCell("A{$row}")->getValue() != '' && !empty($sheet->getCell("I{$row}")->getValue()) && !empty($sheet->getCell("C{$row}")->getValue()) && !empty($sheet->getCell("C{$row}")->getValue()) && $sheet->getCell("C{$row}")->getValue() != 'P' ) {

                $arr = array(
                    'fecha' => trim($sheet->getCell("A{$row}")->getValue()),
                    'ppto' => trim($sheet->getCell("B{$row}")->getValue()),
                    'sap_cliente' => trim($sheet->getCell("C{$row}")->getValue()),
                    'cliente' => trim($sheet->getCell("D{$row}")->getValue()),
                    'valor' => trim($sheet->getCell("E{$row}")->getValue()),
                    'factura' => trim($sheet->getCell("F{$row}")->getValue()),
                    'sap_proveedor' => trim($sheet->getCell("G{$row}")->getValue()),
                    'proveedor' => trim($sheet->getCell("H{$row}")->getValue()),
                    'cebe' => trim($sheet->getCell("I{$row}")->getValue()),
                    'servicio' => trim($sheet->getCell("J{$row}")->getValue()),
                    'campana' => trim($sheet->getCell("K{$row}")->getValue()),
                    'producto' => trim($sheet->getCell("L{$row}")->getValue()),
                    'bruto' => trim($sheet->getCell("M{$row}")->getValue()),
                    'iva' => trim($sheet->getCell("N{$row}")->getValue()),
                    'spa' => trim($sheet->getCell("O{$row}")->getValue()),
                    'ivaspa' => trim($sheet->getCell("P{$row}")->getValue()),
                    'total' => trim($sheet->getCell("Q{$row}")->getValue()),
                    'retencion' => trim($sheet->getCell("R{$row}")->getValue()),
                    'valor_ret' => trim($sheet->getCell("S{$row}")->getValue()),
                    'inret' => trim($sheet->getCell("T{$row}")->getValue()),
                    'detalle' => trim($sheet->getCell("V{$row}")->getValue()),
                    'tipo' => (substr(trim($sheet->getCell("I{$row}")->getValue()), 0, 5) == 'SP01I') ? 'I' : 'E',
                    'modulo' => trim($sheet->getCell("W{$row}")->getValue())
                );

                $details[] = $arr;

                $row++;
                $loop = ($sheet->getCell("A$row")->getValue() == '') ? false : true;
            } else {
                $loop = false;
                if (empty($sheet->getCell("I{$row}")->getValue())) {
                    $error[] = 'Existen registros sin CEBE';
                } else if (empty($sheet->getCell("C{$row}")->getValue())) {
                    $error[] = 'Existen clientes sin codigo SAP';
                } else {
                    $error[] = 'Las columnas deben estar diligenciadas en su totalidad, no se aceptan vacias';
                }
            }
        }

        $createFiles = array('c_i','c_m');
        if (count($details) > 0 && count($error) <= 0):
            $insert = $this->M_Chargue->SaveImportDetail($details);
            if ($insert == 1) {
                $createFiles = $this->generateFieldSAP();
            }

        endif;

        $objXLS->disconnectWorksheets();
        unset($objXLS);
        unlink(dirname(__FILE__) . '/../../../Adjuntos/temp/' . $name);
        return array("0" => $error, "1" => $insert, "2" => count($details), "4"=>$createFiles['c_i'], "5"=>$createFiles['c_m']);
    }

    function generateFieldSAP() {
        $rowData = $this->M_Chargue->infoConsecutive();
        $rowI = $this->M_Chargue->ListBill('I');
        $rowM = $this->M_Chargue->ListBill('E');
        
        $consecutivoM = 0;
        $consecutivoI = 0;
        
        if ($rowM['num'] > 0) {
            
            $ruta = dirname(__FILE__) . '/../../../Cargue/M';
            $consecutivoM = str_pad($rowData->c_m, 10, "0", STR_PAD_LEFT);
            $nomArchivo = "DT" . $consecutivoM;

            $filename1 = $ruta . '/' . $nomArchivo;

            $fp = fopen($filename1, "w");

            foreach ($rowM['result'] as $v) {
                $cabecera = '1'.$v->fecha.'DT'.'9200'.$v->fecha.DATE('m').str_pad("COP",5,' ',STR_PAD_RIGHT).str_pad($v->factura,16,' ',STR_PAD_RIGHT).str_pad($v->producto,25,' ',STR_PAD_RIGHT);
                $det1 = '2'.str_pad('BBSEG',30,' ',STR_PAD_RIGHT).'01'.str_pad($v->sap_cliente,17,' ',STR_PAD_RIGHT).'/'.str_pad($v->valor_base,13,'0',STR_PAD_LEFT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",16,' ',STR_PAD_RIGHT).'/'.str_pad("/",10,' ',STR_PAD_RIGHT).str_pad($v->ppto,18,' ',STR_PAD_RIGHT).str_pad($v->campana,50,' ',STR_PAD_RIGHT).str_pad('/',10,' ',STR_PAD_RIGHT).str_pad("/",12,' ',STR_PAD_RIGHT).str_pad("/",12,' ',STR_PAD_RIGHT).str_pad($v->sap_cliente,20,' ',STR_PAD_RIGHT);
                $det2 = '2'.str_pad('BBSEG',30,' ',STR_PAD_RIGHT).'50'.str_pad('2815100198',17,' ',STR_PAD_RIGHT).'/'.str_pad($v->bruto,13,'0',STR_PAD_LEFT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",16,' ',STR_PAD_RIGHT).'/'.str_pad("/",10,' ',STR_PAD_RIGHT).str_pad($v->ppto,18,' ',STR_PAD_RIGHT).str_pad($v->proveedor,50,' ',STR_PAD_RIGHT).str_pad('/',10,' ',STR_PAD_RIGHT).str_pad($v->sap_proveedor,12,' ',STR_PAD_RIGHT).str_pad("COSTO",12,' ',STR_PAD_RIGHT).str_pad($v->sap_cliente,20,' ',STR_PAD_RIGHT);
                if($v->iva != '0'){
                    $det3 = '2'.str_pad('BBSEG',30,' ',STR_PAD_RIGHT).'50'.str_pad('2815100197',17,' ',STR_PAD_RIGHT).'/'.str_pad($v->iva,13,'0',STR_PAD_LEFT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",35,' ',STR_PAD_RIGHT).str_pad("/",16,' ',STR_PAD_RIGHT).'/'.str_pad("/",10,' ',STR_PAD_RIGHT).str_pad($v->ppto,18,' ',STR_PAD_RIGHT).str_pad($v->proveedor,50,' ',STR_PAD_RIGHT).str_pad('/',10,' ',STR_PAD_RIGHT).str_pad($v->sap_proveedor,12,' ',STR_PAD_RIGHT).str_pad("IVA",12,' ',STR_PAD_RIGHT).str_pad($v->sap_cliente,20,' ',STR_PAD_RIGHT);
                }
                fwrite($fp,$cabecera."\r". PHP_EOL);
                fwrite($fp,$det1."\r". PHP_EOL);
                fwrite($fp,$det2."\r". PHP_EOL);
                if($v->iva != '0'){
                    fwrite($fp,$det3."\r". PHP_EOL);
                }
                $info = $this->getDataModule($v->modulo);
                $this->M_Chargue->UpdateData($info['table'], $info['fieldId'], $v->ppto, array('cargado'=>1));
            }
            $this->M_Chargue->UpdateData('sys_data_billing', 'nit', '890101778', array('cons_cargue_mandato'=>$rowData->c_m+1));
        }

        if ($rowI['num'] > 0) {
            $ruta = dirname(__FILE__) . '/../../../Cargue/I';
            
            $consecutivoI = str_pad($rowData->c_i, 10, "0", STR_PAD_LEFT);
            $nomArchivo = "PB" . $consecutivoI;

            $filename1 = $ruta . '/' . $nomArchivo;

            $fp = fopen($filename1, "w");

            foreach ($rowI['result'] as $v) {
                $tpodoc = ($v->bruto == 0) ? 'DB' : 'DP';

                $cabecera = '1' . $v->fecha . $tpodoc . '9200' . $v->fecha . DATE('m') . str_pad("COP", 5, ' ', STR_PAD_RIGHT) . str_pad($v->factura, 16, ' ', STR_PAD_RIGHT) . str_pad($v->campana, 25, ' ', STR_PAD_RIGHT);
                $det1 = '2' . str_pad('BBSEG', 30, ' ', STR_PAD_RIGHT) . '01' . str_pad($v->sap_cliente, 17, ' ', STR_PAD_RIGHT) . '/' . str_pad($v->total, 13, '0', STR_PAD_LEFT) . str_pad("/", 13, ' ', STR_PAD_RIGHT) . str_pad("/", 2, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 3, ' ', STR_PAD_RIGHT) . '/' . '/' . str_pad($v->ppto, 18, ' ', STR_PAD_RIGHT) . str_pad($v->producto, 50, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("0", 12, ' ', STR_PAD_RIGHT) . str_pad($v->sap_cliente, 20, ' ', STR_PAD_RIGHT) . str_pad("/", 13, ' ', STR_PAD_RIGHT);
                $det2 = '2' . str_pad('BWITH', 30, ' ', STR_PAD_RIGHT) . 'S1' . str_pad($v->inret, 2, '0', STR_PAD_LEFT) . str_pad($v->spa, 13, '0', STR_PAD_LEFT) . str_pad($v->valor_ret, 13, '0', STR_PAD_LEFT); //LINEA DE LA RETENCION.
                $det4 = '2' . str_pad('BBTAX', 30, ' ', STR_PAD_RIGHT) . str_pad($v->ivaspa, 13, '0', STR_PAD_LEFT) . 'BE' . '50';
                $det5 = '2' . str_pad('BBSEG', 30, ' ', STR_PAD_RIGHT) . '50' . str_pad("4155550100", 17, ' ', STR_PAD_RIGHT) . '/' . str_pad($v->spa, 13, '0', STR_PAD_LEFT) . str_pad("/", 13, ' ', STR_PAD_RIGHT) . str_pad("BE", 2, ' ', STR_PAD_RIGHT) . str_pad($v->cebe, 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 3, ' ', STR_PAD_RIGHT) . '/' . '/' . str_pad($v->ppto, 18, ' ', STR_PAD_RIGHT) . str_pad($v->producto, 50, ' ', STR_PAD_RIGHT) . str_pad("/", 10, ' ', STR_PAD_RIGHT) . str_pad("/", 12, ' ', STR_PAD_RIGHT) . str_pad($v->sap_cliente, 20, ' ', STR_PAD_RIGHT) . str_pad("/", 13, ' ', STR_PAD_RIGHT);
                fwrite($fp, "$cabecera\r" . PHP_EOL);
                fwrite($fp, "$det1\r" . PHP_EOL);
                fwrite($fp, "$det2\r" . PHP_EOL);

                fwrite($fp, "$det4\r" . PHP_EOL);
                fwrite($fp, "$det5\r" . PHP_EOL);

            }
            $this->M_Chargue->UpdateData('sys_data_billing', 'nit', '890101778', array('cons_cargue_interna'=>$rowData->c_i+1));
        }
        
        return array('c_i'=> $consecutivoI, 'c_m' => $consecutivoM);
    }
    
    function getDataModule($tipo){
         switch ($tipo) {
            case 1:
                $data = array('table'=> 'presup_avisos','fieldId'=> 'psav_id');
                break;
            case 2:
                $data = array('table'=> 'presup_clasificados','fieldId'=> 'pscf_id');
                break;
            case 3:
                $data = array('table'=> 'presup_revis','fieldId'=> 'psrev_id');
                break;
            case 4:
                $data = array('table'=> 'presup_radio','fieldId'=> 'psrad_id');
                break;
            case 5:
                $data = array('table'=> 'presup_tv','fieldId'=> 'pstv_id');
                break;
            case 6:
                $data = array('table'=> 'presup_prode','fieldId'=> 'psex_id');
                break;
            case 7:
                $data = array('table'=> 'presup_prodi','fieldId'=> 'psin_id');
                break;
            case 8:
                $data = array('table'=> 'publicidad_exterior','fieldId'=> 'pubext_id');
                break;
            case 9:
                $data = array('table'=> 'impresos','fieldId'=> 'imp_id');
                break;
            case 10:
                $data = array('table'=> 'art_publi','fieldId'=> 'artp_id');
                break;

            default:
                break;
        }
        return $data;
    }

    function Cargue($archivo = 0) {

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
            if (file_exists(dirname(__FILE__) . "/../../includes/phpexcel/temp/Cargue.xls")) {
                unlink(dirname(__FILE__) . "/../../includes/phpexcel/temp/Cargue.xls");
            }
        }

        $archivo = dirname(__FILE__) . "/../../includes/phpexcel/temp/Cargue.xls";

        copy(dirname(__FILE__) . "/../../includes/phpexcel/plantillas/Cargue.xlsx", $archivo);

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo(PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $styleArray = array('font' => array('bold' => true, 'color' => array('rgb' => 'ffffff'), 'size' => 8, 'name' => 'Arial',),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,),), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90, 'startcolor' => array('rgb' => '303483',), 'endcolor' => array('rgb' => '303483',),),
        );
        $styleArray2 = array('font' => array('bold' => true, 'color' => array('rgb' => 'ffffff'), 'size' => 8, 'name' => 'Arial',),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,),), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90, 'startcolor' => array('rgb' => '7382d9',), 'endcolor' => array('rgb' => '7382d9',),),
        );


        $A = $objPHPExcel->getActiveSheet(0);

        $y = 6;
        $fact = array();
        foreach ($this->M_Chargue->ListarCategoriasRadicador() as $c) {
            $result = $this->M_Chargue->ListaPresupuestos($c->id_categoria, false, $this->input->post('fecha_ini'), $this->input->post('fecha_fin'), 'all');
            foreach ($result as $v) {

                if ($v->num_fact2 > 0) {
                    if (!array_key_exists($v->num_fact2, $fact)) {
                        $infoFact = $this->M_Chargue->infoBill($v->num_fact2);
                        $fact[$v->num_fact2]['ret'] = $infoFact->factura_retefuente;
                        $fact[$v->num_fact2]['ret_id'] = $infoFact->rete_id;
                    }
                    $ret = $fact[$v->num_fact2]['ret'];
                    $inRet = $this->M_Chargue->infoRet($fact[$v->num_fact2]['ret_id'])->rete_ret;
                } else {
                    $ret = 0;
                    $inRet = 0;
                }
                switch ($v->est_id) {
                    case 9999:
                    case 38:
                        $bruto_orden = 0;
                        $iva = 0;
                        $spa = 0;
                        $iva_spa = 0;
                        $valor_rete = 0;
                        break;

                    default:
                        $bruto_orden = $v->valor_menos_desc;
                        $iva = $v->valor_iva;
                        $spa = $v->valor_spa;
                        $iva_spa = $v->valor_iva_spa;
                        $valor_rete = ($spa * $ret) / 100;
                        break;
                }

                $v->num_fact = ($v->num_fact != 0) ? $v->num_fact : $v->num_fact2;


                $newDate = date("d.m.Y", strtotime($v->fecha_presup));

                $A->setCellValue("A$y", $newDate);
                $A->setCellValue("B$y", $v->num_presup);
                $A->setCellValue("C$y", $v->cod_sap_clie);
                $A->setCellValue("D$y", $v->nmb_clie);
                $A->setCellValue("E$y", round($v->total))->getStyle("E$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("F$y", $v->num_fact);
                $A->setCellValue("G$y", $v->cod_sap_prov);
                $A->setCellValue("H$y", $v->nmb_prov);
                $A->setCellValue("I$y", $v->cebe_tposerv);
                $A->setCellValue("J$y", $v->dependencia);
                $A->setCellValue("K$y", $v->nmb_camp);
                $A->setCellValue("L$y", $v->nmb_prod);
                $A->setCellValue("M$y", round($bruto_orden))->getStyle("M$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("N$y", round($iva))->getStyle("N$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("O$y", round($spa))->getStyle("O$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("P$y", round($iva_spa))->getStyle("P$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("Q$y", round($spa + $iva_spa))->getStyle("Q$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
//                $A->setCellValue("M$y", $bruto_orden)->getStyle("M$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
//                $A->setCellValue("N$y", $iva)->getStyle("N$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
//                $A->setCellValue("O$y", $spa)->getStyle("O$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
//                $A->setCellValue("P$y", $iva_spa)->getStyle("P$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
//                $A->setCellValue("Q$y", $spa + $iva_spa)->getStyle("Q$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("R$y", (empty($spa))?0:$ret);
                $A->setCellValue("S$y", round($valor_rete))->getStyle("S$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0_);_(\"$\"* \(#,##0\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("T$y", (empty($spa))?0:$inRet);
                $A->setCellValue("U$y", $v->estado);
                $A->setCellValue("V$y", utf8_decode($v->detalle));
                $A->setCellValue("W$y", $c->id_categoria);
                $y++;
            }
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'Cargue');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }

    function Send() {

        $_POST['fecha_ini'] = '2020-03-01';
        $_POST['fecha_fin'] = '2020-03-31';
        $_POST['id_proveedor'] = 'all';
        $_POST['id_cliente'] = 'all';
        $_POST['id_categoria'] = 'all';


        echo '<table border style="font-size:10px">'
        . '<thead>'
        . '<td>#</td>'
        . '<td>ESTADO</td>'
        . '<td>FECHA PPSTO</td>'
        . '<td>NO. PPSTO</td>'
        . '<td>COD SAP CLI</td>'
        . '<td>CLIENTE</td>'
        . '<td>VALOR BRUTO</td>'
        . '<td>NO. FACTURA</td>'
        . '<td>COD SAP PRV</td>'
        . '<td>PROVEEDOR</td>'
        . '<td>CEBE</td>'
        . '<td>TIPO DE SERVICIO</td>'
        . '<td>CAMPAÑA</td>'
        . '<td>PRODUCTO</td>'
        . '<td>BRUTO ORDEN</td>'
        . '<td>IVA</td>'
        . '<td>SPA</td>'
        . '<td>IVA SPA</td>'
        . '<td>TOTALFAC</td>'
        . '<td>RET</td>'
        . '<td>VALOR_RTE</td>'
        . '<td>INRET</td>'
        . '<td>DETALLE</td></thead><tbody>';

        $fact = array();
        $count = 1;
        foreach ($this->M_Chargue->ListarCategoriasRadicador() as $v) {
            $result = $this->M_Chargue->ListaPresupuestos($v->id_categoria, false, $this->input->post('fecha_ini'), $this->input->post('fecha_fin'), $this->input->post('id_cliente'));
            foreach ($result as $v) {
                if ($v->num_fact2 > 0) {
                    if (!array_key_exists($v->num_fact2, $fact)) {
                        $fact[$v->num_fact2] = $this->M_Chargue->infoBill($v->num_fact2)->factura_retefuente;
                    }
                    $ret = $fact[$v->num_fact2];
                } else {
                    $ret = 0;
                }
                switch ($v->est_id) {
                    case 9999:
                    case 38:
                        $bruto_orden = 0;
                        $iva = 0;
                        $spa = 0;
                        $iva_spa = 0;
                        $valor_rete = 0;
                        break;

                    default:
                        $bruto_orden = $v->valor_menos_desc;
                        $iva = $v->valor_iva;
                        $spa = $v->valor_spa;
                        $iva_spa = $v->valor_iva_spa;
                        $valor_rete = ($spa * $ret) / 100;
                        break;
                }

                $v->num_fact = ($v->num_fact != 0) ? $v->num_fact : $v->num_fact2;

                echo '<tr>';
                echo '<td>' . $count++ . '</td>';
                echo '<td>' . $v->estado . '</td>';
                echo '<td>' . $v->fecha_presup . '</td>';
                echo '<td>' . $v->num_presup . '</td>';
                echo '<td>' . $v->cod_sap_clie . '</td>';
                echo '<td>' . $v->nmb_clie . '</td>';
                echo '<td>' . $v->total . '</td>';
                echo '<td>' . $v->num_fact2 . '</td>';
                echo '<td>' . $v->cod_sap_prov . '</td>';
                echo '<td>' . $v->nmb_prov . '</td>';
                echo '<td>' . $v->cebe_tposerv . '</td>';
                echo '<td>' . $v->dependencia . '</td>';
                echo '<td>' . $v->nmb_camp . '</td>';
                echo '<td>' . $v->nmb_prod . '</td>';
                echo '<td>' . $bruto_orden . '</td>';
                echo '<td>' . $iva . '</td>';
                echo '<td>' . $spa . '</td>';
                echo '<td>' . $iva_spa . '</td>';
                echo '<td></td>';
                echo '<td>' . $ret . '</td>';
                echo '<td>' . $valor_rete . '</td>';
                echo '<td></td>';
                echo '<td>' . $v->detalle . '</td>';

                echo '</tr>';
            }
        }
        echo '</tbody></table>';
    }

}
