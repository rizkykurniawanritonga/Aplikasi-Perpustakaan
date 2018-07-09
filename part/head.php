<?php
function inithead($val){
echo '<HTML><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="description" content="Aplikasi Perpustakaan untuk TA."><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"><title>'.$val.'</title>';
incfile("cdn/font/material-icons","css");
incfile("cdn/css/material.min","css");
incfile("cdn/css/style","css");
echo '<link href="cdn/img/sd.gif" rel="shortcut icon" type="image/x-icon"/></head><body><div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">';
}
?>