<?php 
//incluir la conexion de base de datos
require "../config/Conexion2.php";
class ReporteContador{


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
	$sql="SELECT us.cedularuc,us.nombre,us.apellido,f.facnro,f.impmin,fa.impexe,fa.erssan,fa.facnro comparar FROM factura f INNER JOIN usuarios us on us.nrousu=f.nrousu LEFT JOIN factanul fa on fa.facnro=f.facnro WHERE f.facmes=1 and f.anho=2021 order by f.facnro;";
	return ejecutarConsulta($sql);
}
public function listarTodo24(){
	$sql="SELECT f.nrousu,f.impmin,f.impexe,f.erssan,f.impatr,f.imptot,us.cedularuc,us.nombre,us.apellido,f.facnro,f.impiva,f.fechemision FROM backupfactura f INNER JOIN usuarios us on us.nrousu=f.nrousu;";
	return ejecutarConsulta($sql);
}
public function listarTodo1(){
	$sql="SELECT us.cedularuc,us.nombre,us.apellido,f.facnro,f.total imptot,f.fecfac ,fa.facnro comparar FROM detpag f INNER JOIN usuarios us on us.nrousu=f.nrousu LEFT JOIN factanul fa on fa.facnro=f.facnro WHERE f.fecfac >= '2021-01-01' and f.fecfac <= '2021-01-31' order by f.facnro;";
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
