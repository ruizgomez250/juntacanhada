 <?php 
if (strlen(session_id())<1) 
  session_start();

  ?>
 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Junta | Escritorio</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->

  <link rel="stylesheet" href="../public/css/font-awesome.min.css">

  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <!-- Morris chart --><!-- Daterange picker -->
<!-- DATATABLES-->
<link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
<link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
<link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
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
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="escritorio.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Junta</b> </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Junta</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">NAVEGACIÓM</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">

                
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

<br>
       <?php 
       echo ' <li><a href="escritorio.php"><i class="fa  fa-dashboard (alias)"></i> <span>Escritorio Facturacion</span></a>
              </li>';    
if(isset($_SESSION['impuesto'])){
      if ($_SESSION['impuesto']==1) {
        echo ' <li class="treeview">
              </li>
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-money"></i> <span>Impuesto</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="addModifImpuesto.php"><i class="fa fa-circle-o"></i> Agregar/Modificar</a></li>
                  <li><a href="corregirFactura.php"><i class="fa fa-circle-o"></i> Corregir Factura</a></li>
                </ul>
              </li>';
      }
  }
  if(isset($_SESSION['cuentascont'])){
      if ($_SESSION['cuentascont']==1) {
        echo ' <li class="treeview">
                <a href="#">
                  <i class="fa fa-list"></i> <span>Contabilidad</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="cuentasCompras.php"><i class="fa fa-circle-o"></i> Cuentas a utilizar</a></li>
                  <li><a href="asignarCuentas.php"><i class="fa fa-circle-o"></i>Asignar Cuentas</a></li>
                  <li><a href="crearCuentas.php"><i class="fa fa-circle-o"></i>Crear Cuentas</a></li>
                  <li><a href="agregarTimbrado.php"><i class="fa fa-circle-o"></i>Agregar Timbrado</a></li>
				  <li><a href="asientosContables.php"><i class="fa fa-circle-o"></i>Asientos Contables</a></li>
                  <li><a href="borrarDeudaAnt.php"><i class="fa fa-circle-o"></i>Borrar Deuda Anterior</a></li>
                  <li><a href="anularFactura.php"><i class="fa fa-circle-o"></i>Anular Factura</a></li>
                  <li><a href="rg90ventas.php"><i class="fa fa-circle-o"></i>RG90 Ventas</a></li>
                </ul>
                
              </li>';
      }
  }
  if(isset($_SESSION['bancos'])){
      if ($_SESSION['bancos']==1) { 
          echo '<li class="treeview">
                <a href="#">
                  <i class="fa fa-bank"></i> <span>Bancos</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="banco.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
                </ul>                
              </li>';
      }
  }
if(isset($_SESSION['mercaderias'])){
      if ($_SESSION['mercaderias']==1) {
           echo '<li class="treeview">
                <a href="#">
                  <i class="fa fa-cubes"></i> <span>Mercaderias</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="articulo.php"><i class="fa fa-circle-o"></i> Articulos</a></li>
                  <li><a href="categoria.php"><i class="fa fa-circle-o"></i> Categorias</a></li>
                </ul>
              </li>';
      }
  }
if(isset($_SESSION['compras'])){
      if ($_SESSION['compras']==1) {
        echo ' <li class="treeview">
                <a href="#">
                  <i class="fa fa-th"></i> <span>Compras</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="ingreso.php"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                  <li><a href="ordenDePago.php"><i class="fa fa-circle-o"></i> Orden de Pago</a></li>
                  <li><a href="proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                </ul>
              </li>';
      }
}
if(isset($_SESSION['remisionmerc'])){
      if ($_SESSION['remisionmerc']==1) {
            echo ' <li class="treeview">
              <a href="#">
                  <i class="fa fa-list-ol"></i> <span>Entregar Insumos</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
              <ul class="treeview-menu">
                <li><a href="entregaInsumos.php"><i class="fa fa-circle-o"></i>Entrega de Insumos</a></li>
                <li><a href="encargados.php"><i class="fa fa-circle-o"></i>Agregar/Modificar Encargados</a></li>
              </ul>
            </li>';
      }
}
if(isset($_SESSION['extracto'])){
      if ($_SESSION['extracto']==1) {
        echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i> <span>Generar Extracto</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="generar.php"><i class="fa fa-circle-o"></i> Extracto Usuarios</a></li>
                
              </ul>
            </li>';
      }
  }
if(isset($_SESSION['ventas'])){
      if ($_SESSION['ventas']==1) {
        echo '<li class="treeview">
                <a href="#">
                  <i class="fa fa-shopping-cart"></i> <span>Caja</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="caja.php"><i class="fa fa-circle-o"></i> Caja</a></li>
                  <li><a href="arqueoCaja.php"><i class="fa fa-circle-o"></i>Arqueo de Caja</a></li>
                  <li><a href="notaCredito.php"><i class="fa fa-circle-o"></i>Nota de Credito</a></li>
                  
                </ul>
              </li>';
      }
  }
if(isset($_SESSION['acceso'])){
    if ($_SESSION['acceso']==1) {
      echo '  <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li><a href="permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['zonasusu'])){
    if ($_SESSION['zonasusu']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-map-marker"></i> <span>Zonas de Usuarios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="zonas.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['categusu'])){
    if ($_SESSION['categusu']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-address-book"></i> <span>Categorias de Usuarios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="categoriaUsuario.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['situacionusu'])){
    if ($_SESSION['situacionusu']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Situacion de Usuarios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="situacionUsuario.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['usuariosjunta'])){
    if ($_SESSION['usuariosjunta']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>Usuarios de la Junta</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="cliente.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['costosfactura'])){
    if ($_SESSION['costosfactura']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-ruble"></i> <span>Costos Fijos por Factura</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="costosFactura.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['costosusuario'])){
    if ($_SESSION['costosusuario']==1) {
      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-credit-card"></i> <span>Costos por Usuarios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="costos.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
                <li><a href="costosCliente.php"><i class="fa fa-circle-o"></i>Asignar Costo</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>Funcionarios de la Junta</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="funcionario.php"><i class="fa fa-circle-o"></i>Agregar/Modificar</a></li>
                <li><a href="costosCliente.php"><i class="fa fa-circle-o"></i>Asignar Costo</a></li>
              </ul>
            </li>';
    }
}
if(isset($_SESSION['lecturamedidor'])){
    if ($_SESSION['lecturamedidor']==1) {
      
      
        
        
        
        
        
        echo '<li class="treeview">
              <a href="#">
                <i > <svg class="bi" width="20" height="20" fill="currentColor">
                    <use xlink:href="icon/bootstrap-icons.svg#ui-radios-grid"/>
              </svg></i> <span>Lectura Medidor</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="tomarLectura.php"><i class="fa fa-circle-o"></i>Tomar Lectura</a></li>
                <li><a href="modificarLectura.php"><i class="fa fa-circle-o"></i>Modicar Lectura</a></li>
              </ul>
            </li>';
    }
}
        ?>  
                                     <?php

      echo ' <li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Reporte Facturas</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="reporteparaErssan.php"><i class="fa fa-circle-o"></i>Facturas por fechas</a></li>
              </ul>
            </li>
            ';

      echo '<li class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Facturas Emitidas</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="consultaCaja.php"><i class="fa fa-circle-o"></i>Facturas no pagadas y anuladas</a></li>
              </ul>
              <ul class="treeview-menu">
                <li><a href="consultaCaja.php"><i class="fa fa-circle-o"></i>Facturas no pagadas y anuladas</a></li>
              </ul>
            </li>';
    
        ?> 
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>