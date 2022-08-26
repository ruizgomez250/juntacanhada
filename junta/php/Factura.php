<?php
	include('../config/conexion.php');
	$conexion = conexion_db();
	if(isset($_POST['op'])){
		$op=$_POST['op'];
	}else{
		$op=$_GET['op'];
	}
	switch ($op) {
		case 'guardar':
			$fechaEmision=$_POST["fechaEmision"];
			$fechaVencimiento=$_POST["fechaVencimiento"];
			$ultimoEncabezado=0;
			$cliAct=0;
			$sql = "SELECT cli.id,cli.id_medidor,cat.costo_consumo_minimo,cat.litros_minimo,cat.costo_por_litro_sobre_minimo FROM cliente cli INNER JOIN categoria cat on cat.id=cli.id_categoria WHERE estado =1;";
			$stmt = pg_exec($conexion, $sql );
			$bodyTablaPermiso=null;
			while( $row = pg_fetch_array( $stmt) ) {

				$idCliente=$row[0];
				$idMedidor=$row[1];
				$costoConsumoMinimo=$row[2];
				$litrosMinimo=$row[3];
				$costoSobreMinimo=$row[4];
				$sql1 = "SELECT count(id) FROM toma_de_medida where id_Medidor= $idMedidor";
				
				$resultado1 = pg_query($conexion,$sql1);
				$res1 = pg_fetch_row($resultado1);
				$cont= $res1[0];
				if($cont > 1){
					/********** Guardamos el encabezado de la factura*****/
					$sql2 = 'SELECT coalesce(MAX(id),0) FROM factura_encabezado;';
					$resultado2 = pg_query($conexion,$sql2);
					$res2 = pg_fetch_row($resultado2);
					$id2 = $res2[0];
					$id2++;
					$estado=1;
					$sql3 = "INSERT INTO factura_encabezado (id,fecha_emision,id_cliente,vencimiento,estado) VALUES ($id2,'$fechaEmision',$idCliente,'$fechaVencimiento',$estado);";
					
					$stmt3 = pg_query($conexion, $sql3);
					$ultimoEncabezado=$id2;
					$cliAct=$idCliente;
					/*********** Detalles de la Factura*************/
					/****************** Consumo ***********************/
					$descConsumo='Consumo Minimo';
					$existeToma=true;
					$id6='';
					//while($existeToma){

						$sql6="SELECT MAX(id) FROM toma_de_medida where id_medidor = $idMedidor;";
						
						$resultado6 = pg_query($conexion,$sql6);
						$res6 = pg_fetch_row($resultado6);
						//if(isset($res6[0])){
							$id6 = $res6[0];
							$sql8 = "UPDATE  toma_de_medida SET orden_emitido=1 where id_medidor = $idMedidor and fecha <= '$fechaEmision';";
							$stmt8 = pg_query($conexion, $sql8 );
							$existeToma=false;
						/*}else{
							$sql9="SELECT MAX(id) FROM toma_de_medida where id_medidor = $idMedidor and fecha < '$fechaEmision';";
							$resultado9 = pg_query($conexion,$sql9);
							$res9 = pg_fetch_row($resultado9);
							$id9 = $res9[0];
							$sql10="SELECT lectura FROM toma_de_medida where id = $id9;";
							$resultado10 = pg_query($conexion,$sql10);
							$res10 = pg_fetch_row($resultado10);
							$lect10 = $res10[0];
							$consumo10=$lect10+$litrosMinimo;

							$sql7="SELECT  coalesce(max(id),0)+1  FROM toma_de_medida;";
							$resultado7 = pg_query($conexion,$sql7);
							$res7 = pg_fetch_row($resultado7);
							$id7= $res7[0];

							$sql8 = "INSERT INTO  toma_de_medida (id,id_medidor,fecha,lectura) VALUES ($id7,$idMedidor,'$fechaEmision',$consumo10);";
							$stmt8 = pg_query($conexion, $sql8 );
						}*/
					//}
					$lectura1=0;
					$lectura2=0;
						//echo('med '.$idMedidor.' med');
						$lectura1=traeLectura($id6);
						$sql7="SELECT MAX(id) FROM toma_de_medida where id_medidor = $idMedidor AND id < $id6;";
						$resultado7 = pg_query($conexion,$sql7);
						$res7 = pg_fetch_row($resultado7);
						$id7 = $res7[0];
						$lectura2=traeLectura($id7);
					
					$cantConsumo=$lectura1-$lectura2;
					$costoTotal=0;

					
					

					$sql4 = 'SELECT coalesce(MAX(id),0) FROM factura_detalle;';
					$resultado4 = pg_query($conexion,$sql4);
					$res4 = pg_fetch_row($resultado4);
					$id4 = $res4[0];
					$id4++;
					$sql5 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id4,$id2,$litrosMinimo,'$descConsumo',$costoConsumoMinimo,$costoConsumoMinimo);";
					
					$stmt5 = pg_query($conexion, $sql5);


					if($cantConsumo > $litrosMinimo){
						$consumoSobreMinimo=$cantConsumo - $litrosMinimo;
						$costoTotal = $consumoSobreMinimo*$costoSobreMinimo;
						$descConsumo='Exceso Consumo';

						$sql4 = 'SELECT coalesce(MAX(id),0) FROM factura_detalle;';
						$resultado4 = pg_query($conexion,$sql4);
						$res4 = pg_fetch_row($resultado4);
						$id4 = $res4[0];
						$id4++;
						$sql5 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id4,$id2,$consumoSobreMinimo,'$descConsumo',$costoSobreMinimo,$costoTotal);";
						
						$stmt5 = pg_query($conexion, $sql5);
						$costoTotal=$costoTotal+$costoConsumoMinimo;
					}else{
						$costoTotal=$costoConsumoMinimo;
					}
					
/************ Costos Fijos por Facturas *********************/
					$sql8 = "SELECT descripcion,es_porcentaje,monto,porcentaje FROM costos_fijos_x_factura WHERE estado =1;";
						$stmt8 = pg_exec($conexion, $sql8 );
						while( $row8 = pg_fetch_array( $stmt8) ) {
							$descFijo=$row8[0];
							$esPorcentaje=$row8[1];
							$montoFijo=$row8[2];
							$porcentajeFijo=$row8[3];

							$montoAsig=0;
							if($esPorcentaje){
								$montoAsig=($porcentajeFijo*$costoTotal)/100;
							}else{
								$montoAsig=$montoFijo;
							}
							$sql4 = 'SELECT coalesce(MAX(id),0) FROM factura_detalle;';
							$resultado4 = pg_query($conexion,$sql4);
							$res4 = pg_fetch_row($resultado4);
							$id4 = $res4[0];
							$id4++;
							$cantidad=1;
							$consumoMinimo=0;
							$sql5 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id4,$id2,$cantidad,'$descFijo',$consumoMinimo,$montoAsig);";
							$stmt5 = pg_query($conexion, $sql5);
						}
						/*********Costos por Clientes********/
					$sql10 = "UPDATE costos_x_cliente SET estado=0 WHERE numero_de_pago >= cantidad_pagos;";
								$stmt10 = pg_query($conexion, $sql10);
					$sql8 = "SELECT cost.cantidad_pagos,cost.numero_de_pago,det.descripcion,det.monto_total,cost.id FROM costos_x_cliente cost INNER JOIN costo det on det.id=cost.id_costo WHERE cost.estado = 1 and cost.id_usuario=$idCliente;";
						$stmt8 = pg_exec($conexion, $sql8 );
						while( $row8 = pg_fetch_array( $stmt8) ) {
							$cantPagos=$row8[0];
							$numeroDePago=$row8[1];
							$numeroDePago=$numeroDePago+1;
							$descPago=$row8[2];
							$montoTotal=$row8[3];
							$costosXClienteId=$row8[4];
							$pagos=$numeroDePago.'/'.$cantPagos;
							$montoPagar=0;
							if($cantPagos >0)
								$montoPagar=$montoTotal/$cantPagos;
							$descPago=$descPago.' '.$pagos;
							if($numeroDePago <= $cantPagos){
								$sql4 = 'SELECT coalesce(MAX(id),0) FROM factura_detalle;';
								$resultado4 = pg_query($conexion,$sql4);
								$res4 = pg_fetch_row($resultado4);
								$id4 = $res4[0];
								$id4++;
								$consumoMinimo=0;
								$sql5 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id4,$id2,$numeroDePago,'$descPago',$consumoMinimo,$montoPagar);";
								$stmt5 = pg_query($conexion, $sql5);

								$sql10 = "UPDATE costos_x_cliente SET numero_de_pago=$numeroDePago WHERE id=$costosXClienteId;";
								$stmt10 = pg_query($conexion, $sql10);
								/*****porcentaje teporal******/
								/*if($descPago == 'Deuda anterior 1/1'){
									$id4++;
									$porcentAux=($montoPagar*2)/100;
									$sql5 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id4,$id2,$numeroDePago,'ERSSAN-LEY 1614/2000-TASA RETRIBUTARIA 2%',0,$porcentAux);";
									$stmt5 = pg_query($conexion, $sql5);									
								}
								/*****fin porcentaje teporal******/
							}
						}
						$estad=1;
						$sql9 = "SELECT MAX(id) FROM factura_encabezado WHERE id_cliente=$cliAct and id < $ultimoEncabezado and estado = $estad;";
						
						$resultado9 = pg_query($conexion,$sql9);
						$res9 = pg_fetch_row($resultado9);
						if(isset($res9[0])){
							$idFactAnterior = $res9[0];
							$sql9 = "SELECT sum(exentas) FROM factura_detalle WHERE id_encabezado=$idFactAnterior;";
							$resultado9 = pg_query($conexion,$sql9);
							$res9 = pg_fetch_row($resultado9);
							$sumaDeudaAnterior = $res9[0];
							$descripc='Deuda Anterior';
							$cantid=0;

							$sql9 = 'SELECT coalesce(MAX(id),0) FROM factura_detalle;';
							$resultado9 = pg_query($conexion,$sql9);
							$res9 = pg_fetch_row($resultado9);
							$id9 = $res9[0];
							$id9++;
							$sql9 = "INSERT INTO factura_detalle (id,id_encabezado,cantidad,descripcion,precio_unitario,exentas) VALUES ($id9,$ultimoEncabezado,$cantid,'$descripc',$cantid,$sumaDeudaAnterior);";
							$stmt9 = pg_query($conexion, $sql9);
							$estado2=2;
							//$sql10 = "UPDATE factura_encabezado SET estado=$estado2 WHERE id=$idFactAnterior;";
							//$stmt10 = pg_query($conexion, $sql10);
							
						}
												
				}

			}

			header("location: ../vistas/factura.php");
			exit();

		break;
		case 'buscarCategoriaTabla':
				/***********************/
				$tabla=array();
				$cont = 0;
				array_push($tabla,$cont);
				$where='';
				if(isset($_POST["codigo"])){
					$codigo=$_POST["codigo"];
					$where = " WHERE cli.id = ".$codigo.";";
				}else if(isset($_POST["cedula"])){
					$cedula=$_POST["cedula"];
					$where = " WHERE cedula like '".$cedula."';";
				}else if(isset($_POST["nombre"])){
					$nombre=$_POST["nombre"];
					$where = " WHERE nombre like '%".$nombre."%'";
					if(isset($_POST["apellido"])){
						$apellido=$_POST["apellido"];
						$where =$where." and apellido like '%".$apellido."%';";
					}else{
						$where =$where.";";
					}
				}else if(isset($_POST["apellido"])){
					$apellido=$_POST["apellido"];
					$where = " WHERE apellido like '%".$apellido."%';";
				}
				$sql = "SELECT cli.id,cli.cedula,cli.nombre,cli.apellido,cli.telefono,cli.telefono1,cat.descripcion,sector.descripcion 
				      FROM cliente cli 
				      inner join opcion cat on cat.id = cli.id_categoria
				      inner join opcion sector on sector.id = cli.id_sector ".$where;
				  $stmt = pg_exec($conexion, $sql );
				  $bodyTablaPermiso=null;
					while( $row = pg_fetch_array( $stmt) ) {
							$cont++;
							$id1=$row['id'];
							  $cedula1=$row['cedula'];
							  $nombre1=$row['nombre'];
							  $apellido1=$row['apellido'];
							  $telefono3=$row['telefono'];
							  $telefono4=$row['telefono1'];
							  $sector1=$row[6];
							  $categoria1=$row[7];
							  $verif='';
							  $documento='';
							  $bodyTablaPermiso=('<tr><td class="text-center ">'.$id1.'</td><td class="text-center ">'.$cedula1.'</td><td class="text-center ">'.$nombre1.' '.$apellido1.'</td><td>'.$telefono3.'</td><td>'.$telefono4.'</td><td class="text-center ">'.$categoria1.'</td><td class="text-center ">'.$sector1.'</td><td class="text-left"><ahref="addModifCliente.php?dsafkjlhteruqiyopxb=ControlPermisos.php&moadfnmgvlfjhdif='.$id1.'"><button  name="'.$id1.'" class="ieditar btn-sm btn-dark"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="32" height="30" border ="0" id= "editar" title="Seleccionar" /></button></a>'.$verif.$documento.'<button class="btn-sm btn-dark"><img class="ver imagen" style="cursor:pointer;"  src="icon/buscar.svg" width="32" height="30"  border ="0" id= "ver" title="Ver" name="'.$id1.'"></button></td></tr>');
							  array_push($tabla,$bodyTablaPermiso);

					}
					$tabla[0]=$cont;
					echo(json_encode($tabla));
				/***********************/
			
		break; 
		case 'modificar':
			$idCategoria=$_GET["id"];
			$descCategoria=$_POST["descCategoria"];
			$costoConsumoMinimo=$_POST["costoConsumoMinimo"];
			$litrosConsumoMinimo=$_POST["litrosConsumoMinimo"];
			$costoLitrosPorExceso=$_POST["costoLitrosPorExceso"];

			
			$sql = "UPDATE categoria SET id=$idCategoria,descripcion='$descCategoria',costo_consumo_minimo=$costoConsumoMinimo,litros_minimo=$litrosConsumoMinimo,costo_por_litro_sobre_minimo=$costoLitrosPorExceso WHERE id=$idCategoria;";
			
			$stmt = pg_query($conexion, $sql );
			header("location: ../vistas/addModifCategoria.php?moadfnmgvlfjhdif=".$idCategoria);
		break;
		case 'borrar':
			$fecha=$_POST["fecha"];
			$cliVer=-1;

			$sql8 = "SELECT id_cliente,id FROM factura_encabezado WHERE fecha_emision='$fecha' order by id_cliente;";
			$stmt8 = pg_exec($conexion, $sql8 );
			while( $row8 = pg_fetch_array( $stmt8) ) {
				$idCliente=$row8[0];
				$idEncabezado=$row8[1];
/***********Habilita la edicion de la toma de medida***********/
				if($cliVer!=$idCliente){
					$cliVer=$idCliente;
					$idMedi=0;
					$sql = "SELECT id_medidor from cliente WHERE id=$idCliente;";
					$stmt21 = pg_exec($conexion, $sql );
					while( $row21 = pg_fetch_array( $stmt21) ) {
						$idMedi=$row21[0];
					}
					$sql = "SELECT max(id) from toma_de_medida WHERE id_medidor=$idMedi;";
					$stmt21 = pg_exec($conexion, $sql );
					while( $row21 = pg_fetch_array( $stmt21) ) {
						$idMedi=$row21[0];
					}
					$sql = "UPDATE toma_de_medida SET
orden_emitido=0 WHERE id=$idMedi;";
					$stmt = pg_query($conexion, $sql );
					$sql = "UPDATE toma_de_medida SET
orden_emitido=0 WHERE id=$idMedi;";
					$stmt = pg_query($conexion, $sql );
				}
/***********************fin toma de medida********************/
				$sql1 = "SELECT descripcion FROM factura_detalle WHERE id_encabezado=$idEncabezado;";
				$stmt1 = pg_exec($conexion, $sql1 );
				$idModificado=-1;
				while( $row1 = pg_fetch_array( $stmt1) ) {
					$descDetalle=$row1[0];
					/*********** sustrae la cantidad de cuotas de la descripcion************/
					$borrarDesde=0;
					$long = strlen($descDetalle)-4;
					$descDetalle=substr( $descDetalle,0, $long );
					/*********** fin sustrae la cantidad de cuotas de la descripcion************/
					/******* Busca el id mayor con la descripcion*******/
					$sql21 = "SELECT max(cost.id) FROM costos_x_cliente cost INNER JOIN costo c ON c.id=cost.id_costo WHERE cost.id_usuario=$idCliente and c.descripcion='$descDetalle' and not cost.id=$idModificado;";
					$stmt21 = pg_exec($conexion, $sql21 );
					if(!$stmt21){

					}else{
						while( $row21 = pg_fetch_array( $stmt21) ) {
							$idModificado=$row21[0];
								if(strlen($idModificado) > 0){
								
								$sql = "SELECT cost.id,cost.numero_de_pago FROM costos_x_cliente cost WHERE cost.id=$idModificado;";
								$stmt = pg_exec($conexion, $sql );
								if(!$stmt){
								}else{
									while( $row = pg_fetch_array( $stmt) ) {
											$idCostoCliente=$row[0];
											$numeroPago=$row[1];
											if($numeroPago > 0){
												$numeroPago--;
											}
											
											$sql = "UPDATE costos_x_cliente SET numero_de_pago=$numeroPago where id_usuario=$idCliente;";
											$stmt = pg_query($conexion, $sql );

										
									}
								}
							}else{
								$idModificado=-1;
							}
						}
					}
					
					/*****fin busca id mayor***********/


				} 
					
				}

			
			$sql = "DELETE FROM factura_detalle  using factura_encabezado WHERE factura_detalle.id_encabezado=factura_encabezado.id and factura_encabezado.fecha_emision='$fecha';";
			
			$stmt = pg_query($conexion, $sql );

			$sql = "DELETE FROM factura_encabezado WHERE fecha_emision='$fecha';";
			
			$stmt = pg_query($conexion, $sql );
		break;
	}
	function traeLectura($id){
		$conexion = conexion_db();
		$sql = "SELECT lectura FROM toma_de_medida where id=$id;";
		$resultado = pg_query($conexion,$sql);
		$res = pg_fetch_row($resultado);
		$lectura = $res[0];
		return $lectura;

	}
?>