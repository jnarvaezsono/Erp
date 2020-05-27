<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Order_Cost extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model('Managerbudget/O_Cost/M_Order_Cost');
    }
    
    public function GetList() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,RANGOPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        foreach ($this->M_Order_Cost->LoadButtonPermissions("COSTO") as $btn) {
            $data[$btn->name] = $btn->name;
        }
        
        $data['proveedores'] = $this->M_Order_Cost->ListarProveedoresNew();
        $data['orders'] = $this->M_Order_Cost->GetOrderDupli();
        
        $this->load->view('Managerbudget/O_Cost/V_Panel', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,MOMENT, RANGOPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function GetListTable($order,$fecha_ini,$fecha_fin,$proveedor) {
        $rows = $this->M_Order_Cost->GetPptoCompleteInfo($this->input->get('start'), $this->input->get("length"), $order,$fecha_ini,$fecha_fin,$proveedor);
        $rows2 = $this->M_Order_Cost->GetPptoCompleteInfo(false, false,$order,$fecha_ini,$fecha_fin,$proveedor);
        
        $btns = $this->M_Order_Cost->LoadButtonPermissions("COSTO");
        
        foreach ($btns as $btn) {
            $button = $btn->name;
            $$button = $button;
        }
        
        $array = array();
        foreach ($rows['result'] as $v) { 
            
            $btn = '<div class="btn-group btnI'.$v->id.'" obs="'.$v->ordcos_guia.'" >
                        <button  type="button" class="btn1-'.$v->id.' btn btn-'.$v->est_color.' btn-xs btn-left">'.$v->estado.'</button>
                            <button type="button" class="btn2-'.$v->id.' btn btn-'.$v->est_color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>';
            
            $btn    .= '<ul class="dropdown-menu u-'.$v->id.'" role="menu">';
            $btn    .= '<li onclick="printPdf('.$v->id.',0)"><a href="#"><i class="fa fa-fw fa-print" ></i> Imprimir</a></li>';
            $btn    .= '<li onclick="Download('.$v->id.')"><a href="#"><i class="fa fa-fw fa-download" ></i> Descargar</a></li>';
            
            $btn    .= (isset($BtnEditOrder) && ($v->id_estado == 1 && $v->impresiones == -1))? '<li onclick="EditOrder('.$v->id.')"><a href="#"><i class="fa fa-fw fa-edit"></i> Editar</a></li>':'';
            $btn    .= (isset($BtnAddOrderObs) && ($v->id_estado != 7 && $v->id_estado != 39 && $v->id_estado != 9999 ))? '<li onclick="openModal('.$v->id.')" ><a href="#"><i class="fa fa-fw fa-plus"></i> Add Observación</a></li>':'';
            $btn    .= (isset($BtnAnuleOrder) && ($v->id_estado != 39 && $v->id_estado != 9999))? '<li onclick="Anule('.$v->id.')"><a style="color: red;" href="#"><i class="fa fa-fw fa-trash-o"></i> Anular</a></li>':'';
            $btn    .= '</ul></div>';
            

            $array[] = array($v->id, $v->fecha, $v->cliente, $v->proveedor, $v->campana,$v->usuario, $btn, number_format($v->total,0,',','.'));
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $rows2['num'], 'datos' => $array));
    }
    
    public function Edit($id){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['id'] = $id;
        $data['row'] = $this->M_Order_Cost->GetOrder($id);
        $data['clientes'] = $this->M_Order_Cost->ListarClientesNew();
        $data['campanas'] = $this->M_Order_Cost->ListarCampana($data['row']->cliente);
        $data['rubros'] = $this->M_Order_Cost->ListarRubro($data['row']->cliente);
        $data['servicios'] = $this->M_Order_Cost->LoadServices($data['row']->tipo);
        $data['proveedores'] = $this->M_Order_Cost->ListarProveedoresNew();
        $detail = $this->M_Order_Cost->ListDetail($id);
        
        $data['detail'] = $this->load->view('Managerbudget/O_Cost/V_Table_Detail',array('detail'=>$detail),true);
        $this->load->view('Managerbudget/O_Cost/V_Form_Update',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function NewP() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS,DATEPICKER_CSS,TIMEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        
        $data['clientes'] = $this->M_Order_Cost->ListarClientesNew(false,true);
        $data['servicios'] = $this->M_Order_Cost->LoadServices('I');
        $data['proveedores'] = $this->M_Order_Cost->ListarProveedoresNew();
        $data['detail'] = $this->load->view('Managerbudget/O_Cost/V_Table_Detail',array('detail'=>array()),true);
        $this->load->view('Managerbudget/O_Cost/V_Form_New',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS,DATEPICKER_JS, AUTO_NUMERIC,TIMEPICKER_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function InsertInfo(){
        $result = $this->M_Order_Cost->InsertInfo($_POST);
        echo json_encode($result);
    }
    
    function UpdateInfo(){
        $order = $this->input->post('order');
        
        unset($_POST['order']);
        
        $_POST['usr_id_mod'] = $this->session->UserMedios;
             
        $result = $this->M_Order_Cost->UpdateInfo($order,$_POST);
        echo json_encode(array('res'=>$result));
    }
    
    function AddDetail(){
        $id = $this->input->post('ordcos_id');
        $result = $this->M_Order_Cost->AddDetail($_POST,$id);
        $reverse = '';
        $msg = '';
        if($result['res'] == 'OK'){
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_valor'=>$result['valor']));
            $total = $this->M_Order_Cost->ValorTotal($id);
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_total'=>$total->total));
            
            $rsRow = $this->M_Order_Cost->SelectRow('ord_costos', 'ordcos_id', $id);
            $validate = $this->ValidateCredit($rsRow->pvcl_id_clie, false, 0);
            
            if ($validate['res'] == 'LOCKED'):
                $_POST['id_detalle'] = $result['id_detalle'];
               
                $this->DeleteDetail(false);
                $reverse = 'OK';
                $msg = $validate['msg'];
            endif;
        }
        echo json_encode(array('res' => $result['res'], 'reverse'=>$reverse, 'msg'=>$msg));
    }
    
    function DeleteDetail($response = true){
        $id = $ppto = $this->input->post('ordcos_id');
        $result = $this->M_Order_Cost->DeleteDetail($id,$this->input->post('id_detalle'));
        if($result['res'] == 'OK'){
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_valor'=>$result['valor']));
            $total = $this->M_Order_Cost->ValorTotal($id);
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_total'=>$total->total));
        }
        if($response){
            echo json_encode(array('res'=>$result['res']));
        }
        
    }
    
    function UpdateDetail(){
        $id = $this->input->post('ordcos_id');
        $reverse = '';
        $msg = '';
        $old = $this->M_Order_Cost->SelectRow('det_ordcostos','dordcos_id',$this->input->post('dordcos_id'));
        $row = $this->M_Order_Cost->ValorTotal($id);
        
        $result = $this->M_Order_Cost->UpdateDetail($_POST,$id,$this->input->post('dordcos_id'));
        if($result['res'] == 'OK'){
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_valor'=>$result['valor']));
            $total = $this->M_Order_Cost->ValorTotal($id);
            $this->M_Order_Cost->UpdateInfo($id,array('ordcos_total'=>$total->total));
            
            if($total->total > $row->total){
                $validate = $this->ValidateCredit($row->pvcl_id_clie, false, 0);
                
                if ($validate['res'] == 'LOCKED'):
                    $result = $this->M_Order_Cost->UpdateDetail($old,$id,$this->input->post('dordcos_id'));
                    $this->M_Order_Cost->UpdateInfo($id,array('ordcos_valor'=>$result['valor']));
                    $this->M_Order_Cost->UpdateInfo($id,array('ordcos_total'=>$row->total));
                    $reverse = 'OK';
                    $msg = $validate['msg'];
                endif;
            }
            
        }
        echo json_encode(array('res' => $result['res'], 'reverse'=>$reverse, 'msg'=>$msg));
    }
    
    function AddObs(){
        $result = $this->M_Order_Cost->AddObs($this->input->post('id'),$this->input->post('obs'));
        echo json_encode(array('res'=>$result));
    }
    
    function Anule(){
        $result = $this->M_Order_Cost->UpdateStatus($this->input->post('order'), $this->input->post('status'));
        echo json_encode(array('res'=>$result));
    }
    
    function LoadServices(){
        $result = $this->M_Order_Cost->LoadServices($this->input->post('tipo'));
        echo json_encode(array('services'=>$result));
    }
    
    function PrintOrder($id, $return = false){
        $result = $this->M_Order_Cost->GetPptoCompleteInfo(false, false, $id,'all','all','all');
        $result['detail'] = $this->M_Order_Cost->GetDetail($id);
        
        

        if($return){
            $html = $this->load->view('Managerbudget/O_Cost/V_Down',$result,$return);
            return $html;
        }else{
            $html = $this->load->view('Managerbudget/O_Cost/V_Pdf',$result);
        }
        
    }
    
    function LoadSelect(){
        $data =  array(
            'cliente'=>$this->input->post('cliente'),
            'campana'=>$this->input->post('campana'),
            'producto'=>$this->input->post('producto'),
            'servicio'=>$this->input->post('servicio')
        );
            
        $data['pptos'] = $this->M_Order_Cost->GetPPtos((object) $data);
        echo json_encode($data);
    }
    
    function UpdatePrint(){
        $this->M_Order_Cost->UpdateStatus($this->input->post('id'), $this->input->post('status'));
    }
    
    function DownloadOrder($id){
        
        require_once(dirname(__FILE__) . '/../../../includes/html2pdf_v4.03/html2pdf.class.php');
        
        $html = $this->PrintOrder($id,true);
        
        $pdf = new HTML2PDF('P', 'A4', 'fr', 'true', 'UTF-8');
        $pdf->WriteHTML($html);
        ob_end_clean();
        $pdf->Output('Orden_costo_'.$id.'.pdf','D');
        
    }
    
    function CopyMasive(){
        $array = explode(',', $this->input->post('orders'));
        sort($array);
        foreach ($array as $value) {
            $result = $this->M_Order_Cost->Copy($value);
        }
        echo json_encode($result);
    }
    
    function Control($op){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS,ALERTIFY_CSS2,SELECT2_CSS,SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $result = $this->M_Order_Cost->Receivable();
        $arrayPaid = array();
        $arrayReceivable = array();
        foreach ($result as $value) :
            
            $pptos = explode(',', $value->no_presup);
            $newValues=array_filter($pptos, "strlen");
                
            $total = 0;

            foreach ($newValues as $v) {
                $resppto = $this->M_Order_Cost->GetPptoT($v,$value->tpo_presup);

                if($resppto->estado != 'Anulado')
                    $total = $total + $resppto->total;

            }
            $diferencia = $total - $value->ordcos_total;
            
            if($diferencia >= 0){
                $style = 'background-color: #31bd3147;';
                if($value->estado != 'Anulado'){
                    $arrayPaid[] = array('usuario'=>$value->usuario,'fecha'=>$value->fecha,'orden'=>$value->ordcos_id,'estado'=>$value->estado,'total_orden'=>$value->ordcos_total,'total_ppto'=>$total,'diferencia'=>$diferencia,'style'=>$style,'cliente'=>$value->cliente);
                }
            }else if($diferencia < 0){
                $style = 'background-color: #bd313147;';
                if($value->estado != 'Anulado'){
                    $arrayReceivable[] = array('usuario'=>$value->usuario,'fecha'=>$value->fecha,'orden'=>$value->ordcos_id,'estado'=>$value->estado,'total_orden'=>$value->ordcos_total,'total_ppto'=>$total,'diferencia'=>$diferencia,'style'=>$style,'cliente'=>$value->cliente);
                }
            }
                
        endforeach;
        if($op == 'Paid'){
            $data['nPaid'] = $this->load->view('Managerbudget/O_Cost/V_Table_Order',array('table'=>'1','result'=>$arrayPaid),true);
        }else{
            $data['nReceivable'] = $this->load->view('Managerbudget/O_Cost/V_Table_Order',array('table'=>'2','result'=>$arrayReceivable),true);
        }
        
        $this->load->view('Managerbudget/O_Cost/V_Order',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS,SELECT2_JS,SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ordenes2(){
        
        echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
        
        $result = $this->M_Order_Cost->Receivable();
        
        $tabla = "<table border>";
        $tabla .= "<tr>";
        $tabla .= "<th>ORDEN</th>";
        $tabla .= "<th>ESTADO</th>";
        $tabla .= "<th>CLIENTE</th>";
        $tabla .= "<th>CAMPAÑA</th>";
        $tabla .= "<th>PRODUCTO</th>";
        $tabla .= "<th>PPTOS</th>";
        $tabla .= "<th colspan='2'>VALOR ORDEN</th>";
        $tabla .= "<th colspan='2'>TOTAL ORDEN</th>";
        $tabla .= "<th colspan='2'>DIFERENCIA</th>";
        $tabla .= "</tr>";
            
        foreach ($result as $value) :
            $tabla .= "<tr>";
                $tabla .= "<td>".$value->ordcos_id."</td>";
                $tabla .= "<td>".$value->estado."</td>";
                $tabla .= "<td>".$value->cliente."</td>";
                $tabla .= "<td>".$value->campana."</td>";
                $tabla .= "<td>".$value->producto."</td>";
                $tabla .= "<td>".$value->no_presup."</td>";
                $tabla .= "<td>".$value->ordcos_valor."</td>";
                $tabla .= "<td style='background-color: burlywood;' >".number_format($value->ordcos_valor,'2',',','.')."</td>";
                $tabla .= "<td>".$value->ordcos_total."</td>";
                $tabla .= "<td style='background-color: burlywood;'>".number_format($value->ordcos_total,'2',',','.')."</td>";
                $tabla .= '<th colspan="2"></th>';
            $tabla .= "</tr>";
            
            $pptos = explode(',', $value->no_presup);
            $newValues=array_filter($pptos, "strlen");
                
                $total = 0;
            
                foreach ($newValues as $v) {
                    $resppto = $this->M_Order_Cost->ppto($v,$value->tpo_presup);
                    $tabla .= '<tr>';
                        $tabla .= '<td>'.$resppto->id.'</td>';
                        $tabla .= '<td>'.$resppto->estado.'</td>';
                        $tabla .= '<td colspan="4"></td>';
                        $tabla .= '<td>'.$resppto->valor.'</td>';
                        $tabla .= '<td>'.number_format($resppto->valor,'2',',','.').'</td>';
                        $tabla .= '<td>'.$resppto->total.'</td>';
                        $tabla .= '<td>'.number_format($resppto->total,'2',',','.').'</td>';
                        $tabla .= '<th colspan="2"></th>';
                        
                    $tabla .= '</tr>';
                    
                    if($resppto->estado != 'Anulado')
                        $total = $total + $resppto->total;
                    
                }
                $diferencia = $total - $value->ordcos_total;
                
                if($diferencia > 0){
                    $style = 'background-color: #31bd3147;';
                }else if($diferencia < 0){
                    $style = 'background-color: #bd313147;';
                    if($value->estado != 'Anulado'){
                        $arrayAll[] = array('usuario'=>$value->usuario,'orden'=>$value->ordcos_id,'estado'=>$value->estado,'total_orden'=>$value->ordcos_total,'total_ppto'=>$total,'diferencia'=>$diferencia);
                    }
                }else{
                    $style = 'background-color: #00000047;';
                }
                
            $tabla .= "<tr><td colspan='9'>TOTAL</td><td>".number_format($total,'2',',','.')."</td><td style='$style'>".number_format($diferencia,'2',',','.')."</td></tr>";
        endforeach;
        $tabla .= "</table>";
        
        $html = '<div class="container"><table class="table table-bordered"><thead><tr><th>Orden</th><th>Estado</th><th>Total Orden</th><th>Total Pptos</th><th>Diferencia</th><th>Usuario</th></tr></thead>';
        foreach ($arrayAll as $value) {
            $html .= '<tr>';
            $html .= '<td>'.$value["orden"].'</td>';
            $html .= '<td>'.$value["estado"].'</td>';
            $html .= '<td>$ '.number_format($value["total_orden"],"2",",",".").'</td>';
            $html .= '<td>$ '.number_format($value["total_ppto"],"2",",",".").'</td>';
            $html .= '<td>$ '.number_format($value["diferencia"],"2",",",".").'</td>';
            $html .= '<td>'.$value["usuario"].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table></div>';
//        echo $html;
        $this->load->view('Managerbudget/V_Orden', array('nCobradas'=>''));
        //echo $tabla;
        
        echo '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>';
    }

}
