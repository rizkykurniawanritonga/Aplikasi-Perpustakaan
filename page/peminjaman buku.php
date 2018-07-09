<?php
$haspinjam=0;
$nisstate=0;
if (isset($_POST['subpinjam']) and (isset($_POST['nispinjam']))) {
  $checkuser = mysql_query("SELECT * FROM anggota where NIS='".$_POST['nispinjam']."'") or die (mysql_error());
  if ($row = mysql_fetch_array($checkuser)) {
      $_SESSION['nispinjam'] = $_POST['nispinjam'];
      $nisstate=1;
  } else {
      $_SESSION["errorlogtxt"] = "NIS yang anda masukkan tidak terdaftar di database siswa.";
      $nisstate=2;

  }
} elseif (isset($_POST['subpinjam']) and ($_SESSION['nispinjam'] <> "")) {
  $nis=$_SESSION['nispinjam'];
  $nokatalog = (isset($_POST['bukupinjam'])) ? $_POST['bukupinjam'] : "" ;
  if (!isset($_POST['bukupinjam'])) {
    $_SESSION["errorlogtxt"] = "Silahkan pilih buku terlebih dahulu.";
  }
  $tglp = $_POST['tglpinjam'];
  $tglk = $_POST['tglkembali'];

  $checkhaspinjam = mysql_query("SELECT * FROM peminjaman where KodeKatalog='$nokatalog' and NIS='$nis'") or die (mysql_error());
  if (($row = mysql_fetch_array($checkhaspinjam)) and (!isset($_POST['yespinjamlagi']))) {
      $checktglnya = mysql_query("SELECT * FROM pengembalian where KodePeminjaman='$row[0]' and KodeKatalog='$row[2]' and TglDikembalikan=''") or die (mysql_error());
      if ($row = mysql_fetch_array($checktglnya)) {
        $_SESSION["errorlogtxt"] = "Buku tersebut sudah pernah anda pinjam sebelumnya.";
        $_SESSION["bukuhaspinjam"] = $nokatalog;
        $haspinjam=1;
      }
  } elseif($nokatalog <> "") {
    $dtrst1 = resetdatemysql($tglp);
    $dtrst2 = resetdatemysql($tglk);
    mysql_query("INSERT INTO `peminjaman` VALUES (null,'$nis','$nokatalog','$dtrst1','$dtrst2');") or die (mysql_error());
    $checkpinjamid = mysql_query("SELECT * FROM peminjaman where KodeKatalog='$nokatalog' and NIS='$nis' and TglPinjam='$dtrst1' and TglKembali='$dtrst2'") or die (mysql_error());
    if ($row = mysql_fetch_array($checkpinjamid)) {
      mysql_query("INSERT INTO `pengembalian` VALUES (null,'$row[0]','$nis','$nokatalog','$dtrst1','$dtrst2','','','','');") or die (mysql_error());
    }

    $getstok = mysql_query("SELECT stok FROM buku where KodeKatalog='$nokatalog'") or die (mysql_error());
    if ($row = mysql_fetch_array($getstok)) {
      $updatestok = $row[0] - 1;
      mysql_query("UPDATE buku SET Stok='$updatestok' WHERE KodeKatalog='$nokatalog'") or die (mysql_error());
    }

    $_SESSION["successlogtxt"] = "Data peminjaman sudah disimpan di database. Ingin meminjam lagi?";
    $_SESSION['nispinjam']="";
    $_SESSION["bukuhaspinjam"]="";
  }
} elseif (isset($_POST['batalpinjam'])) {
  $_SESSION['nispinjam']="";
  $_SESSION["successlogtxt"] = "";
  $_SESSION["bukuhaspinjam"]="";
}
$curdate = date('d/m/Y',time());
$makspinjam = date('d/m/Y',strtotime("+7 day"));
$nispinjam = (isset($_SESSION['nispinjam'])) ? $_SESSION['nispinjam'] : 0 ;
?>
<div class="mdl-grid demo-content">
<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Peminjaman Buku</h2>
  </div>
    <div class="mdl-grid mdl-grid--no-spacing">
