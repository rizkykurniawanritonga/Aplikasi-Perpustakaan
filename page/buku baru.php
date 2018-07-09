<?php
$no = "";$jdl = "";$pengarang = "";$penerbit = "";$isbn = "";$stok="";
if (isset($_POST["simpanbukubaru"]) and !isset($_GET['edit'])) {

  $no = $_POST['nokatalog'];
  $jdl = $_POST['judul'];
  $pengarang = $_POST['pengarang'];
  $penerbit = $_POST['penerbit'];
  $isbn = $_POST['isbn'];
  $stok = $_POST['stok'];

  $getanggota = mysql_query("SELECT * FROM buku where KodeKatalog='$no' or Judul='$jdl' and Pengarang='$pengarang'") or die (mysql_error());
  if ($row = mysql_fetch_array($getanggota)) {
      $_SESSION["errorlogtxt"] = "No Katalog atau Buku ini sudah disimpan sebelumnya";
  } else {
      mysql_query("INSERT INTO `buku` VALUES ('$no','$jdl','$pengarang','$penerbit','$isbn','$stok');") or die (mysql_error());
      $no = "";$jdl = "";$pengarang = "";$penerbit = "";$isbn = "";$stok="";
      $_SESSION["successlogtxt"] = "Buku telah ditambahkan";
  }
}elseif (isset($_GET['edit']) and empty($_POST)) {
  $getbuku = mysql_query("SELECT * FROM buku where KodeKatalog='".$_GET['edit']."'") or die (mysql_error());
  if ($row = mysql_fetch_array($getbuku)) {
      $no = $row[0];$jdl = $row[1];$pengarang = $row[2];$penerbit = $row[3];$isbn = $row[4];$stok = $row[5];
  }
}elseif (isset($_GET['edit']) and isset($_POST["simpanbukubaru"])) {
  $no = $_POST['nokatalog'];
  $jdl = $_POST['judul'];
  $pengarang = $_POST['pengarang'];
  $penerbit = $_POST['penerbit'];
  $isbn = $_POST['isbn'];
  $stok = $_POST['stok'];

  mysql_query("UPDATE buku SET KodeKatalog='$no',Judul='$jdl', Pengarang='$pengarang', Penerbit='$penerbit',ISBN='$isbn',Stok='$stok' WHERE KodeKatalog='$no'") or die (mysql_error());
  $no = "";$jdl = "";$pengarang = "";$penerbit = "";$isbn = "";$stok="";
  redirect("/perpustakaan/?page=katalog");
}
$statepagetitle="Tambah Buku Baru";
if (isset($_GET['edit'])) {
  $statepagetitle="Edit Buku";
}elseif (isset($_GET['delete'])) {
  $statepagetitle="Hapus Buku";
}
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text"><?php echo $statepagetitle;?></h2>
  </div>
<form action="" method="POST">
    <div class="mdl-grid ">
      <div class="mdl-cell mdl-cell--8-col mdl-grid">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="nokatalog" id="nislabel" value="<?php echo $no?>">
          <label class="mdl-textfield__label" for="nislabel">No Katalog</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="isbn" id="nmlabel" value="<?php echo $isbn?>">
          <label class="mdl-textfield__label" for="nmlabel">ISBN</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--10-col mdl-cell--6-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="judul" id="nmlabel" value="<?php echo $jdl?>">
          <label class="mdl-textfield__label" for="nmlabel">Judul Buku</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--4 -col-phone">
          <input class="mdl-textfield__input" type="text" name="stok" id="stoklabel" value="<?php echo $stok?>">
          <label class="mdl-textfield__label" for="stoklabel">Stok</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
          <input class="mdl-textfield__input" type="text" name="pengarang" id="nmlabel" value="<?php echo $pengarang?>">
          <label class="mdl-textfield__label" for="nmlabel">Pengarang</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
          <input class="mdl-textfield__input" type="text"  name="penerbit" id="nmlabel" value="<?php echo $penerbit?>">
          <label class="mdl-textfield__label" for="nmlabel">Penerbit</label>
        </div>

<div class="mdl-cell mdl-cell--12-col">
  <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="Simpan" type="submit" name="simpanbukubaru">
</div>

      </div>
      <div class="mdl-cell mdl-cell--4-col mdl-grid">
        <?php
        if ((isset($_SESSION["errorlogtxt"])) and ($_SESSION["errorlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--red'>".$_SESSION['errorlogtxt']."</b><br>";
          $_SESSION['errorlogtxt'] ="";
        }
        elseif ((isset($_SESSION["successlogtxt"])) and ($_SESSION["successlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--green'>".$_SESSION['successlogtxt']."</b><br><a href='/perpustakaan/?page=katalog'>Lihat daftar</a>";
          $_SESSION['successlogtxt'] ="";
        }
        ?>
        <p>Harap masukkan data buku dengan benar.</p>
      </div>
    </div>
  </form>
</div>
</div>  