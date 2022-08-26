<?php 
require_once "../modelos/Timbrado.php";

$articulo=new Timbrado();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$desde=isset($_POST["desde"])? limpiarCadena($_POST["desde"]):"";
$hasta=isset($_POST["hasta"])? limpiarCadena($_POST["hasta"]):"";
$timbrado=isset($_POST["timbrado"])? limpiarCadena($_POST["timbrado"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				$fecha=date('Y-m-d');
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar($desde,$hasta,$timbrado,$fecha,$idusuario);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			         $rspta=$articulo->editar($desde,$hasta,$timbrado,$fecha,$idusuario,$idarticulo);
					echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				}
		break;
	

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$articulo->activar($idarticulo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$articulo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>',
            "1"=>$reg->desde,
            "2"=>$reg->hasta,
            "3"=>$reg->timbrado,
            "4"=>$reg->fecha,
            "5"=>$reg->nombre
              );
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