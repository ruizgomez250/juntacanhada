<?php
session_start();
$_SESSION['desoxirribonucleico']="true";
include('conexion.php');

if($_POST['ingreso'] == 'Ingresar')
{
    $username=$_POST['inputUsuario'];
    $password=$_POST['inputPassword']; 
    
    $sql = "SELECT id,estado,rol,fecha FROM usuario WHERE username = '".$username."' and password = '".$password."' ;";
    //consulta/*
    $conexion = getConexion();
    $stmt = sqlsrv_query($conexion, $sql );
    if( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) ) {
        $id =$row[0];
        $codigo_aleatorio = password_hash($username.$password, PASSWORD_DEFAULT);
        $sql1 = "SELECT coalesce(sum(id),0) FROM usuario WHERE sesion like '".$codigo_aleatorio."';";
        $stmt1 = sqlsrv_query($conexion, $sql1 );
        $existe=true;
        while( $existe ) {
            if( $row1 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_NUMERIC) ) {
                if($row1[0] < 1){
                    $existe=false;
                }else{
                    $codigo_aleatorio = password_hash($username.$password, PASSWORD_DEFAULT);
                    $sql = "SELECT id,estado,nivel FROM usuario WHERE sesion like '".$codigo_aleatorio."';";
                    $stmt = sqlsrv_query($conexion, $sql );
                }
            }
        }
        $sql = "UPDATE usuario SET sesion = '".$codigo_aleatorio."' WHERE id = ".$id;
        $stmt = sqlsrv_query($conexion, $sql );
        if($row[1] == 1){
            if($row[2] == 1){
                header('Location: RecepcionPermisos.php?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='.$codigo_aleatorio.'&dsafkjlhteruqiyopxb=RecepcionPermisos.php');
            }else if($row[2] >1 and  $row[2] < 4 || $row[2] == 7){
                header('Location: ControlPermisos.php?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='.$codigo_aleatorio.'&dsafkjlhteruqiyopxb=ControlPermisos.php');
                
            } else if ($row[2]  > 3 and $row[2]  != 7){
                
                header('Location: ControlPermisos1.php?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='.$codigo_aleatorio.'&dsafkjlhteruqiyopxb=ControlPermisos1.php');
            } else{
              header('Location: index.php?codigo=error');   
            }  
            
        }
            
     
    }else{
        header('Location: index.php?codigo=error'); 
    }

}
?>



