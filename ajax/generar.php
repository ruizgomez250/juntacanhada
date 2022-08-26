<?php
require_once "../modelos/Generar.php";
if (strlen(session_id()) < 1)
	session_start();
$_SESSION['idusuario'] = 1;
$_SESSION['nombre'] = 'angel';
$_SESSION['imagen'] = '1535417472.jpg';
$_SESSION['login'] = 'admin';


$inicio = isset($_POST["inicio"]) ? $_POST["inicio"] : "";
$cierre = isset($_POST["cierre"]) ? $_POST["cierre"] : "";
$vencimiento = isset($_POST["vencimiento"]) ? $_POST["vencimiento"] : "";
$emision = isset($_POST["emision"]) ? $_POST["emision"] : "";
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";



$generar = new Generar();
$pagina = 'generarpdf.php?id=';
switch ($_GET["op"]) {
	case 'listar':
		$rspta = $generar->listar();
		$data = array();
		while ($reg = $rspta->fetch_object()) {
			/*if ($reg->tipo_comprobante == 'Ticket') {
				$url = '../reportes/exTicket.php?id=';
			} else {
				$url = '../reportes/exFactura.php?id=';
			}*/
			$data[] = array(
				"0" => $reg->id,
				"1" => $reg->nombre,
				"2" => $reg->num_documento,
				"3" => $reg->categoria,
				"4" => '<a href="' . $pagina . $reg->id . '" target="_blank"><i class="fa fa-file-pdf-o"></i></a>'
			);
		}
		$results = array(
			"sEcho" => 1, //info para datatables
			"iTotalRecords" => count($data), //enviamos el total de registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;
	case 'crearextracto':
		/*date_default_timezone_set('America/Asuncion');
		$DateAndTime2 = date('m_d_Y_h_i_s', time());*/
		$estado = 1;
		$tipocomprobante = 'EXTRACTO';
		$contador = 0;
		$lista = $generar->getListaLectura();
		$descripcion = 'Consumo de Agua Potable';
		$id_cuenta = $generar->getOpcionConf($descripcion);
		$descripcion2 = 'ERSSAN';
		$id_cuenta2 = $generar->getOpcionConf($descripcion2);
		$aux = 0;
		while ($reg = $lista->fetch_object()) {
			$contador += 1;
			$ext = 0;
			$LecActual = 0;
			$LecAnterior = 0;
			$ConsumoMinimo = 0;
			$ConsumoTotal = 0;
			$PrecioVenta = 0;
			$deudaAnt = 0;
			$vtotal = 0;
			$erssan = 0;
			$ext =  $generar->getNroExtracto();
			$lectura = $generar->getLectura($reg->idcliente);
			if (intval($lectura['id']) > 0) {
				$deudaAnt = $generar->getDeudaAnterior($reg->idcliente);
				$costoCliente = $generar->getCostoCliente($reg->idcliente);
				$LecActual = intval($lectura['lectura']);
				$LecAnterior = intval($lectura['lectura_ant']);
				$ConsumoMinimo = intval($lectura['litros_minimo']); //consumo minio 12
				$ConsumoAux = $LecActual - $LecAnterior;
				$diferencia = ($ConsumoAux - $ConsumoMinimo);
				$ConsumoTotal = ($diferencia > 0 ? ($diferencia + $ConsumoMinimo) : $ConsumoMinimo);
				$precioVenta = ($diferencia > 0 ? (($diferencia * $lectura['costo_sobre_minimo']) + $lectura['costo_consumo_minimo']) : $lectura['costo_consumo_minimo']);
				$erssan = ($precioVenta * 0.02);
				$id_venta = $generar->insertarVentaA($inicio, $cierre, $vencimiento, $emision, $tipocomprobante, $reg->idcliente, $lectura['id'], $ext['nro'], $estado);
				$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, $descripcion, $id_cuenta['id_cuenta'], $ConsumoTotal, $precioVenta);
				$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, $descripcion2, $id_cuenta2['id_cuenta'], 0, $erssan);
				if ($deudaAnt['deuda'] > 0) {
					$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, 'Deuda Anterior', $id_cuenta['id_cuenta'], 0, $deudaAnt['deuda']);
					$vtotal = $precioVenta + $erssan + $deudaAnt['deuda'];
				} else {
					$vtotal = $precioVenta + $erssan;
				}
				$update_total = $generar->setActualizarTotal($id_venta, $vtotal);
				$costoRow = mysqli_num_rows($costoCliente);
				if($costoRow > 0){
					while ($reg = $costoCliente->fetch_object()) {
						$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, $reg->descripcion,  $reg->id_cuenta, 0,  $reg->monto);
						$actualizarPago = $generar->setActualizarPago($reg->id);
					}
				}
			}
		}
		echo json_encode('LISTO EL POLLO_' );
		break;
}
