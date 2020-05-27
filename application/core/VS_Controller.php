<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ValidateSession() {
        if (!$this->session->has_userdata('IdUser')) {
            header('Location: ' . base_url());
            return false;
        }else if($this->session->count_time > 0){
            header('Location: ' . base_url().'Time/C_Time/MyTimes');
            return false;
        }
    }

    function SendEmail($emailTo, $cc, $subject, $html) {
        $this->load->library("phpmailer_lib");
        $mail = $this->phpmailer_lib->load();
        $mail->IsHTML(true);
        $mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 0;
        $mail->Host = "n3plvcpnl299716.prod.ams3.secureserver.net";
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "notificaciones@sonoffice.com";
        $mail->Password = "Vista2019*-*";
        $mail->SetFrom("notificaciones@sonoffice.com", "Info OP");
        $mail->CharSet = 'UTF-8';
        
        $mail->AddAddress($emailTo);
        
        $mail->Subject = $subject;

        $mail->Body = $html;
        $mail->AltBody = "Usted esta viendo este mensaje simple debido a que su servidor de correo no admite formato HTML.";
       

        $exito = $mail->Send();
        
        $intentos = 1;
        $res = "";
        
        if($exito)
            $res = "OK";
        
        while ((!$exito) && ($intentos < 3)) {
            sleep(3);
            $exito = $mail->Send();
            $intentos = $intentos + 1;
        }
        return $res;
    }
    
    function getDiasHabiles($month, $year, $diasferiados = array(), $saturday = false, $sunday = true, $time = false) {

        $fechainicio = $year . "-" . $month . "-01";
        $fechafin = $year . "-" . $month . "-" . date("d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));

        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24 * 60 * 60;

        // Arreglo de dias habiles, inicianlizacion
        $business_days = array();

        $arrayDay = array();
        if ($saturday) {
            $arrayDay[] = 6;
        }

        if ($sunday) {
            $arrayDay[] = 7;
        }
        
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            // Si el dia indicado, no es sabado o domingo es habil
            if (!in_array(date('N', $midia), $arrayDay)) { // DOC: http://www.php.net/manual/es/function.date.php
                // Si no es un dia feriado entonces es habil
                if(!$time){
                    if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                        array_push($business_days, array('fecha'=>date('Y-m-d', $midia),'num'=>date('N', $midia)));
                    }
                }else{
                    $fest = 1;
                    if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                        $fest = 0;
                    }
                    array_push($business_days, array('fecha'=>date('Y-m-d', $midia),'num'=>date('N', $midia), 'festivo'=>$fest));
                }
            }
        }

//        return array("days" => $business_days, "count" => count($business_days), "date-end" => $fechafin);
        return $business_days;
    }

    function getDiasHabiles2($fechainicio,$fechafin, $diasferiados = array(), $saturday = false, $sunday = true) {
      
//        $fechainicio = $year . "-" . $month . "-01";
//        $fechafin = $year . "-" . $month . "-" . date("d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));

        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24 * 60 * 60;

        // Arreglo de dias habiles, inicianlizacion
        $business_days = array();

        $arrayDay = array();
        if ($saturday) {
            $arrayDay[] = 6;
        }

        if ($sunday) {
            $arrayDay[] = 7;
        }

        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            // Si el dia indicado, no es sabado o domingo es habil
            if (!in_array(date('N', $midia), $arrayDay)) { // DOC: http://www.php.net/manual/es/function.date.php
                // Si no es un dia feriado entonces es habil
                if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($business_days, date('Y-m-d', $midia));
                }
            }
        }

//        return array("days" => $business_days, "count" => count($business_days), "date-end" => $fechafin);
        return $business_days;
    }

    function current_week($date) {

        $date2 = strtotime($date);
        $inicio0 = strtotime('sunday this week -1 week', $date2);

        $inicio = date('Y-m-d', $inicio0);
        
        $days = array();
        for ($i = 1; $i <= 7; $i++) {
            $days[] = date("Y-m-d", strtotime("$inicio +$i day"));
        }
        return $days;
    }
    
    function calcularDigitoVerificacion($nit) {
        $nit = $this->cleanCharacters($nit);
        $array = array(1=>'3',2=>'7',3=>'13',4=>'17',5=>'19',6=>'23',7=>'29',8=>'37',9=>'41',10=>'43',11=>'47',12=>'53',13=>'59',14=>'67',15=>'71');

        $count = strlen($nit);
      
        $x = 0;
        for ($i = 0; $i < $count; $i++) {
            $y = substr($nit,$i,1);
            $x += ($y * $array[$count-$i] ) ;
        }
        
        $y =  $x % 11;

        return ($y > 1)?11 - $y:$y;
    }
    
    function cleanCharacters($string){
        $string = trim($string);
        $string = htmlentities($string);
        $string = preg_replace('/\&(.)[^;]*;/', '\\1', $string);
        return $string;
    }
    
    function ValidateCredit($id_cliente,$ppto = false,$total,$response = false){
        $this->load->model('Managerbudget/M_Manager');
        
        $rowCli = $this->M_Manager->ListarClientesNew($id_cliente);
        
        if($rowCli->id_status == 9999){
            $array = array('res'=>'LOCKED','msg' =>'El cliente esta bloqueado');
        
        }else if($rowCli->total_credito > 0){
            $rsAdeudado = $this->M_Manager->getTotalPptoOc($id_cliente,$ppto);
            
            $saldo = ($rsAdeudado + $total) - ($rowCli->total_recaudado + $rowCli->total_retencion);
            
            if($rowCli->total_credito > $saldo){
                $array = array('res'=>'OK','saldo'=>$saldo);
            }else{
//                if(!$ppto){
//                    $this->M_Manager->lockClient($id_cliente,9999);
//                }
                
                $array = array('res'=>'LOCKED', 'saldo'=>$saldo,'msg' => 'El cliente '.$rowCli->nombre.' ha exedido el monto del crédito('.  number_format($rowCli->total_credito).') en un total de '.  number_format($saldo).'. Por favor comunicate con contabilidad');
            }
        }else{
            $array = array('res'=>'OK','saldo'=>0);
        }
        
        if($response){
            echo json_encode($array);
        }else{
            return $array;
        }
    }
    
}