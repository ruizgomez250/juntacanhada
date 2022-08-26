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

  /*****************carga el modal usuario*****************/
  $cuerpoClientes='';
  $sql = "SELECT cli.id,cli.cedula,cli.nombre,cli.apellido,cli.telefono,cli.telefono1,cat.descripcion,sector.descripcion,medid.codigo_medidor FROM cliente cli inner join categoria cat on cat.id = cli.id_categoria inner join opcion sector on sector.id = cli.id_sector inner join medidor medid on medid.id = cli.id_medidor ";
        $stmt = pg_exec($conexion, $sql );
        $bodyTablaPermiso=null;
        while( $row = pg_fetch_array( $stmt) ) {
                $id1=$row['id'];
                $cedula1=$row['cedula'];
                $nombre1=$row['nombre'];
                $apellido1=$row['apellido'];
                $telefono3=$row['telefono'];
                $telefono4=$row['telefono1'];
                $sector1=$row[6];
                $categoria1=$row[7];
                $medidor=$row[8];

                $verif='<button  name="'.$id1.'" class="ieditar1 btn-sm btn-success "><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar" /></button>';
                if(isset($_GET['medida'])){
                  $verif='<button  name="'.$medidor.'" class="ieditar btn-sm btn-primary "><img class="imagen" style="cursor:pointer;"  src="icon/droplet.svg" width="20" height="20" border ="0" id= "editar" title="Tomar Medida" /></button>';
        }
        $documento='';
        $cuerpoClientes='<tr><td class="text-center ">'.$id1.'</td>
                          <td class="text-center ">'.$cedula1.'</td>
                          <td class="text-center ">'.$nombre1.' '.$apellido1.'</td>
                        <td class="text-center ">'.$sector1.'</td>
                        <td class="text-center ">'.$categoria1.'</td>
                        <td class="text-left">
                          
                            '.$verif.$documento.'
                        </td>
                        </tr>'.$cuerpoClientes;

          }
  
  /**************fin carga Modal******************/

  if(isset($_GET['moadfnmgvlfjhdif'])){
    $modificar = $_GET['moadfnmgvlfjhdif'];
    $sql = "SELECT cost.id,cost.cantidad_pagos,cost.numero_de_pago,cli.id,cli.nombre,cli.apellido,costDet.descripcion,costDet.monto_total,cli.cedula,costDet.id
      FROM costos_x_cliente cost 
      INNER JOIN cliente cli on cli.id=cost.id_usuario
      INNER JOIN costo costDet on costDet.id=cost.id_costo
      WHERE cost.id = $modificar;";
      $stmt = pg_exec($conexion, $sql );
      while( $row = pg_fetch_array( $stmt) ) {
        $id1=$row[0];
        $cantPagos1=$row[1];
        $numPago1=$row[2];
        $codUsu1=$row[3];
        $nombre1=$row[4];
        $apellido1=$row[5];
        $detalleCosto1=$row[6];
        $montoTotal1=$row[7];
        $cedula1=$row[8];
        $idCosto1=$row[9];
      }
  }
  $paginaGuardado='';
  if($modificar == 0){
    $paginaGuardado='../php/AsignarCostoUsuario.php?op=guardar';
  }else{
    $paginaGuardado='../php/AsignarCostoUsuario.php?op=modificar&id='.$_GET['moadfnmgvlfjhdif'];
  }
  echo('<input id="modificarVerif" name="modificarVerif" value ="'.$modificar.'" style="display:none">');
  echo('<input id="modificarVerif" name="porcentajeVerif" value ="'.$esPorcentaje1.'" style="display:none">');

  $sql = "SELECT cost.id,cost.cantidad_pagos,cost.numero_de_pago,cli.id,cli.nombre,cli.apellido,costDet.descripcion,costDet.monto_total
      FROM costos_x_cliente cost 
      INNER JOIN cliente cli on cli.id=cost.id_usuario
      INNER JOIN costo costDet on costDet.id=cost.id_costo
      WHERE cost.estado=1;";
  $stmt = pg_exec($conexion, $sql );
  $bodyTablaPermiso=null;
  while( $row = pg_fetch_array( $stmt) ) {
        $id=$row[0];
        $cantPagos=$row[1];
        $numPago=$row[2];
        $codUsu=$row[3];
        $nombre=$row[4];
        $apellido=$row[5];
        $detalleCosto=$row[6];
        $montoTotal=$row[7];
        $formatearMonto=0;
        if($cantPagos != 0){
          $formatearMonto=round($montoTotal/$cantPagos);
        }
        
        $modif='';
        if($numPago == 0){
          $modif='<a href="asignarCostoUsuario.php?moadfnmgvlfjhdif='.$id.'"><button  name='.$id.' class="ieditar btn-success btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button></a>';
        }
        
        $documento='';
        if($cantPagos > $numPago){
          $bodyTablaPermiso=('<tr><td class="text-center ">'.$codUsu.'</td>
                          <td class="text-center ">'.$nombre.' '.$apellido.'</td>
                          <td class="text-center ">'.number_format($montoTotal,0,",",".").'</td>
                          <td class="text-center ">'.$detalleCosto.'</td>
                          <td class="text-center ">'.$numPago.'/'.$cantPagos.'</td>
                          <td class="text-center ">'.number_format($formatearMonto,0,",",".").'</td>
                        
                        <td class="text-left">
                            '.$modif.$documento.'
                        </td>
                        </tr>').$bodyTablaPermiso;
        }

  }
  if(!isset($bodyTablaPermiso) ){
     $bodyTablaPermiso=('<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>');
  }
$sql = "SELECT id,descripcion,monto_total
      FROM costo WHERE not descripcion = 'Saldo Pago Anterior Cod.#s';";
  $stmt = pg_exec($conexion, $sql );
  $bodyTablaCosto=null;
  while( $row = pg_fetch_array( $stmt) ) {
        $id=$row['id'];
        $descripcion=$row['descripcion'];
        $monto=$row['monto_total'];
        $verif='';
        $documento='';
        $bodyTablaCosto=('<tr><td class="text-center ">'.$id.'</td>
                          <td class="text-center ">'.$descripcion.'</td>
                          <td class="text-center ">'.$monto.'</td>
                        
                        <td class="text-left">
                          
                            <button  name='.$id.' class="selecCosto btn-success btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>
                            
                            '.$verif.$documento.'
                        </td>
                        </tr>').$bodyTablaCosto;

  }




  include('menu.php');
?>
  



<div class="content-wrapper">
  <div class="container">

  
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <h2 class="txtBlue text-center">Asignar Costo a Usuario</h2>
        <div class="card">
              <div class="card-header">
                  <img src="icon/plus-circle.svg" width="25" height="25" border ="0" id= "buscarCod"/><?php if(isset($_GET['moadfnmgvlfjhdif']))echo('<a href="asignarCostoUsuario.php"> <button class="btn btn-sm btn-secondary">Nuevo</button></a>'); ?> 
              </div>
              <div class="card-body">
                

                <!-- /*agregar nuevo doc*/-->
                <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <form class=" inline-block" id="form" enctype="multipart/form-data" method="post" action="<?php echo ($paginaGuardado); ?>" name="  form" novalidate>
       

          <div class="row">
            <div class="col-md-2">
              <label for="cedul">
                <font style="vertical-align: inherit;">Usuario</font>
              </label>
              <div class="input-group mb-3">
                <input type="text" id="codUsuario" name="codUsuario" class="form-control text-center" placeholder="Codigo" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($codUsu1); ?> ">
                <div class="input-group-append">
                  <button id="buscUsuario" class="btn btn-secondary" type="button">...</button>
                </div>
              </div>
              <label id="funcmensaje" name="funcmensaje" class="btn-danger" style="display:none">El campo no puede estar vacio!!!</label>
            </div>
            <div class="col-md-2">
              <label for="cedul">
                
                <font style="vertical-align: inherit;">RUC/Cedula</font>
              </label>
              <input id="cedula" name="cedula" class="form-control text-center" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($cedula1); ?> " disabled>

            </div>
            <div class="col-md-4">
              <label for="cedul">
                <font style="vertical-align: inherit;">Nombre y Apellido</font>
              </label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($nombre1.' '.$apellido1); ?> " disabled>

            </div>


          </div>
          <div class="row">
            <div class="col-md-2">
              <label for="cedul">
                <font style="vertical-align: inherit;">Cod. Costo</font>
              </label>
              <div class="input-group mb-3">
                <input type="text" id="codCosto" name="codCosto" class="form-control text-center" placeholder="Codigo" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($idCosto1); ?> " >
                <div class="input-group-append">
                  <button id="buscCosto" class="btn btn-secondary" type="button">...</button>
                </div>
              </div>
              <label id="funcmensaje" name="funcmensaje" class="btn-danger" style="display:none">El campo no puede estar vacio!!!</label>
            </div>
            <div class="col-md-2">
              <label for="cedul">
                
                <font style="vertical-align: inherit;">Descripcion</font>
              </label>
              <input id="descCosto" name="descCosto" class="form-control text-center" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($detalleCosto1); ?> " disabled>

            </div>
            <div class="col-md-4">
              <label for="cedul">
                <font style="vertical-align: inherit;">Guaranies</font>
              </label>
              <input type="text" class="form-control" id="montoTot" name="montoTot" placeholder="" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($montoTotal1); ?> " disabled>

            </div>
          </div>
          <div class="row" >
            <div class="col-1" id="Funcionario5" >
              <label for="cedul" >
                <font style="vertical-align: inherit;">Pagos</font>
              </label>
              <input id="cantPago" name="cantPago" class="form-control text-center" type="text" value="<?php if(isset($_GET['moadfnmgvlfjhdif']))echo($cantPagos1); ?> " >

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
                <th class="txtWhite"><b>Cod. Usuario</b></th>
                <th class="txtWhite"><b>Nombre y Apellido</b></th>
                <th class="txtWhite"><b>Monto A facturar</b></th>
                <th class="txtWhite"><b>Descripcion</b></th>
                <th class="txtWhite"><b>Cuota</b></th>
                <th class="txtWhite"><b>Monto Cuotas</b></th>
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
            
<div class="modal fade" id="modalUsuario" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content borde1">
        <!--Cabecera-->
        <div class="modal-header align-self-center">



          <div class="card">
            <h3> Buscar Cliente</h3>
            
          </div>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!--body-->
        <div class="table-responsive">
            
            
            <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead align="center">
              <tr>
                <th><b class="text">Codigo Usuario</b></th>
                <th><b class="text">Cedula</b></th>
                <th><b class="text">Nombre y Apellido</b></th>
                <th><b class="text">Categoria</b></th>
                <th><b class="text">Sector</b></th>
                <th><b class="text">Seleccionar</b></th>

              </tr>
            </thead>
            <tbody id="bodyTab">
                <?php echo($cuerpoClientes); ?>
            </tbody>
          </table>


        </div>
        <!--pie modal-->
        <div class="modal-footer text-left text-justify text">

        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="modalCosto">
            <div class="modal-dialog ">
                  <div class="modal-content borde1">
                          <!--Cabecera-->
                              <div class="modal-header">
                                <h3 >Costo</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <!--body-->
                              <div class="modal-body">
                      
                            <div class="row">
                                <div class="col-12">
            
            
                                    <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                      <thead align="center">
                                        <tr>
                                          <th><b class="text">Codigo</b></th>
                                          <th><b class="text">Descripcion</b></th>
                                          <th><b class="text">Monto</b></th>
                                          <th><b class="text">Seleccionar</b></th>
                                        </tr>
                                      </thead>
                                      <tbody id="bodyDestino">
                                          <?php echo($bodyTablaCosto); ?>
                                      </tbody>
                                    </table>  
                                                                
                                </div>
                            </div>
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
    <script src="scripts/asignarCostoUsuario.js"></script> 
    
    
  </body>
</html>
