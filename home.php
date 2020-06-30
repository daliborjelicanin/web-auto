<?php


require "dbBroker.php";
require "model/automobil.php";
require "model/kompanija.php";
require "model/prodaja.php";
require "model/korisnik.php";

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
} elseif (isset($_GET['logout']) && !empty($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
}


$result = Automobil::getAll($conn);
$result2 = Kompanija::getAll($conn);
$result3 = Prodaja::getAllForAgent($_SESSION['id'], $conn);
$result4 = Prodaja::getAll($conn);

if (!$result) {
    echo "Nastala je greska pri izvodenju upita<br>";
    die();
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <script src="js/jspdf.js"></script>
        <title>WEB auto</title>

    </head>

    <body>


        <div id="temperatura" class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6 naslov">
                <h1>WEB auto</h1>
            </div>

            <div class="col-md-3">
                <div class="jumbotron">
                    <p id="ulogovaniKorisnik" style="text-align:right"> <?php echo $_SESSION['uloga'] . ": " . $_SESSION['user']  ?> </p>
                    <a href="home.php?logout=true" style="float: right; padding: 10px">

                        <button id="logout" type="button" class="btn btn-danger odjavi-se">Odjavi se</button>
                    </a>
                    <h1><br></h1>

                </div>

            </div>

        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4 outer">

                    <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin") { ?>
                        <div class="inner ">
                            <h3>PREGLED AUTOMOBILA</h3>
                            <button id="btn" class="btn btn-info btn-block" style="background-color: #F39237 !important; border: lightpink !important;"><i class="glyphicon glyphicon-eye-open"></i> Pregled automobila
                            </button>
                        </div>
                        <div class="inner">
                            <h3>PREGLED SVIH PRODAJA</h3>
                            <button id="btn-prodaje" class="btn btn-info btn-block" style="background-color: #F39237 !important; border: lightpink !important;"><i class="glyphicon glyphicon-eye-open"></i> Pregled svih prodaja
                            </button>
                        </div>
                    <?php } else { ?>
                        <div class="inner">
                            <h3>PREGLED VAŠIH PRODAJA</h3>
                            <button id="btnPregledVasihProdaja" class="btn btn-info btn-block" style="background-color: #F39237 !important; border: lightpink !important;"><i class="glyphicon glyphicon-eye-open"></i> Pregled vaših prodaja
                            </button>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-4 outer">
                    <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin") { ?>
                        <div class="inner">
                            <h3>DODAJ NOVI AUTOMOBIL</h3>

                            <button id="btn-dodaj" type="button" class="btn btn-success btn-block" style="background-color: #4EACF3; border: #A03E81;" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Dodaj novi
                            </button>
                        </div>
                        <div class="inner">
                            <h3>PRETRAGA AUTOMOBILA</h3>


                            <input type="text" id="myInput" class="form-control" onkeyup="pretragaAutomobila()" placeholder="Pretrazi automobile">
                        </div>
                    <?php } else { ?>
                        <div class="inner">
                            <h3>DODAJ NOVU PRODAJU</h3>

                            <button id="btn-dodaj-prodaju" type="button" class="btn btn-success btn-block" style="background-color: #4EACF3; border: #A03E81;" data-toggle="modal" data-target="#myModalProdaja"><i class="glyphicon glyphicon-plus"></i> Dodaj prodaju
                            </button>
                        </div>
                        <div class="inner">
                            <h3>PRETRAGA PRODAJA</h3>


                            <input type="text" id="myInput" class="form-control" onkeyup="pretragaProdaja()" placeholder="Pretrazi prodaje">
                        </div>

                    <?php } ?>
                </div>
                <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin") { ?>
                    <div class="col-md-4 outer">
                        <div class="inner">
                            <h3>STATISTIKA</h3>
                            <button id="btnStatistikaAdmin" class="btn btn-info btn-block" style="background-color: 	#228B22 !important; border: lightpink !important;"><i class="glyphicon glyphicon-eye-open"></i> Statistika
                            </button>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-4 outer">
                        <div class="inner">
                            <h3>STATISTIKA</h3>
                            <button id="btnStatistikaAgent" class="btn btn-info btn-block" style="background-color: 	#228B22 !important; border: lightpink !important;"><i class="glyphicon glyphicon-eye-open"></i> Statistika
                            </button>
                        </div>
                    </div>

                <?php } ?>



            </div>



        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4 outer">
                    <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin") { ?>
                        <button id="btn-izmeni" class="btn btn-warning" style="background-color: #4EACF3; border: #A03E81; width: 20%" data-toggle="modal" data-target="#izmeniModal">
                            <i class="glyphicon glyphicon-pencil"></i> Izmeni
                        </button>
                        <button id="btn-obrisi" class="btn btn-danger" style="background-color: #ED6A5A; border: #ED6A5A; width: 20%"><i class="glyphicon glyphicon-trash"></i> Obriši
                        </button>
                    <?php }   ?>
                </div>

            </div>
        </div>

        <div class="panel panel-info" style="margin-top: 1%">
            <?php if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin") { ?>
                <div id="pregled">
                    <div>
                        <h2>Svi automobili</h2>
                    </div>
                    <div class="panel-heading">Pregled automobila</div>
                    <div class="panel-body">
                        <div style="height:400px;overflow:auto;">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>

                                        <th scope="col">Proizvodjac</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Karoserija</th>
                                        <th scope="col">Kubikaza</th>
                                        <th scope="col">Cena</th>
                                        <th scope="col">Izmena/Brisanje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($red = $result->fetch_array()) { ?>
                                        <tr>


                                            <td><?php echo $red["proizvodjac"] ?></td>
                                            <td><?php echo $red["model"] ?></td>
                                            <td><?php echo $red["karoserija"] ?></td>
                                            <td><?php echo $red["kubikaza"] ?></td>
                                            <td><?php echo $red["cena"] ?></td>

                                            <td>
                                                <label class="custom-radio-btn">
                                                    <input type="radio" name="izabraniAutomobil" value=<?php echo $red["idAutomobila"] ?> checked>

                                                </label>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>

                    </div>

                </div>
                <div id="pregledProdaja">
                    <div>
                        <h2>Prodaje svih agenata</h2>
                        <button id="btn-generisiPdf" class="btn btn-warning" style="background-color: #00FF7F; border: #00FF7F; width: 10%; margin-left:30px" onclick="javascript:demoFromHTML();">
                            <i class="glyphicon glyphicon-file"></i> Download pdf
                        </button>
                    </div>
                    <div class="panel-heading">Pregled prodaja</div>
                    <div class="panel-body">
                        <div style="height:400px;overflow:auto;">

                            <table id="myTableProdaje" class="table table-striped">
                                <thead>
                                    <tr>

                                        <th scope="col">Datum</th>
                                        <th scope="col">Agent</th>
                                        <th scope="col">Kompanija</th>
                                        <th scope="col">Proizvodjac</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Karoserija</th>
                                        <th scope="col">Kubikaza</th>

                                        <th id="sort" scope="col">
                                            <div id="cenaSort">Cena </div>
                                            <div class="bt"><button onclick="sortTableAsc()">&#x25B2;</button><br /><button onclick="sortTableDesc()">&#x25BC;</button></div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($red = $result4->fetch_array()) {
                                    ?>
                                        <tr>


                                            <td><?php echo $red["datum"] ?></td>
                                            <td><?php echo $red["ime"] ?></td>
                                            <td><?php echo $red["Naziv"] ?></td>
                                            <td><?php echo $red["proizvodjac"] ?></td>
                                            <td><?php echo $red["model"] ?></td>
                                            <td><?php echo $red["karoserija"] ?></td>
                                            <td><?php echo $red["kubikaza"] ?></td>
                                            <td><?php echo $red["cena"] ?></td>



                                        </tr>
                                    <?php

                                    }  ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>







            <?php } else { ?>
                <div id="pregledProdaja">
                    <div>
                        <h2>Vase prodaje</h2>
                        <button id="btn-generisiPdf" class="btn btn-warning" style="background-color: #00FF7F; border: #00FF7F; width: 10%; margin-left:30px" onclick="javascript:demoFromHTML();">
                            <i class="glyphicon glyphicon-file"></i> Download pdf
                        </button>
                    </div>
                    <div class="panel-heading">Pregled prodaja</div>
                    <div class="panel-body">
                        <div id style="height:400px;overflow:auto;">
                            <table id="myTableProdaje" class="table table-striped">
                                <thead>
                                    <tr>

                                        <th id="Datum" scope="col">Datum</th>
                                        <th id="Agent" scope="col">Agent</th>
                                        <th id="Kompanija" scope="col">Kompanija</th>
                                        <th id="Proizvodjac" scope="col">Proizvodjac</th>
                                        <th id="Model" scope="col">Model</th>
                                        <th id="Karoserija" scope="col">Karoserija</th>
                                        <th id="Kubikaza" scope="col">Kubikaza</th>
                                        <th id="sort" scope="col">
                                            <div id="cenaSort">Cena </div>
                                            <div class="bt"><button onclick="sortTableAsc()">&#x25B2;</button><br /><button onclick="sortTableDesc()">&#x25BC;</button></div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    while ($red = $result3->fetch_array()) {
                                    ?>
                                        <tr>


                                            <td><?php echo $red["datum"] ?></td>
                                            <td><?php echo $red["ime"] ?></td>
                                            <td><?php echo $red["Naziv"] ?></td>
                                            <td><?php echo $red["proizvodjac"] ?></td>
                                            <td><?php echo $red["model"] ?></td>
                                            <td><?php echo $red["karoserija"] ?></td>
                                            <td><?php echo $red["kubikaza"] ?></td>
                                            <td><?php echo $red["cena"] ?></td>



                                        </tr>
                                <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <section id="statistika">
                    <div class="row grafik">
                        <div class="col-md-6 ">
                            <h3 class="nazivGrafika">Iznos prodaje po kompanijama</h3>
                            <div class="chart-container">
                                <canvas id="iznosProdajePoKompanijama"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <h3 class="nazivGrafika">Broj prodaja po agentima</h3>
                            <div class="chart-container">
                                <canvas id="brojProdajaPoAgentima"></canvas>
                            </div>
                        </div>


                    </div>
                    <div class="row grafik ">
                        <div class="col-md-6 ">
                            <h3 class="nazivGrafika">Broj kupljenih tipova automobila</h3>
                            <div class="chart-container">
                                <canvas id="brojKupljenihTipovaAutomobila"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 lineChart ">
                            <h3 class="nazivGrafika">Broj prodaja po mesecima</h3>
                            <div class="chart-container">
                                <canvas id="brojProdajaPoMesecima"></canvas>
                            </div>
                        </div>


                    </div>
                </section>

            <?php } ?>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="color: #A03E81">NOVI AUTOMOBIL</h3>

                    </div>
                    <div class="modal-body">
                        <div class="container automobil-form">

                            <form action="#" method="post" id="dodajForm">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" required name="proizvodjac" class="form-control" placeholder="Proizvodjac automobila *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required name="model" class="form-control" placeholder="Model automobila *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="karoserija" id="sel1">
                                                <option>limuzina</option>
                                                <option>hatchback</option>
                                                <option>karavan</option>
                                                <option>kupe</option>
                                                <option>dzip</option>
                                                <option>pickup</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" required name="kubikaza" class="form-control" placeholder="Kubikaza *">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" required name="cena" class="form-control" placeholder="Cena *" value="" />
                                        </div>

                                        <div class="form-group">
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block dugme-u-modalu" style="background-color: #A03E81; border: #A03E81;"><i class="glyphicon glyphicon-plus"></i> Dodaj
                                            </button>
                                        </div>

                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Zatvori</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="izmeniModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="color: #000">IZMENA AUTOMOBILA</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container automobil-form">

                            <form action="#" method="post" id="izmeniForm">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="idAutomobila" type="text" name="idAutomobila" required class="form-control" placeholder="Id automobila *" readonly value="<?php echo $red["idAutomobila"] ?>" />
                                        </div>
                                        <div class="form-group">
                                            <input id="proizvodjac" required type="text" name="proizvodjac" class="form-control" placeholder="Proizvodjac automobila *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input id="model" required type="text" name="model" class="form-control" placeholder="Model automobila *" value="" />
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control" id="select-model" name="karoserija" id="sel1">
                                                <option>limuzina</option>
                                                <option>hatchback</option>
                                                <option>karavan</option>
                                                <option>kupe</option>
                                                <option>dzip</option>
                                                <option>pickup</option>


                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input id="cena" required type="number" name="cena" class="form-control" placeholder="Cena *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input id="kubikaza" required name="kubikaza" class="form-control" placeholder="Kubikaza *">
                                        </div>
                                        <div class="form-group">
                                            <button id="btnIzmeni" type="submit" class="btn btn-success btn-block dugme-u-modalu"><i class="glyphicon glyphicon-ok"></i> Potvrdi izmene
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Zatvori</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModalProdaja" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="color: #A03E81">NOVA PRODAJA</h3>

                    </div>
                    <div class="modal-body">
                        <div class="container automobil-form">

                            <form action="#" method="post" id="dodajProdajuForm">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h4>Agent</h4>
                                            <input id="idAgenta" required name="idAgenta" readonly class="form-control" value="<?php echo $_SESSION['id']  ?>">
                                        </div>
                                        <div class="form-group">
                                            <h4>Automobil</h4>
                                            <select class="form-control" name="idAutomobila" id="1">
                                                <?php
                                                foreach ($result as $auto) { ?>
                                                    <option value="<?= $auto['idAutomobila'] ?>"><?= $auto['proizvodjac'] ?> <?= $auto['model'] ?> <?= $auto['karoserija'] ?> <?= $auto['kubikaza'] ?> <?= $auto['cena'] ?>&euro;</option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h4>Kompanija</h4>
                                            <select class="form-control" name="idKupca" id="">
                                                <?php
                                                foreach ($result2 as $komp) { ?>
                                                    <option value="<?= $komp['idKompanije'] ?>"><?= $komp['Naziv'] ?> <?= $komp['Mesto'] ?></option>
                                                <?php
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h4>Datum prodaje</h4>
                                            <input class="form-control" type="date" name="datum">
                                        </div>

                                        <div class="form-group">
                                            <button id="btnDodajProdaju" type="submit" class="btn btn-success btn-block dugme-u-modalu" style="background-color: #A03E81; border: #A03E81;"><i class="glyphicon glyphicon-plus"></i> Dodaj prodaju
                                            </button>
                                        </div>

                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Zatvori</button>
                    </div>
                </div>

            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/Chart.min.js"></script>

        <?php $session_user = (isset($_SESSION['user'])) ? $_SESSION['user'] : '';
        $session_uloga = (isset($_SESSION['uloga'])) ? $_SESSION['uloga'] : '';
        ?>

        <script type="text/javascript">
            var user = '<?php echo $session_user; ?>';
            var uloga = '<?php echo $session_uloga; ?>';
        </script>


        <script src="js/main.js"></script>

        <!-- Funkcije za pretragu -->
        <script>
            function pretragaAutomobila() {

                var input, filter, table, tr, i, td1, td2, td3, td4, txtValue1, txtValue2, txtValue3, txtValue4;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[0];
                    td2 = tr[i].getElementsByTagName("td")[1];
                    td3 = tr[i].getElementsByTagName("td")[2];
                    td4 = tr[i].getElementsByTagName("td")[3];

                    if (td1 || td2 || td3 || td4) {
                        txtValue1 = td1.textContent || td1.innerText;
                        txtValue2 = td2.textContent || td2.innerText;
                        txtValue3 = td3.textContent || td3.innerText;
                        txtValue4 = td4.textContent || td4.innerText;

                        if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                            txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            function pretragaProdaja() {

                var input, filter, table, tr, i, td1, td2, td3, td4, td5, td6, td7, td8, txtValue1, txtValue2, txtValue3, txtValue4, txtValue5, txtValue6, txtValue7, txtValue8;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTableProdaje");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td1 = tr[i].getElementsByTagName("td")[0];
                    td2 = tr[i].getElementsByTagName("td")[1];
                    td3 = tr[i].getElementsByTagName("td")[2];
                    td4 = tr[i].getElementsByTagName("td")[3];
                    td5 = tr[i].getElementsByTagName("td")[4];
                    td6 = tr[i].getElementsByTagName("td")[5];
                    td7 = tr[i].getElementsByTagName("td")[6];
                    td8 = tr[i].getElementsByTagName("td")[7];

                    if (td1 || td2 || td3 || td4 || td5 || td6 || td7 || td8) {
                        txtValue1 = td1.textContent || td1.innerText;
                        txtValue2 = td2.textContent || td2.innerText;
                        txtValue3 = td3.textContent || td3.innerText;
                        txtValue4 = td4.textContent || td4.innerText;
                        txtValue5 = td5.textContent || td5.innerText;
                        txtValue6 = td6.textContent || td6.innerText;
                        txtValue7 = td7.textContent || td7.innerText;
                        txtValue8 = td8.textContent || td8.innerText;

                        if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                            txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1 || txtValue5.toUpperCase().indexOf(filter) > -1 ||
                            txtValue6.toUpperCase().indexOf(filter) > -1 || txtValue7.toUpperCase().indexOf(filter) > -1 || txtValue8.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        <script>
            function sortTableAsc() {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("myTableProdaje");
                switching = true;
                /*Make a loop that will continue until
                no switching has been done:*/
                while (switching) {
                    //start by saying: no switching is done:
                    switching = false;
                    rows = table.rows;
                    /*Loop through all table rows (except the
                    first, which contains table headers):*/
                    for (i = 1; i < (rows.length - 1); i++) {
                        //start by saying there should be no switching:
                        shouldSwitch = false;
                        /*Get the two elements you want to compare,
                        one from current row and one from the next:*/

                        x = rows[i].getElementsByTagName("td")[7];
                        y = rows[i + 1].getElementsByTagName("td")[7];
                        //check if the two rows should switch place:

                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        /*If a switch has been marked, make the switch
                        and mark that a switch has been done:*/
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }
            }


            function sortTableDesc() {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("myTableProdaje");
                switching = true;
                /*Make a loop that will continue until
                no switching has been done:*/
                while (switching) {
                    //start by saying: no switching is done:
                    switching = false;
                    rows = table.rows;
                    /*Loop through all table rows (except the
                    first, which contains table headers):*/
                    for (i = 1; i < (rows.length - 1); i++) {
                        //start by saying there should be no switching:
                        shouldSwitch = false;
                        /*Get the two elements you want to compare,
                        one from current row and one from the next:*/

                        x = rows[i].getElementsByTagName("td")[7];
                        y = rows[i + 1].getElementsByTagName("td")[7];
                        //check if the two rows should switch place:

                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        /*If a switch has been marked, make the switch
                        and mark that a switch has been done:*/
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }
            }


            function demoFromHTML() {
                var pdf = new jsPDF('p', 'pt', 'letter');
                // source can be HTML-formatted string, or a reference
                // to an actual DOM element from which the text will be scraped.

                source = $('#pregledProdaja')[0];




                // we support special element handlers. Register them with jQuery-style 
                // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
                // There is no support for any other type of selectors 
                // (class, of compound) at this time.
                specialElementHandlers = {
                    // element with id of "bypass" - jQuery style selector
                    '#bypassme': function(element, renderer) {
                        // true = "handled elsewhere, bypass text extraction"
                        return true
                    }
                };
                margins = {
                    top: 80,
                    bottom: 60,
                    left: 5,
                    width: 1000
                };
                // all coords and widths are in jsPDF instance's declared units
                // 'inches' in this case
                pdf.fromHTML(
                    source, // HTML string or DOM elem ref.
                    margins.left, // x coord
                    margins.top, { // y coord
                        'width': margins.width, // max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },

                    function(dispose) {
                        // dispose: object with X, Y of the last line add to the PDF 
                        //          this allow the insertion of new lines after html
                        pdf.save("<?php echo "Prodaje_" . $_SESSION['user']  ?>");
                    }, margins);
            }
        </script>


    </body>

    </html>