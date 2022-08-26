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
				$sql = "SELECT id,estado,codigo_medidor from medidor WHERE id = ".$codigo.";";
				$stmt = pg_exec($conexion, $sql );
				$id='';
				while( $row = pg_fetch_array( $stmt) ) {

				    $id=$row['id'];
				    $estado=$row['estado'];
				    $codigoMedidor=$row['codigo_medidor'];
					$result=json_encode(array($id,$estado,$codigoMedidor));
					
				}
				echo ($result);
		break;
		case 'BuscarOpcionTabla':
				$sql = "SELECT id,estado,codigo_medidor FROM medidor where estado=0 order by id desc;";
				$tabla=array();
				$cont = 0;
				array_push($tabla,$cont);
				$conexion = conexion_db();
				$stmt = pg_exec($conexion, $sql );
				
				while( $row = pg_fetch_array( $stmt) ) {

					
				    $id=$row['id'];
				    $descripcion=$row['codigo_medidor'];
				    
				    $cont++;
				    $borrar='<button type="button" class="borrarMedidor btn btn-danger" name="'.$id.'" aria-label="Left Align"><img src="icon/dash-circle-fill.svg" width="17" height="17" title="Borrar" border ="0" id= "lista_oradores"/></button>';
				    $bodyTablaFunc =('<tr><td class="text-left">'.$descripcion.'</td><td><button type="button" class="elegirMedidor btn btn-success" name="'.$id.'" aria-label="Left Align"><img src="icon/check-circle-fill.svg" width="17" height="17" title="Elegir" border ="0" id= "lista_oradores"/></button>'.$borrar.'</td></tr>');
				    array_push($tabla,$bodyTablaFunc);
				    	$cont++;

			 }
			 $cont--;
				    
					
				
				if($tabla == ''){
					$tabla = '<tr><td class="text-center"></td><td class="text-center"></td><td></td><td></td></tr>';
				}
				$tabla[0]=$cont;
				echo(json_encode($tabla));
	break;

	case 'guardar':

				$descripcion=$_POST["descrip"];
				$estado=0;
				$conexion = conexion_db();
				$sql="SELECT  count(id)  FROM medidor where codigo_medidor like '".$descripcion."';";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				if($res[0] > 0){
					echo(0);
				}
				else{
						$sql="SELECT  coalesce(max(id),0)+1  FROM medidor;";
						$resultado = pg_query($conexion,$sql);
						$res = pg_fetch_row($resultado);
						$id = $res[0];
						$sql = "INSERT INTO  medidor (id,codigo_medidor,estado) VALUES (".$id.",'".$descripcion."',".$estado.");";
						$stmt = pg_query($conexion, $sql );
						echo(1);
				}
	break;
	case 'borrar':
				$id=$_POST["id"];
				$conexion = conexion_db();
				$sql="DELETE FROM medidor WHERE id=".$id." ;";
				$stmt = pg_query($conexion, $sql );
	break;
	
}





	


	
	
	/*fsssssssssssssssssssssssssssssssssssssssss*/
	
	
	
	

?>