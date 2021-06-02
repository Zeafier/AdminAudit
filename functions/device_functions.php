<?php
include "../functions/XSS.php";
include "../functions/cryp_decrypt.php";
use \Chirp\Cryptor;

//add new device
class addasset{
    function newasset($con){
        if(isset($_POST['add']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ #check user type and session
            $result = "success"; # default result
            $faculty = clean($_POST['faculty']);
            $usertype = clean($_POST['usertype']);
            $location = clean($_POST['location']);
            $device = clean($_POST['device_type']);
            $sn = strtoupper(clean($_POST['serial'])); # serial number
            $tag = strtoupper(clean($_POST['tag']));
            $specs = clean($_POST['specs']);
            
            //add faculty if is not on list
            if($faculty == "Notonlist"){
                $faculty = strtoupper(clean($_POST['faculty2']));
                if(empty($faculty)){
                    $result = "fail";;
                }else{
                    $faculty = $this -> nofaculty($con, $faculty);
                }
            }
            //add usertype if is not on list
            if($usertype == "Notonlist"){
                $usertype = strtoupper(clean($_POST['usertype2']));
                if(empty($usertype)){
                    $result = "fail";;
                }else{
                    $usertype = $this -> nousertype($con, $usertype);
                }
            }
            //add usertype if is not on list
            if($location == "Notonlist"){
                $location = strtoupper(clean($_POST['location2']));
                if(empty($location)){
                    $result = "fail";;
                }else{
                    $location = $this -> nolocation($con, $location);
                }
            }
            //add device if is not on list
            if($device == "Notonlist"){
                $type = clean($_POST['type']);
                $model = clean($_POST['model']);
                $brand = clean($_POST['brand']);
                $device = $this -> noitem($con, $type, $brand, $model);
            }
            //add specs if is not on list
            if($specs == "Notonlist"){
                $specs = strtoupper(clean($_POST['specs2']));
                if(empty($specs)){
                    $result = "fail";;
                }else{
                    $specs = $this -> nospecs($con, $specs);
                }
            }
            
            //check if empty
            if(empty($sn) || empty($tag)){ # check if fields are empty
                echo "<script>alert('One of the field is empty.');</script>";
            }else if($faculty == "fail" || $usertype == "fail" || $location == "fail" || $device == "fail" || $specs == "fail"){ # check if functions failed
                echo "<script>alert('Something went wrong. please try again.');</script>";
            }else if($result == "fail"){ # check if new field was empty
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5'; # prepare encryption class for encryption process
                $crypt = new Cryptor($encryption_key);
                $sn = $crypt -> encrypt($sn);
                $tag = $crypt -> encrypt($tag);
                $msg = "INSERT INTO _devices_(_item_id_, _specs_id_, _SN_, _TAG_, _classes_id_, _faculty_id_, _ut_id_) VALUES(?, ?, ?, ?, ?, ?, ?)";
                $stmnt = $con -> prepare($msg);
                $stmnt->bind_param("iissiii", $device, $specs, $sn, $tag, $location, $faculty, $usertype);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    echo "<script>alert('Item has been added to asset.');</script>";
                    $extra="Add_device.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    $stmnt -> close();
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                }
            }
        }
    }
    
