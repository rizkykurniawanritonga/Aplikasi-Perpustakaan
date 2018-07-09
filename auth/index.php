<?php
include '../system/core.php';
//Perintah Login
if (isset($_POST['submitlogin'])) {
	$id = $_POST["username"];
	$pass = $_POST["password"];
	$getakun = mysql_query("SELECT * FROM admin where Username='$id'") or die (mysql_error());
	if ($row = mysql_fetch_array($getakun)) {
		if ($row[3] == $pass) {
			$_SESSION["loginstate"] = 1;
			$_SESSION["currentloginaccount"] = $row[2];
			redirect(homelink());
			$_SESSION["errorlogtxt"]="";
		} elseif ($pass == "") {
			$_SESSION["errorlogtxt"] = "Password yang kamu masukkan tidak boleh kosong.";
			redirectback();
		} else {
			$_SESSION["errorlogtxt"] = "Password yang kamu masukkan salah.";
			redirectback();
		}
	} else {
		echo "account not found";
		$_SESSION["errorlogtxt"] = "Akun yang kamu masukkan tidak terdaftar di database kami.";
		redirectback();
	}
}
//Perintah Logout
if (isset($_GET["action"]) == "logout") {
	session_unset();
	session_destroy();
	redirect(homelink());
}
?>
<html>
<head>
<title>Mohon Tunggu....</title>
</head>
<body>
<p>Mohon Tunggu...</p>
</body>
</html>