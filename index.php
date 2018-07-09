<?php
include 'system/core.php';

incfile("part/head","php");

$logorno = (isset($_GET['page']) and $_GET['page'] == "login") ? "Login - " : "" ;

$txttitle = (loginit() > 0) ? "" : $logorno ;
inithead($txttitle.judul());

if (loginit() > 0) {
	incfile("part/paged","php");
}elseif (isset($_GET['page']) and $_GET['page'] == "login") {
	incfile("part/notlogin","php");
}elseif (isset($_GET['findbook'])) {
	incfile("part/findbook","php");
}
else {
	incfile("part/homealt","php");
}
incfile("part/end","php");
?>