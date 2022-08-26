<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class TomarLectura
{


	//implementamos nuestro constructor
	public function __construct()
	{
	}

	//metodo insertar regiustro

	public function insertar($lectura, $fechaLectura, $mesperiodo, $anhoperiodo, $hidr, $idusuario)
	{
		$sql = "INSERT INTO lectura (anhociclo,fecha_lectura,id_hidrometro,id_usuario,lectura,mesciclo,orden_emitido) VALUES ('$anhoperiodo','$fechaLectura','$hidr','$idusuario','$lectura','$mesperiodo','0')";
		return ejecutarConsulta_retornarID($sql);
		//echo $sql;
	}
	public function cargarLecturas()
	{
		session_start();
		$idusuario = $_SESSION['idusuario'];
		$fechaDef = date('Y-m-d');
		$sql = "SELECT h.id FROM hidrometro h INNER JOIN cliente c on c.id=h.idcliente WHERE c.id_categoria=4;";
		$rspta = ejecutarConsulta($sql);
		while ($reg = $rspta->fetch_object()) {
			$idhidr = $reg->id;
			$sql = "SELECT max(l.lectura) lectura,l.mesciclo,l.anhociclo FROM lectura l INNER JOIN hidrometro h on h.id=l.id_hidrometro WHERE h.id=$idhidr;";
			$rsp = ejecutarConsultaSimpleFila($sql);
			$lect = $rsp['lectura'];
			$mesciclo = $rsp['mesciclo'] + 1;
			$anhociclo = $rsp['anhociclo'];
			if ($mesciclo > 12) {
				$mesciclo = 1;
				$anhociclo++;
			}

			$sql = "INSERT INTO lectura (anhociclo,fecha_lectura,id_hidrometro,id_usuario,lectura,mesciclo,orden_emitido) VALUES ('$anhociclo','$fechaDef','$idhidr','$idusuario','$lect','$mesciclo','0')";
			$verif = ejecutarConsulta($sql);
			if (!$verif) {
				return 'Errores al guardar el dato!!';
			}
		}
		return 'Guardado en forma exitosa!!';
	}
	public function modifLectFac($lecturaActual, $lecturaAnterior, $idLectura)
	{
		$sql = "UPDATE lectura SET lectura='$lecturaActual',lectura_ant='$lecturaAnterior' WHERE id=$idLectura;";
		ejecutarConsulta($sql);
		$sql = "SELECT * FROM venta_agua WHERE idlectura=$idLectura;";
		$rsp =  ejecutarConsultaSimpleFila($sql);
		$idVentaAgua = $rsp['id'];
		$idcliente = $rsp['idcliente'];
		$sql = "SELECT cat.* FROM cliente c INNER JOIN categ_cliente cat on cat.id=c.id_categoria WHERE c.id=$idcliente;";
		$rsp1 =  ejecutarConsultaSimpleFila($sql);
		$precioVenta = intval($rsp1['consumo_minimo_gs']);
		$erssan = 0;
		$consumo = intval($lecturaActual) - intval($lecturaAnterior);
		$exceso = (intval($consumo) > intval($rsp1['consumo_minimo_m3']) ? intval($consumo) - intval($rsp1['consumo_minimo_m3']) : 0);
		$precioVenta = (intval($exceso) > 0 ? (intval($precioVenta) + (intval($exceso) * intval($rsp1['exceso_gs']))) : intval($rsp1['consumo_minimo_gs']));
		$erssan = (intval($precioVenta) * 0.02);

		$sql = "UPDATE venta_detalle SET precio_venta='$precioVenta',cantidad='$consumo' WHERE idventa=$idVentaAgua AND concepto like '%Agua Potable';";
		ejecutarConsulta($sql);
		$sql = "UPDATE venta_detalle SET precio_venta='$erssan' WHERE idventa=$idVentaAgua AND concepto like 'ERSSAN';";
		ejecutarConsulta($sql);
		$sql = "SELECT sum(precio_venta) tot FROM venta_detalle WHERE idventa=$idVentaAgua;";
		$rsp2 =  ejecutarConsultaSimpleFila($sql);
		$tot = $rsp2['tot'];
		$sql = "UPDATE venta_agua SET total_venta='$tot' WHERE id=$idVentaAgua;";
		return ejecutarConsulta($sql);
	}
	public function editarCliente($idcategoria, $idsituacion, $idzona, $obs, $fecha, $idusuario, $idPersona)
	{
		$sql = "UPDATE cliente SET id_categoria='$idcategoria',fecha_carga='$fecha',id_situacion='$idsituacion',id_usuario='$idusuario',id_zona='$idzona',obs='$obs' WHERE id_persona=$idPersona;";
		return ejecutarConsulta($sql);
	}
	public function editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email)
	{
		$sql = "UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email' 
	WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}
	//funcion para eliminar datos
	public function eliminar($idlectura)
	{
		$sql = "DELETE FROM lectura WHERE id='$idlectura'";
		ejecutarConsulta($sql);
	}

	//metodo para mostrar registros
	public function mostrarDatos($idhidro)
	{
		$sql = "SELECT h.medidor,h.idCliente,p.nombre,p.apellido,p.num_documento,z.descripcion zona FROM hidrometro h INNER JOIN cliente c on c.id=h.idCliente INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN zona z on z.id=c.id_zona WHERE h.id=$idhidro;";
		return ejecutarConsultaSimpleFila($sql);
	}
	//metodo para mostrar registros
	public function contarLectura($idhidro)
	{
		$sql = "SELECT count(id) cont FROM lectura WHERE id_hidrometro = $idhidro;";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function activarCliente($idhidro)
	{
		$sql = "UPDATE cliente c INNER JOIN hidrometro h SET c.id_situacion=1,c.estado=1 WHERE h.id='$idhidro' AND c.estado=10;";
		ejecutarConsulta($sql);
	}
	public function ultimoCiclo($idhidro)
	{
		$sql = "SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idhidro
    );";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function cicloAFac()
	{
		$sql = "SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE orden_emitido = 1
    );";
		return ejecutarConsultaSimpleFila($sql);
	}
	//metodo para mostrar registros
	public function mostrar($idpersona)
	{
		$sql = "SELECT p.idpersona,p.direccion,p.email,p.nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE p.idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function mostrarCliente($idcliente)
	{
		$sql = "SELECT p.idpersona,p.direccion,p.email,p.nombre,p.num_documento,p.telefono,p.tipo_documento,p.tipo_persona,c.estado,c.fecha_carga,c.id_categoria,c.id_persona,c.id_situacion,c.id_usuario,c.id_zona,c.obs,c.orden FROM persona p INNER JOIN cliente c on c.id_persona=p.idpersona WHERE c.id='$idcliente';";
		return ejecutarConsultaSimpleFila($sql);
	}
	//metodo para mostrar registros
	public function selectUltimaOrden()
	{
		$sql = "SELECT coalesce(max(orden),0) ord FROM cliente";
		return ejecutarConsultaSimpleFila($sql);
	}
	//listar registros
	public function listarp()
	{
		$sql = "SELECT * FROM persona WHERE tipo_persona='Proveedor'";
		return ejecutarConsulta($sql);
	}
	public function listarLecturas($id)
	{
		$sql = "SELECT * FROM lectura WHERE id_hidrometro=$id";
		return ejecutarConsulta($sql);
	}
	public function listar()
	{
		$sql = "SELECT h.id,h.medidor,c.orden,c.id id_usuario,z.descripcion zona,p.nombre,p.apellido,p.num_documento,cat.descripcion categoria FROM cliente c INNER JOIN zona z on z.id=c.id_zona INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN hidrometro h on h.idcliente=c.id INNER JOIN categoria_usuario cat on cat.id=c.id_categoria WHERE c.estado=1 OR c.estado=10;";
		return ejecutarConsulta($sql);
	}

	public function listarUltLectura($idHidro)
	{
		$sql = "SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idHidro AND orden_emitido=1
    );";
		return ejecutarConsulta($sql);
	}
	public function listarNuevatLectura($idHidro, $mesp, $anhop)
	{
		$sql = "SELECT max(lectura_ant) lectura FROM lectura  WHERE id_hidrometro=$idHidro;";
		$sql = "SELECT l.* FROM lectura l
    WHERE l.id IN (
        SELECT max(id) FROM lectura WHERE id_hidrometro = $idHidro AND mesciclo=$mesp AND anhociclo=$anhop
    );";
		return ejecutarConsulta($sql);
	}
	public function listarAsig()
	{
		$sql = "SELECT c.id,c.orden,c.obs,p.nombre,z.descripcion zona,s.descripcion situacion,cat.descripcion categoria FROM cliente c INNER JOIN persona p on p.idpersona=c.id_persona INNER JOIN zona z on z.id=c.id_zona INNER JOIN situacion s on s.id=c.id_situacion INNER JOIN categoria_usuario cat on cat.id=c.id_categoria;";
		return ejecutarConsulta($sql);
	}
}
