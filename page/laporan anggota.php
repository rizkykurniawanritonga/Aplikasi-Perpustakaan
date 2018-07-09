<?php
$statefind=isset($_GET['cari']);
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Laporan Anggota</h2>
<?php
$linkquer = ($statefind) ? "?cari=".$_GET['cari'] : "" ;
?>
&nbsp;&nbsp;&nbsp;<a class="mdl-button mdl-js-button mdl-button--icon" href="/perpustakaan/laporananggota.php<?php echo $linkquer;?>" target="_blank">
  <i class="icon-print"></i>
</a>
<div class="mdl-layout-spacer"></div>
    <form action="<?php echo trim($_SERVER['PHP_SELF'],'index.php');?>" method="GET" style="margin:0">
    <div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable' style="height:0">
      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt1">Cari data Anggota</div>
      <label id="tt1" class="mdl-button mdl-js-button mdl-button--icon" for="btncarianggota">
        <i class="icon-search"></i>
      </label>
    <div class="mdl-textfield__expandable-holder">
    <input type="hidden" name="page" value="laporan anggota">
      <input class="mdl-textfield__input" type="text" id="btncarianggota" name='cari'>
      <label class="mdl-textfield__label" for="sample-expandable">Cari Data Anggota</label>
    </div>
  </div>
  </form>
  </div>

  <?php
  if ($statefind) {
    echo "<p class='mdl-card__actions mdl-card--border mdl-color-text--blue'>Hasil Pencarian dengan kueri <b>'".$_GET['cari']."'</b>. <a href='".trim($_SERVER['PHP_SELF'],'index.php')."?page=laporan anggota'>Lihat semua data</a></p>";
  }
  ?>

  <div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th>NIS</th>
      <th class="mdl-data-table__cell--non-numeric">Nama Siswa</th>
      <th class="mdl-data-table__cell--non-numeric">Jenis Kelamin</th>
      <th class="mdl-data-table__cell--non-numeric">Kelas</th>
      <th class="mdl-data-table__cell--non-numeric">Alamat</th>
    </tr>
  </thead>
  <tbody>
<?php
$extcmd = ($statefind) ? " where NIS like '%".$_GET['cari']."%' or NamaSiswa like '%".$_GET['cari']."%' or Kelas like '%".$_GET['cari']."%'" : "" ;
$classes = "class='mdl-data-table__cell--non-numeric'";

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM anggota".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getaccountlist = mysql_query("SELECT * FROM anggota".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getaccountlist)) {
      echo "<tr><td>$row[0]</td><td $classes>$row[1]</td><td $classes>$row[4]</td><td $classes>$row[5]</td><td $classes>$row[6]</td></tr>";
    }
  }else{
    echo "<center>Data tidak ada</center>";
  }
}
?>
  </tbody>
</table></div>
  </div>
</div>