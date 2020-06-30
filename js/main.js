$('#btn').click(function () {
    $('#pregled').toggle("slow");
});

$('#btn-prodaje').click(function () {
    $('#pregledProdaja').toggle("slow");
});


$('#btnPregledVasihProdaja').click(function () {
    $('#pregledProdaja').toggle("slow");
});



$('#btn-obrisi').click(function () {

    const checked = $('input[name=izabraniAutomobil]:checked');

    if (checked.val() === undefined) {
        alert('Niste izabrali automobil koji zelite da obrisete');
        location.reload();

    } else {

        request = $.ajax({
            url: 'handler/delete.php',
            type: 'post',
            data: { 'idAutomobila': checked.val() }
        });

        request.done(function (response, textStatus, jqXHR) {
            if (response === 'Success') {
                checked.closest('tr').remove();

                console.log('Automobil je obrisan');
                location.reload();
            }
            else {
                console.log('Automobil nije obrisan, doslo je do greske');
                alert('Automobil nije obrisan zato sto je ukljucen u prodaju');
                location.reload();
            }
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Desila se greska: ' + textStatus, errorThrown);
        });

    }


});

$('#btnDodaj').submit(function () {

    $('#myModal').modal('toggle');
    return false;
});

$('#btnDodajProdaju').submit(function () {

    $('#myModalProdaja').modal('toggle');
    return false;
});

$('#dodajForm').submit(function () {

    event.preventDefault();

    const $form = $(this);
    const $inputs = $form.find('input, select, button');
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

    request = $.ajax({
        url: 'handler/add.php',
        type: 'post',
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            console.log('Automobil je dodat');
            console.log('EVO');
            location.reload(true);
        } else console.log('Automobil nije dodat ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });

});

$('#dodajProdajuForm').submit(function (e) {

    e.preventDefault();

    const $form = $(this);
    const $inputs = $form.find('input, select, button, date');
    const serializedData = $form.serialize();
    console.log(serializedData);
    const $datum = $form.find('date');
    if ($datum == "0000-00-00") {
        console.log("ne valja");
    } else {
        $inputs.prop('disabled', true);

        request = $.ajax({
            url: 'handler/addProdaja.php',
            type: 'post',
            data: serializedData
        });

        request.done(function (response, textStatus, jqXHR) {

            if (response === 'Success') {
                console.log('Prodaja je dodat');
                location.reload(true);
            } else console.log('Prodaja nije dodat ' + response);
            console.log(response);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + textStatus, errorThrown);
        });
    }
});

$('#btnIzmeni').submit(function () {

    $('#myModal').modal('toggle');
    return false;

});

$('#btn-izmeni').click(function () {
    var checked = $('input[name=izabraniAutomobil]:checked');

    request = $.ajax({
        url: 'handler/get.php',
        type: 'post',
        data: {
            'idAutomobila': checked.val()
        },
        dataType: 'json'
    });

    request.done(function (response, textStatus, jqXHR) {
        $('#proizvodjac').val(response[0]['proizvodjac'].trim());
        $('#model').val(response[0]['model'].trim());
        $('#karoserija').val(response[0]['karoserija'].trim());
        $('#cena').val(response[0]['cena'].trim());
        $('#kubikaza').val(response[0]['kubikaza'].trim());
        $('#idAutomobila').val(checked.val());

        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {

    });



});

$('#izmeniForm').submit(function () {

    event.preventDefault();

    const $form = $(this);
    const $inputs = $form.find('input, select, button');
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

    request = $.ajax({
        url: 'handler/update.php',
        type: 'post',
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR) {


        if (response === 'Success') {

            alert("Izmenili ste vozilo");
            location.reload(true);

        } else {
            alert("Niste izmenili vozilo");

        }
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });


});

$("#btnStatistikaAdmin").click(function () {
    $('html,body').animate({
            scrollTop: $("#statistika").offset().top
        },
        'slow');
});

$("#btnStatistikaAgent").click(function () {
    $('html,body').animate({
            scrollTop: $("#statistika").offset().top
        },
        'slow');
});

$('#btn-pretraga').click(function () {

    var para = document.querySelector('#myInput');
    console.log(para);
    var style = window.getComputedStyle(para);
    console.log(style);
    if (!(style.display === 'inline-block') || ($('#myInput').css("visibility") == "hidden")) {
        console.log('block');
        $('#myInput').show();
        document.querySelector("#myInput").style.visibility = "";
    } else {
        document.querySelector("#myInput").style.visibility = "hidden";
    }
});

/*  CHART JS*/

function shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

$(document).ready(function () {
    $.ajax({
        url: "http://localhost/iteh/stats/iznosProdajePoKompanijama.php",
        method: "GET",
        success: function (data) {
            console.log(data);
            var kompanije = [];
            var iznosi = [];

            for (var i in data) {
                kompanije.push(data[i].Naziv);
                iznosi.push(data[i].iznos);
            }

            var colors = [];
            var chartdata = {
                labels: kompanije,
                datasets: [{
                    label: 'Ukupan iznos prodaje',
                    backgroundColor: '#FF6633',
                    borderColor: 'rgba(0, 0, 0, 0.75)',
                    hoverBackgroundColor: 'rgba(255, 100, 200, 1)',
                    hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    data: iznosi,

                }]
            };

            var ctx = $("#iznosProdajePoKompanijama");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata,
                options: {
                    scaleFontColor: 'red',
                    responsive: true,
                    tooltips: {
                        mode: 'single',

                    },
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    },



                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            },
                            ticks: {
                                fontColor: "#fff", // this here
                            },
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: true,
                                color: 'rgba(255,255,255,0.4)',
                            },
                            ticks: {
                                fontColor: "#fff", // this here
                            },
                        }],
                    }
                }
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});

