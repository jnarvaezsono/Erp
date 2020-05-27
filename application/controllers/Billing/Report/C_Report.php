<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Billing/Report/M_Report');
    }

    function Report($function) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, RANGOPICKER_CSS, ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);

        $data['clientes'] = $this->M_Report->ListarClientes();
        $data['proveedores'] = $this->M_Report->ListarProveedor();
        $data['categorias'] = $this->M_Report->ListarCategoriasRadicador();
        $data['function'] = $function;

        $this->load->view('Billing/Report/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, MOMENT, RANGOPICKER_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function InHouse($archivo = 0) {
        require_once(dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel.php');
        require_once dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/IOFactory.php';
        include dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';

        if ($archivo) {
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$archivo");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: private", false);


            $archivo = dirname(__FILE__) . "/../../../includes/phpexcel/temp/" . $archivo;
            $archivo = file_get_contents($archivo);
            echo $archivo;
            exit;
        }

        $archivo = dirname(__FILE__) . "/../../../includes/phpexcel/temp/InternaDetallado.xls";

        copy(dirname(__FILE__) . "/../../../includes/phpexcel/plantillas/Interna.xlsx", $archivo);

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo(PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $styleArray2 = array('font' => array('bold' => true, 'color' => array('rgb' => 'ffffff'), 'size' => 8, 'name' => 'Arial',),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,),), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'rotation' => 90, 'startcolor' => array('rgb' => '7382d9',), 'endcolor' => array('rgb' => '7382d9',),),
        );


        $A = $objPHPExcel->getActiveSheet(0);

        $A->setCellValue('A1', " INTERNA DETALLADO DESDE " . $this->input->post('fecha_ini') . "   HASTA " . $this->input->post('fecha_fin'));
        
        $result = $this->M_Report->ListDetailInterna();
        $y = 6;
        foreach ($result as $v) :
            
            switch ($v->id_estado) {
                case 9999:
                case 38:
                    $v->valor_bruto_ppto = 0;
                    $v->total_descuento = 0;
                    $v->subtotal_ppto = 0;
                    $v->iva_ppto = 0;
                    $v->total_ppto = 0;
                    break;

                default:
                    break;
            }
            
            $A->setCellValue("A$y", $v->presupuesto);
            $A->setCellValue("B$y", $v->factura_id);
            $A->setCellValue("C$y", $v->estado);
            $A->setCellValue("D$y", $v->fecha);
            $A->setCellValue("E$y", $v->cliente);
            $A->setCellValue("F$y", $v->campana);
            $A->setCellValue("G$y", $v->producto);
            $A->setCellValue("H$y", $v->descuento);
            $A->setCellValue("I$y", $v->iva);
            $A->setCellValue("J$y", $v->valor_bruto_ppto)->getStyle("J$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("K$y", $v->total_descuento)->getStyle("K$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("L$y", $v->subtotal_ppto)->getStyle("L$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("M$y", $v->iva_ppto)->getStyle("M$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("N$y", $v->total_ppto)->getStyle("N$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("O$y", $v->orden);
            $A->setCellValue("P$y", $v->detalle);
            $A->setCellValue("Q$y", $v->servicio);
            $A->setCellValue("R$y", $v->unidad);
            $A->setCellValue("S$y", $v->cantidad);
            $A->setCellValue("T$y", $v->total_detalle)->getStyle("S$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");;
            $A->setCellValue("U$y", $v->orden_costo);
            
          
            $y++;
        endforeach;
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'InternaDetallado.xls');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }
    
    function Radicador($archivo = 0) {
        
        require_once(dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel.php');
        require_once dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/IOFactory.php';
        include dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';

        if ($archivo) {
            $archivo .= '.xls';
            
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$archivo");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: private", false);


            $ruta = dirname(__FILE__) . "/../../../includes/phpexcel/temp/" . $archivo;
            $archivo = file_get_contents($ruta);
            echo $archivo;
            
            exit;
        }else{
            if(file_exists(dirname(__FILE__) . "/../../../includes/phpexcel/temp/Radicador.xls")){
                unlink(dirname(__FILE__) . "/../../../includes/phpexcel/temp/Radicador.xls");
            }
        }

        $archivo = dirname(__FILE__) . "/../../../includes/phpexcel/temp/Radicador.xls";

        copy(dirname(__FILE__) . "/../../../includes/phpexcel/plantillas/Radicado.xlsx", $archivo);

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

        //$A->setCellValue('A1', " RADICADOR DESDE " . $this->input->post('fecha_ini') . "   HASTA " . $this->input->post('fecha_fin'));
        $y = 2;

        if ($this->input->post('id_categoria') == 'all') {
            foreach ($this->M_Report->ListarCategoriasRadicador() as $v) {
                $result = $this->M_Report->ListaPresupuestos($v->id_categoria);
                foreach ($result as $v) {
                    
                    switch ($v->est_id) {
                        case 9999:
                        case 38:
                            $v->total = 0;
                            $v->valor_menos_desc = 0;
                            $v->valor_iva = 0;
                            $v->valor_mas_iva = 0;
                            $v->valor_spa = 0;
                            $v->valor_iva_spa = 0;
                            $total_facturación = 0;
                            break;

                        default:
                            $total_facturación = $v->valor_menos_desc + $v->valor_spa;
                            break;
                    }

                    $mes = $this->Monts($v->fecha_presup);
                    $tipo = $this->TypeClient($v->id_clie, $v->detalle);

                    $v->num_fact = ($v->num_fact != 0) ? $v->num_fact : $v->num_fact2;

                    $A->setCellValue("A$y", $mes);
                    $A->setCellValue("B$y", $tipo);
                    $A->setCellValue("C$y", $v->fecha_presup);
                    $A->setCellValue("D$y", $v->num_presup);
                    $A->setCellValue("E$y", $v->num_fact);
                    $A->setCellValue("F$y", $v->cod_sap_clie);
                    $A->setCellValue("G$y", $v->nmb_clie);
                    $A->setCellValue("H$y", $v->total)->getStyle("H$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("I$y", utf8_decode($v->detalle));
                    $A->setCellValue("J$y", $v->cod_sap_prov);
                    $A->setCellValue("K$y", $v->nmb_prov);
                    $A->setCellValue("L$y", $v->cebe_tposerv);
                    $A->setCellValue("M$y", utf8_decode($v->dependencia));
                    $A->setCellValue("N$y", utf8_decode($v->nmb_tposerv));
                    $A->setCellValue("O$y", utf8_decode($v->nmb_camp));
                    $A->setCellValue("P$y", utf8_decode($v->nmb_prod));
                    $A->setCellValue("Q$y", utf8_decode($v->nmb_medio));
                    $A->setCellValue("R$y", $v->no_orden_prov);
                    $A->setCellValue("S$y", $v->valor_menos_desc)->getStyle("S$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("T$y", $v->valor_iva)->getStyle("T$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("U$y", $v->valor_mas_iva)->getStyle("U$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("V$y", $v->valor_spa)->getStyle("V$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("W$y", $v->valor_iva_spa)->getStyle("W$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("X$y", $total_facturación)->getStyle("X$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                    $A->setCellValue("Y$y", $v->estado);
                    $A->setCellValue("Z$y", $v->numorden);
                    $A->setCellValue("AA$y", $v->numcotizacion);
                    $A->setCellValue("AB$y", $v->tpo_prod);
                    $A->setCellValue("AC$y", $v->unidad);
                    $y++;
                }
            }
        } else {
            $result = $this->M_Report->ListaPresupuestos($this->input->post('id_categoria'));
            foreach ($result as $v) {
                
                switch ($v->est_id) {
                    case 9999:
                    case 38:
                        $v->total = 0;
                        $v->valor_menos_desc = 0;
                        $v->valor_iva = 0;
                        $v->valor_mas_iva = 0;
                        $v->valor_spa = 0;
                        $v->valor_iva_spa = 0;
                        $total_facturación = 0;
                        break;

                    default:
                        $total_facturación = $v->valor_menos_desc + $v->valor_spa;
                        break;
                }
                
                $mes = $this->Monts($v->fecha_presup);
                $tipo = $this->TypeClient($v->id_clie, $v->detalle);

                $v->num_fact = ($v->num_fact != 0) ? $v->num_fact : $v->num_fact2;

                $A->setCellValue("A$y", $mes)->getStyle("A$y")->applyFromArray($styleArray);
                $A->setCellValue("B$y", $tipo)->getStyle("B$y")->applyFromArray($styleArray);
                $A->setCellValue("C$y", $v->fecha_presup);
                $A->setCellValue("D$y", $v->num_presup);
                $A->setCellValue("E$y", $v->num_fact);
                $A->setCellValue("F$y", $v->cod_sap_clie);
                $A->setCellValue("G$y", $v->nmb_clie);
                $A->setCellValue("H$y", $v->total)->getStyle("H$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("I$y", utf8_decode($v->detalle));
                $A->setCellValue("J$y", $v->cod_sap_prov);
                $A->setCellValue("K$y", $v->nmb_prov);
                $A->setCellValue("L$y", $v->cebe_tposerv);
                $A->setCellValue("M$y", utf8_decode($v->dependencia));
                $A->setCellValue("N$y", utf8_decode($v->nmb_tposerv));
                $A->setCellValue("O$y", utf8_decode($v->nmb_camp));
                $A->setCellValue("P$y", utf8_decode($v->nmb_prod));
                $A->setCellValue("Q$y", utf8_decode($v->nmb_medio));
                $A->setCellValue("R$y", $v->no_orden_prov);
                $A->setCellValue("S$y", $v->valor_menos_desc)->getStyle("S$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("T$y", $v->valor_iva)->getStyle("T$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("U$y", $v->valor_mas_iva)->getStyle("U$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("V$y", $v->valor_spa)->getStyle("V$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("W$y", $v->valor_iva_spa)->getStyle("W$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("X$y", $total_facturación)->getStyle("X$y")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("Y$y", $v->estado);
                $A->setCellValue("Z$y", $v->numorden);
                $A->setCellValue("AA$y", $v->numcotizacion);
                $A->setCellValue("AB$y", $v->tpo_prod);
                $A->setCellValue("AC$y", $v->unidad);
                $y++;

            }
        }

        $result_notes = $this->M_Report->ListaNota();

        foreach ($result_notes as $value) {
            
            $result = $this->M_Report->ListaPresupuestos($this->category($value->tipo),$value->ppto);
            
            foreach ($result as $v) {
                $mes = $this->Monts($value->fecha);
                $tipo = $this->TypeClient($v->id_clie, $v->detalle);
                

                $v->num_fact = ($v->num_fact != 0) ? $v->num_fact : $v->num_fact2;
                $A->setCellValue("A$y", $mes)->getStyle("A$y")->applyFromArray($styleArray2);
                $A->setCellValue("B$y", $tipo)->getStyle("B$y")->applyFromArray($styleArray2);
                $A->setCellValue("C$y", $value->fecha)->getStyle("C$y")->applyFromArray($styleArray2);
                $A->setCellValue("D$y", $v->num_presup)->getStyle("D$y")->applyFromArray($styleArray2);
                $A->setCellValue("E$y", $v->num_fact)->getStyle("E$y")->applyFromArray($styleArray2);
                $A->setCellValue("F$y", $v->cod_sap_clie)->getStyle("F$y")->applyFromArray($styleArray2);
                $A->setCellValue("G$y", $v->nmb_clie)->getStyle("G$y")->applyFromArray($styleArray2);

                $bruto_orden = $value->valor_bruto - $value->descuento;
//                $A->setCellValue("H$y", '-'.$value->total)->getStyle("H$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("H$y", '-'.($bruto_orden + $value->iva + $value->spa +$value->iva_spa))->getStyle("H$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("I$y", utf8_decode($v->detalle))->getStyle("I$y")->applyFromArray($styleArray2);
                $A->setCellValue("J$y", $v->cod_sap_prov)->getStyle("J$y")->applyFromArray($styleArray2);
                $A->setCellValue("K$y", $v->nmb_prov)->getStyle("K$y")->applyFromArray($styleArray2);
                $A->setCellValue("L$y", $v->cebe_tposerv)->getStyle("L$y")->applyFromArray($styleArray2);
                $A->setCellValue("M$y", $v->dependencia)->getStyle("M$y")->applyFromArray($styleArray2);
                $A->setCellValue("N$y", utf8_decode($v->nmb_tposerv))->getStyle("N$y")->applyFromArray($styleArray2);
                $A->setCellValue("O$y", utf8_decode($v->nmb_camp))->getStyle("O$y")->applyFromArray($styleArray2);
                $A->setCellValue("P$y", utf8_decode($v->nmb_prod))->getStyle("P$y")->applyFromArray($styleArray2);
                $A->setCellValue("Q$y", utf8_decode($v->nmb_medio))->getStyle("Q$y")->applyFromArray($styleArray2);
                $A->setCellValue("R$y", $v->no_orden_prov)->getStyle("R$y")->applyFromArray($styleArray2);
                $A->setCellValue("S$y", '-'.$bruto_orden )->getStyle("S$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("T$y", '-'.$value->iva )->getStyle("T$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("U$y", '-'.($bruto_orden + $value->iva))->getStyle("U$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("V$y", '-'.$value->spa )->getStyle("V$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("W$y", '-'.$value->iva_spa )->getStyle("W$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("X$y", '-'.($bruto_orden + $value->spa))->getStyle("X$y")->applyFromArray($styleArray2)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
                $A->setCellValue("Y$y", $v->estado)->getStyle("Y$y")->applyFromArray($styleArray2);
                $A->setCellValue("Z$y", $v->numorden)->getStyle("Z$y")->applyFromArray($styleArray2);
                $A->setCellValue("AA$y", $v->numcotizacion)->getStyle("AA$y")->applyFromArray($styleArray2);
                $A->setCellValue("AB$y", $v->tpo_prod)->getStyle("AB$y")->applyFromArray($styleArray2);
                $A->setCellValue("AC$y", $v->unidad)->getStyle("AC$y")->applyFromArray($styleArray2);
                $A->setCellValue("AD$y", $value->id_nota_credito)->getStyle("AD$y")->applyFromArray($styleArray2);
                $y++;
            }
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'Radicador');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }
    
    function General($archivo = 0) {

        require_once(dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel.php');
        require_once dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/IOFactory.php';
        include dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel/Writer/Excel2007.php';

        if ($archivo) {
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$archivo");
            header("Expires: 0");
            header('Content-Transfer-Encoding: binary');
            header("Cache-Control: private", false);


            $archivo = dirname(__FILE__) . "/../../../includes/phpexcel/temp/" . $archivo;
            $archivo = file_get_contents($archivo);
            echo $archivo;
            exit;
        }

        $archivo = dirname(__FILE__) . "/../../../includes/phpexcel/temp/General.xls";

        copy(dirname(__FILE__) . "/../../../includes/phpexcel/plantillas/General.xlsx", $archivo);
        
        try {
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo(PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $A = $objPHPExcel->getActiveSheet(0);

        $A->setCellValue('A1', " GENERAL DESDE " . $this->input->post('fecha_ini') . "   HASTA " . $this->input->post('fecha_fin'));
        $y = 6;

      

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($archivo, __FILE__);
        $returnArray = Array('result' => "ok", 'archivo' => 'General.xls');
        $myjson = json_encode($returnArray);
        echo $myjson;
    }
    
    function category($desc){
        $i = '';
        switch ($desc) {
            case "aviso":
                $i = 1;
                break;
            case "clasificados":
                $i = 2;
                break;
            case "revistas":
                $i = 3;
                break;
            case "radio":
                $i = 4;
                break;
            case "television":
                $i = 5;
                break;
            case "externa":
                $i = 6;
                break;
            case "interna":
                $i = 7;
                break;
            case "publicidad exterior":
                $i = 8;
                break;
            case "impresos":
                $i = 9;
                break;
            case "articulos publicitarios":
                $i = 10;
                break;
            default:
                break;
        }
        return $i;
    }

    function TypeClient($id_clie, $nmb_clie) {

        if ($id_clie == 1339) {
            $tipo = 'OLIMPICA';
        } else {
            if (strpos($nmb_clie, 'incentivo') === false && strpos($nmb_clie, 'Incentivo') === false && strpos($nmb_clie, 'INCENTIVO') === false) {
                $tipo = 'CLIENTE';
            } else {
                $tipo = 'INCENTIVO';
            }
        }
        return $tipo;
    }

    function Monts($fecha_presup) {
        $f = explode('-', $fecha_presup);
        $array = array(
            '00' => '',
            '01' => 'ENERO',
            '02' => 'FEBRERO',
            '03' => 'MARZO',
            '04' => 'ABRIL',
            '05' => 'MAYO',
            '06' => 'JUNIO',
            '07' => 'JULIO',
            '08' => 'AGOSTO',
            '09' => 'SEPTIEMBRE',
            '10' => 'OCTUBRE',
            '11' => 'NOVIEMBRE',
            '12' => 'DICIEMBRE',
        );

        return $array[$f[1]];
    }

}
