<?php
$statefind=isset($_GET['caritransaksi']);
$statesort=isset($_GET['sortmonth']);
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Daftar Transaksi</h2><a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="?page=peminjaman%20buku">
      Pinjam Buku
    </a><a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="?page=pengembalian%20buku">
      Kembalikan Buku
    </a>
<?php
$linkquer = ($statefind) ? "cari=".$_GET['caritransaksi'] : "" ;
$sortquer = ($statesort) ? "sort=".$_GET['sortmonth'] : "" ;
$andquer = (($statefind <> 0) and ($statesort <> 0)) ? "&" : "" ;
$quer=(isset($_GET)) ? "?".$linkquer.$andquer.$sortquer : "";
?>
<a class="mdl-button mdl-js-button mdl-button--icon" href="/perpustakaan/laporantransaksi.php<?php echo $quer;?>" target="_blank">
  <i class="icon-print"></i>
</a>

<div class="mdl-layout-spacer"></div>
    <form action="<?php echo trim($_SERVER['PHP_SELF'],'index.php');?>" method="GET" style="margin:0">
    <div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable' style="height:0">
      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt1">Cari Transaksi</div>
      <label id="tt1" class="mdl-button mdl-js-button mdl-button--icon" for="btncaribuku">
        <i class="icon-search"></i>
      </label>
    <div class="mdl-textfield__expandable-holder">
    <input type="hidden" name="page" value="transaksi">
<?php
if ($statesort) {
  echo '<input type="hidden" name="sortmonth" value="'.$_GET['sortmonth'].'">';
}
?>
      <input class="mdl-textfield__input" type="text" id="btncaribuku" name='caritransaksi'>
      <label class="mdl-textfield__label" for="sample-expandable">Cari Transaksi</label>
    </div>
  </div>
  </form>
  </div>

<div class='mdl-cell mdl-cell--12-col bulani'>
<small><b>Bulan</b>:
<?php
$getdate=getdate(date("U"));
$month = array
  (
  array("Januari",1),
  array("Februari",2),
  array("Maret",3),
  array("April",4),
  array("Mei",5),
  array("Juni",6),
  array("Juli",7),
  array("Agustus",8),
  array("September",9),
  array("Oktober",10),
  array("November",11),
  array("Desember",12),
  );
$curmonth = $getdate['mon'];
$getbul = (isset($_GET['sortmonth'])) ? $_GET['sortmonth'] : $curmonth ;
foreach ($month as $val) {
  $tag = array(
    array("<a href='?page=transaksi&sortmonth=$val[1]'>","</a>"),
    array("<mark>","</mark>")
  );
  $cmdsql = "SELECT COUNT(*) AS jumlahdata FROM pengembalian where TglPinjam like '%".$getdate['year']."-".$val[1]."-%' or TglPinjam LIKE '%".$getdate['year']."-0".$val[1]."-%'";
  $getjumlahdata=mysql_query($cmdsql) or die (mysql_error());
  while ($row = mysql_fetch_array($getjumlahdata)) {
    $mark = $tag[1][0].$val[0]."(<b>$row[0]</b>)".$tag[1][1];
    $def=$tag[0][0].$val[0]."(<b>$row[0]</b>)".$tag[0][1];
  }
  $orecho = (($val[1] == $curmonth) and !isset($_GET['sortmonth'])) ? $mark : $def ;
  echo (isset($_GET['sortmonth']) and $_GET['sortmonth'] == $val[1]) ? $mark : $orecho ;
  echo "&nbsp;";
}
?></small>
</div>

  <?php
if (($statefind <> 0) or ($statesort <> 0)) {
  $txthslcari = ($statefind) ? "dengan kueri <b>'".$_GET['caritransaksi']."'</b>." : "" ;
  $txthasilsort = ($statesort) ? "pada bulan <b>".$month[$getbul-1][0]."</b>" : "" ;
  echo "<p class='mdl-card__actions mdl-card--border mdl-color-text--blue'>Hasil Pencarian ".$txthslcari." ".$txthasilsort." <a href=".trim($_SERVER['PHP_SELF'],'index.php').'?page=transaksi'.">Lihat semua data</a></p>";
}
  ?>

<div class="overtable must"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th class="mdl-data-table__cell--non-numeric">ID Transaksi</th>
      <th class="mdl-data-table__cell--non-numeric">ID Anggota</th>
      <th class="mdl-data-table__cell--non-numeric">No Katalog</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal Pinjam</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal Kembali</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal Buku Kembali</th>
      <th class="mdl-data-table__cell--non-numeric">Waktu Keterlambatan</th>
      <th class="mdl-data-table__cell--non-numeric">Denda</th>
      <th class="mdl-data-table__cell--non-numeric">Tagih</th>
    </tr>
  </thead>
  <tbody>
<?php
$extcmdcari = ($statefind) ? " or KodePeminjaman like '%".$_GET['caritransaksi']."%' or NIS like '%".$_GET['caritransaksi']."%' or KodeKatalog like '%".$_GET['caritransaksi']."%'" : "" ;
$extcmdsort = ($statesort) ? " where TglPinjam like '%".$getdate['year']."-".$_GET['sortmonth']."-%' or TglPinjam LIKE '%".$getdate['year']."-0".$_GET['sortmonth']."-%'" : " where TglPinjam like '%".$getdate['year']."-".$curmonth."-%' or TglPinjam LIKE '%".$getdate['year']."-0".$curmonth."-%'";
$classes = "class='mdl-data-table__cell--non-numeric'";
$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM pengembalian".$extcmdsort.$extcmdcari) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getaccountlist = mysql_query("SELECT * FROM pengembalian".$extcmdsort.$extcmdcari) or die (mysql_error());
    while ($row = mysql_fetch_array($getaccountlist)) {
      $tbk = ($row[6] <> "0000-00-00") ? date_format(date_create($row[6]),"j/m/Y") : "<span class='mdl-cell mdl-cell--12-col mdl-color-text--red'>(Belum dikembalikan)</span>";
      $tagih = ($row[9] == "Y") ? "Ya" : "Tidak";
		  echo "<tr><td $classes>$row[0]</td><td $classes><a href='?page=anggota&cari=$row[2]'>$row[2]</a></td><td $classes><a href='?page=katalog&carikatalog=$row[3]'>$row[3]</a></td><td $classes>".date_format(date_create($row[4]),"j/m/Y")."</td><td $classes>".date_format(date_create($row[5]),"j/m/Y")."</td><td $classes>$tbk</td><td $classes>$row[7]</td><td $classes>$row[8]</td><td $classes>$tagih</td></tr>";
    }
  }else {
    echo "<center>Data untuk bulan <b><i>".$month[$getbul-1][0]."</i></b> tidak ada.</center>";
  }
}
?>
  </tbody>
</table></div>
  </div>
</div>