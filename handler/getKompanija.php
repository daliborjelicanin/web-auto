<?php


require "../dbBroker.php";
require "../model/kompanija.php";

if(isset($_POST['idKompanije'])) {
    $myArray = Kompanija::getById($_POST['idKompanije'], $conn);
    echo json_encode($myArray);
}

