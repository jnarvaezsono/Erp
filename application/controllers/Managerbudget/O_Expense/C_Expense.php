<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Expense extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Managerbudget/O_Expense/M_Expense');
    }
    
    public function GetList() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        foreach ($this->M_Expense->LoadButtonPermissions("GASTO") as $btn) {
            $data[$btn->name] = $btn->name;
        }
        
        $data['proveedores'] = $this->M_Expense->ListarProveedoresNew();
        
        $this->load->view('Managerbudget/O_Expense/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,MOMENT, RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function GetListTable($order,$fecha_ini,$fecha_fin,$proveedor) {
        $rows = $this->M_Expense->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), $order,$fecha_ini,$fecha_fin,$proveedor);
        $rows2 = $this->M_Expense->GetPptoCompleteInfo(false, false,$order,$fecha_ini,$fecha_fin,$proveedor);
        
        $btns = $this->M_Expense->LoadButtonPermissions("GASTO");
        
        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        
        $array = array();
        foreach ($rows['result'] as $v) { 
            
            $btn = '<div class="btn-group btnI'.$v->id.'"  >
                        <button  type="button" class="btn1-'.$v->id.' btn btn-'.$v->est_color.' btn-xs btn-left">'.$v->estado.'</button>
                            <button type="button" class="btn2-'.$v->id.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
            
            $btn    .= '<ul class="dropdown-menu u-'.$v->id.'" role="menu">';
            $btn    .= '<li onclick="printPdf('.$v->id.')"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn    .= (isset($BtnEditOrder) && ($v->id_estado == 1 && $v->impresiones == -1))? '<li onclick="EditOrder('.$v->id.')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>':'';
            $btn    .= (isset($BtnAnuleOrder) && ($v->id_estado != 39 && $v->id_estado != 9999))? '<li onclick="Anule('.$v->id.')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>':'';
            $btn    .= '</ul></div>';
            
            $array[] = array($v->id, $v->fecha, $v->proveedor, $v->usuario, $btn, number_format($v->total,0,',','.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }
    
    function Anule(){
        $result = $this->M_Expense->UpdateStatus($this->input->post('order'), $this->input->post('status'));
        echo json_encode(array('res'=>$result));
    }
    
    function PrintOrder($id, $return = false){
        $result = $this->M_Expense->GetPptoCompleteInfo(false, false, $id,'all','all','all');
        $result['detail'] = $this->M_Expense->GetDetail($id);
        
        if($return){
            $html = $this->load->view('Managerbudget/O_Expense/V_Down',$result,$return);
            return $html;
        }else{
            $html = $this->load->view('Managerbudget/O_Expense/V_Pdf',$result);
        }
        
    }
    
    function UpdatePrint(){
        $this->M_Expense->UpdateStatus($this->input->post('id'), $this->input->post('status'));
    }
    
    public function Edit($id){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['id'] = $id;
        $data['row'] = $this->M_Expense->GetOrder($id);
        $data['proveedores'] = $this->M_Expense->ListarProveedoresNew();
        $detail = $this->M_Expense->ListDetail($id);
        
        $data['detail'] = $this->load->view('Managerbudget/O_Expense/V_Table_Detail',array('detail'=>$detail),true);
        $this->load->view('Managerbudget/O_Expense/V_Form_Update',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function UpdateInfo(){
        $order = $this->input->post('order');
        
        unset($_POST['order']);
        
        $_POST['ordgas_usuariomod'] = $this->session->UserMedios;
             
        $result = $this->M_Expense->UpdateInfo($order,$_POST);
        echo json_encode(array('res'=>$result));
    }
    
    function AddDetail(){
        $id = $this->input->post('ordgas_id');
        $result = $this->M_Expense->AddDetail($_POST,$id);
        if($result['res'] == 'OK'){
            $this->M_Expense->UpdateInfo($id,array('ordgas_valor'=>$result['valor']));
            $total = $this->M_Expense->ValorTotal($id);
            $this->M_Expense->UpdateInfo($id,array('ordgas_total'=>$total));
        }
        echo json_encode(array('res'=>$result['res']));
    }
    
    function DeleteDetail(){
        $id = $ppto = $this->input->post('ordgas_id');
        $result = $this->M_Expense->DeleteDetail($id,$this->input->post('id_detalle'));
        if($result['res'] == 'OK'){
            $this->M_Expense->UpdateInfo($id,array('ordgas_valor'=>$result['valor']));
            $total = $this->M_Expense->ValorTotal($id);
            $this->M_Expense->UpdateInfo($id,array('ordgas_total'=>$total));
        }
        echo json_encode(array('res'=>$result['res']));
    }
    
    function UpdateDetail(){
        $id = $this->input->post('ordgas_id');
        $result = $this->M_Expense->UpdateDetail($_POST,$id,$this->input->post('dordgas_id'));
        if($result['res'] == 'OK'){
            $this->M_Expense->UpdateInfo($id,array('ordgas_valor'=>$result['valor']));
            $total = $this->M_Expense->ValorTotal($id);
            $this->M_Expense->UpdateInfo($id,array('ordgas_total'=>$total));
        }
        echo json_encode(array('res'=>$result['res']));
    }
    
    public function NewP() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['proveedores'] = $this->M_Expense->ListarProveedoresNew();
        $data['detail'] = $this->load->view('Managerbudget/O_Expense/V_Table_Detail',array('detail'=>array()),true);
        $this->load->view('Managerbudget/O_Expense/V_Form_New',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function InsertInfo(){
        $result = $this->M_Expense->InsertInfo($_POST);
        echo json_encode($result);
    }
  
}


