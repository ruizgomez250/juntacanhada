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
           
<style type="text/css">
.bi::before {
  display: inline-block;
  content: "";
  background-image: url("data:image/svg+xml,<svg viewBox='0 0 16 16' fill='%C82333' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z' clip-rule='evenodd'/></svg>");
  background-repeat: no-repeat;
  background-size: 1rem 1rem;
}
	.fondo{
		background-color:#3EAEB5;
		/*text-align:center;*/
		/*height: 50px;*/
	}
	
	.borde3{
		/*height:50px;*/
		text-align:center;
		background-color:olivedrab;
	}
	.txtWhite{
		color: #FFFFFF;
	}
	
	.txtBlue{
		color: #007BFF;
	}
</style>

    <title>Ver Pago</title>
  </head> 
  <body>


<!--*******************************************************Empieza el contenido****************************************************************-->
  



  <?php 
	 include('../config/conexion.php');
	 $conexion = conexion_db();
  $modificar=0;
  $cedula='';
  $nombre='';
  $apellido='';
  $telefono='';
  $telefono1='';
  $direccion='';
  $codSector='';
  $sector='';
  $codCateg='';
  $categoria='';
  $medidor1='';
  if(isset($_GET['moadfnmgvlfjhdif'])){
    $modificar = $_GET['moadfnmgvlfjhdif'];
    $sql = "SELECT cli.nombre,cli.apellido,cli.direccion,cli.telefono,cli.cedula,cli.estado,cli.telefono1,cli.id_categoria,cat.descripcion,cli.id_sector,sector.descripcion,cli.id_medidor
      FROM cliente cli 
      inner join categoria cat on cat.id = cli.id_categoria
      inner join opcion sector on sector.id = cli.id_sector
      WHERE cli.id = ".$modificar.";";
      $stmt = pg_exec($conexion, $sql );
			while( $row = pg_fetch_array( $stmt) ) {
				$cedula=$row['cedula'];
			  $nombre=$row['nombre'];
			  $apellido=$row['apellido'];
			  $telefono=$row['telefono'];
			  $telefono1=$row['telefono1'];
			  $direccion=$row['direccion'];
			  $codSector=$row['id_sector'];
			  $sector=$row[10];
			  $codCateg=$row['id_categoria'];
			  $categoria=$row[8];
			  $medidor=$row['id_medidor'];

			  $sql1 = "SELECT codigo_medidor FROM medidor where  id=".$medidor.";";
				$resultado1 = pg_query($conexion,$sql1);
				$res1 = pg_fetch_row($resultado1);
				$medidor1 = $res1[0];
			}
  }
  $paginaGuardado='';
  if($modificar == 0){
    $paginaGuardado='../php/Cliente.php?op=guardar';
  }else{
    $paginaGuardado='../php/Cliente.php?op=modificar&id='.$_GET['moadfnmgvlfjhdif'];
  }
  echo('<input id="modificarVerif" name="modificarVerif" value ="'.$modificar.'" style="display:none">');
  $sql = "SELECT cli.id,cli.cedula,cli.nombre,cli.apellido,cli.telefono,cli.telefono1,cat.descripcion,sector.descripcion,medid.codigo_medidor 
      FROM cliente cli 
      inner join categoria cat on cat.id = cli.id_categoria
      inner join opcion sector on sector.id = cli.id_sector
      inner join medidor medid on medid.id = cli.id_medidor order by cli.id;";
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
			  $medidor2=$row[8];
			  $verif='';
			  $documento='';
			  $bodyTablaPermiso=('<tr><td class="text-center ">'.$id1.'</td>
	     										<td class="text-center ">'.$cedula1.'</td>
	     										<td class="text-center ">'.$nombre1.' '.$apellido1.'</td>
												<td>'.$telefono3.'</td>
												<td>'.$telefono4.'</td>
												<td class="text-center ">'.$categoria1.'</td>
												<td class="text-center ">'.$medidor2.'</td>
												<td class="text-center ">'.$sector1.'</td>
												
												<td class="text-left">
													
														<button  name='.$id1.' class="ieditar btn-success btn-sm"><img class="imagen" style="cursor:pointer;"  src="icon/Check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Seleccionar"/></button>
														
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
				<h2 class="txtBlue text-center">Ver Orden de Pago por Usuario</h2>
			  			<hr>
			  			<div class="card">
							<div class="card-header text-center">
								<h3><strong>Listado</strong></h3>
							</div>
						
					<div class="card-body">
						
						
			  		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    	<thead align="center">
                        	<tr class="fondo">
								<th class="txtWhite"><b>Codigo</b></th>
								<th class="txtWhite"><b>Cedula</b></th>
								<th class="txtWhite"><b>Nombre y Apellido</b></th>
								<th class="txtWhite"><b>Telefono</b></th>
                <th class="txtWhite"><b>Telefono</b></th>
                <th class="txtWhite"><b>Sector</b></th>
                <th class="txtWhite"><b>Medidor</b></th>
                <th class="txtWhite"><b>Categoria</b></th>
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



<div class="modal fade" id="modalTomaMedida">
    <div class="modal-dialog modal-lg">
      <div class="modal-content borde1">
        <!--Cabecera-->
        <div class="modal-header align-self-center">



          

          <div class="card">
            <div class="card-header">
              <img src="icon/card-heading.svg" width="25" height="25" border="0" id="buscarCod" /> <strong>Seleccione la fecha de la orden de pago</strong>

            </div>
           
          </div>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!--body-->
        <div class="modal-body">
            
                <div class="row">
                 
                  <div class="col-12 align-self-end">
                    <div class="form-group">
                      


                      	<div class="card">
													<div class="card-header text-center">
														<h3><strong>Orden de pago emitido por fechas</strong></h3>
													</div>
												
											<div class="card-body">
												
												
									  		<table id = "tablaModalFech" class="table table-hover table-bordered">
                    			<thead align="center">
                        	<tr class="fondo">
													<th class="txtWhite"><b>Fecha de Emision</b></th>
													<th class="txtWhite"><b>Fecha de Vencimiento</b></th>
													<th class="txtWhite"><b>Accion</b></th>
					                        	</tr>
					                        </thead>
					                        <tbody id="tablaModBody">
																	</tbody>
                    	</table>
											</div>
										</div>

                      
                    </div>
                  </div>
                </div>


        </div>
        <!--pie modal-->
        <div class="modal-footer text-left text-justify text">

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
						<div class="modal-dialog modal-lg ">
    							<div class="modal-content borde1">
            							<!--Cabecera-->
                   					 	<div class="modal-header">

                   					 		<h3>Seleccionar Categoria</h3>





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
													                <th><b class="text">Descripcion</b></th>
													                <th><b class="text">Costo Minimo</b></th>
													                <th><b class="text">Litros Minimo</b></th>
													                <th><b class="text">Costo Por Litro</b></th>
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
    <script src="scripts/verOrdenDePagoUsuario.js"></script>
		
   
  </body>
</html>