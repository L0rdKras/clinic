<?php
define('FPDF_FONTPATH','font/');
require('pdf_js.php');
require("../helper/conversiones.php");

class PDF_AutoPrint extends PDF_Javascript
{

function Header()
{
	$fundo=utf8_decode('Clinica Dental');
	$this->SetFont('Times','B',12);
    $this->Cell(30,10,'Dr.');
    $this->Cell(130);
    $this->Cell(30,10,"Num Reserv: {$_GET['id']}");
    $this->ln(5);
    $this->Cell(30,10,$fundo);
    $this->SetFont('Times','B',12);
    $this->Ln(5);
    $this->Cell(30,10,'R.U.T. 79.703.020-1');
    $this->Ln(5);
    $this->Cell(30,10,'FONO: ');
    $this->Ln(10);


    $this->Cell(60);
    $this->SetFont('Times','B',14);
    $this->Cell(30,10,'COMPROBANTE RESERVA HORA');
    
    $this->SetFont('Times','B',12);
    $this->Ln();
	
}


}

function convierte_fecha($data)
{
	$fecha=explode("-",$data);	
	$mes="";
	switch($fecha[1]){
		case 1: $mes="Enero";
			break;
		case 2: $mes="Febrero";
			break;
		case 3: $mes="Marzo";
			break;
		case 4: $mes="Abril";
			break;
		case 5: $mes="Mayo";
			break;
		case 6: $mes="Junio";
			break;
		case 7: $mes="Julio";
			break;
		case 8: $mes="Agosto";
			break;
		case 9: $mes="Septiembre";
			break;
		case 10: $mes="Octubre";
			break;
		case 11: $mes="Noviembre";
			break;
		case 12: $mes="Diciembre";
			break;
	}
	
	
	return $fecha[2]." de ".$mes." del ".$fecha[0];
}

//Creación del objeto de la clase heredada
require "../Entidades/Consulta.php";
require "../Entidades/Agenda.php";
require "../Entidades/Atencion.php";
require "../Entidades/Paciente.php";
require "../Entidades/Horario.php";

extract($_GET);

$agenda = new Agenda();

$pdf=new PDF_AutoPrint('P','mm','letter');;
$pdf->AddPage();

$pdf->SetFont('Times','',10);
if($agenda->get_by_id($id) == true){
	
	//$pdf->SetXY(150,35);
	$pdf->Ln(15);
	$pdf->Cell(20,0,"Fecha Reserva : ".convierte_fecha($agenda->consultation_date));

	$paciente = $agenda->return_patient();
	$horario = $agenda->return_time();
	$atencion = $agenda->return_atention();
	
	$pdf->Ln(5);
	
	$pdf->Cell(20,0,"Hora Reserva : ".$horario->initiation);

	$pdf->Ln(5);

	$pdf->Cell(20,0,"Paciente : ".$paciente->first_name." ".$paciente->last_name);

	$pdf->Ln(5);

	$pdf->Cell(20,0,"RUT : ".$paciente->rut);

	$pdf->Ln(5);

	$pdf->Cell(20,0,"Telefono : ".$paciente->phone);

	$pdf->Ln(5);


	$pdf->Cell(20,0,"Atencion : ".$atencion->name);

	

	$pdf->SetFont('Times','',11);

	
}

$pdf->Output();
?>