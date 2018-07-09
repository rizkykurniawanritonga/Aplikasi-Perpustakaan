<?php
function sessionreseter(){
  $_SESSION["errorlogtxt"]=0;
  $_SESSION["successtxt"]=0;
  $_SESSION['niskembali']=0;
  $_SESSION['nisstate']=0;
}
$nisstate = (isset($_SESSION['nisstate'])) ? $_SESSION['nisstate'] : 0;
$niskembali = (isset($_SESSION['niskembali'])) ? $_SESSION['niskembali'] : 0;
if (($nisstate == 0) and (isset($_POST['subkembali']))) {
  $checkuser = mysql_query("SELECT * FROM anggota where NIS='".$_POST['niskembali']."'") or die (mysql_error());
  if ($row = mysql_fetch_array($checkuser)) {
      $_SESSION['niskembali'] = $_POST['niskembali'];
      $_SESSION['nisstate']=1;
      $niskembali = $_POST['niskembali'];
      $nisstate=1;
  } else {
      $_SESSION["errorlogtxt"] = "NIS yang anda masukkan tidak terdaftar di database siswa.";
  }
}elseif (($nisstate == 1) and (!empty($_GET['idtra']))) {
  $_SESSION['nisstate']=2;
  $nisstate=2;
}elseif (($nisstate == 2) and (!empty($_GET['idtra'])) and (isset($_POST['subkembali']))) {
  $tglpinjam = resetdatemysql($_POST['tglpinjam']);
  $tglkembali = resetdatemysql($_POST['tglharuskembali']);
  $tgllbukukembali = resetdatemysql($_POST['tglbukukembali']);
  $wktketerlambatan = $_POST['wktketerlambatan'];
  $denda = $_POST['denda'];
  $tagih = $_POST['tagih'];
  mysql_query("UPDATE pengembalian SET TglPinjam='$tglpinjam', TglKembali='$tglkembali', TglDikembalikan='$tgllbukukembali', Terlambat='$wktketerlambatan', Denda='$denda', Tagih='$tagih' WHERE KodePengembalian='".$_GET['idtra']."'") or die (mysql_error());

  if ($_POST['tagih'] == "Y") {
    $_SESSION["successtxt"]="Terima kasih telah mengembalikan buku :)";
    $getnokatal = mysql_query("SELECT KodeKatalog FROM pengembalian where KodePengembalian='".$_GET['idtra']."'") or die (mysql_error());
    if ($row = mysql_fetch_array($getnokatal)) {
      $nokatalog=$row[0];
      $getstok = mysql_query("SELECT stok FROM buku where KodeKatalog='$nokatalog'") or die (mysql_error());
      if ($row = mysql_fetch_array($getstok)) {
        $updatestok = $row[0] + 1;
        mysql_query("UPDATE buku SET Stok='$updatestok' WHERE KodeKatalog='$nokatalog'") or die (mysql_error());
      }
    }
  }
  $nisstate=1;
}
elseif ((isset($_GET['action'])) and ($_GET['action'] == "batal")) {
  sessionreseter();
  $nisstate=0;
  $niskembali=0;
}
?>
<div class="mdl-grid demo-content">
<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Pengembalian Buku</h2>
  </div>
    <div class="mdl-grid mdl-grid--no-spacing">
