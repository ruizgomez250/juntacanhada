<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class CorregirFactura{


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
public function listar(){
	$sql = "SELECT pf.idpago id,c.id codCli,CONCAT(p.nombre, ' ',p.apellido) AS nombre,pf.numfactura,pf.monto FROM pago_factura pf INNER JOIN venta_agua va on va.id=pf.idventaagua INNER JOIN cliente c on c.id=va.idcliente INNER JOIN persona p on p.idpersona=c.id_persona;";

	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
