<?php
	include('../config/conexion.php');
	$conexion = conexion_db();
	if(isset($_POST['op'])){
		$op=$_POST['op'];
	}else{
		$op=$_GET['op'];
	}
	switch ($op) {
		case 'buscarUsuarioTabla':
		/**********************/
		$nombreyApellido='';
		$sql='';
		$nombre='';
		$apellido='';
		$cedula='';
		$tabla=array();
		$cont = 0;
		array_push($tabla,$cont);
		$where='';
		if(isset($_POST["cedula"])){
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
		$sql = "SELECT cli.id,cli.cedula,cli.nombre,cli.apellido,cli.telefono,cli.telefono1,cat.descripcion,sector.descripcion,medid.codigo_medidor FROM cliente cli inner join categoria cat on cat.id = cli.id_categoria inner join opcion sector on sector.id = cli.id_sector inner join medidor medid on medid.id = cli.id_medidor ".$where;
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

							  $verif='<button  name="'.$id1.'" class="ieditar1 btn-sm btn-success "><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar" /></button>';
							  if(isset($_GET['medida'])){
							  	$verif='<button  name="'.$medidor.'" class="ieditar btn-sm btn-primary "><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" width="20" height="20" border ="0" id= "editar" title="Tomar Medida" /></button>';
			  }
			  $documento='';
			  $bodyTablaPermiso=('<tr><td class="text-center ">'.$id1.'</td>
	     										<td class="text-center ">'.$cedula1.'</td>
	     										<td class="text-center ">'.$nombre1.' '.$apellido1.'</td>
												<td class="text-center ">'.$sector1.'</td>
												<td class="text-center ">'.$categoria1.'</td>
												<td class="text-left">
													
														'.$verif.$documento.'
												</td>
												</tr>');
							  array_push($tabla,$bodyTablaPermiso);

					}
					$tabla[0]=$cont;
					echo(json_encode($tabla));
		/*********************/
		break;
		case 'traeDatosUsuario':
				$tabla=array();
				$id=$_POST["id"];
				$sql = "SELECT cli.nombre,cli.apellido,cli.direccion,cli.telefono,cli.cedula,cli.estado,cli.telefono1,cli.id_categoria,cat.descripcion,cli.id_sector,sector.descripcion,cli.id_medidor
			      FROM cliente cli 
			      inner join categoria cat on cat.id = cli.id_categoria
			      inner join opcion sector on sector.id = cli.id_sector
			      WHERE cli.id = ".$id.";";
			      $stmt = pg_exec($conexion, $sql );
			      $exito=false;
				  while( $row = pg_fetch_array( $stmt) ) {
				  		  $exito=true;
						  $cedula=$row['cedula'];
						  $nombre=$row['nombre'];
						  $apellido=$row['apellido'];
						  array_push($tabla,$id);
						  $nombAp=$nombre.' '.$apellido;
						  array_push($tabla,$nombAp);
						  array_push($tabla,$cedula);
						  echo(json_encode($tabla));
				}
				if(!$exito){
					echo 0;
				}
				
		break;
	}
?>