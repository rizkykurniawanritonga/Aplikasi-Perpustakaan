<?php
//redirect tujuan
function redirect($tujuan){
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.$tujuan);
}
//redirect halaman sebelumnya
function redirectback($interval = 0){
	$beflink = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : homelink() ;
	if (!headers_sent()) {
		header('Location: '.$beflink);
	}
	print '<meta content="'.$interval.';URL='.$beflink.'" http-equiv="refresh"/><br>Memuat...<br>';
}
//loginstate
function loginit(){
	$loginit = (isset($_SESSION["loginstate"])) ? $_SESSION["loginstate"] : 0 ;
	return $loginit;
}
function getname($source){
  $getname = mysql_query("SELECT * FROM admin where Username='$source'") or die (mysql_error());
  $row = mysql_fetch_array($getname);
  return $row[1];
}
function bulan($get){
  $str = array('01' =>'Januari',
         '02' =>'Februari',
         '03' =>'Maret',
         '04' =>'April',
         '05' =>'Mei',
         '06' =>'Juni',
         '07' =>'Juli',
         '08' =>'Agustus',
         '09' =>'September',
         '10' =>'Oktober',
         '11' =>'November',
         '12' =>'Desember',
        );
  return $str[$get];
}
function resetdatemysql($val){
	list($day, $month, $year) = sscanf($val,'%02d/%02d/%04d');
	$datetime = new DateTime("$year-$month-$day");
	return $datetime->format("Y-m-d");
}
function dateconv($val){
  list($year, $month, $day) = sscanf($val,'%04d/%02d/%02d');
  $datetime = new DateTime("$year-$month-$day");
  return $datetime->format("d ".bulan(."m".)." Y");
}
function sessionreseterhome(){
  $_SESSION["errorlogtxt"]="";
  $_SESSION["successtxt"]="";
  $_SESSION['niskembali']="";
  $_SESSION['nisstate']="";
  $_SESSION['savedidforcard']="";
  $_SESSION['successlogtxt']="";
  $_SESSION['nispinjam']="";
}
function days_diff($d1, $d2) {
    $x1 = days($d1);
    $x2 = days($d2);
    
    if ($x1 && $x2) {
        return abs($x1 - $x2);
    }
}

function days($x) {
    if (get_class($x) != 'DateTime') {
        return false;
    }
    
    $y = $x->format('Y') - 1;
    $days = $y * 365;
    $z = (int)($y / 4);
    $days += $z;
    $z = (int)($y / 100);
    $days -= $z;
    $z = (int)($y / 400);
    $days += $z;
    $days += $x->format('z');

    return $days;
}
?>