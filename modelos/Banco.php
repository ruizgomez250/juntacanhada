<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Banco{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($tipocuenta,$numcuenta,$nombre,$numdoc,$idplancuentas){
	$sql="INSERT INTO banco (nombre,nro_cuenta,tipo_cuenta,cedula_ruc_titular,estado,id_plan_cuentas)
	 VALUES ('$nombre','$numcuenta','$tipocuenta','$numdoc','1','$idplancuentas')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$tipocuenta,$numcuenta,$nombre,$numdoc,$idplancuentas){
	$sql="UPDATE banco SET nombre='$nombre',nro_cuenta='$numcuenta',tipo_cuenta='$tipocuenta',cedula_ruc_titular='$numdoc',id_plan_cuentas=$idplancuentas 
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
	$sql="SELECT * FROM banco WHERE id=$idarticulo;";
	return ejecutarConsultaSimpleFila($sql);
	//echo($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT id,nombre,cedula_ruc_titular,nro_cuenta,tipo_cuenta,estado FROM banco ;";
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
