<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Cliente{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$apellido){
	$sql="INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email,apellido) VALUES ('$tipo_persona','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$apellido')";
	return ejecutarConsulta_retornarID($sql);
}
public function insertarCliente($idcategoria,$idsituacion,$idzona,$obs,$fecha,$idusuario,$orden,$idPersona){
	$sql="INSERT INTO cliente (estado,fecha_carga,id_categoria,id_situacion,id_usuario,id_zona,obs,orden,id_persona) VALUES ('0','$fecha','$idcategoria','2','$idusuario','$idzona','$obs','$orden','$idPersona')";
	return ejecutarConsulta($sql);
	//return $sql;
}
public function insertarMedid($medidor,$fechaMedidor,$idcliente,$idusuario){
	//$sql="UPDATE cliente SET id_situacion=1,estado=1 WHERE id='$idcliente';";
	$sql="UPDATE cliente SET estado=10 WHERE id='$idcliente';";
	ejecutarConsulta($sql);
	$sql="INSERT INTO hidrometro (medidor,fecha,idcliente,id_usuario) VALUES ('$medidor','$fechaMedidor','$idcliente','$idusuario')";
	return ejecutarConsulta($sql);
	//return $sql;
}
public function cambiarMedid($medidorNuevo,$fechaMedidor,$idcliente,$idusuario,$lecInic){
	$sql="SELECT medidor,id FROM hidrometro WHERE idcliente=$idcliente;";
	$hid=ejecutarConsultaSimpleFila($sql);
	$medidor=$hid['medidor'];
	$idMedidor=$hid['id'];
	$sql="INSERT INTO cambiomedidor (fechacambio,idcliente,medidor) VALUES ('$fechaMedidor','$idcliente','$medidor');";
	ejecutarConsulta($sql);

	$sql="SELECT anhociclo,mesciclo FROM lectura WHERE id IN (SELECT max(id) FROM lectura WHERE id_hidrometro=$idMedidor);";
	$lec=ejecutarConsultaSimpleFila($sql);
	$anhocic=$lec['anhociclo'];
	$mescic=$lec['mesciclo'];

	
	$sql="INSERT INTO lectura (anhociclo,fecha_lectura,id_hidrometro,id_usuario,lectura,mesciclo,orden_emitido) VALUES ('$anhocic','$fechaMedidor','$idMedidor','$idusuario','$lecInic','$mescic','1');";	
	 ejecutarConsulta($sql);
	$sql="UPDATE hidrometro SET medidor='$medidorNuevo' WHERE id=$idMedidor;";	
	return ejecutarConsulta($sql);
	//return($sql);
}
//metodo para mostrar registros
public function consultaMedid($idCliente){
	$sql="SELECT count(h.id) cantidad FROM hidrometro h WHERE h.idcliente=$idCliente;";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function mostrarDatos($idCliente){
	$sql="SELECT c.id,CONCAT(p.nombre, ' ',p.apellido) AS nombre,p.apellido,p.num_documento,z.descripcion,z.descripcion zona,cat.descripcion categoria FROM cliente c INNER JOIN persona p on p.idpersona=c.id_persona LEFT JOIN zona z on z.id=c.id_zona LEFT JOIN categ_cliente cat on cat.id=c.id_categoria WHERE c.id=$idCliente;";
	return ejecutarConsultaSimpleFila($sql);
}
public function editarCliente($idcategoria,$idsituacion,$idzona,$obs,$fecha,$idusuario,$idPersona){
	$estado=1;
	if($idsituacion > 1){
		$estado=0;
	}
	$sql="UPDATE cliente SET id_categoria='$idcategoria',fecha_carga='$fecha',id_situacion='$idsituacion',id_usuario='$idusuario',id_zona='$idzona',obs='$obs',estado='$estado' WHERE id_persona=$idPersona;";
	return ejecutarConsulta($sql);
	
}
public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$apellido){
	$sql="UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',apellido='$apellido' 
	WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idpersona){
	$sql="DELETE FROM cliente WHERE id_persona='$idpersona'";
	ejecutarConsulta($sql);
	$sql="DELETE FROM persona WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idpersona){
	$sql="SELECT p.idpersona,p.direccion,p.email,CONCAT(p.nombre, ' ',p.apellido) AS nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden,p.apellido FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE p.idpersona='$idpersona';";
	return ejecutarConsultaSimpleFila($sql);
}
public function verificarSituacion($idpersona){
	$sql="SELECT count(l.id) AS sit FROM lectura l INNER JOIN hidrometro h on h.id=l.id_hidrometro INNER JOIN cliente c on c.id=h.idcliente WHERE l.orden_emitido=1 and c.id_persona='$idpersona';";
	return ejecutarConsultaSimpleFila($sql);
}
public function cantLectura($idpersona){
	$sql="SELECT count(l.id) AS sit1 FROM lectura l INNER JOIN hidrometro h on h.id=l.id_hidrometro INNER JOIN cliente c on c.id=h.idcliente WHERE l.orden_emitido=0 and c.id_persona='$idpersona';";
	return ejecutarConsultaSimpleFila($sql);
}
//metodo para mostrar registros
public function verifMedidor($idCliente){
	$sql="SELECT COUNT(*) exist FROM hidrometro WHERE idcliente=$idCliente;";
	return ejecutarConsultaSimpleFila($sql);
}
public function mostrarCliente($idcliente){
	$sql="SELECT p.idpersona,p.direccion,p.email,CONCAT(p.nombre, ' ',p.apellido) AS nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE c.id='$idcliente';";
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
public function listarc(){
	$sql="SELECT p.*,c.* FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE p.tipo_persona='Cliente' order by c.id;";
	return ejecutarConsulta($sql);
}
public function listarAsig(){
	$sql="SELECT c.id,c.orden,c.obs,CONCAT(p.nombre, ' ',p.apellido) AS nombre,z.descripcion zona,s.descripcion situacion,cat.descripcion categoria FROM cliente c INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN zona z on z.id=c.id_zona INNER JOIN situacion s on s.id=c.id_situacion INNER JOIN categoria_usuario cat on cat.id=c.id_categoria;";
	return ejecutarConsulta($sql);
}
}

 ?>
