<?php
require "../config/Conexion.php";
require('fpdf/fpdf.php');
$idPago =$_GET["idFactura"];
/*$sql = "SELECT num_factura FROM pago_factura WHERE id_cabecera=$idFactura";
$resultado = pg_query($conexion,$sql);
$res = pg_fetch_row($resultado);*/ 
$numFac=10;
//$fechaForm = 'Fecha: ' . formatoFecha($fecha);

//$pdf = new FPDF('L', 'mm', 'Legal');
	$pdf = new FPDF('P','mm',array(230,230)); // Tamaño tickt 80mm x 150 mm (largo aprox)
/**********ENCABEZAD*********/
$sql="SELECT date_format(pf.fecha, \"%d/%m/%Y\") facfecha,pf.monto,date_format(v.fecha_inicio, \"%d/%m/%Y\") inicio,date_format(v.fecha_cierre, \"%d/%m/%Y\") cierre,v.id,date_format(v.fechaemision, \"%d/%m/%Y\") fechaemision,date_format(v.fechavencimiento, \"%d/%m/%Y\") fechavencimiento,v.tipo_comprobante,c.id idusuario,CONCAT(p.nombre, ' ',p.apellido) As nombre,p.direccion,h.medidor,p.num_documento,z.descripcion zona,l.mesciclo,l.anhociclo,l.lectura_ant,l.lectura,categ.consumo_minimo_m3,categ.exceso_m3 FROM venta_agua v INNER JOIN cliente c on c.id=v.idcliente INNER JOIN persona p on p.idpersona=c.id_persona LEFT JOIN hidrometro h on h.idcliente=v.idcliente INNER JOIN zona z on z.id=c.id_zona LEFT JOIN lectura l on l.id=v.idlectura INNER JOIN categ_cliente categ on categ.id=c.id_categoria INNER JOIN pago_factura pf on pf.idventaagua=v.id WHERE pf.idpago=$idPago;";
//echo($sql);// WHERE num_factura >= '$desde' AND num_factura <= '$hasta';";
//echo($sql);
$rspta=ejecutarConsulta($sql);
while ($row=$rspta->fetch_object()) {
	$idventa=$row->id;
	$tipocomprob=$row->tipo_comprobante;
	$nombre=$row->nombre;
	$direccion=$row->direccion;
	$cedula=$row->num_documento;
	$numusu=$row->idusuario;
	$medidor=$row->medidor;
	$zona=$row->zona;
	$finicio=$row->inicio;
	$fcierre=$row->cierre;
	$monto=$row->monto;
	//echo($monto);
	$lecturaanterior=0;
	$lecturaactual=0;
	$consumototal=0;
	$mes=0;
	$anho=0;

	if(isset($row->lectura_ant)){
		$lecturaanterior=$row->lectura_ant;
		$lecturaactual=$row->lectura;
		$consumototal=$lecturaactual-$lecturaanterior;
		$mes=$row->mesciclo;
		$anho=$row->anhociclo;
	}
	
	$consumominimo=$row->consumo_minimo_m3;
	$excedente=0;
	if($consumominimo < $consumototal){
		$excedente=$consumototal-$consumominimo;
	}else{
		$consumominimo=$consumototal;
	}
	
	$emision=$row->facfecha;
	$vencimiento=$row->fechavencimiento;
	$mesdesde=($mes*1)-1;
	$anhodesde=$anho;
	if($mesdesde == 0){
		$mesdesde=12;
		$anhodesde=($anho*1)-1;
	}
		/***** Encabezado *********/
	
	$pdf->AddPage();
//pdf->AddPage('ladscape',array(240,146));
	$contPag=0;
	$contln=0;
	$total=0;
		//$pdf->Image('icon/junta.png', 85, 3, 50);
	$pdf->SetFont('Courier', 'B', 12);
	
	$pdf->SetXY(32, 42);
	$pdf->Cell(15, 6,$emision, 0 , 1); 
	if($tipocomprob == 'faccredito'){
		$pdf->SetXY(194, 42);
		$pdf->Cell(15, 6,'X', 0 , 1); 
	}else{
		$pdf->SetXY(152, 42);
		$pdf->Cell(15, 6,'X', 0 , 1);
	}
	$pdf->SetXY(18, 46);
	$pdf->Cell(15, 6,utf8_decode($nombre), 0 , 1); //Celda
	$pdf->SetXY(150, 46);
	$pdf->Cell(15, 6,$numusu, 0 , 1); //Celda
	$pdf->SetXY(23, 50);
	$pdf->Cell(15, 6,utf8_decode($direccion), 0 , 1); //Celda
	$pdf->SetXY(146, 50);
	$pdf->Cell(15, 6,$medidor, 0 , 1); //Celda
	$pdf->SetXY(144, 54);
	$pdf->Cell(15, 6,utf8_decode($zona), 0 , 1); //Celda
	$pdf->SetXY(20, 58);
	$pdf->Cell(15, 6,$cedula, 0 , 1); //Celda
	$pdf->SetXY(14, 65);
	if($mes != 0){
		$pdf->Cell(15, 6,fechaLetra($mes).' '.$anho, 0 , 1); //Celda
		$pdf->SetXY(75, 65);
		$pdf->Cell(15, 6,$finicio.' - '.$fcierre, 0 , 1); 
	
		$pdf->SetXY(4, 83);
		$pdf->Cell(15, 6,$lecturaanterior, 0 , 1); //
		$pdf->SetXY(21, 83);
		$pdf->Cell(15, 6,$lecturaactual, 0 , 1); //
		$pdf->SetXY(39, 83);
		$pdf->Cell(15, 6,$consumototal, 0 , 1); //
		$pdf->SetXY(57, 83);
		$pdf->Cell(15, 6,$consumominimo, 0 , 1); //
		$pdf->SetXY(75, 83);
		$pdf->Cell(15, 6,$excedente, 0 , 1); //
	}
	$saltolinea=78;
	$sql="SELECT count(idpago) cont FROM pago_factura WHERE idventaagua=$idventa ;";
	$rspta122=ejecutarConsultaSimpleFila($sql);
	if($rspta122['cont'] < 2){
		/***** Carga erssan de la factura*************/
		$sql="SELECT concepto,precio_venta FROM venta_detalle  WHERE idventa=$idventa AND concepto like '%ERSSAN%';";
		//echo($sql);
		$rspta1=ejecutarConsulta($sql);

		$total=0;
		while ($row1=$rspta1->fetch_object()) {
			if($row1->precio_venta > 0){
				if($monto !=0){
					$costoextracto=$row1->precio_venta;
					
					if($monto >= $costoextracto){
						$monto=$monto-$costoextracto;
					}else{
						$monto=0;
						$costoextracto=$costoextracto-$monto;
					}
					$saltolinea=$saltolinea+5;		
					$concepto=$row1->concepto;
					$total=$costoextracto+$total;
					$pdf->SetXY(91, $saltolinea);
					$pdf->Cell(15, 6,utf8_decode($concepto), 0 , 1); //
					$pdf->SetXY(160, $saltolinea);
					$pdf->Cell(15, 6,round($costoextracto), 0 , 1); //
				}
			}
		}
	}
	//echo('-'.$monto);
	/***** Carga erssan de la factura*************/
	$sql="SELECT concepto,precio_venta FROM venta_detalle  WHERE idventa=$idventa AND not concepto like '%ERSSAN%';";
	$rspta1=ejecutarConsulta($sql);
	while ($row1=$rspta1->fetch_object()) {
		if($row1->precio_venta > 0){
			if($monto !=0){

				$costoextracto=$row1->precio_venta;
				
				if($monto >= $costoextracto){
					$monto=$monto-$costoextracto;
				}else{
					$costoextracto=$monto;
					$monto=0;
					
				}
				$saltolinea=$saltolinea+5;		
				$concepto=$row1->concepto;
				$total=$costoextracto+$total;
				$pdf->SetXY(91, $saltolinea);
				$pdf->Cell(15, 6,utf8_decode($concepto), 0 , 1); //
				$pdf->SetXY(160, $saltolinea);
				$pdf->Cell(15, 6,round($costoextracto), 0 , 1); //
			}
		}
	}
	/********** fin Detalle************/
	$subtotal=$total;
	$pdf->SetXY(160, 114);
	$pdf->Cell(15, 6,$subtotal, 0 , 1); //
	$pdf->SetXY(37, 117);
	$totalletras=convertir($total);
	$pdf->Cell(15, 6,utf8_decode(strtoupper($totalletras)), 0 , 1); //
	$pdf->SetXY(193, 119);
	$pdf->Cell(15, 6,$total, 0 , 1); //
}
	/*
	//	$pdf->tablaHorizontal($miCabecera, $misDatos);*/
	$pdf->Output('I');



/*FUNCION PARA DARLE FORMATO A LA FECHA*/
function fechaLetra($fechaIN)
{
	//$date = date_create($fechaIN);
	$mesNumero=$fechaIN;//date_format($date, "m");
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





/*******Convertir numeros a letras******/
function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
'nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno ','veintidos ','veintitres ', 'veinticuatro','veinticinco',
'veintiseis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}

function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}

function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
}
} else return decenas($n);
}

function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.centenas($x);}
else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
else $cadena = centenas($c). ' mil';
return $cadena;
}
} else return centenas($n);
}

function millones($n) {
if($n == 1000000) {return 'un millón';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millon ';
} else {
$cadena = ' millones ';
}
return miles($c).$cadena.(($x > 0)?miles($x):'');
}
}
function convertir($n) {
switch (true) {
case ( $n >= 1 && $n <= 29) : return basico($n); break;
case ( $n >= 30 && $n < 100) : return decenas($n); break;
case ( $n >= 100 && $n < 1000) : return centenas($n); break;
case ($n >= 1000 && $n <= 999999): return miles($n); break;
case ($n >= 1000000): return millones($n);
}
}
?>