<?php
$nis = "";$nm = "";$tlhr = "";$tgllhr = "";$jk = "";$kls = "";$almt = "";
if (isset($_POST["simpandaftaranggota"]) and !isset($_GET['edit'])) {
  $nis = $_POST['NIS'];
  $nm = $_POST['namasiswa'];
  $tlhr = $_POST['tempatlahir'];
  $tgllhr = resetdatemysql($_POST['tgllahir'],"d/m/Y");
  $jk = $_POST['jeniskelamin'];
  $kls = $_POST['kelas'];
  $almt = $_POST['alamat'];

  $getanggota = mysql_query("SELECT * FROM anggota where NIS='$nis'") or die (mysql_error());
  if ($row = mysql_fetch_array($getanggota)) {
      $_SESSION["errorlogtxt"] = "NIS yang di masukkan sudah didaftarkan sebelumnya";
  } else {
      mysql_query("INSERT INTO `anggota` VALUES ('$nis','$nm','$tlhr','$tgllhr','$jk','$kls','$almt');") or die (mysql_error());
      $_SESSION["savedidforcard"]=$nis;
      $nis = "";$nm = "";$tlhr = "";$tgllhr = "";$jk = "";$kls = "";$almt = "";
      $_SESSION["successlogtxt"] = "Anda telah didaftarkan";
  }
}elseif (isset($_GET['edit']) and empty($_POST)) {
  $getanggota = mysql_query("SELECT * FROM anggota where NIS='".$_GET['edit']."'") or die (mysql_error());
  if ($row = mysql_fetch_array($getanggota)) {
      $nis = $row[0];$nm = $row[1];$tlhr = $row[2];$tgllhr = $row[3];$jk = $row[4];$kls = $row[5];$almt = $row[6];
  }
}elseif (isset($_GET['edit']) and isset($_POST["simpandaftaranggota"])) {
  $nis = $_POST['NIS'];
  $nm = $_POST['namasiswa'];
  $tlhr = $_POST['tempatlahir'];
  $tgllhr = resetdatemysql($_POST['tgllahir'],"d/m/Y");
  $jk = $_POST['jeniskelamin'];
  $kls = $_POST['kelas'];
  $almt = $_POST['alamat'];

  mysql_query("UPDATE anggota SET NamaSiswa='$nm', TempatLahir='$tlhr', TanggalLahir='$tgllhr',JenisKelamin='$jk',Kelas='$kls',Alamat='$almt' WHERE NIS='$nis'") or die (mysql_error());
  $nis = "";$nm = "";$tlhr = "";$tgllhr = "";$jk = "";$kls = "";$almt = "";
  redirect("/perpustakaan/?page=anggota");
}

$statepagetitle="Mendaftar Anggota Baru";
$submittxt="Daftar";
if (isset($_GET['edit'])) {
  $statepagetitle="Edit Anggota";
  $submittxt="Simpan";
}elseif (isset($_GET['delete'])) {
  $statepagetitle="Hapus Anggota";
  $submittxt="Hapus";
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
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--3-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="NIS" id="nislabel" value="<?php echo $nis?>">
          <label class="mdl-textfield__label" for="nislabel">NIS</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--9-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="namasiswa" id="nmlabel" value="<?php echo $nm?>">
          <label class="mdl-textfield__label" for="nmlabel">Nama Siswa</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--7-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="tempatlahir" id="tllabel" value="<?php echo $tlhr?>">
          <label class="mdl-textfield__label" for="tllabel">Tempat Lahir</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--5-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="tgllahir" id="tgllahirlbl" value="<?php echo date_format(date_create($tgllhr),"d/m/Y")?>">
          <label class="mdl-textfield__label" for="tgllahirlbl">Tanggal Lahir, Format: 31/12/1990</label>
        </div>


        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">Jenis Kelamin : 
          <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="jklaki">
<?php
$lkstate = ($jk == "Laki-Laki") ? 'checked=""' : '' ;
$prstate = ($jk == "Perempuan") ? 'checked=""' : '' ;
$lkstate = ($jk == 0) ? 'checked=""' :'';
?>
  <input type="radio" id="jklaki" class="mdl-radio__button" name="jeniskelamin" value="Laki-Laki" <?php echo $lkstate;?>>
  <span class="mdl-radio__label">Laki - Laki</span>
</label>
&nbsp;&nbsp;
<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="jkwanita">
  <input type="radio" id="jkwanita" class="mdl-radio__button" name="jeniskelamin" value="Perempuan" <?php echo $prstate;?>>
  <span class="mdl-radio__label">Perempuan</span>
</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="kelas" id="kelas" value="<?php echo $kls?>">
          <label class="mdl-textfield__label" for="kelas">Kelas</label>
        </div>

<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
    <textarea class="mdl-textfield__input" type="text" rows= "3" id="alamatid" name="alamat"><?php echo $almt?></textarea>
    <label class="mdl-textfield__label" for="alamatid">Alamat</label>
  </div>

<div class="mdl-cell mdl-cell--12-col">
  <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="<?php echo $submittxt;?>" type="submit" name="simpandaftaranggota">
</div>

      </div>
      <div class="mdl-cell mdl-cell--4-col mdl-grid">
        <?php
        if ((isset($_SESSION["errorlogtxt"])) and ($_SESSION["errorlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--red'>".$_SESSION['errorlogtxt']."</b>";
          $_SESSION['errorlogtxt'] ="";
        }
        elseif ((isset($_SESSION["successlogtxt"])) and ($_SESSION["successlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--green'>".$_SESSION['successlogtxt']."</b><br>";
          echo '<a class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect" target="_blank" href="'.homelink().'/kartuanggota.php?id='.$_SESSION["savedidforcard"].'">Lihat Kartu Anggota</a>';
          $_SESSION['successlogtxt'] ="";
          $_SESSION["savedidforcard"]="";
        }
        ?>
        <p>Dengan mendaftar, itu berarti setiap siswa harus bersedia menepati aturan yang telah ditetapkan pihak sekolah sebelumnya dan bersedia untuk diberikan sanksi jika melanggar peraturan yang telah dibuat.</p>
      </div>
    </div>
  </form>
</div>
</div>  