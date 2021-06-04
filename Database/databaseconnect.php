<?php
global $con, $dbname, $username, $servername, $password;
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'audit_admin';
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con -> connect_error)
{
die ("Connection failed: " . $con->connect_error);
 }

?>