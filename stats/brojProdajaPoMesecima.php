<?php
//setting header to json
header('Content-Type: application/json');
session_start();
require "../dbBroker.php";

if(!$conn){
  die("Connection failed: " . $conn->error);
}

if(isset ($_SESSION['user']) && isset($_SESSION['uloga'])){
  
  if($_SESSION['uloga']=='admin'){
    
    $query = sprintf("SELECT MONTH(datum) AS mesec,COUNT(MONTH(datum)) AS brojPoMesecu FROM prodaja p JOIN korisnik k ON p.idAgenta=k.id JOIN kompanija kk ON p.idKupca=kk.idKompanije JOIN automobil a ON p.idAutomobila = a.idAutomobila GROUP BY MONTH(datum) order by MONTH(datum)");

  }else{
    $id = $_SESSION['id'];
    
    $query = sprintf("SELECT idAgenta,MONTH(datum) AS mesec,COUNT(MONTH(datum)) AS brojPoMesecu FROM (SELECT * FROM PRODAJA WHERE idAgenta= '".$id."') a GROUP BY MONTH(datum) order by MONTH(datum)");


  }


}



//query to get data from the table
//$query = sprintf("SELECT MONTH(datum) AS mesec,COUNT(MONTH(datum)) AS brojPoMesecu FROM prodaja p JOIN korisnik k ON p.idAgenta=k.id JOIN kompanija kk ON p.idKupca=kk.idKompanije JOIN automobil a ON p.idAutomobila = a.idAutomobila GROUP BY MONTH(datum) order by MONTH(datum)");

//execute query
$result = $conn->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$conn->close();

//now print the data
print json_encode($data);