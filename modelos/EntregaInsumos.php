<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class EntregaInsumos{


	//implementamos nuestro constructor
public function __construct(){

}


public function insertar($idcliente,$idusuario,$tipo_comprobante,$fecha_hora,$idarticulo,$cantidad){
	$sql="SELECT coalesce(max(num_comprobante),0) n from nota_remision";
	$row=ejecutarConsultaSimpleFila($sql);
	$num_comprobante=$row['n'];
	$num_comprobante++;
	$sql="INSERT INTO nota_remision (fecha_hora,idcliente,idusuario,num_comprobante,tipo_comprobante) VALUES ('$fecha_hora','$idcliente','$idusuario','$num_comprobante','$tipo_comprobante')";
	
	//return ejecutarConsulta($sql);
	 $idventanew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 $sql_det='';
	 while ($num_elementos < count($idarticulo)) {
	 	$sql_stock="UPDATE articulo SET stock= stock-$cantidad[$num_elementos] WHERE idarticulo=$idarticulo[$num_elementos];";
	 	ejecutarConsulta($sql_stock);

	 	$sql_detalle="INSERT INTO detalle_remision (estado,idarticulo,cantidad,idremision) VALUES('1','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$idventanew');";
	 	$sql_det="INSERT INTO detalle_remision (idarticulo,cantidad,idremision) VALUES('$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$idventanew');";
	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
	 //return $sql_det;
}
public function anular($idventa){
	$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
	return ejecutarConsulta($sql);
}


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT n.fecha_hora,p.idpersona,n.id cliente FROM nota_remision n INNER JOIN persona p on p.idpersona=n.idcliente  WHERE id='$idventa'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetalle($idventa){
	$sql="SELECT d.cantidad,a.nombre FROM detalle_remision d INNER JOIN articulo a on a.idarticulo=d.idarticulo WHERE d.idremision='$idventa'";
	return ejecutarConsulta($sql);
}
public function listare(){
	$sql="SELECT * FROM persona  WHERE tipo_persona='Encargado';";
	return ejecutarConsulta($sql);
}
//listar registros
public function listar(){
	$sql="SELECT n.id,DATE(n.fecha_hora) as fecha,n.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, n.tipo_comprobante,n.num_comprobante,n.estado FROM nota_remision n INNER JOIN persona p ON p.idpersona=n.idcliente INNER JOIN usuario u ON n.idusuario=u.idusuario ORDER BY n.id DESC;";
	return ejecutarConsulta($sql);
}


public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idventa){
	$sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
         return ejecutarConsulta($sql);
}


}

 ?>
