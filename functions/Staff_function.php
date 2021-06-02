<?php
class staff{
    
    //insert staff
    public function insertstaff($con){
       //register staff member
        if((isset($_POST['Create_staff']) || isset($_POST['Create']) || isset($_POST['Add_order']) || isset($_POST['Edit_order'])) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # proceed function if session exists and user is admin
            //collect data
            $name=clean($_POST['user_name']);
            $sname=clean($_POST['user_sname']);
            $surname=clean($_POST['user_surname']);
            $email=clean($_POST['user_email']);
            $email = strtolower($email); # set email to camll letters
            $title=clean($_POST['Title']);
            $visible=1;
            $nid=""; #name id
            $nid1="";  #second name if
            $sid=""; #title id
            //check if staff with this email exists
            $msg = "Select _email_ From _staff_ Where _email_ = ?"; # check if user with selected email exists
            $stmnt = $con->prepare($msg);
            $stmnt->bind_param("s", $email);
            $stmnt->execute();
            
            if(empty($sname)){ #set second name if field empty
                $sname="empty";
            }

            //check if fields are empty
            if(empty($name) || empty($surname) || empty($email) || empty($title)){ # check field
                echo "<script>alert('One of  the field is empty');</script>";
                $stmnt -> close();
            }else if($stmnt->fetch() != 0){ # make selected staff visible if already exists
                $stmnt -> close();
                $msg = "SELECT _visible_ FROM _staff_ WHERE _email_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $email);
                $stmnt -> execute();
                $stmnt -> bind_result($visible);
                $stmnt -> fetch();
                $stmnt -> close();
                if($visible == 0){
                    $msg = "UPDATE _staff_ SET _visible_ = 1 WHERE _email_ = ?";
                    $stmnt2 = $con->prepare($msg);
                    $stmnt2 -> bind_param("s", $email);
                    if($stmnt2->execute()){
                        return "success";
                        echo "<script>alert('Staff with ".$email." email has been activated');</script>";
                       $stmnt2->close();
                    }
                }else{
                    return "exists";
                    echo "<script>alert('Staff already on list');</script>";
                }
            }else{
                $stmnt->close();
                $this -> maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid); #insert staff member
                $this -> secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid); #Update with second name
            }
        } 
    }

    //insert second name
    public function secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
        $msg = "Select _nID_ FROM _name_ WHERE _name_ = ?"; # check if name is in database
        $stmnt1 = $con->prepare($msg);
        $stmnt1->bind_param("s",$sname);
        $stmnt1->execute();
        $stmnt1->bind_result($nid1);
        if($stmnt1->fetch()){ # proceed if exists
            $stmnt1->close();
            $msg = "UPDATE _staff_ SET _s_name_id_ = ? WHERE _email_ = ?";
            $stmnt2 = $con->prepare($msg);
            $stmnt2 -> bind_param("is", $nid1, $email);
            $stmnt2 -> execute();
            $stmnt2->close();
        }else{ #add new name
            $stmnt1->close();
            $this -> ifnotsecondname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
        }
    }

    //insert for first name
    public function maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
        $msg = "Select _nID_ FROM _name_ WHERE _name_ = ?"; # check if name exists
        $stmnt1 = $con->prepare($msg);
        $stmnt1->bind_param("s",$name);
        $stmnt1->execute();
        $stmnt1->bind_result($nid);
        if($stmnt1->fetch()){ # proceed if exists
            $stmnt1->close();
            $msg = "Select _tID_ FROM _title_ WHERE _title_name_ = ?"; # check if title exists
            $stmnt2 = $con->prepare($msg);
            $stmnt2 -> bind_param("s", $title);
            $stmnt2 -> execute();
            $stmnt2 -> bind_result($sid);
            if($stmnt2->fetch()){ # proceed if title exists
                $stmnt2->close();
                $this -> insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
            }else{ # set new title
                $stmnt2->close();
                $this -> ifnottitle($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
            }
        }else{
            $stmnt1->close();
            $this -> ifnotname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
        }
    }
    //insert staff into table
    public function insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
        $msg="INSERT INTO _staff_ (_name_id_, _surname_, _email_, _title_id_, _visible_) VALUES (?, ?, ?, ?, ?)";
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("issii", $nid, $surname, $email, $sid, $visible);
        if($stmnt->execute()){
            echo "<script>alert('Staff has been added');</script>";
            $stmnt -> close();
        }else{
            echo "<script>alert('Something went wrong');</script>";
            $stmnt -> close();
        }
    }
    //insert is not title
    public function ifnottitle($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
        $msg = "INSERT INTO _title_ (_title_name_) VALUES (?)"; # insert new title
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $title);
        if($stmnt->execute()){
            $stmnt->close();
            $msg = "Select _tID_ FROM _title_ WHERE _title_name_ = ?"; # select inserted title id
            $stmnt4 = $con->prepare($msg);
            $stmnt4 -> bind_param("s", $title);
            $stmnt4 -> execute();
            $stmnt4 -> bind_result($sid);
            if($stmnt4 -> fetch()){ # proceed to insert staff member
                $stmnt4 -> close();
                $this -> insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
            }
        }
    }

    //insert name
    public function ifnotname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
        $stmnt = $con->prepare("INSERT INTO _name_ (_name_) VALUES (?);"); # insert new name
        $stmnt -> bind_param("s", $name);
        if($stmnt -> execute()){ #repeat main insert process with inserted name
            $stmnt -> close();
            $this -> maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
        }
    }

    //insert second name
    public function ifnotsecondname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid){
         $msg = "INSERT INTO _name_ (_name_) VALUES (?)"; # insert name
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $sname);
        if($stmnt->execute()){ #repeat secondary insert process with inserted name
            $stmnt->close();
            $this -> secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid);
        }
    }

}

