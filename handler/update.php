<?php

require "../dbBroker.php";
require "../model/automobil.php";

if (isset($_POST['idAutomobila']) && isset($_POST['proizvodjac']) && isset($_POST['model']) && isset($_POST['karoserija'])
    && isset($_POST['kubikaza']) && isset($_POST['cena'])) {

    $status = Automobil::update($_POST['idAutomobila'], $_POST['proizvodjac'], $_POST['model'],$_POST['karoserija'], $_POST['kubikaza'], $_POST['cena'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}