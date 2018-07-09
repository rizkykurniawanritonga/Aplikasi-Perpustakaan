<style type="text/css">
.mdl-layout--fixed-drawer>.mdl-layout__content {margin:0}
</style>
<?php
$statefind = (isset($_GET['findbook']) and $_GET['findbook'] <> "") ? 1 : null ;
?>
<main class="mdl-layout__content mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
<br><br><br><center>
<h4 style="margin:0"><?php echo judul();?></h4>
</center>
<div class="mdl-cell mdl-cell--10-col mdl-grid" style="margin:0 auto">
<div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
<div class="mdl-card__title">
	<h2 class="mdl-card__title-text">Daftar Katalog Buku</h2>
<div class="mdl-layout-spacer"></div>
    <form action="<?php echo trim($_SERVER['PHP_SELF'],'index.php');?>" method="GET" style="margin:0">
    <div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable' style="height:0">
      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt1">Cari Katalog Buku</div>
      <label id="tt1" class="mdl-button mdl-js-button mdl-button--icon" for="btncaribuku">
        <i class="icon-search"></i>
      </label>
    <div class="mdl-textfield__expandable-holder">
      <input class="mdl-textfield__input" type="text" id="btncaribuku" name='findbook'>
      <label class="mdl-textfield__label" for="sample-expandable">Cari Katalog Buku</label>
    </div>
  </div>
  </form>
  </div>
<div class="mdl-card__supporting-text" style="padding:0 16px">
<?php if ($statefind) {?>
	<p>Pencarian Buku berdasarkan kueri "<b><?php echo $_GET['findbook'];?></b>"<br>Lihat <a href='<?php echo homelink();?>?findbook'>semua data</a></p>
<?php }?>
</div>
<div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th class="mdl-data-table__cell--non-numeric">No Katalog</th>
      <th class="mdl-data-table__cell--non-numeric">Judul</th>
      <th class="mdl-data-table__cell--non-numeric">Pengarang</th>
      <th class="mdl-data-table__cell--non-numeric">Penerbit</th>
      <th class="mdl-data-table__cell--non-numeric">ISBN</th>
      <th class="mdl-data-table__cell--non-numeric">Stok</th>
    </tr>
  </thead>
  <tbody>
<?php
$extcmd = ($statefind) ? " where KodeKatalog like '%".$_GET['findbook']."%' or Judul like '%".$_GET['findbook']."%' or Pengarang like '%".$_GET['findbook']."%'  or Penerbit like '%".$_GET['findbook']."%'  or ISBN like '%".$_GET['findbook']."%'" : "" ;
$classes = "class='mdl-data-table__cell--non-numeric'";

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM buku".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getkataloglist = mysql_query("SELECT * FROM buku".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getkataloglist)) {
      echo "<tr><td $classes>$row[0]</td><td $classes>$row[1]</td><td $classes>$row[2]</td><td $classes>$row[3]</td><td $classes>$row[4]</td><td $classes>$row[5] Exemplar</td></tr>";
    }
  }else {
    echo "<center><span class='mdl-color-text--red'>Data tidak ada</span></center>";
  }
}
?>
  </tbody>
</table>

</div>
</div>
</div>

<center>Kembali ke <a href='<?php echo homelink();?>'>homepage</a></center>

</main>