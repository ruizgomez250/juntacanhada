<?php 
require_once "../modelos/Costos.php";

$articulo=new Costos
();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar(strtoupper($descripcion),$monto,$idcuenta);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			    $rspta=$articulo->editar($idarticulo,strtoupper($descripcion),$monto,$idcuenta);
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
			$ret=$reg->id;
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>',
            "1"=>$reg->monto,
            "2"=>$reg->descripcion,
            "3"=>$reg->cuenta,
            "4"=>($reg->estado)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
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
		case 'listarAsig':
		$rspta=$articulo->listar();
		$data=Array();
		$ret=0;
		while ($reg=$rspta->fetch_object()) {
			$ret=$reg->id;
			$data[]=array(
            "0"=>'<button class="btn btn-info btn-xs" onclick="agregar(\''.$reg->id.'\',\''.$reg->descripcion.'\',\''.number_format($reg->monto, 0, ',', '.').'\')"><i class="fa fa-hand-o-right"></i></button>',
            "1"=>$reg->monto,
            "2"=>$reg->descripcion,
            "3"=>$reg->cuenta,
            "4"=>($reg->estado)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
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