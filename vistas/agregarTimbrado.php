<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['mercaderias']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Articulo <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> <a target="_blank" href="../reportes/rptarticulos.php"><button class="btn btn-info">Reporte</button></a></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Factura desde</th>
      <th>Factura hasta</th>
      <th>Timbrado</th>
      <th>Fecha modificacion</th>
      <th>Usuario</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Factura desde</th>
      <th>Factura hasta</th>
      <th>Timbrado</th>
      <th>Fecha modificacion</th>
      <th>Usuario</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Desde Numero Factura(*):</label>
      <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
      <input class="form-control" type="number" name="desde" id="desde" maxlength="100" placeholder="Desde" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Hasta Numero Factura(*):</label>
      <input class="form-control" type="number" name="hasta" id="hasta" maxlength="100" placeholder="Hasta" required>
    </div>
       <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Timbrado</label>
      <input class="form-control" type="text" name="timbrado" id="timbrado" maxlength="256" placeholder="Timbrado" required>
    </div>

    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>

      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  </form>
</div>
<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php'
 ?>
 <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>
 <script src="scripts/agregarTimbrado.js"></script>

 <?php 
}

ob_end_flush();
  ?>