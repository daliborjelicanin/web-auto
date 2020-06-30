<?php
require "../dbBroker.php";
require "../model/kompanija.php";

if(isset($_POST['idKompanije'])) {
    $status = Kompanija::deleteById($_POST['idKompanije'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}