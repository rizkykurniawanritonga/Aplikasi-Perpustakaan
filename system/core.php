<?php
session_start();

incfile("system/connection","php");
incfile("system/func","php");

function judul(){
	return "Aplikasi Perpustakaan";
}

function homelink(){
	$homelink = "/perpustakaan";
	return $homelink;
}

//server setting
date_default_timezone_set("Asia/Jakarta");

//include file
function incfile($file,$type){
	$fltype = '.'.$type;
	if (file_exists($file.$fltype)) {
		$dirhelp = "";
	}elseif (file_exists("../".$file.$fltype)) {
		$dirhelp = "../";
	}elseif (file_exists("../../".$file.$fltype)) {
		$dirhelp = "../../";
	}elseif (file_exists("../../../".$file.$fltype)) {
		$dirhelp = "../../../";
	}
	$get = $dirhelp.$file.$fltype;
	if (($type == "php") || ($type == "html")) {
		include $get;
	}elseif ($type == "css") {
		echo "<link rel='stylesheet' href='$get'/>";
	}elseif ($type == "js") {
		echo "<script type='text/javascript' src='$get'></script>";
	}
}
?>