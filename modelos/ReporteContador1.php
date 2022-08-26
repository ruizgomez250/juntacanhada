<?php 
//incluir la conexion de base de datos
require "../config/Conexion2.php";
class ReporteContador1{


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
public function guardar($cuenta,$codigo){
	$sql="INSERT INTO plan_de_cuentas (asentable,codigo,cuenta,mostrar_en_compra) VALUES ('1','$codigo','$cuenta','1');";
	return ejecutarConsulta($sql);
	//return $sql;
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
	$sql="SELECT id,codigo,cuenta,asentable FROM plan_de_cuentas WHERE asentable=1 and mostrar_en_compra=1;";
	return ejecutarConsulta($sql);
}
//listar registros
public function verificar($buscar){
	$sql="SELECT count(id) cont FROM plan_de_cuentas WHERE codigo='$buscar';";
	return ejecutarConsulta($sql);
}
//listar registros
public function listarTodo(){
	$sql="SELECT f.imptot,f.facnro,f.impmin,f.impexe,f.erssan,us.nombre,us.apellido,us.nrousu,imp.recibo,imp.monto,imp.excenta,imp.iva,imp.concepto,us.cedularuc FROM factura f LEFT JOIN usuarios us on us.nrousu=f.nrousu LEFT JOIN imprec imp on imp.facnro=f.facnro WHERE f.facmes=1 and f.anho=2021 order by f.facnro;";
	
	return ejecutarConsulta($sql);
}
public function listarTodo2(){
	$sql="SELECT b.nrousu,usu.nombre,usu.apellido,usu.cedularuc,b.facnro,b.fecfac,b.descri,b.unidad,b.iva,b.total FROM backupconexion b LEFT JOIN usuarios usu on usu.nrousu = b.nrousu;";
	
	return ejecutarConsulta($sql);
}
public function listarTodo1(){
	$sql="SELECT us.cedularuc,us.nombre,us.apellido,f.facnro,f.fecfac ,f.nrousu,f.descri,f.unidad,f.iva,f.total,f.faciva FROM backupconexion f INNER JOIN usuarios us on us.nrousu=f.nrousu ;";
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
