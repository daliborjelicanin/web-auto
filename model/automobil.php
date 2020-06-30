<?php


class Automobil
{
    public $idAutomobila;
    public $proizvodjac;
    public $model;
    public $karoserija;
    public $kubikaza;
    public $cena;

    public function __construct($idAutomobila = null, $proizvodjac = null, $model = null,$karoserija=null, $kubikaza = null, $cena = null)
    {
        $this->idAutomobila = $idAutomobila;
        $this->proizvodjac = $proizvodjac;
        $this->model = $model;
        $this->karoserija = $karoserija;
        $this->kubikaza = $kubikaza;
        $this->cena = $cena;
    }

  

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM automobil";
        return $conn->query($q);
    }

    public static function getById($idAutomobila, mysqli $conn)
    {
        $id = (int)($idAutomobila);
        $q = "SELECT * FROM automobil WHERE idAutomobila=$id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function deleteById($idAutomobila, mysqli $conn)
    {
        $id = (int)($idAutomobila);
        $q = "DELETE FROM automobil WHERE idAutomobila=$id";
        return $conn->query($q);
    }

    public static function add($proizvodjac, $model,$karoserija, $kubikaza, $cena, mysqli $conn)
    {
        $pro = $conn->real_escape_string($proizvodjac);
        $mod = $conn->real_escape_string($model);
        $kar = $conn->real_escape_string($karoserija);
        $kub = (int)($kubikaza);
        $cen = (int)($cena);

        $q = "INSERT INTO automobil(proizvodjac,model,karoserija,kubikaza,cena) values('$pro','$mod','$kar', '$kub', $cen)";
        return $conn->query($q);
    }

    public static function update($idAutomobila, $proizvodjac, $model,$karoserija, $kubikaza, $cena, mysqli $conn)
    {
        $id = (int)($idAutomobila);
        $pro = $conn->real_escape_string($proizvodjac);
        $mod = $conn->real_escape_string($model);
        $kar = $conn->real_escape_string($karoserija);
        $kub = (int)($kubikaza);
        $cen = (int)($cena);
        
        $q = "UPDATE automobil  set  proizvodjac='$proizvodjac', model='$model', karoserija='$karoserija', kubikaza='$kubikaza', cena=$cena where idAutomobila=$idAutomobila";
        return $conn->query($q);
    }
}