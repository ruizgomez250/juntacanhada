<?php
include "../controllers/pdfGenerador.php";
$pdf = new PDF('P', 'mm', 'legal');
$izq = 14;
$top = 10;
$der = 30;
$lista = array();
$i = 0;
$nroExtracto = $pdf->getIdVentaPersonal($_GET['id'],$_GET['mes'], $_GET['anho']); //se optiene id de la tabla ventas por ciclo y estado 
if(isset($nroExtracto)){
$cabece =  $pdf->getCabecera($nroExtracto['id']);
$nrousuario = $cabece['idcliente'];
$idventa = $cabece['id'];
$nro = $cabece['num_extracto'];
$detalleventa = $pdf->getDetalleVenta($idventa);
$reg = $pdf->getDatosCliente($nrousuario);
$pdf->SetMargins($izq, $top, $der);
$pdf->AddPage();
$pdf->tablaHorizontal($reg, $nro);
$pdf->tablaDetallecabecera($cabece);
$pdf->tablaDetalle($cabece);
$pdf->tablaDetalleconsumo($cabece);
$pdf->tablaDetalleconsumo2($detalleventa);

// *************************************************** //


$pdf->Output(); //Salida al navegador
    
} else {
    echo '
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <div style="margin-top: 15%;margin-left: 20%;margin-right: 20%; text-align: center;" class="alert alert-info" role="alert">
    <h1>PERÍODO NO GENERADO</h1>
  </div>';
}
