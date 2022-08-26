<?php 
require_once "../modelos/Ingreso.php";
if (strlen(session_id())<1) 
	session_start();

$ingreso=new Ingreso();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$fechaPago=isset($_POST["fechaPago"])? limpiarCadena($_POST["fechaPago"]):"";
$iddeuda=isset($_POST["iddeuda"])? limpiarCadena($_POST["iddeuda"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=isset($_SESSION["idusuario"])?$_SESSION["idusuario"]:"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
$cantidad_pagos=isset($_POST["cant_pago"])? limpiarCadena($_POST["cant_pago"]):"";
$metodo_pago=isset($_POST["metodo_pago"])? limpiarCadena($_POST["metodo_pago"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				if (empty($idingreso)) {
					$rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],0,0,$cantidad_pagos,$metodo_pago,$_POST["imp"],$_POST["idimp"],$_POST["fechP"]);
					//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
					echo $rspta;
					//echo($_POST["fechP"]);
				}else{
			        
				}
	break;
	case 'generarOrdenPago':
			//session_start();
				$idusuario=$_SESSION['idusuario'];
				$fecha=date('Y-m-d');
					$rspta=$ingreso->insertarOrden($idingreso,$fecha,$idusuario);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
					//echo $rspta;
					//echo($_POST["fechP"]);
				
		break;
	case 'guardPago':
		$fecha = str_replace('/', '-', $fechaPago);
    $fechap = date('Y-m-d', strtotime($fecha));
		$rspta=$ingreso->guardPag($idingreso,$fechap,$iddeuda);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		//echo $rspta;
		//echo($_POST["fechP"]);
	
		break;
	

	case 'anular':
		$rspta=$ingreso->anular($idingreso);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$ingreso->mostrar($idingreso);
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//recibimos el idingreso
		$id=$_GET['id'];
		$rspta=$ingreso->listarImpuesto($id);
		$porcentaje=0;
		while ($reg=$rspta->fetch_object()) {
			$porcentaje=$reg->impuesto;
		}
		
		$rspta=$ingreso->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Impuesto</th>
        <th>Total</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			$tot=($reg->precio_compra*$reg->cantidad);
			$impuesto=$reg->impuesto;
			$subt=($reg->precio_compra*$reg->cantidad)+$impuesto;
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_compra.'</td>
			<td>'.$impuesto.'</td>
			<td>'.$subt.'</td>
			<td></td>
			</tr>';
			$total=$total+($reg->precio_compra*$reg->cantidad)+$impuesto;
		}
		echo '<tfoot>
         <th>TOTAL</th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th><h4 id="total">Gs. '.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
       </tfoot>';
		break;

    case 'listar':
		$rspta=$ingreso->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$metodo_pago='';
			if($reg->metodo_pago == -1){
				$metodo_pago='Efectivo';
			}else if($reg->metodo_pago == -2){
				$metodo_pago='Documentos a pagar';
			}else{
				$metodo_pago='Banco';
			}
			$pagoCuot='';
			if($reg->cantidad_pagos > $reg->pagos_realizados){
				$pagoCuot='<a data-toggle="modal" href="#modalPago"><button onclick="cargarPago('.$reg->idingreso.')" class="btn btn-info btn-xs"><i class="fa fa-rouble"></i></button></a>';
			}
			$data[]=array(
            "0"=>($reg->estado=='Aceptado')?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>'.' '.$pagoCuot:'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>',
            "1"=>$reg->fecha,
            "2"=>$reg->proveedor,
            "3"=>$reg->usuario,
            "4"=>$reg->tipo_comprobante,
            "5"=>$reg->serie_comprobante,
            "6"=>$reg->num_comprobante,
            "7"=>$reg->total_compra,
            "8"=>$metodo_pago,
            "9"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarPa':

		$rspta=$ingreso->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$metodo_pago='';
			if($reg->metodo_pago == -1){
				$metodo_pago='Efectivo';
			}else if($reg->metodo_pago == -2){
				$metodo_pago='Documentos a pagar';
			}else{
				$metodo_pago='Banco';
			}
			//echo('ingresssso '.$reg->idingreso);
			
			$boton='';
			if($reg->estado=='Aceptado'){
				$verif=$ingreso->verificarOrdenP($reg->idingreso);
				if($verif['existe'] > 0){
					$boton='<a target="_blank" href="../reportes/ordenPago.php?id='.$verif['existe'].'"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
				}else{
					$boton='<button class="btn btn-warning btn-xs" onclick="ordenPago('.$reg->idingreso.')"><i class="fa fa-hand-o-right "></i></button>';
				}
			}
			$pagoCuot='';

			$data[]=array(
            "0"=>$boton,
            "1"=>$reg->fecha,
            "2"=>$reg->proveedor,
            "3"=>$reg->usuario,
            "4"=>$reg->tipo_comprobante,
            "5"=>$reg->serie_comprobante,
            "6"=>$reg->num_comprobante,
            "7"=>$reg->total_compra,
            "8"=>$metodo_pago,
            "9"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarDeuda':
		$idd=$_GET["id"];
		$rspta=$ingreso->listarDeuda($idd);
		$data=Array();
		$cont=0;
		while ($reg=$rspta->fetch_object()) {
			$pagoCuot='';
			$fechp='<input id="pago'.$cont.'" name="pago'.$cont.'"  class="form-control" type="date" value="'.date('Y-m-d').'">';
			if(!isset($reg->pagofecha)){
				$pagoCuot='<a data-toggle="modal" href="#modalPago"><button onclick="guardPago('.$idd.','.$cont.','.$reg->id.')" class="btn btn-success btn-xs"><i class="fa fa-rouble"></i></button></a>';
			}else{
				$fechp=$reg->pagofecha;
			}
			$data[]=array(
						"0"=>$cont+1,
            "1"=>$pagoCuot,
            "2"=>$reg->monto,
            "3"=>$reg->fecha_emision,
            "4"=>$reg->fecha_vencimiento,
            "5"=>$fechp
              );
			$cont++;
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		//echo($idd);
		break;
		case 'selectProveedor':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarp();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
			}
			break;
			case 'selectImpuesto':
			require_once "../config/Conexion1.php";
			$conexion = conexion_db();
			$sql = "SELECT id,porcentaje,descripcion FROM impuesto WHERE estado=1;";
			$rspta = $conexion->query($sql);
			$cont=1;
			$rsp = array(
		    0 => "",
		    1 => "",
		    2 => "",
			);
			while ($reg = $rspta->fetch_object()) {
				
					 

					if($cont == 1){
						$rsp[0]=$rsp[0].'<option selected="selected"  value="'.$reg->id.'">'.$reg->porcentaje.'</option>';
						$rsp[1]=$reg->id;
						$rsp[2]=$reg->porcentaje;
						
					}else{
						$rsp[0]=$rsp[0].'<option value="'.$reg->id.'">'.$reg->porcentaje.'</option>';
					}
				$cont++;
				
			}
			echo json_encode($rsp);
			break;
			case 'impdefault':
				$rspta=$ingreso->impDefault($idingreso);
				echo json_encode($rspta);
			break;
			case 'selectMetodoPago':
			require_once "../config/Conexion1.php";
			$conexion = conexion_db();
			$sql = "SELECT id,nombre,nro_cuenta FROM banco WHERE estado=1;";
			$rspta = $conexion->query($sql);
			echo '<option value=-1>Efectivo</option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->id.'>'.$reg->nombre.'('.$reg->nro_cuenta.')</option>';
			}
			break;

			
}
