<?php

class Korisnik {
    public $id;
    public $username;
    public $password;
    public $ime;
    public $uloga;

    public function __construct($id = null, $username = null, $password = null, $ime = null, $uloga = null) 
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->ime = $ime;
        $this->uloga = $uloga;
    }

    public static function logInUser($username, $password,mysqli $conn)
    {
        
        $user = $conn->real_escape_string($username);
        $pass = $conn->real_escape_string($password);
        $q ="select * from korisnik where username='".$user."' and password='".$pass."' limit 1";
        return $conn->query($q);
    }

    public static function getById($idKorisnika, mysqli $conn)
    {
        $id = (int)($idKorisnika);
        $q = "SELECT * FROM korisnik WHERE idKorisnika=$id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }


}