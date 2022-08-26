<?php
include "../controllers/pdfGenerador.php";
$pdf = new PDF('P', 'mm', 'legal');
$izq = 14;
$top = 10;
$der = 30;
$lista = array();
$i = 0;
$nroExtracto = $pdf->getIdVenta($_GET['mes'], $_GET['anho']); //se optiene id de la tabla ventas por ciclo y estado 
//$pdf->getCabecera($reg->idcliente);
$i = 0;


while ($reg = $nroExtracto->fetch_object()) {
    $lista[$i] = $reg->id;
  //  echo $i . ' --> ' . $lista[$i] . '</br>';
    $i += 1;
}

//die;
if (count($lista) > 0) {
    for ($i = 0; $i < count($lista); $i++) {
        $cabece =  $pdf->getCabecera($lista[$i]);        
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

        $i = $i  + 1;
        if ($i < count($lista)) {
            if ($i < 3) {
                $spacio = 70;
            } else {
                $spacio = 76;
            }
  
            $cabece2 =  $pdf->getCabecera($lista[$i]);
            $nrousuario2 = $cabece2['idcliente'];
            $idventa2 = $cabece2['id'];
            $nro2 = $cabece2['num_extracto'];
            $detalleventa2 = $pdf->getDetalleVenta($idventa2);

            $reg2 = $pdf->getDatosCliente($nrousuario2);

            $pdf->datosHorizontal2($reg2, $nro2);
            $pdf->tablaDetallecabecera2($cabece2);
            $pdf->tablaDetalle2($cabece2);
            $pdf->tablaDetalleconsumox($cabece2);
            $pdf->tablaDetalleconsumox2($detalleventa2);
        }
    }
    $pdf->Output(); //Salida al navegador
} else {
    echo '
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <div style="margin-top: 15%;margin-left: 20%;margin-right: 20%; text-align: center;" class="alert alert-info" role="alert">
    <h1>PERÍODO NO GENERADO</h1>
  </div>';
}
