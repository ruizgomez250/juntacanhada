<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class CostosCliente{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($codCosto,$codigoCliente,$cantPago,$fecha,$idusuario){
	$sql="INSERT INTO costos_cliente(cantidad_pago,estado,fecha,id_cliente,id_costo,id_usuario,pagos_realizados)
	 VALUES ('$cantPago','1','$fecha','$codigoCliente','$codCosto','$idusuario','0')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$codCosto,$codUs,$cantPago,$fecha,$idusuario){
	$sql="UPDATE costos_cliente SET cantidad_pago='$cantPago',fecha='$fecha',id_cliente='$codUs',id_costo='$codCosto',id_usuario='$idusuario' WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE costos SET estado='0' WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
	
}
public function activar($idarticulo){
	$sql="UPDATE costos SET estado='1' WHERE id=$idarticulo;";
	return ejecutarConsulta($sql);
	//return($sql);
}

//metodo para mostrar registros
public function mostrar($idarticulo){
	$sql="SELECT cos.id,cos.cantidad_pago,cos.estado,cos.fecha,cos.id_cliente,cos.id_costo,cos.pagos_realizados,CONCAT(p.nombre, ' ',p.apellido) As nombre,co.descripcion FROM costos_cliente cos INNER JOIN cliente c on c.id=cos.id_cliente INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN costos co on co.id=cos.id_costo WHERE cos.id=$idarticulo;";
	return ejecutarConsultaSimpleFila($sql);
	//echo($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT c.pagos_realizados,c.id,c.cantidad_pago,c.fecha,cost.descripcion,cost.monto,cli.id nrousu,CONCAT(p.nombre, ' ',p.apellido) As nombre FROM costos_cliente c INNER JOIN cliente cli on cli.id=c.id_cliente INNER JOIN costos cost on cost.id=c.id_costo INNER JOIN persona p on p.idpersona=cli.id_persona WHERE c.cantidad_pago > c.pagos_realizados AND NOT cost.descripcion like 'Saldo pago Factura #%';";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
public function select(){
	$sql="SELECT * FROM situacion WHERE estado=1";
	return ejecutarConsulta($sql);
}
//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
