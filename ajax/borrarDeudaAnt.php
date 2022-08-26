<?php 
require_once "../modelos/BorrarDeudaAnt.php";

$persona=new BorrarDeudaAnt();
$codCliente=isset($_POST["codCliente"])? limpiarCadena($_POST["codCliente"]):"";
$idfactura=isset($_POST["idfactura"])? limpiarCadena($_POST["idfactura"]):"";
$diferencia=isset($_POST["diferencia"])? limpiarCadena($_POST["diferencia"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";

switch ($_GET["op"]) {
	case 'guardar':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				$fechaActual=new DateTime();
				$fechaActual->setTimeZone(new DateTimeZone('America/Asuncion'));
				$fecha=$fechaActual->format('Y-m-d H:i:s');
				$rspta=$persona->insertar($codCliente,$idfactura,$diferencia,$monto,$fecha,$idusuario);
				
			echo ($rspta);
				
		break;
	
	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
		echo json_encode($rspta);
		break;
	case 'mostrarDatos':

		$rspta=$persona->mostrarDatos($_POST['idHidro']);
		echo json_encode($rspta);
	break;
	case 'listarLecturas':
				$verifUlt=$persona->ultimoCiclo($_GET['idusu']);
				$borr='';
				$idLec=0;
				if($verifUlt['orden_emitido'] == 0){
							$borr='<button class="btn btn-danger btn-xs" onclick="eliminar('.$verifUlt['id'].')"><i class="fa fa-trash"></i></button>';
							$idLec=$verifUlt['id'];
				}
				
				$rspta=$persona->listarLecturas($_GET['idusu']);

		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$borrar='';
			if($reg->id == $idLec){
				$borrar=$borr;
			}else{
				$borrar='';
			}
			$data[]=array(
            "0"=>$reg->fecha_lectura,
            "1"=>$reg->lectura,
            "2"=>$reg->mesciclo.'/'.$reg->anhociclo,
            "3"=>$borrar
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

				break;
	case 'ultimoCiclo':

		$rspta=$persona->ultimoCiclo($_POST['idHidro']);
		if(isset($rspta['mesciclo'])){
			if($rspta['mesciclo'] == 0){
				$rspsta1=$persona->cicloAFac($_POST['idHidro']);
				$rspsta1['lectura']=0;
				$rspsta1['fecha_lectura']='1000-01-01';
				echo json_encode($rspsta1);
			}else{
				echo json_encode($rspta);
			}
		}else{
			echo json_encode($rspta);
		}
	break;
	case 'cargarLecturas':

		$rspta=$persona->cargarLecturas();
		echo ($rspta);
	break;
		case 'mostrarCliente':
				$rspta=$persona->mostrarCliente($idpersona);
				echo json_encode($rspta);
		break;
    case 'listarp':
		$rspta=$persona->listarp();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->tipo_documento,
            "3"=>$reg->num_documento,
            "4"=>$reg->telefono,
            "5"=>$reg->email
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		  case 'listar':
		$rspta=$persona->listar();
		$data=Array();
		$cont=0;
		while ($reg=$rspta->fetch_object()) {	
			$nombre=$reg->nombre.' '.$reg->apellido;
			$rspta1=$persona->ultimaVenta($reg->id_usuario);
			$boton='';
			if(isset($rspta1['id'])){
				$boton='<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="traerDatos('.$reg->id_usuario.',\''.$reg->num_documento.'\',\''.$nombre.'\','.$cont.')"><i class="fa fa-ruble"></i></button></a>';
			}
			$data[]=array(
            "0"=>$boton,
            "1"=>$reg->orden,
            "2"=>$reg->id_usuario,
            "3"=>$reg->num_documento,
            "4"=>$nombre,
            "5"=>$reg->zona,
            "6"=>$reg->medidor,
            "7"=>$reg->categoria);
			$cont++;
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarDeuda':
		$fecha=$_GET['fecha'];
		$rspta=$persona->listarDeuda($fecha);
		$data=Array();
		$cont=0;
		$total=0;
		while ($reg=$rspta->fetch_object()) {	
			$cont++;
			$nombre=$reg->nombre.' '.$reg->apellido;
			$data[]=array(
            "0"=>'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->id.')"><i class="fa fa-close">',
            "1"=>$nombre,
            "2"=>$reg->concepto,
            "3"=>$reg->precio_venta);
		}
		$cont++;
		
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'ultimafactura':
				$idCliente=$_POST["idCliente"];
				$rspta=$persona->ultimaVenta($idCliente);
				$total=0;
				$idFact = '';
				if(isset($rspta['id'])){
						$idFact = $rspta['id'];
						$bodyTablaPermiso=0;
						$rspta=$persona->listarDetalles($idFact);						
						$stmt1 = '';
						$total=0;
						$cont=0;
						$bodyTablaPermiso=null;
						while ($reg=$rspta->fetch_object()) {
									$cont++;
									$idDetalle = $reg->id;
									$descripcion = $reg->descripcion;
									$exentas = round($reg->exentas);//round($exentas)
									if($exentas >0){
										$total=$total+$reg->exentas;
										//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
										$bodyTablaPermiso=('<tr><td class="text-center ">'.$descripcion.'</td><td class="text-center ">'.number_format($exentas,0,",",".").'</td></tr>').$bodyTablaPermiso;
									}
							
						}
						$bodyTablaPermiso=$bodyTablaPermiso.('<tr><td class="text-center "><strong>TOTAL</strong></td><td class="text-center "><strong>'.number_format($total,0,",",".").'</strong></td></tr>');
					echo(json_encode(array($bodyTablaPermiso,$total,$idFact)));
				}else{
					echo(0);
				}

				
			
	break;
	case 'eliminar':
		$rspta=$persona->eliminar($_POST["idlectura"]);
		echo $rspta ? "Dato Borrado Correctamente" : "No se pudo borrar el dato";
		//echo($sql);
	break;
		case 'listarAsig':
		$rspta=$persona->listarAsig();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-success btn-xs" onclick="asignarCliente('.$reg->id.',\''.$reg->nombre.'\')"><i class="fa fa-check"></i>',
            "1"=>$reg->id,
            "2"=>$reg->nombre,
            "3"=>$reg->zona,
            "4"=>$reg->situacion,
            "5"=>$reg->categoria
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
				require_once "../modelos/CategoriaUsuarios.php";
				$categoria=new CategoriaUsuarios();

				$rspta=$categoria->select();

				while ($reg=$rspta->fetch_object()) {
					echo '<option value=' . $reg->id.'>'.$reg->descripcion.'</option>';
				}
			break;
			case 'selectZona':
				require_once "../modelos/Zona.php";
				$categoria=new Zona();

				$rspta=$categoria->select();

				while ($reg=$rspta->fetch_object()) {
					echo '<option value=' . $reg->id.'>'.$reg->descripcion.'</option>';
				}
			break;
			case 'selectSituacion':
				require_once "../modelos/SituacionUsuario.php";
				$categoria=new SituacionUsuario();

				$rspta=$categoria->select();

				while ($reg=$rspta->fetch_object()) {
					echo '<option value=' . $reg->id.'>'.$reg->descripcion.'</option>';
				}
			break;
}
 ?>