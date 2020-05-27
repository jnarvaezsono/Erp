<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Credit_Notes extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Billing/M_Credit_Notes');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS,RANGOPICKER_CSS,ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);
        
//        $all = $this->M_Credit_Notes->SelectNote(0, false, false, false);
//        $datos['rows'] = $this->M_Credit_Notes->ListNote($this->input->get('start'), $this->input->get("length"),'desc', 0, 'all','all','all');
        $tabla = $this->load->view('Billing/Note/V_Table_Note', false, true);
        

        $this->load->view('Billing/Note/V_Panel', array('table' => $tabla));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS,MOMENT,RANGOPICKER_JS,ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ListNote($factura, $ppto, $f_ini, $f_fin) {
        $order_by = $this->input->get("order");
        $rows = $this->M_Credit_Notes->ListNote($this->input->get('start'), $this->input->get("length"),$order_by[0]['dir'], $factura, $ppto,$f_ini, $f_fin);
        $all = $this->M_Credit_Notes->SelectNote($factura, $ppto, $f_ini, $f_fin);
        $array = array();
        foreach ($rows['result'] as $v) {
            
                $btn = '<div class="btn-group btnI'.$v->id_nota_credito.'" >
                        <button style="width:100px;"  type="button" class="btn1-'.$v->id_nota_credito.' btn btn-'.$v->est_color.' btn-xs btn-left">'.$v->est_nombre.'</button>
                            <button type="button" class="btn2-'.$v->id_nota_credito.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu u-'.$v->id_nota_credito.'" role="menu">';
            
                $btn    .= '<li onclick="OpenPdf('.$v->id_nota_credito.','.$v->factura.')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
                $btn    .= ($v->est_id == 1 || $v->est_id == 44)?'<li onclick="PrintXml(' . $v->id_nota_credito . ',' . $v->factura . ')"><a href="#"></i><i class="fa fa-fw fa-send"></i> Enviar CEN</a></li>':'';
                $btn    .= '<li onclick="OpenXml(' . $v->id_nota_credito . ',' . $v->factura . ')"><a href="#"></i><i class="fa fa-fw fa-download"></i> Descargar XML</a></li>';
                $btn    .= '</ul></div>';
            
            
                $array[] = array(
                    $btn,
                    $v->id_nota_credito,$v->factura, $v->ppto,$v->tipo,$v->fecha, '$' . number_format($v->valor_bruto,0),'$' . number_format($v->total,0),
                    '<div style="font-size: 14px; padding: 4px;" class="label-' . $v->est_color . ' label-' . $v->id_nota_credito . '">' . $v->est_nombre . '</div>');
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function  PrintNote($id_nota,$factura){
         $this->load->library('MonedaLetras');
        
        $data['nota'] = $id_nota;
        
        $data['cab'] = $this->M_Credit_Notes->InfoNote($id_nota);
        
        $data['info'] = $this->M_Credit_Notes->InfoFactura($factura);

        $row = $this->M_Credit_Notes->InfoNoteDetail($id_nota);
        
        $table = '<tr class="heading">
                    <td>Ppto</td>
                    <td>Servicio</td>
                    <td>Proveedor</td>
                    <td>Producto</td>
                    <td>Vlr Bruto</td>
                    <td>Descuento</td>
                    <td>Iva</td>
                    <td>Spa</td>
                    <td>IvaSpa</td>
                    <td>Total</td>
                </tr>';
        $total = 0;
        $spa = 0;
        foreach ($row as $v) {
            
            $factura_presup = $this->M_Credit_Notes->InfoPptoFact($v->ppto,$factura);
            
            
            
            $table .='<tr class="item">
                    <td>'.$v->ppto.'</td>
                    <td>'.$factura_presup->tipo_servicio.'</td>
                    <td>'.$factura_presup->proveedor.'</td>
                    <td>'.$factura_presup->producto.'</td>
                    <td>'.number_format($v->valor_bruto, 2,',','.').'</td>
                    <td>'.number_format($v->descuento, 2,',','.').'</td>
                    <td>'.number_format($v->iva, 2,',','.').'</td>
                    <td>'.number_format($v->spa, 2,',','.').'</td>
                    <td>'.number_format($v->iva_spa, 2,',','.').'</td>
                    <td>'.number_format($v->total, 2,',','.').'</td>
                </tr>';
            $total += $v->total;
            $spa += $v->spa;
        }
        
        $table .= '<tr class="total">
                    <td colspan="9" style="text-align:right">Total:</td>
                    <td  style="text-align:center">
                         $ '.number_format($total, 2,',','.').'
                    </td>
                </tr>';
        $letras = $this->monedaletras->ValorEnLetras($total, 'pesos' );
        $data['spa'] = $spa;
        $data['tabla'] = $table;
        $data['letras'] = $letras;

        
        
        $this->load->view('Billing/Note/V_Pdf_Bill', $data);
    }
    
    function GenerateXml($note, $bill, $n ,$send = false) {

         $this->load->helper('xml_helper');
        $this->load->library('MonedaLetras');

        $dom = xml_dom();

        $data = $this->M_Credit_Notes->InfoDataBilling();
        $info = $this->M_Credit_Notes->InfoCab($note);
        $detail = $this->M_Credit_Notes->ListaDetailBill($note, $bill);
        $row_cliente = $this->M_Credit_Notes->ListarClientesNew($info->pvcl_id);
        $resolucion = $this->M_Credit_Notes->getResolution($info->resol_id);
        $totals = $this->M_Credit_Notes->GetTotalNc($note);
        
        $rows = $this->M_Credit_Notes->InfoNoteDetail($note);
        
        $iva_cal = 0;
        $iva_spa_cal = 0;
        $base_iva = 0;
        $base_iva_spa = 0;
        foreach ($rows as $p) {
            $iva_cal += $p->iva;
            $iva_spa_cal += $p->iva_spa;
            
            $base_iva += ($p->iva > 0)?($p->valor_bruto - $p->descuento) : 0;
            $base_iva_spa += ($p->iva_spa > 0)?($p->spa - $p->descuento) : 0;
        }
        
        
        $totals->iva =  $iva_cal;
        $totals->iva_spa = $iva_spa_cal;
        
        
        $RowBill = xml_add_child($dom, 'NOTA');

        $enc = xml_add_child($RowBill, 'ENC');
        
        if($n == 'NC'){
            $tipo_doc = '91';
            $tipo_operacion = ($info->old == 1)?23:$data->tipo_operacion_nota;
        }else{
            $tipo_doc = '92';
            $tipo_operacion = ($info->old == 1)?33:$data->tipo_operacion_nd;
        }

        $array_enc = array('1' => $n
            , '2' => $data->nit
            , '3' => $row_cliente->documento
            , '4' => $data->version_ubl
            , '5' => $data->version_dian
            , '6' => $note
            , '7' => $info->fecha
            , '8' => '23:00:30-05:00'
            , '9' => $tipo_doc
            , '10' => $data->divisa
            , '15' => $detail['num'] + $this->M_Credit_Notes->OtherLines($note)->count
            , '20' => $data->ambiente
            , '21' => $tipo_operacion
        );

        foreach ($array_enc as $key => $value) {
            xml_add_child($enc, 'ENC_' . $key, $value);
        }

        $fecha_pago = strtotime('+30 day', strtotime($info->factura_impresion));
        $fecha_pago = date('Y-m-d', $fecha_pago);

        $emi = xml_add_child($RowBill, 'EMI');

        $array_emi = array(
            '1' => $data->tipo_persona,
            '2' => $data->nit,
            '3' => $data->tipo_documento,
            '4' => $data->regimen_fiscal,
            '6' => $data->razon_social_emisor,
            '7' => $data->nombre_comercial_emisor,
            '10' => $data->direccion_emisor,
            '11' => $data->cod_departamento_emisor,
            '13' => $data->ciudad_emisor,
            '14' => $data->postal_emisor,
            '15' => $data->cod_pais_emisor,
            '19' => $data->departamento_emisor,
            '21' => $data->pais_emisor,
            '22' => $data->digito_verificacion_emisor,
            '23' => $data->cod_municipio_emisor,
            '24' => $data->nombre_comercial_emisor
        );

        foreach ($array_emi as $key => $value) {
            xml_add_child($emi, 'EMI_' . $key, $value);
        }

        $tac = xml_add_child($emi, 'TAC');
        xml_add_child($tac, 'TAC_1', str_replace(',', ";", $data->informacion_tributaria_emisor));

        $dfe = xml_add_child($emi, 'DFE');

        $array_dfe = array(
            '1' => $data->cod_municipio_emisor,
            '2' => $data->cod_departamento_emisor,
            '3' => $data->cod_pais_emisor,
            '4' => $data->postal_emisor,
            '5' => $data->pais_emisor,
            '6' => $data->departamento_emisor,
            '7' => $data->ciudad_emisor,
            '8' => $data->direccion_emisor,
        );

        foreach ($array_dfe as $key => $value) {
            xml_add_child($dfe, 'DFE_' . $key, $value);
        }

        $icc = xml_add_child($emi, 'ICC');
        $array_icc = array(
            '1' => $data->matricula_mercantil,
            '2' => $data->barrio_emisor,
            '9' => $resolucion->prefijo,
        );

        foreach ($array_icc as $key => $value) {
            xml_add_child($icc, 'ICC_' . $key, $value);
        }

        foreach (explode(',', $data->impuestos_emisor) as $value) {
            $val = explode('-', $value);
            $gte = xml_add_child($emi, 'GTE');
            xml_add_child($gte, 'GTE_1', $val[0]);
            xml_add_child($gte, 'GTE_2', $val[1]);
        }

        $cde = xml_add_child($emi, 'CDE');
        $array_cde = array(
            '1' => '1',
            '2' => 'Pendiente por definir',
            '3' => $data->telefono_emisor,
            '4' => 'angie.santiago@sonovista.co',
        );
        foreach ($array_cde as $key => $value) {
            xml_add_child($cde, 'CDE_' . $key, $value);
        }

        $adq = xml_add_child($RowBill, 'ADQ');

        $code_dpto = $this->M_Credit_Notes->InfoDpto($row_cliente->departamento)->codigo;
        $code_city = $this->M_Credit_Notes->InfoCity($row_cliente->ciudad, $code_dpto)->codigo;
        $digito_cliente = $this->calcularDigitoVerificacion($row_cliente->documento);

        $array_adq = array(
            '1' => $row_cliente->tipo_persona,
            '2' => $row_cliente->documento,
            '3' => $row_cliente->tipo_documento,
            '4' => ($row_cliente->regimen == 2) ? '48' : '49',
            '6' => $row_cliente->nombre,
        );

        if ($row_cliente->tipo_persona == 2) {
            $array_adq['7'] = $row_cliente->nombre;
            $array_adq['8'] = $row_cliente->nombre;
        }
        
        $array_adq['10'] =  $row_cliente->direccion;
        $array_adq['11'] =  (empty($row_cliente->departamento)) ? '' : $code_dpto;
        $array_adq['13'] =  $row_cliente->ciudad;
        $array_adq['15'] =  $row_cliente->pais;
        $array_adq['19'] = $row_cliente->departamento;
        $array_adq['21'] =  'COLOMBIA';
        $array_adq['22'] =  ''.$digito_cliente;
        $array_adq['23'] =  $code_city;
       
        
        foreach ($array_adq as $key => $value) {
            xml_add_child($adq, 'ADQ_' . $key, $value);
        }

        $tcr = xml_add_child($adq, 'TCR');
        xml_add_child($tcr, 'TCR_1', 'O-99');

        $ila = xml_add_child($adq, 'ILA');
        $array_ila = array(
            '1' => $row_cliente->nombre,
            '2' => $row_cliente->documento,
            '3' => $row_cliente->tipo_documento,
            '4' => ''.$digito_cliente
        );
        foreach ($array_ila as $key => $value) {
            xml_add_child($ila, 'ILA_' . $key, $value);
        }

        $dfa = xml_add_child($adq, 'DFA');
        $array_dfa = array(
            '1' => $row_cliente->pais,
            '2' => $code_dpto,
            '3' => '080001',
            '4' => $code_city,
            '5' => 'Colombia',
            '6' => $row_cliente->departamento,
            '7' => $row_cliente->ciudad,
            '8' => $row_cliente->direccion,
        );
        foreach ($array_dfa as $key => $value) {
            xml_add_child($dfa, 'DFA_' . $key, $value);
        }

        if ($row_cliente->tipo_persona == 1) {
            $icr = xml_add_child($adq, 'ICR');
            $array_icr = array(
                '1' => $row_cliente->camara,
            );
            foreach ($array_icr as $key => $value) {
                xml_add_child($icr, 'ICR_' . $key, $value);
            }
        }

        $cda = xml_add_child($adq, 'CDA');
        $array_cda = array(
            '1' => 1,
            '2' => $row_cliente->contacto_facturacion,
            '3' => $row_cliente->telefono_facturacion,
            '4' => $row_cliente->info_email,
        );
        foreach ($array_cda as $key => $value) {
            xml_add_child($cda, 'CDA_' . $key, $value);
        }


        foreach (explode(',', $data->impuesto_adquiriente) as $value) {
            $val = explode('-', $value);
            $gta = xml_add_child($adq, 'GTA');
            xml_add_child($gta, 'GTA_1', $val[0]);
            xml_add_child($gta, 'GTA_2', $val[1]);
        }


        $totals->bruto_spa = ($totals->bruto_spa - $totals->descuento_interna);
        $total_bruto = ($totals->bruto - $totals->descuento_externa) + $totals->bruto_spa;
        
//        if($totals->iva > 0){
//            $totals->iva =  ($totals->bruto - $totals->descuento_externa) * ($data->tarifa_impuesto / 100);
//        }
//        if($totals->iva_spa > 0){
//            $totals->iva_spa = $totals->bruto_spa * ($data->tarifa_impuesto / 100);
//        }
        $totals->total = $total_bruto + $totals->iva + $totals->iva_spa;
        
        $total_medios = ($totals->bruto - $totals->descuento_externa) + $totals->iva;
        
        $tot = xml_add_child($RowBill, 'TOT');
        $array_tot = array(
            '1' => $total_bruto,
            '2' => $data->divisa,
            '3' => $total_bruto,
            '4' => $data->divisa,
            '5' => $totals->total,
//            '5' => ($valr->vlr_bruto - $valr->vlr_desc) + $valr->vlr_iva  + $valr->vlr_ivaspa + $spa,
            '6' => $data->divisa,
            '7' => $total_bruto + $totals->iva + $totals->iva_spa,
            '8' => $data->divisa,
            '9' => 0,
            '10' => $data->divisa,
            '11' => '0',// total mas cargos
            '12' => $data->divisa,
            '13' => '0',
            '14' => $data->divisa,
        );
        foreach ($array_tot as $key => $value) {
            xml_add_child($tot, 'TOT_' . $key, $value);
        }

        $tim = xml_add_child($RowBill, 'TIM');
        $tim_2 = $totals->iva + $totals->iva_spa;
        $array_tim = array(
            '1' => 'false',
            '2' => ($tim_2 > 0)?$tim_2:'0',
            '3' => $data->divisa,
        );
        foreach ($array_tim as $key => $value) {
            xml_add_child($tim, 'TIM_' . $key, $value);
        }

        $imp = xml_add_child($tim, 'IMP');
        $im = explode(',', $data->impuestos_emisor);
        $imp_2= $totals->bruto - $totals->descuento_externa;
        $array_imp = array(
            '1' => explode('-', $im[0])[0],
            '2' => '' . $base_iva, 
            '3' => $data->divisa,
            '4' => ($totals->iva > 0)?$totals->iva:'0',
            '5' => $data->divisa,
            '6' => ($totals->iva > 0)?$data->tarifa_impuesto:'0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }


        $imp = xml_add_child($tim, 'IMP');
        $array_imp = array(
            '1' => '01',
            '2' => '' . $base_iva_spa,
            '3' => $data->divisa,
            '4' => ($totals->iva_spa > 0)?$totals->iva_spa:'0',
            '5' => $data->divisa,
            '6' => ($totals->iva_spa > 0)?$data->tarifa_impuesto:'0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }

        
        $ref = xml_add_child($RowBill, 'REF');
       
        $array_ref = array(
            '1' => 'IV',
            '2' => 'E'.$bill,
            '3' => $info->factura_impresion
        );
        foreach ($array_ref as $key => $value) {
            xml_add_child($ref, 'REF_' . $key, $value);
        }

        $array_note = array(
            '1.-SONOVISTA PUBLICIDAD S.A. \n\n' . $resolucion->resol_texto,
            '2.-Efectuar el ' . $info->factura_retefuente . '% de Retención en la fuente sobre ' . number_format($totals->bruto_spa, 0, ",", "."),
            '4.-LA FIRMA DEL COMPRADOR O CUALQUIER OTRA PERSONA QUE FORME PARTE DE LA EMPRESA DEL COMPRADOR EN LA PRESENTE FACTURA, ES PRUEBA DE QUE EL COMPRADOR CONOCE ESTAS CONDICIONES Y A ELLAS SE SOMETE INCONDICIONALMENTE',
            '5.-La presente Factura Cambiaria de Compraventa se asimila para todos sus efectos legales a la letra de cambio (Art. 774 y 671 C. de Co.) la cual pagaremos a SONOVISTA PUBLICIDAD S.A. excusado el protesto. En caso de mora, pagaremos intereses de 1.5% mensual, sin prejuicio de las acciones legales del acreedor. Por haberse recibido a satisfación la entrega real y material de las mercancías vendidas, aceptamos esta factura en la forma y términos del libramento.',
            '6.-' . $info->factura_formapago . '|' . $this->monedaletras->ValorEnLetras($totals->total, 'pesos') . '|||' . $info->factura_detalle,
            '7.-www.sonovista.co|' . $info->campana,
            '12.-' . $totals->bruto . '|' . $total_medios.'|'.($totals->bruto - $totals->descuento_externa).'|'.$totals->descuento_externa
        );
        foreach ($array_note as $value) {
            $not = xml_add_child($RowBill, 'NOT');
            xml_add_child($not, 'NOT_1', $value);
        }

        $mep = xml_add_child($RowBill, 'MEP');
        $array_mep = array(
            '1' => $data->medio_pago,
            '2' => $data->metodo_pago,
            '3' => $fecha_pago
        );
        foreach ($array_mep as $key => $value) {
            xml_add_child($mep, 'MEP_' . $key, $value);
        }

        $arrayOrc = array();
        foreach ($detail['result'] as $p) {
            $ppto = $this->M_Credit_Notes->GetPptoT($p->ppto);
            if ($ppto->orden > 0) {
                if (!in_array($ppto->orden, $arrayOrc)) {
                    $arrayOrc[] = $ppto->orden;
                    $orc = xml_add_child($RowBill, 'ORC');
                    xml_add_child($orc, 'ORC_1', $ppto->orden);
                }
            }
        }

        $cts = xml_add_child($RowBill, 'CTS');
        xml_add_child($cts, 'CTS_1', $data->plantilla);

        $cont = 1;
        foreach ($detail['result'] as $p) {

            $infoPpto = $this->M_Credit_Notes->GetCabPpto($p->ppto, $p->modulo_id);

            if ($p->id_producto == 473):
                $p->producto = 'PyP';
            elseif ($p->id_producto == 659 || $p->id_producto == 859):
                $p->producto = 'Act Nacional';
            endif;
            
            $descuento = $p->descuento;
            $base_spa = $p->spa;
            if ($p->tpo_presup != 'interna') {
                $ite_11 = 'EXTERNA|' . utf8_encode($p->tipo_servicio) . '|' . ucwords(strtolower(str_replace('&', '&amp;', $p->proveedor))) . ' - ' . $p->nit_proveedor . '|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto;
                $valor_bruto_item = $p->valor_bruto;
                $sub_total_item = $p->valor_bruto - $p->descuento;
                $tributo = $p->iva; 
                $p->iva_spa = $p->spa * ($infoPpto->iva_spa / 100);
                
            } else {
                $ite_11 = 'INTERNA|' . utf8_encode($p->tipo_servicio) . '|Sonovista Publicidad S.A - 890101778|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto;
                $valor_bruto_item = $p->spa ;
                $sub_total_item = $p->spa - $p->descuento;
                $tributo = ($p->spa - $p->descuento) * ($infoPpto->iva_spa / 100);
                $p->iva_spa = ($p->spa - $p->descuento) * ($infoPpto->iva_spa / 100);
            }
            
            $total_item = ($valor_bruto_item - $descuento) + $tributo;

            

            $ite = xml_add_child($RowBill, 'ITE');
            xml_add_child($ite, 'ITE_1', $cont);
            xml_add_child($ite, 'ITE_3', 1);
            xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
            xml_add_child($ite, 'ITE_5', $sub_total_item);
            xml_add_child($ite, 'ITE_6', $data->divisa);
            xml_add_child($ite, 'ITE_7', $valor_bruto_item);
            xml_add_child($ite, 'ITE_8', $data->divisa);

            xml_add_child($ite, 'ITE_11', $ite_11);
            xml_add_child($ite, 'ITE_17', $p->cebe);
            xml_add_child($ite, 'ITE_19', $total_item);
            xml_add_child($ite, 'ITE_20', $data->divisa);
            xml_add_child($ite, 'ITE_21', $total_item);
            xml_add_child($ite, 'ITE_22', $data->divisa);
            if ($p->tpo_presup != 'interna') {
                xml_add_child($ite, 'ITE_25', $ppto->orden);
            }
            xml_add_child($ite, 'ITE_27', 1);
            xml_add_child($ite, 'ITE_28', $data->codigo_unidad);

            $iae = xml_add_child($ite, 'IAE');
            $array_iae = array(
                '1' => $data->codigo_producto,
                '2' => $data->codigo_estandar_scheme,
                '3' => $data->id_scheme
            );
            foreach ($array_iae as $key => $value) {
                xml_add_child($iae, 'IAE_' . $key, $value);
            }

            if ($p->tpo_presup != 'interna') {
                $cmi = xml_add_child($ite, 'CMI');
                $array_cmi = array(
                    '1' => $row_cliente->documento,
                    '2' => $row_cliente->tipo_documento,
                    '3' => ''.$digito_cliente,
                );
                foreach ($array_cmi as $key => $value) {
                    xml_add_child($cmi, 'CMI_' . $key, $value);
                }
            }

            $ide = xml_add_child($ite, 'IDE');
            $array_ide = array(
                '1' => 'false',
                '2' => $descuento,
                '3' => $data->divisa,
                '6' => $infoPpto->porc_descuento,
                '7' => $valor_bruto_item,
                '8' => $data->divisa,
                '10' => '1',
            );
            foreach ($array_ide as $key => $value) {
                xml_add_child($ide, 'IDE_' . $key, $value);
            }

            $tii = xml_add_child($ite, 'TII');
            $array_tii = array(
                '1' => ($tributo > 0)?$tributo:'0',
                '2' => $data->divisa,
                '3' => 'false',
            );
            foreach ($array_tii as $key => $value) {
                xml_add_child($tii, 'TII_' . $key, $value);
            }

            if ($p->tpo_presup != 'interna') {
                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => ''.$p->iva,
                    '3' => $data->divisa,
                    '4' => $sub_total_item,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva,
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }
            } else {
                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva_spa = array(
                    '1' => '01',
                    '2' => ''.$p->iva_spa,
                    '3' => $data->divisa,
                    '4' => $sub_total_item,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva_spa,
                );
                foreach ($array_iim_iva_spa as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }
            }
            $cont++;

            if ($p->tpo_presup != 'interna' && $base_spa > 0) {
                $ite = xml_add_child($RowBill, 'ITE');

                $valor_bruto_item = $base_spa;
                $total_item = $valor_bruto_item + $p->iva_spa;

                xml_add_child($ite, 'ITE_1', $cont);
                xml_add_child($ite, 'ITE_3', 1);
                xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
                xml_add_child($ite, 'ITE_5', $valor_bruto_item);
                xml_add_child($ite, 'ITE_6', $data->divisa);
                xml_add_child($ite, 'ITE_7', $valor_bruto_item);
                xml_add_child($ite, 'ITE_8', $data->divisa);

                xml_add_child($ite, 'ITE_11', 'INTERNA|Servicios Agencia|Sonovista Publicidad S.A - 890101778|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto);
                xml_add_child($ite, 'ITE_19', $total_item);  //------------------------OJO CON EL TOTAL ----------------------
                xml_add_child($ite, 'ITE_20', $data->divisa);
                xml_add_child($ite, 'ITE_21', $total_item);
                xml_add_child($ite, 'ITE_22', $data->divisa);
                xml_add_child($ite, 'ITE_27', 1);
                xml_add_child($ite, 'ITE_28', $data->codigo_unidad);

                $iae = xml_add_child($ite, 'IAE');
                $array_iae = array(
                    '1' => $data->codigo_producto,
                    '2' => $data->codigo_estandar_scheme,
                    '3' => $data->id_scheme
                );
                foreach ($array_iae as $key => $value) {
                    xml_add_child($iae, 'IAE_' . $key, $value);
                }

                if ($p->tpo_presup != 'interna') {
                    $cmi = xml_add_child($ite, 'CMI');
                    $array_cmi = array(
                        '1' => $row_cliente->documento,
                        '2' => $row_cliente->tipo_documento,
                        '3' => ''.$digito_cliente,
                    );
                    foreach ($array_cmi as $key => $value) {
                        xml_add_child($cmi, 'CMI_' . $key, $value);
                    }
                }

                $ide = xml_add_child($ite, 'IDE');
                $array_ide = array(
                    '1' => 'false',
                    '2' => '0',
                    '3' => $data->divisa,
                    '6' => '0',
                    '7' => $valor_bruto_item,
                    '8' => $data->divisa,
                    '10' => '1',
                );
                foreach ($array_ide as $key => $value) {
                    xml_add_child($ide, 'IDE_' . $key, $value);
                }

                $tii = xml_add_child($ite, 'TII');
                $array_tii = array(
                    '1' => $p->iva_spa,
                    '2' => $data->divisa,
                    '3' => 'false',
                );
                foreach ($array_tii as $key => $value) {
                    xml_add_child($tii, 'TII_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva_spa = array(
                    '1' => '01',
                    '2' => $p->iva_spa,
                    '3' => $data->divisa,
                    '4' => $base_spa,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva_spa,
                );
                foreach ($array_iim_iva_spa as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $cont++;
            }
        }
        
        
        $file_xml = $n.'_' . $note . '_' . date("Ymd") . '.xml';

        $ruta = dirname(__FILE__) . '/../../../xml/Bill/' . $file_xml;
        xml_save($dom, $ruta);

        $dstFile = '/INVOICE/LAB/890101778/890101778_01/IN/' . $file_xml;

        if ($send) {
//            $host = 'sftp-piloto.cen.biz';
            $host = 'sftpebz.cen.biz';
            $port = 220;
            $user = 'sonopublisa_feco';
            $pass = 'S0n0pu61is4+fe';

            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $user, $pass);
            $sftp = ssh2_sftp($connection);
//            $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/LAB/890101778/890101778_01/IN/" . $file_xml, "w");
            $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $file_xml, "w"); 
            if (!$sftpStream) {
                throw new \Exception('Could not open remote file: ' . $dstFile);
            }
            try {
                $data_to_send = file_get_contents($ruta);
                fwrite($sftpStream, $data_to_send);
                fclose($sftpStream);
                $data = array('id_estado'=>44);
                $this->M_Credit_Notes->UpdateNote($note,$data);
                echo json_encode(array('res'=>'OK'));
            } catch (\Exception $e) {
                fclose($sftpStream);
                echo json_encode(array('res'=>'ERROR'));
            }
        } else {
            header("Content-Disposition: attachment; filename=" . $file_xml);
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($ruta));

            readfile($ruta);
        }
        unlink($ruta);
    }
    
    function GenerateXmlPrueba($note, $bill, $n ,$send = false) {

         $this->load->helper('xml_helper');
        $this->load->library('MonedaLetras');

        $dom = xml_dom();

        $data = $this->M_Credit_Notes->InfoDataBilling();
        $info = $this->M_Credit_Notes->InfoCab($note);
        $detail = $this->M_Credit_Notes->ListaDetailBill($note, $bill);
        $row_cliente = $this->M_Credit_Notes->ListarClientesNew($info->pvcl_id);
        $resolucion = $this->M_Credit_Notes->getResolution($info->resol_id);
        $totals = $this->M_Credit_Notes->GetTotalNc($note);
        
        $RowBill = xml_add_child($dom, 'NOTA');

        $enc = xml_add_child($RowBill, 'ENC');
        
        if($n == 'NC'){
            $tipo_doc = '91';
            $tipo_operacion = ($info->old == 1)?23:$data->tipo_operacion_nota;
        }else{
            $tipo_doc = '92';
            $tipo_operacion = ($info->old == 1)?33:$data->tipo_operacion_nd;
        }

        $array_enc = array('1' => $n
            , '2' => $data->nit
            , '3' => $row_cliente->documento
            , '4' => $data->version_ubl
            , '5' => $data->version_dian
            , '6' => 4267
            , '7' => $info->fecha
            , '8' => '23:00:30-05:00'
            , '9' => $tipo_doc
            , '10' => $data->divisa
            , '15' => $detail['num'] + $this->M_Credit_Notes->OtherLines($note)->count
            , '20' => 2
            , '21' => $tipo_operacion
        );

        foreach ($array_enc as $key => $value) {
            xml_add_child($enc, 'ENC_' . $key, $value);
        }

        $fecha_pago = strtotime('+30 day', strtotime($info->factura_impresion));
        $fecha_pago = date('Y-m-d', $fecha_pago);

        $emi = xml_add_child($RowBill, 'EMI');

        $array_emi = array(
            '1' => $data->tipo_persona,
            '2' => $data->nit,
            '3' => $data->tipo_documento,
            '4' => $data->regimen_fiscal,
            '6' => $data->razon_social_emisor,
            '7' => $data->nombre_comercial_emisor,
            '10' => $data->direccion_emisor,
            '11' => $data->cod_departamento_emisor,
            '13' => $data->ciudad_emisor,
            '14' => $data->postal_emisor,
            '15' => $data->cod_pais_emisor,
            '19' => $data->departamento_emisor,
            '21' => $data->pais_emisor,
            '22' => $data->digito_verificacion_emisor,
            '23' => $data->cod_municipio_emisor,
            '24' => $data->nombre_comercial_emisor
        );

        foreach ($array_emi as $key => $value) {
            xml_add_child($emi, 'EMI_' . $key, $value);
        }

        $tac = xml_add_child($emi, 'TAC');
        xml_add_child($tac, 'TAC_1', str_replace(',', ";", $data->informacion_tributaria_emisor));

        $dfe = xml_add_child($emi, 'DFE');

        $array_dfe = array(
            '1' => $data->cod_municipio_emisor,
            '2' => $data->cod_departamento_emisor,
            '3' => $data->cod_pais_emisor,
            '4' => $data->postal_emisor,
            '5' => $data->pais_emisor,
            '6' => $data->departamento_emisor,
            '7' => $data->ciudad_emisor,
            '8' => $data->direccion_emisor,
        );

        foreach ($array_dfe as $key => $value) {
            xml_add_child($dfe, 'DFE_' . $key, $value);
        }

        $icc = xml_add_child($emi, 'ICC');
        $array_icc = array(
            '1' => $data->matricula_mercantil,
            '2' => $data->barrio_emisor,
            '9' => $resolucion->prefijo,
        );

        foreach ($array_icc as $key => $value) {
            xml_add_child($icc, 'ICC_' . $key, $value);
        }

        foreach (explode(',', $data->impuestos_emisor) as $value) {
            $val = explode('-', $value);
            $gte = xml_add_child($emi, 'GTE');
            xml_add_child($gte, 'GTE_1', $val[0]);
            xml_add_child($gte, 'GTE_2', $val[1]);
        }

        $cde = xml_add_child($emi, 'CDE');
        $array_cde = array(
            '1' => '1',
            '2' => 'Pendiente por definir',
            '3' => $data->telefono_emisor,
            '4' => 'angie.santiago@sonovista.co',
        );
        foreach ($array_cde as $key => $value) {
            xml_add_child($cde, 'CDE_' . $key, $value);
        }

        $adq = xml_add_child($RowBill, 'ADQ');

        $code_dpto = $this->M_Credit_Notes->InfoDpto($row_cliente->departamento)->codigo;
        $code_city = $this->M_Credit_Notes->InfoCity($row_cliente->ciudad, $code_dpto)->codigo;
        $digito_cliente = $this->calcularDigitoVerificacion($row_cliente->documento);

        $array_adq = array(
            '1' => $row_cliente->tipo_persona,
            '2' => $row_cliente->documento,
            '3' => $row_cliente->tipo_documento,
            '4' => ($row_cliente->regimen == 2) ? '48' : '49',
            '6' => $row_cliente->nombre,
        );

        if ($row_cliente->tipo_persona == 2) {
            $array_adq['7'] = $row_cliente->nombre;
            $array_adq['8'] = $row_cliente->nombre;
        }
        
        $array_adq['10'] =  $row_cliente->direccion;
        $array_adq['11'] =  (empty($row_cliente->departamento)) ? '' : $code_dpto;
        $array_adq['13'] =  $row_cliente->ciudad;
        $array_adq['15'] =  $row_cliente->pais;
        $array_adq['19'] = $row_cliente->departamento;
        $array_adq['21'] =  'COLOMBIA';
        $array_adq['22'] =  ''.$digito_cliente;
        $array_adq['23'] =  $code_city;
       
        
        foreach ($array_adq as $key => $value) {
            xml_add_child($adq, 'ADQ_' . $key, $value);
        }

        $tcr = xml_add_child($adq, 'TCR');
        xml_add_child($tcr, 'TCR_1', 'O-99');

        $ila = xml_add_child($adq, 'ILA');
        $array_ila = array(
            '1' => $row_cliente->nombre,
            '2' => $row_cliente->documento,
            '3' => $row_cliente->tipo_documento,
            '4' => ''.$digito_cliente
        );
        foreach ($array_ila as $key => $value) {
            xml_add_child($ila, 'ILA_' . $key, $value);
        }

        $dfa = xml_add_child($adq, 'DFA');
        $array_dfa = array(
            '1' => $row_cliente->pais,
            '2' => $code_dpto,
            '3' => '080001',
            '4' => $code_city,
            '5' => 'Colombia',
            '6' => $row_cliente->departamento,
            '7' => $row_cliente->ciudad,
            '8' => $row_cliente->direccion,
        );
        foreach ($array_dfa as $key => $value) {
            xml_add_child($dfa, 'DFA_' . $key, $value);
        }

        if ($row_cliente->tipo_persona == 1) {
            $icr = xml_add_child($adq, 'ICR');
            $array_icr = array(
                '1' => $row_cliente->camara,
            );
            foreach ($array_icr as $key => $value) {
                xml_add_child($icr, 'ICR_' . $key, $value);
            }
        }

        $cda = xml_add_child($adq, 'CDA');
        $array_cda = array(
            '1' => 1,
            '2' => $row_cliente->contacto_facturacion,
            '3' => $row_cliente->telefono_facturacion,
            '4' => $row_cliente->info_email,
        );
        foreach ($array_cda as $key => $value) {
            xml_add_child($cda, 'CDA_' . $key, $value);
        }


        foreach (explode(',', $data->impuesto_adquiriente) as $value) {
            $val = explode('-', $value);
            $gta = xml_add_child($adq, 'GTA');
            xml_add_child($gta, 'GTA_1', $val[0]);
            xml_add_child($gta, 'GTA_2', $val[1]);
        }


        $totals->bruto_spa = ($totals->bruto_spa - $totals->descuento_interna);
        $total_bruto = ($totals->bruto - $totals->descuento_externa) + $totals->bruto_spa;
        $totals->iva =  ($totals->bruto - $totals->descuento_externa) * ($data->tarifa_impuesto / 100);
        $totals->iva_spa = $totals->bruto_spa * ($data->tarifa_impuesto / 100);
        $totals->total = $total_bruto + $totals->iva + $totals->iva_spa;
        
        $total_medios = ($totals->bruto - $totals->descuento_externa) + $totals->iva;
        
        $tot = xml_add_child($RowBill, 'TOT');
        $array_tot = array(
            '1' => $total_bruto,
            '2' => $data->divisa,
            '3' => $total_bruto,
            '4' => $data->divisa,
            '5' => $totals->total,
//            '5' => ($valr->vlr_bruto - $valr->vlr_desc) + $valr->vlr_iva  + $valr->vlr_ivaspa + $spa,
            '6' => $data->divisa,
            '7' => $total_bruto + $totals->iva + $totals->iva_spa,
            '8' => $data->divisa,
            '9' => 0,
            '10' => $data->divisa,
            '11' => '0',// total mas cargos
            '12' => $data->divisa,
            '13' => '0',
            '14' => $data->divisa,
        );
        foreach ($array_tot as $key => $value) {
            xml_add_child($tot, 'TOT_' . $key, $value);
        }

        $tim = xml_add_child($RowBill, 'TIM');
        $tim_2 = $totals->iva + $totals->iva_spa;
        $array_tim = array(
            '1' => 'false',
            '2' => ($tim_2 > 0)?$tim_2:'0',
            '3' => $data->divisa,
        );
        foreach ($array_tim as $key => $value) {
            xml_add_child($tim, 'TIM_' . $key, $value);
        }

        $imp = xml_add_child($tim, 'IMP');
        $im = explode(',', $data->impuestos_emisor);
        $array_imp = array(
            '1' => explode('-', $im[0])[0],
            '2' => $totals->bruto - $totals->descuento_externa, 
            '3' => $data->divisa,
            '4' => $totals->iva,
            '5' => $data->divisa,
            '6' => ($totals->iva > 0)?$data->tarifa_impuesto:'0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }


        $imp = xml_add_child($tim, 'IMP');
        $array_imp = array(
            '1' => '01',
            '2' => $totals->bruto_spa,
            '3' => $data->divisa,
            '4' => $totals->iva_spa,
            '5' => $data->divisa,
            '6' => ($totals->iva_spa > 0)?$data->tarifa_impuesto:'0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }

        
        $ref = xml_add_child($RowBill, 'REF');
       
        $array_ref = array(
            '1' => 'IV',
            '2' => 'E'.$bill,
            '3' => $info->factura_impresion
        );
        foreach ($array_ref as $key => $value) {
            xml_add_child($ref, 'REF_' . $key, $value);
        }

        $array_note = array(
            '1.-SONOVISTA PUBLICIDAD S.A. \n\n' . $resolucion->resol_texto,
            '2.-Efectuar el ' . $info->factura_retefuente . '% de Retención en la fuente sobre ' . number_format($totals->bruto_spa, 0, ",", "."),
            '4.-LA FIRMA DEL COMPRADOR O CUALQUIER OTRA PERSONA QUE FORME PARTE DE LA EMPRESA DEL COMPRADOR EN LA PRESENTE FACTURA, ES PRUEBA DE QUE EL COMPRADOR CONOCE ESTAS CONDICIONES Y A ELLAS SE SOMETE INCONDICIONALMENTE',
            '5.-La presente Factura Cambiaria de Compraventa se asimila para todos sus efectos legales a la letra de cambio (Art. 774 y 671 C. de Co.) la cual pagaremos a SONOVISTA PUBLICIDAD S.A. excusado el protesto. En caso de mora, pagaremos intereses de 1.5% mensual, sin prejuicio de las acciones legales del acreedor. Por haberse recibido a satisfación la entrega real y material de las mercancías vendidas, aceptamos esta factura en la forma y términos del libramento.',
            '6.-' . $info->factura_formapago . '|' . $this->monedaletras->ValorEnLetras($totals->total, 'pesos') . '|||' . $info->factura_detalle,
            '7.-www.sonovista.co|' . $info->campana,
            '12.-' . $totals->bruto . '|' . $total_medios.'|'.($totals->bruto - $totals->descuento_externa).'|'.$totals->descuento_externa
        );
        foreach ($array_note as $value) {
            $not = xml_add_child($RowBill, 'NOT');
            xml_add_child($not, 'NOT_1', $value);
        }

        $mep = xml_add_child($RowBill, 'MEP');
        $array_mep = array(
            '1' => $data->medio_pago,
            '2' => $data->metodo_pago,
            '3' => $fecha_pago
        );
        foreach ($array_mep as $key => $value) {
            xml_add_child($mep, 'MEP_' . $key, $value);
        }

        $arrayOrc = array();
        foreach ($detail['result'] as $p) {
            $ppto = $this->M_Credit_Notes->GetPptoT($p->ppto);
            if ($ppto->orden > 0) {
                if (!in_array($ppto->orden, $arrayOrc)) {
                    $arrayOrc[] = $ppto->orden;
                    $orc = xml_add_child($RowBill, 'ORC');
                    xml_add_child($orc, 'ORC_1', $ppto->orden);
                }
            }
        }

        $cts = xml_add_child($RowBill, 'CTS');
        xml_add_child($cts, 'CTS_1', $data->plantilla);

        $cont = 1;
        foreach ($detail['result'] as $p) {

            $infoPpto = $this->M_Credit_Notes->GetCabPpto($p->ppto, $p->modulo_id);

            if ($p->id_producto == 473):
                $p->producto = 'PyP';
            elseif ($p->id_producto == 659 || $p->id_producto == 859):
                $p->producto = 'Act Nacional';
            endif;
            
            $descuento = $p->descuento;
            $base_spa = $p->spa;
            if ($p->tpo_presup != 'interna') {
                $ite_11 = 'EXTERNA|' . utf8_encode($p->tipo_servicio) . '|' . ucwords(strtolower(str_replace('&', '&amp;', $p->proveedor))) . ' - ' . $p->nit_proveedor . '|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto;
                $valor_bruto_item = $p->valor_bruto;
                $sub_total_item = $p->valor_bruto - $p->descuento;
                $tributo = $p->iva; 
                $p->iva_spa = $p->spa * ($infoPpto->iva_spa / 100);
                
            } else {
                $ite_11 = 'INTERNA|' . utf8_encode($p->tipo_servicio) . '|Sonovista Publicidad S.A - 890101778|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto;
                $valor_bruto_item = $p->spa ;
                $sub_total_item = $p->spa - $p->descuento;
                $tributo = ($p->spa - $p->descuento) * ($infoPpto->iva_spa / 100);
                $p->iva_spa = ($p->spa - $p->descuento) * ($infoPpto->iva_spa / 100);
            }
            
            $total_item = ($valor_bruto_item - $descuento) + $tributo;

            

            $ite = xml_add_child($RowBill, 'ITE');
            xml_add_child($ite, 'ITE_1', $cont);
            xml_add_child($ite, 'ITE_3', 1);
            xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
            xml_add_child($ite, 'ITE_5', $sub_total_item);
            xml_add_child($ite, 'ITE_6', $data->divisa);
            xml_add_child($ite, 'ITE_7', $valor_bruto_item);
            xml_add_child($ite, 'ITE_8', $data->divisa);

            xml_add_child($ite, 'ITE_11', $ite_11);
            xml_add_child($ite, 'ITE_17', $p->cebe);
            xml_add_child($ite, 'ITE_19', $total_item);
            xml_add_child($ite, 'ITE_20', $data->divisa);
            xml_add_child($ite, 'ITE_21', $total_item);
            xml_add_child($ite, 'ITE_22', $data->divisa);
            if ($p->tpo_presup != 'interna') {
                xml_add_child($ite, 'ITE_25', $ppto->orden);
            }
            xml_add_child($ite, 'ITE_27', 1);
            xml_add_child($ite, 'ITE_28', $data->codigo_unidad);

            $iae = xml_add_child($ite, 'IAE');
            $array_iae = array(
                '1' => $data->codigo_producto,
                '2' => $data->codigo_estandar_scheme,
                '3' => $data->id_scheme
            );
            foreach ($array_iae as $key => $value) {
                xml_add_child($iae, 'IAE_' . $key, $value);
            }

            if ($p->tpo_presup != 'interna') {
                $cmi = xml_add_child($ite, 'CMI');
                $array_cmi = array(
                    '1' => $row_cliente->documento,
                    '2' => $row_cliente->tipo_documento,
                    '3' => ''.$digito_cliente,
                );
                foreach ($array_cmi as $key => $value) {
                    xml_add_child($cmi, 'CMI_' . $key, $value);
                }
            }

            $ide = xml_add_child($ite, 'IDE');
            $array_ide = array(
                '1' => 'false',
                '2' => $descuento,
                '3' => $data->divisa,
                '6' => $infoPpto->porc_descuento,
                '7' => $valor_bruto_item,
                '8' => $data->divisa,
                '10' => '1',
            );
            foreach ($array_ide as $key => $value) {
                xml_add_child($ide, 'IDE_' . $key, $value);
            }

            $tii = xml_add_child($ite, 'TII');
            $array_tii = array(
                '1' => $tributo,
                '2' => $data->divisa,
                '3' => 'false',
            );
            foreach ($array_tii as $key => $value) {
                xml_add_child($tii, 'TII_' . $key, $value);
            }

            if ($p->tpo_presup != 'interna') {
                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => $p->iva,
                    '3' => $data->divisa,
                    '4' => $sub_total_item,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva,
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }
            } else {
                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva_spa = array(
                    '1' => '01',
                    '2' => $p->iva_spa,
                    '3' => $data->divisa,
                    '4' => $sub_total_item,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva_spa,
                );
                foreach ($array_iim_iva_spa as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }
            }
            $cont++;

            if ($p->tpo_presup != 'interna' && $base_spa > 0) {
                $ite = xml_add_child($RowBill, 'ITE');

                $valor_bruto_item = $base_spa;
                $total_item = $valor_bruto_item + $p->iva_spa;

                xml_add_child($ite, 'ITE_1', $cont);
                xml_add_child($ite, 'ITE_3', 1);
                xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
                xml_add_child($ite, 'ITE_5', $valor_bruto_item);
                xml_add_child($ite, 'ITE_6', $data->divisa);
                xml_add_child($ite, 'ITE_7', $valor_bruto_item);
                xml_add_child($ite, 'ITE_8', $data->divisa);

                xml_add_child($ite, 'ITE_11', 'INTERNA|Servicios Agencia|Sonovista Publicidad S.A - 890101778|' . utf8_encode(ucwords(strtolower($p->producto))) . '|' . $p->ppto);
                xml_add_child($ite, 'ITE_19', $total_item);  //------------------------OJO CON EL TOTAL ----------------------
                xml_add_child($ite, 'ITE_20', $data->divisa);
                xml_add_child($ite, 'ITE_21', $total_item);
                xml_add_child($ite, 'ITE_22', $data->divisa);
                xml_add_child($ite, 'ITE_27', 1);
                xml_add_child($ite, 'ITE_28', $data->codigo_unidad);

                $iae = xml_add_child($ite, 'IAE');
                $array_iae = array(
                    '1' => $data->codigo_producto,
                    '2' => $data->codigo_estandar_scheme,
                    '3' => $data->id_scheme
                );
                foreach ($array_iae as $key => $value) {
                    xml_add_child($iae, 'IAE_' . $key, $value);
                }

                if ($p->tpo_presup != 'interna') {
                    $cmi = xml_add_child($ite, 'CMI');
                    $array_cmi = array(
                        '1' => $row_cliente->documento,
                        '2' => $row_cliente->tipo_documento,
                        '3' => ''.$digito_cliente,
                    );
                    foreach ($array_cmi as $key => $value) {
                        xml_add_child($cmi, 'CMI_' . $key, $value);
                    }
                }

                $ide = xml_add_child($ite, 'IDE');
                $array_ide = array(
                    '1' => 'false',
                    '2' => '0',
                    '3' => $data->divisa,
                    '6' => '0',
                    '7' => $valor_bruto_item,
                    '8' => $data->divisa,
                    '10' => '1',
                );
                foreach ($array_ide as $key => $value) {
                    xml_add_child($ide, 'IDE_' . $key, $value);
                }

                $tii = xml_add_child($ite, 'TII');
                $array_tii = array(
                    '1' => $p->iva_spa,
                    '2' => $data->divisa,
                    '3' => 'false',
                );
                foreach ($array_tii as $key => $value) {
                    xml_add_child($tii, 'TII_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva = array(
                    '1' => '01',
                    '2' => '0',
                    '3' => $data->divisa,
                    '4' => '0',
                    '5' => $data->divisa,
                    '6' => '0.00',
                );
                foreach ($array_iim_iva as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $iim = xml_add_child($tii, 'IIM');
                $array_iim_iva_spa = array(
                    '1' => '01',
                    '2' => $p->iva_spa,
                    '3' => $data->divisa,
                    '4' => $base_spa,
                    '5' => $data->divisa,
                    '6' => $infoPpto->iva_spa,
                );
                foreach ($array_iim_iva_spa as $key => $value) {
                    xml_add_child($iim, 'IIM_' . $key, $value);
                }

                $cont++;
            }
        }
        
        
        $file_xml = $n.'_' . $note . '_' . date("Ymd") . '.xml';

        $ruta = dirname(__FILE__) . '/../../../xml/Bill/' . $file_xml;
        xml_save($dom, $ruta);

        $dstFile = '/INVOICE/LAB/890101778/890101778_01/IN/' . $file_xml;

        if ($send) {
            $host = 'sftp-piloto.cen.biz';
//            $host = 'sftpebz.cen.biz';
            $port = 220;
            $user = 'sonopublisa_feco';
            $pass = 'S0n0pu61is4+fe';

            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $user, $pass);
            $sftp = ssh2_sftp($connection);
            $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/LAB/890101778/890101778_01/IN/" . $file_xml, "w");
//            $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $file_xml, "w"); 
            if (!$sftpStream) {
                throw new \Exception('Could not open remote file: ' . $dstFile);
            }
            try {
                $data_to_send = file_get_contents($ruta);
                fwrite($sftpStream, $data_to_send);
                fclose($sftpStream);
                echo json_encode(array('res'=>'OK'));
            } catch (\Exception $e) {
                fclose($sftpStream);
                echo json_encode(array('res'=>'ERROR'));
            }
        } else {
            header("Content-Disposition: attachment; filename=" . $file_xml);
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($ruta));

            readfile($ruta);
        }
        unlink($ruta);
    }
    

}

