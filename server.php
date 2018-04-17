<?php
if($_GET["validate"]){
    readfile('chat-meu.html');
}else{
    readfile('chat-test.html');
}