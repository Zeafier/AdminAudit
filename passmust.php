<?php
session_start();
include "./Database/databaseconnect.php";
include "./functions/XSS.php";
include "./logcheck/logincheck.php";
check_login_main();
$uID = $_SESSION['id'];

if(isset($_POST['change']))
{
    $password=clean($_POST['opass']);
    $newpass=clean($_POST['password']);
    $confirmpass=clean($_POST['c_password']);
    $hpw = password_hash($newpass, PASSWORD_BCRYPT);
    
    if(empty($password) || empty($newpass) || empty($confirmpass)){
        echo "<script>alert('Old and new passwords are required');</script>";
    }else if($newpass != $confirmpass){
        echo "<script>alert('Passwords do not match');</script>";
    }else if(strlen($newpass) < 5 || strlen($newpass) > 20){
        echo "<script>alert('Password must be between 5 to 20 characters');</script>";
    }else if(strtolower($newpass) == "password" || strtolower($newpass) == "kingsford"){
        echo "<script>alert('Password cannot be changed');</script>";
    }else{
        $stmnt = $con->prepare("Select _password_ From _user_log_ Where _uID_ = ?");
        $stmnt->bind_param("i",$uID);
        $stmnt->execute();
        $stmnt->bind_result($pword);
        if($stmnt->fetch()!=0){
            if(password_verify($password, $pword))
            {
               $stmnt->close();
                $msg="UPDATE _user_log_ SET _password_ = ?, password_change = 0 WHERE _uID_ = ?";
                $stmnt1 = $con -> prepare($msg);
                $stmnt1 -> bind_param("si", $hpw, $uID);
                if($stmnt1->execute()){
                    echo "<script>alert('Password has been changed');</script>";
                    $extra="./index.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                    $stmnt1->close();
                }else{
                    echo "<script>alert('Something went wrong');</script>";
                    $stmnt1->close();
                }
            }else{
                echo "<script>alert('Old password is incorrect');</script>";
                $stmnt->close();
            }   
        }else{
            echo "<script>alert('Something went wrong. Please contact with local admin');</script>";
            $extra="login.php";
            echo "<script>window.location.href='".$extra."'</script>";
            $stmnt -> close();
        }
    }
}

if(isset($_POST['cancel'])){
    $_SESSION['login']=="";
    echo "<script>alert('Password change has been canceled');</script>";
    $extra="./login.php";
    echo "<script>window.location.href='".$extra."'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Audits Admin| Password</title>
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
    <a href="#"><img src="./dist/img/NewLogo.png" width="50" height="60" alt="Audit Admin" class="brand-image img-circle elevation-4"
           style="opacity: .8"> <b>Audit Admin</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Change your password</p>

      <form method="post" role="form" onsubmit="" action="">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Old password" name="opass" maxlength="20" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
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
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name="c_password" maxlength="20" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
            <button style="right: auto;" type="submit" name="change" class="btn btn-primary btn-block">Change</button>
            <button style="left: auto;" type="submit" name="cancel" class="btn btn-danger btn-block">Cancel</button>
          <!-- /.col -->
        </div>
      </form>
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