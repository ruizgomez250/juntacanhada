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
				$sql = "SELECT id,descripcion from opcion WHERE id = ".$codigo.";";
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
		case 'BuscarOpcionTabla':
				$codigo=$_POST["codigo"];
				$sql = "SELECT id,descripcion FROM opcion WHERE id_dominio =   ".$codigo.";";
				$tabla=array();
				$cont = 0;
				array_push($tabla,$cont);
				$conexion = conexion_db();
				$stmt = pg_exec($conexion, $sql );
				
				while( $row = pg_fetch_array( $stmt) ) {

					$cont++;
				    $id=$row['id'];
				    $descripcion=$row['descripcion'];

				    $sql1 = "SELECT count(id) FROM cliente WHERE id_categoria = ".$id." or id_sector = ".$id.";";
				    $stmt1 = pg_exec($conexion, $sql1 );
				    $borrar="";
				    while( $row1 = pg_fetch_array( $stmt1) ) {
				   
				    	if($row1['count'] <1){
				    		$borrar='<button type="button" class="borrar'.$codigo.' btn btn-danger" name="'.$id.'" aria-label="Left Align"><img src="icon/dash-circle-fill.svg" width="17" height="17" title="Borrar" border ="0" id= "lista_oradores"/></button>';
				    	}

				    }

				    $bodyTablaFunc =('<tr><td class="text-center">'.$id.'</td><td class="text-left">'.$descripcion.'</td><td><button type="button" class="elegir'.$codigo.' btn btn-success" name="'.$id.'" aria-label="Left Align"><img src="icon/check-circle-fill.svg" width="17" height="17" title="Elegir" border ="0" id= "lista_oradores"/></button>'.$borrar.'</td></tr>');
				    array_push($tabla,$bodyTablaFunc);
					
				}
				if($tabla == ''){
					$tabla = '<tr><td class="text-center"></td><td class="text-center"></td><td></td><td></td></tr>';
				}
				$tabla[0]=$cont;
				echo(json_encode($tabla));
	break;

	case 'guardar':
				$descripcion=$_POST["descrip"];
				$dominio=$_POST["dominio"];
				$conexion = conexion_db();
				$sql="SELECT  coalesce(max(id),0)+1  FROM opcion;";
				$resultado = pg_query($conexion,$sql);
				$res = pg_fetch_row($resultado);
				$id = $res[0];
				$sql = "INSERT INTO  opcion (id,descripcion,id_dominio) VALUES (".$id.",'".$descripcion."',".$dominio.");";
				$stmt = pg_query($conexion, $sql );
	break;
	case 'borrar':
				$id=$_POST["id"];
				$conexion = conexion_db();
				$sql="DELETE FROM opcion WHERE id=".$id." ;";
				$stmt = pg_query($conexion, $sql );
	break;
	
}





	


	
	
	/*fsssssssssssssssssssssssssssssssssssssssss*/
	
	
	
	

?>