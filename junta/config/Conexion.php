<?php 

function conexion_db (){
	$conexion = pg_connect( "user=postgres  password=jorge366286 port=3535 dbname=juntaSaneamiento options='--client_encoding=UTF8'"
                               ) or die( "Error al conectar: ".pg_last_error() );
	return $conexion;//pg_set_client_encoding($conexion,"UNICODE");
}
?>