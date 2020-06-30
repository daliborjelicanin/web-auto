<?php
//setting header to json
header('Content-Type: application/json');

require "../dbBroker.php";

if(!$conn){
  die("Connection failed: " . $conn->error);
}

//query to get data from the table
$query = sprintf("SELECT ime,count(ime) as brojProdaja FROM prodaja p join korisnik k on p.idAgenta=k.id join kompanija kk on p.idKupca=kk.idKompanije join automobil a on p.idAutomobila = a.idAutomobila group by ime");

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