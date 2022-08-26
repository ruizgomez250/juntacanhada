<?php
require "../config/Conexion.php";
require('fpdf/fpdf.php');
$idorden =$_GET["id"];
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
$sql="SELECT op.fecha,op.anho,op.numero numeroorden,i.total_compra,i.num_comprobante,p.nombre,p.num_documento,ac.id,u.nombre unombre,u.num_documento udocumento FROM orden_pago op INNER JOIN ingreso i on i.idingreso=op.idingreso INNER JOIN persona p on p.idpersona=i.idproveedor INNER JOIN asiento_contable ac on ac.id=i.id_asiento INNER JOIN usuario u on u.idusuario=i.idusuario  WHERE op.id=$idorden;";
$row= ejecutarConsultaSimpleFila($sql);
$fecha=$row['fecha'];
$anho=$row['anho'];
$numeroorden=$row['numeroorden'];
$total_compra=$row['total_compra'];
$num_comprobante=$row['num_comprobante'];
$nombre=$row['nombre'];
$num_documento=$row['num_documento'];
$idAsiento=$row['id'];
$unombre=$row['unombre'];
$udocumento=$row['udocumento'];
	/***** Encabezado *********/
	//$pdf->Image('icon/junta.png', 85, 3, 50);

	$pdf->SetFont('Arial', '', 12);
	$pdf->SetTextColor(118, 127, 128);
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
	$pdf->SetFillColor(200, 211, 212);
	$pdf->SetDrawColor(200, 211, 212);
	$pdf->Cell(200, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(255, 255, 255);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(200, 1, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Ln();

/*********** fin Encabezado ********************/
	

	$numOrden=$numeroorden;
	$fecha=$fecha;
	$anho=$anho;
	$ruc=$num_documento;
	$factura=$num_comprobante;
	$razon=$nombre;
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(0, 5,utf8_decode('ORDEN DE PAGO Nº '.$numOrden.'/'.$anho), 0, 0, 'C');
	$pdf->Ln();
	$pdf->Cell(35, 7, utf8_decode('FECHA:'), 1, 0, 'L', true);
	$pdf->Cell(70, 7, utf8_decode($fecha), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->Cell(30, 7, utf8_decode('RAZON SOCIAL:'), 1, 0, 'L', true);
	$pdf->Cell(100, 7, utf8_decode($razon), 1, 0, 'L', true);
	$pdf->Cell(20, 7, utf8_decode('R.U.C./CEDULA:'), 1, 0, 'L', true);
	$pdf->Cell(50, 7, utf8_decode($ruc), 1, 0, 'L', true);
	$pdf->Ln();
	$pdf->Cell(30, 7, utf8_decode('FACTURA Nº:'), 1, 0, 'L', true);
	$pdf->Cell(90, 7, utf8_decode($factura), 1, 0, 'L', true);

	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->SetFillColor(118, 127, 128);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetDrawColor(88, 88, 88);	
	$pdf->Cell(200, 6, utf8_decode('IMPUTACION CONTABLE'), 1, 0, 'C', true);
	$pdf->Ln();
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('Arial', '', 9);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(50, 6, utf8_decode('CODIGO CUENTA'), 1, 0, 'C', true);
	$pdf->Cell(100, 6, utf8_decode('DESCRIPCION'), 1, 0, 'C', true);
	$pdf->Cell(25, 6, utf8_decode('DEBE'), 1, 0, 'C', true);
	$pdf->Cell(25, 6, utf8_decode('HABER'), 1, 0, 'C', true);
	$pdf->Ln();



	
	$contln++;
	$sql="SELECT a.monto,a.tipo,pc.codigo,pc.cuenta FROM asiento_detalle a INNER JOIN plan_de_cuentas pc on pc.id=a.id_cuenta WHERE a.id_asiento=$idAsiento;";
	$rspta= ejecutarConsulta($sql);
	$total=0;
	while ($reg=$rspta->fetch_object()){//( $row1 = pg_fetch_array( $stmt1) ) {
		$codcuenta =$reg->codigo;
		$tipo = $reg->tipo;
		$debe=0;
		$haber=0;
		if($tipo == 1){
			$debe = $reg->monto;
		}else{
			$haber= $reg->monto;
		}
		
		
		$cuenta = $reg->cuenta;
		$pdf->Cell(50, 6, utf8_decode($codcuenta), 1, 0, 'C', true);
		$pdf->Cell(100, 6, utf8_decode($cuenta), 1, 0, 'C', true);
		$pdf->Cell(25, 6, utf8_decode($debe), 1, 0, 'C', true);
		$pdf->Cell(25, 6, utf8_decode($haber), 1, 0, 'C', true);
		$pdf->Ln();
		$contln++;
		
	}
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(150, 5, utf8_decode('Total'), 1, 0, 'C', true);
	$pdf->Cell(25, 5, utf8_decode(number_format($total_compra,0,",",".")), 1, 0, 'C', true);
	$pdf->Cell(25, 5, utf8_decode(number_format($total_compra,0,",",".")), 1, 0, 'C', true);
	$pdf->Ln();
	$contln++;
	$contPag++;
	while($contln < 8){
		$pdf->Ln();
		$contln++;
	}
	$pdf->Cell(130, 6, utf8_decode('ELABORADO POR: '.$unombre.' C.I. '.$udocumento), 1, 0, 'L', true);
	$pdf->Cell(35, 6, utf8_decode('TESORERO'), 1, 0, 'C', true);
	$pdf->Cell(35, 6, utf8_decode('PRESIDENTE'), 1, 0, 'C', true);

	$pdf->Ln();
	$pdf->Cell(130, 18, utf8_decode(''), 1, 0, 'L', true);
	$pdf->Cell(35, 18, utf8_decode(''), 1, 0, 'C', true);
	$pdf->Cell(35, 18, utf8_decode(''), 1, 0, 'C', true);




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