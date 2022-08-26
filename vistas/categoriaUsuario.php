<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['categusu']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Categoria Usuario <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> </h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Descripcion</th>
      <th>Gs. Consumo Minimo</th>
      <th>Consumo minimo m3</th>
      <th>Gs. Por Exceso</th>  
      <th>Consumo Exceso m3</th>        
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Descripcion</th>
      <th>Gs. Consumo Minimo</th>
      <th>Consumo minimo m3</th>
      <th>Gs. Por Exceso</th>  
      <th>Consumo Exceso m3</th>  
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
      <div class="row">
        <div class="form-group col-lg-6 col-md-6 col-xs-12">
          <label for="">Descripcion(*):</label>
          <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
          <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="100" placeholder="Descripcion" required>
        </div>
      </div>
    <div class="row">
        <div class="form-group col-lg-6 col-md-6 col-xs-12">
          <label for="">Gs. Consumo minimo(*): </label>
         <input class="form-control" type="number" name="gsconsumominimo" id="gsconsumominimo" maxlength="100" placeholder="Guaranies" required>
        </div>
           
           <div class="form-group col-lg-6 col-md-6 col-xs-12">
          <label for="">M3 Consumo Minimo(*)</label>
          <input class="form-control" type="number" name="m3consumominimo" id="m3consumominimo" maxlength="256" placeholder="Consumo m3" required>
        </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-6 col-md-6 col-xs-12">
        <label for="">Gs Por Exceso(*)</label>
        <input class="form-control" type="number" name="gsexceso" id="gsexceso" maxlength="256" placeholder="Guaranies" required>
      </div>
        <div class="form-group col-lg-6 col-md-6 col-xs-12">
          <label for="">Consumo Exceso(*):</label>
          <input class="form-control" type="number" name="consumoexceso" id="consumoexceso" maxlength="256" placeholder="Consumo m3" required>
        </div>
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
 <script src="scripts/categoriaUsuario.js"></script>

 <?php 
}

ob_end_flush();
  ?>