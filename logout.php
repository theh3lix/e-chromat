<?php
session_start();
session_destroy();
$_SESSION['success']='Zostałeś wylogowany!';
header("Location: index.php");
?>
