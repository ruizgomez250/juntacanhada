<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['ventas'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['ventas']==1) {
 ?>

    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Arqueo de Caja <input class="" type="date" name="fech" id="fech"><button onclick="listar()" class="btn btn-success">Generar</button></h1>
 
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Orden</th>
      <th>Fecha Hora</th>
      <th>Nº Factura</th>
      <th>Nº Documento</th>
      <th>Nº Usuario</th>
      <th>Nombre</th>
      <th>Monto</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Orden</th>
      <th>Fecha Hora</th>
      <th>Nº Factura</th>
      <th>Nº Documento</th>
      <th>Nº Usuario</th>
      <th>Nombre</th>
      <th>Monto</th>
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
              <i class="fa fa-ruble"></i> <strong>Ingresar Pago</strong>
            </div>
              
          </div>
        </div>
        <!--body-->
        <div class="modal-body">
                
              <div>
                <div class="row">
                  <div class="col-xs-12 text-center ">
                      <h4><strong id="nombUs">Extracto del Usuario</strong></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3 text-center ">
                      <h6>Nº Doc.:<label id="ndoc"></label></h6>
                  </div>
                  <div class="col-xs-3 text-center ">
                      <h6>Cod. Usu.:<label id="codus"></label></h6>
                  </div>
                  <div class="col-xs-6 text-center ">
                      <h6>Nombre:<label id="nombMod"></label></h6>
                  </div>
                      
                      
                  
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <table id = "tablaModalFech" class="table table-hover table-bordered">
                            <thead align="center">
                            <tr class="fondo">
                            <th class="txtWhite"><b>Descripcion</b></th>
                            <th class="txtWhite"><b>Exentas</b></th>
                                      </tr>
                                    </thead>
                                    <tbody id="tablaModBody">
                                    </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-center">
                        <h2>
                            Cargar numero de factura y el monto a abonar
                        </h2>
                      </div>

                </div>
                  <div class="row">
                      <div class="col-3">
                        <h2><label>Monto a Abonar</label>
                          <input type="hidden"  name="idfac" id="idfac" value="" placeholder="Numero" >
                        <input type="number" oninput="verifMonto()" name="montoAbonar" id="montoAbonar" value="" placeholder="Numero" class="btn-success"></h2>
                        <input type="hidden" name="montoAbonar1" id="montoAbonar1" class="form-control" value="" placeholder="Numero">
                        
                      </div>
                      <div class="col-3 text-center">
                        <h1>
                        <label>Diferencia</label>
                        <label id="diferenciaAbonar" class="btn-danger">Diferencia</label>                    

                        </h1>
                      </div>
                      
                </div>
                      <button class=" btn btn-primary " id="guardarMedida" onclick="pagar()" > Guardar</button>
                  


                </div>
              </div>
        </div>
        <!--pie modal-->
          
      </div>
    </div>
  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php';
 ?>
 <script src="scripts/arqueoCaja.js"></script>
 <?php 
}

ob_end_flush();
  ?>
