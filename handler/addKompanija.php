<?php
require "../dbBroker.php";
require "../model/kompanija.php";

if (isset($_POST['naziv']) && isset($_POST['mesto'])) {

    $status = Kompanija::add($_POST['naziv'], $_POST['mesto'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
?>