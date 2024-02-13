<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /oturum.php");
    die();
}

require 'db.php'; // Veritabanı bağlantısını buraya taşıyoruz.

$uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
$query_perm = "SELECT * FROM `ipban` WHERE `ip` = '$uip'";
$query_check = mysqli_query($con, $query_perm);
if($query_check->num_rows >= 1) {
    header("Location: https://http.cat/images/401.jpg");
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
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
    </style>
</head>
<body style="background-color: #313338;" onload="ajax();">
    <div class="container">
        <div id="chat_box">
            <div id="chat"></div>
            <form method="post" action="indexs.php" class="form-horizontal">
                <div class="form-group">
                    <?php
                    $query_perm = "SELECT * FROM `sus` WHERE `ip` = '$uip'";
                    $query_check = mysqli_query($con, $query_perm);
                    if(!$query_check->num_rows >= 1) {
                    echo "
                                        <div class='odiv'>
                        <textarea style='resize: none;'' placeholder='Mesaj' name='message' class='form-control form-control-message' rows='1'id='comment'></textarea>
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
                $name = $_SESSION['username'];
                $message = $_POST['message'];
                $uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
                $query_perm = "SELECT * FROM `ipban` WHERE `ip` = '$uip'";
                $query_check = mysqli_query($con, $query_perm);
                if($query_check->num_rows >= 1) {
                    header("Location: https://http.cat/images/401.jpg");
                    die();
                }else {
                    $query_1 = "INSERT INTO chat_info (name, msg, ip) VALUES ('$name', '$message', '$uip')";
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
