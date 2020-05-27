<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Bill extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Billing/M_Bill');
    }

    public function Panel() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, RANGOPICKER_CSS, ICHECK_CSS_RED, DATEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
		$data = array();
        foreach ($this->M_Bill->LoadButtonPermissions("FACTURA") as $btn) {
            $data[$btn->name] = $btn->name;
        }
        
        $tabla = $this->load->view('Billing/Bill/V_List_Bill', $data, true);
        $clientes = $this->M_Bill->ListarClientesNew();

        $this->load->view('Billing/Bill/V_Panel', array('table' => $tabla, 'clientes' => $clientes));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, MOMENT, RANGOPICKER_JS, ICHECK_JS, DATEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function NewP() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS, FILER_CSS);
        
        $this->load->view('Template/V_Header', $Header);
        
        $data['clientes'] = $this->M_Bill->ListarClientesNew();
        $data['retenciones'] = $this->M_Bill->Retencion();
        $data['category'] = $this->M_Bill->GetCategorias();
       
        $detail = array();
        $adjuntos = array();
                
        $btns = $this->M_Bill->LoadButtonPermissions("FACTURA");
        
        foreach ($btns as $btn) {
            $button = $btn->name;
            $data[$button] = $button;
        }
        
        $data['adjuntos'] = $this->load->view('Billing/Bill/V_Adjuntos',array('adjuntos'=>$adjuntos,'factura_id'=>''),true);
        $data['detail'] = '';
        $this->load->view('Billing/Bill/V_Form_New',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS, FILER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function Edit($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS, FILER_CSS);
        
        $this->load->view('Template/V_Header', $Header);
        
        $data['id'] = $id;
        
        $data['row'] = $this->M_Bill->InfoBill($id);
        $data['val'] = $this->M_Bill->InfoValues($id);
        $data['clientes'] = $this->M_Bill->ListarClientesNew();
        $data['campanas'] = $this->M_Bill->ListarCampana($data['row']->id_cliente);
        $data['retenciones'] = $this->M_Bill->Retencion();
        $data['category'] = $this->M_Bill->GetCategorias();
       
        $detail = $this->M_Bill->ListaDetailBill($id);
        $adjuntos = $this->M_Bill->ListaAdjuntos($id);
                
        $btns = $this->M_Bill->LoadButtonPermissions("FACTURA");
        
        foreach ($btns as $btn) {
            $button = $btn->name;
            $data[$button] = $button;
        }
        
        $data['adjuntos'] = $this->load->view('Billing/Bill/V_Adjuntos',array('adjuntos'=>$adjuntos,'factura_id'=>$id),true);
        $data['detail'] = $this->load->view('Billing/Bill/V_Table_Detail',array('detail'=>$detail),true);
        $this->load->view('Billing/Bill/V_Form_Update',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS, FILER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function Attach($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        
        $this->load->view('Template/V_Header', $Header);
        
        $data['id'] = $id;
        $data['row'] = $this->M_Bill->InfoBill($id);
        $adjuntos = $this->M_Bill->ListaAdjuntos($id);
                
        $data['adjuntos'] = $this->load->view('Billing/Bill/V_Adjuntos',array('adjuntos'=>$adjuntos,'factura_id'=>$id),true);
     
        $this->load->view('Billing/Bill/V_Form_Attach',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ListBill($factura, $cliente, $f_ini, $f_fin) {
        $order_by = $this->input->get("order");
        $rows = $this->M_Bill->ListBill($this->input->get('start'), $this->input->get("length"), $order_by[0]['dir'], $factura, $cliente, $f_ini, $f_fin);
        $all = $this->M_Bill->SelectBill($factura, $cliente, $f_ini, $f_fin);
        $array = array();
        
        $btns = $this->M_Bill->LoadButtonPermissions("FACTURA");
        
        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        
        foreach ($rows['result'] as $v) {
            
            $btn = '<div class="btn-group btnI'.$v->factura_id.'" >
                        <button style="width:100px;"  type="button" class="btn1-'.$v->factura_id.' btn btn-'.$v->est_color.' btn-xs btn-left">'.$v->estado.'</button>
                            <button type="button" class="btn2-'.$v->factura_id.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu u-'.$v->factura_id.'" role="menu">';
            
            $btn    .= '<li onclick="printPdf('.$v->factura_id.',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Ver Factura</a></li>';
            $btn    .= (isset($BtnEditBill) && ($v->est_id == 1 || $v->est_id == 4))? '<li onclick="EditBill('.$v->factura_id.')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>':'';
            $btn    .= ((isset($BtnGenerateNc)) && ($v->est_id == 4 || $v->est_id == 46 || $v->est_id == 44))? '<li onclick="OpenModal(' . $v->factura_id . ')"><a href="#"></i><i class="fa fa-fw fa-gears"></i> Generar NC</a></li>':'';
            $btn    .= ((isset($BtnSend)) && ($v->est_id == 4 || $v->est_id == 44))?'<li onclick="PrintXmlProductivo(' . $v->factura_id . ')"><a href="#"></i><i class="fa fa-fw fa-send"></i> Enviar CEN</a></li>':'';
            $btn    .= ((isset($BtnDownXml)) && ($v->est_id == 4 || $v->est_id == 44))?'<li onclick="OpenXmlProductivo(' . $v->factura_id . ')"><a href="#"></i><i class="fa fa-fw fa-download"></i> Descargar XML</a></li>':'';
            $btn    .= ($v->est_id == 44)?'<li class="divider"></li>':'';
            $btn    .= ((isset($BtnAproBill)) && ($v->est_id == 44))? '<li onclick="Approve('.$v->factura_id.',45)"><a href="#"><i class="fa fa-fw fa-check" ></i> Aprobado CEN</a></li>':'';
            $btn    .= ((isset($BtnAproBill)) && ($v->est_id == 44))? '<li onclick="Approve('.$v->factura_id.',46)"><a href="#"><i class="fa fa-fw fa-times" ></i> Rechazado CEN</a></li>':'';
            $btn    .= '<li class="divider"></li>';
            $btn    .= '<li onclick="getAttach('.$v->factura_id.')"><a href="#"><i class="fa fa-fw fa-paperclip" ></i>Adjuntos</a></li>';
            $btn    .= '</ul></div>';
            
            $array[] = array(
                $btn,
                $v->factura_id,
                $v->fecha,
                $v->cliente,
                $v->campana,
                '$' . number_format($v->factura_total, 2,'.',',')
            );
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function DeleteDetail(){
        $id_detalle = $this->input->post('id_detalle');
        $factura_id = $this->input->post('factura_id');
        $ppto = $this->input->post('ppto');
        $tipo = $this->input->post('tipo');
        
        $result = $this->M_Bill->DeleteDetail($id_detalle, $ppto, $tipo);
        
        if($result['res'] == 'OK'){
            $result['val'] = $this->M_Bill->InfoValues($factura_id);
            $this->M_Bill->UpdataBill($factura_id,array('factura_total'=>(count($result['val'])>0)?$result['val']->vlr_total:0));
            $detail = $this->M_Bill->ListaDetailBill($factura_id);
            $result['table'] = $this->load->view('Billing/Bill/V_Table_Detail',array('detail'=>$detail),true);
        }
        echo json_encode($result);
    }
    
    function GetListTable(){
        $rows = $this->M_Bill->ListarType($this->input->post('category'),$this->input->post('client'),$this->input->post('campain'));
        echo json_encode($rows);
    }
    
    function UpdateInfo(){
        $factura_id = $this->input->post('factura_id');
        unset($_POST['factura_id']);
        
        $result = $this->M_Bill->UpdateInfo($factura_id,$_POST);
        echo json_encode(array('res'=>$result));
    }
    
    function Aprove(){
        $factura_id = $this->input->post('factura_id');
        unset($_POST['factura_id']);
        
        $result = $this->M_Bill->UpdateInfo($factura_id,$_POST);
        
        $detail = $this->M_Bill->ListaDetailBill($factura_id);
        foreach ($detail['result'] as $value) {
            $this->M_Bill->UpdateStatusPpto($value->ppto, $value->modulo_id, 4);
        }
        echo json_encode(array('res'=>$result));
    }

    function ListaDetailBill() {
        $res = $this->M_Bill->ListaDetailBill($this->input->post('factura'));
        $result['detail'] = $res['result'];
        $data['table'] = $this->load->view('Billing/V_Table_Detail', $result, true);
        echo json_encode($data);
    }
    
    function GenerateNote() {
        $this->db->trans_begin();

        $res = '';
        $id = $this->M_Bill->CreateNote(
                array(
                    'factura' => $this->input->post('factura'),
                    'fecha' => $this->input->post('fecha'),
                    'observacion' => $this->input->post('observacion')
                )
        );

        foreach ($this->input->post('array_body') as $v) {
            $Subdata = array(
                'id_nota_credito' => $id,
                'ppto' => $v[0],
                'tipo' => $v[1],
                'valor_bruto' => str_replace(",", "", $v[3]),
                'descuento' => str_replace(",", "", $v[4]),
                'iva' => str_replace(",", "", $v[5]),
                'spa' => str_replace(",", "", $v[6]),
                'iva_spa' => str_replace(",", "", $v[7]),
                'total' => str_replace(",", "", $v[8])
            );

            $res = $this->M_Bill->CreateNoteDetail($Subdata);

            switch ($v[1]) {
                case "aviso":
                    $tabla = "presup_avisos";
                    $campo = 'psav_estado';
                    $where = 'psav_id';
                    break;
                case "clasificados":
                    $tabla = "presup_clasificados";
                    $campo = 'pscf_estado';
                    $where = 'pscf_id';
                    break;
                case "revistas":
                    $tabla = "presup_revis";
                    $campo = 'psrev_estado';
                    $where = 'psrev_id';
                    break;
                case "radio":
                    $tabla = "presup_radio";
                    $campo = 'psrad_estado';
                    $where = 'psrad_id';
                    break;
                case "television":
                    $tabla = "presup_tv";
                    $campo = 'pstv_estado';
                    $where = 'pstv_id';
                    break;
                case "externa":
                    $tabla = "presup_prode";
                    $campo = 'psex_estado';
                    $where = 'psex_id';
                    break;
                case "interna":
                    $tabla = "presup_prodi";
                    $campo = 'psin_estado';
                    $where = 'psin_id';
                    break;
                case "publicidad exterior":
                    $tabla = "publicidad_exterior";
                    $campo = 'est_id';
                    $where = 'pubext_id';
                    break;
                case "impresos":
                    $tabla = "impresos";
                    $campo = 'est_id';
                    $where = 'imp_id';
                    break;
                case "articulos publicitarios":
                    $tabla = "art_publi";
                    $campo = 'est_id';
                    $where = 'artp_id';
                    break;
                default:
                    break;
            }

            $this->M_Bill->UpdatePpto($tabla, $where, $v[0], $campo, 47);
            $this->M_Bill->UpdateDetalleFactura($v[2]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        echo json_encode(array('res' => $res));
    }
    
    function InsertInfo(){
        $result = $this->M_Bill->InsertInfo($_POST);
        echo json_encode($result);
    }
    
    function PrintPpto($factura_id){
        
//        $result = $this->M_Bill->CabBill($factura_id);
////        $result['detail'] = $this->M_Bill->GetDetailPpto($tipo, $ppto);
////        $result['bill'] = $this->M_Bill->GetBillPpto($ppto,$tipo);
//       
//        $html = $this->load->view('Billing/Bill/V_Pdf',array('v'=>$result));
              
    }
    
    function AddDetail(){
        $tipo = $this->input->post('tipo');
        $factura_id = $this->input->post('factura_id');
        $row = $this->M_Bill->GetPptoInfo($tipo, $this->input->post('ppto'));
        $data = array (
            'factura_id'=> $factura_id,
            'modulo_id'=> $tipo,
            'id_doc'=> $this->input->post('ppto')
        );
        
        
        $data['vlr_total'] =  $row->total;
        $data['tpsv_id'] =  $row->id_servicio;
        $data['pvcl_id_prov'] =  $row->id_proveedor;
        $data['pvcl_id_clie'] =  $row->id_cliente;
        $data['camp_id'] =  $row->id_campana;
        $data['pdcl_id'] =  $row->id_producto;
        
        if($tipo != 7){
            $vlrDesc = $row->valor * ($row->descuento / 100 );
            $subTotal = $row->valor - $vlrDesc;
            $vlrIva = $subTotal * ($row->iva / 100 );
            $vlrMasIva = $subTotal + $vlrIva;
            $vlrSpa = $subTotal * ($row->porcentaje_spa / 100 );
            $vlrIvaspa = $vlrSpa * ($row->porcentaje_iva_spa / 100 );
                    
            $data['vlr_bruto'] = $row->valor;
            $data['vlr_desc'] =  $vlrDesc;
            $data['vlr_subtotal_medios'] =  $subTotal;
            $data['vlr_subtotal2_medios'] =  $vlrMasIva;
            $data['vlr_iva'] =  $vlrIva;
            $data['vlr_spa'] =  $vlrSpa;
            $data['vlr_ivaspa'] =  $vlrIvaspa;
        }else{
            $vlrDesc = $row->valor * ($row->descuento / 100 );
            $subTotal = $row->valor - $vlrDesc;
            $vlrIva = $subTotal * ($row->iva / 100 );
            
            $data['vlr_desc_interna'] =  $vlrDesc;
            $data['vlr_spa_interna'] =  $row->valor;
            $data['vlr_subtotal_interna'] =  $subTotal;
            $data['vlr_ivaspa'] =  $vlrIva;
        }
        
        $result = $this->M_Bill->AddDetail($factura_id, $data, $this->input->post('ppto'), $tipo);
        
        if($result['res'] == 'OK'){
            $result['val'] = $this->M_Bill->InfoValues($factura_id);
            $this->M_Bill->UpdataBill($factura_id,array('factura_total'=>$result['val']->vlr_total));
            $detail = $this->M_Bill->ListaDetailBill($factura_id);
            $result['table'] = $this->load->view('Billing/Bill/V_Table_Detail',array('detail'=>$detail),true);
        }
        echo json_encode($result);
    }
    
    function UpAttach() {
        $factura_id = $this->input->post('factura_id');
        
        require_once(dirname(__FILE__) . '/../../../dist/jQuery.filer/php/class.uploader.php');
        
        $ruta = dirname(__FILE__) . '/../../../Adjuntos/FACTURAS/'.$factura_id.'/';
        
        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['files'], array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => $ruta, //Upload directory {String}
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
                
                $totalSize = $this->M_Bill->sizeFile($factura_id);
               
                if(($totalSize->total + $value['size']) > 2000000){
                    $result['res'] = 'La sumatoria de tamaño de los archivos de la factura sobrepasan las dos megas permitidas ';
                    unlink($ruta.$value['name']);
                }else{
                    $datos['name'] = $value['name'];
                    $datos['size'] = $value['size'];
                    $datos['size2'] = $value['size2'];
                    $datos['type'] = $value['type'][1];
                    $datos['factura_id'] = $factura_id;
                    $this->M_Bill->SaveFile($datos);
                    
                    $adjuntos = $this->M_Bill->ListaAdjuntos($factura_id);
                    $result['table'] = $this->load->view('Billing/Bill/V_Adjuntos',array('adjuntos'=>$adjuntos,'factura_id'=>$factura_id),true);
                    
                    $result['res'] = 'OK';
                }
            }
        } else if ($data['hasErrors']) {
            $result = array();
            $result['res'] = $data['errors'];
        }

        echo json_encode($result);
    }
    
    function deleteAdjunto(){
        $result = $this->M_Bill->deleteAdjunto($this->input->post('id'),$this->input->post('ruta'));
        echo json_encode($result);
    }
    
    function sssssss($bill, $send = false) {

        $this->load->helper('xml_helper');
        $this->load->library('MonedaLetras');

        $dom = xml_dom();

        $data = $this->M_Bill->InfoDataBilling();
        $info = $this->M_Bill->InfoBill($bill);
        $valr = $this->M_Bill->InfoValues($bill);
        $detail = $this->M_Bill->ListaDetailBill($bill);
        $row_cliente = $this->M_Bill->ListarClientesNew($info->id_cliente);
        $resolucion = $this->M_Bill->getResolution($info->resol_id);
//        $resolucion = $this->M_Bill->getResolution(3);

        $RowBill = xml_add_child($dom, 'FACTURA');

        $enc = xml_add_child($RowBill, 'ENC');

        $fecha_pago = strtotime('+30 day', strtotime($info->factura_impresion));
        $fecha_pago = date('Y-m-d', $fecha_pago);

        $tipo_operacion = '10';
        $imp_All = 0;
        foreach ($detail['result'] as $p) {
            if ($p->tpo_presup != 'interna') {
                $tipo_operacion = '11';
//                break;
                $imp_All += $p->vlr_iva;
                $base = $p->vlr_spa;
            } else {
                $base = $p->vlr_spa_interna;
                $imp_All += $p->vlr_ivaspa;
            }

            if ($p->tpo_presup != 'interna' && $base > 0) {
                $imp_All += $p->vlr_ivaspa;
            }
        }

        $array_enc = array('1' => 'INVOIC'
            , '2' => $data->nit
            , '3' => $row_cliente->documento
            , '4' => $data->version_ubl
            , '5' => $data->version_dian
            , '6' => 'E' . $bill
            , '7' => $info->factura_impresion
            , '8' => $info->factura_hora . '-05:00'
            , '9' => '01'
            , '10' => $data->divisa
            , '15' => $detail['num'] + $this->M_Bill->OtherLines($bill)->count
            , '16' => $fecha_pago
            , '20' => $data->ambiente
            , '21' => $tipo_operacion
        );

        foreach ($array_enc as $key => $value) {
            xml_add_child($enc, 'ENC_' . $key, $value);
        }



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

        $code_dpto = $this->M_Bill->InfoDpto($row_cliente->departamento)->codigo;
        $code_city = $this->M_Bill->InfoCity($row_cliente->ciudad, $code_dpto)->codigo;
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

        $array_adq['10'] = $row_cliente->direccion;
        $array_adq['11'] = (empty($row_cliente->departamento)) ? '' : $code_dpto;
        $array_adq['13'] = $row_cliente->ciudad;
        $array_adq['15'] = $row_cliente->pais;
        $array_adq['19'] = $row_cliente->departamento;
        $array_adq['21'] = 'COLOMBIA';
        $array_adq['22'] = ''.$digito_cliente;
        $array_adq['23'] = $code_city;

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




        $spa = $valr->vlr_spa + $valr->vlr_subtotal_interna;
        $total_bruto = $valr->vlr_bruto + $spa;

        $valr->vlr_iva = ($valr->vlr_iva > 0) ? round($valr->imp_iva * ($data->tarifa_impuesto / 100)) : 0;
        $valr->vlr_ivaspa = ($valr->vlr_ivaspa > 0) ? round($spa * ($data->tarifa_impuesto / 100)) : 0;
        $tim_2 = $valr->vlr_iva + $valr->vlr_ivaspa;

        $total_factura = ($valr->vlr_bruto - $valr->vlr_desc) + $valr->vlr_iva + $valr->vlr_ivaspa + $spa;

        $tot = xml_add_child($RowBill, 'TOT');
        $array_tot = array(
            '1' => $valr->vlr_bruto + $spa - $valr->vlr_desc,
            '2' => $data->divisa,
            '3' => $valr->vlr_bruto + $spa - $valr->vlr_desc,
            '4' => $data->divisa,
//            '5' => $valr->vlr_total,
            '5' => $total_factura,
            '6' => $data->divisa,
            '7' => ($valr->vlr_bruto + $spa - $valr->vlr_desc) + $tim_2,
            '8' => $data->divisa,
            '9' => '0', //$valr->vlr_desc,
            '10' => $data->divisa,
            '11' => '0', // total mas cargos
            '12' => $data->divisa,
            '13' => '0',
            '14' => $data->divisa,
        );
        foreach ($array_tot as $key => $value) {
            xml_add_child($tot, 'TOT_' . $key, $value);
        }

        $tim = xml_add_child($RowBill, 'TIM');

        $array_tim = array(
            '1' => 'false',
            '2' => ($tim_2 > 0) ? $tim_2 : '0',
            '3' => $data->divisa,
        );
        foreach ($array_tim as $key => $value) {
            xml_add_child($tim, 'TIM_' . $key, $value);
        }

        $imp = xml_add_child($tim, 'IMP');
        $im = explode(',', $data->impuestos_emisor);


        $array_imp = array(
            '1' => explode('-', $im[0])[0],
            '2' => $valr->imp_iva, //$valr->vlr_subtotal_medios,
            '3' => $data->divisa,
            '4' => ($valr->vlr_iva > 0) ? $valr->vlr_iva : '0', //$valr->vlr_iva,
            '5' => $data->divisa,
            '6' => ($valr->vlr_iva > 0) ? $data->tarifa_impuesto : '0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }

//        $imp = xml_add_child($tim, 'IMP');
//        $array_imp = array(
//            '1' => explode('-', $im[0])[0],
//            '2' => $valr->imp_sin_iva, //$valr->vlr_subtotal_medios,
//            '3' => $data->divisa,
//            '4' => '0',
//            '5' => $data->divisa,
//            '6' => '0',
//        );
//        foreach ($array_imp as $key => $value) {
//            xml_add_child($imp, 'IMP_' . $key, $value);
//        }
//        if ($valr->vlr_ivaspa > 0) {
        $imp = xml_add_child($tim, 'IMP');
        $array_imp = array(
            '1' => '01',
            '2' => '' . $spa,
            '3' => $data->divisa,
            '4' => ($valr->vlr_ivaspa > 0) ? $valr->vlr_ivaspa : '0',
            '5' => $data->divisa,
            '6' => ($valr->vlr_ivaspa > 0) ? $data->tarifa_impuesto : '0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }
//        }

        $drf = xml_add_child($RowBill, 'DRF');
        $array_drf = array(
            '1' => $resolucion->numero,
            '2' => $resolucion->resol_fecha,
            '3' => $resolucion->resol_fechavencimiento,
            '4' => $resolucion->prefijo,
            '5' => $resolucion->inicio,
            '6' => $resolucion->fin,
        );
        foreach ($array_drf as $key => $value) {
            xml_add_child($drf, 'DRF_' . $key, $value);
        }

        $array_note = array(
            '1.-SONOVISTA PUBLICIDAD S.A. \n\n' . $resolucion->resol_texto,
            '2.-Efectuar el ' . $info->factura_retefuente . '% de Retención en la fuente sobre ' . number_format($spa, 0, ",", "."),
            '4.-LA FIRMA DEL COMPRADOR O CUALQUIER OTRA PERSONA QUE FORME PARTE DE LA EMPRESA DEL COMPRADOR EN LA PRESENTE FACTURA, ES PRUEBA DE QUE EL COMPRADOR CONOCE ESTAS CONDICIONES Y A ELLAS SE SOMETE INCONDICIONALMENTE',
            '5.-La presente Factura Cambiaria de Compraventa se asimila para todos sus efectos legales a la letra de cambio (Art. 774 y 671 C. de Co.) la cual pagaremos a SONOVISTA PUBLICIDAD S.A. excusado el protesto. En caso de mora, pagaremos intereses de 1.5% mensual, sin prejuicio de las acciones legales del acreedor. Por haberse recibido a satisfación la entrega real y material de las mercancías vendidas, aceptamos esta factura en la forma y términos del libramento.',
            '6.-' . $info->factura_formapago . '|' . $this->monedaletras->ValorEnLetras($total_factura, 'pesos') . '|||' . $info->factura_detalle,
            '7.-www.sonovista.co|' . $info->campana,
            '12.-' . $valr->vlr_bruto . '|' . ($valr->vlr_subtotal_medios + $valr->vlr_iva) . '|' . $valr->vlr_subtotal_medios.'|'.$valr->vlr_desc
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
        
        $ppto = $this->M_Bill->GetPptoT($p->ppto);
        if(empty($info->orden_servicio)){
            $arrayOrc = array();
            foreach ($detail['result'] as $p) {
                if ($ppto->orden > 0) {
                    if (!in_array($ppto->orden, $arrayOrc)) {
                        $arrayOrc[] = $ppto->orden;
                        $orc = xml_add_child($RowBill, 'ORC');
                        xml_add_child($orc, 'ORC_1', $ppto->orden);
                    }
                    break;
                }
            }
        }else{
            $orc = xml_add_child($RowBill, 'ORC');
            xml_add_child($orc, 'ORC_1', $info->orden_servicio);
        }

        $cts = xml_add_child($RowBill, 'CTS');
        xml_add_child($cts, 'CTS_1', $data->plantilla);

        $cont = 1;
        foreach ($detail['result'] as $p) {

            $infoPpto = $this->M_Bill->GetCabPpto($p->ppto, $p->modulo_id);

            if ($p->id_producto == 473):
                $p->producto = 'PyP';
            elseif ($p->id_producto == 659 || $p->id_producto == 859):
                $p->producto = 'Act Nacional';
            endif;

            if ($p->tpo_presup != 'interna') {
                $ite_11 = 'EXTERNA|' . $p->tipo_servicio . '|' . ucwords(strtolower(str_replace('&', '&amp;', $p->proveedor))) . ' - ' . $p->nit_proveedor . '|' . ucwords(strtolower($p->producto)) . '|' . $p->ppto;
                $valor_bruto_item = $p->vlr_bruto;
                $sub_total_item = $p->vlr_bruto - $p->vlr_desc;
                $descuento = $p->vlr_desc;
                $tributo = $p->vlr_iva; // + $p->vlr_ivaspa;
                $base_spa = $p->vlr_spa;
            } else {
                $ite_11 = 'INTERNA|' . $p->tipo_servicio . '|Sonovista Publicidad S.A - 890101778|' . ucwords(strtolower($p->producto)) . '|' . $p->ppto;
                $valor_bruto_item = $p->vlr_spa_interna; 
                $sub_total_item = $p->vlr_subtotal_interna;
                $descuento = $p->vlr_desc_interna;
                $tributo = $p->vlr_ivaspa;
                $base_spa = $p->vlr_subtotal_interna; //$p->vlr_spa_interna;
            }

            $total_item = ($valor_bruto_item - $descuento) + $tributo;

            $ite = xml_add_child($RowBill, 'ITE');
            xml_add_child($ite, 'ITE_1', $cont);
            xml_add_child($ite, 'ITE_3', 1);
            xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
            xml_add_child($ite, 'ITE_5', $valor_bruto_item - $descuento);
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
                '1' => $p->cebe, //$data->codigo_producto,
                '2' => '999', //$data->codigo_estandar_scheme,
//                '3' => $data->id_scheme
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

            if ($tributo > 0) {
                $iim_iva = ($valor_bruto_item - $descuento) * ($infoPpto->iva / 100);
                $iim_iva = ($iim_iva > 0) ? $iim_iva : '0';
            } else {
                $iim_iva = '0';
            }

//            $iim_spa_iva = ($valor_bruto_item - $descuento) * ($infoPpto->iva_spa / 100);
            $iim_spa_iva = $base_spa * ($infoPpto->iva_spa / 100);
            $iim_spa_iva = ($iim_spa_iva > 0) ? $iim_spa_iva : '0';

            if ($p->tpo_presup != 'interna') {
                $tii_1 = $iim_iva;
            } else {
                $tii_1 = $iim_spa_iva;
            }

            $tii = xml_add_child($ite, 'TII');
            $array_tii = array(
                '1' => $tii_1,
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
                    '2' => $iim_iva, //$p->vlr_iva,
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
                    '2' => $iim_spa_iva, //$p->vlr_ivaspa,
                    '3' => $data->divisa,
                    '4' => $base_spa,
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
                $total_item = $valor_bruto_item + $p->vlr_ivaspa;

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

//                $ide = xml_add_child($ite, 'IDE');
//                $array_ide = array(
//                    '1' => 'false',
//                    '2' => '0',
//                    '3' => $data->divisa,
//                    '6' => '0',
//                    '7' => $valor_bruto_item,
//                    '8' => $data->divisa,
//                    '10' => '1',
//                );
//                foreach ($array_ide as $key => $value) {
//                    xml_add_child($ide, 'IDE_' . $key, $value);
//                }

                $tii = xml_add_child($ite, 'TII');
                $array_tii = array(
                    '1' => $p->vlr_ivaspa,
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
                    '2' => $p->vlr_ivaspa,
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

        $file_xml = 'FV_' . $bill . '_' . date("Ymd") . '.xml';

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
                $data = array('est_id' => 44);
                $this->M_Bill->UpdateBill($bill, $data);
                echo json_encode(array('res' => 'OK'));
            } catch (\Exception $e) {
                fclose($sftpStream);
                echo json_encode(array('res' => 'ERROR'));
            }
        } else {
            header("Content-Disposition: attachment; filename=" . $file_xml);
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($ruta));

            readfile($ruta);
        }
        unlink($ruta);
    }
    
    function GenerateXml($bill, $send = false) {

        $this->load->helper('xml_helper');
        $this->load->library('MonedaLetras');

        $dom = xml_dom();

        $data = $this->M_Bill->InfoDataBilling();
        $info = $this->M_Bill->InfoBill($bill);
        $valr = $this->M_Bill->InfoValues($bill);
        $detail = $this->M_Bill->ListaDetailBill($bill);
        $row_cliente = $this->M_Bill->ListarClientesNew($info->id_cliente);
        $resolucion = $this->M_Bill->getResolution($info->resol_id);
//        $resolucion = $this->M_Bill->getResolution(3);

        $RowBill = xml_add_child($dom, 'FACTURA');

        $enc = xml_add_child($RowBill, 'ENC');

        $fecha_pago = strtotime('+30 day', strtotime($info->factura_impresion));
        $fecha_pago = date('Y-m-d', $fecha_pago);

        $tipo_operacion = '10';
        $imp_All = 0;
        
        $iva_cal = 0;
        $iva_spa_cal = 0;
        $base_iva = 0;
        $base_iva_spa = 0;
        foreach ($detail['result'] as $p) {
            if ($p->tpo_presup != 'interna') {
                $tipo_operacion = '11';
//                break;
                $imp_All += $p->vlr_iva;
                $base = $p->vlr_spa;
            } else {
                $base = $p->vlr_spa_interna;
                $imp_All += $p->vlr_ivaspa;
            }

            if ($p->tpo_presup != 'interna' && $base > 0) {
                $imp_All += $p->vlr_ivaspa;
            }
            
            $iva_cal += $p->vlr_iva;
            $iva_spa_cal += $p->vlr_ivaspa;
            
            $base_iva += ($p->vlr_iva > 0)?($p->vlr_bruto - $p->vlr_desc) : 0;
            $base_iva_spa += ($p->vlr_ivaspa > 0)?($p->vlr_spa - $p->vlr_desc_interna) : 0;
        }
        
        $valr->vlr_iva = ($iva_cal > 0) ? $iva_cal : 0;
        $valr->vlr_ivaspa = ($iva_spa_cal > 0) ? $iva_spa_cal : 0;

        $array_enc = array('1' => 'INVOIC'
            , '2' => $data->nit
            , '3' => $row_cliente->documento
            , '4' => $data->version_ubl
            , '5' => $data->version_dian
            , '6' => 'E' . $bill
//            , '6' => 'SETT' . $bill
            , '7' => $info->factura_impresion
            , '8' => $info->factura_hora . '-05:00'
            , '9' => '01'
            , '10' => $data->divisa
            , '15' => $detail['num'] + $this->M_Bill->OtherLines($bill)->count
            , '16' => $fecha_pago
            , '20' => $data->ambiente
//            , '20' => 2
            , '21' => $tipo_operacion
        );

        foreach ($array_enc as $key => $value) {
            xml_add_child($enc, 'ENC_' . $key, $value);
        }



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

        $code_dpto = $this->M_Bill->InfoDpto($row_cliente->departamento)->codigo;
        $code_city = $this->M_Bill->InfoCity($row_cliente->ciudad, $code_dpto)->codigo;
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

        $array_adq['10'] = $row_cliente->direccion;
        $array_adq['11'] = (empty($row_cliente->departamento)) ? '' : $code_dpto;
        $array_adq['13'] = $row_cliente->ciudad;
        $array_adq['15'] = $row_cliente->pais;
        $array_adq['19'] = $row_cliente->departamento;
        $array_adq['21'] = 'COLOMBIA';
        $array_adq['22'] = ''.$digito_cliente;
        $array_adq['23'] = $code_city;

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




        $spa = $valr->vlr_spa + $valr->vlr_subtotal_interna;
        $total_bruto = $valr->vlr_bruto + $spa;


        
        $tim_2 = $valr->vlr_iva + $valr->vlr_ivaspa;

        $total_factura = ($valr->vlr_bruto - $valr->vlr_desc) + $valr->vlr_iva + $valr->vlr_ivaspa + $spa;

        $tot = xml_add_child($RowBill, 'TOT');
        $array_tot = array(
            '1' => $valr->vlr_bruto + $spa - $valr->vlr_desc,
            '2' => $data->divisa,
            '3' => $valr->vlr_bruto + $spa - $valr->vlr_desc,
            '4' => $data->divisa,
//            '5' => $valr->vlr_total,
            '5' => $total_factura,
            '6' => $data->divisa,
            '7' => ($valr->vlr_bruto + $spa - $valr->vlr_desc) + $tim_2,
            '8' => $data->divisa,
            '9' => '0', //$valr->vlr_desc,
            '10' => $data->divisa,
            '11' => '0', // total mas cargos
            '12' => $data->divisa,
            '13' => '0',
            '14' => $data->divisa,
        );
        foreach ($array_tot as $key => $value) {
            xml_add_child($tot, 'TOT_' . $key, $value);
        }

        $tim = xml_add_child($RowBill, 'TIM');

        $array_tim = array(
            '1' => 'false',
            '2' => ($tim_2 > 0) ? $tim_2 : '0',
            '3' => $data->divisa,
        );
        foreach ($array_tim as $key => $value) {
            xml_add_child($tim, 'TIM_' . $key, $value);
        }

        $imp = xml_add_child($tim, 'IMP');
        $im = explode(',', $data->impuestos_emisor);


        $array_imp = array(
            '1' => explode('-', $im[0])[0],
//            '2' => $valr->imp_iva, //$valr->vlr_subtotal_medios,
            '2' => '' . $base_iva, //$valr->vlr_subtotal_medios,
            '3' => $data->divisa,
            '4' => ($valr->vlr_iva > 0) ? $valr->vlr_iva : '0', //$valr->vlr_iva,
            '5' => $data->divisa,
            '6' => ($valr->vlr_iva > 0) ? $data->tarifa_impuesto : '0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }


        $imp = xml_add_child($tim, 'IMP');
        $array_imp = array(
            '1' => '01',
            '2' => '' . $base_iva_spa,
            '3' => $data->divisa,
            '4' => ($valr->vlr_ivaspa > 0) ? $valr->vlr_ivaspa : '0',
            '5' => $data->divisa,
            '6' => ($valr->vlr_ivaspa > 0) ? $data->tarifa_impuesto : '0.00',
        );
        foreach ($array_imp as $key => $value) {
            xml_add_child($imp, 'IMP_' . $key, $value);
        }

        $drf = xml_add_child($RowBill, 'DRF');
        $array_drf = array(
            '1' => $resolucion->numero,
            '2' => $resolucion->resol_fecha,
            '3' => $resolucion->resol_fechavencimiento,
            '4' => $resolucion->prefijo,
            '5' => $resolucion->inicio,
            '6' => $resolucion->fin,
        );
        foreach ($array_drf as $key => $value) {
            xml_add_child($drf, 'DRF_' . $key, $value);
        }

        $array_note = array(
            '1.-SONOVISTA PUBLICIDAD S.A. \n\n' . $resolucion->resol_texto,
            '2.-Efectuar el ' . $info->factura_retefuente . '% de Retención en la fuente sobre ' . number_format($spa, 0, ",", "."),
            '4.-LA FIRMA DEL COMPRADOR O CUALQUIER OTRA PERSONA QUE FORME PARTE DE LA EMPRESA DEL COMPRADOR EN LA PRESENTE FACTURA, ES PRUEBA DE QUE EL COMPRADOR CONOCE ESTAS CONDICIONES Y A ELLAS SE SOMETE INCONDICIONALMENTE',
            '5.-La presente Factura Cambiaria de Compraventa se asimila para todos sus efectos legales a la letra de cambio (Art. 774 y 671 C. de Co.) la cual pagaremos a SONOVISTA PUBLICIDAD S.A. excusado el protesto. En caso de mora, pagaremos intereses de 1.5% mensual, sin prejuicio de las acciones legales del acreedor. Por haberse recibido a satisfación la entrega real y material de las mercancías vendidas, aceptamos esta factura en la forma y términos del libramento.',
            '6.-' . $info->factura_formapago . '|' . $this->monedaletras->ValorEnLetras($total_factura, 'pesos') . '|||' . $info->factura_detalle,
            '7.-www.sonovista.co|' . $info->campana,
            '12.-' . $valr->vlr_bruto . '|' . ($valr->vlr_subtotal_medios + $valr->vlr_iva) . '|' . $valr->vlr_subtotal_medios.'|'.$valr->vlr_desc
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
        
        $ppto = $this->M_Bill->GetPptoT($p->ppto);
        if(empty($info->orden_servicio)){
            $arrayOrc = array();
            foreach ($detail['result'] as $p) {
                if ($ppto->orden > 0) {
                    if (!in_array($ppto->orden, $arrayOrc)) {
                        $arrayOrc[] = $ppto->orden;
                        $orc = xml_add_child($RowBill, 'ORC');
                        xml_add_child($orc, 'ORC_1', $ppto->orden);
                    }
                    break;
                }
            }
        }else{
            $orc = xml_add_child($RowBill, 'ORC');
            xml_add_child($orc, 'ORC_1', $info->orden_servicio);
        }

        $cts = xml_add_child($RowBill, 'CTS');
        xml_add_child($cts, 'CTS_1', $data->plantilla);

        $cont = 1;
        foreach ($detail['result'] as $p) {

            $infoPpto = $this->M_Bill->GetCabPpto($p->ppto, $p->modulo_id);

            if ($p->id_producto == 473):
                $p->producto = 'PyP';
            elseif ($p->id_producto == 659 || $p->id_producto == 859):
                $p->producto = 'Act Nacional';
            endif;

            if ($p->tpo_presup != 'interna') {
                $ite_11 = 'EXTERNA|' . $p->tipo_servicio . '|' . ucwords(strtolower(str_replace('&', '&amp;', $p->proveedor))) . ' - ' . $p->nit_proveedor . '|' . ucwords(strtolower($p->producto)) . '|' . $p->ppto;
                $valor_bruto_item = $p->vlr_bruto;
                $sub_total_item = $p->vlr_bruto - $p->vlr_desc;
                $descuento = $p->vlr_desc;
                $tributo = $p->vlr_iva; // + $p->vlr_ivaspa;
                $base_spa = $p->vlr_spa;
            } else {
                $ite_11 = 'INTERNA|' . $p->tipo_servicio . '|Sonovista Publicidad S.A - 890101778|' . ucwords(strtolower($p->producto)) . '|' . $p->ppto;
                $valor_bruto_item = $p->vlr_spa_interna; 
                $sub_total_item = $p->vlr_subtotal_interna;
                $descuento = $p->vlr_desc_interna;
                $tributo = $p->vlr_ivaspa;
                $base_spa = $p->vlr_subtotal_interna; //$p->vlr_spa_interna;
            }

            $total_item = ($valor_bruto_item - $descuento) + $tributo;

            $ite = xml_add_child($RowBill, 'ITE');
            xml_add_child($ite, 'ITE_1', $cont);
            xml_add_child($ite, 'ITE_3', 1);
            xml_add_child($ite, 'ITE_4', $data->codigo_unidad);
            xml_add_child($ite, 'ITE_5', $valor_bruto_item - $descuento);
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
                '1' => $p->cebe, //$data->codigo_producto,
                '2' => '999', //$data->codigo_estandar_scheme,
//                '3' => $data->id_scheme
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

            if ($tributo > 0) {
                $iim_iva = ($valor_bruto_item - $descuento) * ($infoPpto->iva / 100);
                $iim_iva = ($iim_iva > 0) ? $iim_iva : '0';
            } else {
                $iim_iva = '0';
            }

//            $iim_spa_iva = ($valor_bruto_item - $descuento) * ($infoPpto->iva_spa / 100);
            $iim_spa_iva = $base_spa * ($infoPpto->iva_spa / 100);
            $iim_spa_iva = ($iim_spa_iva > 0) ? $iim_spa_iva : '0';

            if ($p->tpo_presup != 'interna') {
                $tii_1 = $iim_iva;
            } else {
                $tii_1 = $iim_spa_iva;
            }

            $tii = xml_add_child($ite, 'TII');
            $array_tii = array(
                '1' => $tii_1,
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
                    '2' => $iim_iva, //$p->vlr_iva,
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
                    '2' => $iim_spa_iva, //$p->vlr_ivaspa,
                    '3' => $data->divisa,
                    '4' => $base_spa,
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
                $total_item = $valor_bruto_item + $p->vlr_ivaspa;

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

//                $ide = xml_add_child($ite, 'IDE');
//                $array_ide = array(
//                    '1' => 'false',
//                    '2' => '0',
//                    '3' => $data->divisa,
//                    '6' => '0',
//                    '7' => $valor_bruto_item,
//                    '8' => $data->divisa,
//                    '10' => '1',
//                );
//                foreach ($array_ide as $key => $value) {
//                    xml_add_child($ide, 'IDE_' . $key, $value);
//                }

                $tii = xml_add_child($ite, 'TII');
                $array_tii = array(
                    '1' => $p->vlr_ivaspa,
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
                    '2' => $p->vlr_ivaspa,
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

        $file_xml = 'FV_SETT' . $bill . '.xml';

        $ruta = dirname(__FILE__) . '/../../../xml/Bill/' . $file_xml;
        
        xml_save($dom, $ruta);

        $dstFile = '/INVOICE/LAB/890101778/890101778_01/IN/' . $file_xml;
        
        if ($send) {
            
            $host = 'sftpebz.cen.biz';
            $port = 220;
            $user = 'sonopublisa_feco';
            $pass = 'S0n0pu61is4+fe';
            
//            $host = 'sftp-piloto.cen.biz';
//            $pass = 'S0n0pu61is4+fe';
            
            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $user, $pass);
            $sftp = ssh2_sftp($connection);
            
            $rAdj = $this->M_Bill->SelectAdjunto($bill);
            
            if($rAdj['num'] > 0){
                $zipContent = new ZipArchive();
                $zip = new ZipArchive();
                
                $subZip = dirname(__FILE__) . "/../../../Adjuntos/FACTURAS/".$bill."/FV_ADJ".$bill.".zip";
                $contZip = dirname(__FILE__) . "/../../../Adjuntos/FACTURAS/".$bill."/FV_SETT".$bill.".zip";
                $nameZip = "FV_SETT".$bill.".zip";
                
                $zipContent->open($contZip,ZipArchive::CREATE);
                $zip->open($subZip,ZipArchive::CREATE);
               
                foreach ($rAdj['result'] as $v) {
                    $zip->addFile(dirname(__FILE__) . '/../../../Adjuntos/FACTURAS/'.$bill.'/'.$v->name,$v->name);
                }
                $zip->close();
                
                $zipContent->addFile($ruta,$file_xml);
                $zipContent->addFile($subZip,"FV_SETT".$bill.".zip");
                
                $zipContent->close();
                

                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $nameZip, "w");

                if (!$sftpStream) {
                    throw new \Exception('Could not open remote file: ' . $dstFile);
                }
                try {
                    $data_to_send = file_get_contents($contZip);
                    fwrite($sftpStream, $data_to_send);
                    fclose($sftpStream);
                    $data = array('est_id' => 44);
                    $this->M_Bill->UpdateBill($bill, $data);
                    echo json_encode(array('res' => 'OK'));
                } catch (\Exception $e) {
                    fclose($sftpStream);
                    echo json_encode(array('res' => 'ERROR'));
                }
            }else{
                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $file_xml, "w");
//                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/LAB/890101778/890101778_01/IN/" . $file_xml, "w");
                if (!$sftpStream) {
                    throw new \Exception('Could not open remote file: ' . $dstFile);
                }
                try {
                    $data_to_send = file_get_contents($ruta);
                    fwrite($sftpStream, $data_to_send);
                    fclose($sftpStream);
                    $data = array('est_id' => 44);
                    $this->M_Bill->UpdateBill($bill, $data);
                    echo json_encode(array('res' => 'OK'));
                } catch (\Exception $e) {
                    fclose($sftpStream);
                    echo json_encode(array('res' => 'ERROR'));
                }
            }
            
            
            
            if($rAdj['num'] > 0){
                unlink($subZip);
                unlink($contZip);
            }
            
        } else {
            header("Content-Disposition: attachment; filename=" . $file_xml);
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($ruta));

            readfile($ruta);
        }
        unlink($ruta);
    }
    
    function Piloto($bill, $send = false) {

        $file_xml = 'FV_SETT303649.xml';

        $ruta = dirname(__FILE__) . '/../../../xml/Bill/' . $file_xml;
        
//        xml_save($dom, $ruta);

        $dstFile = '/INVOICE/LAB/890101778/890101778_01/IN/' . $file_xml;
        
        if ($send) {
            
//            $host = 'sftpebz.cen.biz';
//            $pass = 'S0n0pu61is4+fe';
            $port = 220;
            $user = 'sonopublisa_feco';
            
            $host = 'sftp-piloto.cen.biz';
            $pass = 'S0n0pu61is4+fe';
            
            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $user, $pass);
            $sftp = ssh2_sftp($connection);
            
            $rAdj = $this->M_Bill->SelectAdjunto($bill);
            
            if($rAdj['num'] > 0){
                $zipContent = new ZipArchive();
                $zip = new ZipArchive();
                
                $subZip = dirname(__FILE__) . "/../../../Adjuntos/FACTURAS/".$bill."/FV_ADJ".$bill.".zip";
                $contZip = dirname(__FILE__) . "/../../../Adjuntos/FACTURAS/".$bill."/FV_SETT".$bill.".zip";
                $nameZip = "FV_SETT".$bill.".zip";
                
                $zipContent->open($contZip,ZipArchive::CREATE);
                $zip->open($subZip,ZipArchive::CREATE);
               
                foreach ($rAdj['result'] as $v) {
                    $zip->addFile(dirname(__FILE__) . '/../../../Adjuntos/FACTURAS/'.$bill.'/'.$v->name,$v->name);
                }
                $zip->close();
                
                $zipContent->addFile($ruta,$file_xml);
                $zipContent->addFile($subZip,"FV_SETT".$bill.".zip");
                
                $zipContent->close();
                

//                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $nameZip, "w");
                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/LAB/890101778/890101778_01/IN/" . $nameZip, "w");

                if (!$sftpStream) {
                    throw new \Exception('Could not open remote file: ' . $dstFile);
                }
                try {
                    $data_to_send = file_get_contents($contZip);
                    fwrite($sftpStream, $data_to_send);
                    fclose($sftpStream);
                    $data = array('est_id' => 44);
//                    $this->M_Bill->UpdateBill($bill, $data);
                    echo json_encode(array('res' => 'OK'));
                } catch (\Exception $e) {
                    fclose($sftpStream);
                    echo json_encode(array('res' => 'ERROR'));
                }
            }else{
//                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/PRODUCCION/890101778/890101778_01/IN/" . $file_xml, "w");
                $sftpStream = fopen("ssh2.sftp://$sftp/INVOICE/LAB/890101778/890101778_01/IN/" . $file_xml, "w");
                if (!$sftpStream) {
                    throw new \Exception('Could not open remote file: ' . $dstFile);
                }
                try {
                    $data_to_send = file_get_contents($ruta);
                    fwrite($sftpStream, $data_to_send);
                    fclose($sftpStream);
                    $data = array('est_id' => 44);
//                    $this->M_Bill->UpdateBill($bill, $data);
                    echo json_encode(array('res' => 'OK'));
                } catch (\Exception $e) {
                    fclose($sftpStream);
                    echo json_encode(array('res' => 'ERROR'));
                }
            }
            
            
            
//            if($rAdj['num'] > 0){
//                unlink($subZip);
//                unlink($contZip);
//            }
            
        } else {
            header("Content-Disposition: attachment; filename=" . $file_xml);
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($ruta));

            readfile($ruta);
        }
//        unlink($ruta);
    }
}
