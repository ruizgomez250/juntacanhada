<?php
include('../config/conexion.php');
$conexion = conexion_db();
/*
$pdf = new PDF('L','mm','Legal');
*/
$contline = 0;

require('fpdf/fpdf.php');

//$fechaForm = 'Fecha: ' . formatoFecha($fecha);
$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->AddPage();
/***** Encabezado *********/
	//$pdf->Image('icon/junta.png', 85, 3, 50);
	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(0, 5, 'JUNTA DE SANEAMIENTO', 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(0, 5, 'DE ITA ANGU A - LUQUE', 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(0, 5, 'Distribucion de Agua Ozonizada', 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(0, 5, 'Tel.: (0981) 415 512', 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 5, 'Luque-Paraguay', 0, 0, 'C');
	$pdf->Ln();
/**********FIN ENCABEZAD*********/
/******************** Dar Forma **************************/
	$pdf->SetFillColor(62, 174, 181);
	$pdf->SetDrawColor(62, 174, 181);
	$pdf->Cell(335, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Cell(335, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(0, 5,utf8_decode('FACTURAS PAGADAS POR USUARIO'), 0, 0, 'C');
	$pdf->Ln();
/********** Fin Dar Forma*********/
/*********** fin Encabezado ********************/
/********* Tabla Cabecera****************/
$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(62, 174, 181);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetDrawColor(88, 88, 88);
	$pdf->Cell(30, 7, utf8_decode('COD.'), 1, 0, 'C', true);
	$pdf->Cell(80, 7, utf8_decode('NOMBRE/RAZON SOCIAL'), 1, 0, 'C', true);
	$pdf->Cell(35, 7, 'CEDULA/R.U.C.', 1, 0, 'C', true);
	$pdf->Cell(80, 7, 'SECTOR', 1, 0, 'C', true);
	$pdf->Cell(35, 7, 'FECHA EMISION', 1, 0, 'C', true);
	
	$pdf->Cell(35, 7, 'VENCIMIENTO', 1, 0, 'C', true);
	$pdf->Cell(35, 7, 'PERIODO', 1, 0, 'C', true);
	$pdf->Ln();
/***************Fin Tabla Cabecera*************************/

$contPag=0;
$contln=0;
$total=0;

$sql = "SELECT id,fecha_emision,id_cliente,vencimiento FROM factura_encabezado WHERE estado=2 ORDER BY id_cliente asc;";
$stmt = pg_exec($conexion, $sql );

while( $row = pg_fetch_array( $stmt) ) {
	
	$idEncabezado=$row[0];
	$fecha_emision=$row[1];
	$id_cliente=$row[2];
	$vencimiento=$row[3];
	$sql2="SELECT  cli.nombre,cli.apellido,cli.cedula,med.codigo_medidor,sect.descripcion  FROM cliente cli INNER JOIN medidor med on med.id=cli.id_medidor INNER JOIN opcion sect on sect.id=cli.id_sector WHERE cli.id=$id_cliente;";
	$resultado2 = pg_query($conexion,$sql2);
	$res2 = pg_fetch_row($resultado2);
	$nombre = $res2[0];
	$apellido = $res2[1];
	$cedula = $res2[2];
	$medidor=$res2[3];
	$sector = $res2[4];
	$periodo=fechaLetra($fecha_emision);
	

	$pdf->SetFont('Arial', '', 9);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetTextColor(0, 0, 0);
	
	$pdf->Cell(30, 7, utf8_decode($id_cliente), 1, 0, 'C', true);
	$pdf->Cell(80, 7, utf8_decode($nombre), 1, 0, 'C', true);
	$pdf->Cell(35, 7,$cedula, 1, 0, 'C', true);
	$pdf->Cell(80, 7, $sector, 1, 0, 'C', true);
	$pdf->Cell(35, 7,$fecha_emision, 1, 0, 'C', true);
	
	$pdf->Cell(35, 7,$vencimiento, 1, 0, 'C', true);
	$pdf->Cell(35, 7,$periodo, 1, 0, 'C', true);	
	$pdf->Ln();
	
}







/*
//	$pdf->tablaHorizontal($miCabecera, $misDatos);*/
$pdf->Output('I');



/*FUNCION PARA DARLE FORMATO A LA FECHA*/
function fechaLetra($fechaIN)
{
	$date = date_create($fechaIN);
	$mesNumero=date_format($date, "m");
	$mesLetra='';
	if($mesNumero == 1){
		$mesLetra='Enero';
	}else if($mesNumero == 2){
		$mesLetra='Febrero';
	}if($mesNumero == 3){
		$mesLetra='Marzo';
	}if($mesNumero == 4){
		$mesLetra='Abril';
	}if($mesNumero == 5){
		$mesLetra='Mayo';
	}if($mesNumero == 6){
		$mesLetra='Junio';
	}if($mesNumero == 7){
		$mesLetra='Julio';
	}if($mesNumero == 8){
		$mesLetra='Agosto';
	}if($mesNumero == 9){
		$mesLetra='Setiembre';
	}if($mesNumero == 10){
		$mesLetra='Octubre';
	}if($mesNumero == 11){
		$mesLetra='Noviembre';
	}if($mesNumero == 12){
		$mesLetra='Diciembre';
	}
	return $mesLetra;
}
?>