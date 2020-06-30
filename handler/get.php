<?php


require "../dbBroker.php";
require "../model/automobil.php";

if(isset($_POST['idAutomobila'])) {
    $myArray = Automobil::getById($_POST['idAutomobila'], $conn);
    echo json_encode($myArray);
}

