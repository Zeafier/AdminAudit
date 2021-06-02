<?php
session_start();
include "./Database/databaseconnect.php";
include "./functions/XSS.php";
include "./logcheck/logincheck.php";
logged();

//check user
if(isset($_POST['login']))
{
    $password=clean($_POST['password']);
    $useremail=clean($_POST['uemail']);
    $useremail = strtolower($useremail);
    $userid;
    $pword;
    //check if fields are empty
    if(empty($password) || empty($useremail)){
        echo "<script>alert('Email and Passwords are required');</script>";
    }else{
        //select user from database
        $stmnt = $con->prepare("Select _uID_, _password_, _username_, _is_active_, password_change, _is_admin_ From _user_log_ INNER JOIN _staff_ ON _staff_._sID_=_user_log_._staff_id_ Where _email_ = ? OR _username_ = ?");
        $stmnt->bind_param("ss",$useremail, $useremail);
        $stmnt->execute();
        $stmnt->bind_result($userid, $pword, $username, $ia, $passwordchange, $isadmin);
        //check if data exists
        if($stmnt->fetch()!=0){
            //check uset type account and if password needs to be changed
            if(password_verify($password, $pword) && $ia == 1 && $passwordchange==0)
            {
                $extra="index.php";
                $_SESSION['login']=clean($username);
                $_SESSION['id']=clean($userid);
                $_SESSION['isadmin'] = clean($isadmin);
                $host=$_SERVER['HTTP_HOST'];
                $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                header("location:http://$host$uri/$extra");
                exit();
            }else if(password_verify($password, $pword) && $ia == 1 && $passwordchange==1){
                $extra="passmust.php";
                $_SESSION['login']=clean($username);
                $_SESSION['id']=clean($userid);
                $_SESSION['isadmin'] = clean($isadmin);
                echo "<script>window.location.href='".$extra."'</script>";
                exit();  
            }else if(password_verify($password, $pword) && $ia == 0){
                echo "<script>alert('Your account has been disabled. Please contact with local admin');</script>";
                $extra="login.php";
                $host  = $_SERVER['HTTP_HOST'];
                $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                $stmnt->close();
            }else{
                echo "<script>alert('Invalid username or password');</script>";
                $extra="login.php";
                $host  = $_SERVER['HTTP_HOST'];
                $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                $stmnt->close();
            } 
            //if empty
        }else{
            echo "<script>alert('Invalid username or password');</script>";
            $extra="login.php";
            $host  = $_SERVER['HTTP_HOST'];
            $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
            $stmnt -> close();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <img src="./dist/img/NewLogo.png" width="50" height="60" alt="Audit Admin" class="brand-image img-circle elevation-4"
           style="opacity: .8"> <b>Audit Admin</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Log in to start session</p>

      <form method="post" role="form" onsubmit="" action="">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email or username" name="uemail" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" maxlength="20" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="login.php" onclick="alert('Please contact with your local admin');">I forgot my password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>

</body>
</html>