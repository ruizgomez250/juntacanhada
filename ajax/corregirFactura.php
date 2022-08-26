<?php 
require_once "../modelos/CorregirFactura.php";
//include('../config/Conexion1.php');
$corregirF=new CorregirFactura();
if (strlen(session_id())<1) 
	session_start();

$idimpuesto="";
if(isset($_POST["idimpuesto"])){
		$idimpuesto=$_POST['idimpuesto'];
			
}
/*$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
*/

switch ($_GET["op"]) {
	case 'guardaryeditar':
			$numFactura=$_POST['numfac'];
			$id=$_POST['id'];
			$rspta=$corregirF->editar($id,$numFactura);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos"; 
				//echo($sql);
			
	break;
	

	case 'anular':
		//$idimpuesto=$_POST['impuesto'];
		$sql = "DELETE FROM impuesto WHERE id=$idimpuesto;";
		$rspta = $conexion->query($sql);
		echo $rspta ? "Impuesto borrado correctamente" : "No se pudo borrar el impuesto";
		//echo($sql);
		break;
	
	case 'mostrar':
		$idimpuesto=$_POST['idimpuesto'];
		$sql="SELECT id,descripcion,porcentaje,estado,id_cuenta FROM impuesto WHERE id=$idimpuesto;";
		//echo($sql);
		$query = $conexion->query($sql);	
		$rspta=$query->fetch_assoc();
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//recibimos el idingreso
		$id=$_GET['id'];

		$rspta=$ingreso->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Precio Venta</th>
        <th>Subtotal</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_compra.'</td>
			<td>'.$reg->precio_venta.'</td>
			<td>'.$reg->precio_compra*$reg->cantidad.'</td>
			<td></td>
			</tr>';
			$total=$total+($reg->precio_compra*$reg->cantidad);
		}
		echo '<tfoot>
         <th>TOTAL</th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th><h4 id="total">S/. '.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th>
       </tfoot>';
		break;

    case 'listar':
		$rspta = $corregirF->listar();	
		$data=Array();
		
		while ($reg=$rspta->fetch_object()) {
			$id=$reg->id;
			$data[]=array(
            "0"=>$reg->codCli,
            "1"=>$reg->nombre,
            "2"=>'<input class="form-control" onchange="guardar('.$id.')" value="'.$reg->numfactura.'" type="number" name="numfac'.$id.'" id="numfac'.$id.'">',
            "3"=>number_format($reg->monto,0,",",".")
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

			case 'listarArticulos':
			require_once "../modelos/Impuesto.php";
			$impuesto=new Impuesto();

				$rspta=$impuesto->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->id.',\''.$reg->descripcion.'\')"><span class="fa fa-plus"></span></button>',
            "1"=>$reg->descripcion,
            "2"=>$reg->estado
          
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