<?php
global $con, $dbname, $username, $servername, $password;
$servername = 'localhost';
$username = 'AuditAdmin';
$password = 'nhr7V1un4zclvl95';
$dbname = 'audit_admin';
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con -> connect_error)
{
die ("Connection failed: " . $con->connect_error);
 }

?>