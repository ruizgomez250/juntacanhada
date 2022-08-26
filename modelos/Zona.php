<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Zona{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($descripcion){
	$sql="INSERT INTO zona (descripcion,estado)
	 VALUES ('$descripcion','1')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$descripcion){
	$sql="UPDATE zona SET descripcion='$descripcion' 
	WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE zona SET estado='0' WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
	
}
public function activar($idarticulo){
	$sql="UPDATE zona SET estado='1' WHERE id=$idarticulo;";
	return ejecutarConsulta($sql);
	//return($sql);
}

//metodo para mostrar registros
public function mostrar($idarticulo){
	$sql="SELECT * FROM zona WHERE id=$idarticulo;";
	return ejecutarConsultaSimpleFila($sql);
	//echo($sql);
}
public function select(){
	$sql="SELECT * FROM zona WHERE estado =1";
	return ejecutarConsulta($sql);
}
//listar registros 
public function listar(){
	$sql="SELECT id,estado,descripcion FROM zona ;";
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
