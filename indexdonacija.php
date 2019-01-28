<?php
require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloodBank</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="popupstyle.css" rel="stylesheet">
</head>
<body>
<!-- Navigation -->
<div id="nav-placeholder">
</div>

<script>
    $(function(){
        $("#nav-placeholder").load("navbar.php");
    });
</script>

<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
        <li data-target="#slides" data-slide-to="0" class="active"></li>
        <li data-target="#slides" data-slide-to="1" ></li>
        <li data-target="#slides" data-slide-to="2" ></li>
    </ul>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/donacija11.png" border="red">
            <div class="carousel-caption">
                <h1>Doniraj i spasi život</h1><br>
                <img src="https://img-cache.cdn.gaiaonline.com/fdcc3e959eb100491c4601a7efe2576c/http://i1201.photobucket.com/albums/bb353/mazzel100/Untitled-1.gif" style="width:90px;height:90px">
            </div>
        </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<!--- Jumbotron -->
<div class="border">
    <div class="container-fluid">
        <div class="row jumbotron">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                <h2>Zašto darivati krv?</h2><br>
                <font size="4px">
                <p>
                    Opće je poznato da krv nije moguće proizvesti na umjetan način.<br>
                    Jedini izvor toga lijeka je čovjek - <font color="#b22222">DONOR KRVI</font>, a 1 doza krvi moze spasiti čak 3 života!<br><br>
                    <h5>Darivanjem krvi:</h5>
                    <ul style="margin-left: 40px">
                        <li> vršimo kontrolu vlastitog zdravlja te pomažemo napretku tuđeg</li>
                        <li> može se započeti i prestati u svako doba između 18 i 65 (70) godina života</li>
                        <li> ne nastaju nikakve štetne tjelesne promjene ili posljedice po organizam te ne šteti zdravlju ako se provedu svi propisani postupci pri odabiru darivatelja krvi</li>
                    </ul>
                    Svaka zdrava osoba pripadajuće dobi može bez opasnosti za svoje zdravlje darovati krv, 3 do 4 puta tijekom jedne godine.<br>
                    Zdrav organizam darivatelja krvi vrlo brzo u potpunosti nadoknađuje količinu i sve sastavne dijelove darovane krvi:
                    već unutar 24 sata organizam nadoknadi tekući dio krvi - plazmu i njene sastojke, broj trombocita i leukocita.
                    Eritrociti se nadoknade unutar 4 do 6 tjedana.
                </p>
                </font>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
                <img src="img/zastodonirati.png" style="width:270px;height;270px;margin-left: -50px">
                <img src="img/kapljicadonacije.png" style="width:200px;height;270px;margin-left: -15px">
            </div>

        </div>
    </div>

    <!--- Welcome Section -->
    <div class="container-fluid">
        <div class="row jumbotron">
            <div class="col-12" style="text-align: center">
                <h1 class="display-4">Tko može donirati krv?</h1>
                <hr>
            </div>
            <div class="row jumbotron">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
                    <img src="img/covjeculjak_donacija.png" style="width:150px;height;270px">
                </div>

                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10" style="margin-top: -30px;margin-bottom: -90px">
                    <font size="4px">
                        <ul style="margin-left: 40px">
                            <li><b>Dob:</b> od 18 do 65 godina, do 60 godina ako krv daje prvi put, do 70 godina 1-2 godišnje nakon pregleda i odluke liječnika specijalista transfuzijske medicine.</li><br>
                            <li><b>Tjelesna težina:</b> iznad 55 kg, proporcionalna visini.</li><br>
                            <li><b>Tjelesna temperatura:</b> do 37°C.</li><br>
                            <li><b>Krvni tlak:</b> sistolični 100 do 180 mm Hg, dijastolični 60 do 110 mm Hg.</li><br>
                            <li><b>Puls:</b> 50 do 100 otkucaja u minuti.</li><br>
                            <li><b>Puls:</b> 50 do 100 otkucaja u minuti.</li><br>
                            <li><b>Hemoglobin:</b> muškarci 135 g/L, žene 125 g/L.</li><br>
                        </ul>
                        U Hrvatskoj, muškarci, darivatelji pune krvi smiju dati krv do 4 puta godišnje, s razmakom između darivanja od 3 mjeseca. Žene, darivateljice pune krvi, smiju dati krv do 3 puta godišnje, s razmakom između darivanja od 4 mjeseca.
                    </font>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row jumbotron">
            <div class="col-12" style="text-align: center">
                <h1 class="display-4">Postupak darivanja krvi</h1>
                <hr>
            </div>
            <div class="row jumbotron">

                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10" style="margin-top: -30px;margin-bottom: -200px">
                    <font size="4px">
                        <ol style="margin-left: 40px">
                            <li><b>Identifikacija donora.</b><br> Kod svakog darivanja krvi sa nekim identifikacijskim dokumentom sa slikom ( osobna iskaznica, putovnica, vozačka dozvola, indeks). Ispis podataka na evidencijski karton davatelja krvi.</li><br>
                            <li><b>Provjera hemoglobina.</b><br> Sterilnom lancetom tehničar ubode darivatelja u jagodicu prsta i skida kap krvi koju trzajem lancete spušta u posudu sa bakrenim sulfatom poznate koncentracije. Kada kapljica tone, darivatelj može dati krv. Test sa bakrenim sulfatom je jednostavna, brza i pouzdana metoda kojom štitimo darivatelje krvi.</li><br>
                            <li><b>Liječnički pregled</b><br> Liječnicki pregled podrazumijeva razgovor sa liječnikom, mjerenje tlaka, provjeru rada srca i po potrebi tjelesne težine. Kroz postavljanje određenih pitanja liječnik odlučuje da li osoba može darovati krv bez škodljivosti za svoje zdravstveno stanje, te bez opasnosti za potencijalne primatelje krvi. Darivatelj krvi je udobno smješten na krevetu za davanje krvi.</li><br>
                            <li><b>Venepunkcija.</b><br> Iskusan zdravstveni tehničar odabire venu u lakatnoj jami i bezbolno uvodi iglu u venu.
                                Sam čin darivanja krvi traje maksimalno desetak minuta.Darivatelj je u ugodnom poluležećem položaju dok laganim stiskanjem šake puni vrećicu za krv koja je sterilnom iglom i sistemom vezana za njegovu venu u lakatnoj jami. Naravno, tu vezu uspostavljaju educirani i iskusni punkteri. Sav pribor i materijal koji se koriste pri venepunkciji su sterilni i za jednokratnu uporabu. Svaka osoba daruje 450 ml pune krvi. Iz sistema se svaki put izdvajaju dvije epruvete i to jedna za potvrđivanje krvne grupe, a druga za serološka testiranja. </li><br>
                            <li><b>Odmor </b><br> Davatelju nakon darivanja krvi slijedi kratkotrajni odmor uz osvježenje i lagani obrok. </li><br>
                        </ol>
                        <i style="margin-left: 40px;color: #A60202">Sveukupno, darivanje krvi vam može oduzeti oko 30 minuta vremena.</i>
                    </font>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
                    <img src="img/hemoglobindonacija.png" style="width:250px;margin-top: 60px">
                    <img src="img/tlakdonacija.gif" style="width:250px;">
                    <img src="img/doniranjedonacija.jpg" style="width:250px;">
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>













