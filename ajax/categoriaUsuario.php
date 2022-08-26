<?php 
require_once "../modelos/CategoriaUsuarios.php";

$articulo=new CategoriaUsuarios();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$gsconsumominimo=isset($_POST["gsconsumominimo"])? limpiarCadena($_POST["gsconsumominimo"]):"";
$m3consumominimo=isset($_POST["m3consumominimo"])? limpiarCadena($_POST["m3consumominimo"]):"";
$gsexceso=isset($_POST["gsexceso"])? limpiarCadena($_POST["gsexceso"]):"";
$consumoexceso=isset($_POST["consumoexceso"])? limpiarCadena($_POST["consumoexceso"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar(strtoupper($descripcion),$gsconsumominimo,$m3consumominimo,$gsexceso,$consumoexceso);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			         $rspta=$articulo->editar($idarticulo,strtoupper($descripcion),$gsconsumominimo,$m3consumominimo,$gsexceso,$consumoexceso);
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
			$ret=$reg->id;
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>',
            "1"=>$reg->descripcion,
            "2"=>$reg->costo_consumo_minimo,
            "3"=>$reg->litros_minimo,
            "4"=>$reg->costo_sobre_minimo,
            "5"=>$reg->litros_sobre_minimo
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