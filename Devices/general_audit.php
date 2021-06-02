<?php
session_start();
include "../Database/databaseconnect.php";
include "../logcheck/logincheck.php";
check_login();
include "../functions/device_functions.php";
use \Chirp\Cryptor;
$encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5'; # encrypotion key
$crypt = new Cryptor($encryption_key);

$delete = new remove();
$delete -> removeitem($con);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Audit</title>
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
                <a href="../Devices/general_audit.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Devices</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="../Decomission/current_dec.php" class="nav-link">
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
            <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Audits
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Devices/general_audit.php" class="nav-link active">
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
                <a href="../Decomission/current_dec.php" class="nav-link">
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
            <h1 class="m-0 text-dark">Audits</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./general_audit.php">Audits</a></li>
              <li class="breadcrumb-item active">General Audit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-12">
              <div class="card">
              <!-- Main row -->
                <div class="card-header">
                  <!-- Top column -->
                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                            <h2 class="card-title">
                                General Audit
                            </h2>
                        </div>
                        <div class="col-sm-12 col-md-1">
                            <button class = "btn btn-block bg-gradient-primary" type="button" onclick="printJS('UserTable', 'html')"><i class="fas fa-print"></i> Print</button>
                        </div>
                        <?php if($_SESSION['isadmin'] == 1){ ?>
                        <div class="col-sm-12 col-md-1">
                            <a href="Add_device.php">
                                <button class = "btn btn-block bg-gradient-success" type="button" id="add_user"><i class="fas fa-plus-circle"></i> ADD</button>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                  <!-- /.Top column -->
                  <!-- Main table-->
                </div>
                  <form name="actionfrom" id="action" action="" method="post">
                    <!-- /.row (main row) -->
                        <div class="card-body">
                          <table id="UserTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Faculty</th>
                              <th>User type</th>
                              <th>Location</th>
                              <th>Device type</th>
                              <th>Device model</th>
                              <th>Specs</th>
                              <th>S/N</th>
                              <th>Tag</th>
                                <?php if($_SESSION['isadmin'] == 1){ ?>
                              <th>Action 
<input type="checkbox" name="select-all" title="Click to tick all" id="select-all" /></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                                <?php # Select inforamtionj about current devices and place it in table rows
                                    $msg = "SELECT _devID_, _specs_, _type_name_, _brand_name_, _model_name_, _SN_, _TAG_, _classes_, _faculty_name_, _utype_name_ FROM _devices_ INNER JOIN _decomission_item_ AS di ON di._di_ID_= _devices_._item_id_ INNER JOIN _model_ ON _model_._mID_ = di._mode_id_ INNER JOIN _brands_ ON _brands_._bID_ = di._brand_ID_ INNER JOIN _types_ ON _types_._tID_ = di._typy_ID_ INNER JOIN _specs_ AS dq ON dq._secID_ = _devices_._specs_id_ INNER JOIN _classes_ ON _classes_._caID_ = _devices_._classes_id_ INNER JOIN _faculty_ on _faculty_._facID_ = _devices_._faculty_id_ INNER JOIN _user_type_ ON _user_type_._utID_ = _devices_._ut_id_";
                                    $stmnt = $con->prepare($msg);
                                    $stmnt -> execute();
                                    $stmnt -> bind_result($devid, $spec, $type, $brand, $model, $SN, $tag, $class, $faculty, $usertype);
                                while ($stmnt -> fetch()){
                                    $cryptor = new Cryptor($encryption_key); # decrypt information about s/n and asset tag
                                    $SN = $cryptor->decrypt($SN);
                                    $tag = $cryptor->decrypt($tag);
                                ?>
                                    <tr>
                                        <td><?php print $faculty;?></td>
                                        <td><?php print $usertype; ?></td>
                                        <td><?php print $class; ?></td>
                                        <td><?php print $type; ?></td>
                                        <td><?php print $brand; ?> <?php print $model; ?></td>
                                        <td><?php print $spec; ?></td>
                                        <td><?php print $SN; ?></td>
                                        <td><?php print $tag; ?></td>
                                        <?php if($_SESSION['isadmin'] == 1){ ?>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button class = "btn btn-primary btn-xs" title="Edit device" type="button" onclick="myFunction(<?php print $devid; ?>)"><i class="fa fa-edit"></i></button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="checkbox" title="Tick to remove" name="check_box_delete[]" id= "checkbox-<?php print $devid;?>" value="<?php print $devid; ?>"/>
                                                </div>
                                            </div>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                             <tr>
                              <th>Faculty</th>
                              <th>User type</th>
                              <th>Location</th>
                              <th>Device type</th>
                              <th>Device model</th>
                              <th>Specs</th>
                              <th>S/N</th>
                              <th>Tag</th>
                                 <?php if($_SESSION['isadmin'] == 1){ ?>
                              <th>Action</th>
                                 <?php } ?>
                            </tr>
                            </tfoot>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      <?php if($_SESSION['isadmin'] == 1){ ?>
                      <!-- card footer-->
                      <div class="card-footer">
                          <div class="row">
                              <div class="col-sm-12 col-md-11">
                                    <h1 class="card-title">
                                        Action
                                    </h1>
                                </div>
                                <div class="col-sm-12 col-md-1">
                                    <button class = "btn btn-block bg-gradient-danger" type="submit" name="remove" id="RemoveItems" onClick="return confirm('Do you really want to delete?');"><i class="fas fa-trash"></i> Remove</button>
                                </div>
                          </div>
                      </div>
                      <?php } ?>
                  </form>
              </div>
          </div>
      </div><!-- /.container-fluid -->
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
<script>
  $(function () {
    $("#UserTable").DataTable();
  });
</script>
    <!-- Select all checkboxes -->
<script language="JavaScript">
    // Listen for click on toggle checkbox
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });
</script>
<script>
    function myFunction(input){
        
        window.location = "http://"+window.location.hostname+"/Devices/edit_device.php?uid="+input+"";
    }
</script>    
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
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
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Import printing function-->
<script src="../plugins/Print.js/src/js/print.js"></script>
<script src="../plugins/Print.js/src/js/print.min.js"></script>
</body>
</html>
