<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Perpustakaan - Cetak Laporan Buku</title>

<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>

</head>
<body>

<center>
<table border="1" width="80%">
	<tr>
		<td style="padding:5px 0">
			<center><b>PEMERINTAH KABUPATEN DELI SERDANG<br>DINAS PENDIDIKAN<br>
			SD NEGERI 101895 BANGUN SARI<br>KECAMATAN TANJUNG MORAWA</b></center>
		</td>
	</tr>
	<tr>
		<td><center>
<br><b><u>Laporan Buku</u></b><br>
<span>Perpustakaan SD Negeri 101895 Bangun Sari</span><br><br>
	<table width="80%" border="1">
		<thead>
			<tr>
				<th>No Katalog</th>
				<th>Judul Buku</th>
				<th>Pengarang</th>
				<th>Penerbit</th>
				<th>ISBN</th>
				<th>Stok</th>
			</tr>
		</thead>
		<tbody>
<?php
include_once 'system/connection.php';
$statefind=isset($_GET['carikatalog']);
$extcmd = ($statefind) ? " where KodeKatalog like '%".$_GET['carikatalog']."%' or Judul like '%".$_GET['carikatalog']."%' or Pengarang like '%".$_GET['carikatalog']."%'  or Penerbit like '%".$_GET['carikatalog']."%'  or ISBN like '%".$_GET['carikatalog']."%'" : "" ;

$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM buku".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getkataloglist = mysql_query("SELECT * FROM buku".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getkataloglist)) {
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5] Exemplar</td></tr>";
    }
  }else {
    echo "<center>Data tidak ada</center>";
  }
}
?>
</tbody>
</table><br>
</center></td></tr></table>
</center>

</body>
</html>