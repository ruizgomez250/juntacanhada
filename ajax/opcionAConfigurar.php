<?php 
require_once "../modelos/OpcionAConfigurar.php";
if (strlen(session_id())<1) 
	session_start();

$ingreso=new OpcionAConfigurar();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";



switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idingreso)) {
		$rspta=$ingreso->insertar($_POST["idarticulo"]);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
		break;
	
		case 'selectCuenta':

			$rspta=$ingreso->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->id.'>'.$reg->cuenta.'</option>';
			}
			break;
			
	case 'modificar':
		$rspta=$ingreso->modificar($_POST['idOpcion'],$_POST['idCuenta']);
		echo $rspta ? "Cuenta modificada correctamente" : "No se pudo modificar la Cuenta";
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
			$impuesto=($tot*$porcentaje)/100;
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
			$data[]=array(            
            "0"=>$reg->descripcion,
            "1"=>$reg->codigo,
            "2"=>$reg->cuenta,
            "3"=>'<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="asignar('.$reg->idOp.')"><i class="fa fa-exchange"></i></button></a>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
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

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->porcentaje.'>'.$reg->descripcion.'-'.$reg->porcentaje.'%'.'</option>';
			}
			break;

			case 'listarCuentas':

				$rspta=$ingreso->listarAsentables();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->id.',\''.$reg->cuenta.'\')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg->codigo,
            "2"=>$reg->cuenta
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

				break;
}
 ?>