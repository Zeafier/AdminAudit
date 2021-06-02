<?php
session_start();
//Clean log sessions
$_SESSION['login']=="";
$_SESSION['isadmin']=="";

session_unset();

?>
<!-- Inform user about successful operation -->
<script language="javascript">
document.location="../login.php";
alert("You have logged out successfully..!");
</script>