<form action="" method="POST" class="mdl-cell mdl-cell--8-col mdl-grid">
<?php
if ($nispinjam == 0) {
echo (isset($_SESSION["successlogtxt"])) ? "<p class='mdl-cell mdl-cell--12-col mdl-color-text--green'>".$_SESSION["successlogtxt"]."</p>" : "" ;
echo (isset($_SESSION["errorlogtxt"]) and ($nisstate == 2)) ? "<p class='mdl-cell mdl-cell--12-col mdl-color-text--red'>".$_SESSION["errorlogtxt"]."</p>" : "" ;
$_SESSION["successlogtxt"]="";
$_SESSION["errorlogtxt"]="";

  echo '<p class="mdl-cell mdl-cell--12-col">Harap masukkan NIS Siswa terlebih dahulu.</p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col"><input class="mdl-textfield__input" type="text" name="nispinjam" id="nislabel" autofocus=""><label class="mdl-textfield__label" for="nislabel">NIS Siswa</label></div>';
} else {
  $getidentitasanggota = mysql_query("SELECT * FROM anggota where NIS='$nispinjam'") or die (mysql_error());
  if ($row = mysql_fetch_array($getidentitasanggota)) {
    $namapeminjam = "<b>".$row[1]."</b> [".$row[0]."]";
  }
  echo '<p class="mdl-cell mdl-cell--12-col">Hallo '.$namapeminjam.', kamu hendak meminjam buku apa?</p>';

if (isset($_SESSION["errorlogtxt"]) and ($haspinjam > 0)) {
  echo '<div class="mdl-cell mdl-cell--12-col mdl-grid mdl-grid--no-spacing"><p class="mdl-cell mdl-cell--12-col mdl-color-text--red">'.$_SESSION["errorlogtxt"].'</p>
<label class="mdl-cell mdl-cell--12-col mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
  <input type="checkbox" id="checkbox-1" class="mdl-checkbox__input" name="yespinjamlagi">
  <span class="mdl-checkbox__label">Ya Pinjam Lagi.</span>
</label></div>';
}

echo (isset($_SESSION["errorlogtxt"])) ? "<p class='mdl-cell mdl-cell--12-col mdl-color-text--red'>".$_SESSION["errorlogtxt"]."</p>" : "" ;

echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
<select class="mdl-textfield__input" name="bukupinjam" id="bukupinjam" autofocus="" autocomplete="off">
<option selected="" disabled="">-- --</option>';
$getbooklist = mysql_query("SELECT * FROM buku where stok > 0") or die (mysql_error());
while ($row = mysql_fetch_array($getbooklist)) {
  $checkedstate = (isset($nokatalog) and ($nokatalog == $row[0])) ? " selected=''" : "" ;
  echo "<option ".$checkedstate." value='$row[0]'>$row[1] - $row[3]</option>";
}
echo '</select>
<label class="mdl-textfield__label" for="bukupinjam">Pilih Buku</label>
</div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col"><input class="mdl-textfield__input" type="text" name="tglpinjam" id="tglpinjamlabel" value="'.$curdate.'"><label class="mdl-textfield__label" for="tglpinjamlabel">Tanggal Pinjam</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col"><input class="mdl-textfield__input" type="text" name="tglkembali" id="tglkembalilabel" value="'.$makspinjam.'"><label class="mdl-textfield__label mdl-color-text--red" for="tglkembalilabel">Tanggal Harus dikembalikan</label></div>
';
}
?>
<div class="mdl-cell mdl-cell--12-col">
  <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="Ok" type="submit" name="subpinjam">
<?php
if ($nispinjam) {
  echo '<input class="mdl-button mdl-js-button mdl-button--flat mdl-js-ripple-effect mdl-button--accent" value="Batal" type="submit" name="batalpinjam">';
}
?><br><br>
<p class="mdl-card__supporting-text">Note: Jika terlambat mengembalikan buku, maka dikenakan denda Rp.500/Hari</p>
</div>
</form>
    </div>
    <br>
</div>
</div>  