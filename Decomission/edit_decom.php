<?php
session_start();
include "../Database/databaseconnect.php";
include "../logcheck/logincheck.php";
check_login();
isadmin();
include "../functions/decom_function.php";
use \Chirp\Cryptor;
$encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5';
$crypt = new Cryptor($encryption_key);
    
$decomadd = new updatedecom();
$decomadd -> update($con);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Decomission</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select booststrap-->
    <link href="//netdna.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css" />
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
        <a href="../index.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../Contact.php" class="nav-link">Contact</a>
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
    <a href="../index.php" class="brand-link">
      <img src="../dist/img/NewLogo.png" alt="Audit Admin" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Audits Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="../user-pass.php" class="d-block"><?php print $_SESSION['login'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Home Dashboard -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
                <?php if($_SESSION['isadmin'] == 1){ ?>
              <li class="nav-item">
                <a href="../Users/Log_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li><?php }?>
              <li class="nav-item">
                <a href="../Devices/general_audit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="../Decomission/current_dec.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Decomission</p>
                </a>
              </li>
                <li class="nav-item">
                    <a href="../Orders/current_orders.php" class="nav-link">
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
                <a href="../Users/Log_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Log users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Users/staff_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Users/dep_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Departments</p>
                </a>
              </li>
            </ul>
          </li><?php }?>
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
                <a href="../Devices/general_audit.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General audit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Devices/pcname.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>PC names</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="../Devices/devices.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
            </ul>
          </li>
             <!--Decomission -->
            <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-ban"></i>
              <p>
                Decomission
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Decomission/current_dec.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Current decomissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Decomission/past_dec.php" class="nav-link">
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
                <a href="../Orders/current_orders.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Current orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Orders/pricing.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pricing and QTY</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../Orders/past_orders.php" class="nav-link">
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
            <h1 class="m-0 text-dark">Edit decomission item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../Decomission/current_dec.php">Decomission</a></li>
                <li class="breadcrumb-item"><a href="decomission_item.php">Current decomission</a></li>
                <li class="breadcrumb-item active">Edit details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">
                            Edit item details
                        </h3>
                      </div>
                      <form name="register" role="form" onsubmit="" action="" method="post">
                          <?php # select information about editted item
                            $msg = "SELECT _decID_, _reason_, _type_name_, _brand_name_, _model_name_, _SN_, _TAG_, _day_added_ FROM _decomission_ INNER JOIN _decomission_item_ AS di ON di._di_ID_= _decomission_._item_id_ INNER JOIN _model_ ON _model_._mID_ = di._mode_id_ INNER JOIN _brands_ ON _brands_._bID_ = di._brand_ID_ INNER JOIN _types_ ON _types_._tID_ = di._typy_ID_ INNER JOIN _decom_quantity_ AS dq ON dq._dcID_ = _decomission_._dec_qty_ INNER JOIN _reason_ ON _reason_._rID_ = dq._reason_id_ WHERE _dec_visible_ = 1 AND _decID_ = ?";
                            $stmnt = $con -> prepare($msg);
                            $deviceid = clean($_GET['uid']);
                            $stmnt -> bind_param("i", $deviceid);
                            $stmnt -> execute();
                            $stmnt -> bind_result($decid, $reason, $type, $brand, $model, $SN, $tag, $sdate);
                            $stmnt -> fetch();
                            $stmnt -> close();
                            $SN = $crypt -> decrypt($SN);
                            $tag = $crypt -> decrypt($tag);
                          ?>
                          <div class="card-body">
                              <!-- /.Type -->
                              <div class="form-group">
                                <label for="Type">Device type</label>
                                  <select class="form-control selectpicker" id="Type" name="type" data-live-search="true">
                                      <?php # select types and set as selected decomission type item
                                            $stmnt = $con -> prepare("Select * FROM _types_ ORDER BY _type_name_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($typeid, $typename);
                                             while ($stmnt->fetch()) {
                                                 if($typename == $type){
                                                     echo '<option value="'.$typeid.'" selected>'.$typename.'</option>';  
                                                 }else{
                                                     echo '<option value="'.$typeid.'">'.$typename.'</option>';  
                                                 }  
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- Show if type not exists -->
                              <div class="form-group" id="div_type">
                                <label for="no_type">Type</label>
                                  <input class="form-control" id="no_type" name="type2" type="text" placeholder="Type"/>
                              </div>
                              <!-- /.Brand -->
                              <div class="form-group">
                                <label for="Brand">Brand</label>
                                  <select class="form-control selectpicker" id="Brand" name="brand" data-live-search="true">
                                      <?php # select brand and set as selected decomission brand item
                                            $stmnt = $con -> prepare("Select * FROM _brands_ ORDER BY _brand_name_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($brandid, $brandname);
                                             while ($stmnt->fetch()) {
                                                 if($brandname == $brand){
                                                     echo '<option value="'.$brandid.'" selected>'.$brandname.'</option>'; 
                                                 }else{
                                                     echo '<option value="'.$brandid.'">'.$brandname.'</option>'; 
                                                 }   
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- Show if brand not exists -->
                              <div class="form-group" id="div_brand">
                                <label for="no_brand">Brand</label>
                                  <input class="form-control" id="no_brand" name="brand2" type="text" placeholder="Brand"/>
                              </div>
                              <!-- /.Model -->
                              <div class="form-group">
                                <label for="Model">Model</label>
                                  <select class="form-control selectpicker" id="Model" name="model" data-live-search="true">
                                      <?php # select models and set as selected decomission brand item
                                            $stmnt = $con -> prepare("Select * FROM _model_ ORDER BY _model_name_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($modelid, $modelname);
                                             while ($stmnt->fetch()) {
                                                 //check which model is selected
                                                 if($modelname == $model){
                                                     echo '<option value="'.$modelid.'" selected>'.$modelname.'</option>'; 
                                                 }else{
                                                     echo '<option value="'.$modelid.'">'.$modelname.'</option>'; 
                                                 }   
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- Show if model not exists -->
                              <div class="form-group" id="div_model">
                                <label for="no_brand">Model</label>
                                  <input class="form-control" id="no_model" name="model2" type="text" placeholder="Model"/>
                              </div>
                              <!-- /.Serial Nnumber -->
                              <div class="form-group">
                                <label for="S_N">Serial number</label>
                                  <input class="form-control" id="S_N" name="sn" type="text" value="<?php print clean($SN); ?>"/>
                              </div>
                              <div class="form-group">
                                <label for="Tag">Asset Tag</label>
                                  <input class="form-control" id="Tag" name="tag" type="text" value="<?php print clean($tag); ?>"/>
                              </div>
                              <div class="form-group">
                                <label for="Reason">Decomission reason</label>
                                  <select class="form-control selectpicker" id="Reason" name="reason" data-live-search="true">
                                      <?php # select reasons and set as selected decomission brand item
                                            $stmnt = $con -> prepare("Select * FROM _reason_ ORDER BY _reason_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($reasonid, $reasonname);
                                             while ($stmnt->fetch()) {
                                                 if($reason == $reasonname){
                                                     echo '<option value="'.$reasonid.'" selected>'.$reasonname.'</option>'; 
                                                 }else{
                                                     echo '<option value="'.$reasonid.'">'.$reasonname.'</option>'; 
                                                 }   
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- Show if reason not exists -->
                              <div class="form-group" id="div_reason">
                                <label for="no_brand">Reason</label>
                                  <input class="form-control" id="no_reason" name="reason2" type="text" placeholder="Model"/>
                              </div>
                              <div class="form-group">
                                <label for="DecomissionDate">Date</label>
                                  <input class="form-control" id="DecomissionDate" name="DecomissionDate" type="date" value="<?php print $sdate; ?>"/ required>
                              </div>
                          </div>
                          <div class="card-footer">
                              <button class="btn btn-primary" style="float: right;" type="submit" name="update">Update</button>
                              <button class="btn btn-danger" style="float: right; margin-right: 10px;" onclick="window.location = 'http://'+window.location.hostname+'/Decomission/decomission_item.php'; return false" name="cancel">Cancel</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019 <a href="">AuditAdmin</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
     <!-- JQuery and bootstraps -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- Select bootstraps -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js">
</script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<script src="../dist/js/BoxChange.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>