<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Costos{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($descripcion,$monto,$cuenta){
	$sql="INSERT INTO costos(descripcion,monto,estado,id_cuenta)
	 VALUES ('$descripcion','$monto','1','$cuenta')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$descripcion,$monto,$cuenta){
	$sql="UPDATE costos SET descripcion='$descripcion',monto=$monto,id_cuenta='$cuenta'
	WHERE id='$idarticulo'";
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
	$sql="SELECT * FROM costos WHERE id=$idarticulo;";
	return ejecutarConsultaSimpleFila($sql);
	//echo($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT c.id,c.monto,c.descripcion,c.estado,p.cuenta FROM costos c INNER JOIN plan_de_cuentas p on p.id=c.id_cuenta WHERE NOT c.descripcion like 'Saldo pago Factura #%';";
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
