<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class AnularFactura{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idcuenta){
	$sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion,impuesto,margen,idcuenta)
	 VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1','0','0','$idcuenta')";
	return ejecutarConsulta($sql);
}

public function editar($id,$numFactura){
	$sql = "SELECT va.idcliente FROM pago_factura pf INNER JOIN venta_agua va on va.id=pf.idventaagua WHERE pf.idpago=$id;";
	$rsp = ejecutarConsultaSimpleFila($sql);
	$cliente = $rsp['idcliente'];
	/*$sql = "UPDATE venta_agua set estado='2' WHERE idcliente=$cliente;";
	ejecutarConsulta($sql);*/
	$sql = "UPDATE pago_factura set numfactura=$numFactura WHERE idpago=$id;";	
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function activar($idarticulo){
	$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idarticulo){
	$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar($idFac){
	$sql = "SELECT pf.idpago id,c.id codCli,CONCAT(p.nombre, ' ',p.apellido) AS nombre,pf.numfactura,pf.monto FROM pago_factura pf INNER JOIN venta_agua va on va.id=pf.idventaagua INNER JOIN cliente c on c.id=va.idcliente INNER JOIN persona p on p.idpersona=c.id_persona WHERE pf.numfactura='$idFac' AND pf.estado=1;";

	return ejecutarConsulta($sql);
}

//listar registros activos
public function anular($idFac){
	$sql="SELECT monto,idventaagua,idasiento FROM pago_factura WHERE idpago=$idFac;";
	$pagoFac=ejecutarConsultaSimpleFila($sql);
	$monto=$pagoFac['monto'];
	$idVenta=$pagoFac['idventaagua'];
	$idasiento=$pagoFac['idasiento'];
	$sql="UPDATE asiento_contable SET total_debe=0,total_haber=0 WHERE id='$idasiento';";
	ejecutarConsulta($sql);
	$sql="UPDATE asiento_detalle SET monto=0 WHERE id_asiento='$idasiento';";
	ejecutarConsulta($sql);

	$sql="SELECT count(idpago) cant FROM pago_factura WHERE idpago='$idFac';";
	$cont=ejecutarConsultaSimpleFila($sql);
	$cantidad=$cont['cant'];

	$sql="SELECT sum(monto) tot FROM pago_factura WHERE idventaagua='$idVenta';";
	$tot=ejecutarConsultaSimpleFila($sql);
	$total=$tot['tot'];

	$sql="SELECT sum(precio_venta) tota FROM venta_detalle WHERE idventa='$idVenta';";
	$totV=ejecutarConsultaSimpleFila($sql);
	$totalVenta=$totV['tota'];

	$sql="SELECT idcliente FROM venta_agua WHERE id='$idVenta';";
	$idcli=ejecutarConsultaSimpleFila($sql);
	$idCliente=$idcli['idcliente'];
	$saldo=0;
	if($totalVenta >$monto){
			$saldo=$totalVenta-$total;
	}
	if($saldo >0){
		$sql="SELECT cc.id idcosto,c.id FROM costos_cliente cc INNER JOIN costos c on c.id=cc.id_costo WHERE c.monto=$saldo AND cc.id_cliente='$idCliente' AND c.descripcion like 'Saldo pago Factura #%';";
		$idC=ejecutarConsultaSimpleFila($sql);
		$idCosto=$idC['idcosto'];
		$idCos=$idC['id'];
		$restar=$total-$monto;
		if($restar == 0){			
			$sql="UPDATE costos_cliente SET estado=0,pagos_realizados=0,cantidad_pago=0 WHERE id=$idCosto;";
			ejecutarConsulta($sql);
		}else{
			$saldo=$totalVenta-$restar;
			$sql="UPDATE costos SET monto=$saldo WHERE id=$idCos;";
			ejecutarConsulta($sql);
		}
	}
	if($cantidad == 1){
		$sql="UPDATE venta_agua SET estado=1 WHERE id='$idVenta';";
		ejecutarConsulta($sql);
	}
	$fecha=date('Y-m-d');
	$sql="INSERT INTO facturas_anuladas (fecha,idpagofactura,monto) VALUES ('$fecha','$idFac','$monto');";
	ejecutarConsulta($sql);
	$sql="UPDATE pago_factura SET estado=0,monto=0 WHERE idpago='$idFac';";
	return ejecutarConsulta($sql);

}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
