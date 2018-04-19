<?php
$valido = $_GET["logado"];
if ($valido === "true") {
    readfile('chat.html');
}else{
    readfile('inicio.html');
}