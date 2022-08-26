<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Timbrado{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($desde,$hasta,$timbrado,$fecha,$idusuario){
	$sql="INSERT INTO timbrado (desde,hasta,timbrado,fecha,idusuario)
	 VALUES ('$desde','$hasta','$timbrado','$fecha','$idusuario')";
	return ejecutarConsulta($sql);
}

public function editar($desde,$hasta,$timbrado,$fecha,$idusuario,$idarticulo){
	$sql="UPDATE timbrado SET desde='$desde',hasta='$hasta',timbrado='$timbrado',fecha='$fecha',idusuario='$idusuario'  
	WHERE id='$idarticulo'";
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
	$sql="SELECT * FROM timbrado WHERE id='$idarticulo'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT t.id,t.desde,t.hasta,t.fecha,u.nombre,t.timbrado FROM timbrado t INNER JOIN usuario u ON u.idusuario=t.idusuario";
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
