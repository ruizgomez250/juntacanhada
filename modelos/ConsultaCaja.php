<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class ConsultaCaja{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idarticulo){
	$precio_venta=0;
	$margen=0;
	
	 $num_elementos=0;
	 $sw=true;
	 $ret='';
	 while ($num_elementos < count($idarticulo)) {
	 	$sql="UPDATE plan_de_cuentas SET mostrar_en_compra=1 WHERE id=$idarticulo[$num_elementos];";
	 	ejecutarConsulta($sql); 

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
	 //echo $ret;
}

public function anular($idingreso){
	$sql="UPDATE plan_de_cuentas SET mostrar_en_compra=0 WHERE id=$idingreso";
	return ejecutarConsulta($sql);
}
public function editar($idcuenta,$codigo,$nombre,$asentable){
	$sql="UPDATE plan_de_cuentas SET cuenta='$nombre',asentable='$asentable' WHERE id=$idcuenta";
	return ejecutarConsulta($sql);
}
public function guardar($cuenta,$codigo){
	$sql="INSERT INTO plan_de_cuentas (asentable,codigo,cuenta,mostrar_en_compra) VALUES ('1','$codigo','$cuenta','1');";
	return ejecutarConsulta($sql);
	//return $sql;
}

//metodo para mostrar registros
public function mostrar($idcuentas){
	$sql="SELECT * FROM plan_de_cuentas WHERE id='$idcuentas';";
	return ejecutarConsultaSimpleFila($sql);
	//return $sql;
}
public function listarImpuesto($idingreso){
	$sql="";
	return ejecutarConsulta($sql);
}

public function listarDetalle($idingreso){
	$sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta,di.margen FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo=a.idarticulo WHERE di.idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listarNoPagados(){
	$sql="SELECT f.num_factura,f.num_extracto,f.fechaemision,f.fechavencimiento,f.fecha_inicio,f.fecha_cierre,us.nombre usu,f.estado,per.nombre,per.apellido,cli.id codcli,f.total_venta,f.estado FROM venta_agua f INNER JOIN usuario us on us.idusuario=f.idusuario INNER JOIN cliente cli on cli.id=f.idcliente INNER JOIN persona per on per.idpersona=cli.id_persona WHERE f.estado < 2;";
	return ejecutarConsulta($sql);
}
//listar registros
public function verificar($buscar){
	$sql="SELECT count(id) cont FROM plan_de_cuentas WHERE codigo='$buscar';";
	return ejecutarConsulta($sql);
}
//listar registros
public function listarTodo(){
	$sql="SELECT id,codigo,cuenta,asentable FROM plan_de_cuentas;";
	return ejecutarConsulta($sql);
}
public function listarAsentables(){
	$sql="SELECT id,codigo,cuenta FROM plan_de_cuentas WHERE asentable=1;";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT id,cuenta FROM plan_de_cuentas WHERE mostrar_en_compra=1";
	return ejecutarConsulta($sql);
}

}

 ?>
