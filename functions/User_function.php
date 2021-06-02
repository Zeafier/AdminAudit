<?php
include "../functions/XSS.php";

//Add new user
class users{
    function createuser($con){
        include "Staff_function.php";
        
        if(isset($_POST['Create']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ #Check if user is logged
            //Variables
            $username=clean($_POST['username']); # username
            $staffid=clean($_POST['staff_list']); # Selected staff memeber
            $fname=clean($_POST['user_name']); # first name
            $secname=clean($_POST['user_sname']); # second name
            $lname=clean($_POST['user_surname']); # last name
            $email=clean($_POST['user_email']); # email
            $email = strtolower($email); # change email to small case
            $job=clean($_POST['Title']); # title
            $pass=clean($_POST['user_password']); # password
            $cpass=clean($_POST['user_rpassword']); # password confirmation
            $usertype=clean($_POST['user_type']); # username
            $username = strtolower($username); # change username to small case
            //Check if checkbox has been selected
            if(isset($_POST['mustpass'])){
                $passchange=0;
            }else{
                $passchange=1;
            }
            //select username to check if user exists
            $stmnt = $con->prepare("Select _username_ From _user_log_ Where _username_ = ?");
            $stmnt->bind_param("s",$username);
            $stmnt->execute(); 

            $hpw = password_hash($pass, PASSWORD_BCRYPT);

            if(empty($_POST['username']) || empty($_POST['user_password']) || empty($_POST['user_rpassword'])){ # Check if fields are empty
                echo "<script>alert('One of the field is empty');</script>";
                $stmnt->close();
                $extra = "./Create_user.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if($stmnt->fetch()!=0){ # Check if account exists
                echo "<script>alert('This account already exists');</script>";
                $extra = "./Create_user.php";
                echo "<script>window.location.href='".$extra."'</script>";
                $stmnt->close();
            }else if($pass != $cpass){ # Check if password are the same
                echo "<script>alert('Password do not match');</script>";
                $extra = "./Create_user.php";
                echo "<script>window.location.href='".$extra."'</script>";
                $stmnt->close();
            }else if(strlen($pass) < 5 || strlen($pass) > 15){ # Check if password if between 6 to 14 characters
                echo "<script>alert('Password must be between 5 to 15 characters');</script>";
                $stmnt->close();
            }else{
                //Proceed if not on the list
                if($staffid == "Notonlist"){
                    //Add staff memeber
                    $insertstaff = new staff();
                    $insertstaff -> insertstaff($con);
                    //select staff ud
                    $msg = "SELECT _sID_ FROM _staff_ WHERE _email_ = ?";
                    $stmnt1 = $con->prepare($msg);
                    $stmnt1 -> bind_param("s", $email);
                    $stmnt1 -> execute();
                    $stmnt1 -> bind_result($sid); # Bind staff id
                    $stmnt1->fetch();
                    $stmnt1->close();
                    // Create new user account
                    $msg = "INSERT INTO _user_log_ (_staff_id_, _username_, _password_, _is_admin_, _is_active_, password_change) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmnt2 = $con->prepare($msg);
                    $valueact = 1;
                    $stmnt2 -> bind_param("issiii", $sid, $username, $hpw, $usertype, $valueact, $passchange);
                    if($stmnt2 -> execute()){
                        echo "<script>alert('Account has been created');</script>";
                        $stmnt2->close();
                    }else{
                        echo "<script>alert('Something went wrong. Try again');</script>";
                        $stmnt2->close();
                    }
                }else{
                    // Create new user account
                    $msg = "INSERT INTO _user_log_ (_staff_id_, _username_, _password_, _is_admin_, _is_active_, password_change) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmnt1 = $con->prepare($msg);
                    $valueact = 1;
                    $stmnt1 -> bind_param("issiii", $staffid, $username, $hpw, $usertype, $valueact, $passchange);
                    if($stmnt1 -> execute()){
                        echo "<script>alert('Account has been created');</script>";
                        $stmnt1->close();
                    }else{
                        echo "<script>alert('Something went wrong. Try again');</script>";
                        $stmnt1->close();
                    }
                }
            }
        }
    }
}

//class to acivate or disable acocunt
class activation{
    function activate($con){
        if(isset($_GET['uid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1) #check if session exists and if user is admin
        {
            $adminid=$_GET['uid'];
            $msg = "SELECT _is_active_ FROM _user_log_ WHERE _uID_ = ?"; #check user's current status account
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("i", $adminid);
            $stmnt -> execute();
            $stmnt -> bind_result($isact);
            $stmnt->fetch();
            $stmnt -> close();
            if ($isact == 1){ # Desactivate users account
                $msg = "UPDATE _user_log_ SET _is_active_ = 0 WHERE _uID_ = ?";
                $stmnt1 = $con->prepare($msg);
                $stmnt1 -> bind_param("i", $adminid);
                if($stmnt1->execute()){
                   echo "<script>alert('Account has been disabled');</script>";
                   $stmnt1->close();
                }
            }else{
                $msg = "SELECT _staff_id_ FROM _user_log_ WHERE _uID_ = ?"; # Select staff member of selected user
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $adminid);
                $stmnt -> execute();
                $stmnt -> bind_result($staffid);
                $stmnt -> fetch();
                $stmnt -> close();
                $msg = "SELECT _visible_ FROM _staff_ WHERE _sID_ = ?"; # Check if staff member is visible
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $staffid);
                $stmnt -> execute();
                $stmnt -> bind_result($visible);
                $stmnt -> fetch();
                $stmnt -> close();
                if($visible == 0){ # If staff member not visible, change visibility to 1
                    $msg = "UPDATE _staff_ SET _visible_ = 1 WHERE _sID_ = ?";
                    $stmnt2 = $con->prepare($msg);
                    $stmnt2 -> bind_param("i", $staffid);
                    if($stmnt2->execute()){
                       $stmnt2->close();
                    }
                }
                $msg = "UPDATE _user_log_ SET _is_active_ = 1 WHERE _uID_ = ?"; # Activate user account
                $stmnt1 = $con->prepare($msg);
                $stmnt1 -> bind_param("i", $adminid);
                if($stmnt1->execute()){
                   echo "<script>alert('Account has been enabled');</script>";
                   $stmnt1->close();
                }
            }
        }
    }
}

//update user's details
class updateusers{
    function update($con, $userid){
        if(isset($_POST['Update']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check if session exists
            $usertype = clean($_POST['user_type']);
            $msg = "UPDATE _user_log_ SET _is_admin_ = ? WHERE _uID_ = ?"; # Update user account type
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $usertype, $userid);
            if($stmnt -> execute()){
                $stmnt->close();
                echo "<script>alert('User has been updated');</script>";
                $extra = "./Log_users.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }
        }
    }
}
?>