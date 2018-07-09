<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Perpustakaan - Data Transaksi</title>
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
<br><b><u>Laporan Transaksi</u></b><br>
<span>Perpustakaan SD Negeri 101895 Bangun Sari</span><br><br>
	<table width="90%" border="1">
		<thead>
			<tr>
				<th>No Transaksi</th>
				<th>NIS</th>
				<th>No Katalog</th>
				<th>Tanggal Pinjam</th>
				<th>Tanggal Kembali</th>
				<th>Tanggal Buku Kembali</th>
				<th>Waktu Keterlambatan</th>
				<th>Denda</th>
				<th>Tagih</th>
			</tr>
		</thead>
		<tbody>

<?php
include_once 'system/connection.php';
$getdate=getdate(date("U"));
$statefind=isset($_GET['cari']);
$statesort=isset($_GET['sort']);
$extcmdcari = ($statefind) ? " or KodePeminjaman like '%".$_GET['cari']."%' or NIS like '%".$_GET['cari']."%' or KodeKatalog like '%".$_GET['cari']."%'" : "" ;
$extcmdsort = ($statesort) ? " where TglPinjam like '%".$getdate['year']."-".$_GET['sort']."-%' or TglPinjam LIKE '%".$getdate['year']."-0".$_GET['sort']."-%'" : "";
$getjumlahdata=mysql_query("SELECT COUNT(*) AS jumlahdata FROM pengembalian".$extcmdsort.$extcmdcari) or die (mysql_error());
while ($row = mysql_fetch_array($getjumlahdata)) {
  if ($row[0]) {
    $getaccountlist = mysql_query("SELECT * FROM pengembalian".$extcmdsort.$extcmdcari) or die (mysql_error());
    while ($row = mysql_fetch_array($getaccountlist)) {
    	$bukubalik = ($row[6] <> "0000-00-00") ? date_format(date_create($row[6]),"j/m/Y") : "00/00/0000";
    	$denda = ($row[8] > 0) ? "Rp. ".$row[8] : 0;
		$tagih = ($row[9] == "Y") ? "Ya" : "Tidak";
		echo "<tr><td>$row[0]</td><td>$row[2]</td><td>$row[3]</td><td>".date_format(date_create($row[5]),"j/m/Y")."</td><td>".date_format(date_create($row[5]),"j/m/Y")."</td><td>$bukubalik</td><td>$row[7]</td><td>$denda</td><td>$tagih</td></tr>";
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