var colors = [
    "#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177", "#0d5ac1",
    "#f205e6", "#1c0365", "#14a9ad", "#4ca2f9", "#a4e43f", "#d298e2", "#6119d0",
    "#d2737d", "#c0a43c", "#f2510e", "#651be6", "#79806e", "#61da5e", "#cd2f00",
    "#9348af", "#01ac53", "#c5a4fb", "#996635", "#b11573", "#4bb473", "#75d89e",
    "#2f3f94", "#2f7b99", "#da967d", "#34891f", "#b0d87b", "#ca4751", "#7e50a8",
    "#c4d647", "#e0eeb8", "#11dec1", "#289812", "#566ca0", "#ffdbe1", "#2f1179",
    "#935b6d", "#916988", "#513d98", "#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
    "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
    "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
    "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
    "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
    "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
    "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
    "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
    "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
    "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
    "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
    "#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
    "#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
    "#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473"
];

$(document).ready(function () {
    $.ajax({
        url: "http://localhost/iteh/stats/brojProdajaPoAgentima.php",
        method: "GET",
        success: function (data) {
            console.log(data);
            var agenti = [];
            var broj = [];



            for (var i in data) {
                agenti.push(data[i].ime);
                broj.push(data[i].brojProdaja);

            }



            var chartdata = {
                labels: agenti,
                datasets: [{
                    label: 'Ukupan iznos prodaje',
                    // backgroundColor: 'rgba(255, 255, 2, 0.75)',
                    borderColor: 'rgba(200, 200, 200, 0.75)',
                    hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                    hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    data: broj,
                    backgroundColor: shuffle(colors)
                }]
            };



            var ctx = $("#brojProdajaPoAgentima");

            var barGraph = new Chart(ctx, {
                type: 'pie',
                data: chartdata,
                options: {
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    }
                }
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});

$(document).ready(function () {
    $.ajax({
        url: "http://localhost/iteh/stats/brojKupljenihTipovaAutomobila.php",
        method: "GET",
        success: function (data) {
            console.log(data);
            var karoserija = [];
            var broj = [];

            for (var i in data) {
                karoserija.push(data[i].karoserija);
                broj.push(data[i].brojKaroserija);
            }


            var chartdata = {
                labels: karoserija,
                datasets: [{
                    label: 'Prodati automobili po tipu karoserije',
                    borderColor: 'rgba(200, 200, 200, 0.75)',
                    hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                    hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    data: broj,
                    backgroundColor: shuffle(colors)


                }]
            };

            var ctx = $("#brojKupljenihTipovaAutomobila");

            var barGraph = new Chart(ctx, {
                type: 'pie',
                data: chartdata,
                options: {
                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    }
                }
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});

$(document).ready(function () {
    console.log(user);
    console.log(uloga);
    $.ajax({

        url: "http://localhost/iteh/stats/brojProdajaPoMesecima.php",
        method: "GET",
        success: function (data) {
            console.log(data);
            var mesec = [];
            var broj = [];

            var meseci = ["Januar", "Februar", "Mart", "April", "Maj", "Jun", "Jul", "Avgust", "Septembar", "Oktobar", "Novembar", "Decembar", ];

            for (var i in data) {
                mesec.push(data[i].mesec);
                broj.push(data[i].brojPoMesecu);
            }


            var chartdata = {
                labels: meseci,
                datasets: [{
                    label: 'Broj prodatih automobila po mesecu',
                    borderColor: "#00bfff",
                    //hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                    // hoverBorderColor: 'rgba(200, 200, 200, 1)',
                    data: broj,
                    backgroundColor: "#00bfff",
                    fill: false
                }]
            };

            var ctx = $("#brojProdajaPoMesecima");

            var barGraph = new Chart(ctx, {
                type: 'line',

                data: chartdata,
                options: {
                    scaleFontColor: 'blue',
                    responsive: true,
                    tooltips: {
                        mode: 'single',
                    },

                    legend: {
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    },
                    scales: {
                        pointLabels: {

                        },
                        xAxes: [{
                            gridLines: {
                                display: true,
                            },
                            ticks: {
                                fontColor: "#fff",
                                fontStyle: "bold", // this here
                            },
                        }],
                        yAxes: [{
                            display: true,
                            gridLines: {
                                display: true,
                                color: 'rgba(255,255,255,0.4)',

                            },
                            ticks: {
                                fontColor: "#fff", // this here
                                stepSize: 1,
                            },
                        }],
                    }
                }
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
});