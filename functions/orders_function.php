<?php
include "../functions/XSS.php";

//Add new item
class newprice{
    function addpricing($con){
        if(isset($_POST['add']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $type = clean($_POST['type']);
            $brand = clean($_POST['brand']);
            $model = strtoupper(clean($_POST['model2']));
            $qty = clean($_POST['quantity']);
            $price = clean($_POST['price']);
            
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
            
            //check if item exists
            $msg = "SELECT _oiID_, _visible_ FROM _order_item_ INNER JOIN _supply_item_ ON _supply_item_._sp_ID_ = _order_item_._si_ID_ WHERE _brand_ID_ = ? and _item_name_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("is", $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($oiid, $vis);
            if(empty($model) || empty($qty) || empty($price)){ # check if fields are empty
                echo "<script>alert('One of the field is empty.');</script>";
                $extra="add_pricing.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if(!is_numeric($qty) || !is_numeric($price)){ # check if variables are numeric
                echo "<script>alert('One of the field has incorrect value.');</script>";
                $extra="add_pricing.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if($stmnt->fetch()){ # check if item exists
                if($vis == 1){ # check if is visible
                    $stmnt -> close();
                    echo "<script>alert('Item is already on list.');</script>";
                    $extra="add_pricing.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                    $stmnt -> close();
                    //readd hided item
                    $stmnt = $con -> prepare("UPDATE _order_item_ SET _visible_ = 1, _QTY_ = ?, _price_ = ? WHERE _oiID_ = ?"); # update item information
                    $stmnt -> bind_param("idi",$qty, $price, $oiid);
                    if($stmnt -> execute()){
                        $stmnt -> close();
                        echo "<script>alert('Item added successfully.');</script>";
                        $extra="add_pricing.php";
                        echo "<script>window.location.href='".$extra."'</script>";
                    }else{
                        $stmnt -> close();
                        echo "<script>alert('Something went wrong.');</script>";
                        $extra="add_pricing.php";
                        echo "<script>window.location.href='".$extra."'</script>";
                    }
                }
            }else{ # proceed adding new pricing
                $stmnt -> close();
                $this -> additem($con, $type, $brand, $model, $price, $qty);
            }
        }
    }
    
    //add new item
    function additem($con, $type, $brand, $model, $price, $qty){
        $msg = "INSERT INTO _supply_item_(_type_ID_, _brand_ID_, _item_name_) VALUES (?, ?, ?)"; #insert new item
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("iis", $type, $brand, $model);
        if($stmnt -> execute()){
            $stmnt -> close();
            $msg = "SELECT _sp_ID_ FROM _supply_item_ WHERE _type_ID_ = ? AND _brand_ID_ = ? AND _item_name_ = ?"; # select item id
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("iis", $type, $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($siID);
            $stmnt -> fetch();
            $stmnt -> close();
            $msg = "INSERT INTO _order_item_(_si_ID_, _price_, _QTY_) VALUES (?, ?, ?)"; # insert data into pricing table
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("idi", $siID, $price, $qty);
            if($stmnt -> execute()){
                echo "<script>alert('Item price has been added.');</script>";
            }else{
                echo "<script>alert('Something went wrong.');</script>";
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
        
    } 
    //add new type
    function notype($con, $type2){
        $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?"; # check if exists
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $type2);
        $stmnt -> execute();
        $stmnt -> bind_result($type);
        if($stmnt -> fetch()){ # return if exists
            $stmnt -> close();
            return $type;
        }else{
            $msg = "INSERT INTO _types_(_type_name_) VALUES (?)"; # insert new type
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $type2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _tID_ FROM _types_ WHERE _type_name_ = ?"; # select type id
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
        $msg = "SELECT _bID_ FROM _brands_ WHERE _brand_name_ = ?"; # check if brand exists
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("s", $brand2);
        $stmnt -> execute();
        $stmnt -> bind_result($brand);
        if($stmnt -> fetch()){ # return if exists
            $stmnt -> close();
            return $brand;
        }else{
            $msg = "INSERT INTO _brands_(_brand_name_) VALUES (?)"; # insert new brand
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("s", $brand2);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "SELECT _bID_ FROM _brands_ WHERE _brand_name_ = ?"; # select brand id
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
}

//edit item
class editprice{
    function eddit($con, $itemid){
        if(isset($_POST['edit']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){
            $type = clean($_POST['type']);
            $brand = clean($_POST['brand']);
            $model = strtoupper(clean($_POST['model2']));
            $qty = clean($_POST['quantity']);
            $price = clean($_POST['price']);
            
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
            
            //check if item exists
            $msg = "SELECT _oiID_ FROM _order_item_ INNER JOIN _supply_item_ ON _supply_item_._sp_ID_ = _order_item_._si_ID_ WHERE _brand_ID_ = ? and _item_name_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("is", $brand, $model);
            $stmnt -> execute();
            $stmnt -> bind_result($oiID);
            //check if fields are empty
            if(empty($model) || empty($qty) || empty($price)){ # check if fields are empty
                echo "<script>alert('One of the field is empty.');</script>";
                $extra="edit_pricing.php?uid=".$itemid."";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if(!is_numeric($qty) || !is_numeric($price)){ # check if inputs are numeric
                echo "<script>alert('One of the field has incorrect value.');</script>";
                $extra="edit_pricing.php?uid=".$itemid."";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if($stmnt->fetch()){ # check if pricing already exists with editing item details
                $stmnt -> close();
                if($itemid == $oiID){ # chech if existing pricing is equall to edited item
                    $this -> edditem($con, $type, $brand, $model, $price, $qty, $itemid);
                }else{
                    echo "<script>alert('This item already exists.');</script>";
                    $extra="edit_pricing.php?uid=".$itemid."";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }else{
                $stmnt -> close();
                $this -> edditem($con, $type, $brand, $model, $price, $qty, $itemid);
            }
        }
    }
    //update pricing information
    function edditem($con, $type, $brand, $model, $price, $qty, $itemid){
        $msg = "UPDATE _order_item_ AS oi INNER JOIN _supply_item_ AS si ON si._sp_ID_ = oi._si_ID_ SET si._brand_ID_ = ?, si._item_name_ = ?, oi._price_ = ?, oi._QTY_ = ?, si._type_ID_ = ? WHERE oi._oiID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("isdiii", $brand, $model, $price, $qty, $type, $itemid);
        if ($stmnt -> execute()){
            $stmnt -> close();
            echo "<script>alert('Item has been updated.');</script>";
            $extra="pricing.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }else{
            $stmnt -> close();
            echo "<script>alert('Something went wrong.');</script>";
            $extra="edit_pricing.php?uid=".$itemid."";
            echo "<script>window.location.href='".$extra."'</script>";
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
}

//add new order
class neworder{
    function order($con){
        include "../functions/Staff_function.php";
        if(isset($_POST['Add_order']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){ # check user permissions and session
            $staffid = clean($_POST['staff']);
            $depid = clean($_POST['depart']);
            $QTY = clean($_POST['quantity']);
            $itemid = clean($_POST['item']);
            $sdate = clean($_POST['order_date']);
            
            //add new staff and get id
            if($staffid == "Notonlist"){
                $newstaff = new staff();
                $newstaff -> insertstaff($con);
                $email = clean($_POST['user_email']);
                $email = strtolower($email);
                $msg = "SELECT _sID_ FROM _staff_ WHERE _email_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $email);
                $stmnt -> execute();
                $stmnt -> bind_result($staffid);
                $stmnt -> fetch();
                $stmnt -> close();
            }
            //add new department and get id
            if($depid == "Notonlist"){
                $res = $this -> adddepart($con);
                if($res = "success"){
                    $msg = "SELECT _dID_ FROM _departments_ WHERE _deparment_name_ = ? AND _visible_ = 1";
                    $stmnt = $con -> prepare($msg);
                    $depname = clean($_POST['department']);
                    $stmnt -> bind_param("s", $depname);
                    $stmnt -> execute();
                    $stmnt -> bind_result($depid);
                    $stmnt -> fetch();
                    $stmnt -> close();
                }else{
                    echo "<script>alert('Something went wrong');</script>";
                    $extra="add_order.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }
            
            if(empty($QTY) || empty($sdate)){ # chech if fields are empty
                echo "<script>alert('One of the field is empty');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if(!is_numeric($QTY)){ # check if quantity is numeric
                echo "<script>alert('One of the field contain incorrect format');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else{# proceed to insert order into database
                $this -> insertorder($con, $staffid, $depid, $QTY, $itemid, $sdate);
            }
        }
    }
    
    //add department if not exists
    function adddepart($con){
        $deptname=clean($_POST['department']);
        $visib = 1;

        $msg = "SELECT * FROM _departments_ WHERE _deparment_name_ = ?";
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $deptname);
        $stmnt -> execute();
        $stmnt -> bind_result($depid, $depname, $depvis);

        if(empty($deptname)){ # check if field is empty
            echo "<script>alert('One of the field is empty');</script>";
            $stmnt->close();
        }else if ($stmnt -> fetch()){ # check if department exists
            $stmnt->close();
            if($depvis == 1){
                $stmnt -> close();
                return "fail";
            }else{
                $msg = "UPDATE _departments_ SET _visible_ = 1 WHERE _dID_ = ?"; #make deparment visible
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $depid);
                if($stmnt ->execute()){
                    $stmnt->close();
                    return "success";
                }
            }
        }else{
            $stmnt->close();
            $msg="INSERT INTO _departments_ (_deparment_name_, _visible_) VALUES (?, ?)"; # insert new department
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("si", $deptname, $visib);
            if($stmnt->execute()){
                $stmnt -> close();
                return "success";
            }

        }
    }
    
    //insert order
    function insertorder($con, $staffid, $depid, $QTY, $itemid, $sdate){
        $msg = "SELECT _QTY_, _price_ FROM _order_item_ WHERE _oiID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $itemid);
        $stmnt -> execute();
        $stmnt -> bind_result($oldqty, $price);
        $stmnt -> fetch();
        $stmnt -> close();
        $newqty = $oldqty - $QTY;
        if($newqty < 0){ # check quantity of the item
            echo "<script>alert('Not enough items in quantity');</script>";
            $extra="add_order.php";
            echo "<script>window.location.href='".$extra."'</script>";
        }else{
            $total = $price * $QTY;
            $msg = "UPDATE _order_item_ SET _QTY_ = ? WHERE _oiID_ = ?"; #update item quantity
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $newqty, $itemid);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "INSERT INTO _orders_ (_staff_id_, _item_id_, _quantity_, _total_price_, _date_, _dep_id_, _current_) VALUES (?, ?, ?, ?, ?, ?, 1)"; # insert order
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("iiidsi", $staffid, $itemid, $QTY, $total, $sdate, $depid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    echo "<script>alert('Order has been added');</script>";
                    $extra="add_order.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                   $stmnt -> close();
                    echo "<script>alert('Something went wrong');</script>";
                    $extra="add_order.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }else{
                echo "<script>alert('Something went wrong');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }
        }
    }
}

//edit user's order
class editorde{
    function edit($con, $orderid){
        if(isset($_POST['Edit_order']) && !empty($_SESSION['login']) && $_SESSION['isadmin'] == 1){# chech user accoun and session
            //Variables
            $staffid = clean($_POST['staff']);
            $depid = clean($_POST['depart']);
            $QTY = clean($_POST['quantity']);
            $itemid = clean($_POST['item']);
            $sdate = clean($_POST['order_date']);
            $depidresult = "";
            
            //add new staff and get id
            if($staffid == "Notonlist"){
                $newstaff = new staff();
                $newstaff -> insertstaff($con);
                $email = clean($_POST['user_email']);
                $email = strtolower($email);
                $msg = "SELECT _sID_ FROM _staff_ WHERE _email_ = ?";
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("s", $email);
                $stmnt -> execute();
                $stmnt -> bind_result($staffid);
                $stmnt -> fetch();
                $stmnt -> close();
            }
            //add new department and get id
            if($depid == "Notonlist"){
                $res = $this -> adddepart($con);
                if($res = "success"){
                    $msg = "SELECT _dID_ FROM _departments_ WHERE _deparment_name_ = ? AND _visible_ = 1";
                    $stmnt = $con -> prepare($msg);
                    $depname = clean($_POST['department']);
                    $stmnt -> bind_param("s", $depname);
                    $stmnt -> execute();
                    $stmnt -> bind_result($depid);
                    $stmnt -> fetch();
                    $stmnt -> close();
                }else{
                    $depidresult = "unsuccessful";
                }
            }

            //select item and quantity
            $msg = "SELECT _oiID_, _QTY_ FROM _order_item_ INNER JOIN _orders_ ON _orders_._item_id_ = _order_item_._oiID_ WHERE _oID_ = ?";
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("i", $orderid);
            $stmnt -> execute();
            $stmnt -> bind_result($oldid, $olderqty);
            $stmnt -> fetch();
            $stmnt -> close();
            
            if(empty($QTY) || empty($sdate)){ # check if field are empty
                echo "<script>alert('One of the field is empty');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if(!is_numeric($QTY)){ # check if quantity is numeric
                echo "<script>alert('One of the field contain incorrect format');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if(!($this -> retrive($con, $orderid))){ # check if retrive quantity item is successfull
                echo "<script>alert('Something went wrong');</script>";
                $extra="add_order.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }else if($depidresult == "unsuccessful"){ # check if department method was successful
                echo "<script>alert('Something went wrong');</script>";
                $this -> retrivechanges($con, $oldid, $olderqty); # retrive changes if department insertion was unsuccessful
                $extra="current_orders.php";    
                echo "<script>window.location.href='".$extra."'</script>";
            }else{
                $this -> editorder($con, $orderid, $staffid, $depid, $QTY, $itemid, $sdate, $oldid, $olderqty); # proceed to edit order
            }
        }
    }
    
    //add department if not exists
    function adddepart($con){
        $deptname=clean($_POST['department']);
        $visib = 1;

        $msg = "SELECT * FROM _departments_ WHERE _deparment_name_ = ?"; # check if department exists
        $stmnt = $con->prepare($msg);
        $stmnt -> bind_param("s", $deptname);
        $stmnt -> execute();
        $stmnt -> bind_result($depid, $depname, $depvis);

        if(empty($deptname)){
            echo "<script>alert('One of the field is empty');</script>";
            $stmnt->close();
        }else if ($stmnt -> fetch()){
            $stmnt->close();
            if($depvis == 1){
                $stmnt -> close();
                return "fail";
            }else{
                $msg = "UPDATE _departments_ SET _visible_ = 1 WHERE _dID_ = ?"; # set department visible if already exists
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("i", $depid);
                if($stmnt ->execute()){
                    $stmnt->close();
                    return "success";
                }
            }
        }else{
            $stmnt->close();
            $msg="INSERT INTO _departments_ (_deparment_name_, _visible_) VALUES (?, ?)"; # insert new department
            $stmnt = $con->prepare($msg);
            $stmnt -> bind_param("si", $deptname, $visib);
            if($stmnt->execute()){
                $stmnt -> close();
                return "success";
            }

        }
    }
    
    //insert order
    function editorder($con, $orderid, $staffid, $depid, $QTY, $itemid, $sdate, $oldid, $olderqty){
        //select item quantity
        $msg = "SELECT _QTY_, _price_ FROM _order_item_ WHERE _oiID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $itemid);
        $stmnt -> execute();
        $stmnt -> bind_result($oldqty, $price);
        $stmnt -> fetch();
        $stmnt -> close();
        
        $newqty = $oldqty - $QTY;
        $total = $QTY * $price;
        
        if($newqty < 0){ # check if number of item is greated than current quantity
            echo "<script>alert('Not enough items in quantity ');</script>";
            $this -> retrivechanges($con, $oldid, $olderqty);
        }else{
            $total = $price * $QTY;
            $msg = "UPDATE _order_item_ SET _QTY_ = ? WHERE _oiID_ = ?"; # Update quantity of the item
            $stmnt = $con -> prepare($msg);
            $stmnt -> bind_param("ii", $newqty, $itemid);
            if($stmnt -> execute()){
                $stmnt -> close();
                $msg = "UPDATE _orders_ SET _staff_id_ = ?, _item_id_ = ?, _quantity_ = ?, _total_price_ = ?, _date_ = ?, _dep_id_ = ? WHERE _oID_ = ?"; # Update staff order
                $stmnt = $con -> prepare($msg);
                $stmnt -> bind_param("iiidsii", $staffid, $itemid, $QTY, $total, $sdate, $depid, $orderid);
                if($stmnt -> execute()){
                    $stmnt -> close();
                    echo "<script>alert('Order has been edited');</script>";
                    $extra="current_orders.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }else{
                   $stmnt -> close();
                    echo "<script>alert('Something went wrong');</script>";
                    $this -> retrivechanges($con, $oldid, $olderqty); # Retrive changes if there are errors
                    $extra="current_orders.php";
                    echo "<script>window.location.href='".$extra."'</script>";
                }
            }else{
                echo "<script>alert('Something went wrong');</script>";
                $this -> retrivechanges($con, $oldid, $olderqty); # retrive changes if there are errors
                $extra="current_orders.php";
                echo "<script>window.location.href='".$extra."'</script>";
            }
        }
    }
    
    //retrevie quantity
    function retrive($con, $orderid){
        //select item quantity
        $msg = "SELECT _QTY_, _price_ FROM _order_item_ INNER JOIN _orders_ ON _orders_._item_id_ = _order_item_._oiID_ WHERE _oID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $orderid);
        $stmnt -> execute();
        $stmnt -> bind_result($oldqty, $price);
        $stmnt -> fetch();
        $stmnt -> close();
        
        //select ordered quantity
        $msg = "SELECT _quantity_  FROM _orders_ WHERE _oID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $orderid);
        $stmnt -> execute();
        $stmnt -> bind_result($orderqty);
        $stmnt -> fetch();
        $stmnt -> close();
        
        //select item to update quantity
        $msg = "SELECT _oiID_ FROM _order_item_ INNER JOIN _orders_ ON _orders_._item_id_ = _order_item_._oiID_ WHERE _oID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("i", $orderid);
        $stmnt -> execute();
        $stmnt -> bind_result($itemid);
        $stmnt -> fetch();
        $stmnt -> close();
        
        $newqty= $oldqty + $orderqty;
        
        //update quantity
        $msg = "UPDATE _order_item_ SET _QTY_ = ? WHERE _oiID_ = ?";
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("ii", $newqty, $itemid);
        if ($stmnt -> execute()){
            $stmnt -> close();
            return true;
        }else{
            $stmnt -> close();
            return false;
        }
    }
    
    //retrive changes to quantity
    function retrivechanges($con, $oldid, $olderqty){
        
        //update quantity
        $msg = "UPDATE _order_item_ SET _QTY_ = ? WHERE _oiID_ = ?"; # update with old data
        $stmnt = $con -> prepare($msg);
        $stmnt -> bind_param("ii", $olderqty, $oldid);
        if ($stmnt -> execute()){
            $stmnt -> close();
            return true;
        }else{
            $stmnt -> close();
            return false;
        }
    }
}

?>