<form action="" method="POST" class="mdl-cell mdl-cell--12-col mdl-grid">
<?php
echo ((isset($_SESSION["errorlogtxt"])) and ($_SESSION["errorlogtxt"] <> "")) ? "<p class='mdl-cell mdl-cell--12-col mdl-color-text--red'>".$_SESSION["errorlogtxt"]."</p>".$_SESSION["errorlogtxt"]="" : null ;
echo ((isset($_SESSION["successtxt"])) and ($_SESSION["successtxt"] <> "")) ? "<p class='mdl-cell mdl-cell--12-col mdl-color-text--green'>".$_SESSION["successtxt"]."</p>".$_SESSION["successtxt"]="" : null ;
if ($nisstate == 0) {
echo '<p class="mdl-cell mdl-cell--12-col">Harap masukkan NIS Siswa terlebih dahulu.</p><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"><input class="mdl-textfield__input" type="text" name="niskembali" id="nislabel" autofocus=""><label class="mdl-textfield__label" for="nislabel">NIS Siswa</label></div>';
} elseif($nisstate == 1) {
  $gethasquery=trim($_SERVER['QUERY_STRING'],"&action=batal");

  $getidentitasanggota = mysql_query("SELECT * FROM anggota where NIS='$niskembali'") or die (mysql_error());
  if ($row = mysql_fetch_array($getidentitasanggota)) {
    $namapeminjam = "<b>".$row[1]."</b> [".$row[0]."]";
  } else {
    echo "NIS tidak ditemukan";
    die();
  }
  echo '
<p class="mdl-cell mdl-cell--12-col">Hallo '.$namapeminjam.'<br>';

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM pengembalian where NIS='$niskembali' and Tagih<>'Y'") or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
echo 'Berikut adalah daftar buku kamu yang belum dikembalikan, silahkan pilih salah satu buku yang ingin dikembalikan terlebih dahulu.</p>
<div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th>No Transaksi</th>
      <th>No Katalog</th>
      <th class="mdl-data-table__cell--non-numeric">Judul Buku</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal Dipinjam</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal Harus Dikembalikan</th>
      <th class="mdl-data-table__cell--non-numeric">Status</th>
      <th class="mdl-data-table__cell--non-numeric">Kembalikan?</th>
    </tr>
  </thead>
  <tbody>';
  $getpinjaman = mysql_query("SELECT * FROM pengembalian where NIS='$niskembali' and Tagih<>'Y'") or die (mysql_error());
    while ($row = mysql_fetch_array($getpinjaman)) {
      $getidentitasbuku = mysql_query("SELECT * FROM buku where KodeKatalog='$row[3]'") or die (mysql_error());
      if ($rowsing = mysql_fetch_array($getidentitasbuku)) {
        $judulbuku = $rowsing[1];
      }

      $getpj=($row[4] <> "0000-00-00") ? $row[4] : "-" ;
      $getkm=($row[5] <> "0000-00-00") ? $row[5] : "-" ;

      //statuspinjaman
      $date1=date_create($getkm);
      $date2=date_create(date('Y-m-d',time()));
      $diff=date_diff($date2,$date1);
      $status = ($diff->format("%R%a") < 0) ? "<b class='mdl-color-text--red'>Terlambat</b>" : "Masih Berlaku" ;

      $tglpinjam = date_format(date_create($getpj),"j/m/Y");
      $tglharuskembali = date_format(date_create($getkm),"j/m/Y");

      $classes='class="mdl-data-table__cell--non-numeric"';
      echo "<tr><td>$row[0]</td><td>$row[2]</td><td $classes>$judulbuku</td><td $classes>$tglpinjam</td><td $classes>$tglharuskembali</td><td $classes>$status</td><td $classes><a href='?".$gethasquery."&idtra=$row[0]'><b>Ya</b></a></td></tr>";
  }
  echo '</tbody></table></div>';
  }else{
    echo "<span class='mdl-color-text--green'>Saat ini kamu belum memiliki buku yang belum dikembalikan.</span></p>";
  }
}
} elseif ($nisstate == 2) {
$curdate = date('j/m/Y',time());
$getdetailpinjam = mysql_query("SELECT * FROM pengembalian where KodePengembalian='".$_GET['idtra']."'") or die (mysql_error());
      if ($row = mysql_fetch_array($getdetailpinjam)) {
        $notrans=$row[1];
        $nokat = $row[3];
        $tglpinjam= date_format(date_create($row[4]),"j/m/Y");
        $tglkembali= date_format(date_create($row[5]),"j/m/Y");

        //kalkulasihariketerlambatan
        $date1=date_create($row[5]);
        $date2=date_create(date('Y-m-d',time()));
        $diff=date_diff($date2,$date1);
        $terlambat = ($diff->format("%R%a") < 0) ? $diff->format("%a") : 0 ;

        //denda
        $denda=$terlambat*500;

        //tagih
        $tagih = ($row[9]) ? $row[9] : "T" ;
      }
  echo '
<center class="mdl-cell mdl-cell--12-col"><h4>Transaksi Pengembalian Buku</h4></center>
<div class="mdl-card__actions mdl-card--border">
<p class="mdl-cell mdl-cell--12-col">Buku dengan nomer katalog: <b>'.$nokat.'</b></p>
<p class="mdl-cell mdl-cell--12-col">Dipinjam oleh Siswa dengan No Anggota: <b>'.$niskembali.'</b></p>
<p class="mdl-cell mdl-cell--12-col">Detail Transaksi:</p>
<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="notransaksi" id="notransaksi" value="'.$notrans.'"><label class="mdl-textfield__label" for="notransaksi">No Transaksi</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="tglpinjam" id="tglpinjam" value="'.$tglpinjam.'"><label class="mdl-textfield__label" for="tglpinjam">Tanggal Pinjam</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="tglharuskembali" id="tglharuskembali" value="'.$tglkembali.'"><label class="mdl-textfield__label" for="tglharuskembali">Tanggal Harus Kembali</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="tglbukukembali" id="tglbukukembali" value="'.$curdate.'"><label class="mdl-textfield__label" for="tglbukukembali">Tanggal Buku Kembali (Hari ini)</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="wktketerlambatan" id="wktketerlambatan" value="'.$terlambat.'"><label class="mdl-textfield__label" for="wktketerlambatan">Waktu Keterlambatan / Hari</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="denda" id="denda" value="'.$denda.'"><label class="mdl-textfield__label" for="denda">Denda (Rp.1000/Hari)</label></div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col"><input class="mdl-textfield__input" type="text" name="tagih" id="tagih" value="'.$tagih.'"><label class="mdl-textfield__label" for="tagih">Tagih</label></div>
</div>';
}
?>
<div class="mdl-cell mdl-cell--12-col">
<?php
if ($nisstate <> 1) {
  echo '<input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="Ok" type="submit" name="subkembali">';
}
if ($nisstate <> 0) {
  echo '<a class="mdl-button mdl-js-button mdl-button--flat mdl-js-ripple-effect mdl-button--accent" href="'.homelink().'?page=pengembalian%20buku&action=batal">Batal</a>';
}
?>
</div>
</form>
    </div>
    <br>
</div>
</div>  