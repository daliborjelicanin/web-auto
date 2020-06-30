<?php
require "../dbBroker.php";
require "../model/automobil.php";

if(isset($_POST['idAutomobila'])) {
    $status = Automobil::deleteById($_POST['idAutomobila'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}