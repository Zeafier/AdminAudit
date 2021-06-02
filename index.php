<?php
session_start();
include "./Database/databaseconnect.php";
include "./logcheck/logincheck.php";
include "./functions/XSS.php";
include "./functions/cryp_decrypt.php";
use \Chirp\Cryptor;
check_login_main();
$encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5';
$crypt = new Cryptor($encryption_key);

//send message
if(isset($_POST['Send'])){
    $inserttext = clean($_POST['message']);
    $date = date("d/m/Y h:i:sa");
    $userid = $_SESSION['id'];
    //words to be disabled
    $word="fuck";
    $word1="fck";
    $word2="ass";
    $word3="nude";
    $word_array=array($word, $word1, $word2, $word3);
    $replace_array = array("****", "***", "***", "****");
    //check if fields are empty
    if(empty($inserttext)){
        echo "<script>alert('Text cannot be empty');</script>";
    }else{
        //check if words are matching and replace if necessary
        if(strpos($inserttext, $word) !== false || strpos($inserttext, $word1) !== false || strpos($inserttext, $word2) !== false || strpos($inserttext, $word3) !== false){
            $inserttext = str_replace($word_array, $replace_array, $inserttext);
        }
        $extra = "index.php";
        $inserttext = $crypt -> encrypt($inserttext);
        $msg = "INSERT INTO _chat_ (_uID_, _text_, _date_) VALUES (?, ?, ?)";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("iss", $userid, $inserttext, $date);
        if ($stmnt->execute()){
            $stmnt->close();
            unset($inserttext);
            echo "<script>window.location.href='".$extra."'</script>";
        }else{
            echo "<script>alert('Something went wrong');</script>";
            unset($inserttext);
            echo "<script>window.location.href='".$extra."'</script>";
        }
    }
}

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
        <a href="./logcheck/logout.php" class="nav-link"><button type="submit" class="btn btn-danger btn-block">Logout</button></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./index.php" class="brand-link">
      <img src="dist/img/NewLogo.png" alt="Audit Admin" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Audits Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="./user-pass.php" class="d-block"><?php print $_SESSION['login'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Home Dashboard -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
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
              </li> <?php } ?>
              <li class="nav-item">
                <a href="./Devices/general_audit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="./Decomission/decomission_item.php" class="nav-link">
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
            <?php 
                    if($_SESSION['isadmin'] == 1){ ?>
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
          </li> <?php }?>
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
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <?php
                    $msg = "SELECT COUNT(_oID_) FROM _orders_ WHERE _current_ = 1;";
                    $stmnt = $con->prepare($msg);
                    $stmnt -> execute();
                    $stmnt -> bind_result($ordercount);
                    $stmnt -> fetch();
                    $stmnt -> close()
                  ?>
                <h3><?php print clean($ordercount);?></h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="./Orders/current_orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
            <?php if($_SESSION['isadmin'] == 1){ ?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <?php
                    $msg = "SELECT COUNT(_sID_) FROM _staff_ WHERE _visible_ = 1;";
                    $stmnt = $con->prepare($msg);
                    $stmnt -> execute();
                    $stmnt -> bind_result($studentcount);
                    $stmnt -> fetch();
                    $stmnt -> close()
                  ?>
                <h3><?php print $studentcount;?></h3>

                <p>Staff Members</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="./Users/staff_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
            <?php } ?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                  <?php
                    $msg = "SELECT COUNT(_devID_) FROM _devices_;";
                    $stmnt = $con->prepare($msg);
                    $stmnt -> execute();
                    $stmnt -> bind_result($usercount);
                    $stmnt -> fetch();
                    $stmnt -> close()
                  ?>
                <h3><?php print $usercount;?></h3>

                <p>All devices</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="./Devices/general_audit.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                  <?php
                    $msg = "SELECT COUNT(_decID_) FROM _decomission_ WHERE _dec_visible_ = 1;";
                    $stmnt = $con->prepare($msg);
                    $stmnt -> execute();
                    $stmnt -> bind_result($deccount);
                    $stmnt -> fetch();
                    $stmnt -> close()
                  ?>
                <h3><?php print $deccount; ?></h3>

                <p>Current decomission items</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="./Decomission/decomission_item.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
          
          
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            

            <!-- DIRECT CHAT -->
            <div class="card direct-chat direct-chat-primary">
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <?php 
                        $msg = "SELECT _name_, _username_, _surname_, _text_, _date_ FROM _chat_ INNER JOIN _user_log_ ON _chat_._uID_=_user_log_._uID_ INNER JOIN _staff_ ON _staff_._sID_=_user_log_._staff_id_ INNER JOIN _name_ ON _staff_._name_id_=_name_._nID_ ORDER BY _cID_ DESC LIMIT 30;";
                        $stmnt = $con->prepare($msg);
                        $stmnt -> execute();
                        $stmnt -> bind_result($name, $uname, $surname, $text, $date);
                        while ($stmnt -> fetch()){
                            $cryptor = new Cryptor($encryption_key);
                            $text = $cryptor->decrypt($text);
                            
                            if($uname == $_SESSION['login']){?>
                                <!-- Message to the right -->
                                  <div class="direct-chat-msg right">
                                    <div class="direct-chat-infos clearfix">
                                      <span class="direct-chat-name float-right"><?php print clean($name)?> <?php print clean($surname)?></span>
                                      <span class="direct-chat-timestamp float-left"><?php print clean($date)?></span>
                                    </div>
                                    <!-- /.direct-chat-infos -->
                                    <div class="direct-chat-text">
                                      <?php print clean($text)?>
                                    </div>
                                    <!-- /.direct-chat-text -->
                                  </div>
                                  <!-- /.direct-chat-msg -->
                            <?php }else{ ?>
                                <!-- Message. Default to the left -->
                                  <div class="direct-chat-msg">
                                    <div class="direct-chat-infos clearfix">
                                      <span class="direct-chat-name float-left"><?php print clean($name)?> <?php print clean($surname)?></span>
                                      <span class="direct-chat-timestamp float-right"><?php print clean($date)?></span>
                                    </div>
                                    <!-- /.direct-chat-infos -->
                                    <div class="direct-chat-text">
                                      <?php print clean($text)?>
                                    </div>
                                    <!-- /.direct-chat-text -->
                                  </div>
                                  <!-- /.direct-chat-msg -->
                            <?php }
                        }
                    ?>
                </div>
                <!--/.direct-chat-messages-->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form method="post" role="form" onsubmit="" action="">
                  <div class="input-group">
                    <input type="text" name="message" placeholder="Type Message ..." class="form-control" maxlength="100" required>
                    <span class="input-group-append">
                      <button type="submit" name="Send" id="Send" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->

            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Visitors
                </h3>
              </div>
              <!-- /.card-body-->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.card -->

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu float-right" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
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
