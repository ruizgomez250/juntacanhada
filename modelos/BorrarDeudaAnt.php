<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class BorrarDeudaAnt{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro

public function insertar($codCliente,$idfactura,$diferencia,$monto,$fecha,$idusuario){
	$sql="SELECT coalesce(num_factura,0) numfac FROM venta_agua WHERE id=$idfactura;";
	$res=ejecutarConsultaSimpleFila($sql);
	$nuevaFac=$res['numfac'];
	if($res['numfac'] < 1){
		$sql="SELECT coalesce((nro),0) fac FROM numerofactura WHERE id='1';";
		$res=ejecutarConsultaSimpleFila($sql);
		$nuevaFac=($res['fac']*1)+1;
		$sql="UPDATE numerofactura SET nro='$nuevaFac' WHERE id='1';";
		$res=ejecutarConsulta($sql);
		$sql="UPDATE venta_agua SET num_factura='$nuevaFac',estado=2 WHERE idcliente='$codCliente';";
		$res=ejecutarConsulta($sql);
	}else{
			$sql="UPDATE venta_agua SET estado=2 WHERE id='$idfactura';";
		$res=ejecutarConsulta($sql);
	}
	if($diferencia > 0){
	  $descr='Saldo pago Factura #'.$nuevaFac;
      $sql="INSERT INTO costos (descripcion,estado,id_cuenta,monto) VALUES ('$descr','1','5','$diferencia');";
      $idCostos=ejecutarConsulta_retornarID($sql);
      $sql="INSERT INTO costos_cliente (cantidad_pago,estado,fecha,id_cliente,id_costo,id_usuario,pagos_realizados) VALUES ('1','1','$fecha','$codCliente','$idCostos','$idusuario','0');";
      ejecutarConsulta($sql);
	}
	$sql="INSERT INTO pago_factura (estado,fecha,idusuario,idventaagua,monto,numfactura) VALUES ('1','$fecha','$idusuario','$idfactura','$monto','$nuevaFac');";
	return ejecutarConsulta_retornarID($sql);
	//return $sql;

	//echo $sql;
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
public function eliminar($idimpuesto){
	$sql = "DELETE FROM venta_detalle WHERE id=$idimpuesto;";
	return ejecutarConsulta($sql);
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
public function listarLecturas($id){
	$sql="SELECT * FROM lectura WHERE id_hidrometro=$id";
	return ejecutarConsulta($sql);
}
public function listar(){
	$sql="SELECT h.id,h.medidor,c.orden,c.id id_usuario,z.descripcion zona,p.nombre,p.apellido,p.num_documento,cat.descripcion categoria FROM cliente c INNER JOIN zona z on z.id=c.id_zona INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN hidrometro h on h.idcliente=c.id INNER JOIN categoria_usuario cat on cat.id=c.id_categoria WHERE c.estado=1;";
	return ejecutarConsulta($sql);
}
public function listarDeuda($fecha){
	$fechaSig=date("Y-m-d",strtotime($fecha."+ 1 days"));
	$sql="SELECT vd.id,vd.concepto,vd.precio_venta,p.nombre,p.apellido FROM venta_detalle vd INNER JOIN venta_agua va on va.id=vd.idventa INNER JOIN cliente c on c.id=va.idcliente INNER JOIN persona p on p.idpersona=c.id_persona WHERE  va.id=(SELECT max(id) FROM venta_agua WHERE idcliente='$fecha');";
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