    //add new faculty
    function nofaculty($con, $faculty2){
        $msg = "SELECT _facID_ FROM _faculty_ WHERE _faculty_name_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $faculty2);
        $stmnt -> execute();
        $stmnt -> bind_result($faculty);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $faculty;
        }else{
            $msg = "INSERT INTO _faculty_(_faculty_name_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $faculty2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _facID_ FROM _faculty_ WHERE _faculty_name_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $faculty2);
                $stmnt -> execute();
                $stmnt -> bind_result($faculty);
                $stmnt -> fetch();
                $stmnt -> close();
                return $faculty;
            }else{
                $stmnt -> close();
                $faculty = "fail";
                return $faculty;
            }
        }
    }
    
    //add new user type
    function nousertype($con, $usertype2){
        $msg = "SELECT _utID_ FROM _user_type_ WHERE _utype_name_ = ?"; # check if exists
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $usertype2);
        $stmnt -> execute();
        $stmnt -> bind_result($usertype);
        if($stmnt -> fetch()){ # take id if exists
            $stmnt -> close();
            return $usertype;
        }else{
            $msg = "INSERT INTO _user_type_(_utype_name_) VALUES (?)"; # insert new user type
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $usertype2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _utID_ FROM _user_type_ WHERE _utype_name_ = ?"; # select user type id
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $usertype2);
                $stmnt -> execute();
                $stmnt -> bind_result($usertype);
                $stmnt -> fetch();
                $stmnt -> close();
                return $usertype;
            }else{
                $stmnt -> close();
                $usertype = "fail";
                return $usertype;
            }
        }
    }
    
    //add new brand
    function nolocation($con, $location2){
        $msg = "SELECT _caID_ FROM _classes_ WHERE _classes_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $location2);
        $stmnt -> execute();
        $stmnt -> bind_result($location);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $location;
        }else{
            $stmnt -> close();
            $msg = "INSERT INTO _classes_(_classes_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $location2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _caID_ FROM _classes_ WHERE _classes_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $location2);
                $stmnt -> execute();
                $stmnt -> bind_result($location);
                $stmnt -> fetch();
                $stmnt -> close();
                return $location;
            }else{
                $stmnt -> close();
                $location = "fail";
                return $location;
            }
        }
    }
    
    //add new item
    function noitem($con, $type, $brand, $model){
        //add type if is not on list
        if($type == "Notonlist"){
            $type2 = strtoupper(clean($_POST['type2']));
            if(empty($type2)){
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $type = $this -> notype($con, $type2);
            }
        }
        //add brand if is not on list
        if($brand == "Notonlist"){
            $brand2 = strtoupper(clean($_POST['brand2']));
            if(empty($brand2)){
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $brand = $this -> nobrand($con, $brand2);
            }
        }
        //add model if is not on list
        if($model == "Notonlist"){
            $model2 = strtoupper(clean($_POST['model2']));
            if(empty($model2)){
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $model = $this -> nomodel($con, $model2);
            }
        }
        
        if($type == "fail" || $brand == "fail" || $model =="fail"){ # check if functions failed
            $result = "fail";
            return $result;
        }else{
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?"; # check if item exists
            $stmnt1 = $con->prepare($msg);
            $stmnt1 -> bind_param("iii", $type, $brand, $model);
            $stmnt1 -> execute();
            $stmnt1 -> bind_result($iID);
            if($stmnt1 -> fetch()){ # select if of existing item
                $stmnt1 -> close();
                return $iID;
            }else{
                $stmnt1 -> close();
                $msg = "INSERT INTO _decomission_item_(_typy_ID_, _brand_ID_, _mode_id_) VALUES(?,?,?)"; #insert new device
                $stmnt = $con->prepare($msg);
                $stmnt -> bind_param("iii", $type, $brand, $model);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?"; # slect item id
                    $stmnt1 = $con->prepare($msg);
                    $stmnt1 -> bind_param("iii", $type, $brand, $model);
                    $stmnt1 -> execute();
                    $stmnt1 -> bind_result($iID);
                    if($stmnt1 -> fetch()){
                        $stmnt1 -> close();
                        return $iID;
                    }else{
                        $stmnt1 -> close();
                        $result = "fail";
                        return $result;
                    }
                }else{
                    $stmnt -> close();
                    $result = "fail";
                    return $result;
                }
            }
        }
    }
    
    //add new type
    function notype($con, $type2){
        $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $type2);
        $stmnt -> execute();
        $stmnt -> bind_result($type);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $type;
        }else{
            $msg = "INSERT INTO _types_(_type_name_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $type2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $type2);
                $stmnt -> execute();
                $stmnt -> bind_result($type);
                $stmnt -> fetch();
                $stmnt -> close();
                return $type;
            }else{
                $stmnt -> close();
                $type = "fail";
                return $type;
            }
        }
    }
    
    //add new brand
    function nobrand($con, $brand2){
        $msg = "SELECT _bID_ FROM _brands_ WHERE _brand_name_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $brand2);
        $stmnt -> execute();
        $stmnt -> bind_result($brand);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $brand;
        }else{
            $msg = "INSERT INTO _brands_(_brand_name_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $brand2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _bID_ FROM _brands_ WHERE _brand_name_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $brand2);
                $stmnt -> execute();
                $stmnt -> bind_result($brand);
                $stmnt -> fetch();
                $stmnt -> close();
                return $brand;
            }else{
                $stmtn -> close();
                $brand = "fail";
                return $brand;
            }
        }
    }
    
    //add new model
    function nomodel($con, $model2){
        $msg = "SELECT _mID_ FROM _model_ WHERE _model_name_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $model2);
        $stmnt -> execute();
        $stmnt -> bind_result($model);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $model;
        }else{
            $msg = "INSERT INTO _model_(_model_name_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $model2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _mID_ FROM _model_ WHERE _model_name_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $model2);
                $stmnt -> execute();
                $stmnt -> bind_result($model);
                $stmnt -> fetch();
                $stmnt -> close();
                return $model;
            }else{
                $stmnt -> close();
                $model = "fail";
                return $model;
            }
        }
    }
    
    //add new specs
    function nospecs($con, $specs2){
        $msg = "SELECT _secID_ FROM _specs_ WHERE _specs_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $specs2);
        $stmnt -> execute();
        $stmnt -> bind_result($specs);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $specs;
        }else{
            $stmnt -> close();
            $msg = "INSERT INTO _specs_(_specs_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $specs2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _secID_ FROM _specs_ WHERE _specs_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $specs2);
                $stmnt -> execute();
                $stmnt -> bind_result($specs);
                $stmnt -> fetch();
                $stmnt -> close();
                return $specs;
            }else{
                $stmnt -> close();
                $model = "fail";
                return $specs;
            }
        }
    }
}

