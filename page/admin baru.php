<?php
$nama = "";$user = "";$pass = "";
//Perintah DAFTAR BeLuM Jadi
if (isset($_POST["simpanadminbaru"])) {
  $nama = $_POST['nama'];
  $user = strtolower($_POST['user']);
  $pass = strtolower($_POST['pass']);

  $getanggota = mysql_query("SELECT * FROM admin where Username='$user'") or die (mysql_error());
  if ($row = mysql_fetch_array($getanggota)) {
      $_SESSION["errorlogtxt"] = "Username ini sudah didaftarkan sebelumnya.";
  } else {
      mysql_query("INSERT INTO `admin` VALUES (null,'$nama','$user','$pass');") or die (mysql_error());
      $nama = "";$user = "";$pass = "";
      $_SESSION["successlogtxt"] = "Admin telah ditambahkan";
  }
}
?>
<div class="mdl-grid demo-content">

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
  <div class="mdl-card__title">
    <h2 class="mdl-card__title-text">Tambah Admin Baru</h2>
  </div>
<form action="" method="POST">
    <div class="mdl-grid ">
      <div class="mdl-cell mdl-cell--8-col mdl-grid">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="nama" id="nmlabel" value="<?php echo $nama?>">
          <label class="mdl-textfield__label" for="nmlabel">Nama</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="text" name="user" id="userlabel" value="<?php echo $user?>">
          <label class="mdl-textfield__label" for="userlabel">Username</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
          <input class="mdl-textfield__input" type="password" name="pass" id="pslabel" value="<?php echo $pass?>">
          <label class="mdl-textfield__label" for="pslabel">Password</label>
        </div>

<div class="mdl-cell mdl-cell--12-col">
  <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" value="Tambahkan" type="submit" name="simpanadminbaru">
</div>

      </div>
      <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
        <?php
        if ((isset($_SESSION["errorlogtxt"])) and ($_SESSION["errorlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--red'>".$_SESSION['errorlogtxt']."</b><br>";
          $_SESSION['errorlogtxt'] ="";
        }
        elseif ((isset($_SESSION["successlogtxt"])) and ($_SESSION["successlogtxt"] <> "")) {
          echo "<b class='mdl-color-text--green'>".$_SESSION['successlogtxt']."</b><br><a href='/perpustakaan/?page=daftar admin'>Lihat daftar</a>";
          $_SESSION['successlogtxt'] ="";
        }
        ?>
        <p>Dihimbau kepada admin sistem perpustakaan ini agar selalu menjaga data data yang ada didalam ini baik sengaja atau tidak.</p>
      </div>
    </div>
  </form>
</div>
</div>  