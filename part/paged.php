<?php
incfile("part/func","php");

$pgtxt = (!empty($_GET['page'])) ? ucwords($_GET['page']) : "" ;
headerel($pgtxt);
drawerel()
?>
<main class="mdl-layout__content mdl-color--grey-100">
<?php
$paged = (!empty($_GET['page'])) ? $_GET['page'] : null ;
if ($paged) {
	switch (strtolower($paged)){
		case 'transaksi':
			incfile("page/transaksi","php");
			break;
		case 'katalog':
			incfile("page/katalog","php");
			break;
		case 'anggota':
			incfile("page/anggota","php");
			break;
		case 'daftar anggota':
			incfile("page/daftar anggota","php");
			break;
		case 'buku baru':
			incfile("page/buku baru","php");
			break;
		case 'daftar admin':
			incfile("page/listadmin","php");
			break;
		case 'admin baru':
			incfile("page/admin baru","php");
			break;
		case 'peminjaman buku':
			incfile("page/peminjaman buku","php");
			break;
		case 'pengembalian buku':
			incfile("page/pengembalian buku","php");
			break;
		case 'profile':
			incfile("page/profile","php");
			break;
		case 'laporan anggota':
			incfile("page/laporan anggota","php");
			break;
		case 'laporan buku':
			incfile("page/laporan buku","php");
			break;
		case 'laporan peminjaman':
			incfile("page/laporan peminjaman","php");
			break;
		case 'laporan pengembalian':
			incfile("page/laporan pengembalian","php");
			break;
		default:
			echo "<div class='mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col'><div class='mdl-card__title'><h2 class='mdl-typography--display-4'>404: Error</h2></div><p class='mdl-card__supporting-text'>Maaf, Halaman '<b>$pgtxt</b>' tidak ditemukan. Silahkan hubungi bagian IT administrator.</p></div>";
			break;
	}
} else {
	incfile("page/home","php");
}
?>        
</main>