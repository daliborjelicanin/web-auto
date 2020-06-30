<?php


class Kompanija
{
    public $idKompanije;
    public $naziv;
    public $mesto;

    public function __construct($idKompanije = null, $naziv = null, $mesto = null)
    {
        $this->idKompanije = $idKompanije;
        $this->naziv = $naziv;
        $this->mesto = $mesto;
       
    }

    public static function getAll(mysqli $conn)
    {
        $q = "SELECT * FROM kompanija";
        return $conn->query($q);
    }

    public static function getById($idKompanije, mysqli $conn)
    {
        $id = (int)($idKompanije);
        $q = "SELECT * FROM kompanija WHERE idKompanije=$id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function deleteById($idKompanije, mysqli $conn)
    {
        $id = (int)($idKompanije);
        $q = "DELETE FROM kompanija WHERE idKompanije=$id";
        return $conn->query($q);
    }

    public static function add($naziv, $mesto, mysqli $conn)
    {
        
        $naz = $conn->real_escape_string($naziv);
        $mest = $conn->real_escape_string($mesto);
        

        $q = "INSERT INTO kompanija(naziv,mesto) values('$naz','$mest)";
        return $conn->query($q);
    }

    public static function update($idKompanije, $naziv, $mesto, mysqli $conn)
    {
        $id = (int)($idKompanije);
        $naz = $conn->real_escape_string($naziv);
        $mest = $conn->real_escape_string($mesto);
        $q = "UPDATE kompanija  set  naziv='$naz', mesto='$mest' where idKompanije=$id";
        return $conn->query($q);
    }
}