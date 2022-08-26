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
			$cedula=$_POST["cedula1"];
			$nombre=$_POST["nombre1"];
			$apellido=$_POST["apellido1"];
			$telefono1=$_POST["telefono1"];
			$telefono2=$_POST["telefono2"];
			$direccion=$_POST["direccion"];
			$sector=$_POST["sector"];
			$categoria=$_POST["categoria"];
			$medidor=$_POST["medidorCod"];
			$sql = "SELECT id FROM medidor where codigo_medidor like '".$medidor."';";
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$id_medidor = $res[0];
			$sql = "UPDATE medidor SET estado=1 WHERE codigo_medidor like '".$medidor."';";
			$resultado = pg_query($conexion,$sql);

			$estado=1;
			$sql = 'SELECT coalesce(MAX(orden),0) FROM cliente';
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$orden = $res[0]+1;

			$sql = 'SELECT coalesce(MAX(id),0) FROM cliente';
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$id = $res[0];
			$id++;
			$sql = "INSERT INTO cliente (id,id_categoria,id_sector,nombre,apellido,direccion,telefono,cedula,estado,telefono1,id_medidor,orden) VALUES (".$id.",".$categoria.",".$sector.",'".$nombre."','".$apellido."','".$direccion."','".$telefono1."','".$cedula."',".$estado.",'".$telefono2."','".$id_medidor."',$orden);";
			$stmt = pg_query($conexion, $sql );
			header("location: ../vistas/addModifCliente.php?moadfnmgvlfjhdif=".$id);
		exit();

		break;
		case 'buscarClienteTabla':
				/***********************/
				$tabla=array();
				$cont = 0;
				array_push($tabla,$cont);
				$where='';
				if(isset($_POST["medidor"])){
					$medidor=$_POST["medidor"];
					$sql1 = "SELECT id FROM medidor where  codigo_medidor='".$medidor."';";
					$resultado1 = pg_query($conexion,$sql1);
					$res1 = pg_fetch_row($resultado1);
					$medidor1 = $res1[0];
					$where = " WHERE cli.id_medidor = '".$medidor1."';";
				}else if(isset($_POST["cedula"])){
					$cedula=$_POST["cedula"];
					$where = " WHERE cli.cedula like '".$cedula."';";
				}else if(isset($_POST["nombre"])){
					$nombre=$_POST["nombre"];
					$where = " WHERE cli.nombre like '%".$nombre."%'";
					if(isset($_POST["apellido"])){
						$apellido=$_POST["apellido"];
						$where =$where." and cli.apellido like '%".$apellido."%';";
					}else{
						$where =$where.";";
					}
				}else if(isset($_POST["apellido"])){
					$apellido=$_POST["apellido"];
					$where = " WHERE apellido like '%".$apellido."%';";
				}
				$sql = "SELECT cli.id,cli.cedula,cli.nombre,cli.apellido,cli.telefono,cli.telefono1,cat.descripcion,sector.descripcion,medid.codigo_medidor 
				      FROM cliente cli 
				      inner join categoria cat on cat.id = cli.id_categoria
				      inner join opcion sector on sector.id = cli.id_sector
				      inner join medidor medid on medid.id = cli.id_medidor ".$where;
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
			  $medidor=$row[8];
			  $verif='';
			  if(isset($_GET["ver"])){
			  	$verif='<button  name='.$id1.' class="ieditar btn-success btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>';
			  }else{
			  	$verif='<a href="addModifCliente.php?dsafkjlhteruqiyopxb=ControlPermisos.php&moadfnmgvlfjhdif='.$id1.'">
														<button  name="'.$id1.'" class="ieditar btn-sm btn-success "><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar" /></button></a>';
			}
			  if(isset($_GET['medida'])){
			  	$verif='<button  name="'.$medidor.'" class="ieditar btn-sm btn-primary "><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" width="20" height="20" border ="0" id= "editar" title="Tomar Medida" /></button>';
			  }
			  $documento='';
			  $bodyTablaPermiso=('<tr><td class="text-center ">'.$id1.'</td>
	     										<td class="text-center ">'.$cedula1.'</td>
	     										<td class="text-center ">'.$nombre1.' '.$apellido1.'</td>
												<td>'.$telefono3.'</td>
												<td>'.$telefono4.'</td>
												<td class="text-center ">'.$categoria1.'</td>
												<td class="text-center ">'.$medidor.'</td>
												<td class="text-center ">'.$sector1.'</td>
												
												<td class="text-left">
													
														'.$verif.$documento.'
												</td>
												</tr>');
							  array_push($tabla,$bodyTablaPermiso);

					}
					$tabla[0]=$cont;
					echo(json_encode($tabla));
				/***********************/
			
		break; 
		case 'modificar':
			$id=$_GET["id"];
			$cedula=$_POST["cedula1"];
			$nombre=$_POST["nombre1"];
			$apellido=$_POST["apellido1"];
			$telefono1=$_POST["telefono1"];
			$telefono2=$_POST["telefono2"];
			$direccion=$_POST["direccion"];
			$sector=$_POST["sector"];
			$categoria=$_POST["categoria"];
			$medidor=$_POST["medidorCod"];
			$estado=$_POST["estado"];


			$sql = "SELECT id_medidor FROM cliente where id = $id;";
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$idMedAnterior = $res[0];
			$sql = "UPDATE medidor SET estado=0 WHERE id = $idMedAnterior;";
			$resultado = pg_query($conexion,$sql);


			$sql = "SELECT id FROM medidor where codigo_medidor like '".$medidor."';";
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$id_medidor = $res[0];

			$sql = "UPDATE medidor SET estado=1 where codigo_medidor like '".$medidor."';";
			$resultado = pg_query($conexion,$sql);
			
			$sql = "UPDATE cliente SET id_categoria=".$categoria.",id_sector=".$sector.",nombre='".$nombre."',apellido='".$apellido."',direccion='".$direccion."',telefono='".$telefono1."',cedula='".$cedula."',estado=".$estado.",telefono1='".$telefono2."',id_medidor='".$id_medidor."' WHERE id=".$id.";";
			
			$stmt = pg_query($conexion, $sql );
			header("location: ../vistas/addModifCliente.php?moadfnmgvlfjhdif=".$id);
		break;
		case 'orden':
			$codigoUsuario=$_POST["codUsuario"];
			$codigoUsuario1=$_POST["codCosto"];


			$sql = "SELECT orden FROM cliente where id = $codigoUsuario;";
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$orden = $res[0]+1;

			$sql = "UPDATE cliente SET orden=$orden WHERE id = $codigoUsuario1;";
			$resultado = pg_query($conexion,$sql);

			header("location: ../vistas/asignarOrden.php");
		break;
	}
?>