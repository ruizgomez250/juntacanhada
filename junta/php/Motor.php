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
			$idCategoria='';
			$descCategoria=$_POST["descCategoria"];
			$fecha=$_POST["costoConsumoMinimo"];
			
			
			
			$sql = "INSERT INTO motor (descripcion,fecha) VALUES ('$descCategoria','$fecha');";
			
			$stmt = pg_query($conexion, $sql );

			$sql = 'SELECT MAX(id) FROM motor';
			$resultado = pg_query($conexion,$sql);
			$res = pg_fetch_row($resultado);
			$id = $res[0];
			header("location: ../vistas/motor.php?moadfnmgvlfjhdif=".$id);
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
			$fecha=$_POST["costoConsumoMinimo"];

			
			$sql = "UPDATE motor SET descripcion='$descCategoria',fecha='$fecha' WHERE id=$idCategoria;";
			
			$stmt = pg_query($conexion, $sql );
			header("location: ../vistas/motor.php?moadfnmgvlfjhdif=".$idCategoria);
		break;
	}
?>