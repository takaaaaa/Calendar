<?php
$SERV = "localhost";
$USER = "root";
$PASS = "";
$DBNM = "comp";

$db = mysqli_connect($SERV, $USER, $PASS, $DBNM) or die(mysqli_connect_error());
mysqli_set_charset($db, 'utf8');
?>

