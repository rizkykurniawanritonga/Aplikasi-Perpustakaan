<style type="text/css">
.mdl-layout--fixed-drawer>.mdl-layout__content {margin:0}
.mdl-textfield__input {border-bottom: 1px solid rgba(255,255,255,.12)}
.mdl-textfield__label:after{background-color:#fff}
.mdl-textfield--floating-label .mdl-textfield__label{color:#aaa}
.mdl-textfield--floating-label.is-focused .mdl-textfield__label{color:#fff}
</style>
<main class="mdl-layout__content mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

<br><br><br><br><br><br><br><br><br><br><br><br>
<center>
<h3><?php echo judul();?></h3>

<form action="?findbook" method="GET">
  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" name='findbook' type="text" id="sample3" autofocus>
    <label class="mdl-textfield__label" for="sample3">Pencarian Buku...</label>
  </div>
</form>


<p>Lihat <a href='<?php echo homelink();?>?findbook'>semua katalog</a> // Admin? silahkan <a href='?page=login'>login</a></p>
</center>

</main>