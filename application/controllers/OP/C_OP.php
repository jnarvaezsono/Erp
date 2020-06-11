<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_OP extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('OP/M_OP');
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, DATEPICKER_CSS, TIMEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, FILER_CSS);
        $this->load->view('Template/V_Header', $Header);

        foreach ($this->M_OP->LoadButtonPermissions("OP") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $array['info'] = (object) array('id_estado' => '1', 'description' => '');
        $data['clientes'] = $this->M_OP->ListarClientes();
        $array['form'] = $this->load->view('OP/V_Form_New', $data, true);
        $array['tabla_tareas'] = '';

        $arrayModal['unidades'] = $this->M_OP->ListarUnidades();
        $arrayModal['modalidades'] = $this->M_OP->ListarModalidadCobro();
        $arrayModal['area_responsable'] = $this->M_OP->ListarAreas();
        $arrayModal['usuarios'] = $this->M_OP->ListarUsuarios();
        $formModal['id_op'] = "";
        $array['id_op'] = 0;
        $formModal['categorias'] = $this->M_OP->ListCategoria(array('T'));
        $formModal['form_modal'] = $this->load->view('OP/V_Form_Modal', $arrayModal, true);

        $array['modal'] = $this->load->view('OP/V_Modal_Tarea', $formModal, true);

        $this->load->view('OP/V_Panel', $array);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, DATEPICKER_JS, TIMEPICKER_JS, ALERTIFY_JS, CKEDITOR_JS, FILER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function Info($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, DATEPICKER_CSS, TIMEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2, FILER_CSS);
        $this->load->view('Template/V_Header', $Header);

        foreach ($this->M_OP->LoadButtonPermissions("OP") as $btn) {
            $data[$btn->name] = $btn->name;
            $arrayTask[$btn->name] = $btn->name;
        }

        //DATOS PARA EL FORMULARIO DE CREACION DE OP
        $data['info'] = $this->M_OP->GetInfoOp($id);
        $array['info'] = $data['info'];
        if ($data['info']):
            $data['clientes'] = $this->M_OP->ListarClientes();
            $data['campanas'] = $this->M_OP->ListarCampana($data['info']->id_cliente);
            $data['rubros'] = $this->M_OP->ListarRubro($data['info']->id_cliente);


            $array['form'] = $this->load->view('OP/V_Form_Update', $data, true);

            //MODAL DE CREACION DE TAREAS
            $arrayModal['unidades'] = $this->M_OP->ListarUnidades();
            $arrayModal['modalidades'] = $this->M_OP->ListarModalidadCobro();
            $arrayModal['area_responsable'] = $this->M_OP->ListarAreas();
            $arrayModal['usuarios'] = $this->M_OP->ListarUsuarios();
            $arrayModal['categorias'] = $this->M_OP->ListCategoria(array('T'));

            $formModal['form_modal'] = $this->load->view('OP/V_Form_Modal', $arrayModal, true);
            $formModal['id_op'] = $id;

            $array['modal'] = $this->load->view('OP/V_Modal_Tarea', $formModal, true);

            $arrayTask['tasks'] = $this->M_OP->ListarTareasOP($id);
            $array['tabla_tareas'] = $this->load->view('OP/V_Table_Task', $arrayTask, true);

            $this->load->view('OP/V_Panel', $array);
        else:
            $this->load->view('errors/html/error_404.php');
        endif;
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, DATEPICKER_JS, TIMEPICKER_JS, ALERTIFY_JS, CKEDITOR_JS, FILER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ListarTasksFilterNotified($op, $tarea, $estado, $usuario, $maestro) {
        $rows = $this->M_OP->ListarTaskNotified($this->input->get('start'), $this->input->get("length"), $op, $tarea, $estado, $usuario);

        $array = array();
        foreach ($rows['result'] as $v) {
            $icon = '<img style="width:25px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea cerrada" src="' . base_url() . 'dist/img/icon-image/invalid.png" />';
            if (isOpen($v->id_estado)) {
                if ($v->dias <= 0) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea vencida" src="' . base_url() . 'dist/img/icon-image/rojo.png" />';
                } elseif ($v->dias <= 1) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 1 día para su vencimiento" src="' . base_url() . 'dist/img/icon-image/naranja.png" />';
                } elseif ($v->dias <= 2) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 2 días para su vencimiento" src="' . base_url() . 'dist/img/icon-image/amarillo.png" />';
                } elseif ($v->dias <= 3) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 3 días para su vencimiento" src="' . base_url() . 'dist/img/icon-image/lima.png" />';
                } else {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan mas de 3 día para su vencimiento" src="' . base_url() . 'dist/img/icon-image/verde.png" />';
                }
            } else if ($v->id_estado == 13) {
                $icon = '<img style="width:25px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea cerrada" src="' . base_url() . 'dist/img/icon-image/valid.png" />';
            }
            $array[] = array('<span class="label label-' . $v->color . '">' . $v->estado . '</span>', $icon, $v->id_op, $v->id_tarea, $v->categoria, $v->nombre, $v->creador, $v->fecha_creacion, $v->fecha_entrega, $v->fecha_cierre, strip_tags($v->descripcion), $v->responsable, $v->presupuesto);
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows['num'], 'datos' => $array));
    }

    public function ListTask($maestro) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, BTN_DATATABLE_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $estados = $this->M_OP->ListStatusAll();
        $usuarios = $this->M_OP->ListarUsuariosArea();
        $clientes = $this->M_OP->ListarClientes();
        $areas = $this->M_OP->ListarAreas();
        $modalidad = $this->M_OP->ListarModalidadCobro();
        $this->load->view('OP/List/V_List', array('modalidad' => $modalidad, 'estados' => $estados, 'areas' => $areas, 'clientes' => $clientes, 'maestro' => $maestro, 'usuarios' => $usuarios, 'title' => 'Lista De Tareas'));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ListarTasksFilter($cliente, $op, $tarea, $estado, $usuario, $area, $maestro, $modalidad, $descripcion) {
        $rows = $this->M_OP->ListarMyTask($this->input->get('start'), $this->input->get("length"), $cliente, $op, $tarea, $estado, $usuario, $area, $maestro, $modalidad, $descripcion);
        $all = $this->M_OP->SelectMyTask($cliente, $op, $tarea, $estado, $usuario, $area, $maestro, $modalidad, $descripcion);
        $array = array();
        foreach ($rows['result'] as $v) { //mb_substr()
            $icon = '<img style="width:25px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea cerrada" src="' . base_url() . 'dist/img/icon-image/invalid.png" />';
            if (isOpen($v->id_estado)) {
                if ($v->dias <= 0) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea vencida" src="' . base_url() . 'dist/img/icon-image/rojo.png" />';
                } elseif ($v->dias <= 1) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 1 día para su vencimiento" src="' . base_url() . 'dist/img/icon-image/naranja.png" />';
                } elseif ($v->dias <= 2) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 2 días para su vencimiento" src="' . base_url() . 'dist/img/icon-image/amarillo.png" />';
                } elseif ($v->dias <= 3) {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan 3 días para su vencimiento" src="' . base_url() . 'dist/img/icon-image/lima.png" />';
                } else {
                    $icon = '<img style="width:30px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Restan mas de 3 día para su vencimiento" src="' . base_url() . 'dist/img/icon-image/verde.png" />';
                }
            } else if ($v->id_estado == 13) {
                $icon = '<img style="width:25px;margin-left:5px" data-toggle="tooltip" data-placement="top" title="Tarea cerrada" src="' . base_url() . 'dist/img/icon-image/valid.png" />';
            }
            $array[] = array('<span class="label label-' . $v->color . '">' . $v->estado . '</span>', $icon, $v->id_op, $v->id_tarea, $v->categoria, $v->nombre, $v->creador, $v->fecha_creacion, $v->fecha_entrega, $v->modalidad_cobro, strip_tags($v->descripcion), $v->responsable, $v->presupuesto, $v->camp_nombre);
