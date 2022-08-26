<?php 
	include('../config/Conexion.php');
	
	$op='';
	$sql='';
	if(isset($_POST['op'])){
		$op=$_POST['op'];
	}else{
		$op=$_GET['op'];
	}
	switch ($op) {
		case 'buscarOpcion':
				$codigo=$_POST["codigo"];
				$conexion = conexion_db();
				$sql = "SELECT id,descripcion from Categoria WHERE id = ".$codigo.";";
				$stmt = pg_exec($conexion, $sql );
				$id='';
				while( $row = pg_fetch_array( $stmt) ) { 
				    $id=$row['id'];
				    $descripcion=$row['descripcion'];
					$res=json_encode(array($id,$descripcion));

					echo($res);


				}

				if($id == ''){
					echo(false);
				}

		break;
		case 'BuscarTomaMedidaTabla':
				$medidor=$_POST['medidor'];
				$sql = "SELECT tomaMed.id,tomaMed.id_medidor,tomaMed.fecha,tomaMed.lectura FROM toma_de_medida tomaMed INNER JOIN medidor med on med.id=tomaMed.id_medidor WHERE med.codigo_medidor='$medidor' ORDER BY tomaMed.fecha desc;";
				$tabla=array();
				$cont = 0;
				array_push($tabla,$cont);
				$conexion = conexion_db();
				$stmt = pg_exec($conexion, $sql );
				
				while( $row = pg_fetch_array( $stmt) ) {

					$cont++;
				    $fecha=$row['fecha'];//->format('Y-m-d');
				    $lectura = $row['lectura'];
				    

				    $bodyTablaFunc =('<tr><td class="text-center">'.$fecha.'</td><td class="text-left">'.$lectura.'</td></tr>');
				    array_push($tabla,$bodyTablaFunc);
					
				}
				if($cont == 0){
					$bodyTablaFunc = '<tr><td class="text-center"></td><td class="text-center"></td></tr>';
					$cont++;
					array_push($tabla,$bodyTablaFunc);
				}
				$tabla[0]=$cont;
				echo(json_encode($tabla));
	break;
	case 'verificarLectura':
				$lectura=$_POST['lectura'];
				$medidor=$_POST['medidor'];
				$conexion = conexion_db();
				$sql="SELECT  id  FROM medidor WHERE codigo_medidor='$medidor';";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$medidor = $res[0];
				$sql="SELECT  max(id)  FROM toma_de_medida WHERE id_medidor=$medidor;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$id = $res[0];

 
				$sql = "SELECT lectura FROM toma_de_medida WHERE id=$id;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$lectura1 = $res[0];
				if($lectura > $lectura1){
					echo(1);
				}else{
					echo(0);
				}
	break;
	case 'facturasPorFechaCliente':
				  
				  $idCliente=$_POST["idCliente"];
				  $sql = "SELECT id,fecha_emision,vencimiento FROM factura_encabezado WHERE id_cliente=".$idCliente.";";
				  $conexion = conexion_db();
  				  $stmt = pg_exec($conexion, $sql );
				  $bodyTablaPermiso=null;
					while( $row = pg_fetch_array( $stmt) ) {
				          $fechaActual=$row[1];
				          $id=$row[0];
				          $vencimiento=$row[2];
				          $verif='';
				          $documento='';
				          $bodyTablaPermiso=('<tr><td class="text-center ">'.$fechaActual.'</td>
				                            <td class="text-center ">'.$vencimiento.'</td>
				                          <td class="text-left">
				                            
				                              <button  name='.$id.' class="selecc btn-dark btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/pdf.png" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>
				                              
				                              '.$verif.$documento.'
				                          </td>
				                          </tr>').$bodyTablaPermiso;

				        
				        

			}
			echo(json_encode($bodyTablaPermiso));
			
	break;
	case 'facturasPagPorFechaCliente':
				  
				  $idCliente=$_POST["idCliente"];
				  $sql = "SELECT enc.id,enc.fecha_emision,enc.vencimiento FROM factura_encabezado enc INNER JOIN pago_factura pago on pago.id_cabecera=enc.id WHERE enc.id_cliente=".$idCliente.";";
				  $conexion = conexion_db();
  				  $stmt = pg_exec($conexion, $sql );
				  $bodyTablaPermiso=null;
					while( $row = pg_fetch_array( $stmt) ) {
				          $fechaActual=$row[1];
				          $id=$row[0];
				          $vencimiento=$row[2];
				          $verif='';
				          $documento='';
				          $bodyTablaPermiso=('<tr><td class="text-center ">'.$fechaActual.'</td>
				                            <td class="text-center ">'.$vencimiento.'</td>
				                          <td class="text-left">
				                            
				                              <button  name='.$id.' class="selecc btn-dark btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/pdf.png" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>
				                              
				                              '.$verif.$documento.'
				                          </td>
				                          </tr>').$bodyTablaPermiso;

				        
				        

			}
			echo(json_encode($bodyTablaPermiso));
			
	break;
	case 'ultimafacturaCliente':
				//$idCliente=$_POST["idCliente"];
				echo('llego');
				/*$sql="SELECT  max(id)  FROM factura_encabezado WHERE estado = 1 and id_cliente=".$idCliente.";";
				/*$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$idFact = $res[0];


				  
				  $sql = "SELECT id,fecha_emision,vencimiento FROM factura_encabezado WHERE id=".$idFact.";";
				  $conexion = conexion_db();
  				  $stmt = pg_exec($conexion, $sql );
				  $bodyTablaPermiso=null;
					while( $row = pg_fetch_array( $stmt) ) {
				          $fechaActual=$row[1];
				          $id=$row[0];
				          $vencimiento=$row[2];
				          $verif='';
				          $documento='';
				          $bodyTablaPermiso=('<tr><td class="text-center ">'.$fechaActual.'</td>
				                            <td class="text-center ">'.$vencimiento.'</td>
				                          <td class="text-left">
				                            
				                              <button  name='.$id.' class="selecc btn-dark btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/pdf.png" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>
				                              
				                              '.$verif.$documento.'
				                          </td>
				                          </tr>').$bodyTablaPermiso;

				        
				        

			}
			echo(json_encode($bodyTablaPermiso));
*/
				
	break;
	case 'verificarFecha':
				$fechaLectura=$_POST['fecha'];
				$medidor=$_POST['medidor'];
				$conexion = conexion_db();
				$sql="SELECT  id  FROM medidor WHERE codigo_medidor='$medidor';";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$medidor = $res[0];
				$sql="SELECT  max(id)  FROM toma_de_medida WHERE id_medidor=$medidor;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$id = $res[0];

 
				$sql = "SELECT fecha FROM toma_de_medida WHERE id=$id;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$fechaLectura1 = $res[0];
				if($fechaLectura >= $fechaLectura1){
					echo(1);
				}else{
					echo(0);
				}
	break;

	case 'guardar':
				$lectura=$_POST["lectura"];
				$fecha=$_POST["fecha"];
				$medidor=$_POST["medidor"];

				$conexion = conexion_db();
				$sql="SELECT  id  FROM medidor WHERE codigo_medidor='$medidor';";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$medidor = $res[0];



				$sql="SELECT  coalesce(max(id),0)+1  FROM toma_de_medida;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$id = $res[0];
				$sql = "INSERT INTO  toma_de_medida (id,id_medidor,fecha,lectura) VALUES ($id,$medidor,'$fecha',$lectura);";
				$stmt = pg_query($conexion, $sql );
	break;
	case 'borrar':
				$id=$_POST["id"];
				$conexion = conexion_db();
				$sql="DELETE FROM Categoria WHERE id=".$id." ;";
				$stmt = pg_query($conexion, $sql );
	break;
	
}





	


	
	
	/*fsssssssssssssssssssssssssssssssssssssssss*/
	
	
	
	

?>