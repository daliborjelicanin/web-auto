<?php


class Prodaja
{
    public $idProdaje;
    public $datum;
    public $idAgenta;
    public $idKompanije;
    public $idAutomobila;

    public function __construct($idProdaje = null, $datum = null, $idAgenta = null, $idKompanije = null, $idAutomobila = null)
    {
        $this->idProdaje = $idProdaje;
        $this->datum = $datum;
        $this->idAgenta = $idAgenta;
        $this->idKompanije = $idKompanije;
        $this->idAutomobila = $idAutomobila;
    }

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM prodaja p join korisnik k on p.idAgenta=k.id join kompanija kk on p.idKupca=kk.idKompanije join automobil a on p.idAutomobila = a.idAutomobila";
        return $conn->query($q);
    }

    public static function getAllForAgent( $agent ,mysqli $conn)
    {
        $q = "SELECT * FROM prodaja p join korisnik k on p.idAgenta=k.id join kompanija kk on p.idKupca=kk.idKompanije join automobil a on p.idAutomobila = a.idAutomobila where p.idAgenta=$agent ";
        return $conn->query($q);
    }

    public static function getById($idProdaje, mysqli $conn)
    {
        $q = "SELECT * FROM prodaja WHERE idProdaje=$idProdaje";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function deleteById($idProdaje, mysqli $conn)
    {
        $q = "DELETE FROM prodaja WHERE idProdaje=$idProdaje";
        return $conn->query($q);
    }

    public static function add($datum, $idAgenta, $idKupca, $idAutomobila, mysqli $conn)
    {
        

        $q = "INSERT INTO prodaja(datum,idAgenta,idKupca,idAutomobila) values('$datum','$idAgenta', '$idKupca', $idAutomobila)";

        
        return $conn->query($q);
    }

    public static function update($idProdaje, $datum, $idAgenta, $idKompanije, $idAutomobila, mysqli $conn)
    {
        $q = "UPDATE prodaja  set  datum='$datum', idAgenta='$idAgenta', idKompanije='$idKompanije', idAutomobila=$idAutomobila where idProdaje=$idProdaje";
        return $conn->query($q);
    }
}