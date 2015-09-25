<?php
define('FPDF_FONTPATH','font/');
require('pdf_js.php');
require("../helper/conversiones.php");

class PDF_AutoPrint extends PDF_Javascript
{

function Header()
{
	$fundo=utf8_decode('Clinica Dental San Antonio de Padua');
	$this->SetFont('Times','B',12);
    $this->Cell(30,10,'Dr. Antonio Vargas Crisostomo');
    
    $this->ln(5);
    $this->Cell(30,10,$fundo);
    $this->SetFont('Times','B',12);
    $this->Ln(5);
    //$this->Cell(30,10,'R.U.T. 79.703.020-1');
    //$this->Ln(5);
    $this->Cell(30,10,'FONO: 0512211568');
    $this->Ln(10);


    $this->Cell(60);
    $this->SetFont('Times','B',14);
    $this->Cell(30,10,'Atenciones');
    
    $this->SetFont('Times','B',12);
    $this->Ln();
	
}

public function devuelve_palabras($numero,$texto)
{
	//$numero=$row['TOTAL'];
    $extras= array("/[\$]/","/ /","/,/","/-/"); 
    $limpio=preg_replace($extras,"",$numero); 
    $partes=explode(".",$limpio); 
    if (count($partes)>2) { 
        return "Error, el n&uacute;mero no es correcto"; 
        exit(); 
    } 
     
    // Ahora explotamos la parte del numero en elementos de un array que 
    // llamaremos $digitos, y contamos los grupos de tres digitos 
    // resultantes 
     
    $digitos_piezas=chunk_split ($partes[0],1,"#"); 
    $digitos_piezas=substr($digitos_piezas,0,strlen($digitos_piezas)-1); 
    $digitos=explode("#",$digitos_piezas); 
    $todos=count($digitos); 
    $grupos=ceil (count($digitos)/3); 
     
    // comenzamos a dar formato a cada grupo 
     
    $unidad = array   ('UN','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE'); 
    $decenas = array ('DIEZ','ONCE','DOCE', 'TRECE','CATORCE','QUINCE'); 
    $decena = array   ('DIECI','VEINTI','TREINTA','CUARENTA','CINCUENTA'  ,'SESENTA','SETENTA','OCHENTA','NOVENTA'); 
    $centena = array   ('CIENTO','DOSCIENTOS','TRESCIENTOS','CUATROCIENTOS','QUINIENTOS','SEISIENTOS','SETECIENTOS','OCHOCIENTOS','NOVECIENTOS'); 
    $resto=$todos; 
     
    for ($i=1; $i<=$grupos; $i++) { 
         
        // Hacemos el grupo 
        if ($resto>=3) { 
            $corte=3; } else { 
            $corte=$resto; 
        } 
            $offset=(($i*3)-3)+$corte; 
            $offset=$offset*(-1); 
         
        // la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 
         
        $num=implode("",array_slice ($digitos,$offset,$corte)); 
        $resultado[$i] = ""; 
        $cen = (int) ($num / 100);              //Cifra de las centenas 
        $doble = $num - ($cen*100);             //Cifras de las decenas y unidades 
        $dec = (int)($num / 10) - ($cen*10);    //Cifra de las decenas 
        $uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 
        if ($cen > 0) { 
           if ($num == 100) $resultado[$i] = "CIEN"; 
           else $resultado[$i] = $centena[$cen-1].' '; 
        }//end if 
        if ($doble>0) { 
           if ($doble == 20) { 
              $resultado[$i] .= " VEINTE"; 
           }elseif (($doble < 16) and ($doble>9)) { 
              $resultado[$i] .= $decenas[$doble-10]; 
           }else { 
              $resultado[$i] .=' '. $decena[$dec-1]; 
           }//end if 
           if ($dec>2 and $uni<>0) $resultado[$i] .=' y '; 
           if (($uni>0) and ($doble>15) or ($dec==0)) { 
              if ($i==1 && $uni == 1) $resultado[$i].="UNO"; 
              elseif ($i==2 && $num == 1) $resultado[$i].=""; 
              else $resultado[$i].=$unidad[$uni-1]; 
           } 
        } 

        // Le agregamos la terminacion del grupo 
        switch ($i) { 
            case 2: 
            $resultado[$i].= ($resultado[$i]=="") ? "" : " MIL "; 
            break; 
            case 3: 
            $resultado[$i].= ($num==1) ? " MILLON " : " MILLONES "; 
            break; 
        } 
        $resto-=$corte; 
    } 
     
    // Sacamos el resultado (primero invertimos el array) 
    $resultado_inv= array_reverse($resultado, TRUE); 
    $final=""; 
    foreach ($resultado_inv as $parte){ 
        $final.=$parte; 
    }

    $this->Cell(50,0,"TOTAL EN PALABRAS ($texto): $final PESOS.-");
}

