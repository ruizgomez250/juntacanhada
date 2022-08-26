<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['extracto'])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['extracto'] == 1) {
?>
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h2 class="box-title"><button class="btn btn-success" id="generador" name="generador"><i class="fa fa-plus-circle"></i>Preparar Extracto</button></h2>
                <h2 class="box-title"><button class="btn btn-success" id="generador2" name="generador2"><i class="fa fa-plus-circle"></i>Generar PDF.</button></h2>
                <div class="box-tools pull-right">

                </div>
              </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-hover">
                  <thead>

                    <th>Nro</th>
                    <th>Cliente</th>                    
                    <th>RUC/CI</th>
                    <th>Estado</th>
                    <th>Categoría</th>
                    <th></th>

                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>

                    <th>Nro</th>
                    <th>Cliente</th>                    
                    <th>RUC/CI</th>
                    <th>Estado</th>
                    <th>Categoría</th>
                    <th></th>


                  </tfoot>
                </table>
              </div>

              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>




    <!-- Modal -->
    <div class="modal fade" id="generadorpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ciclo</h5>
          </div>
          <div class="modal-body">
            <form id="formModal" name="formModal">
              <div class="row" style="margin-left: 5%; margin-right: 5%;">
                <div class="col-md-6">
                  <label for="inputMes2">Mes</label>
                  <select class="custom-select d-block w-100 form-control" name="inputMes2" id="inputMes2">

                  </select>
                </div>
                <div class="col-md-6">
                  <label for="inputAnho2">Año</label>
                  <select class="custom-select d-block w-100 form-control" name="inputAnho2" id="inputAnho2">

                  </select>
                </div>

              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="generarpdf" name="generarpdf" class="btn btn-primary">Generar Pdf</button>
          </div>
        </div>
      </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="generadorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          </div>
          <div class="modal-body">
            <form id="formModal" name="formModal">
              <div class="row" style="margin-left: 5%; margin-right: 5%;">
                <div class="col-md-6">
                  <label for="inputInicio">Inicio</label>
                  <input type="date" class="form-control" id="inputInicio" placeholder="Inicio Periodo">
                </div>
                <div class="col-md-6">
                  <label for="inputFin">Cierre</label>
                  <input type="date" class="form-control" id="inputFin" placeholder="Fin Periodo">
                </div>
              </div>
              <div class="row" style="margin-left: 5%; margin-right: 5%;">
                <div class="col-md-6">
                  <label for="inputInicio">Vencimiento</label>
                  <input type="date" class="form-control" id="inputVencimiento" placeholder="Vencimiento">
                </div>
                <div class="col-md-6">
                  <label for="inputFin">Emisión</label>
                  <input type="date" class="form-control" id="inputEmision" placeholder="Emisión">
                </div>

              </div>

              <div class="row" style="margin-left: 5%; margin-right: 5%;">
                <div class="col-md-6">
                  <label for="inputMes">Mes</label>
                  <select class="custom-select d-block w-100 form-control" name="inputMes" id="inputMes">

                  </select>
                </div>
                <div class="col-md-6">
                  <label for="inputAnho">Año</label>
                  <select class="custom-select d-block w-100 form-control" name="inputAnho" id="inputAnho">

                  </select>
                </div>

              </div>


            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" id="generardoc" name="generardoc" class="btn btn-primary">Generar Extracto</button>
          </div>
        </div>
      </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row">
              <div id="content" class="col-lg-12" style="text-align: center;margin-bottom: 25px;">
                <div class="alert alert-warning" role="alert">
                  Contenido inicial del contenedor...
                </div>
              </div>
              <div class="col-lg-12" style="text-align: center;margin-bottom: 25px;">
                <h1><time>00:00:00</time></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script src="scripts/generar.js"></script>
<?php
}

ob_end_flush();
?>