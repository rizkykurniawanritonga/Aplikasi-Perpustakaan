<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Perpustakaan - Laporan Anggota</title>
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
<br><b><u>Laporan Anggota</u></b><br>
<span>Perpustakaan SD Negeri 101895 Bangun Sari</span><br><br>
	<table width="90%" border="1">
		<thead>
			<tr>
				<th>NIS</th>
				<th>Nama Siswa</th>
				<th>Jenis Kelamin</th>
				<th>Kelas</th>
				<th>Alamat</th>
			</tr>
		</thead>
		<tbody>

<?php
include_once 'system/connection.php';
$statefind=isset($_GET['cari']);
$extcmd = ($statefind) ? " where NIS like '%".$_GET['cari']."%' or NamaSiswa like '%".$_GET['cari']."%' or Kelas like '%".$_GET['cari']."%'" : "" ;
$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM anggota".$extcmd) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getaccountlist = mysql_query("SELECT * FROM anggota".$extcmd) or die (mysql_error());
    while ($row = mysql_fetch_array($getaccountlist)) {
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td></tr>";
    }
  }else{
    echo "<center>Data tidak ada</center>";
  }
}
?>

		</tbody>
	</table><br>
	</center></td>
	</tr>
	</table>
</center>

</body>
</html>