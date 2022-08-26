<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Ingreso{


	//implementamos nuestro constructor
public function __construct(){

}
public function insertarOrden($idingreso,$fecha,$idusuario){
	$anho=date("Y");
	$numero=0;
	$sql="SELECT coalesce(max(numero),0) numero FROM orden_pago WHERE anho=$anho;";
	$rsp=ejecutarConsultaSimpleFila($sql);
	if($rsp['numero'] == 0){
		$numero=$rsp['numero']+1;
	}
	/********Asiento Contable Cabecera********/
	$sql="INSERT INTO orden_pago (anho,fecha,idusuario,numero,idingreso) VALUES ('$anho','$fecha','$idusuario','$numero','$idingreso')";
	return ejecutarConsulta($sql);
}
//metodo insertar registro
public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta,$margen,$cantidad_pagos,$metodo_pago,$imp,$id_imp,$fechP){
	$precio_venta=0;
	$margen=0;
	$prueb='';
	/********Asiento Contable Cabecera********/
	$sql="INSERT INTO asiento_contable (fecha,origen,total_debe,total_haber,estado) VALUES ('$fecha_hora','compra','0','0','1')";
	$id_asiento=ejecutarConsulta_retornarID($sql);
	$pagosRealizados=1;
	if($tipo_comprobante=='Factura Credito'){
		$pagosRealizados=0;
	}
	$sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado,cantidad_pagos,metodo_pago,id_asiento,pagos_realizados) VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado','$cantidad_pagos','$metodo_pago','$id_asiento','$pagosRealizados')";
	//return ejecutarConsulta($sql);
	
	 $idingresonew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 $ret='';
	 $total=0;
	 $detalle_asiento;
	 while ($num_elementos < count($idarticulo)) {
	 
	 	$sql_stock="SELECT idcuenta from articulo where idarticulo=$idarticulo[$num_elementos];";
	 	$cta=ejecutarConsultaSimpleFila($sql_stock);
	 	$idcuenta=$cta["idcuenta"];
	 	$sql_detalle1="INSERT INTO detalle_ingreso (idingreso,idarticulo,cantidad,precio_compra,precio_venta,margen,impuesto) VALUES('$idingresonew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta','$margen','$imp[$num_elementos]')";
	 	ejecutarConsulta($sql_detalle1) or $sw=false;
	 	$tot=$cantidad[$num_elementos]*$precio_compra[$num_elementos];
	 	$detalle_asiento="INSERT INTO asiento_detalle (monto,id_cuenta,id_asiento,tipo) VALUES ('$tot','$idcuenta','$id_asiento','1');";
	 	ejecutarConsulta($detalle_asiento);
	 	$prueb=$detalle_asiento;
	 	$total=$tot+$total;
	 	if($tipo_comprobante =='Factura Contado' || $tipo_comprobante=='Factura Credito' || $tipo_comprobante=='Auto Factura'){
	 		$sql_as="SELECT id_cuenta from impuesto where id='$id_imp[$num_elementos]';";
		 	$as=ejecutarConsultaSimpleFila($sql_as);
		 	$idAsientoImp=$as["id_cuenta"];

	 		if($imp[$num_elementos] > 0){
				$detalle_asiento="INSERT INTO asiento_detalle (monto,id_cuenta,id_asiento,tipo) VALUES ('$imp[$num_elementos]','$idAsientoImp','$id_asiento','1');";
				ejecutarConsulta($detalle_asiento);
				$total=$imp[$num_elementos]+$total;
			}
	 		//$metodo_pago='entro';
	 	} 
	 	//$sw=$metodo_pago;
	 	$num_elementos=$num_elementos+1;
	 }
	 $idcuentaH=0;
	 if($metodo_pago < 1){
	 	$sql_stock="SELECT id_cuenta from opcion_a_configurar where cod=$metodo_pago;";
	 	$cta=ejecutarConsultaSimpleFila($sql_stock);
	 	$idcuentaH=$cta["id_cuenta"];
	 }else{
	 	$sql_stock="SELECT id_plan_cuentas from banco where id=$metodo_pago;";
	 	$cta=ejecutarConsultaSimpleFila($sql_stock);
	 	$idcuentaH=$cta["id_plan_cuentas"];
	 }
	 	
	 $detalle_asiento="INSERT INTO asiento_detalle (monto,id_cuenta,id_asiento,tipo) VALUES ('$total','$idcuentaH','$id_asiento','2');";
	 ejecutarConsulta($detalle_asiento);
	 $detalle_asiento="UPDATE asiento_contable SET total_debe='$total',total_haber='$total' WHERE id=$id_asiento;";
	 ejecutarConsulta($detalle_asiento);
	 $sqlPagare;
	 if($tipo_comprobante=='Factura Credito'){
	 	$num_elementos=0;
	 	$cuota=$total/$cantidad_pagos;
	 	while ($num_elementos < count($fechP)) {	 		
	 		$sqlPagare="INSERT INTO pagare  (monto,fecha_emision,fecha_vencimiento,id_ingreso) VALUES ('$cuota','$fecha_hora','$fechP[$num_elementos]','$idingresonew');";
	 		ejecutarConsulta($sqlPagare);
	 		//$metodo_pago='entro';
	 		$num_elementos++;
	 	}
	} 
	 return $sw;
	 //echo $sqlPagare;
	// return $prueb;
}

