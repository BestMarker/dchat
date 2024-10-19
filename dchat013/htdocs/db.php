<?php
$host = "localhost";
$user = "connectionmanager";
$pass = "wSp2P3g5@[dwE-G(";
$db_name = "chat";

    $con = new mysqli($host,$user,$pass,$db_name);

    function formatDate($date)
    {
        return date('g:i a',strtotime($date));
    }


?>