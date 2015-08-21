<?php
require('../Entidades/fpdf.php');

class Pdf_listados extends FPDF
{
	var $angle=0;
	var $nombre_listado="";

//Cabecera de página
	public function __construct($nombre){
		$this->nombre_listado=$nombre;
		parent::__construct('P','mm','letter');
	}

	function Header()
	{
	    //Logo
	    //$this->Image('../icono.jpg',10,5,40);
	    //Arial bold 15
	    $this->SetFont('Helvetica','B',30);
	    //Movernos a la derecha
	    $this->Cell(72);
	    //Título
	    
	    $this->Cell(30,10,'Reportes');
	    $this->Ln(10);
	    $this->Cell(80);
	    $this->SetFont('Times','B',8);
	    $this->Cell(30,10,'Giro');
	    //Salto de línea
	    $this->Ln(15);
	    //MARCA DE AGUA
	    $this->SetFont('Arial','B',90);
	    $this->SetTextColor(255,192,203);
	    $this->RotatedText(50,190,'Reporte',45);

	}

	public function titulo($label)
	{
	    //Arial 12
	    $this->SetFont('Arial','B',12);
	    //Color de fondo
	    $this->SetFillColor(200,220,255);
	    //Título
	    $this->Cell(0,6,$label,0,1,'L',true);
	    //Salto de línea
	    $this->Ln(2);
	}

	function informacion_lista($titulo,$arreglo =array())
	{
		$this->SetFont('Arial','B',12);
		$this->SetFillColor(200,220,255);
		$this->Cell(0,6,$titulo,0,1,'L',true);
		$this->Ln(2);
		$this->SetFont('Arial','',12);
		foreach ($arreglo as $key => $value) {
			$label=$key.": ".$value;
			$this->Cell(0,6,$label,0,1,'L',false);
			$this->Ln(2);
		}
	}


	function RotatedText($x, $y, $txt, $angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}

	function Rotate($angle,$x=-1,$y=-1)
	{
	    if($x==-1)
	        $x=$this->x;
	    if($y==-1)
	        $y=$this->y;
	    if($this->angle!=0)
	        $this->_out('Q');
	    $this->angle=$angle;
	    if($angle!=0)
	    {
	        $angle*=M_PI/180;
	        $c=cos($angle);
	        $s=sin($angle);
	        $cx=$x*$this->k;
	        $cy=($this->h-$y)*$this->k;
	        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	    }
	}


	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $this->SetY(-20);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Número de página
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}	
	//Cargar los datos
	function LoadData($file)
	{
	    //Leer las líneas del fichero
	    $lines=file($file);
	    $data=array();
	    foreach($lines as $line)
	        $data[]=explode(';',chop($line));
	    return $data;
	}

	//Tabla 
	public function Imprimir_tabla($header,$campos,$w,$resultado_consulta,$tamaño_fuente)
	{
	    //Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(50,205,50);
	    $this->SetTextColor(255);
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
	    		
		while($row=$resultado_consulta->fetch_array()){
			for($i=0;$i<count($campos);$i++){
				if(empty($campos[$i])){
					$this->Cell($w[$i],$tamaño_fuente,"",'LR',0,'L',$fill);
				}else{
					$formula=$w[$i]*0.62864-$tamaño_fuente*0.074;
					$info=substr($row[$campos[$i]], 0,$formula);
					$this->Cell($w[$i],$tamaño_fuente,utf8_decode($info),'LR',0,'L',$fill);				
				}
			}
        	$this->Ln();
        	$fill=!$fill;						
		}  
	}
	public function Imprimir_tabla2($header,$campos,$w,$resultado_consulta,$tamaño_fuente)
	{
	    //Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(50,205,50);
	    $this->SetTextColor(255);
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
			for($i=0;$i<count($campos);$i++){
				if(empty($campos[$i])){
					$this->Cell($w[$i],$tamaño_fuente,"",'LR',0,'L',$fill);
				}else{
					$formula=$w[$i]*0.62864-$tamaño_fuente*0.074;
					$info=substr($value[$campos[$i]], 0,$formula);
					$this->Cell($w[$i],$tamaño_fuente,utf8_decode($info),'LR',0,'C',$fill);
				}
			}
        	$this->Ln();
        	$fill=!$fill;						
		}
		$this->Cell(array_sum($w),0,'','T');
	}	
}