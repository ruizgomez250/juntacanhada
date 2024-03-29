<?php 
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				$idcuenta=$_POST["idcuenta"];
				if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
					$imagen=$_POST["imagenactual"];
				}else{
					$ext=explode(".", $_FILES["imagen"]["name"]);
					if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
						$imagen=round(microtime(true)).'.'. end($ext);
						move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/".$imagen);
					}
				}
				if (empty($idarticulo)) {
					$rspta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idcuenta);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
				}else{
			         $rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idcuenta);
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
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
            "6"=>$reg->descripcion,
            "7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarArticulosVenta':
						$rspta=$articulo->listarActivosVenta();
						$data=Array();

						while ($reg=$rspta->fetch_object()) {
							$data[]=array(
				            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\','.$reg->precio_venta.','.$reg->stock.')"><span class="fa fa-plus"></span></button>',
				            "1"=>$reg->nombre,
				            "2"=>$reg->categoria,
				            "3"=>$reg->codigo,
				            "4"=>$reg->stock,
				            "5"=>$reg->precio_venta,
				            "6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
				          
				              );
						}
						$results=array(
				             "sEcho"=>1,//info para datatables
				             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
				             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
				             "aaData"=>$data); 
						echo json_encode($results);

				break;
		case 'listarArticulos':

				$rspta=$articulo->listarActivos();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
		/*	$datosM['data'][$cont]= array('nombre' => $nombre,
												  'cat' => $reg->categoria,
												  'codig' => $reg->codigo,
												  'stock' => $reg->stock,
												  'img' => "<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>");*/
			$nombre=str_replace('"', '', $reg->nombre);
			$nombre=str_replace("'", "", $nombre);
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$nombre.'\')"><span class="fa fa-plus"></span></button>',
            "1"=>$nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);  
		//echo json_encode($results);
				echo json_encode($results, JSON_UNESCAPED_UNICODE);
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