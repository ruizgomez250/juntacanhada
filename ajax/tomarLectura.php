<?php 
require_once "../modelos/TomarLectura.php";

$persona=new TomarLectura();
$hidr=isset($_POST["hidr"])? limpiarCadena($_POST["hidr"]):"";
$lectura=isset($_POST["lectura"])? limpiarCadena($_POST["lectura"]):"";
$fechaLectura=isset($_POST["fechaLectura"])? limpiarCadena($_POST["fechaLectura"]):"";
$mesperiodo=isset($_POST["mesperiodo"])? limpiarCadena($_POST["mesperiodo"]):"";
$anhoperiodo=isset($_POST["anhoperiodo"])? limpiarCadena($_POST["anhoperiodo"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
				session_start();
				$idusuario=$_SESSION['idusuario'];
				//$fecha=date('Y-m-d h:i:s', time());
				$rspta=$persona->insertar($lectura,$fechaLectura,$mesperiodo,$anhoperiodo,$hidr,$idusuario);
				$rspta10=$persona->contarLectura($hidr);
			if($rspta10['cont'] == 2){
				$persona->activarCliente($hidr);
			}
			$rspta1=$persona->listarUltLectura($hidr);
			$lectura=0;
			$anhoP=0;
			$mesP=0;
			while ($reg1=$rspta1->fetch_object()) {
					$lectura=$reg1->lectura;
					$lectura_ant=$reg1->lectura_ant;
					$mesP=$reg1->mesciclo+1;
					$anhoP=$reg1->anhociclo;
					if($mesP > 12){
						$mesP=1;
						$anhoP=$reg1->anhociclo+1;
					}
					
			}
			$rspta1=$persona->listarNuevatLectura($hidr,$mesP,$anhoP);
			$lecturaNuev='';
			while ($reg1=$rspta1->fetch_object()) {
				if(isset($reg1->lectura)){
					$lecturaNuev=$reg1->lectura;
				}
			}
				//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
			//echo $lecturaNuev;
			echo ($lecturaNuev);
				
		break;
		case 'guardaryeditarModif':
				//session_start();
				//$idusuario=$_SESSION['idusuario'];
				//$fecha=date('Y-m-d h:i:s', time());
				$rspta=$persona->modifLectFac($lectura,$_POST["fechaLectura"],$_POST["idlec"]);
				echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
				
		break;
	

	case 'eliminar':
		$hid = $_POST['hidrometro'];

		$rspta=$persona->eliminar($_POST['idlectura']);
		//echo $rspta ? "No se pudo eliminar los datos": "Datos eliminados correctamente" ;
		$rspta1=$persona->listarUltLectura($hid);
			$lectura=0;
			$anhoP=0;
			$mesP=0;
			while ($reg1=$rspta1->fetch_object()) {
					$lectura=$reg1->lectura;
					$lectura_ant=$reg1->lectura_ant;
					$mesP=$reg1->mesciclo+1;
					$anhoP=$reg1->anhociclo;
					if($mesP > 12){
						$mesP=1;
						$anhoP=$reg1->anhociclo+1;
					}
					
			}
			$lecturaNuev='';
			
				$rspta1=$persona->listarNuevatLectura($hid,$mesP,$anhoP);
				
				while ($reg1=$rspta1->fetch_object()) {
					if(isset($reg1->lectura)){
						$lecturaNuev=$reg1->lectura;
					}
				}
			
				//echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
			//echo $lecturaNuev;
			echo ($lecturaNuev);
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
			$rspta1=$persona->listarUltLectura($reg->id);
			$lectura=0;
			$anhoP=0;
			$mesP=0;
			while ($reg1=$rspta1->fetch_object()) {
					$lectura=$reg1->lectura;
					$lectura_ant=$reg1->lectura_ant;
					$mesP=$reg1->mesciclo+1;
					$anhoP=$reg1->anhociclo;
					if($mesP > 12){
						$mesP=1;
						$anhoP=$reg1->anhociclo+1;
					}
					
			}
			$rspta1=$persona->listarNuevatLectura($reg->id,$mesP,$anhoP);
			$lecturaNuev='';
			
			while ($reg1=$rspta1->fetch_object()) {
				if(isset($reg1->lectura)){
					$lecturaNuev=$reg1->lectura;
				}
			}
			$data[]=array(
            "0"=>'<a data-toggle="modal" href="#myModal"><button class="btn btn-primary btn-xs" onclick="traerDatos('.$reg->id.','.$cont.')"><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" border ="0" id= "editar" title="Tomar Medida" /></button></a>',
            "1"=>$reg->orden,
            "2"=>$reg->id_usuario,
            "3"=>$reg->num_documento,
            "4"=>$reg->nombre.' '.$reg->apellido,
            "5"=>$reg->zona,
            "6"=>$reg->medidor,
            "7"=>$reg->categoria,
            "8"=>$lectura_ant,
            "9"=>$lectura,
            "10"=>'<input class="form-control " value="'.$lecturaNuev.'" type="number" name="lecA'.$cont.'" id="lecA'.$cont.'"  placeholder="" readonly>');
			$cont++;
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarModif':
		$rspta=$persona->listar();
		$data=Array();
		$cont=0;
		while ($reg=$rspta->fetch_object()) {
			$idLectura='';
			$rspta1=$persona->listarUltLectura($reg->id);
			$lectura=0;
			$anhoP=0;
			$mesP=0;
			while ($reg1=$rspta1->fetch_object()) {
					$lectura=$reg1->lectura;
					$lectura_ant=$reg1->lectura_ant;
					$idLectura=$reg1->id;
					$mesP=$reg1->mesciclo+1;
					$anhoP=$reg1->anhociclo;
					if($mesP > 12){
						$mesP=1;
						$anhoP=$reg1->anhociclo+1;
					}
					
			}
			$rspta1=$persona->listarNuevatLectura($reg->id,$mesP,$anhoP);
			$lecturaNuev='';
			
			while ($reg1=$rspta1->fetch_object()) {
				if(isset($reg1->lectura)){
					$lecturaNuev=$reg1->lectura;
					$idLectura=$reg1->id;
				}
			}
			$data[]=array(
            "0"=>'<a data-toggle="modal" href="#myModal"><button class="btn btn-primary btn-xs" onclick="traerDatos('.$reg->id.','.$cont.','.$lectura_ant.','.$lectura.','.$reg->id_usuario.',\''.$reg->num_documento.'\',\''.$reg->zona.'\',\''.$reg->medidor.'\',\''.$reg->nombre.' '.$reg->apellido.'\','.$idLectura.')"><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" border ="0" id= "editar" title="Tomar Medida" /></button></a>',
            "1"=>$reg->orden,
            "2"=>$reg->id_usuario,
            "3"=>$reg->num_documento,
            "4"=>$reg->nombre.' '.$reg->apellido,
            "5"=>$reg->zona,
            "6"=>$reg->medidor,
            "7"=>$reg->categoria,
            "8"=>$lectura_ant,
            "9"=>$lectura,
            "10"=>'<input class="form-control " value="'.$lecturaNuev.'" type="number" name="lecA'.$cont.'" id="lecA'.$cont.'"  placeholder="" readonly>');
			$cont++;
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