public function anular($idingreso){
	$sql="SELECT id_asiento FROM ingreso WHERE idingreso=$idingreso;";
	$as= ejecutarConsultaSimpleFila($sql);
	$asiento=$as['id_asiento'];
	$sql="UPDATE asiento_contable SET total_debe=0,total_haber=0 WHERE id='$asiento'";
	ejecutarConsulta($sql);
	$sql="UPDATE asiento_detalle SET monto=0 WHERE id_asiento='$asiento'";
	ejecutarConsulta($sql);

	$sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}
public function guardPag($idingreso,$fechaPag,$iddeuda){
	$sql="UPDATE ingreso SET pagos_realizados=pagos_realizados+1 WHERE idingreso='$idingreso'";
	//return $sql;
	ejecutarConsulta($sql);
	$sql="SELECT monto FROM pagare WHERE id=$iddeuda;";
	$cuenta=ejecutarConsultaSimpleFila($sql);
	$monto=$cuenta['monto'];
	$sql="INSERT INTO asiento_contable (estado,fecha,origen,total_debe,total_haber) VALUES ('1','$fechaPag','pagare','$monto','$monto');";
	$idAsiento=ejecutarConsulta_retornarID($sql);

	$sql="SELECT id_cuenta from opcion_a_configurar WHERE cod='-2';";
	$cuenta=ejecutarConsultaSimpleFila($sql);
	$idCuenta=$cuenta['id_cuenta'];

	$sql="INSERT INTO asiento_detalle (id_asiento,id_cuenta,monto,tipo) VALUES ('$idAsiento','$idCuenta','$monto','1');";
	ejecutarConsulta($sql);
	$sql="SELECT id_cuenta from opcion_a_configurar WHERE cod='-1';";
	$cuenta=ejecutarConsultaSimpleFila($sql);
	$idCuenta=$cuenta['id_cuenta'];

	$sql="INSERT INTO asiento_detalle (id_asiento,id_cuenta,monto,tipo) VALUES ('$idAsiento','$idCuenta','$monto','2');";
	ejecutarConsulta($sql);


	$sql="UPDATE pagare SET pagofecha='$fechaPag' WHERE id='$iddeuda'";
	return ejecutarConsulta($sql);
	//return $sql;
}

//metodo para mostrar registros
public function impDefault($idingreso){
	$sql="SELECT id,porcentaje,descripcion FROM impuesto WHERE estado=1 order by asc;";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function mostrar($idingreso){
	$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado,i.cantidad_pagos,i.metodo_pago FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE idingreso='$idingreso'";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function verificarOrdenP($idingreso){
	$sql="SELECT coalesce(max(id),0) existe FROM orden_pago WHERE idingreso=$idingreso;";
	return ejecutarConsultaSimpleFila($sql);
}
public function listarImpuesto($idingreso){
	$sql="SELECT impuesto FROM ingreso WHERE idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

public function listarDetalle($idingreso){
	$sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta,di.margen,di.impuesto FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo=a.idarticulo WHERE di.idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado,i.cantidad_pagos,i.metodo_pago,i.pagos_realizados  FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso DESC;";
	return ejecutarConsulta($sql);
}
public function listarDeuda($id){
	$sql="SELECT id,fecha_emision,fecha_vencimiento,monto,pagofecha FROM pagare WHERE id_ingreso=$id order by id asc;";
	return ejecutarConsulta($sql);
	//return ($sql);
}

}

 ?>
