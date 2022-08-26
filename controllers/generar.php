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
$query =  isset($_POST["sql"]) ? $_POST["sql"] : "";
$mes =  isset($_POST["mes"]) ? $_POST["mes"] : "";
$anho =  isset($_POST["anho"]) ? $_POST["anho"] : "";



$generar = new Generar();
$pagina = 'pdfpersonalmodal.php?id=';
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
				"3" => ($reg->estado==1?'Activo':'<label style="background-color: orange;">Inactivo</label>'),
				"4" => ($reg->idcate == 4 ? '<label style="background-color: lightblue;">' . $reg->categoria . '</label>' : $reg->categoria),
				"5" => '<a href="' . $pagina . $reg->id . '" target="_blank"><i class="fa fa-file-pdf-o"></i></a>'
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
	case 'llenarcombo':
		$rspta = $generar->montarCombo($query);
		$data = array();
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"id" => $reg->nombre,
				"nombre" => $reg->nombre
			);
		}
		echo json_encode($data);
		break;
	case 'crearextracto':
		/*date_default_timezone_set('America/Asuncion');
		$DateAndTime2 = date('m_d_Y_h_i_s', time());*/
		$id_cuenta=0;
		$id_cuenta2 =0;
		$estado = 1;
		$tipocomprobante = 'EXTRACTO';
		$contador = 0;
		$lista = $generar->getListaLectura($mes, $anho);//a traves del ciclo obtiene la lista de clientes - idcliente 
		$id_cuenta = $generar->getOpcionConf(3);//a traves de la descripcion obtine el numero de cuenta de la tabla opcion a configurar		
		$id_cuenta2 = $generar->getOpcionConf(6);//a traves de la descripcion obtine el numero de cuenta de la tabla opcion a configurar
		$aux = 0;
		while ($reg = $lista->fetch_object()) {//recorre la lista de clientes
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
			$lectura = $generar->getLectura($reg->id, $mes, $anho);
			if (isset($lectura)) {
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
					$id_venta = $generar->insertarVentaA($estado, $reg->idcliente, $ext['nro'], $tipocomprobante, $lectura['id'], $vencimiento, $inicio, $cierre, $emision);
					$id_ventadetalle = $generar->insertarVentaDetalle($id_venta,$id_cuenta['descripcion'], $id_cuenta['id_cuenta'], $ConsumoTotal, $precioVenta);
					$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, $id_cuenta2['descripcion'], $id_cuenta2['id_cuenta'], 0, $erssan);
					if ($deudaAnt['deuda'] > 0) {
						$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, 'Deuda Anterior', $id_cuenta['id_cuenta'], 0, $deudaAnt['deuda']);
						$vtotal = $precioVenta + $erssan + $deudaAnt['deuda'];
					} else {
						$vtotal = $precioVenta + $erssan;
					}
					$update_total = $generar->setActualizarTotal($id_venta, $vtotal);
					$costoRow = mysqli_num_rows($costoCliente);
					if ($costoRow > 0) {
						while ($reg = $costoCliente->fetch_object()) {
							$id_ventadetalle = $generar->insertarVentaDetalle($id_venta, $reg->descripcion,  $reg->id_cuenta, 0,  $reg->monto);
							$actualizarPago = $generar->setActualizarPago($reg->id);
						}
					}
				}
			}
		}
		echo json_encode('PROCESO FINALIZADO');
		break;
}
