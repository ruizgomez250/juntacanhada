<?php
//incluir la conexion de base de datos

require "../config/Conexion.php";
class Generar
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
        ,p.direccion
        ,cu.descripcion categoria 
        ,cu.id idcate
        ,c.estado
        FROM `cliente` c 
        LEFT JOIN persona p on p.idpersona = c.id_persona 
        LEFT JOIN categoria_usuario cu on cu.id = c.id_categoria         
        order by nombre asc;
    ";
        return ejecutarConsulta($sql);
    }


    /*SELECT max(l.`id`) maximo,l.id , l.`id_hidrometro`,c.estado ,h.idcliente , l.`fecha_lectura` , l.`lectura` , l.`lectura_ant` , l.`orden_emitido` , l.`id_usuario` , l.`mesciclo` , l.`anhociclo` FROM `lectura` l inner join hidrometro h on h.id = l.id_hidrometro inner join cliente c on c.id = h.idcliente WHERE h.idcliente = 35017 and c.estado = 1 and l.orden_emitido=0; */



    public function getLectura($id,$mes,$anho)
    {
        $sql = "SELECT 
        COALESCE(l.id,0) id 
        ,c.id idcliente
        , l.`id_hidrometro`
        , h.medidor
        , l.`fecha_lectura`
        , l.`lectura`
        , l.`lectura_ant`      
        , l.`orden_emitido`
        , c.id_zona
        , z.descripcion zona
        ,c.id_categoria
        ,cu.descripcion categoria
        ,cu.costo_consumo_minimo 
        ,cu.litros_minimo
        ,cu.costo_sobre_minimo 
        ,cu.litros_sobre_minimo
        , l.`id_usuario`
        , l.`mesciclo`
        , l.`anhociclo` 
        ,c.id_persona
        ,concat_ws(' ',p.nombre,p.apellido) nombre
        FROM `lectura` l
        inner JOIN hidrometro h on h.id = l.id_hidrometro
        inner JOIN cliente c on c.id = h.idcliente
        inner JOIN persona p on p.idpersona = c.id_persona
        inner JOIN zona z on z.id = c.id_zona
        inner JOIN categoria_usuario cu on cu.id = c.id_categoria
        inner JOIN situacion s on s.id = c.id_situacion
        where l.id = '$id' 
        and c.estado = 1 
        and l.orden_emitido=0
        and l.mesciclo='$mes'
        and l.anhociclo='$anho'        
        ";
        /* $sql = "SELECT max(l.`id`) maximo
        ,COALESCE(l.id,0) id 
        , l.`id_hidrometro`
        ,c.estado 
        ,h.idcliente 
        , l.`fecha_lectura` 
        , l.`lectura` 
        , l.`lectura_ant` 
        , l.`orden_emitido` 
        , l.`id_usuario` 
        , l.`mesciclo` 
        , l.`anhociclo` 
        FROM `lectura` l 
        inner join hidrometro h on h.id = l.id_hidrometro 
        inner join cliente c on c.id = h.idcliente 
        WHERE h.idcliente = '$id' and c.estado = 1 and l.orden_emitido=0";*/
        return ejecutarConsultaSimpleFila($sql);
    }

    public function insertarVentaA($estado,$idcliente,$nroextracto,$tipocomprobante,$idlectura,$vencimiento,$inicio,$cierre,$emision)
    {
        $sql = "INSERT INTO `venta_agua`( `estado`, `idcliente`,  `num_extracto`, `tipo_comprobante`,   `idlectura`, `fechavencimiento`, `fecha_inicio`, `fecha_cierre`, `fechaemision`) 
        VALUES ('$estado','$idcliente','$nroextracto','$tipocomprobante','$idlectura','$vencimiento','$inicio','$cierre','$emision')";
        return ejecutarConsulta_retornarID($sql);
    }

    public function insertarVentaDetalle($id_venta, $descripcion, $idcuentacontable,$cantidad,$pventa)
    {
        $sql = "INSERT INTO `venta_detalle`(`idventa`, `concepto`, `idcuentacontable`, `cantidad`, `precio_venta`) 
        VALUES ('$id_venta','$descripcion','$idcuentacontable','$cantidad','$pventa')";
        return ejecutarConsulta_retornarID($sql);
    }


    function getNroExtracto()
    {
        $sql = "SELECT (COALESCE(max(`num_extracto`),0)+1)nro FROM `venta_agua`";
        return ejecutarConsultaSimpleFila($sql);
    }

    function getListaLectura($mes,$anho)
    {
        $sql = "SELECT l.id,h.idcliente 
        FROM `lectura` l 
        inner join hidrometro h on h.id = l.id_hidrometro 
        WHERE orden_emitido = 0 and mesciclo ='$mes' and anhociclo = '$anho'";
        return ejecutarConsulta($sql);
    }

    function getOpcionConf($id){
        $sql = "SELECT `id_cuenta`,`descripcion` FROM `opcion_a_configurar` WHERE `id` = '$id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    function setActualizarTotal($idventa,$total){
        $sql = "UPDATE `venta_agua` SET `total_venta` = COALESCE(`total_venta`,0)+'$total' WHERE `id`= '$idventa'";
        return ejecutarConsulta_retornarID($sql);
    }

    function getDeudaAnterior($idcliente){
        $sql = "SELECT COALESCE(`total_venta`,0)deuda, max(`num_extracto`) 
        FROM `venta_agua` WHERE `idcliente`='$idcliente' and `estado`=1";
        return ejecutarConsultaSimpleFila($sql);
    }


    function getCostoCliente($idcliente){
        $sql="SELECT cc.id ,cc.cantidad_pago ,cc.estado ,cc.pagos_realizados ,cc.id_costo ,c.descripcion ,c.monto,c.id_cuenta ,cc.fecha ,cc.id_cliente 
        FROM `costos_cliente` cc 
        inner join costos c on c.id = cc.id_costo 
        WHERE cc.id_cliente = '$idcliente' and cc.estado = 1 
        and cc.pagos_realizados != cc.cantidad_pago;";
        return ejecutarConsulta($sql);
    }

    function setActualizarPago($id){
        $sql="UPDATE `costos_cliente` SET `estado`=0,`pagos_realizados`=(SELECT (`pagos_realizados` + 1) pagonum) 
        WHERE `id`='$id'
        ";
        return ejecutarConsulta_retornarID($sql);
    }

    function montarCombo($sql){        
        return ejecutarConsulta($sql);
    }

}
