<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ..");
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<title>Oturum Sayfası</title>
</head>
<body style="background-color: #0B2447;text-align: center;">
<style>
.isimkisim {
font-size: 30px;
font-family: 'Ubuntu', sans-serif;
color: #576CBC;
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
<div class="budiv">
	<form method="post" action="oturum.php" class="form-horizontal">
		<p class="isimkisim">Kullanıcı Adı</p>
		<input type="text" class="form-control form-control-name" placeholder="Ad" name="username">
		<button type="submit" name="submit" class="btn btn-primary">Gönder</button>
	</form>
</div>
<?php
if (isset($_POST['username'])) {
	echo "sa";
	$_SESSION["username"] = $_POST['username'];
	echo "oldu1";
	if (isset($_SESSION['username'])) {
		echo "gidio";
    	header("Location: ..");
    	die();
	}
}



?>
</body>
</html>