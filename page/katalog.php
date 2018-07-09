<?php
$statefind=isset($_GET['carikatalog']);
if (isset($_GET['delete']) and ($_GET['delete'] <> "")) {
  mysql_query("DELETE FROM buku WHERE KodeKatalog='".$_GET['delete']."'") or die (mysql_error());
  redirect("/perpustakaan/?page=katalog");
}
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Daftar Katalog Buku</h2><a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="?page=buku baru">
      Tambah Baru
    </a>
<div class="mdl-layout-spacer"></div>
    <form action="<?php echo trim($_SERVER['PHP_SELF'],'index.php');?>" method="GET" style="margin:0">
    <div class='mdl-textfield mdl-js-textfield mdl-textfield--expandable' style="height:0">
      <div class="mdl-tooltip mdl-tooltip--left" data-mdl-for="tt1">Cari Katalog Buku</div>
      <label id="tt1" class="mdl-button mdl-js-button mdl-button--icon" for="btncaribuku">
        <i class="icon-search"></i>
      </label>
    <div class="mdl-textfield__expandable-holder">
    <input type="hidden" name="page" value="katalog">
      <input class="mdl-textfield__input" type="text" id="btncaribuku" name='carikatalog'>
      <label class="mdl-textfield__label" for="sample-expandable">Cari Katalog Buku</label>
    </div>
  </div>
  </form>
  </div>

  <?php
  echo ($statefind) ? "<p class='mdl-card__actions mdl-card--border mdl-color-text--blue'>Hasil Pencarian dengan kueri <b>'".$_GET['carikatalog']."'</b>. <a href=".trim($_SERVER['PHP_SELF'],'index.php').'?page=katalog'.">Lihat semua data</a></p>" : "" ;
  ?>
<div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th>&nbsp;</th>
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
function menuaksi($val){
return '<button id="act-'.$val.'"class="mdl-button mdl-js-button mdl-button--icon"><i class="icon-edit"></i></button><ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"for="act-'.$val.'"><li><a class="mdl-menu__item" href="?page=buku baru&edit='.$val.'">Edit</a></li><li><a class="mdl-menu__item" href="?page=katalog&delete='.$val.'">Hapus</a></li></ul>';
}
$extcmd = ($statefind) ? " where KodeKatalog like '%".$_GET['carikatalog']."%' or Judul like '%".$_GET['carikatalog']."%' or Pengarang like '%".$_GET['carikatalog']."%'  or Penerbit like '%".$_GET['carikatalog']."%'  or ISBN like '%".$_GET['carikatalog']."%'" : "" ;
$classes = "class='mdl-data-table__cell--non-numeric'";

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM buku".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getkataloglist = mysql_query("SELECT * FROM buku".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getkataloglist)) {
      echo "<tr><td>".menuaksi("$row[0]")."</td><td $classes>$row[0]</td><td $classes>$row[1]</td><td $classes>$row[2]</td><td $classes>$row[3]</td><td $classes>$row[4]</td><td $classes>$row[5] Exemplar</td></tr>";
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