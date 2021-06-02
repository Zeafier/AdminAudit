<?php
session_start();
include "../Database/databaseconnect.php";
include "../logcheck/logincheck.php";
check_login();
include "../functions/XSS.php";

//remove order
if(isset($_GET['rid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
    $removeid = clean($_GET['rid']);
    //select ordered quantity
    $msg = "SELECT _quantity_ FROM _orders_ WHERE _oID_ = ?";
    $stmnt = $con -> prepare($msg);
    $stmnt -> bind_param("i", $removeid);
    $stmnt -> execute();
    $stmnt -> bind_result($orderqty);
    $stmnt -> fetch();
    $stmnt -> close();
    //select item quantity and id
    $msg = "SELECT _oiID_, _QTY_ FROM _orders_ INNER JOIN _order_item_ ON _orders_._item_id_ = _order_item_._oiID_ WHERE _oID_ = ?";
    $stmnt = $con -> prepare($msg);
    $stmnt -> bind_param("i", $removeid);
    $stmnt -> execute();
    $stmnt -> bind_result($itemid, $itemqty);
    $stmnt -> fetch();
    $stmnt -> close();
    
    $newqty = $orderqty + $itemqty;
    
    //update quantity of the item
    $msg = "UPDATE _order_item_ SET _order_item_._QTY_ = ? WHERE _oiID_ = ?";
    $stmnt = $con -> prepare($msg);
    $stmnt -> bind_param("ii", $newqty, $itemid);
    if($stmnt -> execute()){
        $stmnt -> close();
        $msg = "DELETE FROM _orders_ WHERE _oID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $removeid);
        if($stmnt -> execute()){
            $stmnt -> close();
            echo "<script>alert('Item has been removed');</script>";
            $extra="current_orders.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }else{
            //revert changes if something went wrong
            $msg = "UPDATE _order_item_ SET _order_item_._QTY_ = ? WHERE _oiID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $itemqty, $itemid);
            $stmnt -> execute();
            $stmnt -> close();
            echo "<script>alert('Something went wrong');</script>";
            $extra="current_orders.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }
    }else{
        echo "<script>alert('Something went wrong');</script>";
        $extra="Current_orders.php";
        echo "<script>window.location.href='".$extra."'</script>";
    }
}

//mark order as completed
if(isset($_GET['uid']) && !empty($_SESSION['login'])){
    $itemid = clean($_GET['uid']);
    $msg = "UPDATE _orders_ SET _current_ = 0 WHERE _oID_ = ?";
    $stmnt = $con -> prepare($msg);
    $stmnt -> bind_param("i", $itemid);
    if($stmnt -> execute()){
        $stmnt -> close();
        echo "<script>alert('Order has been moved to past');</script>";
        $extra="current_orders.php";
        echo "<script>window.location.href='".$extra."'</script>";
    }else{
        $stmnt -> close();
        echo "<script>alert('Something went wrong');</script>";
        $extra="Current_orders.php";
        echo "<script>window.location.href='".$extra."'</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Orders</title>
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
                <a href="../Decomission/current_dec.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Decomission</p>
                </a>
              </li>
                <li class="nav-item">
                    <a href="../Orders/current_orders.php" class="nav-link active">
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
            <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Orders/current_orders.php" class="nav-link active">
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
            <h1 class="m-0 text-dark">Orders</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./current_orders.php">Orders</a></li>
              <li class="breadcrumb-item active">Current Orders</li>
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
                        <div class="col-sm-12 col-md-1">
                            <button class = "btn btn-block bg-gradient-primary" type="button" onclick="printJS('UserTable', 'html')"><i class="fas fa-print"></i> Print</button>
                        </div>
                        <?php if($_SESSION['isadmin'] == 1){ ?>
                        <div class="col-sm-12 col-md-1">
                            <a href="add_order.php">
                                <button class = "btn btn-block bg-gradient-success" type="button" id="add_user"><i class="fas fa-plus-circle"></i> ADD</button>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                  <!-- /.Top column -->
                  <!-- Main table-->
                </div>
                <!-- /.row (main row) -->
                    <div class="card-body">
                      <table id="UserTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Full name</th>
                          <th>Department</th>
                          <th>Email</th>
                          <th>Quantity</th>
                          <th>Item</th>
                          <th>Price</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php #select all current orders from database and place them in table
                            $msg = "SELECT _oID_, _name_, _surname_, _deparment_name_, _email_, _quantity_, _brand_name_, _item_name_, _total_price_, _date_ FROM _orders_ INNER JOIN _order_item_ ON _order_item_._oiID_ = _orders_._item_id_ INNER JOIN _supply_item_ AS si ON si._sp_ID_ = _order_item_._si_ID_ INNER JOIN _brands_ ON _brands_._bID_ = si._brand_ID_ INNER JOIN _staff_ ON _staff_._sID_=_orders_._staff_id_ INNER JOIN _name_ ON _staff_._name_id_ = _name_._nID_ INNER JOIN _departments_ ON _departments_._dID_ = _orders_._dep_id_ WHERE _current_ = 1";
                            $stmnt = $con->prepare($msg);
                            $stmnt->execute();
                            $stmnt -> bind_result($id, $staffname, $staffsurname, $depname, $email, $qty, $brand, $itemname, $price, $dateorder);
                            while ($stmnt -> fetch()){ ?>
                                <tr>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($staffname); ?> <?php print clean($staffsurname); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($depname); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($email); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($qty); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($brand); ?> <?php print clean($itemname); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;">£ <?php print clean($price); ?></a></td>
                                    <td><a onclick="myEdit(<?php print $id; ?>)" style="color: black; display: block; width: 100%; height: 100%; cursor: pointer;"><?php print clean($dateorder); ?></a></td>
                                  <td>
                                    <div class="col-10">
                                          <div class="row">
                                              <?php if($_SESSION['isadmin'] == 1){ ?>
                                              <div class="col-sm-4 col-md-3">
                                                  <a onclick="myEdit(<?php print $id; ?>)"><button class = "btn btn-primary btn-xs" title="Edit order"><i class="fa fa-pencil"></i></button></a>
                                              </div>
                                              <?php } ?>
                                              <div class="col-sm-3 col-md-3">
                                                  <a onclick="myComplete(<?php print $id; ?>)"><button class = "btn btn-success btn-xs" title="Mark as complete"><i class="fa fa-check"></i></button></a>
                                              </div>
                                              <?php if($_SESSION['isadmin'] == 1){ ?>
                                              <div class="col-sm-3">
                                                  <a onclick="myRemove(<?php print $id; ?>)"><button class="btn btn-danger btn-xs" title="Remove order"><i class="fa fa-trash-o "></i></button></a>
                                              </div>
                                              <?php } ?>
                                          </div>
                                      </div>
                                    </td>
                                </tr>
                            <?php }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Full name</th>
                          <th>Department</th>
                          <th>Email</th>
                          <th>Quantity</th>
                          <th>Item</th>
                          <th>Price</th>
                          <th>Date</th>
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
<!-- Navigation between pages -->
<script>
    function myEdit(input){
        
        window.location = "http://"+window.location.hostname+"/Orders/edit_order.php?uid="+input+"";
    }
    function myComplete(input){
        
        window.location = "http://"+window.location.hostname+"/Orders/current_orders.php?uid="+input+"";
    }
    function myRemove(input){
        if (confirm('Do you really want to delete?')) {
      // Save it!
            window.location = "http://"+window.location.hostname+"/Orders/current_orders.php?rid="+input+"";
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
    <!-- Import printing function-->
<script src="../plugins/Print.js/src/js/print.js"></script>
<script src="../plugins/Print.js/src/js/print.min.js"></script>
</body>
</html>