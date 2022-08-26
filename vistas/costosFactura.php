<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['costosfactura']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Costos Factura <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> </h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Monto</th>
      <th>Descripcion</th>
      <th>Cuenta Contable</th> 
      <th>Tipo</th> 
      <th>Estado</th>        
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Monto</th>
      <th>Descripcion</th>
      <th>Cuenta Contable</th>
      <th>Tipo</th>
      <th>Estado</th> 
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Descripcion(*):</label>
      <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="100" placeholder="Nombre" required>
    </div>
    <div class="form-group col-lg-3 col-md-6 col-xs-12">
      <label for="">Monto(*):</label>
      <input class="form-control" type="text" name="monto" id="monto" maxlength="100" placeholder="Nombre" required>
    </div>
    <div class="form-group col-lg-3 col-md-6 col-xs-12">
      <label for="">Tipo Monto(*): </label>
     <select name="tipomonto" id="tipomonto" class="form-control selectpicker" required>
       <option value="1">Porcentaje</option>
       <option value="0">Monto Fijo</option>
     </select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
        <label for="">Cuenta Contable(*):</label>
        <select name="idcuenta" id="idcuenta"  class="form-control selectpicker" data-Live-search="true" required></select>
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
 <script src="scripts/costosFactura.js"></script>

 <?php 
}

ob_end_flush();
  ?>