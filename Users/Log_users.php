<?php
session_start();
include "../Database/databaseconnect.php";
include "../functions/User_function.php";
include "../logcheck/logincheck.php";
check_login();
isadmin();
$active = "Active";
$inactive = "Inactive";
    
$activate= new activation();
$activate -> activate($con);

//remove user from database
if(isset($_GET['rid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
    $rid = $_GET['rid'];
    if(is_numeric($rid)){
        //remove user's chat
        $msg = "DELETE FROM _chat_ WHERE _uID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $rid);
        if($stmnt -> execute()){
            $stmnt -> close();
            //remove user
            $msg = "DELETE FROM _user_log_ WHERE _uID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $rid);
            if($stmnt -> execute()){
                $stmnt -> close();
                echo "<script>alert('User has been removed.');</script>";
                $extra="Log_users.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else{
                $stmnt -> close();
                echo "<script>alert('Something went wrong.');</script>";
                $extra="Log_users.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }
        }else{
            $stmnt -> close();
            echo "<script>alert('Something went wrong.');</script>";
            $extra="Log_users.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }
    }else{
        echo "<script>alert('Incorrect format.');</script>";
        $extra="Log_users.php";
        echo "<script>window.location.href='".$extra."'</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Users</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.css">
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
                <a href="../Users/Log_users.php" class="nav-link active">
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
            <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Users/Log_users.php" class="nav-link active">
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
            <h1 class="m-0 text-dark">Log Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./Log_users.php">Users</a></li>
              <li class="breadcrumb-item active">Log users</li>
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
                                Users
                            </h2>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <a href="Create_user.php">
                                <button class = "btn btn-block bg-gradient-success" type="button" id="add_user"><i class="fas fa-plus-circle"></i> ADD</button>
                            </a>
                        </div>
                    </div>
                  <!-- /.Top column -->
                  <!-- Main table-->
                </div>
                <!-- /.row (main row) -->
                    <div class="card-body">
                      <table id="UserTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Username</th>
                          <th>Full Name</th>
                          <th>User type</th>
                          <th>Active</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                         <?php
                            //select users from database
                            $msg = "SELECT _uID_, _username_, _name_, _surname_, _is_active_, _is_admin_ FROM _user_log_ INNER JOIN _staff_ ON _staff_._sID_=_user_log_._staff_id_ INNER JOIN _name_ ON _name_._nID_=_staff_._name_id_ ORDER BY _username_";
                            $stmnt = $con->prepare($msg);
                            $stmnt->execute();
                            $stmnt -> bind_result($id, $username, $name, $surname, $iact, $admin);
                            //Fill table with collected information
                            while($stmnt->fetch()){
                                if($username != $_SESSION['login']){?>
                                    <tr>
                                      <td><?php print $username;?></td>
                                      <td><?php print $name?> <?php print $surname?></td>
                                      <?php 
                                        if($admin == 1){?>
                                            <td>Admin</td>
                                        <?php }else{ ?>
                                            <td>User</td>
                                        <?php }
                                        ?>
                                      <td><?php if($iact==1)
                                            { 
                                                print $active;
                                            }else{
                                                print $inactive;
                                            }?></td>
                                      <td>
                                        <div class="col-8">
                                              <div class="row">
                                                  <div class="col-sm-2 col-md-2">
                                                      <a onclick="myEdit(<?php print $id; ?>)"><button class = "btn btn-primary btn-xs" title="Edit user"><i class="fa fa-pencil"></i></button></a>
                                                  </div>
                                                  <div class="col-sm-2"><?php if($iact==1)
                                                        { ?>
                                                            <a onclick="myDisEn(<?php print $id; ?>, 'disable')"><button class="btn btn-danger btn-xs" title="Disable account"><i class="fas fa-user-times"></i></button></a>
                                                        <?php }else{ ?>
                                                            <a onclick="myDisEn(<?php print $id; ?>, 'enable')"><button class="btn btn-success btn-xs"><i class="fas fa-unlock" title="Enable account"></i></button></a>
                                                        <?php }?>
                                                  </div>
                                                  <div class="col-sm-2">
                                                        <a onclick="myPassword(<?php print $id; ?>)"><button class="btn btn-warning btn-xs" title="Reset password"><i class="fas fa-exchange-alt"></i></button></a>
                                                  </div>
                                                  <div class="col-sm-2">
                                                      <a onclick="myRemove(<?php print $id; ?>)"><button class = "btn btn-danger btn-xs" title="Remove user"><i class="fa fa-trash-o"></i></button></a>
                                                  </div>
                                              </div>
                                          </div>
                                        </td>
                                    </tr>
                                <?php }
                            }
                            $stmnt->close();
                            ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Username</th>
                          <th>Full Name</th>
                          <th>User type</th>
                          <th>Active</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.card-body -->
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
<script>
    function myEdit(input){
        window.location = "http://"+window.location.hostname+"/Users/edit_user.php?uid="+input+"";
    }
    function myDisEn(input, val){
        if (val == "disable"){
            if (confirm('Are you sure you want to disable this user?')) {
                window.location = "http://"+window.location.hostname+"/Users/Log_users.php?uid="+input+"";
            }
        }else{
            window.location = "http://"+window.location.hostname+"/Users/Log_users.php?uid="+input+"";
        }
    }
    function myPassword(input){
        window.location = "http://"+window.location.hostname+"/Users/password_reset.php?uid="+input+"";
    }
    function myRemove(input){
        if (confirm('This actuion will remove user and all chats. Do you want to continue?')) {
      // Save it!
            window.location = "http://"+window.location.hostname+"/Users/Log_users.php?rid="+input+"";
        }else{
            
        }
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
</body>
</html>
