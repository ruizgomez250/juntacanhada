<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Menu Principal</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<?php 
    session_start();
    if(!$_SESSION['junta']==1){
      if($_SESSION['sesIniciada'] != 1){
        header("Location: ../../index.php");
      } 
    } 
?>
<div class="wrapper">
  <!-- Navbar -->
  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
          </a>
                  
        </div>

      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item menu-open">

            <a href="#" class="nav-link" >
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#globe"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Junta Cañada Garay
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../ajax/usuario.php?op=salir"  class="nav-link" >
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#stop"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Salir del sistema
                      </p>
                </a>
              </li>
              
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="escritorio.php" id="salir" class="nav-link" >
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#house"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Inicio
                      </p>
                </a>
              </li>
              
            </ul>
            
          </li>
          <li class="nav-item menu-open">

            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#people"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Usuarios
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addModifCliente.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#person-plus"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                        Agregar/Modificar
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="asignarOrden.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#person-plus"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                        Asignar Orden
                      </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#ui-radios-grid"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Lectura por Usuario
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addModifTomaMedida.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#droplet"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Tomar Lectura
                      </p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#journal-check"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Categoria
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addModifCategoria.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#journal-plus"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Agregar/Modificar
                      </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#cash"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Costos Fijos por Factura
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="addModifGastosFijosXfactura.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#cash-stack"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Agregar/Modificar
                      </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#wallet2"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Costos por Usuario
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Gastos.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#cash-stack"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Agregar/Modificar Costo
                      </p>
                </a>
                <a href="asignarCostoUsuario.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#person"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Asignar Costo a Usuario
                      </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#card-heading"/>
              </svg>
              <i class="nav-icon"></i>
              <p>
                Orden de Pago
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="factura.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#card-text"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Generar
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="verOrdenDePagoUsuario.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#person-check"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Orden de Pago Usuario
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cargarPago.php" class="nav-link">
                  <svg class="bi" width="15" height="15" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#wallet2"/>
                  </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Cargar Pago
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="verFacturasUsuario.php" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#card-heading"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Facturas/Usuario
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../reportes/UsuariosPendientemayor2.php" target="_blank" class="nav-link">
                  <svg class="bi sm-1 text-secondary" width="15" height="15" fill="currentColor">
                      <use xlink:href="icon/bootstrap-icons.svg#card-heading"/>
                    </svg>
                    <i class="nav-icon"></i>
                      <p> 
                          Deudas mayores a 2 Ordenes 
                      </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="motor.php" class="nav-link">
                  <svg class="bi" width="20" height="20" fill="currentColor">
                        <use xlink:href="icon/bootstrap-icons.svg#card-heading"/>
                  </svg>
                  <i class="nav-icon"></i>
                  <p>
                    Motor
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
              </li>
            </ul>
          </li>
          
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->


  <!-- Control Sidebar -->
    <aside class="control-sidebar  " >
      <!-- Control sidebar content goes here -->
    </aside>

  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
</body>
</html>
