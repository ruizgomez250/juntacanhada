<?php
include('../config/conexion.php');
$conexion = conexion_db();
/*
$pdf = new PDF('L','mm','Legal');
*/
$contline = 0;

require('fpdf/fpdf.php');
$idFactura = $_GET["idFactura"];
$numFac=$_GET["numeroFactura"];

//$fechaForm = 'Fecha: ' . formatoFecha($fecha);
$pdf = new FPDF('P', 'mm', 'Legal');
$pdf->AddPage();
$contPag=0;
$contln=0;
$total=0;
/**********ENCABEZAD*********/
$sql = "SELECT id,fecha_emision,id_cliente,vencimiento FROM factura_encabezado WHERE id=$idFactura ORDER BY id asc;";
$stmt = pg_exec($conexion, $sql );

while( $row = pg_fetch_array( $stmt) ) {
	
	if($contPag == 2){
		$contPag=0;
		$pdf->AddPage();
	}
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
	

	
	//$pdf->Write(5, utf8_decode($fechaForm));
	/******************** dar forma al cuadrado del encabezado**************************/
	
	/*$pdf->Line(10, 8, 76, 8);
	$pdf->Line(10, 8, 10, 40);
	$pdf->Line(76, 8, 76, 40);*/
	/******************** fin dar Forma **************************/
	$pdf->SetFillColor(62, 174, 181);
	$pdf->SetDrawColor(62, 174, 181);
	$pdf->Cell(200, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Cell(200, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();

/*********** fin Encabezado ********************/
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
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(0, 5,utf8_decode('ORDEN DE PAGO Nº '.$idEncabezado.' - Factura Nº '.$numFac), 0, 0, 'C');
	$pdf->Ln();

	$pdf->SetFont('Arial', '', 9);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Cell(30, 7, utf8_decode('Nº MEDIDOR:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($medidor), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode('FECHA:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($fecha_emision), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(30, 7, utf8_decode('Nº USUARIO:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($id_cliente), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode('PERIODO:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($periodo), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(45, 7, utf8_decode('NOMBRE/RAZON SOCIAL:'), 1, 0, 'L', true);
	$pdf->Cell(55, 7, utf8_decode($nombre.' '.$apellido), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode('VENCIMIENTO:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($vencimiento), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(30, 7, utf8_decode('CEDULA/RUC:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($cedula), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode('SECTOR:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($sector), 1, 0, 'L', true);

	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->SetFillColor(62, 174, 181);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetDrawColor(88, 88, 88);
	$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 0, 'C', true);
	$pdf->Cell(100, 7, utf8_decode('DESCRIPCION'), 1, 0, 'C', true);
	$pdf->Cell(35, 7, 'PRECIO UNITARIO', 1, 0, 'C', true);
	$pdf->Cell(35, 7, 'PRECIO TOTAL', 1, 0, 'C', true);
	$pdf->Ln();
	$contln++;
	$sql1 = "SELECT id,cantidad,descripcion,precio_unitario,exentas FROM factura_detalle WHERE id_encabezado=$idEncabezado ORDER BY id asc;";
	$stmt1 = pg_exec($conexion, $sql1 );
	while( $row1 = pg_fetch_array( $stmt1) ) {
		$idDetalle = $row1[0];
		$cantidad = $row1[1];
		$descripcion = $row1[2];
		$precioUnitario = round($row1[3]);
		$exentas = round($row1[4]);//round($exentas)
		$total=$total+$row1[4];
		//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
		
		$pdf->SetFont('Arial', '', 10);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(20, 5, utf8_decode($cantidad), 1, 0, 'C', true);
		$pdf->Cell(100, 5, utf8_decode($descripcion), 1, 0, 'C', true);
		$pdf->Cell(35, 5, utf8_decode(number_format($precioUnitario,0,",",".")), 1, 0, 'C', true);
		$pdf->Cell(35, 5, utf8_decode(number_format($exentas,0,",",".")), 1, 0, 'C', true);
		$pdf->Ln();
		$contln++;
		
	}
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(155, 5, utf8_decode('Total'), 1, 0, 'C', true);
	$pdf->Cell(35, 5, utf8_decode(number_format($total,0,",",".")), 1, 0, 'C', true);
	$pdf->Ln();
	$contln++;
	$contPag++;
	if($contPag == 1){
		while($contln < 21){
			$pdf->Ln();
			$contln++;
		}
		$contln=0;
	}
	
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