//          $array[] = array($v->id_op, $v->id_tarea, $v->categoria,$v->nombre,  $v->fecha_entrega, $v->fecha_cierre, $v->descripcion, $v->responsable, (empty($v->tiempo_estimado)) ? '<span class="fa fa-clock-o" aria-hidden="true" id="time-' . $v->id_tarea . '" onclick="OpenModal(' . $v->id_tarea . ')"></span>' : $v->tiempo_estimado, '<span class="label label-' . $v->color . '">' . $v->estado . '</span>', '<button class="btn btn-block btn-primary btn-xs" onclick="OpenTask(' . $v->id_tarea . ')"><span class="fa fa-sign-in" aria-hidden="true"></span></button>');
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }

    function ListAll() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $clientes = $this->M_OP->ListarClientes();
        $estados = $this->M_OP->ListStatusAll();
        $creadores = $this->M_OP->ListCreatorOP();
        $this->load->view('OP/List/V_Panel', array('clientes' => $clientes, 'estados' => $estados, 'creadores' => $creadores));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ListarOrden($op, $cliente, $estado, $creador, $descripcion) {
        $rows = $this->M_OP->GetListTableOP($this->input->get('start'), $this->input->get("length"), $op, $cliente, $estado, $creador, $descripcion);
        $all = $this->M_OP->SelectOP($op, $cliente, $estado, $creador, $descripcion);
        $array = array();
        foreach ($rows['result'] as $v) {
            $array[] = array($v->id_op, $v->cliente, $v->campana, $v->rubro, $v->creador, substr($v->fecha_creacion, 0, 10), substr($v->fecha_cierre, 0, 10), $v->descripcion_op, '<span class="label label-' . $v->color . '">' . $v->estado . '</span>');
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }

    function ListarDatosForm() {
        $array['campanas'] = $this->M_OP->ListarCampana();
        $array['rubros'] = $this->M_OP->ListarRubro();
        echo json_encode($array);
    }

    function CrearOp() {
        if (!empty($this->input->post('new_campana'))) {
            $data = array(
                "pvcl_id" => $this->input->post('cliente'),
                "camp_nombre" => strtoupper($this->input->post('new_campana')),
                "camp_fecha" => date('Y-m-d H:i:s'),
                "est_id" => 1,
                "usr_id" => 92
            );
            $_POST['campana'] = $this->M_OP->CrearCampana($data);
        }

        if (!empty($this->input->post('new_producto'))) {
            $data = array(
                "pvcl_id" => $this->input->post('cliente'),
                "pdcl_nombre" => strtoupper($this->input->post('new_producto')),
                "pdcl_fecha" => date('Y-m-d H:i:s'),
                "est_id" => 1,
                "usr_id" => 92
            );
            $_POST['rubro'] = $this->M_OP->CrearProducto($data);
        }

        if (!empty($_POST['campana']) && !empty($_POST['rubro'])) {

            $data = array(
                'id_user' => $this->session->IdUser,
                'id_cliente' => $this->input->post('cliente'),
                'id_campana' => $_POST['campana'],
                'id_rubro' => $_POST['rubro'],
                'descripcion_op' => $this->input->post('descripcion_op')
            );

            $result = $this->M_OP->CrearOp($data);
            $result['tabla_tareas'] = $this->load->view('OP/V_Table_Task', array('tasks' => array()), true);
        } else {
            $result = array('res' => 'Error, debe diligenciar todos los datos');
        }
        echo json_encode($result);
    }

    public function OtherTask($maestro) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $datos['rows'] = $this->M_OP->ListarTaskNotified($this->input->get('start'), $this->input->get("length"), 'all', 'all', 'all', 'all');
        $tabla = $this->load->view('OP/List/V_Table_Task', $datos, true);

        $estados = $this->M_OP->ListStatusAll();
        $usuarios = $this->M_OP->ListarUsuariosArea();
        $this->load->view('OP/List/V_List_Notified', array('table' => $tabla, 'all' => $datos['rows']['num'], 'estados' => $estados, 'maestro' => $maestro, 'usuarios' => $usuarios, 'title' => 'Mis Tareas Notificadas'));

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ActualizarOp($id) {
        if (!empty($this->input->post('new_campana'))) {
            $data = array(
                "pvcl_id" => $this->input->post('cliente'),
                "camp_nombre" => strtoupper($this->input->post('new_campana')),
                "camp_fecha" => date('Y-m-d H:i:s'),
                "est_id" => 1,
                "usr_id" => 92
            );
            $_POST['campana'] = $this->M_OP->CrearCampana($data);
        }

        if (!empty($this->input->post('new_producto'))) {
            $data = array(
                "pvcl_id" => $this->input->post('cliente'),
                "pdcl_nombre" => strtoupper($this->input->post('new_producto')),
                "pdcl_fecha" => date('Y-m-d H:i:s'),
                "est_id" => 1,
                "usr_id" => 92
            );
            $_POST['rubro'] = $this->M_OP->CrearProducto($data);
        }

        if (!empty($_POST['campana']) && !empty($_POST['rubro'])) {

            $data = array(
                'id_cliente' => $this->input->post('cliente'),
                'id_campana' => $_POST['campana'],
                'id_rubro' => $_POST['rubro'],
                'descripcion_op' => $this->input->post('descripcion_op'),
                'fecha_modificacion' => date('Y-m-d H:i:s')
            );

            $result = $this->M_OP->ActualizarOp($id, $data);
        } else {
            $result = array('res' => 'Error, debe diligenciar todos los datos');
        }
        echo json_encode($result);
    }

    function CargarFormulario() {
        if ($this->input->post('id_categoria') == 15 || $this->input->post('id_categoria') == 14 || $this->input->post('id_categoria') == 16) { // 15 = diseño 7 = interna 14 digital
            $array['servicios'] = $this->M_OP->ListarTarifas(false,false);
        }else if($this->input->post('id_categoria') == 17){
            $array['servicios'] = $this->M_OP->ListarTarifas(false,true);
        } else {
            $array['servicios'] = $this->M_OP->CargarTipoServicio($this->input->post('id_categoria'));
        }


        switch ($this->input->post('form')) {
            case 'Aviso':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['paginas'] = $this->M_OP->ListarPaginas();
                $array['tintas'] = $this->M_OP->ListarTintas();
                break;
            case 'Clasificado':
                $array['medios'] = $this->M_OP->ListarMedios();
                break;
            case 'Articulo':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                break;
            case 'Exterior':
                $array['piezas'] = $this->M_OP->ListarPiezas();
                $array['ciudades'] = $this->M_OP->ListarCiudades();
                break;
            case 'Externa':

                break;
            case 'Btl':
                
                break;
            case 'Interna':
                $array['tintas'] = $this->M_OP->ListarTintas();
                break;
            case 'Impreso':
                $array['elementos'] = $this->M_OP->ListarElementos();
                $array['conceptos'] = $this->M_OP->ListarConceptos();
                $array['tintas'] = $this->M_OP->ListarTintas();
                break;
            case 'Radio':
                $array['emisoras'] = $this->M_OP->ListarEmisoras();
                $array['ciudades'] = $this->M_OP->ListarCiudades();
                break;
            case 'Revista':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                break;
            case 'Television':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['canales'] = $this->M_OP->ListarCanales();
                break;

            default:
                break;
        }

        if ($this->input->post('option') == "update") {
            $array['info'] = $this->M_OP->IntoTarea($this->input->post('id_tarea'));
            $form = $this->load->view('OP/Form_Categorias_Update/V_Form_' . $this->input->post('form'), $array, true);
        } else {
            $form = $this->load->view('OP/Form_Categorias/V_Form_' . $this->input->post('form'), $array, true);
        }
        echo json_encode(array('form' => $form));
    }

    function IsDuplicatePhoto() {
        $result = array('res' => '');
        if ($this->M_OP->IsDuplicatePhoto($this->input->post('id_tarea'))) {
            $result = array('res' => 'DUPLICADO');
        }
        echo json_encode($result);
    }
    
    function ValidateTaskPhoto(){
        $result = $this->M_OP->ValidateTaskPhoto($this->input->post('id_tarea'));
       
        echo json_encode(array('res' => $result));
    }

    function NewTaskPhoto() {
        $result = array('res' => '');

        $row = $this->M_OP->IntoTarea($this->input->post('id_tarea'));

        $data = array(
            'id_op' => $this->input->post('op'),
            'id_tarifa_servicio' => '250', //servicio para la agencia
            'id_unidad' => '3',
            'fecha_entrega' => $row->entrega_pos,
            'modalidad_cobro' => $row->modalidad_cobro,
            'area_responsable' => 4,
            'descripcion' => $this->input->post('texto'),
            'id_responsable' => '64,65',
            'id_categoria' => 15,
            'notificados' => $row->id_responsable,
            'id_duplicado' => $this->input->post('id_tarea'),
        );
        $result = $this->M_OP->SaveTask($data);

        if ($result['res'] == "OK") {
            
            $data = array(
                "id_tarea" => $this->input->post("id_tarea"),
                "id_user" => $this->session->IdUser,
                "tipo" => "TEXTO",
                "texto" => "Solicitó material a fotografia <br />".$this->input->post('texto')
            );
            $this->M_OP->NewComment($data);
            
            $fil = 'files';

            //            if ($_FILES['files']['size'] > 0) {
            //                $this->UploadFile($result['id']);
            //            }

            $id_tarea = $result['id'];

            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Send.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd . " --op=newtask --id_tarea=" . $id_tarea . " --creador=" . $this->session->IdUser, "w"));
            } else {
                exec("php -q $ruta --op=newtask --id_tarea=" . $id_tarea . " --creador=" . $this->session->IdUser . " > /dev/null &");
            }
        }
        echo json_encode($result);
    }

    function SaveTask() {
        
        
        $arrayResult = array();
        $tarifa_servicio = '';
        if (isset($_POST['id_tarifa_servicio'])) {
            if (isset($_POST['tarifa_new'])) {
                if ($_POST['tarifa_new'] != '') {
                    $tarifa_servicio = $this->M_OP->CreateTarifa($_POST['tarifa_new'], 'OTRO');
                }
            }
        }
        unset($_POST['tarifa_new']);
        unset($_POST['id_tarifa_servicio']);

        $data = $_POST;

        $arrayTask = json_decode($_POST["arrayTask"]);

        unset($data['arrayTask']);

        
        foreach ($arrayTask as $key => $value) {
            
            if($tarifa_servicio != ''){
                $value[7] = str_replace('new,', '', $value[7]);
                $value[7] = str_replace(',new', '', $value[7]);
                $value[7] = str_replace('new', '', $value[7]);
                $value[7] = ($value[7] == '')?$tarifa_servicio:$value[7].','.$tarifa_servicio;
            }
            
            $data['id_unidad'] = $value[0];
            $data['fecha_entrega'] = $value[1];
            $data['modalidad_cobro'] = $value[2];
            $data['area_responsable'] = $value[3];
            $data['descripcion'] = $value[4];
            $data['id_responsable'] = $value[5];
            $data['notificados'] = $value[6];
            
            if(in_array($_POST['id_categoria'], array('14','15','17')) ){
                $data['id_tarifa_servicio'] = $value[7];
            }
            
            if ($value[2] == 'COTIZAR') {
                $data['id_estado'] = 16;
            }


            if (empty($value[5])) {
                $result = $this->M_OP->UpdateStatusOP(array("id_estado" => 15));
            }

            $result = $this->M_OP->SaveTask($data);

            if ($result['res'] == "OK") {
                $fil = 'files';

                if ($_FILES['files']['size'] > 0) {
                    $this->UploadFile($result['id']);
                }

                $arrayResult[] = $result;
                $_POST['id_tarea'] = $result['id'];

                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Send.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd . " --op=newtask --id_tarea=" . $_POST['id_tarea'] . " --creador=" . $this->session->IdUser, "w"));
                } else {
                    exec("php -q $ruta --op=newtask --id_tarea=" . $_POST['id_tarea'] . " --creador=" . $this->session->IdUser . " > /dev/null &");
                }
            }
        }

        echo json_encode($arrayResult);
    }

    function UploadFile($id_tarea) {
        require_once(dirname(__FILE__) . '/../../../dist/jQuery.filer/php/class.uploader.php');
        $carpeta = dirname(__FILE__) . '/../../../Adjuntos/OP/' . $id_tarea;
        
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        
        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['files'], array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => $carpeta. '/', //Upload directory {String}
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
                $datos['nombre'] = $value['name'];
                $datos['tipo'] = $value['extension'];
                $datos['id_tarea'] = $id_tarea;
                $this->M_OP->Guardar_adjunto($datos);
            }

            $result = array('res' => "OK");
        } else if ($data['hasErrors']) {
            $result = array();
            $result['res'] = $data['errors'];
        }

        return $result;
    }

    function SaveTask2() {
        $result = $this->M_OP->SaveTask();

        if ($result['res'] == "OK") {

            $_POST['id_tarea'] = $result['id'];

            $texto = "Te asigno una tarea <br />" . $this->input->post("descripcion");
            $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Creacion.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        }

        echo json_encode($result);
    }

    function DeleteTask() {
        $result = $this->M_OP->DeleteTask();
        if ($result['res'] == "OK") {
            $texto = " Anulo la tarea";
            $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Eliminacion.php";

            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        }

        echo json_encode($result);
    }

    public function EditTask($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, DATEPICKER_CSS, ICHECK_CSS_BLUE, TIMEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2);
        $this->load->view('Template/V_Header', $Header);

        $array['id'] = $id;

        foreach ($this->M_OP->LoadButtonPermissions("TASK") as $btn) {
            $array[$btn->name] = $btn->name;
        }

        $this->M_OP->DeleteNotificationAll($id);

        $array['info'] = $this->M_OP->IntoTarea($id);
        $array['infoOP'] = $this->M_OP->InfoOP($array['info']->id_op);
        $array['op_task'] = $this->M_OP->TaskOP($array['info']->id_op);
        $array['unidades'] = $this->M_OP->ListarUnidades();
        $array['pptos'] = $this->M_OP->ListCategoria(array('P'));
        //$array['categorias'] = $this->M_OP->LoadCategoria($array['info']->id_unidad);
        $array['categorias'] = $this->M_OP->ListCategoria(array('T'));
        $array['modalidades'] = $this->M_OP->ListarModalidadCobro();

        $array['area_responsable'] = $this->M_OP->ListarAreas();
        $array['usuarios'] = $this->M_OP->ListarUsuariosArea($array['info']->area_responsable);
        $array['notificados'] = $this->M_OP->ListarUsuariosArea();

        if ($array['info']->id_categoria == 15 || $array['info']->id_categoria == 14 ) { // 15 = diseño 7 = interna
            $array['servicios'] = $this->M_OP->ListarTarifas(false,false);
        }else if($array['info']->id_categoria == 17){
            $array['servicios'] = $this->M_OP->ListarTarifas(false,true);
        } else {
            $array['servicios'] = $this->M_OP->CargarTipoServicio($array['info']->id_categoria);
        }


        switch ($array['info']->id_categoria) {
            case '1':// 'Aviso':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['paginas'] = $this->M_OP->ListarPaginas();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Aviso', $array, true);
                break;
            case '2':// 'Clasificado':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Clasificado', $array, true);
                break;
            case '3':// 'Revista':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Revista', $array, true);
                break;
            case '4':// 'Radio':
                $array['emisoras'] = $this->M_OP->ListarEmisoras();
                $array['ciudades'] = $this->M_OP->ListarCiudades();

                $array['programas'] = $this->M_OP->LoadSelect('cat_programasr', 'emis_id', $array['info']->id_emisora);

                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Radio', $array, true);
                break;
            case '5':// 'Television':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['canales'] = $this->M_OP->ListarCanales();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Television', $array, true);
                break;
            case '6':// 'Externa':
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Externa', $array, true);
                break;
            case '8':// 'Exterior':
                $array['piezas'] = $this->M_OP->ListarPiezas();
                $array['ciudades'] = $this->M_OP->ListarCiudades();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Exterior', $array, true);
                break;
            case '9': // 'Impreso':
                $array['elementos'] = $this->M_OP->ListarElementos();
                $array['conceptos'] = $this->M_OP->ListarConceptos();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Impreso', $array, true);
                break;
            case '10':// 'Articulo':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Articulo', $array, true);
                break;
            case '14':
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Digital', $array, true);
                break;
            case '7':// 'Interna':
            case '15':
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Interna', $array, true);
                break;

            case '16':
                $array['form'] = '';
                break;
            case '17':
                $array['form'] = $this->load->view('OP/Form_Categorias_Update/V_Form_Btl', $array, true);
                break;
            default:
                $array['form'] = "";
                break;
        }

        $result_Coment = $this->M_OP->ListarComentarios($id);
        $array['comment'] = $this->load->view('OP/Task/V_Comment', array("comments" => $result_Coment), true);
        $array['adjuntos'] = $this->M_OP->ListarAdjuntosTareas($id, $array['info']->id_duplicado);

        $array['modal'] = $this->load->view('OP/Task/V_Modal', null, true);
        $array['modalCot'] = $this->load->view('OP/Task/V_Modal_Cot', null, true);

        $this->load->view('OP/Task/V_Task', $array);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, DATEPICKER_JS, ICHECK_JS, TIMEPICKER_JS, ALERTIFY_JS, CKEDITOR_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function Task($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, DATEPICKER_CSS, ICHECK_CSS_BLUE, TIMEPICKER_CSS, ALERTIFY_CSS, ALERTIFY_CSS2);
        $this->load->view('Template/V_Header', $Header);

        $array['id'] = $id;

        foreach ($this->M_OP->LoadButtonPermissions("TASK") as $btn) {
            $array[$btn->name] = $btn->name;
        }

        $this->M_OP->DeleteNotificationAll($id);

        $array['info'] = $this->M_OP->IntoTarea($id);
        $array['infoOP'] = $this->M_OP->InfoOP($array['info']->id_op);
        $array['op_task'] = $this->M_OP->TaskOP($array['info']->id_op);
        $array['unidades'] = $this->M_OP->ListarUnidades();
        $array['pptos'] = $this->M_OP->ListCategoria(array('P'));
        //$array['categorias'] = $this->M_OP->LoadCategoria($array['info']->id_unidad);
        $array['categorias'] = $this->M_OP->ListCategoria(array('T'));
        $array['modalidades'] = $this->M_OP->ListarModalidadCobro();

        $array['area_responsable'] = $this->M_OP->ListarAreas();
        $array['usuarios'] = $this->M_OP->ListarUsuariosArea($array['info']->area_responsable);
        $array['notificados'] = $this->M_OP->ListarUsuariosArea();

        if ($array['info']->id_categoria == 15 || $array['info']->id_categoria == 14 ) { // 15 = diseño 7 = interna
            $array['servicios'] = $this->M_OP->ListarTarifas(false,false);
        }else if($array['info']->id_categoria == 17){
            $array['servicios'] = $this->M_OP->ListarTarifas(false,true);
        } else {
            $array['servicios'] = $this->M_OP->CargarTipoServicio($array['info']->id_categoria);
        }


        switch ($array['info']->id_categoria) {
            case '1':// 'Aviso':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['paginas'] = $this->M_OP->ListarPaginas();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Aviso', $array, true);
                break;
            case '2':// 'Clasificado':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Clasificado', $array, true);
                break;
            case '3':// 'Revista':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Revista', $array, true);
                break;
            case '4':// 'Radio':
                $array['emisoras'] = $this->M_OP->ListarEmisoras();
                $array['ciudades'] = $this->M_OP->ListarCiudades();

                $array['programas'] = $this->M_OP->LoadSelect('cat_programasr', 'emis_id', $array['info']->id_emisora);

                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Radio', $array, true);
                break;
            case '5':// 'Television':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['canales'] = $this->M_OP->ListarCanales();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Television', $array, true);
                break;
            case '6':// 'Externa':
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Externa', $array, true);
                break;
            case '8':// 'Exterior':
                $array['piezas'] = $this->M_OP->ListarPiezas();
                $array['ciudades'] = $this->M_OP->ListarCiudades();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Exterior', $array, true);
                break;
            case '9': // 'Impreso':
                $array['elementos'] = $this->M_OP->ListarElementos();
                $array['conceptos'] = $this->M_OP->ListarConceptos();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Impreso', $array, true);
                break;
            case '10':// 'Articulo':
                $array['medios'] = $this->M_OP->ListarMedios();
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Articulo', $array, true);
                break;
            case '14':
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Digital', $array, true);
                break;
            case '7':// 'Interna':
            case '15':
                $array['tintas'] = $this->M_OP->ListarTintas();
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Interna', $array, true);
                break;

            case '16':
                $array['form'] = '';
                break;
            case '17':
                $array['form'] = $this->load->view('OP/Form_Categorias_Planos/V_Form_Btl', $array, true);
                break;
            default:
                $array['form'] = "";
                break;
        }

        $result_Coment = $this->M_OP->ListarComentarios($id);
        $array['comment'] = $this->load->view('OP/Task/V_Comment', array("comments" => $result_Coment), true);
        $array['adjuntos'] = $this->M_OP->ListarAdjuntosTareas($id, $array['info']->id_duplicado);

        $array['modal'] = $this->load->view('OP/Task/V_Modal', null, true);
        $array['modalCot'] = $this->load->view('OP/Task/V_Modal_Cot', null, true);

        $this->load->view('OP/Task/V_Task_1', $array);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, DATEPICKER_JS, ICHECK_JS, TIMEPICKER_JS, ALERTIFY_JS, CKEDITOR_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function LoadCategoria() {
        $result = $this->M_OP->LoadCategoria($this->input->post('valor'));
        echo json_encode(array('datos' => $result));
    }

    function LoadSelect() {
        switch ($this->input->post('select')) {
            case 't_programa':
                $this->tabla = 'cat_programasr';
                $this->campo = 'emis_id';
                break;
            case 't_responsable':
                $this->tabla = 'sys_users';
                $this->campo = 'id_area';
                break;
            case 'other_service':
                $this->tabla = 'sys_tipo_servicio';
                $this->campo = 'id_categoria';
                break;

            default:
                break;
        }
        $result = $this->M_OP->LoadSelect($this->tabla, $this->campo);
        echo json_encode(array('datos' => $result));
    }

    function Subir_adjunto() {
        $datos['id_tarea'] = $this->input->post('id_tarea');
        require dirname(__FILE__) . '/../../libraries/UploadHandler.php';
        $UploadHandler = new UploadHandler(null, true, null, $datos['id_tarea'], $this->input->post('folder'));
        $nombre = $UploadHandler->get_response();
        $datos['nombre'] = $nombre['files'][0]->name;
        $datos['tipo'] = $nombre['files'][0]->type;

        $this->M_OP->Guardar_adjunto($datos);
    }

    function UploadCotization() {

        require dirname(__FILE__) . '/../../libraries/UploadHandler.php';
        $UploadHandler = new UploadHandler(null, true, null, $this->input->post('id_tarea'), $this->input->post('folder'));
        $nombre = $UploadHandler->get_response();

        $data = array(
            "id_tarea" => $this->input->post("id_tarea"),
            "id_user" => $this->session->IdUser,
            "tipo" => "ADJUNTO",
            "texto" => 'Adjuntó Cotización',
            "adjunto" => $nombre['files'][0]->name,
        );
        $result = $this->M_OP->NewComment($data);

//        $data = array(
//            "id_tarea" => $this->input->post("id_tarea"),
//            "tipo" => $nombre['files'][0]->type,
//            "nombre" => $nombre['files'][0]->name,
//            "fecha" => date('Y-m-d H:i:s')
//        );
//        $result = $this->M_OP->NewAdjunto($data);

        if ($result == "OK") {
            $this->M_OP->UpdateTaskPpto(array('id_estado' => 17), false);
        }

        if ($this->session->has_userdata('tokenkey') && $this->session->tokenkey == $this->input->post('tokenkey')) {
            
        } else {
            $this->session->set_userdata('tokenkey', $this->input->post('tokenkey'));

            if ($result == "OK") {
                $texto = " Adjunto una Cotización.";
                $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Adjunto.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd, "w"));
                } else {
                    exec("php -f $ruta > /dev/null &");
                }
            }
        }
    }

    function UploadFileComment() {

        require dirname(__FILE__) . '/../../libraries/UploadHandler.php';
        $UploadHandler = new UploadHandler(null, true, null, $this->input->post('id_tarea'), $this->input->post('folder'));
        $nombre = $UploadHandler->get_response();
        
        $data = array(
            "id_tarea" => $this->input->post("id_tarea"),
            "id_user" => $this->session->IdUser,
            "tipo" => "ADJUNTO",
            "adjunto" => $nombre['files'][0]->name,
            "token" => $this->input->post('tokenkey')
        );
        
        $result = $this->M_OP->NewComment($data);

        if ($this->session->has_userdata('tokenkey') && $this->session->tokenkey == $this->input->post('tokenkey')) {
            
        } else {
            $this->session->set_userdata('tokenkey', $this->input->post('tokenkey'));

            if ($result == "OK") {
                $texto = " Adjunto un nuevo archivo.";
                $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Adjunto.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd, "w"));
                } else {
                    exec("php -f $ruta > /dev/null &");
                }
            }
        }
    }

    function Cargar_adjuntos() {
        $id_tarea = $this->input->get('id_tarea');
        require dirname(__FILE__) . '/../../libraries/UploadHandler.php';
        $UploadHandler = new UploadHandler(null, false, null, $id_tarea, $this->input->get('folder'));
        $files = false;
    }

    function Borrar_adjunto($folder, $id, $archivo) {

        require dirname(__FILE__) . '/../../libraries/UploadHandler.php';
        $UploadHandler = new UploadHandler(null, true, null, $id, $folder);

        $UploadHandler->delete(false, array($archivo));
        $this->M_OP->DeleteFileTask($id, $archivo);
    }

    function NewComment() {
        $data = array(
            "id_tarea" => $this->input->post("id_tarea"),
            "id_user" => $this->session->IdUser,
            "tipo" => "TEXTO",
            "texto" => $this->input->post("texto")
        );
        $result = $this->M_OP->NewComment($data);

        if ($result == "OK") {
            $this->M_OP->Tmp($this->input->post("id_tarea"), $this->input->post("texto"));
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Comentario.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        }

        echo json_encode(array("res" => $result, "fecha" => date('Y-m-d H:i:s')));
    }

    function AnuleOP() {

        $query = $this->M_OP->TaskOpActive();

        if ($query['num'] > 0) {
            $res = "TASK-ACTIVE";
        } else {

            $query = $this->M_OP->TaskOpStatus(13);

            if ($query['num'] > 0) {
                $res = "TASK-CLOSE";
            } else {

                $data = array(
                    "id_estado" => 4, //ANULADO
                    "fecha_cierre" => date('Y-m-d H:i:s'),
                    "user_cierre" => $this->session->IdUser
                );
                $result = $this->M_OP->UpdateStatusOP($data);

                if ($result) {
                    $res = "OK";
                    $texto = "La OP ha sido ANULADA por " . $this->session->NameUser;
                    $this->M_OP->Tmp(null, $texto, $this->input->post("id_op"));
                    $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/CierreOP.php";
                    if (SO_SERVER == 'windows') {
                        $cmd = "C:/xampp/php/php.exe $ruta";
                        pclose(popen("start /B " . $cmd, "w"));
                    } else {
                        exec("php -f $ruta > /dev/null &");
                    }
                } else {
                    $res = "ERROR SQL";
                }
            }
        }
        echo json_encode(array("res" => $res));
    }
    
    function CloseOPMasiv(){
        $result = $this->M_OP->TaskOpTV();
        
        if ($result['num'] <= 0) {
            $res = "TASK-TV";
        } else {
            
            $this->M_OP->CloseTaskMasiv();
            
            $data = array(
                "id_estado" => 13, //cerrado
                "fecha_cierre" => date('Y-m-d H:i:s'),
                "user_cierre" => $this->session->IdUser
            );
            $result = $this->M_OP->UpdateStatusOP($data);

            if ($result) {
                $res = "OK";
                $texto = "La OP ha sido finalizada por " . $this->session->NameUser;
                $this->M_OP->Tmp(null, $texto, $this->input->post("id_op"));
                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/CierreOP.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd, "w"));
                } else {
                    exec("php -f $ruta > /dev/null &");
                }
            }
        }

        echo json_encode(array("res" => $res));
    }

    function CloseOP() {

        $result = $this->M_OP->TaskOpActive();

        if ($result['num'] > 0) {
            $res = "TASK-ACTIVE";
        } else {
            $data = array(
                "id_estado" => 13, //cerrado
                "fecha_cierre" => date('Y-m-d H:i:s'),
                "user_cierre" => $this->session->IdUser
            );
            $result = $this->M_OP->UpdateStatusOP($data);

            if ($result) {
                $res = "OK";
                $texto = "La OP ha sido finalizada por " . $this->session->NameUser;
                $this->M_OP->Tmp(null, $texto, $this->input->post("id_op"));
                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/CierreOP.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd, "w"));
                } else {
                    exec("php -f $ruta > /dev/null &");
                }
            }
        }

        echo json_encode(array("res" => $res));
    }

    function CloseTask() {
        $data = array(
            "id_estado" => 13, //cerrado
            "fecha_cierre" => date('Y-m-d H:i:s'),
            "user_cierre" => $this->session->IdUser
        );
        
        if($this->input->post("pay") == 0){
            $data['id_tarifa_servicio'] = 251;
        }

        $result = $this->M_OP->CloseTask($data);

        if ($result) {
            $res = "OK";

            $data = array(
                "id_tarea" => $this->input->post("id_tarea"),
                "id_user" => $this->session->IdUser,
                "tipo" => "TEXTO",
                "texto" => "Cambio de estado a CERRADA",
                "update" => 1
            );
            $this->M_OP->NewComment($data);

            $texto = "La tarea ha sido finalizada ";
            $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/CloseTask.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        } else {
            $res = "Error: " . $this->db->last_query();
        }

        echo json_encode(array("res" => $res));
    }

    function UpdateTask() {
        $id_tarea = $this->input->post("id_tarea");

        $result = $this->M_OP->UpdateTask();
        if ($result['res'] == 'OK') {

            $texto = "La tarea ha sido actualizada";
            $this->M_OP->Tmp($id_tarea, $texto);
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Actualizacion.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        }

        echo json_encode($result);
    }

    function GeneratePpto() {
       
        $verificarPpto = true;
        
        if ($this->input->post('opcion') == 'add') { //existente
            $pptos = str_replace(',', '-', $this->input->post('ppto'));

            $array = explode('-', $pptos);

            foreach ($array as $v) {
                $verificarPpto = $this->M_OP->VerificarPPtoMedios($this->input->post('type'), $v);
                if (!$verificarPpto) {
                    break;
                }
            }
            
            if ($verificarPpto) {
                
                $array_task = explode(',', $this->input->post('tasks'));
                foreach ($array_task as $t) {
                    
                    $result = $this->M_OP->TaskOpEnable($t);
                    $ppto = (empty($result['rows']->presupuesto) ? $pptos : $result['rows']->presupuesto . '-' . $pptos);
                    
                    foreach ($array as $v) {
                        $this->M_OP->DetailPptoTask($v, $this->input->post('type'), $this->input->post('t_servicio'), $t);
                    }
                    
                    $d = array('presupuesto' => $ppto);
                    $rta = $this->M_OP->UpdateTaskPpto($d, $ppto, $t);
                }
            }
        } else {

            $result_param = $this->M_OP->Params();


            $id_medios = 92;
            if ($this->session->has_userdata('UserMedios')) {
                $id_medios = $this->session->UserMedios;
            }

            $this->db->trans_begin();
            $fecha = date('Y-m-d');


            
            switch ($this->input->post('type')) {
                case 1://Aviso OK
                    $table = "presup_avisos";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['psav_fecha'] = $fecha;
                    $data['psav_total'] = 0;
                    $data['psav_estado'] = 1;
                    $data['psav_spa'] = $result_param->spa;
                    $data['psav_iva'] = $result_param->iva;
                    $data['psav_ivaspa'] = $result_param->ivaspa;
                    $data['usr_id_crea'] = $id_medios;
                    $data['usr_id_mod'] = $id_medios;
                    break;
                case 2://Clasificado
                    $table = "presup_clasificados";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['pscf_fecha'] = $fecha;
                    $data['pscf_total'] = 0;
                    $data['pscf_estado'] = 1;
                    $data['pscf_spa'] = $result_param->spa;
                    $data['pscf_iva'] = $result_param->iva;
                    $data['pscf_ivaspa'] = $result_param->ivaspa;
                    $data['usr_id'] = $id_medios;
                    break;
                case 3://Revista
                    $table = "presup_revis";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['psrev_fecha'] = $fecha;
                    $data['psrev_total'] = 0;
                    $data['psrev_estado'] = 1;
                    $data['usr_id_crea'] = $id_medios;
                    $data['psrev_spa'] = $result_param->spa;
                    $data['psrev_iva'] = $result_param->iva;
                    $data['psrev_ivaspa'] = $result_param->ivaspa;
                    break;
                case 4://Radio
                    $table = "presup_radio";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['psrad_fecha'] = $fecha;
                    $data['psrad_total'] = 0;
                    $data['psrad_estado'] = 1;
                    $data['usr_id'] = $id_medios;
                    $data['psrad_spa'] = $result_param->spa;
                    $data['psrad_iva'] = $result_param->iva;
                    $data['psrad_ivaspa'] = $result_param->ivaspa;
                    break;
                case 5://Television
                    $table = "presup_tv";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['pstv_fecha'] = $fecha;
                    $data['pstv_total'] = 0;
                    $data['pstv_estado'] = 1;
                    $data['usr_id_crea'] = $id_medios;
                    $data['pstv_spa'] = $result_param->spa;
                    $data['pstv_iva'] = $result_param->iva;
                    $data['pstv_ivaspa'] = $result_param->ivaspa;
                    break;
                case 6://Externa
                    $table = "presup_prode";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['psex_fecha'] = $fecha;
                    $data['psex_total'] = 0;
                    $data['psex_estado'] = 1;
                    $data['usr_id_crea'] = $id_medios;
                    $data['psex_spa'] = $result_param->spa;
                    $data['psex_iva'] = $result_param->iva;
                    $data['psex_ivaspa'] = $result_param->ivaspa;
                    break;
                case 7://Interna     OK
                    $table = "presup_prodi";
                    $data['cod_ser'] = $this->input->post('t_servicio');
                    $data['psin_fechpresup'] = $fecha;
                    $data['psin_total'] = 0;
                    $data['psin_estado'] = 1;
                    $data['usr_id_crea'] = $id_medios;
                    $data['psin_iva'] = $result_param->iva;
                    break;
                case 8://Exterior
                    $table = "publicidad_exterior";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['pubext_fecha'] = $fecha;
                    $data['pubext_total'] = 0;
                    $data['est_id'] = 1;
                    $data['usr_id'] = $id_medios;
                    $data['pubext_spa'] = $result_param->spa;
                    $data['pubext_iva'] = $result_param->iva;
                    $data['pubext_ivaspa'] = $result_param->ivaspa;
                    break;
                case 9://Impreso
                    $table = "impresos";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['imp_fecha'] = $fecha;
                    $data['imp_total'] = 0;
                    $data['est_id'] = 1;
                    $data['usr_id'] = $id_medios;
                    $data['imp_spa'] = $result_param->spa;
                    $data['imp_iva'] = $result_param->iva;
                    $data['imp_ivaspa'] = $result_param->ivaspa;
                    break;
                case 10://Articulo
                    $table = "art_publi";
                    $data['tpsv_id'] = $this->input->post('t_servicio');
                    $data['artp_fecha'] = $fecha;
                    $data['artp_total'] = 0;
                    $data['est_id'] = 1;
                    $data['usr_id'] = $id_medios;
                    $data['artp_spa'] = $result_param->spa;
                    $data['artp_iva'] = $result_param->iva;
                    $data['artp_ivaspa'] = $result_param->ivaspa;
                    break;

                default:
                    $table = "";
                    break;
            }
            if ($table != "") {
                $create_ppto = false;
                $array_task = explode(',', $this->input->post('tasks'));
                foreach ($array_task as $t) {
                    
                    $result = $this->M_OP->TaskOpEnable($t); 
                    $data["id_op"] = $result['rows']->id_op;
                    $data["pvcl_id_clie"] = $result['rows']->id_cliente; 
                    $data["pdcl_id"] = $result['rows']->producto;
                    $data["camp_id"] = $result['rows']->id_campana; 
                    $data["num_impresiones"] = "-1";

                    $rta = $this->M_OP->CreatePpto($table, $data, $t, (empty($result['rows']->presupuesto) ? '' : $result['rows']->presupuesto . '-'), $this->input->post('t_servicio'),$create_ppto);
                    $create_ppto = $rta['id'];
                    $this->M_OP->DetailPptoTask($create_ppto, $this->input->post('type'), $this->input->post('t_servicio'), $t);
                }
            }
        }

        if ($verificarPpto) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $res = array("res" => "ERROR");
            } else {
                $this->db->trans_commit();

                $texto = $this->session->NameUser . " Ha generado presupuesto para la tarea No " . $this->input->post("id_tarea");
                $this->M_OP->Tmp($this->input->post("id_tarea"), $texto, $result['rows']->id_op);
                
                $res = $rta;
            }
        } else {
            $res = array("res" => "ERROR MEDIOS");
        }

        echo json_encode($res);
    }

    function ChangeStatus() {
        $result = $this->M_OP->ChangeStatus();

        if ($result) {
            $res = "OK";

            $txt = "Cambio de estado a " . $this->input->post("estado");

            switch ($this->input->post("id_estado")) {
                case '16':
                    $txt = 'Solicitó nueva cotización';
                    break;
                case '17':
                    $txt = 'Solicitó Aprobación a la cotización';
                    break;
                case '19':
                    $txt = 'Solicitó Ajustes';
                    break;
                case '20':
                    $txt = 'Solicitó Aprobación';
                    break;
                case '21':
                    $txt = 'Aprobó la tarea';
                    break;

                default:

                    break;
            }

            $data = array(
                "id_tarea" => $this->input->post("id_tarea"),
                "id_user" => $this->session->IdUser,
                "tipo" => "TEXTO",
                "texto" => $txt,
                "update" => 1
            );
            $this->M_OP->NewComment($data);

            $texto = "La tarea ha sido " . $this->input->post("estado");
            $this->M_OP->Tmp($this->input->post("id_tarea"), $texto);
            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/CloseTask.php";
            if (SO_SERVER == 'windows') {
                $cmd = "C:/xampp/php/php.exe $ruta";
                pclose(popen("start /B " . $cmd, "w"));
            } else {
                exec("php -f $ruta > /dev/null &");
            }
        } else {
            $res = "Error ";
        }

        echo json_encode(array("res" => $res));
    }

    function AddTime() {
        $result = $this->M_OP->AddTime();
        echo json_encode(array("res" => $result));
    }

    function GenerateRowUnidad() {
        $arrayModal['unidades'] = $this->M_OP->ListarUnidades();
        $arrayModal['modalidades'] = $this->M_OP->ListarModalidadCobro();
        $arrayModal['area_responsable'] = $this->M_OP->ListarAreas();
        $arrayModal['cont'] = $this->input->post('cont');
        $arrayModal['usuarios'] = $this->M_OP->ListarUsuarios();
        $formModal = $this->load->view('OP/V_Form_Modal', $arrayModal, true);

        echo $formModal;
    }

    function AjustSend() {
        $result = $this->NewComment();

        $this->M_OP->UpdateTaskPpto(array('id_estado' => 19), false); // 19 = por ajustar
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

        $sheet = $objXLS->getSheetByName("Tareas");

        $error = array();
        $insert = 0;
        $row = 6;
        $loop = ($sheet->getCell("A{$row}")->getValue() == '') ? false : true;
        $tareas = array();
        $tareasMedios = array();
        $tareasRadio = array();

        while ($loop) {
            if ($sheet->getCell("A{$row}")->getValue() != '' && $sheet->getCell("B{$row}")->getValue() && $sheet->getCell("C{$row}")->getValue() && $sheet->getCell("D{$row}")->getValue() && $sheet->getCell("E{$row}")->getValue()) {
                $arr = array(
                    'id_op' => $this->input->post('id_op'),
                    'fecha_entrega' => $sheet->getCell("B{$row}")->getValue(),
                    'modalidad_cobro' => $sheet->getCell("A{$row}")->getValue(),
                    'descripcion' => $sheet->getCell("E{$row}")->getValue(),
                    'id_responsable' => $this->M_OP->SearchDigital($sheet->getCell("D{$row}")->getValue()),
                );

                if ($sheet->getCell("B1")->getValue() == 'DIGITAL') {
                    $arr['id_tarifa_servicio'] = $this->M_OP->SearchTarifa($sheet->getCell("C{$row}")->getValue(), 'MULTIMEDIA');
                    $arr['id_unidad'] = 4; //Digital
                    $arr['id_categoria'] = 14; //Digital
                    $arr['area_responsable'] = 5; //Digital
                    $arr['notificados'] = 85; //DAVID
                } else if ($sheet->getCell("B1")->getValue() == 'TV') {
                    $taskMedios = $arr;

                    //se crea tarea para diseño
                    $arr['id_tarifa_servicio'] = $this->M_OP->SearchTarifa($sheet->getCell("C{$row}")->getValue(), 'TELEVISION');
                    $arr['id_unidad'] = 5; //Diseño
                    $arr['id_categoria'] = 15; //Diseño
                    $arr['area_responsable'] = 1; //Creativos
                    $arr['notificados'] = '45,43,12'; //JUAN CARLOS SANTIAGO,LUIFER,JOSE BOLAÑO
                    $arr['texto'] = $sheet->getCell("F{$row}")->getValue(); //HOY MAÑANA
                    //TAREA PARA QUE MEDIOS COTICE EMISION,CODIFICACION,TRANSFER
                    $taskMedios['descripcion'] = strtoupper($sheet->getCell("C{$row}")->getValue()) . '<hr />' . $taskMedios['descripcion'];
                    $taskMedios['fecha_inicio'] = $sheet->getCell("G{$row}")->getValue();
                    $taskMedios['modalidad_cobro'] = 'COTIZAR';
                    $taskMedios['id_responsable'] = 8; //jennyfer
                    $taskMedios['id_tipo_servicio'] = 75; //TV.-COMERCIALES
                    $taskMedios['id_unidad'] = 3; //Produccion
                    $taskMedios['id_categoria'] = 5; //TV
                    $taskMedios['area_responsable'] = 4; //Medios
                    $taskMedios['notificados'] = '62,63'; //mapi y gise
                    $taskMedios['texto'] = $sheet->getCell("F{$row}")->getValue(); //HOY MAÑANA
                    $tareasMedios[] = $taskMedios;

                    $taskRadio = $arr;
                    //TAREA PARA QUE RADIO CREE EL AUDIO
                    $taskRadio['descripcion'] = 'PRODUCCIÓN DE AUDIO<hr />' . $taskRadio['descripcion'];
                    $taskRadio['id_tarifa_servicio'] = 167; //PRODUCCION DE CUÑAS O AUDIOS
                    $taskRadio['id_responsable'] = 56; //carlos solano
                    $taskRadio['texto'] = $sheet->getCell("F{$row}")->getValue(); //HOY MAÑANA
                    $tareasRadio[] = $taskRadio;
                }

                $tareas[] = $arr;

                $row++;
                $loop = ($sheet->getCell("A$row")->getValue() == '') ? false : true;
            } else {
                $loop = false;
                $error[] = 'Las columnas deben estar diligenciadas en su totalidad, no se aceptan vacias';
            }
        }

        $maxId = $this->M_OP->MaxIdtask();

        if (count($tareas) > 0 && count($error) <= 0):
            $insert = $this->M_OP->SaveImportTask($tareas);
        endif;

        if (count($tareasMedios) > 0 && count($error) <= 0):
            $insert = $this->M_OP->SaveImportTask($tareasMedios);
        endif;

        if (count($tareasRadio) > 0 && count($error) <= 0):
            $insert = $this->M_OP->SaveImportTask($tareasRadio);
        endif;

        if ($insert > 0) {
            $taskEmail = $this->M_OP->SelectTaskEmail($maxId);

            foreach ($taskEmail as $value) {
                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/SendMail/Send.php";
                if (SO_SERVER == 'windows') {
                    $cmd = "C:/xampp/php/php.exe $ruta";
                    pclose(popen("start /B " . $cmd . " --op=newtask --id_tarea=" . $value->id_tarea . " --creador=" . $this->session->IdUser, "w"));
                } else {
                    exec("php -q $ruta --op=newtask --id_tarea=" . $value->id_tarea . " --creador=" . $this->session->IdUser . " > /dev/null &");
                }
            }
        }

        $objXLS->disconnectWorksheets();
        unset($objXLS);
        unlink(dirname(__FILE__) . '/../../../Adjuntos/temp/' . $name);
        return array("0" => $error, "1" => $insert);
    }


}
