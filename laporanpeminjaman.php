<?php
$id=(isset($_GET['id'])) ? $_GET['id'] : die("Maaf tentukan id dahulu dari <a href='/perpustakaan/?page=laporan%20peminjaman'>daftar laporan</a>");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Aplikasi Perpustakaan - Cetak Laporan Peminjaman</title>
<script type="text/javascript">
window.onload = function() { window.print(); }
</script>
</head>
<body>
<center>
<table border="1" width="70%">
	<tr>
		<td style="padding:5px 0">
			<center><b>PEMERINTAH KABUPATEN DELI SERDANG<br>DINAS PENDIDIKAN<br>
			SD NEGERI 101895 BANGUN SARI<br>KECAMATAN TANJUNG MORAWA</b></center>
		</td>
	</tr>
	<tr>
		<td><center>
<br><b><u>Laporan Peminjaman Buku</u></b><br>
<span>Perpustakaan SD Negeri 101895 Bangun Sari</span><br><br>

<?php
include_once 'system/connection.php';
$getpinjam = mysql_query("SELECT * FROM pengembalian where KodePengembalian='$id'") or die (mysql_error());
while ($row = mysql_fetch_array($getpinjam)) {
		$nis = $row[2];
		$tgl=$row[4];
		$kembali=$row[5];
		$ktlg=$row[3];
}
$getinfoanggota = mysql_query("SELECT * FROM anggota where NIS='$nis'") or die (mysql_error());
while ($row = mysql_fetch_array($getinfoanggota)) {
		$nama=$row[1];
		$kls=$row[5];
}
$getbuku = mysql_query("SELECT * FROM buku where KodeKatalog='$ktlg'") or die (mysql_error());
while ($row = mysql_fetch_array($getbuku)) {
	$jdlbuku = $row[1];
	$pengarang=$row[2];
	$penerbit=$row[3];
	$isbn=$row[4];
	$stok=$row[5];
}
?>
<table>
	<tr>
		<td>No Peminjaman</td>
		<td>:</td>
		<td><?php echo $id;?></td>
		<td width="30"></td>
		<td>No Induk Siswa</td>
		<td>:</td>
		<td><?php echo $nis;?></td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><?php echo date_format(date_create($tgl),"j/m/Y");?>
		<td width="30"></td>
		<td>Nama Siswa</td>
		<td>:</td>
		<td><?php echo $nama;?></td>
	</tr>
	<tr>
		<td>Batas Peminjaman</td>
		<td>:</td>
		<td><?php echo date_format(date_create($kembali),"j/m/Y");?></td>
		<td width="30"></td>
		<td>Kelas</td>
		<td>:</td>
		<td><?php echo $kls;?></td>
	</tr>
</table>
<br>
<table border="1" width="90%">
	<thead>
		<tr>
			<th>Kode Buku</th>
			<th>Judul Buku</th>
			<th>Pengarang</th>
			<th>Penerbit</th>
			<th>ISBN</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td style="padding:0 5px"><?php echo $ktlg;?></td>
		<td style="padding:0 5px"><?php echo $jdlbuku;?></td>
		<td style="padding:0 5px"><?php echo $pengarang;?></td>
		<td style="padding:0 5px"><?php echo $penerbit;?></td>
		<td style="padding:0 5px"><?php echo $isbn;?></td>
		<td style="padding:0 5px"><?php echo $stok;?></td>
	</tr>
	</tbody>
</table></center><br>
</td></tr>
</table></center>

</body>
</html>