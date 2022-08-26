<?php
require "../config/Conexion.php";
require('fpdf/fpdf.php');
$idremision =$_GET["id"];
/*$sql = "SELECT num_factura FROM pago_factura WHERE id_cabecera=$idFactura";
$resultado = pg_query($conexion,$sql);
$res = pg_fetch_row($resultado);*/ 
$numFac=10;
//$fechaForm = 'Fecha: ' . formatoFecha($fecha);
$pdf = new FPDF('P', 'mm', 'Legal');
$pdf->AddPage();
$contPag=0;
$contln=0;
$total=0;
/**********ENCABEZAD*********/
$sql="SELECT n.fecha_hora,n.num_comprobante,p.nombre,p.num_documento FROM nota_remision n INNER JOIN persona p on p.idpersona=n.idcliente  WHERE n.id='$idremision'";
$row= ejecutarConsultaSimpleFila($sql);
$fecha=$row['fecha_hora'];
$nombre=$row['nombre'];
$cedula=$row['num_documento'];
$numremision=$row['num_comprobante'];
	/***** Encabezado *********/
	//$pdf->Image('icon/junta.png', 85, 3, 50);
	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(0, 5, 'JUNTA DE SANEAMIENTO', 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(0, 5,utf8_decode('CAÑADA GARAY Km 20 - VIA FERREA'), 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(0, 5, 'Distribucion de Agua Ozonizada', 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(0, 5, 'Tel.: (021) 647 130 / 0986 327 311', 0, 0, 'C');
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
	$idEncabezado=1;//$row[0];
	$fecha_emision=1;//$row[1];
	$id_cliente=1;//$row[2];
	$vencimiento=1;//$row[3];
	/*$sql2="SELECT  cli.nombre,cli.apellido,cli.cedula,med.codigo_medidor,sect.descripcion  FROM cliente cli INNER JOIN medidor med on med.id=cli.id_medidor INNER JOIN opcion sect on sect.id=cli.id_sector WHERE cli.id=$id_cliente;";
	$resultado2 = pg_query($conexion,$sql2);
	$res2 = pg_fetch_row($resultado2);*/
	
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(0, 5,utf8_decode('NOTA DE ENTREGA Nº '.$numremision), 0, 0, 'C');
	$pdf->Ln();

	$pdf->SetFont('Arial', '', 9);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(255, 255, 255);
	$pdf->Cell(30, 7, utf8_decode('FECHA:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($fecha), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(30, 7, utf8_decode('ENCARGADO:'), 1, 0, 'L', true);
	$pdf->Cell(90, 7, utf8_decode($nombre), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode('CEDULA:'), 1, 0, 'L', true);
	$pdf->Cell(30, 7, utf8_decode(number_format($cedula, 0, ',', '.')), 1, 0, 'L', true);	

	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(62, 174, 181);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetDrawColor(88, 88, 88);	
	$pdf->Cell(180, 7, utf8_decode('DESCRIPCION'), 1, 0, 'C', true);
	$pdf->Cell(20, 7, utf8_decode('CANTIDAD'), 1, 0, 'C', true);
	$pdf->Ln();
	$contln++;
	$sql="SELECT d.cantidad,a.nombre FROM detalle_remision d INNER JOIN articulo a on a.idarticulo=d.idarticulo WHERE idremision=$idremision;";
	$rspta= ejecutarConsulta($sql);
	$total=0;
	while ($reg=$rspta->fetch_object()){//( $row1 = pg_fetch_array( $stmt1) ) {
		$detalle =$reg->nombre;
		$cantidad = $reg->cantidad;
		$total=$total+$cantidad ;
		$pdf->SetFont('Arial', '', 10);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(180, 5, utf8_decode($detalle), 1, 0, 'L', true);
		$pdf->Cell(20, 5, utf8_decode($cantidad), 1, 0, 'C', true);
		$pdf->Ln();
		$contln++;
		
	}
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(180, 5, utf8_decode('Total'), 1, 0, 'C', true);
	$pdf->Cell(20, 5, utf8_decode(number_format($total,0,",",".")), 1, 0, 'C', true);
	$pdf->Ln();
	$contln++;
	$contPag++;
	while($contln < 10){
		$pdf->Ln();
		$contln++;
	}
	$pdf->SetFont('Arial', '', 10);
	$pdf->Cell(60, 5, utf8_decode('Recibí Conforme'), 0, 0, 'C', true);
	$pdf->Ln();
	$pdf->Cell(60, 5, utf8_decode('C.I.:'.number_format($cedula, 0, ',', '.')), 0, 0, 'C', true);
	$pdf->Ln();
	$pdf->Cell(60, 5, utf8_decode($nombre), 0, 0, 'C', true);






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