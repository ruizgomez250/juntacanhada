<?php 
require_once "../modelos/Cliente.php";

$persona=new Cliente();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idsituacion=isset($_POST["idsituacion"])? limpiarCadena($_POST["idsituacion"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
switch ($_GET["op"]) {
	case 'guardaryeditar':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				$fecha=date('Y-m-d h:i:s', time());
				if (empty($idpersona)) {
					$idPersona=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$apellido);
					$row=$persona->selectUltimaOrden();
					$orden=$row["ord"];
					$orden++; 
					$rspta=$persona->insertarCliente($idcategoria,2,$idzona,$obs,$fecha,$idusuario,$orden,$idPersona,);
					echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
					//echo $rspta;
				}else{
			         $rspta=$persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$apellido);
			         $rspta=$persona->editarCliente($idcategoria,$idsituacion,$idzona,$obs,$fecha,$idusuario,$idpersona);
					echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				}
		break;
	case 'guardarMedid':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				$medidor=$_POST['medidor'];
				$fechaMedidor=$_POST['fechaMedidor'];
				$idcliente=$_POST['idusuario'];
				$rspta1=$persona->consultaMedid($idcliente);
				if($rspta1['cantidad'] == 0){
					$rspta=$persona->insertarMedid($medidor,$fechaMedidor,$idcliente,$idusuario);
					echo $rspta ? "Datos guardados correctamente" : "No se pudo guardar los datos";
				}else{
					echo 'Ya existe un medidor asignado';
				}
				//echo($rspta);
		break;
	case 'cambiarMedid':
				session_start();
				$idcliente=$_POST['idusuario1'];
				$idusuario=$_SESSION['idusuario'];
				$medidor=$_POST['codmedidor1'];
				$lecInic=$_POST['lecInic'];
				$fechaMedidor=$_POST['fechaMedidor1'];
				$rspta1=$persona->cambiarMedid($medidor,$fechaMedidor,$idcliente,$idusuario,$lecInic);
				echo $rspta1 ? "Datos Guardados correctamente" : "No se pudo eliminar los datos";
				//echo($rspta1);
		break;
	case 'eliminar':
		$rspta=$persona->eliminar($idpersona);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;
	case 'mostrarDatos':

		$rspta=$persona->mostrarDatos($_POST['idCliente']);
		echo json_encode($rspta);
	break;
	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
		echo json_encode($rspta);
		break;
	case 'verificarSituacion':
		$rspta=$persona->verificarSituacion($idpersona);
		if($rspta['sit']==0){
			$rspta1=$persona->cantLectura($idpersona);
			if($rspta1['sit1'] < 2){
				echo(0);
			}else{
				echo(1);
			}
		}else{
			echo(1);
		}
		//echo json_encode($rspta);
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

		  case 'listarc':
		$rspta=$persona->listarc();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$rspta1=$persona->verifMedidor($reg->id);
			
			$boton='<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="asignarMedidor('.$reg->id.')"><i class="fa fa-tasks"></i></button></a>';
			if($rspta1["exist"] > 0){
							$boton='<a data-toggle="modal" href="#myModal1"><button class="btn btn-danger btn-xs" onclick="cambiarMedidor('.$reg->id.')"><i class="fa fa-tasks"></i></button></a>';
			}
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.' '.$boton,
            "1"=>$reg->id,
            "2"=>$reg->nombre.' '.$reg->apellido,
            "3"=>$reg->num_documento,
            "4"=>$reg->telefono,
            "5"=>$reg->email,
            "6"=>($reg->estado==1)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
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