//remove device
class remove{
    function removeitem($con){
        if(isset($_POST['remove']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check user account and session
            foreach($_POST['check_box_delete'] as $id)
            {
                $msg = "DELETE FROM _devices_ WHERE _devID_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $id);
                $stmnt -> execute();
                $stmnt -> close();
            }
            echo "<script>alert('Items has been removed');</script>";
            $extra="general_audit.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }
    }
}

//eddit device
class editasset{
    function edititem($con, $assetid){
        if(isset($_POST['edit']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check user account and session
            $result = "success"; # default result
            $faculty = clean($_POST['faculty']);
            $usertype = clean($_POST['usertype']);
            $location = clean($_POST['location']);
            $device = clean($_POST['device_type']);
            $sn = strtoupper(clean($_POST['serial']));
            $tag = strtoupper(clean($_POST['tag']));
            $specs = clean($_POST['specs']);

            //add faculty if is not on list
            if($faculty == "Notonlist"){
                $faculty = strtoupper(clean($_POST['faculty2']));
                if(empty($faculty)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $faculty = $addnew -> nofaculty($con, $faculty); # get faculty id
                }
            }
            //add usertype if is not on list
            if($usertype == "Notonlist"){
                $usertype = strtoupper(clean($_POST['usertype2']));
                if(empty($usertype)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $usertype = $addnew -> nousertype($con, $usertype);
                }
            }
            //add usertype if is not on list
            if($location == "Notonlist"){
                $location = strtoupper(clean($_POST['location2']));
                if(empty($location)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $location = $addnew -> nolocation($con, $location);
                }
            }
            //add device if is not on list
            if($device == "Notonlist"){
                $type = clean($_POST['type']);
                $model = clean($_POST['model']);
                $brand = clean($_POST['brand']);
                $addnew = new addasset();
                $device = $addnew -> noitem($con, $type, $brand, $model);
            }
            //add specs if is not on list
            if($specs == "Notonlist"){
                $specs = strtoupper(clean($_POST['specs2']));
                if(empty($specs)){
                    $result = "fail";
                }else{
                    $addnew = new addasset();
                    $specs = $addnew -> nospecs($con, $specs);
                }
            }

            //check if empty
            if(empty($sn) || empty($tag)){ # check if fields are empty
                echo "<script>alert('One of the field is empty.');</script>";
            }else if($faculty == "fail" || $usertype == "fail" || $location == "fail" || $device == "fail" || $specs == "fail"){ # check if any of the function failed
                echo "<script>alert('Something went wrong. please try again.');</script>";
            }else if($result == "fail"){ #check if new fields are ampty
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5'; # prepare key for encryption
                $crypt = new Cryptor($encryption_key);
                $sn = $crypt -> encrypt($sn);
                $tag = $crypt -> encrypt($tag);
                $msg = "UPDATE _devices_ SET _item_id_ = ?, _specs_id_=?, _SN_=?, _TAG_=?, _classes_id_=?, _faculty_id_=?, _ut_id_=? WHERE _devID_ = ?"; # update device
                $stmnt = $con -> prepare($msg);
                $stmnt->bind_param("iissiiii", $device, $specs, $sn, $tag, $location, $faculty, $usertype, $assetid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    echo "<script>alert('Asset item has been eddited.');</script>";
                    $extra="general_audit.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    $stmnt -> close();
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                }
            }
        }
    }
}

//add new item
class additem{
    function addnew($con){
        if(isset($_POST['add']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $result = "success";
            $type = clean($_POST['type']);
            $model = clean($_POST['model']);
            $brand = clean($_POST['brand']);
            $newtype = new addasset();
            //add type if is not on list
            if($type == "Notonlist"){
                $type2 = strtoupper(clean($_POST['type2']));
                if(empty($type2)){
                    $result = "fail";
                    return $result;
                }else{
                    $type = $newtype -> notype($con, $type2);
                }
            }
            //add brand if is not on list
            if($brand == "Notonlist"){
                $brand2 = strtoupper(clean($_POST['brand2']));
                if(empty($brand2)){
                    $result = "fail";
                    return $result;
                }else{;
                    $brand = $newtype -> nobrand($con, $brand2);
                }
            }
            //add model if is not on list
            if($model == "Notonlist"){
                $model2 = strtoupper(clean($_POST['model2']));
                if(empty($model2)){
                    $result = "fail";
                    return $result;
                }else{
                    $model = $newtype -> nomodel($con, $model2);
                }
            }
            
            if($result == "fail"){
                echo "<script>alert('Something went wrong.');</script>";
                $extra="add_item.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else{
                if($newtype -> noitem($con, $type, $brand, $model) == "fail"){
                    echo "<script>alert('Something went wrong. Please try again');</script>";
                    $extra="add_item.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    echo "<script>alert('Item has been added.');</script>";
                    $extra="add_item.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }
        }
    }
}

//edit item
class edititem{
    function editi($con, $itemid){
        if(isset($_POST['edit']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $result = "success";
            $type = clean($_POST['type']);
            $model = clean($_POST['model']);
            $brand = clean($_POST['brand']);
            $newtype = new addasset();
            //add type if is not on list
            if($type == "Notonlist"){
                $type2 = strtoupper(clean($_POST['type2']));
                if(empty($type2)){
                    $result = "fail";
                    return $result;
                }else{
                    $type = $newtype -> notype($con, $type2);
                }
            }
            //add brand if is not on list
            if($brand == "Notonlist"){
                $brand2 = strtoupper(clean($_POST['brand2']));
                if(empty($brand2)){
                    $result = "fail";
                    return $result;
                }else{;
                    $brand = $newtype -> nobrand($con, $brand2);
                }
            }
            //add model if is not on list
            if($model == "Notonlist"){
                $model2 = strtoupper(clean($_POST['model2']));
                if(empty($model2)){
                    $result = "fail";
                    return $result;
                }else{
                    $model = $newtype -> nomodel($con, $model2);
                }
            }
            
            if($result == "fail"){
                echo "<script>alert('Something when wrong, Please try again.');</script>";
            }else{
                $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?";
                $stmnt1 = $con->prepare($msg);
                $stmnt1 -> bind_param("iii", $type, $brand, $model);
                $stmnt1 -> execute();
                $stmnt1 -> bind_result($iID);
                if($stmnt1 -> fetch()){
                    $stmnt1 -> close();
                    echo "<script>alert('Item already exists.');</script>";
                    $extra="devices.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    $stmnt1 -> close();
                    $msg = "UPDATE _decomission_item_ SET _typy_ID_ = ?, _brand_ID_ = ?,  _mode_id_ = ? WHERE _di_ID_ = ?";
                    $stmnt = $con->prepare($msg);
                    $stmnt -> bind_param("iiii", $type, $brand, $model, $itemid);
                    if($stmnt -> execute()){
                        $stmnt -> close();
                        echo "<script>alert('Item has been updated.');</script>";
                        $extra="devices.php";
                        echo "<script>window.location.href='".$extra."'</script>";
                    }else{
                        $stmnt -> close();
                        $result = "fail";
                        return $result;
                    }
                }
            }
        }
    }
}

//add names
class addname{
    function newname($con){
        if(isset($_POST['add']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check account type and permissions 
            $result = "success"; # default result
            $faculty = clean($_POST['faculty']);
            $usertype = clean($_POST['usertype']);
            $location = clean($_POST['location']);
            $device = clean($_POST['device_type']);
            $sn = strtoupper(clean($_POST['devname'])); # device name
            $specs = clean($_POST['additional']); # additional informations
            $numberdev = clean($_POST['numberdev']); # number of added devices
            
            //add faculty if is not on list
            if($faculty == "Notonlist"){
                $faculty = strtoupper(clean($_POST['faculty2']));
                if(empty($faculty)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $faculty = $addnew -> nofaculty($con, $faculty);
                }
            }
            //add usertype if is not on list
            if($usertype == "Notonlist"){
                $usertype = strtoupper(clean($_POST['usertype2']));
                if(empty($usertype)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $usertype = $addnew -> nousertype($con, $usertype);
                }
            }
            //add usertype if is not on list
            if($location == "Notonlist"){
                $location = strtoupper(clean($_POST['location2']));
                if(empty($location)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $location = $addnew -> nolocation($con, $location);
                }
            }
            //add device if is not on list
            if($device == "Notonlist"){
                $type = clean($_POST['type']);
                $model = clean($_POST['model']);
                $brand = clean($_POST['brand']);
                $addnew = new addasset();
                $device = $addnew -> noitem($con, $type, $brand, $model);
            }
            
            if(empty($specs)){
                $specs = "NONE";
            }
            
            //check if empty
            if(empty($sn) || empty($numberdev)){ # check if fields are ampty
                echo "<script>alert('One of the field is empty.');</script>";
            }else if($faculty == "fail" || $usertype == "fail" || $location == "fail" || $device == "fail"){ # check if methods failed
                echo "<script>alert('Something went wrong. please try again.');</script>";
            }else if($result == "fail"){ # check if new
                echo "<script>alert('One of the field is empty.');</script>";
            }else if(!is_numeric($numberdev) || $numberdev<=0 || is_int($numberdev)){
                echo "<script>alert('Incorrect value.');</script>";
            }else{
                $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5';
                $crypt = new Cryptor($encryption_key);
                $sn1 = "none"; $tag="none"; $specsif = 1;
                if($numberdev == 1){ # if number of added names is 1
                    $sn = $crypt -> encrypt($sn); # encrypt decice name
                    $msg = "INSERT INTO _devices_(_item_id_, _specs_id_, _SN_, _TAG_, _classes_id_, _faculty_id_, _ut_id_) VALUES(?, ?, ?, ?, ?, ?, ?)"; #insert device to asset
                    $stmnt = $con -> prepare($msg);
                    $stmnt->bind_param("iissiii", $device, $specsif, $sn1, $tag, $location, $faculty, $usertype);
                    $stmnt -> execute();
                    $stmnt -> close();
                    $msg = "INSERT INTO _devices_names_(_devID_, _device_name_, _additional_, _userID_, _facID_, _locID_) VALUES(?, ?, ?, ?, ? ,?)"; # insert name
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("issiii", $device, $sn, $specs, $usertype, $faculty, $location);
                    if($stmnt -> execute()){
                        $stmnt -> close();
                        $result = "success";
                    }else{
                        $stmnt -> close();
                        $result = "fail";
                    }
                }else{ # if is more
                    for ($i = 1; $i <= $numberdev; $i++){
                        $sninsert = $crypt -> encrypt($sn);
                        $msg = "INSERT INTO _devices_(_item_id_, _specs_id_, _SN_, _TAG_, _classes_id_, _faculty_id_, _ut_id_) VALUES(?, ?, ?, ?, ?, ?, ?)"; #insert device to asset
                        $stmnt = $con -> prepare($msg);
                        $stmnt->bind_param("iissiii", $device, $specsif, $sn1, $tag, $location, $faculty, $usertype);
                        $stmnt -> execute();
                        $stmnt -> close();
                        $msg = "INSERT INTO _devices_names_(_devID_, _device_name_, _additional_, _userID_, _facID_, _locID_) VALUES(?, ?, ?, ?, ? ,?)"; #insert name 
                        $stmnt = $con -> prepare($msg);
                        $stmnt -> bind_param("issiii", $device, $sninsert, $specs, $usertype, $faculty, $location);
                        if($stmnt -> execute()){
                            $stmnt -> close();
                            $exploded = explode('-', $sn); # split name in the end to input after -
                            $sn = rtrim($sn, end($exploded)); # take name without ending
                            $newdit = end($exploded) + 1; # get item number and add 1 to get new name
                            $sn .= $newdit; # rejoin name with new number
                            $result = "success";
                        }else{
                            $stmnt -> close();
                            $result = "fail";
                            break;
                        }
                    }
                    return $result;
                }
            }
        }
    }
}

//edit name
class editname{
    function edditname($con){
        $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5';# prepare key for encryption
        $crypt = new Cryptor($encryption_key);
        //edit name in main console
        if(isset($_POST['edit']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check user type account and session
            foreach($_POST['check_box_delete'] as $id)
            {
                $id = clean($id); #checkbox id
                $sn = strtoupper(clean($_POST['devname'.$id.''])); # device name
                $tag = strtoupper(clean($_POST['additional'.$id.''])); # additional information
                $sn = $crypt -> encrypt($sn); # encrypt device name
                $msg = "UPDATE _devices_names_ SET _device_name_ = ?, _additional_ = ? WHERE _dn_ID_ =?"; # update information for selected item
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("ssi", $sn, $tag, $id);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    $result = "success";
                }else{
                    $stmnt -> close();
                    $result = "fail";
                    break;
                }
            }
        }
        //remove items
        if(isset($_POST['remove']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check user type account and session
            foreach($_POST['check_box_delete'] as $id)
            {
                $id = clean($id); # checkbox id
                $msg = "DELETE FROM _devices_names_ WHERE _dn_ID_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $id);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    $result = "success";
                }else{
                    $stmnt -> close();
                    $result = "fail";
                    break;
                }
            }
        }
        
        //edit name in page
        if(isset($_POST['editname'])){
            $nameid = clean($_GET['uid']); #device name id
            $result = "success";
            $faculty = clean($_POST['faculty']);
            $usertype = clean($_POST['usertype']);
            $location = clean($_POST['location']);
            $device = clean($_POST['device_type']); # device type
            $sn = strtoupper(clean($_POST['devname'])); # device name
            $specs = clean($_POST['additional']); # additional info
            
            //add faculty if is not on list
            if($faculty == "Notonlist"){
                $faculty = strtoupper(clean($_POST['faculty2']));
                if(empty($faculty)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $faculty = $addnew -> nofaculty($con, $faculty);
                }
            }
            //add usertype if is not on list
            if($usertype == "Notonlist"){
                $usertype = strtoupper(clean($_POST['usertype2']));
                if(empty($usertype)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $usertype = $addnew -> nousertype($con, $usertype);
                }
            }
            //add usertype if is not on list
            if($location == "Notonlist"){
                $location = strtoupper(clean($_POST['location2']));
                if(empty($location)){
                    $result = "fail";;
                }else{
                    $addnew = new addasset();
                    $location = $addnew -> nolocation($con, $location);
                }
            }
            //add device if is not on list
            if($device == "Notonlist"){
                $type = clean($_POST['type']);
                $model = clean($_POST['model']);
                $brand = clean($_POST['brand']);
                $addnew = new addasset();
                $device = $addnew -> noitem($con, $type, $brand, $model);
            }
            
            if(empty($specs)){
                $specs = "NONE";
            }
            
            //check if empty
            if(empty($sn)){ # check if empty
                $result = "empty";
                return $result;
            }else if($faculty == "fail" || $usertype == "fail" || $location == "fail" || $device == "fail"){ # check if any of methods failed
                $result = "fail";
                return $result;
            }else if($result == "fail"){ # check if new fields were empty
                $result = "empty";
                return $result;
            }else{
                $sn = $crypt -> encrypt($sn); # encrypt name
                $msg = "UPDATE _devices_names_ SET _devID_ = ?, _device_name_ = ?, _additional_ = ?, _userID_ = ?, _facID_ = ?, _locID_ = ? WHERE _dn_ID_ = ?"; # update name
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("issiiii", $device, $sn, $specs, $usertype, $faculty, $location, $nameid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    $result = "success";
                }else{
                    $stmnt -> close();
                    $result = "fail";
                }
                return $result;
            }
        }
    }
}
?>