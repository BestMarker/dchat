<?php
require 'db.php';
session_start();
$uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
$query_perm = "SELECT * FROM `kullaniciip` WHERE `ip` = '$uip'";
$query_check = mysqli_query($con, $query_perm);
if($query_check->num_rows >= 1 and isset($_SESSION["uid"])) {
    header("Location: ..");
    die();
} elseif ($query_check->num_rows == 0 & !isset($_SESSION['uid'])){
#	$query_row = mysqli_fetch_assoc($query_check);
#	$_SESSION["username"] = $query_row['kullaniciadi'];
#	$_SESSION["uid"] = $query_row['id'];
	header("Location: ./oturum.php");

    die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<title>Giriş Sayfası</title>
</head>
<body style="background-color: #0B2447;text-align: center;">
<style>
.isimkisim {
font-size: 30px;
font-family: 'Ubuntu', sans-serif;
color: #576CBC;
}  
.uyariyazisi {
font-size: 20px;
font-family: 'Ubuntu', sans-serif;
color: #F5004F;
margin-top: 3%;
}  
.body {
	position: relative;
	text-align: center;
}
.form-horizontal {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}
.form-control-name {
	margin-top: 5%;
	margin-bottom: 5%;
}
</style>
<div class="budiv"> <!-- Görsel tasarım flan -->
	<form method="post" action="giris.php" class="form-horizontal">
		<p class="isimkisim">Kullanıcı Adı</p>
		<input type="text" class="form-control form-control-name" placeholder="Ad" name="username">
		<p class="isimkisim">Şifre</p>
		<input type="password" class="form-control form-control-name" placeholder="Şifre" name="pass">

		<button type="submit" name="submit" class="btn btn-primary">Giriş Yap</button>

	</form>
</div>

<?php
if (isset($_POST['username']) and isset($_POST['pass'])) {
	$uip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
	$ism = $_POST['username'];
	$pass = sha1($_POST['pass']);
	$hesapvarmi = "SELECT * FROM kullaniciip WHERE kullaniciadi = '$ism' AND kullanicisifre = '$pass' AND ip = '$uip'";
	$hesapvarmi_check = mysqli_query($con, $hesapvarmi);
	
	if ($hesapvarmi_check->num_rows >= 1) { //OLMUYOO (tm bitti)
		$hesapvarmi_sonuc = mysqli_fetch_assoc($hesapvarmi_check);
		$_SESSION['username'] = $hesapvarmi_sonuc['kullaniciadi'];
		$_SESSION["uid"] = $hesapvarmi_sonuc['id'];
    	header("Location: ./". $hesapvarmi_sonuc['pass']);
    	die();
	}
}



?>
</body>
</html>