//class to acivate or disable acocunt
class staffactivation{
    function activate($con){
        if(isset($_GET['uid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1) # check if session exists and if account type is admin
        {
            $adminid=clean($_GET['uid']); # get staff id
            $msg = "UPDATE _staff_ SET _visible_ = 0 WHERE _sID_ = ?"; # Set staff member visibility to 0 to remove them
            $stmnt1 = $con->prepare($msg);
            $stmnt1 -> bind_param("i", $adminid);
            if($stmnt1->execute()){
               echo "<script>alert('Staff has been removed');</script>";
               $stmnt1->close();
                $extra = "staff_users.php";
                $msg = "SELECT * FROM _user_log_ WHERE _staff_id_ = ?"; # Select user to desactivate staff account if exists
                $stmnt = $con->prepare($msg);
                $stmnt -> bind_param("i", $adminid);
                $stmnt -> execute();
                if($stmnt -> fetch()){
                    $stmnt->close();
                    $msg = "UPDATE _user_log_ SET _is_active_ = 0 WHERE _staff_id_ = ?";
                    $stmnt2 = $con->prepare($msg);
                    $stmnt2 -> bind_param("i", $adminid);
                    if($stmnt2->execute()){
                       echo "<script>alert('Account has been disabled');</script>";
                       $stmnt2->close();
                        echo "<script>window.location.href='".$extra."'</script>";
                    }
                }else{
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }
        }
    }
}

//udate users
class updateuser{
     //update staff
    public function insertstaff($con){
       //Check details
        if(isset($_POST['Update_staff']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # Check if session exists and if user is admin
            //collect data
            $name=clean($_POST['user_name']);
            $sname=clean($_POST['user_sname']);
            $surname=clean($_POST['user_surname']);
            $email=clean($_POST['user_email']);
            $email = strtolower($email); # set email to small letters
            $title=clean($_POST['Title']);
            $userid = clean($_GET['uid']);
            $visible=1;
            $nid=""; #name id
            $nid1="";  #second name if
            $sid=""; #title id
            //check if staff with this email exists
            $msg = "Select _email_ From _staff_ Where _email_ = ?"; #check if staff member exists
            $stmnt = $con->prepare($msg);
            $stmnt->bind_param("s", $email);
            $stmnt->execute();
            
            if(empty($sname)){ # set second name if empty
                $sname="empty";
            }

            //check if fields are empty
            if(empty($name) || empty($surname) || empty($email) || empty($title)){ # check field
                echo "<script>alert('One of  the field is empty');</script>";
                $stmnt -> close();
            }else if($stmnt->fetch() != 0){ # proceed if staff exists
                $stmnt -> close();
                echo "<script>alert('Staff with ".$email." email exists');</script>";
            }else{ # proceed if everything is fine
                $stmnt->close();
                $this -> maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid); # first update
                $this -> secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid); # secondary update
                $extra = "./staff_users.php"; # move user back to staff page
                echo "<script>window.location.href='".$extra."'</script>";
            }
        } 
    }

    //insert if second name detected
    public function secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
        $msg = "Select _nID_ FROM _name_ WHERE _name_ = ?"; # check if name exists
        $stmnt1 = $con->prepare($msg);
        $stmnt1->bind_param("s",$sname);
        $stmnt1->execute();
        $stmnt1->bind_result($nid1);
        if($stmnt1->fetch()){ # proceed if name exists
            $stmnt1->close();
            $msg = "UPDATE _staff_ SET _s_name_id_ = ? WHERE _sID_ = ?";
            $stmnt2 = $con->prepare($msg);
            $stmnt2 -> bind_param("is", $nid1, $userid);
            $stmnt2 -> execute();
            $stmnt2->close();
        }else{ # insert new name
            $stmnt1->close();
            $this -> ifnotsecondname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
        }
    }

    //insert for first name
    public function maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
        $msg = "Select _nID_ FROM _name_ WHERE _name_ = ?"; # check if name exists
        $stmnt1 = $con->prepare($msg);
        $stmnt1->bind_param("s",$name);
        $stmnt1->execute();
        $stmnt1->bind_result($nid);
        if($stmnt1->fetch()){ # proceed if name exists
            $stmnt1->close();
            $msg = "Select _tID_ FROM _title_ WHERE _title_name_ = ?"; # chech if title exists
            $stmnt2 = $con->prepare($msg);
            $stmnt2 -> bind_param("s", $title);
            $stmnt2 -> execute();
            $stmnt2 -> bind_result($sid);
            if($stmnt2->fetch()){ # proceed if title exists
                $stmnt2->close();
                $this -> insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
            }else{ # proceed if title not exists
                $stmnt2->close();
                $this -> ifnottitle($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
            }
        }else{ # proceed if name not exists
            $stmnt1->close();
            $this -> ifnotname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
        }
    }
    //update staff into table
    public function insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
        $msg="UPDATE _staff_ SET _name_id_ = ?, _surname_ = ?, _email_ = ?, _title_id_ = ? WHERE _sID_ = ?"; # update staff member informations
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("issii", $nid, $surname, $email, $sid, $userid);
        if($stmnt->execute()){
            echo "<script>alert('Staff has been updated');</script>";
            $stmnt -> close();
        }else{
            echo "<script>alert('Something went wrong');</script>";
            $stmnt -> close();
        }
    }
    //insert if not title
    public function ifnottitle($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
        $msg = "INSERT INTO _title_ (_title_name_) VALUES (?)"; # insert new title
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $title);
        if($stmnt->execute()){
            $stmnt->close();
            $msg = "Select _tID_ FROM _title_ WHERE _title_name_ = ?"; # select title id
            $stmnt4 = $con->prepare($msg);
            $stmnt4 -> bind_param("s", $title);
            $stmnt4 -> execute();
            $stmnt4 -> bind_result($sid);
            if($stmnt4 -> fetch()){ # move to inserting staff update
                $stmnt4 -> close();
                $this -> insertinto($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
            }
        }
    }

    //insert if not name
    public function ifnotname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
        $stmnt = $con->prepare("INSERT INTO _name_ (_name_) VALUES (?);"); # insert new name
        $stmnt -> bind_param("s", $name);
        if($stmnt -> execute()){ # proceed main update from beginning
            $stmnt -> close();
            $this -> maininsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
        }
    }

    //insert if not second name
    public function ifnotsecondname($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid){
         $msg = "INSERT INTO _name_ (_name_) VALUES (?)"; # insert new name
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $sname);
        if($stmnt->execute()){ # proceed secondary update from beginning
            $stmnt->close();
            $this -> secondinsert($con, $name, $sname, $surname, $email, $title, $visible, $nid, $nid1, $sid, $userid);
        }
    }

}

?>