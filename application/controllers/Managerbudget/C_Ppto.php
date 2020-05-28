<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Ppto extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Managerbudget/M_Manager');
    }

    public function GetList($type) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data = array('table' => $type);

        if ($type == '1') {
            foreach ($this->M_Manager->LoadButtonPermissions("AVISO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE PRENSA';
        } elseif ($type == '2') {
            foreach ($this->M_Manager->LoadButtonPermissions("CLASIFICADO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE CLASIFICADO';
        } elseif ($type == '3') {
            foreach ($this->M_Manager->LoadButtonPermissions("REVISTA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE REVISTA';
        } elseif ($type == '4') {
            foreach ($this->M_Manager->LoadButtonPermissions("RADIO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE RADIO';
        } elseif ($type == '5') {
            foreach ($this->M_Manager->LoadButtonPermissions("TV") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE TELEVISIÓN';
        } elseif ($type == '6') {
            foreach ($this->M_Manager->LoadButtonPermissions("EXTERNA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE PRODUCCIÓN EXTERNA';
        } elseif ($type == '7') {
            foreach ($this->M_Manager->LoadButtonPermissions("INTERNA") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE PRODUCCIÓN INTERNA';
        } elseif ($type == '8') {
            foreach ($this->M_Manager->LoadButtonPermissions("EXTERIOR") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE PUBLICIDAD EXTERIOR';
        } elseif ($type == '9') {
            foreach ($this->M_Manager->LoadButtonPermissions("IMPRESO") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE IMPRESO';
        } elseif ($type == '10') {
            foreach ($this->M_Manager->LoadButtonPermissions("ARTICULOS") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['tittle'] = 'PRESUPUESTO DE ARTICULOS PUBLICITARIOS';
        }

        $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();

        if ($type == 4)
            $data['pptos'] = $this->M_Manager->GetPptoCompleteInfo(false, false, $type, 'all', date('Y') . '-01-01', date('Y-m-d'), 'all');

        $this->load->view('Managerbudget/Ppto/Interna/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, MOMENT, RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Edit($id, $tipo, $pre_order = false) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);
        if ($tipo == 5) {
            $Header['array_css'][] = FILER_CSS;
        }
        $this->load->view('Template/V_Header', $Header);

        $data['id'] = $id;
        $data['tipo'] = $tipo;
        $data['pre_order'] = $pre_order;
        
        switch ($tipo) {
            case 1:
                $folder = 'Aviso';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['paginas'] = $this->M_Manager->select('cat_paginaperiod', 'pagina_nombre');
                $data['tintas'] = $this->M_Manager->select('cat_tintas', 'tinta_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'aviso',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden Prensa N&deg;':'Presupuesto De Prensa N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_aviso':'presup_avisos';
                break;
            case 2:
                $folder = 'Clasificado';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'clasificado',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Clasificado N&deg;':'Presupuesto De Clasificado N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_clasificado':'presup_clasificados';
                break;
            case 3:
                $folder = 'Revista';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['tintas'] = $this->M_Manager->select('cat_tintas', 'tinta_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'revista',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Revista N&deg;':'Presupuesto De Revista N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_revista':'presup_revis';
                break;
            case 4:
                $folder = 'Radio';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['emisoras'] = $this->M_Manager->select('cat_emisoras', 'emis_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'radio',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Radio N&deg;':'Presupuesto De Radio N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_radio':'presup_radio';
                break;
            case 5:
                $folder = 'Tv';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'television',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De TV N&deg;':'Presupuesto De TV N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_tv':'presup_tv';
                break;
            case 6:
                $folder = 'Externa';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'externa',$pre_order);
                $data['ordenes'] = $this->M_Manager->ListOrdCostoExt($tipo, $data['row']->servicio);
                $data['title'] = ($pre_order)?'Pre Orden De Externa N&deg;':'Presupuesto De Externa N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_externa':'presup_prode';
                break;
            case 7:
                $folder = 'Interna';
                $data['ordenes'] = $this->M_Manager->ListOrdCosto($tipo);
                $data['title'] = ($pre_order)?'Pre Orden De Interna N&deg;':'Presupuesto De Interna N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_interna':'presup_prodi';
                break;
            case 8:
                $folder = 'Exterior';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['piezas'] = $this->M_Manager->select('cat_piezas', 'pieza_nombre');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'publicidad_exterior',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Publ.Exterior N&deg;':'Presupuesto De Publ.Exterior N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_exterior':'publicidad_exterior';
                break;
            case 9:
                $folder = 'Impreso';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['elementos'] = $this->M_Manager->select('cat_elementos', 'elem_nombre');
                $data['conceptos'] = $this->M_Manager->select('cat_concepto', 'concp_nmb');
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'impresos',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Impreso N&deg;':'Presupuesto De Impreso N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_impreso':'impresos';
                break;
            case 10:
                $folder = 'Articulo';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['orden'] = $this->M_Manager->GetOrdenPpto($id, 'articulos_publicitarios',$pre_order);
                $data['title'] = ($pre_order)?'Pre Orden De Articulos Public. N&deg;':'Presupuesto De Articulos Public. N&deg;';
                $data['tabla'] = ($pre_order)?'pre_orden_articulo':'art_publi';
                break;

            default:
                break;
        }
        
        $data['row'] = $this->M_Manager->GetPpto($id, $tipo, $data['tabla']);
        $data['clientes'] = $this->M_Manager->ListarClientesNew();

        $data['campanas'] = $this->M_Manager->ListarCampana($data['row']->cliente);
        $data['rubros'] = $this->M_Manager->ListarRubro($data['row']->cliente);
        $data['servicios'] = $this->M_Manager->CargarTipoServicio($tipo);

        $detail = $this->M_Manager->ListDetailPpto($id, $tipo, $pre_order);

        $data['detail'] = $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Table_Detail', array('detail' => $detail), true);
        $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Form_Update', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);
        if ($tipo == 5) {
            $Footer['array_js'][] = FILER_JS;
        }
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function NewP($tipo,$pre_order = false) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, SELECT2_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS);
        if ($tipo == 5) {
            $Header['array_css'][] = FILER_CSS;
        }
        $this->load->view('Template/V_Header', $Header);


        $data['tipo'] = $tipo;
        $data['pre_order'] = $pre_order;

        $data['clientes'] = $this->M_Manager->ListarClientesNew(false, true);
        $data['servicios'] = $this->M_Manager->CargarTipoServicio($tipo);

        switch ($tipo) {
            case 1:
                $folder = 'Aviso';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['paginas'] = $this->M_Manager->select('cat_paginaperiod', 'pagina_nombre');
                $data['tintas'] = $this->M_Manager->select('cat_tintas', 'tinta_nombre');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Prensa':'Nuevo Presupuesto De Prensa';
                $data['tabla'] = ($pre_order)?'pre_orden_aviso':'presup_avisos';
                break;
            case 2:
                $folder = 'Clasificado';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Clasificado':'Nuevo Presupuesto De Clasificado';
                $data['tabla'] = ($pre_order)?'pre_orden_clasificado':'presup_clasificados';
                break;
            case 3:
                $folder = 'Revista';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['tintas'] = $this->M_Manager->select('cat_tintas', 'tinta_nombre');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Revista':'Nuevo Presupuesto De Revista';
                $data['tabla'] = ($pre_order)?'pre_orden_revista':'presup_revis';
                break;
            case 4:
                $folder = 'Radio';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['emisoras'] = $this->M_Manager->select('cat_emisoras', 'emis_nombre');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Radio':'Nuevo Presupuesto De Radio';
                $data['tabla'] = ($pre_order)?'pre_orden_radio':'presup_radio';
                break;
            case 5:
                $folder = 'Tv';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['medios'] = $this->M_Manager->select('cat_medios', 'medio_nombre');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De TV':'Nuevo Presupuesto De TV';
                $data['tabla'] = ($pre_order)?'pre_orden_tv':'presup_tv';
                break;
            case 6:
                $folder = 'Externa';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Externa':'Nuevo Presupuesto De Externa';
                $data['tabla'] = ($pre_order)?'pre_orden_externa':'presup_prode';
                break;
            case 7:
                $folder = 'Interna';
                $data['ordenes'] = $this->M_Manager->ListOrdCosto($tipo);
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Interna':'Nuevo Presupuesto De Interna';
                $data['tabla'] = ($pre_order)?'pre_orden_interna':'presup_prodi';
                break;
            case 8:
                $folder = 'Exterior';
                $data['piezas'] = $this->M_Manager->select('cat_piezas', 'pieza_nombre');
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Publ.Exterior':'Nuevo Presupuesto De Publ.Exterior';
                $data['tabla'] = ($pre_order)?'pre_orden_exterior':'publicidad_exterior';
                break;
            case 9:
                $folder = 'Impreso';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['elementos'] = $this->M_Manager->select('cat_elementos', 'elem_nombre');
                $data['conceptos'] = $this->M_Manager->select('cat_concepto', 'concp_nmb');
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Impreso':'Nuevo Presupuesto De Impreso';
                $data['tabla'] = ($pre_order)?'pre_orden_impreso':'impresos';
                break;
            case 10:
                $folder = 'Articulo';
                $data['proveedores'] = $this->M_Manager->ListarProveedoresNew();
                $data['title'] = ($pre_order)?'Nueva Pre Orden De Articulos Public.':'Nuevo Presupuesto De Articulos Public.';
                $data['tabla'] = ($pre_order)?'pre_orden_articulo':'art_publi';
                break;

            default:
                break;
        }


        $data['detail'] = $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Table_Detail', array('detail' => array()), true);
        $this->load->view('Managerbudget/Ppto/' . $folder . '/V_Form_New', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS, SELECT2_JS, SWEETALERT_JS, DATEPICKER_JS, AUTO_NUMERIC, TIMEPICKER_JS);
        if ($tipo == 5) {
            $Footer['array_js'][] = FILER_JS;
        }
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function GetListTable($tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor) {
        $rows = $this->M_Manager->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor);
        $rows2 = $this->M_Manager->GetPptoCompleteInfo(false, false, $tipo, $ppto, $fecha_ini, $fecha_fin, $proveedor);

        if ($tipo == '1') {
            $btns = $this->M_Manager->LoadButtonPermissions("AVISO");
        } else if ($tipo == '2') {
            $btns = $this->M_Manager->LoadButtonPermissions("CLASIFICADO");
        } else if ($tipo == '3') {
            $btns = $this->M_Manager->LoadButtonPermissions("REVISTA");
        } else if ($tipo == '4') {
            $btns = $this->M_Manager->LoadButtonPermissions("RADIO");
        } else if ($tipo == '5') {
            $btns = $this->M_Manager->LoadButtonPermissions("TV");
        } else if ($tipo == '6') {
            $btns = $this->M_Manager->LoadButtonPermissions("EXTERNA");
        } else if ($tipo == '7') {
            $btns = $this->M_Manager->LoadButtonPermissions("INTERNA");
        } else if ($tipo == '8') {
            $btns = $this->M_Manager->LoadButtonPermissions("EXTERIOR");
        } else if ($tipo == '9') {
            $btns = $this->M_Manager->LoadButtonPermissions("IMPRESO");
        } else if ($tipo == '10') {
            $btns = $this->M_Manager->LoadButtonPermissions("ARTICULOS");
        }

        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }

        $array = array();
        foreach ($rows['result'] as $v) {

            $btn = '<div class="btn-group btnI' . $v->id . '" order="' . $v->orden . '" >
                        <button  type="button" class="btn1-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs btn-left">' . $v->estado . '</button>
                            <button type="button" class="btn2-' . $v->id . ' btn btn-' . $v->est_color . ' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';

            $btn .= '<ul class="dropdown-menu u-' . $v->id . '" role="menu">';
            $btn .= '<li onclick="printPdf(' . $v->id . ',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            if ($tipo != '7') {
                $btn .= '<li onclick="printPdf(' . $v->id . ',1)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir Orden</a></li>';
            }
            $btn .= (isset($BtnEditPpto) && ($v->id_estado == 1 && $v->impresiones == -1)) ? '<li onclick="EditPpto(' . $v->id . ',' . $tipo . ')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>' : '';
            $btn .= (isset($BtnDupliPpto)) ? '<li onclick="copy(' . $v->id . ','.$v->pvcl_id_clie.','.$v->total.')"><a href="#"><i class="fa fa-fw fa-copy"></i> Duplicar</a></li>' : '';
            $btn .= (isset($BtnAddOrderPpto) && ($v->id_estado == 5 || $v->id_estado == 1 ) ) ? '<li onclick="addOrder(' . $v->id . ')" ><a href="#"><i class="fa fa-fw fa-plus"></i> Add Orden</a></li>' : '';
            $btn .= (isset($BtnAnulePpto) && (($v->id_estado == 1 && $v->impresiones == -1) || ($v->id_estado == 5))) ? '<li onclick="Anule(' . $v->id . ')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>' : '';
            $btn .= '</ul></div>';


            $array[] = array($v->id, $v->fecha, $v->cliente, $v->proveedor, $v->campana, explode(' ', $v->usuario)[0], $btn, number_format($v->total, 0, ',', '.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }

    function UpdatePrint() {
        if ($this->input->post('ord') != 1) {
            $this->M_Manager->UpdateStatusPpto($this->input->post('tipo'), $this->input->post('ppto'), $this->input->post('status'));
        } else {
            $this->M_Manager->UpdateNumOrder($this->input->post('ord_id'));
        }
    }

    function PrintPpto($ppto, $tipo, $ord = 0, $print = 1) {

        $result = $this->M_Manager->GetPptoCompleteInfo(false, false, $tipo, $ppto, 'all', 'all', 'all');
        $result['detail'] = $this->M_Manager->GetDetailPpto($tipo, $ppto);
        $result['bill'] = $this->M_Manager->GetBillPpto($ppto, $tipo);
        $result['tipo'] = $tipo;
        $result['print'] = $print;

        $result['printOrder'] = $ord;
        switch ($tipo) {
            case '1':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'aviso');

                $html = $this->load->view('Managerbudget/Ppto/Aviso/V_Pdf', $result);
                break;
            case '2':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'clasificado');

                $html = $this->load->view('Managerbudget/Ppto/Clasificado/V_Pdf', $result);
                break;
            case '3':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'revista');

                $html = $this->load->view('Managerbudget/Ppto/Revista/V_Pdf', $result);
                break;
            case '4':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'radio');

                $html = $this->load->view('Managerbudget/Ppto/Radio/V_Pdf', $result);
                break;
            case '5':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'television');

                $html = $this->load->view('Managerbudget/Ppto/Tv/V_Pdf', $result);
                break;
            case '6':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'externa');

                $html = $this->load->view('Managerbudget/Ppto/Externa/V_Pdf', $result);
                break;
            case '7':
                $html = $this->load->view('Managerbudget/Ppto/Interna/V_Pdf', $result);
                break;
            case '8':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'publicidad_exterior');

                $html = $this->load->view('Managerbudget/Ppto/Exterior/V_Pdf', $result);
                break;
            case '9':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'impresos');

                $html = $this->load->view('Managerbudget/Ppto/Impreso/V_Pdf', $result);
                break;
            case '10':
                $result['orden'] = $this->M_Manager->GetOrdenPpto($ppto, 'articulos_publicitarios');

                $html = $this->load->view('Managerbudget/Ppto/Articulo/V_Pdf', $result);
                break;

            default:
                break;
        }
    }

    function Anule() {
        $result = $this->M_Manager->UpdateStatusPpto($this->input->post('tipo'), $this->input->post('ppto'), $this->input->post('status'));
        echo json_encode(array('res' => $result));
    }

    function CopyMasive() {
        $array = explode(',', $this->input->post('pptos'));
        sort($array);
        $tipo = $this->input->post('tipo');
        $errors = '';
        
        $result = array('res'=>'empty');
        foreach ($array as $value) {
            
            $row = $this->M_Manager->GetPpto($value, $tipo);
            $validate = $this->ValidateCredit($row->cliente, false, $row->total);
            
            if ($validate['res'] != 'LOCKED') {
                $result = $this->M_Manager->Copy($tipo, $value);
            }else{
                if($errors != '')
                    $errors .= ',';
                    
                $errors .= $value;  
            }
                
        }
        $result['errors'] = $errors;
        echo json_encode($result);
    }

    function Copy() {
        $reverse = '';
        $total = $this->input->post('total');
        $validate = $this->ValidateCredit($this->input->post('cliente'), false, $total);
      
        if ($validate['res'] != 'LOCKED') {
            $result = $this->M_Manager->Copy($this->input->post('tipo'), $this->input->post('ppto'));
        }else{
            $result = $validate;
            $reverse = 'OK';
        }
        echo json_encode($result);
        
    }

    function AddOrder($id, $type, $order) {
        $result = $this->M_Manager->AddOrder($id, $type, $order);
        echo json_encode(array('res' => $result));
    }

    function LoadSelect() {
        $data['campanas'] = $this->M_Manager->ListarCampana($this->input->post('cliente'));
        $data['rubros'] = $this->M_Manager->ListarRubro($this->input->post('cliente'));
        echo json_encode($data);
    }

    function GetDetailOrdCosto() {
        $result = $this->M_Manager->GetDetailOrdCosto($this->input->post('orden'));
        echo json_encode($result);
    }

    function UpdateInfo() {

        $ppto = $this->input->post('ppto');
        $total = $this->input->post('total');
        $tipo = $this->input->post('tipo');

        if ($tipo != 7) {
            $this->M_Manager->UpdateOrder($this->input->post('ord_id'), array('pvcl_id_prov' => $this->input->post('pvcl_id_prov'),'ord_observacion' => $this->input->post('ord_observacion')));
            unset($_POST['ord_observacion']);
            unset($_POST['ord_id']);
        }

        unset($_POST['tipo']);
        unset($_POST['ppto']);
        unset($_POST['total']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psav_id';
                $table = 'presup_avisos';
                break;
            case 2:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'pscf_id';
                $table = 'presup_clasificados';
                break;
            case 3:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psrev_id';
                $table = 'presup_revis';
                break;
            case 4:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'psrad_id';
                $table = 'presup_radio';
                break;
            case 5:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'pstv_id';
                $table = 'presup_tv';
                break;
            case 6:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psex_id';
                $table = 'presup_prode';
                break;
            case 7:
                $_POST['usr_id_mod'] = $this->session->UserMedios;

                $field_id = 'psin_id';
                $table = 'presup_prodi';
                break;
            case 8:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'pubext_id';
                $table = 'publicidad_exterior';
                break;
            case 9:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'imp_id';
                $table = 'impresos';
                break;
            case 10:
                $_POST['usr_mod'] = $this->session->UserMedios;

                $field_id = 'artp_id';
                $table = 'art_publi';
                break;

            default:
                break;
        }

        $result = $this->M_Manager->UpdateInfo($field_id, $ppto, $table, $_POST);
        echo json_encode(array('res' => $result));
    }
    
    function InsertInfo() {

        $tipo = $this->input->post('tipo');
        $ord_observacion = '';
        if ($tipo != 7) {
            $ord_observacion = $this->input->post('ord_observacion');
            unset($_POST['ord_observacion']);
        }

        unset($_POST['tipo']);

        switch ($tipo) {
            case 1:
                $table = 'presup_avisos';
                break;
            case 2:
                $table = 'presup_clasificados';
                break;
            case 3:
                $table = 'presup_revis';
                break;
            case 4:
                $table = 'presup_radio';
                break;
            case 5:
                $table = 'presup_tv';
                break;
            case 6:
                $table = 'presup_prode';
                break;
            case 7:
                $table = 'presup_prodi';
                break;
            case 8:
                $table = 'publicidad_exterior';
                break;
            case 9:
                $table = 'impresos';
                break;
            case 10:
                $table = 'art_publi';
                break;

            default:
                break;
        }

        $result = $this->M_Manager->InsertInfo($table, $_POST, $ord_observacion);
        echo json_encode($result);
    }

    function InsertInfoMore() {

        $tipo = $this->input->post('tipo');
        $table = $this->input->post('tabla');
        $ord_observacion = '';
        if ($tipo != 7) {
            $ord_observacion = $this->input->post('ord_observacion');
            unset($_POST['ord_observacion']);
        }

        unset($_POST['tipo']);
        unset($_POST['tabla']);


        $result = $this->M_Manager->InsertInfo($table, $_POST, $ord_observacion);
        echo json_encode($result);
    }

    function AddDetail() {

        $tipo = $this->input->post('tipo');
        $valor = $this->input->post('valor');

        unset($_POST['tipo']);
        unset($_POST['valor']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $table = 'presup_avisos';
                $field_id = 'psav_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';
                $ppto = $this->input->post('psav_id');
                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                break;
            case 2:
                $table_det = 'det_clasi';
                $table = 'presup_clasificados';
                $field_id = 'pscf_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $ppto = $this->input->post('pscf_id');
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';
                break;
            case 3:
                $table_det = 'det_revis';
                $table = 'presup_revis';
                $field_id = 'psrev_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $ppto = $this->input->post('psrev_id');
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                break;
            case 4:
                $table_det = 'det_radio';
                $table = 'presup_radio';
                $field_id = 'psrad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';
                $ppto = $this->input->post('psrad_id');
                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                break;
            case 5:
                $table_det = 'det_tv';
                $table = 'presup_tv';
                $field_id = 'pstv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';
                $ppto = $this->input->post('pstv_id');
                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';
                break;
            case 6:
                $table_det = 'det_prode';
                $table = 'presup_prode';
                $field_id = 'psex_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';
                $ppto = $this->input->post('psex_id');
                if ($this->input->post('ordcos_id') != 0) {
                    $ordcos_vlrcobrado = $this->input->post('ordcos_vlrcobrado');
                    unset($_POST['ordcos_vlrcobrado']);
                }
                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                break;
            case 7:
                $table_det = 'det_prodi';
                $table = 'presup_prodi';
                $field_id = 'psin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';
                $ppto = $this->input->post('psin_id');
                if ($this->input->post('ordcos_id') != 0) {
                    $ordcos_vlrcobrado = $this->input->post('ordcos_vlrcobrado');
                    unset($_POST['ordcos_vlrcobrado']);
                }
                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                break;
            case 8:
                $table_det = 'det_pubext';
                $table = 'publicidad_exterior';
                $field_id = 'pubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';
                $ppto = $this->input->post('pubext_id');
                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                break;
            case 9:
                $table_det = 'det_impresos';
                $table = 'impresos';
                $field_id = 'imp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';
                $ppto = $this->input->post('imp_id');
                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                break;
            case 10:
                $table_det = 'det_artpub';
                $table = 'art_publi';
                $field_id = 'artp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';
                $ppto = $this->input->post('artp_id');
                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                break;

            default:
                break;
        }

        $reverse = '';
        $msg = '';
        $result = $this->M_Manager->AddDetail($table_det, $_POST, $field_id, $ppto, $table_det, $select);
        if ($result['res'] == 'OK') {
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Manager->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));
            if (($tipo == 7 || $tipo == 6) && $this->input->post('ordcos_id') != 0) {
                $this->M_Manager->AsignPptoOrder($this->input->post('ordcos_id'), $ppto, $ordcos_vlrcobrado, $tipo);
            }
            
            $rsRow = $this->M_Manager->SelectRow($table, $field_id, $ppto);
            $validate = $this->ValidateCredit($rsRow->pvcl_id_clie, false, 0);
            if ($validate['res'] == 'LOCKED'):
                $_POST['id_detalle'] = $result['id_detalle'];
                $_POST['ppto'] = $ppto;
                $_POST['tipo'] = $tipo;
                
                $this->DeleteDetail(false);
                $reverse = 'OK';
                $msg = $validate['msg'];
            endif;
            
        }

        echo json_encode(array('res' => $result['res'], 'reverse'=>$reverse, 'msg'=>$msg));
    }

    function UpdateDetail() {

        $tipo = $this->input->post('tipo');

        unset($_POST['tipo']);
        unset($_POST['tabla']);

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $table = 'presup_avisos';
                $field_id = 'psav_id';
                $field_id_detalle = 'detavi_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';
                $ppto = $this->input->post('psav_id');
                $id_detalle = $this->input->post('detavi_id');

                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                break;
            case 2:
                $table_det = 'det_clasi';
                $table = 'presup_clasificados';
                $field_id = 'pscf_id';
                $field_id_detalle = 'dclasi_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $ppto = $this->input->post('pscf_id');
                $id_detalle = $this->input->post('dclasi_id');
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';
                break;
            case 3:
                $table_det = 'det_revis';
                $table = 'presup_revis';
                $field_id = 'psrev_id';
                $field_id_detalle = 'drevis_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $ppto = $this->input->post('psrev_id');
                $id_detalle = $this->input->post('drevis_id');
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                break;
            case 4:
                $table_det = 'det_radio';
                $table = 'presup_radio';
                $field_id = 'psrad_id';
                $field_id_detalle = 'drad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';
                $ppto = $this->input->post('psrad_id');
                $id_detalle = $this->input->post('drad_id');

                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                break;
            case 5:
                $table_det = 'det_tv';
                $table = 'presup_tv';
                $field_id = 'pstv_id';
                $field_id_detalle = 'dtv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';
                $ppto = $this->input->post('pstv_id');
                $id_detalle = $this->input->post('dtv_id');

                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';

                break;
            case 6:
                $table_det = 'det_prode';
                $table = 'presup_prode';
                $field_id = 'psex_id';
                $field_id_detalle = 'dprode_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';
                $ppto = $this->input->post('psex_id');
                $id_detalle = $this->input->post('dprode_id');

                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                break;
            case 7:
                $table_det = 'det_prodi';
                $table = 'presup_prodi';
                $field_id = 'psin_id';
                $field_id_detalle = 'dpsin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';
                $ppto = $this->input->post('psin_id');
                $id_detalle = $this->input->post('dpsin_id');

                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                break;
            case 8:
                $table_det = 'det_pubext';
                $table = 'publicidad_exterior';
                $field_id = 'pubext_id';
                $field_id_detalle = 'dpubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';
                $ppto = $this->input->post('pubext_id');
                $id_detalle = $this->input->post('dpubext_id');

                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                break;
            case 9:
                $table_det = 'det_impresos';
                $table = 'impresos';
                $field_id = 'imp_id';
                $field_id_detalle = 'dimp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';
                $ppto = $this->input->post('imp_id');
                $id_detalle = $this->input->post('dimp_id');

                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                break;
            case 10:
                $table_det = 'det_artpub';
                $table = 'art_publi';
                $field_id = 'artp_id';
                $field_id_detalle = 'dartp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';
                $ppto = $this->input->post('artp_id');
                $id_detalle = $this->input->post('dartp_id');

                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                break;

            default:
                break;
        }
        
        $old = $this->M_Manager->SelectRow($table_det,$field_id_detalle,$id_detalle);
        $row = $this->M_Manager->ValorTotal($field_id, $ppto, $table, $selectTotal.',pvcl_id_clie',true);
        
        $reverse = '';
        $msg = '';
        $result = $this->M_Manager->UpdateDetail($table_det, $_POST, $field_id, $ppto, $table_det, $select, $field_id_detalle, $id_detalle);
        if ($result['res'] == 'OK') {
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Manager->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));
            
            if($total > $row->total){
                $validate = $this->ValidateCredit($row->pvcl_id_clie, false, 0);
                if ($validate['res'] == 'LOCKED'):
                    $result = $this->M_Manager->UpdateDetail($table_det, $old, $field_id, $ppto, $table_det, $select, $field_id_detalle, $id_detalle);
                    $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
                    $total = $this->M_Manager->ValorTotal($field_id, $ppto, $table, $selectTotal);
                    $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));
                    
                    $reverse = 'OK';
                    $msg = $validate['msg'];
                endif;
            }
        }

        echo json_encode(array('res' => $result['res'], 'reverse'=>$reverse, 'msg'=>$msg));
    }

    function DeleteDetail($response = true) {

        $tipo = $this->input->post('tipo');
        $ppto = $ppto = $this->input->post('ppto');

        switch ($tipo) {
            case 1:
                $table_det = 'det_avisos';
                $table = 'presup_avisos';
                $field_id = 'psav_id';
                $field_id_detalle = 'detavi_id';
                $field_valor = 'psav_valor';
                $field_total = 'psav_total';


                $select = 'SUM(detavi_total) AS valor';
                $selectTotal = 'psav_valor,
                (psav_valor * (psav_desc / 100)) AS descuento,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) AS iva,
                ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) AS spa,
                (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100)) AS iva_spa,
                ((psav_valor - (psav_valor * (psav_desc / 100))) + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_iva / 100)) 
                + ((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) + (((psav_valor - (psav_valor * (psav_desc / 100))) * (psav_spa / 100)) * (psav_ivaspa / 100))
                ) AS total';
                break;
            case 2:
                $table_det = 'det_clasi';
                $table = 'presup_clasificados';
                $field_id = 'pscf_id';
                $field_id_detalle = 'dclasi_id';
                $field_valor = 'pscf_valor';
                $field_total = 'pscf_total';
                $select = 'SUM(dclasi_total) AS valor';
                $selectTotal = 'pscf_valor,
                (pscf_valor * (pscf_desc / 100)) AS descuento,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) AS iva,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) AS spa,
                (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100)) AS iva_spa,
                ((pscf_valor - (pscf_valor * (pscf_desc / 100))) + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_iva / 100)) 
                + ((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) + (((pscf_valor - (pscf_valor * (pscf_desc / 100))) * (pscf_spa / 100)) * (pscf_ivaspa / 100))
                ) AS total';

                break;
            case 3:
                $table_det = 'det_revis';
                $table = 'presup_revis';
                $field_id = 'psrev_id';
                $field_id_detalle = 'drevis_id';
                $field_valor = 'psrev_valor';
                $field_total = 'psrev_total';
                $select = 'SUM(drevis_total) AS valor';
                $selectTotal = 'psrev_valor,
                (psrev_valor * (psrev_desc / 100)) AS descuento,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) AS iva,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) AS spa,
                (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100)) AS iva_spa,
                ((psrev_valor - (psrev_valor * (psrev_desc / 100))) + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_iva / 100)) 
                + ((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) + (((psrev_valor - (psrev_valor * (psrev_desc / 100))) * (psrev_spa / 100)) * (psrev_ivaspa / 100))
                ) AS total';
                break;
            case 4:
                $table_det = 'det_radio';
                $table = 'presup_radio';
                $field_id = 'psrad_id';
                $field_id_detalle = 'drad_id';
                $field_valor = 'psrad_valor';
                $field_total = 'psrad_total';

                $select = 'SUM(drad_total) AS valor';
                $selectTotal = 'psrad_valor,
                (psrad_valor * (psrad_desc / 100)) AS descuento,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) AS iva,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) AS spa,
                (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100)) AS iva_spa,
                ((psrad_valor - (psrad_valor * (psrad_desc / 100))) + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_iva / 100)) 
                + ((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) + (((psrad_valor - (psrad_valor * (psrad_desc / 100))) * (psrad_spa / 100)) * (psrad_ivaspa / 100))
                ) AS total';
                break;
            case 5:
                $table_det = 'det_tv';
                $table = 'presup_tv';
                $field_id = 'pstv_id';
                $field_id_detalle = 'dtv_id';
                $field_valor = 'pstv_valor';
                $field_total = 'pstv_total';

                $select = 'SUM(dtv_total) AS valor';
                $selectTotal = 'pstv_valor,
                (pstv_valor * (pstv_desc / 100)) AS descuento,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
                (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
                ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
                + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
                ) AS total';

                break;
            case 6:
                $table_det = 'det_prode';
                $table = 'presup_prode';
                $field_id = 'psex_id';
                $field_id_detalle = 'dprode_id';
                $field_valor = 'psex_valor';
                $field_total = 'psex_total';

                $select = 'SUM(dprode_valor) AS valor';
                $selectTotal = 'psex_valor,
                (psex_valor * (psex_desc / 100)) AS descuento,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) AS iva,
                ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) AS spa,
                (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100)) AS iva_spa,
                ((psex_valor - (psex_valor * (psex_desc / 100))) + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_iva / 100)) 
                + ((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) + (((psex_valor - (psex_valor * (psex_desc / 100))) * (psex_spa / 100)) * (psex_ivaspa / 100))
                ) AS total';
                break;
            case 7:
                $table_det = 'det_prodi';
                $table = 'presup_prodi';
                $field_id = 'psin_id';
                $field_id_detalle = 'dpsin_id';
                $field_valor = 'psin_valor';
                $field_total = 'psin_total';

                $select = 'SUM(dpsin_total) AS valor';
                $selectTotal = 'psin_valor,
                (psin_valor * (psin_desc / 100) ) AS descuento,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100)) AS iva,
                ((psin_valor - (psin_valor * (psin_desc / 100) )) + ((psin_valor - (psin_valor * (psin_desc / 100) )) * (psin_iva / 100))) AS total';
                break;
            case 8:
                $table_det = 'det_pubext';
                $table = 'publicidad_exterior';
                $field_id = 'pubext_id';
                $field_id_detalle = 'dpubext_id';
                $field_valor = 'pubext_valor';
                $field_total = 'pubext_total';

                $select = 'SUM(dpubext_total) AS valor';
                $selectTotal = 'pubext_valor,
                (pubext_valor * (pubext_desc / 100)) AS descuento,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) AS iva,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) AS spa,
                (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100)) AS iva_spa,
                ((pubext_valor - (pubext_valor * (pubext_desc / 100))) + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_iva / 100)) 
                + ((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) + (((pubext_valor - (pubext_valor * (pubext_desc / 100))) * (pubext_spa / 100)) * (pubext_ivaspa / 100))
                ) AS total';
                break;
            case 9:
                $table_det = 'det_impresos';
                $table = 'impresos';
                $field_id = 'imp_id';
                $field_id_detalle = 'dimp_id';
                $field_valor = 'imp_valor';
                $field_total = 'imp_total';

                $select = 'SUM(dimp_total) AS valor';
                $selectTotal = 'imp_valor,
                (imp_valor * (imp_desc / 100)) AS descuento,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) AS iva,
                ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) AS spa,
                (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100)) AS iva_spa,
                ((imp_valor - (imp_valor * (imp_desc / 100))) + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_iva / 100)) 
                + ((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) + (((imp_valor - (imp_valor * (imp_desc / 100))) * (imp_spa / 100)) * (imp_ivaspa / 100))
                ) AS total';
                break;
            case 10:
                $table_det = 'det_artpub';
                $table = 'art_publi';
                $field_id = 'artp_id';
                $field_id_detalle = 'dartp_id';
                $field_valor = 'artp_valor';
                $field_total = 'artp_total';

                $select = 'SUM(dartp_total) AS valor';
                $selectTotal = 'artp_valor,
                (artp_valor * (artp_desc / 100)) AS descuento,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) AS iva,
                ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) AS spa,
                (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100)) AS iva_spa,
                ((artp_valor - (artp_valor * (artp_desc / 100))) + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_iva / 100)) 
                + ((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) + (((artp_valor - (artp_valor * (artp_desc / 100))) * (artp_spa / 100)) * (artp_ivaspa / 100))
                ) AS total';
                break;

            default:
                break;
        }

        $result = $this->M_Manager->DeleteDetail($field_id, $ppto, $table_det, $select, $field_id_detalle, $this->input->post('id_detalle'));
        if ($result['res'] == 'OK') {
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_valor => $result['valor']));
            $total = $this->M_Manager->ValorTotal($field_id, $ppto, $table, $selectTotal);
            $this->M_Manager->UpdateInfo($field_id, $ppto, $table, array($field_total => $total));

            if (($tipo == 7 || $tipo == 6) && $this->input->post('ordcos_id') != 0) {
                $this->M_Manager->DesAsignPptoOrder($this->input->post('ordcos_id'), $ppto, $this->input->post('total'));
            }
        }
        if($response){
            echo json_encode(array('res' => $result['res']));
        }
    }
    function GetRowDetailppto() {
        $result = $this->M_Manager->GetRowDetailppto();
        echo json_encode($result);
    }

    function loadOrdenCosto() {
        $result = $this->M_Manager->ListOrdCostoExt($this->input->post('tipo'), $this->input->post('servicio'));
        echo json_encode(array('ordenes' => $result));
    }

    function Select() {
        $data['programas'] = $this->M_Manager->SelecTall($this->input->post('id'), $this->input->post('field'), $this->input->post('table'));
        echo json_encode($data);
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
        $ppto = $this->input->post('ppto');
        $error = array();
        $insert = 0;
        $row = 1;
        $loop = ($sheet->getCell("A{$row}")->getValue() == '') ? false : true;

        while ($loop) {
            if ($sheet->getCell("A{$row}")->getValue() != '' && $sheet->getCell("C{$row}")->getValue() && $sheet->getCell("D{$row}")->getValue() && $sheet->getCell("E{$row}")->getValue() && $sheet->getCell("G{$row}")->getValue() && $sheet->getCell("H{$row}")->getValue() && $sheet->getCell("J{$row}")->getValue()) {

                $dtv_total = (!empty($sheet->getCell("I{$row}")->getValue())) ? $sheet->getCell("I{$row}")->getValue() : 0 * $sheet->getCell("H{$row}")->getValue();
                $horareal = strtotime($sheet->getCell("F{$row}")->getValue());
                $unoDay = "06:00:00";
                $dosDay = "12:00:00";
                $dosEarly = "19:00:00";
                $dosPrime = "22:30:59";
                $unoLate = "23:00:00";
                $hora1 = strtotime($unoDay);
                $hora2 = strtotime($dosDay);
                $hora3 = strtotime($dosEarly);
                $hora4 = strtotime($dosPrime);
                $hora5 = strtotime($unoLate);

                if (($horareal >= $hora1) && ($horareal < $hora2)) {
                    $dtv_franja = "Day";
                } elseif (($horareal >= $hora2) && ($horareal < $hora3)) {
                    $dtv_franja = "Early";
                } elseif (($horareal >= $hora3) && ($horareal <= $hora4)) {
                    $dtv_franja = "Prime";
                } else {
                    $dtv_franja = "Late";
                }

                $excel_date = $sheet->getCell("J{$row}")->getValue(); // Serialized form of 10-Apr-1956
                $processDate = $excel_date - 25569;
                $dateVal = strtotime("+$processDate days", mktime(0, 0, 0, 1, 1, 1970));

                $arr = array(
                    'pstv_id' => $ppto,
                    'dtv_canal' => '',
                    'dtv_cliente' => $sheet->getCell("A{$row}")->getValue(),
                    'cod_comercial' => $sheet->getCell("B{$row}")->getValue(),
                    'dtv_producto' => $sheet->getCell("C{$row}")->getValue(),
                    'dtv_programa' => $sheet->getCell("D{$row}")->getValue(),
                    'dtv_referencia' => $sheet->getCell("E{$row}")->getValue(),
                    'dtv_hora' => PHPExcel_Style_NumberFormat::toFormattedString($sheet->getCell("F{$row}")->getValue(), 'hh:mm:ss'),
                    'dtv_segundo' => $sheet->getCell("G{$row}")->getValue(),
                    'dtv_numcomer' => $sheet->getCell("H{$row}")->getValue(),
                    'dtv_numcomerd' => '',
                    'dtv_tarifa' => $sheet->getCell("I{$row}")->getValue(),
                    'dtv_observa' => '',
                    'dtv_bonif' => '',
                    'dtv_valor' => $sheet->getCell("I{$row}")->getValue(),
                    'dtv_diaspub' => '',
                    'dtv_detalle' => '',
                    'dtv_fechasalida' => date('d/m/Y', $dateVal),
                    'dtv_frecuencia' => '',
                    'dtv_franja' => $dtv_franja,
                    'dtv_total' => $dtv_total,
                    'dtv_global' => '',
                    'unidad' => 2,
                );

                $details[] = $arr;

                $row++;
                $loop = ($sheet->getCell("A$row")->getValue() == '') ? false : true;
            } else {
                $loop = false;
                $error[] = 'Las columnas deben estar diligenciadas en su totalidad, no se aceptan vacias';
            }
        }


        if (count($details) > 0 && count($error) <= 0):
            $insert = $this->M_Manager->SaveImportDetail($details, $ppto);

            $selectTotal = 'pstv_valor,
            (pstv_valor * (pstv_desc / 100)) AS descuento,
            ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) AS iva,
            ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) AS spa,
            (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100)) AS iva_spa,
            ((pstv_valor - (pstv_valor * (pstv_desc / 100))) + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_iva / 100)) 
            + ((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) + (((pstv_valor - (pstv_valor * (pstv_desc / 100))) * (pstv_spa / 100)) * (pstv_ivaspa / 100))
            ) AS total';

            $this->M_Manager->UpdateInfo('pstv_id', $ppto, 'presup_tv', array('pstv_valor' => $insert['valor']));
            $total = $this->M_Manager->ValorTotal('pstv_id', $ppto, 'presup_tv', $selectTotal);
            $this->M_Manager->UpdateInfo('pstv_id', $ppto, 'presup_tv', array('pstv_total' => $total));
        endif;

        $objXLS->disconnectWorksheets();
        unset($objXLS);
        unlink(dirname(__FILE__) . '/../../../Adjuntos/temp/' . $name);
        return array("0" => $error, "1" => $insert['res']);
    }

}
