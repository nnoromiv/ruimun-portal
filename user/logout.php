<?php
require_once 'assets/scripts/data.php';
unset($_SESSION['email']);
unset($_SESSION['type']);
unset($_SESSION['userid']);
session_regenerate_id(true);
mysqli_close($connect);
$access = null;
redirect("login");
?>