<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class AsientosContables{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro

public function insertar($fecha,$idcuenta,$debe,$haber){
	$sql="INSERT INTO asiento_contable (estado,fecha,origen,total_debe,total_haber) VALUES ('1','$fecha','cargado','0','0')";
	 $idingresonew=ejecutarConsulta_retornarID($sql);
	  $sw=true;
	  $ret='';
	 $num_elementos=0;
	 $totaldebe=0;
	 $totalhaber=0;
	 while ($num_elementos < count($idcuenta)) {
	 	$tipo=0;
	 	$monto=0;
	 	if($debe[$num_elementos] > 0){
	 		$tipo=1;
	 		$monto=$debe[$num_elementos];
	 		$totaldebe=$totaldebe+$monto;
	 	}else{
	 		$tipo=2;
	 		$monto=$haber[$num_elementos];
	 		$totalhaber=$totalhaber+$monto;
	 	}
	 	$sql_detalle1="INSERT INTO asiento_detalle (id_asiento,id_cuenta,monto,tipo) VALUES('$idingresonew','$idcuenta[$num_elementos]','$monto','$tipo')";
	 	$ret=$sql_detalle1;
	 	ejecutarConsulta($sql_detalle1) or $sw=false;
	 	$num_elementos++;
	 }
	 $sql="UPDATE asiento_contable SET total_debe=$totaldebe,total_haber=$totalhaber WHERE id = $idingresonew;";
	 ejecutarConsulta($sql);
	 return $sw;
	 //return(count($idcuenta));
}
public function modificar($idOpcion,$idCuenta){
	$sql="UPDATE asiento_detalle SET id_cuenta=$idCuenta WHERE id=$idOpcion";
	return ejecutarConsulta($sql);
}
public function cargarLecturas(){
	session_start();
	$idusuario=$_SESSION['idusuario'];
	$fechaDef=date('Y-m-d');
	$sql="SELECT h.id FROM hidrometro h INNER JOIN cliente c on c.id=h.idcliente WHERE c.id_categoria=4;";
	$rspta=ejecutarConsulta($sql);
	while ($reg=$rspta->fetch_object()) {
		$idhidr=$reg->id;
		$sql="SELECT max(l.lectura) lectura,l.mesciclo,l.anhociclo FROM lectura l INNER JOIN hidrometro h on h.id=l.id_hidrometro WHERE h.id=$idhidr;";
		$rsp=ejecutarConsultaSimpleFila($sql);
		$lect=$rsp['lectura'];
		$mesciclo=$rsp['mesciclo']+1;
		$anhociclo=$rsp['anhociclo'];
		if($mesciclo > 12){
			$mesciclo=1;
			$anhociclo++;
		}
		
		$sql="INSERT INTO lectura (anhociclo,fecha_lectura,id_hidrometro,id_usuario,lectura,mesciclo,orden_emitido) VALUES ('$anhociclo','$fechaDef','$idhidr','$idusuario','$lect','$mesciclo','0')";
	 	$verif=ejecutarConsulta($sql);
	 	if(!$verif){
	 		return 'Errores al guardar el dato!!';
	 	}
	}
	return 'Guardado en forma exitosa!!';
}
public function editarCliente($idcategoria,$idsituacion,$idzona,$obs,$fecha,$idusuario,$idPersona){
	$sql="UPDATE cliente SET id_categoria='$idcategoria',fecha_carga='$fecha',id_situacion='$idsituacion',id_usuario='$idusuario',id_zona='$idzona',obs='$obs' WHERE id_persona=$idPersona;";
	return ejecutarConsulta($sql);
	
}
public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email){
	$sql="UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email' 
	WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idlectura){
	$sql="DELETE FROM lectura WHERE id='$idlectura'";
	ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrarDatos($idhidro){
	$sql="SELECT h.medidor,h.idCliente,p.nombre,p.apellido,p.num_documento,z.descripcion zona FROM hidrometro h INNER JOIN cliente c on c.id=h.idCliente INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN zona z on z.id=c.id_zona WHERE h.id=$idhidro;";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function ultimaVenta($idCliente){
	$sql="SELECT  max(id) id  FROM venta_agua WHERE estado = 1 and idcliente=".$idCliente.";";
	return ejecutarConsultaSimpleFila($sql);
}
public function ultimoCosto($idCliente){
	$sql="SELECT  max(id) id  FROM costos_cliente WHERE pagos_realizados < cantidad_pago and id_cliente=".$idCliente.";";
	return ejecutarConsultaSimpleFila($sql);
}
public function ultimaVentaDif($idCliente){
	$sql="SELECT  max(va.id) id  FROM venta_agua va WHERE va.estado = 2 and idcliente='$idCliente' and va.tipo_comprobante like 'EXTRACTO';";
	return ejecutarConsultaSimpleFila($sql);
}
public function verificarSaldo($idFac){
	


	$sql="SELECT  sum(monto) diferencia  FROM  pago_factura  WHERE  idventaagua='$idFac' AND estado=1;";
	return ejecutarConsultaSimpleFila($sql);
}
public function compararDif($idFac){
	/*$sql="SELECT  sum(precio_venta) suma FROM venta_detalle WHERE idventa=$idFac;";
	$rsp1= ejecutarConsultaSimpleFila($sql);
		
	$tot=$rsp1['suma'];
	$sql="UPDATE venta_agua SET total_venta=$tot WHERE id=$idFac;";
	echo($sql);
	ejecutarConsultaSimpleFila($sql);*/


	$sql="SELECT total_venta tot FROM  venta_agua  WHERE id='$idFac';";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function contarLectura($idhidro){
	$sql="SELECT count(id) cont FROM lectura WHERE id_hidrometro = $idhidro;";
	return ejecutarConsultaSimpleFila($sql);
}
public function activarCliente($idhidro){
	$sql="UPDATE cliente c INNER JOIN hidrometro h SET c.id_situacion=1,c.estado=1 WHERE h.id='$idhidro' AND c.estado=10;";
	ejecutarConsulta($sql);
}
public function ultimoCiclo($idhidro){
	$sql="SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idhidro
    );";
	return ejecutarConsultaSimpleFila($sql);
}
public function cicloAFac(){
	$sql="SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE orden_emitido = 1
    );";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function mostrar($idpersona){
	$sql="SELECT p.idpersona,p.direccion,p.email,p.nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE p.idpersona='$idpersona'";
	return ejecutarConsultaSimpleFila($sql);
}
public function mostrarCliente($idcliente){
	$sql="SELECT p.idpersona,p.direccion,p.email,p.nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE c.id='$idcliente';";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function selectUltimaOrden(){
	$sql="SELECT coalesce(max(orden),0) ord FROM cliente";
	return ejecutarConsultaSimpleFila($sql);
}
public function verifCosto($idUsu){

	$sql="SELECT c.id,cost.descripcion,cost.monto FROM costos_cliente c INNER JOIN costos cost on cost.id=c.id_costo WHERE c.id_cliente='$idUsu' AND c.estado=1 AND pagos_realizados < cantidad_pago AND NOT cost.descripcion like 'Saldo pago Factura #%';";
	return ejecutarConsultaSimpleFila($sql);
}
//listar registros
public function listarp(){
	$sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
	return ejecutarConsulta($sql);
}
//listar registros
public function listarDetalles($idFact){
	$sql = "SELECT id,cantidad,concepto descripcion,precio_venta exentas FROM venta_detalle WHERE idventa=$idFact ORDER BY id desc;";
	return ejecutarConsulta($sql);
}
public function listarCosto($idCosto){
	$sql = "SELECT cc.id,c.descripcion descripcion,c.monto exentas FROM costos_cliente cc INNER JOIN costos c on c.id=cc.id_costo WHERE cc.id=$idCosto ORDER BY id desc;";
	return ejecutarConsulta($sql);
}
//listar registros
public function listarDetallesDif($idFact){
	$sql = "SELECT id,cantidad,concepto descripcion,precio_venta exentas FROM venta_detalle WHERE idventa='$idFact' AND NOT concepto like 'ERSSAN' order by id desc;";
	return ejecutarConsulta($sql);
}
public function listarDetallesDifErssan($idFact){
	$sql = "SELECT id,cantidad,concepto descripcion,precio_venta exentas FROM venta_detalle WHERE idventa='$idFact' AND concepto like 'ERSSAN' order by id desc";
	return ejecutarConsulta($sql);
}
public function listarLecturas($id){
	$sql="SELECT * FROM lectura WHERE id_hidrometro=$id";
	return ejecutarConsulta($sql);
}
public function listar(){
	$anho=date("Y");
	$desde=$anho.'-01-01';
	$hasta=$anho.'-12-31';
	$sql="SELECT c.fecha,pc.codigo,pc.cuenta,d.tipo,d.id,d.monto,d.id_asiento,c.total_debe,c.total_haber FROM asiento_contable c  INNER JOIN asiento_detalle d on d.id_asiento=c.id INNER JOIN plan_de_cuentas pc on pc.id=d.id_cuenta WHERE c.fecha BETWEEN '$desde' AND '$hasta' ORDER BY d.id_asiento ASC, d.tipo ASC;";
	return ejecutarConsulta($sql);
}
public function listarCaja($fecha){
	$fechaSig=date("Y-m-d",strtotime($fecha."+ 1 days"));
	$sql="SELECT pf.fecha,pf.monto,pf.numfactura,per.nombre,per.apellido,per.num_documento,cli.id numusuario FROM pago_factura pf INNER JOIN venta_agua vf on vf.id=pf.idventaagua INNER JOIN cliente cli on cli.id=vf.idcliente INNER JOIN persona per on per.idpersona=cli.id_persona WHERE pf.estado=1 AND pf.fecha BETWEEN '$fecha' AND '$fechaSig';";
	return ejecutarConsulta($sql);

	//echo($sql);
}
public function listarUltLectura($idHidro){
	$sql="SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idHidro AND orden_emitido=1
    );";
	return ejecutarConsulta($sql);
}
public function listarNuevatLectura($idHidro,$mesp,$anhop){
	$sql="SELECT max(lectura_ant) lectura FROM lectura  WHERE id_hidrometro=$idHidro;";
	$sql="SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idHidro AND mesciclo=$mesp AND anhociclo=$anhop
    );";
	return ejecutarConsulta($sql);
}
public function listarAsig(){
	$sql="SELECT c.id,c.orden,c.obs,p.nombre,z.descripcion zona,s.descripcion situacion,cat.descripcion categoria FROM cliente c INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN zona z on z.id=c.id_zona INNER JOIN situacion s on s.id=c.id_situacion INNER JOIN categoria_usuario cat on cat.id=c.id_categoria;";
	return ejecutarConsulta($sql);
}
}

 ?>
