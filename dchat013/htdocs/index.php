<?php 
require 'db.php'; // Veritabanı bağlantısını buraya taşıyoruz.
session_start();
$uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
$query_perm2 = "SELECT * FROM `kullaniciip` WHERE `ip` = '$uip'";
$query_check2 = mysqli_query($con, $query_perm2);
if (!isset($_SESSION['username']) or $query_check2->num_rows == 0 or !isset($_SESSION['uid'])) { //kullanıcı adı id vs. yoksa oturum açmaya yönlendiriyoruz
    header("Location: /oturum.php");
    die();

}


$uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
$query_perm = "SELECT * FROM `ipban` WHERE `ip` = '$uip'"; // ip ban kontrolü
$query_check = mysqli_query($con, $query_perm);
if($query_check->num_rows >= 1) {
    header("Location: https://http.cat/images/401.jpg");
    die();
}

$uid = $_SESSION['uid']; // id atama
?>

<!DOCTYPE html>
<html>
<head>
<link rel="apple-touch-icon" sizes="57x57" href="ico/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="ico/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="ico/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="ico/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="ico/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="ico/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="ico/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="ico/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="ico/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="ico/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="ico/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="ico/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <?php
    echo "<title>".$_SESSION['username']."</title>";
    ?>
    <style>
        body::-webkit-scrollbar {
            display: none;
        }
        .form-horizontal {
            margin-top: 150px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #FFFFFF;
            text-align: center;
            background-color: #313338;
        }
        .form-group {
            margin-bottom: 0; /* Set margin-bottom to 0 */
            text-align: center;
            background-color: #313338;
            border: none;
        }
        .form-control-message {
            width: 80%;
            float: left;
            margin-right: 3%;
            margin-left: 3%;
            margin-bottom: 1%;
            color: #FFFFFF;
            border-radius: 10px;
            margin-top: 1%;
            background-color: #383A40;
            border-color: #383A40;
        }
        .btn-primary {
            width: 10%;
            margin-right: 3%;
            border-radius: 10px;
            background-color: #383A40;
            margin-top: 1%;
            border: none;
        }
        .form-control { 
            float: left;
        }
        .cikisbuton {
            width: 5%;
            margin-right: 3%;
            border-radius: 10px;
            background-color: #383A40;
            color: #FFFFFF;
            position: fixed;
        }
        .cikisdiv {
            padding: 1%;
            
        }
    </style>
</head>
<body style="background-color: #313338;" onload="ajax();">
    <div class="cikisdiv"> <button class="btn btn-primary cikisbuton" onclick="window.location.href = './cikis.php';">Çıkış Yap</button> </div> <!-- Cozdum :) -->
    <div class="container">
        <div id="chat_box">
            <div id="chat"></div>
            <form id="oseyform" method="post" action="index.php" class="form-horizontal">
                <div class="form-group">
                    <?php
                    $kullanicisusturuldumu = "SELECT * FROM `sus` WHERE `kullaniciid` = '$uid'";
                    $kullanicisusturuldumucheck = mysqli_query($con, $kullanicisusturuldumu);
                    if(!$kullanicisusturuldumucheck->num_rows >= 1) { //susturulmış ise mesaj atma kısmını göstermiyoruz
                    echo "
                                        <div class='odiv'>
                        <input type='text' style='resize: none;' placeholder='Mesaj (Max. 64)' name='message' class='form-control form-control-message' rows='1'id='comment'></input>
                        
                    </div>
                    <div class='odiv'>
                        <button type='submit' name='submit' class='btn btn-primary'>Gönder</button>
                        
                    </div>
                </div>

                ";
                    }

                    ?>
            </form>
            <?php
            if(isset($_POST['message'])) {
                $hesapvarmi = "SELECT * FROM kullaniciip WHERE id = '$uid'";
	            $hesapvarmi_check = mysqli_query($con, $hesapvarmi);
                $hesapvarmi_sonuc = mysqli_fetch_assoc($hesapvarmi_check);
                $_SESSION['username'] = $hesapvarmi_sonuc['kullaniciadi'];
                $name = $hesapvarmi_sonuc['kullaniciadi'];
                
                $message = $_POST['message'];
                $uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                $query_perm = "SELECT * FROM `ipban` WHERE `ip` = '$uip'"; // herhangi bir yasağı varmı varsa mesaj gönderme işlemi iptal olcak
                $query_check = mysqli_query($con, $query_perm);
                $query_perm2 = "SELECT * FROM `sus` WHERE `id` = '$uid'";
                $query_check2 = mysqli_query($con, $query_perm2);
                if($query_check->num_rows >= 1) {
                    header("Location: https://http.cat/images/401.jpg");
                    die();
                }elseif (!$query_check2->num_rows >= 1 & strlen($message)!=0 & strlen($message)<64) {
                    $query_1 = "INSERT INTO chat_info (name, msg, senderid) VALUES ('$name', '$message', '$uid')";
                    $query_run = mysqli_query($con, $query_1);
                if($query_run) {
                        echo "<audio src='sound/134332-facebook-chat-sound.mp3' hidden='true' autoplay='true' /></audio>";
                    }
                }

                }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
