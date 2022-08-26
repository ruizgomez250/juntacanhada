<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class OpcionAConfigurar{


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

public function modificar($idOpcion,$idCuenta){
	$sql="UPDATE opcion_a_configurar SET id_cuenta=$idCuenta WHERE id=$idOpcion";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idingreso){
	$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario, i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE idingreso='$idingreso'";
	return ejecutarConsultaSimpleFila($sql);
}
public function listarImpuesto($idingreso){
	$sql="SELECT impuesto FROM ingreso WHERE idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

public function listarDetalle($idingreso){
	$sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta,di.margen FROM detalle_ingreso di INNER JOIN articulo a ON di.idarticulo=a.idarticulo WHERE di.idingreso='$idingreso'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT op.id idOp,op.descripcion,pl.id idPlan,pl.codigo,pl.cuenta FROM opcion_a_configurar op INNER JOIN plan_de_cuentas pl on pl.id=op.id_cuenta;";
	return ejecutarConsulta($sql);
}
public function listarAsentables(){
	$sql="SELECT op.id idOp,op.codigo,op.cuenta,pl.id idPlan,pl.codigo,pl.cuenta FROM opcion_a_configurar op INNER JOIN plan_de_cuentas pl on pl.id=op.id_cuenta;";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT id,cuenta FROM plan_de_cuentas WHERE mostrar_en_compra=1";
	return ejecutarConsulta($sql);
}

}

 ?>
