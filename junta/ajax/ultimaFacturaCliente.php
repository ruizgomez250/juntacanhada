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
	
	case 'cabeceraCliente':
				$conexion = conexion_db();
				$idCliente=$_POST["idCliente"];
				$sql="SELECT  max(id)  FROM factura_encabezado WHERE estado = 1 and id_cliente=$idCliente;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				if(strlen($res[0] == 0)){
					echo(0);
				}else{
					$idFact = $res[0];

					$tabla=array();
					
					$sql1 = "SELECT enc.id,enc.fecha_emision,enc.id_cliente,enc.vencimiento,enc.estado,cli.nombre,cli.apellido,cli.id FROM factura_encabezado enc INNER JOIN cliente cli on cli.id=enc.id_cliente WHERE enc.id=$idFact;";
					$stmt1 = pg_exec($conexion, $sql1 );
					$total=0;
					while( $row1 = pg_fetch_array( $stmt1) ) {
						$idCabec = $row1[0];
						$fechaEmision = $row1[1];
						$idCliente = $row1[5].' '.$row1[6];
						$vencimiento = $row1[3];
						$estado =$row1[4];
						$cliente=$row1[7];//round($exentas)
						array_push($tabla,$idCabec);
						array_push($tabla,$fechaEmision);
						array_push($tabla,$idCliente);
						array_push($tabla,$vencimiento);
						array_push($tabla,$estado);
						array_push($tabla,$cliente);
						//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
						
					}
				echo(json_encode($tabla));
			}
			
	break;
	case 'facturasPorFechaCliente':
				$conexion = conexion_db();
				$idCliente=$_POST["idCliente"];
				$total=0;
				$sql="SELECT  max(id)  FROM factura_encabezado WHERE estado = 1 and id_cliente=".$idCliente.";";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$idFact = $res[0];

				$bodyTablaPermiso=0;
				$sql1 = "SELECT id,cantidad,descripcion,precio_unitario,exentas FROM factura_detalle WHERE id_encabezado=$idFact ORDER BY id desc;";
				$stmt1 = '';
				$total=0;
				$cont=0;
				if(isset($res[0])){
					$bodyTablaPermiso=null;
					$stmt1 = pg_exec($conexion, $sql1 );
					while( $row1 = pg_fetch_array( $stmt1) ) {
					$cont++;
					$idDetalle = $row1[0];
					$cantidad = $row1[1];
					$descripcion = $row1[2];
					$precioUnitario = round($row1[3]);
					$exentas = round($row1[4]);//round($exentas)
					$total=$total+$row1[4];
					//echo($idDetalle.$cantidad.$descripcion.$precioUnitario.$exentas);
					$bodyTablaPermiso=('<tr><td class="text-center ">'.$cantidad.'</td>
				                            <td class="text-center ">'.$descripcion.'</td>
				                            <td class="text-center ">'.number_format($precioUnitario,0,",",".").'</td>
				                            <td class="text-center ">'.number_format($exentas,0,",",".").'</td>
				                          </tr>').$bodyTablaPermiso;
					
				}
				$bodyTablaPermiso=$bodyTablaPermiso.('<tr><td class="text-center "><strong>TOTAL</strong></td>
				                            <td class="text-center "></td>
				                            <td class="text-center "></td>
				                            <td class="text-center "><strong>'.number_format($total,0,",",".").'</strong></td>
				                          </tr>');
				}

				
				
			
			echo(json_encode(array($bodyTablaPermiso,$total)));
			
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
				$tabla=array();
				$numeroFactura=$_POST["numeroFactura"];
				$numOrden=$_POST["numOrden"];
				$cliente=$_POST["idCliente"];
				$diferencia=$_POST["diferencia"];
				$conexion = conexion_db();
				$sql="SELECT  count(id)  FROM pago_factura WHERE id_cabecera=$numOrden;";
				$resultado = pg_query($conexion,$sql);
				
				$res = pg_fetch_row($resultado);				
				$cont = $res[0];
					
					if($cont == 0){
						if($diferencia != 0){
	/************************** Agregar nuevo costo********************/
							$sql="SELECT  coalesce(max(id),0)+1  FROM costo;";
							$resultado = pg_query($conexion,$sql);
							$res = pg_fetch_row($resultado);
							$idCosto = $res[0];
							
							$des='Saldo Pago Anterior Cod.#s';
							$sql = "INSERT INTO  costo (id,descripcion,monto_total) VALUES ($idCosto,'$des',$diferencia);";
							$stmt = pg_query($conexion, $sql);
	/*********************** Fin agregar Costo******************************/
	/************************** Asignar costo a cliente********************/
							$fecha=date("Y-m-d"); 
							$sql="SELECT  coalesce(max(id),0)+1  FROM costos_x_cliente;";
							$resultado = pg_query($conexion,$sql);
							$res = pg_fetch_row($resultado);
							$id = $res[0];
							$cantPago=1;
							$numPago=0;
							$sql = "INSERT INTO  costos_x_cliente (id,cantidad_pagos,estado,numero_de_pago,id_usuario,id_costo,fecha) VALUES ($id,$cantPago,$cantPago,$numPago,$cliente,$idCosto,'$fecha');";
							$stmt = pg_query($conexion, $sql);
	/*********************** Fin asignar Costo******************************/
						}
						$sql="SELECT  coalesce(max(id),0)+1  FROM pago_factura;";
						$resultado = pg_query($conexion,$sql);
						$res = pg_fetch_row($resultado);
						$id = $res[0];

						$sql = "INSERT INTO  pago_factura (id,id_cabecera,num_factura) VALUES ($id,$numOrden,$numeroFactura);";
						$stmt = pg_query($conexion, $sql);
						$estad=2;
						$sql = "UPDATE factura_encabezado SET estado=$estad WHERE id_cliente=$cliente;";
						$stmt = pg_query($conexion, $sql );
						array_push($tabla,$numeroFactura);
						array_push($tabla,$numOrden);

						
						echo(json_encode($tabla));
					}else{
						echo(0);
					}
				

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