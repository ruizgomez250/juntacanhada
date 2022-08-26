<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class CategoriaUsuarios{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($descripcion,$gsconsumominimo,$m3consumominimo,$gsexceso,$consumoexceso){
	$sql="INSERT INTO categoria_usuario (descripcion,costo_consumo_minimo,litros_minimo,costo_sobre_minimo,litros_sobre_minimo)
	 VALUES ('$descripcion','$gsconsumominimo','$m3consumominimo','$gsexceso','$consumoexceso')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$descripcion,$gsconsumominimo,$m3consumominimo,$gsexceso,$consumoexceso){
	$sql="UPDATE categoria_usuario SET descripcion='$descripcion',costo_consumo_minimo='$gsconsumominimo',litros_minimo='$m3consumominimo',costo_sobre_minimo='$gsexceso',litros_sobre_minimo='$consumoexceso'
	WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE banco SET estado='0' WHERE id='$idarticulo'";
	return ejecutarConsulta($sql);
	
}
public function activar($idarticulo){
	$sql="UPDATE banco SET estado='1' WHERE id=$idarticulo;";
	return ejecutarConsulta($sql);
	//return($sql);
}

//metodo para mostrar registros
public function mostrar($idarticulo){
	$sql="SELECT * FROM categoria_usuario WHERE id=$idarticulo;";
	return ejecutarConsultaSimpleFila($sql);
	//echo($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT id,costo_consumo_minimo,costo_sobre_minimo,descripcion,litros_minimo,litros_sobre_minimo FROM categoria_usuario ;";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
public function select(){
	$sql="SELECT * FROM categoria_usuario";
	return ejecutarConsulta($sql);
}
//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>
