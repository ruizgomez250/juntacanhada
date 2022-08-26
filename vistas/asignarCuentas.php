<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['cuentascont']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <div class="row">
      <div class="col-lg-12 ">
          <h1 class="box-title">
              Asignar Cuentas
              
          </h1>
      </div>
  </div>
  
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>      
      <th>Opcion a Configurar</th>
      <th>Codigo Contable</th>
      <th>Cuenta Contable</th>
      <th>Cambiar Cuenta Contable</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>      
      <th>Opcion a Configurar</th>
      <th>Codigo Contable</th>
      <th>Cuenta Contable</th>
      <th>Cambiar Cuenta Contable</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Opcion(*): </label>
     <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
       <option value="Boleta">Efectivo</option>
       <option value="Factura Contado">Documentos a pagar</option>
       <option value="Factura Credito">Provicion de agua potable</option>
     </select>
    </div>
    <div class="row">
      <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
       <a data-toggle="modal" href="#myModal">
         <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Cuentas</button>
       </a>
      </div>
    </div>
<div class=" col-6">
     <table id="detalles" class="table table-striped table-bordered table-condensed table-hover table-sm">
       <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Cuenta</th>
        
       </thead>
       
       <tbody>
         
       </tbody>
     </table>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!--Modal-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione una Cuenta</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Codigo</th>
              <th>Cuenta</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
              <th>Codigo</th>
              <th>Cuenta</th>
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/asignarCuentas.js"></script>
 <?php 
}

ob_end_flush();
  ?>

