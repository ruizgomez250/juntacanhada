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
              Crear Cuentas
              
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
      <th>Codigo Contable</th>
      <th>Cuenta Contable</th>
      <th>Editar</th>
      <th>Asentable</th>
      <th>Select Cuenta Padre</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Codigo Contable</th>
      <th>Cuenta Contable</th>
      <th>Editar</th>
      <th>Asentable</th>      
      <th>Select Cuenta Padre</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="form-group col-lg-5 col-md-5 col-xs-12">
      <label for="">Codigo Contable</label>
      <input class="form-control" type="hidden" name="idcuenta" id="idcuenta">
      <input class="form-control" type="text" name="codigo" id="codigo" maxlength="100" placeholder="Codigo" readonly>    
    </div>
    <div class="form-group col-lg-5 col-md-5 col-xs-12">
      <label for="">Cuenta Contable</label>
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>    
    </div>
    <div class="form-group col-lg-2 col-md-2 col-xs-12">
      <label for="">Asentable</label>
      <select name="asentable" id="asentable" class="form-control selectpicker" required>
       <option value="1">Si</option>
       <option value="0">No</option>
     </select>   
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
          <h4 class="modal-title">Crear una nueva cuenta contable</h4>
        </div>
        <div class="modal-body">
          <div class="row alert-secondary">
            <div class="col-xs-12 text-center ">
                <h4><strong>Datos de la cuenta Padre</strong></h4>
                <h6>Cod. Padre :<label id="codP"></label></h6>
          <h6>Cuenta Padre :<label id="cuentaP"></label></h6>
            </div>
          </div>
          
          
          <hr>
          <div class="row">
            <div class="col-xs-12 text-center">
                <h4><strong>Datos de la nueva Cuenta</strong></h4>
            </div>
          </div>
          <div class="row">
                                            
                                            <div class="col-md-8" id="Funcionario1">
                                              <label for="cedul">
                                                <font style="vertical-align: inherit;">Nueva Cuenta</font>
                                                <input type="text" class="form-control" id="descripcion" value=""  name="descripcion" placeholder="">
                                                
                                              </label>
                                              
                                            </div>
                                            <div class="col-md-4" id="Funcionario1">
                                              <label for="cedul">
                                                <font style="vertical-align: inherit;">Cod. nuevo de la Cuenta</font>
                                                <h4 id="cuentaH"></h4>
                                                
                                              </label>
                                              
                                            </div>
                                          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" onclick="guardar()">Guardar</button>
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
 <script src="scripts/crearCuentas.js"></script>
 <?php 
}

ob_end_flush();
  ?>

