<?php 
require_once "../modelos/CostosFactura.php";

$articulo=new CostosFactura
();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$tipomonto=isset($_POST["tipomonto"])? limpiarCadena($_POST["tipomonto"]):"";
$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar(strtoupper($descripcion),$monto,$tipomonto,$idcuenta);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			    $rspta=$articulo->editar($idarticulo,strtoupper($descripcion),$monto,$tipomonto,$idcuenta);
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
			$erssan='<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>';
			if($reg->descripcion == 'ERSSAN'){
				$erssan='';
			}
			$data[]=array(
            "0"=>$erssan.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>'.' '.'<button class="btn btn-success btn-xs" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->monto,
            "2"=>$reg->descripcion,
            "3"=>$reg->cuenta,             
            "4"=>($reg->es_porcentaje)?'<span class="label bg-blue">Porcentaje</span>':'<span class="label bg-yellow">Monto fijo</span>',
            "5"=>($reg->estado)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
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