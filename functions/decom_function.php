<?php
include "../functions/XSS.php";
include "../functions/cryp_decrypt.php";
use \Chirp\Cryptor;

//add new decomission
class additem{
    function newdecom($con){
        if(isset($_POST['add']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $type = clean($_POST['type']);
            $brand = clean($_POST['brand']);
            $model = clean($_POST['model']);
            $sn = strtoupper(clean($_POST['sn']));
            $tag = clean($_POST['tag']);
            $reason = clean($_POST['reason']);
            $sdate = clean($_POST['DecomissionDate']);
            
            //add type if is not on list
            if($type == "Notonlist"){
                $type2 = strtoupper(clean($_POST['type2']));
                if(empty($type2)){ # check if new field is empty
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
            //add reason if is not on list
            if($reason == "Notonlist"){
                $reason2 = clean($_POST['reason2']);
                if(empty($reason2)){
                    echo "<script>alert('One of the field is empty.');</script>";
                }else{
                    $reason = $this -> noreason($con, $reason2);
                }
            }
            
            //check if empty
            if(empty($sn) || empty($tag) || empty($sdate)){ # check if fields are empty
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $msg = "SELECT _dcID_, _quantity_ FROM _decom_quantity_ INNER JOIN _types_ ON _types_._tID_=_decom_quantity_._decom_ID INNER JOIN _reason_ ON _reason_._rID_=_decom_quantity_._reason_id_ WHERE _past_present_=1 AND _decom_ID = ? AND _reason_id_ = ?"; # chech if general item exists
                $stmnt = $con -> prepare($msg);
                $stmnt->bind_param("ii", $type, $reason);
                $stmnt -> execute();
                $stmnt -> bind_result($dcID, $QTY);
                if($stmnt -> fetch()){
                    $stmnt -> close();
                    $this -> decomexists($con, $dcID, $QTY, $reason, $type, $sn, $tag, $brand, $model, $sdate); # proceed if exists
                }else{
                    $stmnt -> close();
                    $this -> newdecomission($con, $reason, $type, $sn, $tag, $brand, $model, $sdate); # proceed if not exists
                }
            }
        }
    }
    
    //add new type
    function notype($con, $type2){
        $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?"; # check if type exists
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $type2);
        $stmnt -> execute();
        $stmnt -> bind_result($type);
        if($stmnt -> fetch()){ # return id if exists
            $stmnt -> close();
            return $type;
        }else{
            $msg = "INSERT INTO _types_(_type_name_) VALUES (?)"; # insert new type
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $type2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?"; # select inserted type and get id
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $type2);
                $stmnt -> execute();
                $stmnt -> bind_result($type);
                $stmnt -> fetch();
                $stmnt -> close();
                return $type;
            }else{
                $stmnt -> close();
                echo "<script>alert('Something went wrong.');</script>";
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
                echo "<script>alert('Something went wrong.');</script>";
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
                echo "<script>alert('Something went wrong.');</script>";
            }
        }
    }
    //add new reason
    function noreason($con, $reason2){
        $msg = "SELECT _rID_ FROM _reason_ WHERE _reason_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $reason2);
        $stmnt -> execute();
        $stmnt -> bind_result($reason);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $reason;
        }else{
            $msg = "INSERT INTO _reason_(_reason_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $reason2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _rID_ FROM _reason_ WHERE _reason_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $reason2);
                $stmnt -> execute();
                $stmnt -> bind_result($reason);
                $stmnt -> fetch();
                $stmnt -> close();
                return $reason;
            }else{
                echo "<script>alert('Something went wrong.');</script>";
            }
        }
    }
    //proceed and finish if item exists
    function itemexists($con, $type, $iID, $sn, $tag, $reason, $dcid, $sdate){
        $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5'; # prepare key for encryption
        $crypt = new Cryptor($encryption_key);
        $sn = $crypt -> encrypt($sn);
        $tag = $crypt -> encrypt($tag);
        $msg = "INSERT INTO _decomission_(_item_id_, _SN_, _TAG_, _dec_visible_, _dec_qty_, _day_added_) VALUES (?, ?, ?, 1, ?, ?)"; # insert new decomission item
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("issis", $iID, $sn, $tag, $dcid, $sdate);
        if($stmnt -> execute()){
            $stmnt -> close();
            unset($sn);
            unset($tag);
            echo "<script>alert('Item has been added to decomission.');</script>";
        }else{
            //substract if item exists
            $msg = "SELECT _quantity_ FROM _decom_quantity_ WHERE _dcID_ = ?"; # reverse changes if something goes wrong
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $dcid);
            $stmnt -> execute();
            $stmnt -> bind_result($qty);
            $stmnt -> fetch();
            $stmnt -> close();
            $nqty = $qty - 1;
            $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ =? AND _past_present_ = 1"; # update general information
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $nqty, $dcid);
            $stmnt -> execute();
            $stmnt -> close();
            unset($sn);
            unset($tag);
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //add new item
    function noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcid, $sdate){
        $msg = "INSERT INTO _decomission_item_(_typy_ID_, _brand_ID_, _mode_id_) VALUES(?,?,?)"; # insert new item type
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("iii", $type, $brand, $model);
        if($stmnt -> execute()){
            $stmnt -> close();
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?"; # select item type id
            $stmnt1 = $con->prepare($msg);
            $stmnt1 -> bind_param("iii", $type, $brand, $model);
            $stmnt1 -> execute();
            $stmnt1 -> bind_result($iID);
            if($stmnt1 -> fetch()){ # return value
                $stmnt1 -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcid, $sdate);
            }else{
                echo "<script>alert('Something went wrong.');</script>";
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //add new decomission
    function newdecomission($con, $reason, $type, $sn, $tag, $brand, $model, $sdate){
        $date = date("d/m/Y");
        $qty = 1;
        $msg = "INSERT INTO _decom_quantity_(_decom_ID, _quantity_, _past_present_, _reason_id_, _decom_date_) VALUES (?, ?, 1, ?, ?)"; # insert new general decomission
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("iiis", $type, $qty, $reason, $date);
        if($stmnt->execute()){
            $stmnt->close();
            //select decomission quantity id and save as parameter
            $msg = "SELECT _dcID_ FROM _decom_quantity_ WHERE _decom_ID = ? AND _reason_id_ = ? AND _past_present_ = 1";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $type, $reason);
            $stmnt -> execute();
            $stmnt -> bind_result($dcID);
            $stmnt -> fetch();
            $stmnt -> close();
            //check if item type exists
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?";
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("iii", $type, $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($iID);
            if($stmnt -> fetch()){
                $stmnt -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcID, $sdate);
            }else{
                $stmnt -> close();
                $this -> noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcID, $sdate);
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //proceed if decomission exists
    function decomexists($con, $dcID, $QTY, $reason, $type, $sn, $tag, $brand, $model, $sdate){
        $nQTY = $QTY + 1;
        $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ? AND _past_present_ = 1"; # update quantity if general decom exists
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("ii",$nQTY, $dcID);
        if($stmnt->execute()){
            $stmnt->close();
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?"; # check if item type exists
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("iii", $type, $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($iID);
            if($stmnt -> fetch()){
                $stmnt -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcID, $sdate);
            }else{
                $stmnt -> close();
                $this -> noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcID, $sdate);
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
}

//remove decomission
class removedecom{
    //remove decomission item from list
    function remove($con){
        if(isset($_GET['uid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $decid = clean($_GET['uid']);
            //find decomission quantity
            $msg = "SELECT _dec_qty_ FROM _decomission_ WHERE _decID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $decid);
            $stmnt -> execute();
            $stmnt -> bind_result($quanid);
            if($stmnt -> fetch()){
                $stmnt -> close();
                //select quantity to be removed
                $msg = "SELECT _quantity_ FROM _decom_quantity_ WHERE _dcID_ = ?";
                $smt = $con -> prepare($msg);
                $smt -> bind_param("i", $quanid);
                $smt -> execute();
                $smt -> bind_result($oldqty);
                if($smt -> fetch()){
                    $smt -> close();
                    //select quantity and update it
                    $newqty = $oldqty - 1;
                    $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ?";
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("ii", $newqty, $quanid);
                    if($stmnt -> execute()){
                        $stmnt -> close();
                        //remove item from decomission
                        $msg = "DELETE FROM _decomission_ WHERE _decID_ = ?";
                        $stmnt = $con -> prepare($msg);
                        $stmnt -> bind_param("i", $decid);
                        if($stmnt -> execute()){
                            $stmnt -> close();
                            echo "<script>alert('Item has been removed');</script>";
                            $extra = "./decomission_item.php";
                            echo "<script>window.location.href='".$extra."'</script>";
                        }else{
                            //revert changes something goes wrong
                            $stmnt -> close();
                            $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ?";
                            $stmnt = $con -> prepare($msg);
                            $stmnt -> bind_param("ii", $oldqty, $quanid);
                            $stmnt -> execute();
                            $stmnt -> close();
                            echo "<script>alert('Something went wrong');</script>";
                            $extra = "./decomission_item.php";
                            echo "<script>window.location.href='".$extra."'</script>";
                        }
                    }else{
                        echo "<script>alert('Something went wrong');</script>";
                        $extra = "./decomission_item.php";
                        echo "<script>window.location.href='".$extra."'</script>";
                    }
                }else{
                    echo "<script>alert('Something went wrong');</script>";
                    $extra = "./decomission_item.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }
        }
    }
}

//update decomission
class updatedecom{
    function update($con){
        if(isset($_POST['update']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # checlk user account and session
            $decID = clean($_GET['uid']);
            $type = clean($_POST['type']);
            $brand = clean($_POST['brand']);
            $model = clean($_POST['model']);
            $sn = clean($_POST['sn']); # serial number
            $tag = clean($_POST['tag']); # asset tag
            $reason = clean($_POST['reason']);
            $sdate = clean($_POST['DecomissionDate']);
            
            //add type if is not on list
            if($type == "Notonlist"){
                $type2 = clean($_POST['type2']);
                if(empty($type2)){
                    echo "<script>alert('One of the field is empty.');</script>";
                }else{
                    $type = $this -> notype($con, $type2);
                }
            }
            //add brand if is not on list
            if($brand == "Notonlist"){
                $brand2 = clean($_POST['brand2']);
                if(empty($brand2)){
                    echo "<script>alert('One of the field is empty.');</script>";
                }else{
                    $brand = $this -> nobrand($con, $brand2);
                }
            }
            //add model if is not on list
            if($model == "Notonlist"){
                $model2 = clean($_POST['model2']);
                if(empty($model2)){
                    echo "<script>alert('One of the field is empty.');</script>";
                }else{
                    $model = $this -> nomodel($con, $model2);
                }
            }
            //add reason if is not on list
            if($reason == "Notonlist"){
                $reason2 = clean($_POST['reason2']);
                if(empty($reason2)){
                    echo "<script>alert('One of the field is empty.');</script>";
                }else{
                    $reason = $this -> noreason($con, $reason2);
                }
            }
            //remove eddited item
            $removed = $this -> removeold($con, $decID);
            
            if($removed == "fail"){ # check if removal function failed
                echo "<script>alert('Something went wrong.');</script>";
            }else if(empty($sn) || empty($tag)){ # check if fields are ampty
                echo "<script>alert('One of the field is empty.');</script>";
            }else{
                $msg = "SELECT _dcID_, _quantity_ FROM _decom_quantity_ INNER JOIN _types_ ON _types_._tID_=_decom_quantity_._decom_ID INNER JOIN _reason_ ON _reason_._rID_=_decom_quantity_._reason_id_ WHERE _past_present_=1 AND _decom_ID = ? AND _reason_id_ = ?"; # check if general decom exists
                $stmnt = $con -> prepare($msg);
                $stmnt->bind_param("ii", $type, $reason);
                $stmnt -> execute();
                $stmnt -> bind_result($dcID, $QTY);
                if($stmnt -> fetch()){
                    $stmnt -> close();
                    $this -> decomexists($con, $dcID, $QTY, $reason, $type, $sn, $tag, $brand, $model, $sdate);
                }else{
                    $stmnt -> close();
                    $this -> newdecomission($con, $reason, $type, $sn, $tag, $brand, $model, $sdate);
                }
            }
        }
    }
    
    //Remove old record
    function removeold($con, $decID){
        //find decomission quantity
        $suc = "success";
        $fail = "fail";
        $msg = "SELECT _dec_qty_ FROM _decomission_ WHERE _decID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $decID);
        $stmnt -> execute();
        $stmnt -> bind_result($quanid);
        if($stmnt -> fetch()){
            $stmnt -> close();
            //select quantity to be removed
            $msg = "SELECT _quantity_ FROM _decom_quantity_ WHERE _dcID_ = ?";
            $smt = $con -> prepare($msg);
            $smt -> bind_param("i", $quanid);
            $smt -> execute();
            $smt -> bind_result($oldqty);
            if($smt -> fetch()){
                $smt -> close();
                //select quantity and update it
                $newqty = $oldqty - 1;
                $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("ii", $newqty, $quanid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    //remove item from decomission
                    $msg = "DELETE FROM _decomission_ WHERE _decID_ = ?";
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("i", $decID);
                    if($stmnt -> execute()){
                        $stmnt -> close();
                        return $suc;
                    }else{
                        //revert changes something goes wrong
                        $stmnt -> close();
                        $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ?";
                        $stmnt = $con -> prepare($msg);
                        $stmnt -> bind_param("ii", $oldqty, $quanid);
                        $stmnt -> execute();
                        $stmnt -> close();
                        return $fail;
                    }
                }else{
                    return $fail;
                }
            }else{
                return $fail;
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
                echo "<script>alert('Something went wrong.');</script>";
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
                echo "<script>alert('Something went wrong.');</script>";
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
                echo "<script>alert('Something went wrong.');</script>";
            }
        }
    }
    
    //add new reason
    function noreason($con, $reason2){
        $msg = "SELECT _rID_ FROM _reason_ WHERE _reason_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $reason2);
        $stmnt -> execute();
        $stmnt -> bind_result($reason);
        if($stmnt -> fetch()){
            $stmnt -> close();
            return $reason;
        }else{
            $msg = "INSERT INTO _reason_(_reason_) VALUES (?)";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $reason2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _rID_ FROM _reason_ WHERE _reason_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $reason2);
                $stmnt -> execute();
                $stmnt -> bind_result($reason);
                $stmnt -> fetch();
                $stmnt -> close();
                return $reason;
            }else{
                echo "<script>alert('Something went wrong.');</script>";
            }
        }
    }
    
    //proceed if item exists
    function itemexists($con, $type, $iID, $sn, $tag, $reason, $dcid, $sdate){
        $encryption_key = 'CKXH!U7RZY3EFD70@LS1ZG4E8WQBOVI6AMJ5';
        $crypt = new Cryptor($encryption_key);
        $sn = $crypt -> encrypt($sn);
        $tag = $crypt -> encrypt($tag);
        $msg = "INSERT INTO _decomission_(_item_id_, _SN_, _TAG_, _dec_visible_, _dec_qty_, _day_added_) VALUES (?, ?, ?, 1, ?, ?)";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("issis", $iID, $sn, $tag, $dcid, $sdate);
        if($stmnt -> execute()){
            $stmnt -> close();
            unset($sn);
            unset($tag);
            echo "<script>alert('Item has been updated.');</script>";
            $extra = "decomission_item.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }else{
            //substract if item exists
            $msg = "SELECT _quantity_ FROM _decom_quantity_ WHERE _dcID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $dcid);
            $stmnt -> execute();
            $stmnt -> bind_result($qty);
            $stmnt -> fetch();
            $stmnt -> close();
            $nqty = $qty - 1;
            $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ =? AND _past_present_ = 1";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $nqty, $dcid);
            $stmnt -> execute();
            $stmnt -> close();
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //add new item
    function noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcid, $sdate){
        $msg = "INSERT INTO _decomission_item_(_typy_ID_, _brand_ID_, _mode_id_) VALUES(?,?,?)";
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("iii", $type, $brand, $model);
        if($stmnt -> execute()){
            $stmnt -> close();
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?";
            $stmnt1 = $con->prepare($msg);
            $stmnt1 -> bind_param("iii", $type, $brand, $model);
            $stmnt1 -> execute();
            $stmnt1 -> bind_result($iID);
            if($stmnt1 -> fetch()){
                $stmnt1 -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcid, $sdate);
            }else{
                echo "<script>alert('Something went wrong.');</script>";
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //add new decomission
    function newdecomission($con, $reason, $type, $sn, $tag, $brand, $model, $sdate){
        $date = date("d/m/Y");
        $qty = 1;
        $msg = "INSERT INTO _decom_quantity_(_decom_ID, _quantity_, _past_present_, _reason_id_, _decom_date_) VALUES (?, ?, 1, ?, ?)";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("iiis", $type, $qty, $reason, $date);
        if($stmnt->execute()){
            $stmnt->close();
            //select decomission quantity id and save as parameter
            $msg = "SELECT _dcID_ FROM _decom_quantity_ WHERE _decom_ID = ? AND _reason_id_ = ? AND _past_present_ = 1";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $type, $reason);
            $stmnt -> execute();
            $stmnt -> bind_result($dcID);
            $stmnt -> fetch();
            $stmnt -> close();
            //check if items exists
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?";
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("iii", $type, $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($iID);
            if($stmnt -> fetch()){
                $stmnt -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcID, $sdate);
            }else{
                $stmnt -> close();
                $this -> noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcID, $sdate);
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
    
    //proceed if decomission exists
    function decomexists($con, $dcID, $QTY, $reason, $type, $sn, $tag, $brand, $model, $sdate){
        $nQTY = $QTY + 1;
        $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ? AND _past_present_ = 1";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("ii",$nQTY, $dcID);
        if($stmnt->execute()){
            $stmnt->close();
            $msg = "SELECT _di_ID_ FROM _decomission_item_ WHERE _typy_ID_ = ? AND _brand_ID_ = ? AND _mode_id_ = ?";
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("iii", $type, $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($iID);
            if($stmnt -> fetch()){
                $stmnt -> close();
                $this -> itemexists($con, $type, $iID, $sn, $tag, $reason, $dcID, $sdate);
            }else{
                $stmnt -> close();
                $this -> noitem($con, $type, $brand, $model, $sn, $tag, $reason, $dcID, $sdate);
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
}

//remove old decomission
class olddecom{
    function old($con){
        //retrive old decomission
        if(isset($_GET['uid']) && !empty($_SESSION['login'])){
            $adminid=clean($_GET['uid']);
            $msg = "SELECT _reason_id_, _decom_ID, _quantity_ FROM _decom_quantity_ WHERE _dcID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $adminid);
            $stmnt -> execute();
            $stmnt -> bind_result($reason, $type, $oldQTY);
            $stmnt -> fetch();
            $stmnt -> close();
            //check if decomission exists before recovering
            $msg = "SELECT _dcID_, _quantity_ FROM _decom_quantity_ WHERE _reason_id_ = ? AND _decom_ID = ? AND _past_present_ = 1";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $reason, $type);
            $stmnt -> execute();
            $stmnt -> bind_result($dcID, $currentQTY);
            if($stmnt -> fetch()){
                $stmnt -> close();
                $msg = "UPDATE _decomission_ SET _dec_visible_ = 1, _dec_qty_ = ? WHERE _dec_qty_ = ?"; # update decommission items visibility
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("ii", $dcID, $adminid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    $total = $oldQTY + $currentQTY;
                    $msg = "UPDATE _decom_quantity_ SET _quantity_ = ? WHERE _dcID_ = ?"; # update quantity of general decom
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("ii", $total, $dcID);
                    $stmnt -> execute();
                    $stmnt->close();
                    $msg = "DELETE FROM _decom_quantity_ WHERE _dcID_ = ?"; # remove old record of general decom
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("i", $adminid);
                    $stmnt -> execute();
                    $stmnt->close();
                    echo "<script>alert('Decomission has been recovered');</script>";
                    $extra="past_dec.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                    exit();
                }else{
                    $stmnt -> close();
                    echo "<script>alert('Something went wrong');</script>";
                    $extra="past_dec.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }else{
                $stmnt -> close();
                //update decomission quantity
                $msg = "UPDATE _decom_quantity_ SET _past_present_ = 1 WHERE _dcID_ = ?"; # update decom items visibility
                $stmnt = $con->prepare($msg);
                $stmnt -> bind_param("i", $adminid);
                if($stmnt -> execute()){
                    $stmnt->close();
                    //update decomission items
                    $msg = "UPDATE _decomission_ SET _dec_visible_ = 1 WHERE _dec_qty_ = ?"; # update general update to current
                    $stmnt = $con -> prepare($msg);
                    $stmnt -> bind_param("i", $adminid);
                    $stmnt -> execute();
                    $stmnt -> close();
                    echo "<script>alert('Decomission has been recovered');</script>";
                    $extra="past_dec.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                    exit();
                }
            }

        }
        
        //remove old decomission
        if(isset($_GET['remid']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $remid = clean($_GET['remid']);
            $msg = "DELETE FROM _decomission_ WHERE _dec_qty_ = ?"; # remove all items in group
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $remid);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "DELETE FROM _decom_quantity_ WHERE _dcID_ = ?"; # remove general list
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $remid);
                if($stmnt -> execute()){
                    echo "<script>alert('Item has been removed');</script>";
                    $extra="past_dec.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    echo "<script>alert('Something went wrong');</script>";
                    $extra="past_dec.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }else{
                echo "<script>alert('Something went wrong');</script>";
                $extra="past_dec.php";  
                echo "<script>window.location.href='".$extra."'</script>";
            }
        }
    }
}
?>