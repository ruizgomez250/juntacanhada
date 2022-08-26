<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    

  
  
<style type="text/css">
.bi::before {
  display: inline-block;
  content: "";
  background-image: url("data:image/svg+xml,<svg viewBox='0 0 16 16' fill='%C82333' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z' clip-rule='evenodd'/></svg>");
  background-repeat: no-repeat;
  background-size: 1rem 1rem;
}
  .fondo{
    background-color:#3EAEB5;
    /*text-align:center;*/
    /*height: 50px;*/
  }
  
  .borde3{
    /*height:50px;*/
    text-align:center;
    background-color:olivedrab;
  }
  .txtWhite{
    color: #FFFFFF;
  }
  
  .txtBlue{
    color: #007BFF;
  }
</style>

    <title>Pagina Principal</title>
  </head> 
  <body>


<!--*******************************************************Empieza el contenido****************************************************************-->
  



  <?php 
  include('../config/Conexion.php');
  $conexion = conexion_db();

  $primerDia=primerDiaMes();
  $ultimoDia=ultimoDia();
  $primerAnho=primerAnho();
  $ultimoAnho=ultimoAnho();
  $facturasPendientes =0;
  $facturasPagadasTotal =0;
  $facturasPagadas =0;
  $facturasPendientesTotal =0;
  $maxIdEncabezado=-1;
  $sql = "SELECT max(id) FROM factura_encabezado;";
  $stmt = pg_exec($conexion, $sql );
  $fechEmision='2001-01-01';
  if(!$stmt){
  }else{
    while( $row = pg_fetch_array( $stmt) ) {

        $maxIdEncabezado=$row[0];
        if(strlen($maxIdEncabezado) != 0){
          $sql = "SELECT fecha_emision FROM factura_encabezado where id=$maxIdEncabezado;";
          $stmt = pg_exec($conexion, $sql );

          while( $row = pg_fetch_array( $stmt) ) {
            
            $fechEmision=$row[0];
          }
        }
    }
    $sql = "select count(id) from factura_encabezado 
  where fecha_emision = '$fechEmision' and estado=1;";
   $resultado = pg_query($conexion,$sql);
   $res = pg_fetch_row($resultado);
   $facturasPendientes = $res[0];


    $sql = "select count(id) from factura_encabezado 
  where estado =2 and fecha_emision < '$ultimoAnho' and fecha_emision >= '$primerAnho';";

   $resultado = pg_query($conexion,$sql);
   $res = pg_fetch_row($resultado);
   $facturasPagadasTotal = $res[0];
   

   $sql = "select count(id) from factura_encabezado 
  where estado =2 and fecha_emision = '$fechEmision';";
   $resultado = pg_query($conexion,$sql);
   $res = pg_fetch_row($resultado);
   $facturasPagadas = $res[0];

   $sql = "select count(id) from factura_encabezado 
  where estado =1 and fecha_emision < '$ultimoAnho' and fecha_emision >= '$primerAnho';;";
   $resultado = pg_query($conexion,$sql);
   $res = pg_fetch_row($resultado);
   $facturasPendientesTotal = $res[0];
}
    function ultimoDia(){
      $anho=date("Y");
      $mes=date("m");
      $mes++;
      if($mes > 12){
        $mes=1;
        $anho++;
      }
      return('01/'.$mes.'/'.$anho);
    }

    function ultimoAnho(){
      $anho=date("Y");
      
      return('31/12/'.$anho);
    }
    function primerAnho(){
      $anho=date("Y");
      
      return('01/01/'.$anho);
    }
    function primerDiaMes(){
      $mes=date("m");
      $anho=date("Y");
      
      return('01/'.$mes.'/'.$anho);
    }

  
  include('menu.php');
?>
  



