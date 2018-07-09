<?php
$statefind=isset($_GET['caripeminjaman']);
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Laporan Peminjaman</h2>
<div class="mdl-layout-spacer"></div>
    <form action="<?php echo trim($_SERVER['PHP_SELF'],'index.php');?>" method="GET" style="margin:0">
    <div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable' style="height:0">
      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt1">Cari Peminjaman</div>
      <label id="tt1" class="mdl-button mdl-js-button mdl-button--icon" for="btncaribuku">
        <i class="icon-search"></i>
      </label>
    <div class="mdl-textfield__expandable-holder">
    <input type="hidden" name="page" value="laporan peminjaman">
      <input class="mdl-textfield__input" type="text" id="btncaribuku" name='caripeminjaman'>
      <label class="mdl-textfield__label" for="sample-expandable">Cari Peminjaman</label>
    </div>
  </div>
  </form>
  </div>

  <?php
  echo ($statefind) ? "<p class='mdl-card__actions mdl-card--border mdl-color-text--blue'>Hasil Pencarian dengan kueri <b>'".$_GET['caripeminjaman']."'</b>. <a href='".trim($_SERVER['PHP_SELF'],'index.php')."?page=laporan Peminjaman'>Lihat semua data</a></p>" : "" ;
  ?>
<div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th class="mdl-data-table__cell--non-numeric">No Peminjaman</th>
      <th class="mdl-data-table__cell--non-numeric">NIS Siswa</th>
      <th class="mdl-data-table__cell--non-numeric">Kode Buku</th>
      <th class="mdl-data-table__cell--non-numeric">Cetak Laporan</th>
      <th class="mdl-data-table__cell--non-numeric">Tanggal</th>
      <th class="mdl-data-table__cell--non-numeric">Batas Pengembalian</th>
      <th class="mdl-data-table__cell--non-numeric">Status</th>
    </tr>
  </thead>
  <tbody>
<?php
$extcmd = ($statefind) ? " where KodePeminjaman like '%".$_GET['caripeminjaman']."%' or NIS like '%".$_GET['caripeminjaman']."%' or KodeKatalog like '%".$_GET['caripeminjaman']."%'" : "" ;
$classes = "class='mdl-data-table__cell--non-numeric'";

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM pengembalian".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getkataloglist = mysql_query("SELECT * FROM pengembalian".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getkataloglist)) {
      $getpj=$row[4] ;
      $getkm=$row[5] ;

      //statuspinjaman
      $date1=date_create($getkm);
      $date2=date_create(date('Y-m-d',time()));
      $diff=date_diff($date2,$date1);
      $getstatus = ($diff->format("%R%a") < 0) ? "<b class='mdl-color-text--red'>Terlambat</b>" : "Masih Berlaku" ;

      $status = ($row[9] <> "Y") ? $getstatus : "<b class='mdl-color-text--green'>Sudah Dikembalikan</b>" ;

      echo "<tr><td $classes>$row[0]</td><td $classes><a href='?page=anggota&cari=$row[2]'>$row[2]</a></td><td $classes><a href='?page=katalog&carikatalog=$row[3]'>$row[3]</a></td><td $classes><a class='mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect' href='/perpustakaan/laporanpeminjaman.php?id=$row[0]' target='_blank'>Cetak</a></td><td $classes>".date_format(date_create($getpj),"j/m/Y")."</td><td $classes>".date_format(date_create($getkm),"j/m/Y")."</td><td $classes>$status</td></tr>";
    }
  }else {
    echo "<center>Data tidak ada</center>";
  }
}
?>
  </tbody>
</table></div>
  </div>
</div>