<?php
header('Content-Type: application/json');

require "../dbBroker.php";
require "../model/prodaja.php";


    $myArray = Prodaja::getAll($conn);
    while ($red = $myArray->fetch_array()) {
        
                     echo $red["ime"];
                    echo $red["Naziv"];
                    echo $red["proizvodjac"];
                    echo $red["model"];
                    echo $red["karoserija"];
                     echo $red["kubikaza"];
                    echo $red["cena"] ;
                    echo "/n";

    }
    echo json_encode($myArray);
