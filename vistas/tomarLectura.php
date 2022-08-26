<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['lecturamedidor']==1) {
 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Tomar Lectura <button class="btn btn-success btn-xs" onclick="cargarLecturas()"><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" border ="0" id= "editar" title="Tomar Medida" />Cargar sin medidor</button></h1>
 
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Tomar Lectura</th>
      <th>Orden</th>
      <th>Codigo Usuario</th>
      <th>Documento</th>
      <th>Nombre</th>
      <th>Sector</th>
      <th>Medidor</th>
      <th>Categoria</th>
      <th>Penultima Lectura</th>
      <th>Ultima Lectura</th>
      <th>Nueva Lectura</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Tomar Lectura</th>
      <th>Orden</th>
      <th>Codigo Usuario</th>
      <th>Documento</th>
      <th>Nombre</th>
      <th>Sector</th>
      <th>Medidor</th>
      <th>Categoria</th>
      <th>Penultima Lectura</th>
      <th>Ultima Lectura</th>
      <th>Nueva Lectura</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre</label>
      <input class="form-control" type="hidden" name="idpersona" id="idpersona">
      <input class="form-control" type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del cliente" required>
    </div>
     <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Tipo Dcumento</label>
     <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
       <option value="CEDULA">CEDULA</option>
       <option value="DNI">DNI</option>
       <option value="RUC">RUC</option>       
     </select>
    </div>
     <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Número Documento(*):</label>
      <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20" placeholder="Número de Documento" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Direccion</label>
      <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Telefono</label>
      <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Número de Telefono">
    </div>
        <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Email</label>
      <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email">
    </div>
    
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Categoria(*):</label>
      <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Situacion(*):</label>
      <select name="idsituacion" id="idsituacion" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">

      <label for="">Zona(*):</label>
      <select name="idzona" id="idzona" class="form-control selectpicker" data-Live-search="true" required></select>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for=""></label>
      <label for="w3review">Observacion:</label>
      <textarea id="obs" name="obs" rows="3" cols="68">
</textarea>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>

      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
    </div>
  
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
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content borde1">
        <!--Cabecera-->
        <div class="modal-header align-self-center"> 
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div class="card">
            <div class="card-header">
              <img src="icon/droplet-fill.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Ingresar Lectura</strong>
            </div>
              
          </div>
        </div>
        <!--body-->
        <div class="modal-body">
                
              <div>
                <div class="row">
                  <div class="col-xs-12 text-center ">
                      <h4><strong id="nombUs">Datos de la cuenta Padre</strong></h4>
                      <h6>Nº Doc.:<label id="codP"></label></h6>
                      <h6>Cod. Usu.:<label id="cuentaP"></label></h6>
                      <h6>Zona:<label id="zon"></label></h6>
                      <h6>Medidor:<label id="med"></label></h6>
                  </div>
                </div>
                <hr>
              <form action="" name="formulario" id="formulario" method="POST">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3 class="btn-primary"> Cargar Nueva Lectura </h3>
                    </div>
                </div>
                <div class="row">
                  
                  <div class="col-sm-3 ">
                    <div class="form-group">
                      <input type="hidden"  name="hidr" id="hidr" class="form-control" value="" placeholder="Lectura Actual">
                      <label>Lectura</label>
                      <input type="number" onchange="verifilec()" name="lectura" id="lectura" class="form-control" value="" placeholder="Lectura Actual">
                      <label id="mensajeLectura" name="mensajeLectura" class="btn-danger" style="display:none">Lectura ingresada inferior a la ultima lectura!!!</label>
                    </div>
                  </div>
                  <div class="col-sm-3 ">
                    <div class="form-group">
                      <label>Fecha Lectura</label>
                      <input id="fechaLectura" name="fechaLectura" onblur="verififech()" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>">
                      <label id="mensajeFecha" name="mensajeFecha" class="btn-danger" style="display:none">Fecha ingresada inferior a la ultima lectura!!!</label>
                    </div>
                  </div>
                  <div class="col-sm-3 ">
                    <div class="form-group">
                      <label>Mes Ciclo</label>
                      <input type="number" name="mesperiodo" id="mesperiodo" class="form-control" value="" placeholder="Lectura Actual" readonly>
                      
                    </div>
                  </div>
                  <div class="col-sm-3 ">
                    <div class="form-group">
                      <label>Año Ciclo</label>
                      <input type="number" name="anhoperiodo" id="anhoperiodo" class="form-control" value="" placeholder="Lectura Actual" readonly>
                      
                    </div>
                  </div>
                  <div class="col-sm-12 ">
                    <div class="form-group">
                      <button class=" btn btn-primary " id="guardarMedida" disabled> Guardar</button>
                    </div>
                  </div>
                </form>
                  


                </div>
              </div>



                <div class="row">
                 
                  <div class="col-12 align-self-end">
                      


                        <div class="card">
                          <div class="card-header text-center">
                            <h3><strong>Lecturas Anteriores</strong></h3>
                          </div>
                        
                        
                        
                        <table id = "tablaMedida" class="table table-striped table-bordered table-hover">
                                  <thead align="center">
                                      <tr class="fondo">
                            <th class="txtWhite"><b>Fecha Lectura</b></th>
                            <th class="txtWhite"><b>Lectura</b></th>
                            <th class="txtWhite"><b>Mes Ciclo</b></th>
                            <th class="txtWhite"><b>Anho Ciclo</b></th>
                            <th class="txtWhite"><b>Borrar</b></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                        </tbody>
                                </table>
                    </div>

                      
                    
                  </div>
                </div>


        </div>
        <!--pie modal-->
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
 <script src="scripts/tomarLectura.js"></script>
 <?php 
}

ob_end_flush();
  ?>