<div class="content-wrapper">
  <div class="container">
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo($facturasPagadas); ?></h3>

                <p>Facturas pagadas en el mes</p>
              </div>
              <div class="icon">
                <svg class="bi" width="100" height="100" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#person-check-fill"/>
                </svg>
              </div>
              <a href="../reportes/usuariosPagMes.php" target="_blank" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo($facturasPagadasTotal); ?></h3>

                <p>Facturas Pagadas en el año</p>
              </div>
              <div class="icon">
                <svg class="bi" width="100" height="100" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#card-checklist"/>
                </svg>
              </div>
              <a href="../reportes/usuariosPagAnho.php" target="_blank" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo($facturasPendientes); ?></h3>

                <p>Pendientes de pago en el mes</p>
              </div>
              <div class="icon">
                <svg class="bi" width="100" height="100" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#card-list"/>
                </svg>
              </div>
              <a href="../reportes/usuariosPendienteMes.php" target="_blank" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo($facturasPendientesTotal); ?></h3>

                <p>Ordenes pendientes en el año</p>
              </div>
              <div class="icon">
                <svg class="bi" width="100" height="100" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#person-x-fill"/>
                </svg>
              </div>
              <a href="../reportes/usuariosPendienteAnho.php" target="_blank" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <div class="col-12 connectedSortable">

              <div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart"></canvas>
</div>

            
          </div>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  
    

        
            
  </div>
</div>    


<?php



  function consumoMinimoMes($mes){
        $conexion = conexion_db();
        $anho=date("Y");
        $anho1=$anho;
        $mesSup=$mes+1;
        if($mesSup > 12){
        $mesSup=1;
        $anho1++;
      }
        $sql = "SELECT COALESCE(SUM(det.cantidad),0) FROM factura_detalle det 
    INNER JOIN factura_encabezado enc ON enc.id = det.id_encabezado  
    WHERE enc.fecha_emision < '01/".$mesSup."/".$anho."'  AND enc.fecha_emision >= '01/".$mes."/".$anho1."' AND det.descripcion = 'Consumo Minimo';";
     $resultado = pg_query($conexion,$sql);
     $res = pg_fetch_row($resultado);
     return($res[0]);
    
  }
  function consumoExcesoMes($mes){
        $conexion = conexion_db();
        $anho=date("Y");
        $anho1=$anho;
        $mesSup=$mes+1;
        if($mesSup > 12){
          $mesSup=1;
          $anho1++;
      }
        $sql = "SELECT COALESCE(SUM(det.cantidad),0) FROM factura_detalle det 
    INNER JOIN factura_encabezado enc ON enc.id = det.id_encabezado  
    WHERE enc.fecha_emision < '01/".$mesSup."/".$anho."'  AND enc.fecha_emision >= '01/".$mes."/".$anho1."' AND det.descripcion = 'Exceso Consumo';";
     $resultado = pg_query($conexion,$sql);
     $res = pg_fetch_row($resultado);
     return($res[0]);
  }
  $consEnero = consumoExcesoMes('01')+consumoMinimoMes('01');
  $consFebrero = consumoExcesoMes('02')+consumoMinimoMes('02');
  $consMarzo = consumoExcesoMes('03')+consumoMinimoMes('03');
  $consAbril = consumoExcesoMes('04')+consumoMinimoMes('04');
  $consMayo = consumoExcesoMes('05')+consumoMinimoMes('05');
  $consJunio = consumoExcesoMes('06')+consumoMinimoMes('06');
  $consJulio = consumoExcesoMes('07')+consumoMinimoMes('07');
  $consAgosto = consumoExcesoMes('08')+consumoMinimoMes('08');
  $consSetiembre = consumoExcesoMes('09')+consumoMinimoMes('09');
  $consOctubre = consumoExcesoMes('10')+consumoMinimoMes('10');
  $consNoviembre = consumoExcesoMes('11')+consumoMinimoMes('11');
  $consDiciembre = consumoExcesoMes('12')+consumoMinimoMes('12');
  echo("<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['', 'Enero', 'Febrero','Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [{
            label: 'Consumo del Agua por Mes',
            data: [".$consEnero.",".$consFebrero.",".$consMarzo.",".$consAbril.",".$consMayo.",".$consJunio.",".$consJulio.",".$consAgosto.",".$consSetiembre.",".$consOctubre.",".$consNoviembre.",".$consDiciembre."],
            backgroundColor: [
                'rgba(0, 123, 255, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>");


 ?>

<!--****************************************************termina el contenido**********************************************************************-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    


    
    
   
  </body>
</html>