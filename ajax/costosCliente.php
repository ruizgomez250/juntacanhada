<?php 
require_once "../modelos/CostosCliente.php";

$articulo=new CostosCliente();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$codUs=isset($_POST["codUs"])? limpiarCadena($_POST["codUs"]):"";
$nomb=isset($_POST["nomb"])? limpiarCadena($_POST["nomb"]):"";
$cantPago=isset($_POST["cantpago"])? limpiarCadena($_POST["cantpago"]):"";
switch ($_GET["op"]) {
	case 'guardaryeditar':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				$dtz = new DateTimeZone("America/Asuncion");
				$fechaActual = new DateTime("now", $dtz);
				$fecha=$fechaActual->format('Y-m-d H:i:s');
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar($monto,$codUs,$cantPago,$fecha,$idusuario);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			    $rspta=$articulo->editar($idarticulo,$monto,$codUs,$cantPago,$fecha,$idusuario);
					echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				}
		break;
	case 'asignar':
				
					$rspta=$articulo->asignar($_POST["codCosto"],$_POST["codUs"]);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				
		break;

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$articulo->activar($idarticulo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		//echo($rspta);
		break;
	
	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$articulo->listar();
		$data=Array();
		$ret=0;
		while ($reg=$rspta->fetch_object()) {
			$cantP=$reg->pagos_realizados;
			$opc='';
			if($cantP == 0){
				$opc='<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>';
			}
			$data[]=array(
            "0"=>$opc,
            "1"=>$reg->monto,
            "2"=>$reg->descripcion,
            "3"=>$reg->nombre,
            "4"=>$reg->nrousu,
            "5"=>$reg->cantidad_pago,
            "6"=>$reg->pagos_realizados
              );
			/*

								.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>'.' '.'<button class="btn btn-success btn-xs" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>'.' '.'<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="agregar(\''.$reg->id.'\',\''.$reg->descripcion.'\',\''.number_format($reg->monto, 0, ',', '.').'\')"><i class="fa fa-hand-o-right"></i></button></a>'
			*/
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria=new Categoria();

			$rspta=$categoria->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
			break;
}
 ?>