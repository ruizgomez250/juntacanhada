<?php 
require_once "../modelos/Banco.php";

$articulo=new Banco();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$tipocuenta=isset($_POST["tipo_cuenta"])? limpiarCadena($_POST["tipo_cuenta"]):"";
$numcuenta=isset($_POST["num_cuenta"])? limpiarCadena($_POST["num_cuenta"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$numdoc=isset($_POST["num_doc"])? limpiarCadena($_POST["num_doc"]):"";
$idplancuentas=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar($tipocuenta,$numcuenta,$nombre,$numdoc,$idplancuentas);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			         $rspta=$articulo->editar($idarticulo,$tipocuenta,$numcuenta,$nombre,$numdoc,$idplancuentas);
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
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>'.' '.'<button class="btn btn-success btn-xs" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->cedula_ruc_titular,
            "3"=>$reg->nro_cuenta,
            "4"=>$reg->tipo_cuenta,
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