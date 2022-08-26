<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />  
    
      
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- CSS personalizado --> 
      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="dataTables/jquery.dataTables.min.css">
           
    <!--font awesome con CDN--> 
      <title>Cliente</title>
  </head>
    
  <body>
<!--*******************************************************Empieza el contenido****************************************************************-->
  



  <?php 
   include('../config/conexion.php');
   $conexion = conexion_db();
  $modificar=0;
  $id1='';
  $descripcion1='';
  $monto1='';
  $porcentaje1='';
  $esPorcentaje1='';
  
  

  if(isset($_GET['moadfnmgvlfjhdif'])){
    $modificar = $_GET['moadfnmgvlfjhdif'];
    $sql = "SELECT id,descripcion,monto,porcentaje,es_porcentaje,estado
      FROM costos_fijos_x_factura
      WHERE id = $modificar;";
      $stmt = pg_exec($conexion, $sql );
      while( $row = pg_fetch_array( $stmt) ) {
        $id1=$row['id'];
        $descripcion1=$row['descripcion'];
        $monto1=$row['monto'];
        $porcentaje1=$row['porcentaje'];
        $esPorcentaje1=$row['es_porcentaje'];
        $estado=$row['estado'];
      }
  }
  $paginaGuardado='';
  if($modificar == 0){
    $paginaGuardado='../php/GastosFijosXFactura.php?op=guardar';
  }else{
    $paginaGuardado='../php/GastosFijosXFactura.php?op=modificar&id='.$_GET['moadfnmgvlfjhdif'];
  }
  echo('<input id="modificarVerif" name="modificarVerif" value ="'.$modificar.'" style="display:none">');
  echo('<input id="porcentajeVerif" name="porcentajeVerif" value ="'.$esPorcentaje1.'" style="display:none">');
  $sql = "SELECT id,descripcion,monto,porcentaje
      FROM costos_fijos_x_factura;";
  $stmt = pg_exec($conexion, $sql );
  $bodyTablaPermiso=null;
  while( $row = pg_fetch_array( $stmt) ) {
        $id=$row['id'];
        $descripcion=$row['descripcion'];
        $monto=$row['monto'];
        $porcentaje=$row['porcentaje'];
      
        $verif='';
        $documento='';
        $bodyTablaPermiso=('<tr><td class="text-center ">'.$id.'</td>
                          <td class="text-center ">'.$descripcion.'</td>
                          <td class="text-center ">'.$monto.'</td>
                        <td>'.$porcentaje.'</td>
                        
                        <td class="text-left">
                          
                            <a href="addModifGastosFijosXfactura.php?moadfnmgvlfjhdif='.$id.'"><button  name='.$id.' class="ieditar btn-success btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button></a>
                            
                            '.$verif.$documento.'
                        </td>
                        </tr>').$bodyTablaPermiso;

  }
  if(!isset($bodyTablaPermiso) ){
     $bodyTablaPermiso=('<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>');
  }

  include('menu.php');
?>
  



<div class="content-wrapper">
  <div class="container">

  
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <h2 class="txtBlue text-center">Agregar/Modificar Costos Fijos por Factura</h2>
        <div class="card">
              <div class="card-header">
                  <img src="icon/plus-circle.svg" width="25" height="25" border ="0" id= "buscarCod"/><?php if(isset($_GET['moadfnmgvlfjhdif']))echo('<a href="addModifGastosFijosXfactura.php"> <button class="btn btn-sm btn-secondary">Nuevo</button></a>'); ?> 
              </div>
              <div class="card-body">
                

                <!-- /*agregar nuevo doc*/-->
                <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <form class=" inline-block" id="form" enctype="multipart/form-data" method="post" action="<?php echo ($paginaGuardado); ?>" name="  form" novalidate>
          <div class="row">
            <div class="col-md-2">
              <label for="cedul">
                <font style="vertical-align: inherit;">Codigo Costo</font>
              </label>
              <input id="codCategoria" name="codCategoria" class="form-control" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($id1); ?>" disabled>
            </div>
            <div class="col-md-3">
                <div class="card" <?php if(!isset($_GET['moadfnmgvlfjhdif']))echo('style="display:none"'); ?>>
                    <div class="card-header">
                        <label for="cedul">
                        <font style="vertical-align: inherit;">Costo Activo &nbsp;&nbsp;</font>
                      </label>
                      <input id="activo" name="estado" class="" type="radio" value="1" <?php if($estado == 1)echo('checked'); ?>>
                      
                      <label for="cedul">
                        <font style="vertical-align: inherit;">Costo Inactivo</font>
                      </label>
                      <input id="inactivo" name="estado" class="" type="radio" value="0" <?php if($estado == 0)echo('checked'); ?>>

                    </div>
                </div>
                
            </div>
          </div>
          <div class="row">
            
            <div class="col-md-7" id="Funcionario1">
              <label for="cedul">
                <font style="vertical-align: inherit;">Descripcion</font>
              </label>
              <input id="descCostoFijo" name="descCostoFijo" class="form-control" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($descripcion1); ?>">

            </div>
            
        

        

            
          </div>
          <div class="row">
            <div class="col-md-3">
              <input id="esPorcentaje" name="esPorcentaje" class="" type="checkbox" <?php if($esPorcentaje1 == 1)echo('checked') ?>>
              <label for="cedul">
                <font style="vertical-align: inherit;">Porcentaje</font>
              </label>
            </div>
          </div> 
          <div class="row" >
            <div class="col-md-3" id="Funcionario5" >
              <label for="cedul" >
                <font style="vertical-align: inherit;">Costo en Guaranies</font>
              </label>
              <input id="costoGuaranies" name="costoGuaranies" class="form-control " type="text" value="<?php 
               if(isset($_GET['moadfnmgvlfjhdif'])){if($esPorcentaje1 != 1)echo($monto1);} ?>" <?php if($esPorcentaje1 == 1)echo('disabled'); ?>>
    


            </div>
            <div class="col-md-" id="Funcionario5" >
              <label for="cedul" >
                <font style="vertical-align: inherit;">Porcentaje sobre el costo del agua</font>
              </label>
              <input id="porcentajeCosto" name="porcentajeCosto" class="form-control text-center" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($porcentaje1); ?> "  <?php if($esPorcentaje1 != 1)echo('disabled'); ?> >

            </div>
          </div>
                   
          <hr>
          <div class="row">
            <div class="col-md-1">
              <button class="btn btn-primary" id="guardar" <?php if(!isset($_GET['moadfnmgvlfjhdif']))echo('disabled');?> type="submit">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Guardar</font>
                </font>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>
        <!--        /*fin agregar*/ -->
            
              <hr>
              
                      
       </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        
              <hr>
              <div class="card">
              <div class="card-header text-center">
                <h3><strong>Listado</strong></h3>
              </div>
            
          <div class="table-responsive">
            
            
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead align="center">
                          <tr class="fondo">
                <th class="txtWhite"><b>Codigo</b></th>
                <th class="txtWhite"><b>Descripcion</b></th>
                <th class="txtWhite"><b>Monto</b></th>
                <th class="txtWhite"><b>Porcentaje</b></th>
                <th class="txtWhite"><b>Accion</b></th>
                          </tr>
                        </thead>
                        <tbody>
              <?PHP echo($bodyTablaPermiso); ?>
            </tbody>
                    </table>
          </div>
        </div>
                
                
                
                
                      
                </div>
          </div>

          <div class="modal hide fade" id="modalCheck" data-focus-on="input:first">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <!--body-->
                              <div class="modal-body">
                            <div class="row">
                                                  <div class="col-12 text-center">
                                                          <img src="icon/exclamation-circle.svg" width="100" height="100" border ="0"/>
                                                                <h6>Documento Enviado</h6>
                                                                <button class=" btn btn-success" id="verifForm">ok</button>
                                                                 <button class=" btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>        
                                                      
                                                     </div>
                                                                
                            </div>
                                        <!--pie modal-->
                                       
                      </div>
              </div>
          </div>  
      </div>
          <!--modal-->
          <!-- <button type="button" id="boton" class="btn btn-primary" data-toggle="modal" data-target="#votar">VOTAR</button>-->
          <!--El Modal -->
          <div class="modal fade" id="modalVer">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <div class="modal-header">
                                                <img src="icon/rrhh.png" width="40" border ="0" id= "foto"/>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" method="post" action="guardarDip.php" name= "form" novalidate>
                            <div class="row">
                                                  <div class="col-12">
                                      <h6><strong>Mesa de Entrada: </strong><span id="mEntrada"></span></h6>
                                                                <h6><strong>Fecha de Recepcion: </strong><span id="fRecep"></span></h6>
                                                                <h6><strong>Fecha del Documento: </strong><span id="fDoc"></span></h6>
                                                                <h6><strong>Solicitante: </strong><span id="Solic"> </span></h6>
                                                                <h6><strong>Firmante: </strong><span id="Firm"> </span></h6>
                                                                <h6><strong>Funcionario solicitante: </strong><span id="funcSolic"> </span></h6>
                                                                <h6><strong>Funcionario Firmante: </strong><span id="supFir"> </span></h6>
                                                                <h6><strong>Tipo Documento: </strong><span id="motPer"></span></h6>
                                                                <h6><strong>Destino Documento: </strong><span id="destinoDoc"></span></h6>
                                                                <h6><strong>Detalles: </strong><span id="obs"></span></h6>
                                                                
                                                                <h6><strong>Estado Documento: </strong><span id="estadoDoc"></span></h6>
                                                                <h6><strong>Recepcionado Por: </strong><span id="recep"></span></h6>
                                </div>
                            </div>
                      </form>
                                        <!--pie modal-->
                                        <div class="modal-footer text-left text-justify text">
                                             <button class=" btn btn-danger" data-dismiss="modal" aria-label="Close">Cerrar</button>                              
                                         </div>
                      </div>
              </div>
          </div>  
      </div>
        <div class="modal fade" id="modalGuardado">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" name= "form" novalidate>
                            <div class="row">
                                                  <div class="col-12 text-center">
                                                          <img src="icon/exclamation-circle.svg" width="100" height="100" border ="0" id= "lista_oradores"/>
                                                                <h6 id="msjGuardado"></h6>
                                                                <button class=" btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>    
                                             
                                                     </div>
                                                                
                            </div>
                                                
                      </form>
                                        <!--pie modal-->
                                       
                      </div>
              </div>
          </div>  
      </div>    
            
            <div class="modal fade" id="modalBorrar">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" name= "form" novalidate>
                            <div class="row">
                                                  <div class="col-12 text-center">
                                                          <img src="icon/exclamation-circle.svg" width="100" height="100" border ="0" id= "lista_oradores"/>
                                      <h6>Esta Seguro?</h6>
                                                                <h6>Si elimina los datos no los podra volver a recuperar</h6>
                                                                <button class=" btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button> <button class=" btn btn-danger" id="borrAsunt" name ="" aria-label="Close">Borrar</button>        
                                             
                                                     </div>
                                                                
                            </div>
                                                
                      </form>
                                        <!--pie modal-->
                                       
                      </div>
              </div>
          </div>  
      </div>
            
<div class="modal fade" id="modalFuncionario" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content borde1">
        <!--Cabecera-->
        <div class="modal-header align-self-center">



          <div class="card">
            <div class="card-header">
              <img src="icon/search.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Buscar</strong>

            </div>
            <div class="card-body">
              <div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label id="cedTit" style="display:block">Cedula</label>

                      <input type="text" name="cedulaBuscar" id="cedulaBuscar" class="form-control" value="" placeholder="Numero de cedula" style="display:block">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nombre</label>
                      <input type="text" name="nombreBuscar" id="nombreBuscar" class="form-control" value="" placeholder="Ingrese Nombre">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Apellido</label>
                      <input type="text" name="apellidoBuscar" id="apellidoBuscar" class="form-control" value="" placeholder="Ingrese Apellido">
                    </div>
                  </div>
                  <div class="col-sm-12 align-self-end">
                    <div class="form-group">
                      <button class=" btn btn-primary " id="botBuscador1"><img src="icon/searchwhite.svg" width="20" height="20" border="0" /> Buscar</button>
                      <button class=" btn btn-danger " name="limpiar" id="limpiar"><img src="icon/arrow-repeat.svg" width="20" height="20" border="0" id="lista_oradores" /> Limpiar</button>
                      <button class=" btn btn-danger " name="prueba" id="prueba" data-toggle="modal" data-target="#modalCheck"><img src="icon/arrow-repeat.svg" width="20" height="20" border="0" id="lista_oradores" /> prueba</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!--body-->
        <div class="modal-body">

          <table id="tabla_orador" name="tabla_orador" class="table table-hover table-bordered">
            <thead align="center">
              <tr>
                <th><b class="text">Codigo Funcionario</b></th>
                <th><b class="text">Cedula</b></th>
                <th><b class="text">Nombre y Apellido</b></th>
                <th><b class="text">Cargo</b></th>
                <th><b class="text">Seleccionar</b></th>

              </tr>
            </thead>
            <tbody id="bodyTab">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tbody>
          </table>


        </div>
        <!--pie modal-->
        <div class="modal-footer text-left text-justify text">

        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="modalSector">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <div class="modal-header">

                                <div class="card">
                                  <div class="card-header">
                                    <img src="icon/plus-circle.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Agregar Sector</strong>

                                  </div>
                                  <div class="card-body">
                                    <div>
                                      <div class="row">
                                        <div class="col-sm-8">
                                          <div class="form-group">
                                            <label>Descripcion</label>
                                            <input type="text" name="descripcionSector" id="descripcionSector" class="form-control" value="" placeholder="Ingrese Descripcion">
                                          </div>
                                        </div>
                                        <div class="col-sm-4 align-self-end">
                                          <div class="form-group">
                                            <button class=" btn btn-dark " id="agregar2">Agregar</button>
                                            
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>






                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" method="post" action="guardarDip.php" name= "form" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tabla_sector" name="tabla_sector" class="table table-hover table-bordered">
                                      <thead align="center">
                                        <tr>
                                          <th><b class="text">Codigo</b></th>
                                          <th><b class="text">Descripcion</b></th>
                                          <th><b class="text">Accion</b></th>
                                        </tr>
                                      </thead>
                                      <tbody id="bodyDestino">
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                      </tbody>
                                    </table>  
                                                                
                                </div>
                            </div>
                      </form>
                                        <!--pie modal-->
                                        <div class="modal-footer text-left text-justify text">
                                                                        
                                         </div>
                      </div>
              </div>
          </div>  
      </div>

  <div class="modal fade" id="modalCategoria">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <div class="modal-header">

                                <div class="card">
                                  <div class="card-header">
                                    <img src="icon/plus-circle.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Agregar Categoria</strong>

                                  </div>
                                  <div class="card-body">
                                    <div>
                                      <div class="row">
                                        <div class="col-sm-8">
                                          <div class="form-group">
                                            <label>Descripcion</label>
                                            <input type="text" name="descripcionCategoria" id="descripcionCategoria" class="form-control" value="" placeholder="Ingrese Descripcion">
                                          </div>
                                        </div>

                                      </div>
                                      <div class="row">
                                        <div class="col-sm-8">
                                          <div class="form-group">
                                            <label>Monto</label>
                                            <input type="text" name="montoCategoria" id="montoCategoria" class="form-control" value="" placeholder="Monto">
                                          </div>
                                        </div>
                                        <div class="col-sm-4 align-self-end">
                                          <div class="form-group">
                                            <button class=" btn btn-dark " id="agregar1">Agregar</button>
                                            
                                          </div>
                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>






                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" method="post" action="guardarDip.php" name= "form" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tabla_categoria" name="tabla_categoria" class="table table-hover table-bordered">
                                      <thead align="center">
                                        <tr>
                                          <th><b class="text">Codigo</b></th>
                                          <th><b class="text">Monto</b></th>
                                          <th><b class="text">Descripcion</b></th>
                                          <th><b class="text">Accion</b></th>
                                        </tr>
                                      </thead>
                                      <tbody id="bodyTipo">
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                      </tbody>
                                    </table>  
                                                                
                                </div>
                            </div>
                      </form>
                                        <!--pie modal-->
                                        <div class="modal-footer text-left text-justify text">
                                                                        
                                         </div>
                      </div>
              </div>
          </div>  
      </div>



      <div class="modal fade" id="modalMedidor">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <div class="modal-header">

                                <div class="card">
                                  <div class="card-header">
                                    <img src="icon/plus-circle.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Agregar Medidor</strong>

                                  </div>
                                  <div class="card-body">
                                    <div>
                                      <div class="row">
                                        <div class="col-sm-8">
                                          <div class="form-group">
                                            <label>Codigo Medidor</label>
                                            <input type="text" name="descripcionMedidor" id="descripcionMedidor" class="form-control" value="" placeholder="Ingrese codigo medidor">

                                          </div>
                                          <label id="medidormensaje" name="medidormensaje" class="btn-danger" style="display:none">Ya existe ese codigo de Medidor!!!</label>
                                        </div>
                                        <div class="col-sm-4 align-self-end">
                                          <div class="form-group">
                                            <button class=" btn btn-dark " id="agregarMedidor">Agregar</button>
                                            
                                          </div>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>






                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" method="post" action="#" name= "form" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <table id="tabla_medidor" name="tabla_medidor" class="table table-hover table-bordered">
                                      <thead align="center">
                                        <tr>
                                          <th><b class="text">Codigo Medidor</b></th>
                                          <th><b class="text">Accion</b></th>
                                        </tr>
                                      </thead>
                                      <tbody id="bodyMedidor">
                                          <td></td>
                                          <td></td>
                                      </tbody>
                                    </table>  
                                                                
                                </div>
                            </div>
                      </form>
                                        <!--pie modal-->
                                        <div class="modal-footer text-left text-justify text">
                                                                        
                                         </div>
                      </div>
              </div>
          </div>  
      </div>

            <div class="modal fade" id="modalEditar">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <!--body-->
                              <div class="modal-body">
                      <form class="needs-validation" id="form" enctype="multipart/form-data" name= "form" novalidate>
                            <div class="row">
                                                  <div class="col-12 text-center">
                                                          <img src="icon/exclamation-circle1.svg" width="100" height="100" border ="0" id= "lista_oradores"/>
                                      <h6>Esta Seguro?</h6>
                                                                <h6>Archivar Documento</h6>
                                                                <button class=" btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button> <button class=" btn btn-success" id="archivarBtn" name ="" aria-label="Close">Archivar</button>        
                                             
                                                     </div>
                                                                
                            </div>
                                                
                      </form>
                                        <!--pie modal-->
                                       
                      </div>
              </div>
          </div>  
      </div>
            
            
  </div>
</div>    




















<!--****************************************************termina el contenido**********************************************************************-->   
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <!-- para usar botones en datatables JS -->  
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
     
    <!-- código JS propìo-->    
    <script src="scripts/addModifGastosFijosXFactura.js"></script>  
    
    
  </body>
</html>
