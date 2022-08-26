<?php 
require_once "../modelos/AsientosContables.php";

$persona=new AsientosContables();
$codCliente=isset($_POST["codCliente"])? limpiarCadena($_POST["codCliente"]):"";
$idfactura=isset($_POST["idfactura"])? limpiarCadena($_POST["idfactura"]):"";
$diferencia=isset($_POST["diferencia"])? limpiarCadena($_POST["diferencia"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";

switch ($_GET["op"]) {
	case 'guardar':
			$rspta=$persona->insertar($_POST["fecha"],$_POST["idcuenta"],$_POST["debe"],$_POST["haber"]);
			echo $rspta? "Datos registrados correctamente" : "No se pudo registrar los datos";
				
		break;
	case 'modificar':
		$rspta=$persona->modificar($_POST['idOpcion'],$_POST['idCuenta']);
		echo $rspta ? "Cuenta modificada correctamente" : "No se pudo modificar la Cuenta";
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
					$ind=0;
					$aux=-1;
					$totDebe=0;
					$totHaber=0;
					$indAux=0;
			while ($reg=$rspta->fetch_object()) {	
					$debe='';
					$haber='';
					if($reg->tipo == 1){
						$debe=$reg->monto;
					}else{
						$haber=$reg->monto;
					}
					if($reg->id_asiento != $aux){
						$ind++;
						
						if($aux < 0){
							$totDebe=$reg->total_debe;
							$totHaber=$reg->total_haber;
						}else{
							$indAux=$ind-1;
							$data[]=array(
									"0"=>$indAux,
									"1"=>'Asiento '.$indAux,
			            "2"=>'',
			            "3"=>'',
			            "4"=>'',
			            "5"=>'<strong class="btn-dark">'.$totDebe.'</strong>',
			            "6"=>'<strong class="btn-dark">'.$totHaber.'</strong>',
			            "7"=>'');
							$totDebe=$reg->total_debe;
							$totHaber=$reg->total_haber;
						}
						$aux=$reg->id_asiento;
					}
					
					/*$data['data'][$cont]= array(
													'ind' => $ind,
													'fecha' => $reg->fecha,
		      								'codigo' => $reg->codigo,
												  'cuenta' => $reg->cuenta,
												  'debe' => $debe,
												  'haber' => $haber,
												  'boton' => '<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="asignar('.$reg->id.')"><i class="fa fa-exchange"></i></button></a>');*/
												  
						$data[]=array(
									"0"=>$ind,
									"1"=>'Asiento '.$ind,
			            "2"=>$reg->fecha,
			            "3"=>$reg->codigo,
			            "4"=>$reg->cuenta,
			            "5"=>$debe,
			            "6"=>$haber,
			            "7"=>'<a data-toggle="modal" href="#myModal"><button class="btn btn-info btn-xs" onclick="asignar('.$reg->id.')"><i class="fa fa-exchange"></i></button></a>');
						$cont++;
					}
					$ult=$indAux+1;
					$data[]=array(
									"0"=>$ult,
									"1"=>'Asiento '.$ult,
			            "2"=>'',
			            "3"=>'',
			            "4"=>'',
			            "5"=>'<strong class="btn-info">'.$totDebe.'</strong>',
			            "6"=>'<strong class="btn-info">'.$totHaber.'</strong>',
			            "7"=>'');
					$results=array(
			             "sEcho"=>1,//info para datatables
			             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
			             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
			             "aaData"=>$data); 
					echo json_encode($results);
					//echo json_encode($data, JSON_UNESCAPED_UNICODE);
					break;
					case 'listarCaja':
					$fecha=$_GET['fecha'];
					$rspta=$persona->listarCaja($fecha);
					$data=Array();
					$cont=0;
					$total=0;
					while ($reg=$rspta->fetch_object()) {	
						$cont++;
						$nombre=$reg->nombre.' '.$reg->apellido;
						$data[]=array(
			            "0"=>$cont,
			            "1"=>$reg->fecha,
			            "2"=>$reg->numfactura,
			            "3"=>$reg->num_documento,
			            "4"=>$reg->numusuario,
			            "5"=>$nombre,
			            "6"=>$reg->monto);
						$total=$total+$reg->monto;
					}
					$cont++;
					$data[]=array(
			            "0"=>$cont,
			            "1"=>'<strong>TOTAL</strong>',
			            "2"=>'',
			            "3"=>'',
			            "4"=>'',
			            "5"=>'',
			            "6"=>'<strong>'.$total.'</strong>');
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
	case 'ultimoCosto':
				$idCliente=$_POST["idCliente"];
				$rspta=$persona->ultimoCosto($idCliente);
				$total=0;
				$idFact = '';
				if(isset($rspta['id'])){
						$idCost = $rspta['id'];
						$bodyTablaPermiso=0;
						$rspta=$persona->listarCosto($idCost);						
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
	case 'ultimafacturaDif':
				$idCliente=$_POST["idCliente"];
				$idFact=$_POST["factura"];
				$rspta=$persona->verificarSaldo($idFact);
				$total=0;
				if(isset($rspta['diferencia'])){
						$diferencia = $rspta['diferencia'];
						$rspta=$persona->listarDetallesDifErssan($idFact);
						$bodyTablaPermiso='';
						while ($reg=$rspta->fetch_object()) {
							$idDetalle = $reg->id;
							$descripcion = $reg->descripcion;
							$exentas = round($reg->exentas);
							if(round($diferencia) > 0){
								$exentas = round($reg->exentas)-round($diferencia);//round($exentas)
							}

							if($exentas > 0){
								$total=$total+($exentas*1);

										//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
								$bodyTablaPermiso=('<tr><td class="text-center ">'.$descripcion.'</td><td class="text-center ">'.number_format($exentas,0,",",".").'</td></tr>').$bodyTablaPermiso;
								$diferencia=round($diferencia)-round($reg->exentas);
							}else{
								$diferencia=round($diferencia)-(round($reg->exentas)*1);
							}
						}
						$rspta=$persona->listarDetallesDif($idFact);						
						$stmt1 = '';
						
						$cont=0;
						while ($reg=$rspta->fetch_object()) {
									$cont++;
									$idDetalle = $reg->id;
									$descripcion = $reg->descripcion;
									$exentas = round($reg->exentas);
									if(round($diferencia) > 0){
										$exentas = round($reg->exentas)-round($diferencia);//round($exentas)
									}
									if($exentas >0){
										$total=$total+($exentas*1);
										//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
										$bodyTablaPermiso=('<tr><td class="text-center ">'.$descripcion.'</td><td class="text-center ">'.number_format($exentas,0,",",".").'</td></tr>').$bodyTablaPermiso;
										$diferencia=round($diferencia)-round($reg->exentas);
									}else{
										$diferencia=round($diferencia)-round($reg->exentas);
									}
							
						}
						$bodyTablaPermiso=$bodyTablaPermiso.('<tr><td class="text-center "><strong>TOTAL</strong></td><td class="text-center "><strong>'.number_format($total,0,",",".").'</strong></td></tr>');
					echo(json_encode(array($bodyTablaPermiso,$total,$idFact)));
				}else{
					echo(0);
				}

				
			
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