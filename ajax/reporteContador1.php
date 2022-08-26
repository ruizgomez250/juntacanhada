<?php 
require_once "../modelos/ReporteContador1.php";
if (strlen(session_id())<1) 
	session_start();

$ingreso=new ReporteContador1();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";



switch ($_GET["op"]) {
	case 'guardar':
	$descripcion=$_POST['descCuenta'];
	$codigo=$_POST['codCuenta'];
	$cont=1;
	$buscar=$codigo.'.0'.$cont;
	$rspta=$ingreso->verificar($buscar);
	$reg=$rspta->fetch_object();
	$encontrado=$reg->cont;
	while ( $encontrado != 0){
		$cont++;
		if($cont < 10)
			$buscar=$codigo.'.0'.$cont;
		else
			$buscar=$codigo.'.'.$cont;
		$rspta=$ingreso->verificar($buscar);
		$reg=$rspta->fetch_object();
		$encontrado=$reg->cont;
	}
	$rspta=$ingreso->guardar($descripcion,$buscar);
	echo $rspta ? "El codigo de la Cuenta es:".$buscar : "No se pudo anular la Cuenta";
		//$rspta=$ingreso->insertar($_POST["idarticulo"]);
		//echo $rspta ;
		break;
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
			
	case 'anular':
		$rspta=$ingreso->anular($idingreso);
		echo $rspta ? "Cuenta anulada correctamente" : "No se pudo anular la Cuenta";
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
            "0"=>'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->id.')"><i class="fa fa-close"></i></button>',
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
		case 'listarTodo':
		$data=Array();
		$timbrado='';
		$fac=-1;
		
		$rspta=$ingreso->listarTodo1();
		$timbrado='';
		$data=Array();
		$fac=-1;
		while ($reg=$rspta->fetch_object()) {
			if($fac != $reg->facnro){
				if($reg->facnro < 194001){
						$timbrado='14247326';
					}else{
						$timbrado='1449610';
					}
				$anulado='';
					
				$anulado='Anulado';
				$data[]=array(
							"0"=>$reg->nrousu,	            
	            "1"=>$reg->nombre.' '.$reg->apellido,
	            "2"=>$reg->cedularuc,
	            "3"=>$reg->facnro,
	            "4"=>$reg->fecfac,
	            "5"=>$reg->descri,
	            "6"=>$reg->unidad,
	            "7"=>$reg->iva,
	            "8"=>$reg->faciva,
	            "9"=>$reg->total
	              );
					$fac=$reg->facnro;
				}
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
		case 'listarTodo1':
		$rspta=$ingreso->listarTodo2();
		$data=Array();
		$timbrado='';
		$fac=-1;
		while ($reg=$rspta->fetch_object()) {
			
				
				/*if($reg->comparar == $reg->facnro)
				$anulado='Anulado';*/
				
				$data[]=array(
	            "0"=>$reg->nrousu,
	            "1"=>$reg->nombre.' '.$reg->apellido,
	            "2"=>$reg->cedularuc,
	            "3"=>$reg->facnro,
	            "4"=>$reg->fecfac,
	            "5"=>$reg->descri,
	            "6"=>$reg->unidad,
	            "7"=>$reg->iva,
	            "8"=>$reg->total
	              );
				
		}/*
		$rspta=$ingreso->listarTodo1();
		$timbrado='';
		$data=Array();
		$fac=-1;
		while ($reg=$rspta->fetch_object()) {
			if($fac != $reg->facnro){
				if($reg->facnro < 194001){
						$timbrado='14247326';
					}else{
						$timbrado='1449610';
					}
				$anulado='';
				if($reg->comparar == $reg->facnro)
					
				$anulado='Anulado';
				$data[]=array(
	            "0"=>$reg->cedularuc,
	            "1"=>$reg->nombre.' '.$reg->apellido,
	            "2"=>'109',
	            "3"=>$reg->fecfac,
	            "4"=>$timbrado,
	            "5"=>'001-001-0'.$reg->facnro,
	            "6"=>$reg->imptot,
	            "7"=>$anulado
	              );
					$fac=$reg->facnro;
				}
		}*/
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
				case 'listarCuentasSelec':

				$rspta=$ingreso->listarAsentables();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-success" onclick="guardar('.$reg->id.')"><span class="fa fa-check"></span></button>',
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