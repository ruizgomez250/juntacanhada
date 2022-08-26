<?php 
session_start();
require_once "../config/Conexion.php";
$op='';
if(isset($_POST['op'])){
	$op=$_POST['op'];
}else{
	$op=$_GET['op'];
}
switch ($op) {
	
	case 'verificar':
			//validar si el usuario tiene acceso al sistema
			$logina=$_POST['logina'];
			$clavea=$_POST['clavea'];

			//Hash SHA256 en la contraseña
			$clavehash=hash("SHA256", $clavea);
			$con = conexion_db();
			$query="select id,nombre,apellido,cedula,telefono,direccion,usuario,contrasenha,estado,email from usuario where estado = 1 and usuario='".$logina."' and contrasenha='".$clavehash."';";

		    $resultado = pg_query($con,$query);
		    $sesIniciada=0;
			
			while($res=pg_fetch_row($resultado)){
				$id = $res[0];
				$nombre = $res[1];
				$apellido = $res[2];
				$cedula = $res[3];
				$telefono = $res[4];
				$direccion = $res[5];
				$usuario = $res[6];
				$contrasenha = $res[7];
				$estado = $res[8];
				$email = $res[9];

				# Declaramos la variables de sesion
				$_SESSION['id']=$id;
				$_SESSION['nombre']=$nombre;
				$_SESSION['apellido']=$apellido;
				$_SESSION['cedula']=$cedula;
				$_SESSION['telefono']=$telefono;
				$_SESSION['direccion']=$direccion;
				$_SESSION['isuario']=$usuario;
				$_SESSION['contrasenha']=$contrasenha;
				$_SESSION['estado']=$estado;
				$_SESSION['email']=$email;
				$sesIniciada=1;
			}
			$_SESSION['sesIniciada']=$sesIniciada;
			echo($sesIniciada);
	break;
	case 'salir':
				   //limpiamos la variables de la sesion
				session_start();
				$value=0;
				$_SESSION["newsession"]=$value;
				session_unset();

				  //destruimos la sesion
				session_destroy();
					  //redireccionamos al login
				header("Location: ../index.php");
	break;

	


	
}
?>