	public function Imprimir_tabla2($header,$campos,$w,$resultado_consulta,$tamaño_fuente,$agenda)
	{
	    //Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(204,255,229);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',$tamaño_fuente);
	    //Cabecera
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],$tamaño_fuente,utf8_decode($header[$i]),1,0,'C',1);
	    $this->Ln();
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('','B',$tamaño_fuente);
	    //Datos
	    $fill=false;

	    foreach ($resultado_consulta as $key => $value) {
	    	# code...
	    	$this->Cell($w[0],$tamaño_fuente-4,utf8_decode($value['initiation']),'1',0,'C',$fill);
	    	$this->Cell($w[1],$tamaño_fuente-4,utf8_decode($value['final']),'1',0,'C',$fill);
	    	if($value['id'] == NULL){
				$this->Cell($w[2],$tamaño_fuente-4,utf8_decode(""),'1',0,'C',$fill);
				$this->Cell($w[3],$tamaño_fuente-4,utf8_decode(""),'1',0,'C',$fill);
			}else{						
						//$paciente->get_by_id($value['patient_id']);
				$agenda->get_by_id($value['id']);

				$this->Cell($w[2],$tamaño_fuente-4,utf8_decode($agenda->return_patient()->last_name.",".$agenda->return_patient()->first_name),'1',0,'C',$fill);
				$this->Cell($w[3],$tamaño_fuente-4,utf8_decode($agenda->return_atention()->name),'1',0,'C',$fill);
			}
	    	

	    	$fill =!$fill;
	    	$this->Ln(6);
	    }
	    /*

	    foreach ($resultado_consulta as $key => $value) {
	    	# code...
	    	$x_glosa = "";
	    	$y_glosa = "";
	    	$y_fin_glosa = "";
			for($i=0;$i<count($campos);$i++){
				if(empty($campos[$i])){
					$this->Cell($w[$i],$tamaño_fuente-2,"",'LR',0,'L',$fill);
				}else{
					$info = "";
					$formula=$w[$i]*0.62864-$tamaño_fuente*0.074;
					if($campos[$i] == "monto_debe" || $campos[$i] == "monto_haber")
					{
						$info = number_format($value[$campos[$i]]);
					}else{
						$info = substr($value[$campos[$i]], 0,$formula);
					}
					//$this->Cell($w[$i],$tamaño_fuente,utf8_decode($info),'LR',0,'C',$fill);
					if($campos[$i] == "glosa"){
						$x_glosa = $this->GetX();
						$y_glosa = $this->GetY();
						$this->MultiCell($w[$i],$tamaño_fuente-4,utf8_decode($value[$campos[$i]]),'1','C',$fill);
					}else{
						if($campos[$i] == "cuenta_debe"){
							$y_fin_glosa = $this->GetY();
							$this->SetXY($x_glosa+55,$y_glosa);
						}
						$this->Cell($w[$i],$tamaño_fuente-4,utf8_decode($info),'1',0,'C',$fill);
					}
				}
			}
        	//$this->Ln(6);
        	$this->SetY($y_fin_glosa);
        	$fill=!$fill;						
		}
		$this->Cell(array_sum($w),0,'','T');*/
	}


	function AutoPrint($dialog=false)
	{
		//Launch the print dialog or start printing immediately on the standard printer
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";

		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		$script = "var pp = getPrintParams();";
		if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		
		$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
		$script .= "print(pp);";

		$this->IncludeJS($script);
	}


}

function convierte_fecha($data)
{
	$fecha=explode("/",$data);	
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
require "../Entidades/Paciente.php";
require "../Entidades/Atencion.php";

extract($_GET);

$pdf=new PDF_AutoPrint('P','mm','letter');;
$pdf->AddPage();

$pdf->SetFont('Times','',12);

$word_date = convierte_fecha($dia);

$pdf->Cell(50,0,$word_date);

$pdf->Ln(10);

$pdf->SetFont('Times','',10);


	//$paciente = new Paciente();

	$agenda = new Agenda();

	$busca = new Consulta("SELECT * FROM (SELECT id as id_hd,initiation,final from disponibles_times order by id)t1 left join (SELECT * from shedule WHERE consultation_date = '$dia')t2 on t1.id_hd=t2.disponibles_time_id");

	$respuesta = $busca->resultado_arreglo();

	$header = array("Horario Inicio","Horario Termino","Paciente","Atencion");

	$campos  = array("initiation","final","paciente","atencion");

	$w = array(35,35,55,35);

	$pdf->Imprimir_tabla2($header,$campos,$w,$respuesta,'9',$agenda);

	$pdf->ln(8);

	$pdf->SetFont('Times','',11);

		


//$pdf->AutoPrint(false);

//$pdf->AutoPrintToPrinter('Contapeni-PC','FACTURA', true);

$pdf->Output();
?>