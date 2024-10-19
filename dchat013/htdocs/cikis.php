<?php
session_start();
$_SESSION['username'] = null;
$_SESSION["uid"] = null;
header("Location: /giris.php");
?>