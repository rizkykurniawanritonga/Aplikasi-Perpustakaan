<?php
	$host ="localhost";
	$user = "root";
	$pass = "";
	$dbname = "aplikasiperpustakaan";
	@mysql_connect($host, $user, $pass) or die ("Koneksi MySQL GAGAL.");
	@mysql_select_db($dbname) or die ("Database '$dbname' tidak Ditemukan.");
?>