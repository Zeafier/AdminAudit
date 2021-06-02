<?php
//Check if user is logged before accessing web page
function check_login()
{
    if(strlen($_SESSION['login'])==0)
	{	
		$host=$_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="../login.php";		
		$_SESSION["login"]="";
		header("Location: http://$host$uri/$extra");
	}
}
//Check if user is logged when trying to access home page
function check_login_main(){
    if(strlen($_SESSION['login'])==0)
	{	
		$host=$_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="./login.php";		
		$_SESSION["login"]="";
		header("Location: http://$host$uri/$extra");
	}
}
//Check if session exists
function logged(){
    if(!empty($_SESSION['login'])){
        $host=$_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="./index.php";
		header("Location: http://$host$uri/$extra");
    }
}
//Check if user have admin-type account before accessing to specyfic web pages
function isadmin(){
    if($_SESSION['isadmin'] == 0){
        $host=$_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra="../index.php";
		header("Location: http://$host$uri/$extra");
    }
}
?>