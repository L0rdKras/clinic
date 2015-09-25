<?php
define('FPDF_FONTPATH','font/');
require('pdf_js.php');
require("../helper/conversiones.php");

class PDF_AutoPrint extends PDF_Javascript
{

function Header()
{
	$fundo=utf8_decode('Fundo San Carlos Vicuña');
	$this->SetFont('Times','B',12);
    $this->Cell(30,10,'Sociedad Agroindustrial Rio Elqui Ltda.');
    $this->Cell(130);
    $this->Cell(30,10,"Numero: {$_GET['numero']}");
    $this->ln(5);
    $this->Cell(30,10,$fundo);
    $this->Cell(45);
    $this->SetFont('Times','B',14);
    $this->Cell(30,10,'COMPROBANTE CONTABLE');
    $this->SetFont('Times','B',12);
    $this->Ln(5);
    $this->Cell(30,10,'R.U.T. 79.703.020-1');
    $this->Ln(5);
    $this->Cell(30,10,'FONO: 0512419050 - 0512673920');
    $this->Cell(110);
    $this->SetFont('Times','B',8);
    $this->Cell(60,6,utf8_decode('CORRELATIVO COMPUTACION N°'),1);
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

	public function Imprimir_tabla2($header,$campos,$w,$resultado_consulta,$tamaño_fuente)
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
		$this->Cell(array_sum($w),0,'','T');
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

extract($_GET);

$busca = new Consulta("SELECT * from accounting_vousher WHERE id='$numero'");



$pdf=new PDF_AutoPrint('P','mm','letter');;
$pdf->AddPage();

$pdf->SetFont('Times','',10);
if($busca->filas_resultado()>0){

	$respuesta = $busca->resultado_arreglo();

	$datos_vousher = $respuesta[0];
	
	$fecha=explode("-",$datos_vousher['fecha']);	
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
	
	$pdf->SetXY(150,35);
	$pdf->Cell(20,0,$fecha[2]." de ".$mes." del ".$fecha[0]);

	//$pdf->SetLeftMargin(35);
	
	$pdf->Ln(5);

	$pdf->Cell(20,0,"TIPO : ".$datos_vousher['tipo']);

	$pdf->Ln(5);

	$pdf->Cell(20,0,$datos_vousher['forma']." : ".$datos_vousher['paguese']);

	$pdf->Ln(5);

	$pdf->Cell(20,0,"MEDIO DE PAGO : ".$datos_vousher['forma_de_pago']);

	$pdf->Ln(5);

	$pdf->Cell(20,0,"A LA ORDEN DE : ".$datos_vousher['a_la_orden']);

	$pdf->Ln(8);

	$busca_detalle = new Consulta("SELECT * from vousher_detail where accounting_vousher_id = '$numero'");

	$arreglo_detalle = $busca_detalle->resultado_arreglo();

	$header = array("GLOSA","CUENTA DEBE","CUENTA HABER","MONTO HABER","MONTO DEBE");

	$campos  = array("glosa","cuenta_debe","cuenta_haber","monto_haber","monto_debe");

	$w = array(55,35,35,30,30);

	$pdf->Imprimir_tabla2($header,$campos,$w,$arreglo_detalle,'9');

	$pdf->ln(8);

	$pdf->SetFont('Times','',11);

	if($datos_vousher['total_haber']>0)
	{
		//
		$pdf->Cell(20,0,"TOTAL HABER: $".number_format($datos_vousher['total_haber']));

		$pdf->ln(7);
		$texto_haber = numero_a_palabras($datos_vousher['total_haber']);

		$pdf->MultiCell(190,8,"TOTAL EN PALABRAS (HABER): $texto_haber PESOS.-");

		$pdf->ln(10);
	}

	if($datos_vousher['total_debe']>0)
	{
		//
		$pdf->Cell(20,0,"TOTAL DEBE: $".number_format($datos_vousher['total_debe']));

		$pdf->ln(7);
		$texto_debe = numero_a_palabras($datos_vousher['total_debe']);

		$pdf->MultiCell(190,8,"TOTAL EN PALABRAS (DEBE): $texto_debe PESOS.-");

		$pdf->ln(10);
	}
	//$pdf->devuelve_palabras($datos_vousher['total_debe'],"DEBE");

	//$pdf->devuelve_palabras($datos_vousher['total_haber'],"HABER");

	$pdf->Cell(60,0,utf8_decode("Recibi cheque N°: ".$datos_vousher['numero_cheque']));
	$pdf->Cell(60,0,utf8_decode("Del Banco: ".$datos_vousher['banco']));
	$pdf->Cell(60,0,utf8_decode("Fecha: ".convierte_fecha($datos_vousher['fecha_recepcion'])));

	/*$pdf->ln(5);

	$pdf->Cell(20,0,"Del Banco ".$datos_vousher['banco']);*/

	/*$pdf->ln(5);

	$pdf->Cell(20,0,"Fecha ".$datos_vousher['fecha_recepcion']);*/

	$pdf->ln(12);

	$pdf->Cell(20,0,"Firma ____________________");

	$pdf->ln(5);

	$pdf->Cell(12);
	$pdf->Cell(20,0,"RUT: ");

	$pdf->ln(10);

	$pdf->Cell(80,13,"Emitido por: {$datos_vousher['emisor']}",1);
	$pdf->Cell(80,13,utf8_decode("V°B° Contabilidad ____________________"),1);

	$pdf->ln(15);

	$pdf->Cell(80,13,"Computacion ____________________",1);
	$pdf->Cell(80,13,utf8_decode("V°B° Gerencia ____________________"),1);
		
}

//$pdf->AutoPrint(false);

//$pdf->AutoPrintToPrinter('Contapeni-PC','FACTURA', true);

$pdf->Output();
?>