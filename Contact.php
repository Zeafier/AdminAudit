<?php
session_start();
include "./Database/databaseconnect.php";
include "./logcheck/logincheck.php";
check_login();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./Contact.php" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="../logcheck/logout.php" class="nav-link"><button type="submit" class="btn btn-danger btn-block">Logout</button></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/NewLogo.png" alt="Audit Admin" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Audits Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="./user-pass.php" class="d-block"><?php print $_SESSION['login']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Home Dashboard -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
                <?php if($_SESSION['isadmin'] == 1){ ?>
              <li class="nav-item">
                <a href="./Users/Log_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li><?php } ?>
              <li class="nav-item">
                <a href="./Devices/general_audit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="./Decomission/current_dec.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Decomission</p>
                </a>
              </li>
                <li class="nav-item">
                    <a href="./Orders/current_orders.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Orders</p>
                    </a>
                </li>
            </ul>
          </li>
            <?php if($_SESSION['isadmin'] == 1){ ?>
            <!--Users -->
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./Users/Log_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Log users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Users/staff_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Users/dep_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Departments</p>
                </a>
              </li>
            </ul>
          </li><?php } ?>
            <!--Devices -->
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Audits
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./Devices/general_audit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General audit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Devices/pcname.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PC names</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Devices/printer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Printers audit</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="./Devices/projector.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projectors</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="./Devices/devices.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
            </ul>
          </li>
             <!--Decomission -->
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-ban"></i>
              <p>
                Decomission
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./Decomission/current_dec.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Current decomissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Decomission/past_dec.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Past decomissions</p>
                </a>
              </li>
            </ul>
          </li>
            <!--Orders -->
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./Orders/current_orders.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Current orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Orders/pricing.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pricing and QTY</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./Orders/past_orders.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Past orders</p>
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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Contact</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item active">Contact</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
              <div class="col-md-12">
                    <!-- Main row -->
                     <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0">
                          Inventry
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-7">
                              <h2 class="lead"><b>Admin Asset</b></h2>
                              <p class="text-muted text-sm"><b>About: </b> We are the webstie to assist you with your daily assets.<br><br>

                                 <center> Excellent</center> </p>
                              <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Beckton, London</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: 0207 700 700</li>
                              </ul>
                            </div>
                            <div class="col-5 text-center">
                              <img src="./dist/img/NewLogo.png" alt="" class="img-circle img-fluid">
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.3-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>