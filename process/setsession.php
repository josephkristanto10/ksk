<?php
session_start();
$idsister = $_POST['idsister'];
$namasister = $_POST['namasister'];


$_SESSION['idsister'] = $idsister;
$_SESSION['namasister'] = $namasister;

?>