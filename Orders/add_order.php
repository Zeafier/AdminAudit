<?php
session_start();
include "../Database/databaseconnect.php";
include "../logcheck/logincheck.php";
check_login();
isadmin();
include "../functions/orders_function.php";

$addorder = new neworder();
$addorder -> order($con);

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
            <h1 class="m-0 text-dark">Add order item</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../Orders/current_orders.php">Orders</a></li>
              <li class="breadcrumb-item">Current orders</li>
                <li class="breadcrumb-item active">Add order</li>
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
                            Order details
                        </h3>
                      </div>
                      <!-- Form to callect user input -->
                      <form name="addorder" role="form" onsubmit="" action="" method="post">
                          <div class="card-body">
                              <div class="form-group">
                                <label for="staff_list">Select staff name:</label>
                                <select class="form-control selectpicker" id="staff_list" name="staff" data-live-search="true">
                                        <?php #Select staff member name and surname and place staff into combobox
                                            $stmnt = $con -> prepare("Select _sID_, _name_, _surname_ FROM _staff_ INNER JOIN _name_ ON _staff_._name_id_=_name_._nID_ WHERE _visible_=1 ORDER BY _email_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($id, $name, $surname);
                                             while ($stmnt->fetch()) {
                                                    echo '<option value="'.$id.'">'.$name.' '.$surname.'</option>';    
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- If staff not exists, add extra input fields -->
                              <div class="form-group" id = "div_name">
                                <label for="user_name">Name</label>
                                <input class="form-control" id="user_name" name="user_name" type="name" placeholder="Name"/>
                              </div>
                              <div class="form-group" id="div_secondname">
                                <label for="user_sname">Second Name</label>
                                  <input class="form-control" id="user_sname" name="user_sname" type="text" placeholder="Second name"/>
                              </div>
                              <div class="form-group" id="div_surname">
                                <label for="user_surname">Surname</label>
                                  <input class="form-control" id="user_surname" name="user_surname" type="surname" placeholder="Surname"/>
                              </div>
                              <div class="form-group" id="div_email">
                                <label for="user_email">Email</label>
                                  <input class="form-control" id="user_email" name="user_email" type="email" placeholder="Email"/>
                              </div>
                              <div class="form-group" id="div_title">
                                <label for="Title">Choose title</label>
                                  <select class="form-control" id="Title" name="Title">
                                      <?php #select titles and place it in combobox
                                            $stmnt = $con -> prepare("Select * FROM _title_ ORDER BY _title_name_");
                                            $stmnt -> execute();
                                            $stmnt -> bind_result($id, $title_name);
                                             while ($stmnt->fetch()) {
                                                    echo '<option value="'.$title_name.'">'.$title_name.'</option>';    
                                                }
                                            $stmnt -> close();
                                        ?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <!-- !If staff not exists, add extra input fields -->
                              <div class="form-group">
                                <label for="Department">Department</label>
                                  <select class="form-control" id="Department" name="depart">
                                      <?php 
                                      $msg = "SELECT * FROM _departments_ WHERE _visible_=1";
                                        $stmnt = $con->prepare($msg);
                                        $stmnt -> execute();
                                        $stmnt -> bind_result($did, $department, $visib);
                                        while($stmnt->fetch()){?>
                                            <option value="<?php print $did; ?>"><?php print clean($department); ?></option>
                                      <?php }?>
                                      <option value="Notonlist">Not on list</option>
                                  </select>
                              </div>
                              <div class="form-group" id="div_department">
                                <label for="no_department">Department</label>
                                  <input class="form-control" id="no_department" type="text" name="department" placeholder="Department"/>
                              </div>
                              <!-- If department not exists, add extra input fields -->
                              <div class="form-group">
                                <label for="quantity">Quantity</label>
                                  <input class="form-control" id="quantity" type="number" name="quantity" placeholder="Quantity"/ required>
                              </div>
                              <div class="form-group">
                                <label for="Item">Item</label>
                                  <select class="form-control selectpicker" id="Item" name="item" data-live-search="true">
                                      <?php #Secelt pricing from database and place it into select box
                                        $msg = "SELECT _oiID_, _brand_name_, _item_name_, _price_ FROM _order_item_ INNER JOIN _supply_item_ AS si ON si._sp_ID_ = _order_item_._si_ID_ INNER JOIN _brands_ ON _brands_._bID_ = si._brand_ID_ WHERE _visible_ = 1";
                                        $stmnt = $con->prepare($msg);
                                        $stmnt -> execute();
                                        $stmnt -> bind_result($oiid, $brand, $model, $price);
                                        while($stmnt->fetch()){?>
                                            <option value="<?php print $oiid; ?>"><?php print clean($brand); ?> <?php print clean($model); ?> £<?php print clean($price); ?></option>
                                      <?php }?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label for="OrderDate">Date</label>
                                  <input class="form-control" id="OrderDate" name="order_date" type="date"/ required>
                              </div>
                          </div>
                          <div class="card-footer">
                              <button class="btn btn-primary" style="float: right;" type="submit" name="Add_order">Add</button>
                              <button class="btn btn-danger" style="float: right; margin-right: 10px;" onclick="window.location = 'http://'+window.location.hostname+'/Orders/current_orders.php'; return false" name="cancel">Cancel</button>
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