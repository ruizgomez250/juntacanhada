<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['costosusuario']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Asignar Costo a Cliente<button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button> </h1>

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
      <th>Nombre Usuario</th> 
      <th>Num. Usuario</th> 
      <th>Cantidad Pagos</th> 
      <th>Pagos Realizados</th>       
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Monto</th>
      <th>Descripcion</th>
      <th>Nombre Usuario</th> 
      <th>Num. Usuario</th> 
      <th>Cantidad Pagos</th> 
      <th>Pagos Realizados</th>   
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="row">
    <div class="form-group col-lg-3 col-md-6 col-xs-12">
      <label for="">Codigo Deuda(*):<i class="fa fa-search bg-primary" onclick="mostrarmodal()"></i></label>
      <input class="form-control" type="text" onchange="buscDeuda()" name="monto" id="monto" maxlength="100" placeholder="Cod. Deuda" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Descripcion(*):</label>
      <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="100" placeholder="Nombre Deuda" readonly>

    </div>
    
  </div>
  <div class="row">
    <div class="form-group col-lg-3 col-md-6 col-xs-12">
      <label for="">Codigo Usuario(*):<i class="fa fa-search bg-primary" onclick="mostrarmod()"></i></label>
      <input class="form-control" onchange="buscUs()" type="number" name="codUs" id="codUs" maxlength="100" placeholder="Usuario Junta" required>
    </div>  
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
        <label for="">Nombre Usuario(*):</label>
        <input class="form-control"  type="text" name="nomb" id="nomb" maxlength="100" placeholder="Nombre" readonly>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-lg-3 col-md-6 col-xs-12">
      <label for="">Cantidad de Pagos(*):</label>
      <input class="form-control" type="number" name="cantpago" id="cantpago" maxlength="100" placeholder="Pagos" value="1"required>
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
  <!--Modal <div class="modal-dialog" style="max-width: 82%;">-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione el costo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12 text-center ">
                <h4><strong>Costo a Asignar</strong></h4>
                <h6>Descripcion :<label id="descC"></label></h6>
                <input type="hidden" name="codas" id="codas">
                <h6>Monto :<label id="montoC"></label></h6>
            </div>
          </div>
          
          
          <hr>
          <div class="row">
            <div class="col-xs-12 text-center">
                <h4><strong>Datos de la nueva Cuenta</strong></h4>
            </div>
          </div>
            <div class="row">                                            
              <div class="col-sm-12" id="Funcionario1">
                     <div class="panel-body table-responsive" id="listadoregistros">
                              <table id="tbllistado1" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                  <th>Opciones</th>
                                  <th>Cod. Usuario</th>
                                  <th>Nombre</th>                                  
                                  <th>Zona</th>
                                  <th>Situacion</th>
                                  <th>Categoria</th>                                  
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <th>Opciones</th>
                                  <th>Cod. Usuario</th>
                                  <th>Nombre</th>              
                                  <th>Zona</th>
                                  <th>Situacion</th>
                                  <th>Categoria</th>
                                </tfoot>   
                              </table>
                            </div>                         
                                              
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
                  <!--Modal <div class="modal-dialog" style="max-width: 82%;">-->
                  <div class="modal fade" id="myModal1" tabindex="-1" role="dialog">
                     <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Seleccione el monto a asignar</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-xs-12 text-center">
                                <h4><strong>Monto</strong></h4>
                            </div>
                          </div>
                            <div class="row">                                            
                              <div class="col-sm-12" id="Funcionario1">
                                     <div class="panel-body table-responsive" id="listadoregistros">
                                              <table id="tbllistado2" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                      <th>Opciones</th>
                      <th>Monto</th>
                      <th>Descripcion</th>
                      <th>Cuenta Contable</th> 
                      <th>Estado</th>        
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th>Opciones</th>
                      <th>Monto</th>
                      <th>Descripcion</th>
                      <th>Cuenta Contable</th>
                      <th>Estado</th> 
                    </tfoot>   
                  </table>                    
                                              
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
require 'footer.php'
 ?>
 <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>
 <script src="scripts/costosCliente.js"></script>

 <?php 
}

ob_end_flush();
  ?>