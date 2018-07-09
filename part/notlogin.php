<style type="text/css">
.mdl-layout--fixed-drawer>.mdl-layout__content {margin:0}
</style>
<main class="mdl-layout__content mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">

<br><br><center><h4 style="margin-bottom:0"><?php echo judul();?></h4></center>
            <div class="mdl-cell mdl-cell--4-col mdl-grid" style="margin:0 auto">
                <div class="mdl-cell mdl-cell--12-col mdl-card mdl-shadow--4dp">
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text">Login</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <p>Untuk Masuk ke Aplikasi Harap Login terlebih dahulu.</p>
                        <form method="POST" action="/perpustakaan/auth/">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
                                <input class="mdl-textfield__input" type="text" name="username" id="userlabel" autofocus="">
                                <label class="mdl-textfield__label" for="userlabel">Username</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
                                <input class="mdl-textfield__input" type="password" name="password" id="pslabel">
                                <label class="mdl-textfield__label" for="pslabel">Password</label>
                            </div>
                            <p>
                                <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name='submitlogin' value="Login">
                            </p>
                        </form>
                        <?php if (isset($_SESSION["errorlogtxt"])) {
                            echo "<p class='mdl-color-text--red'>".$_SESSION["errorlogtxt"]."</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
<center>Kembali ke <a href='<?php echo homelink();?>'>Homepage</a></center>
</main>