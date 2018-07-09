<script type="text/javascript">
 window.onload = function() { window.print(); }
</script>
<?php
include_once 'system/connection.php';
$nis=$_GET['id'];
$getaccount = mysql_query("SELECT * FROM anggota where NIS='$nis'") or die (mysql_error());
  if ($row = mysql_fetch_array($getaccount)) {
    	$nisvar=$row[0];
    	$namavar=$row[1];
    	$kelasvar=$row[5];
    	$alamatvar=$row[6];
  }else{
    die("Kartu anggota dengan NIS: $nis tidak ditemukan");
  }
?><!DOCTYPE html><html><head><title>Kartu Anggota: [<?php echo $nisvar;?>] - <?php echo $namavar;?></title></head><body>
<table border="1" width="500">
	<tr>
		<td style="padding:5px 0">
			<center><b>PEMERINTAH KABUPATEN DELI SERDANG<br>DINAS PENDIDIKAN<br>
			SD NEGERI 101895 BANGUN SARI<br>KECAMATAN TANJUNG MORAWA</b></center>
		</td>
	</tr>
	<tr>
		<td>
			<center><p style="margin-bottom:25px"><b>KARTU ANGGOTA PERPUSTAKAAN</b></p></center>
<table style="margin-left:20px">
	<tr style="vertical-align:initial"><td width="120px">1. NIS</td><td>:</td><td><?php echo $nisvar;?></td></tr>
	<tr style="vertical-align:initial"><td width="120px">2. Nama Siswa</td><td>:</td><td><?php echo $namavar;?></td></tr>
	<tr style="vertical-align:initial"><td width="120px">3. Kelas</td><td>:</td><td><?php echo $kelasvar;?></td></tr>
	<tr style="vertical-align:initial"><td width="120px">4. Alamat</td><td>:</td><td style="display: block;max-height: 35px;overflow: hidden;"><?php echo $alamatvar;?></td></tr>
</table>
			<pre style="line-height:.9;font-family:inherit">
										Tg. Morawa,



									    <b>PUSTAKAWATI</b>
			</pre>
		</td>
	</tr>
</table>
</body></html>