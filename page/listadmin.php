<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Daftar Admin</h2><a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="?page=admin baru">
      Tambah Baru
    </a>
<div class="mdl-layout-spacer"></div>
  </div>
<div class="overtable"><table class="mdl-data-table mdl-js-data-table mdl-cell mdl-cell--12-col">
  <thead>
    <tr>
      <th>ID</th>
      <th class="mdl-data-table__cell--non-numeric">Nama</th>
      <th class="mdl-data-table__cell--non-numeric">Username</th>
      <th class="mdl-data-table__cell--non-numeric">Password</th>
    </tr>
  </thead>
  <tbody>
<?php
$showpass = (isset($_GET['showpass']) and ($_GET['showpass'] == "yes")) ? 1 : 0 ;
$classes = "class='mdl-data-table__cell--non-numeric'";
$getadminlist = mysql_query("SELECT * FROM admin") or die (mysql_error());
while ($row = mysql_fetch_array($getadminlist)) {
  $pass = ($showpass) ? $row[3] : str_repeat('*',strlen($row[3]));
  echo "<tr><td>$row[0]</td><td $classes>$row[1]</td><td $classes>$row[2]</td><td $classes>$pass</td></tr>";
}
?>
  </tbody>
</table></div>
  </div>
</div>