<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Generarpdf
{


    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //listar registros
    public function listar()
    {
        $sql = "SELECT c.id 
        ,CONCAT_ws(' ',p.nombre,p.apellido) nombre 
        ,p.num_documento 
        ,cu.descripcion categoria 
        ,h.medidor 
        ,COALESCE(va.id,0) idventaagua        
        FROM `cliente` c 
        LEFT JOIN persona p on p.idpersona = c.id_persona 
        LEFT JOIN categoria_usuario cu on cu.id = c.id_categoria 
        left join hidrometro h on h.idcliente = c.id 
        left join venta_agua va on va.idcliente = c.id
        where c.estado = 1 order by nombre asc
    ";
        return ejecutarConsulta($sql);
    }
}
