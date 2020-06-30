<?php
require "../dbBroker.php";
require "../model/prodaja.php";
session_start();
if (isset($_POST['datum']) && isset($_POST['idAgenta']) 
    && isset($_POST['idKupca']) && isset($_POST['idAutomobila'])) {
       
    $status = Prodaja::add($_POST['datum'],$_POST['idAgenta'], $_POST['idKupca'], $_POST['idAutomobila'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
?>