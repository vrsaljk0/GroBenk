<?php
require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");
$_SESSION["vratime"] = $_SERVER['REQUEST_URI'];

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
            <img src="img/slide1.jpg">
            <div class="carousel-caption">
                <h1>Želite li biti donor krvi?</h1>
                <h3>Postanite dio naše zajednice!</h3>
                <a href="signup.php"><button type="button" class="btn btn-outline-light btn-lg">SIGN UP</button></a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slide3.jpg">
            <div class="carousel-caption">
                <h1>Potrebna vam je krv?</h1>
                <h3>Pošaljite nam e-mail na info@grobenk.hr</h3>
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
            <div style="width:65%;float:left">
                <h1>Doniraj i spasi život!</h1><br>
                <p class="lead" style="font-size: 20px">Pridružite se GroBenk zajednici darivatelja krvi.<br>
                    <ul style="margin-left: 30px">
                        <li style="font-size: 18px">Budite informirani o organiziranim akcijama darivanja krvi u vašoj okolici</li>
                        <li style="font-size: 18px">Podijelite svoja iskustva</li>
                        <li style="font-size: 18px">Povežite se s ostalim donorima</li>
                        <li style="font-size: 18px">Pratite povijest svojih donacija</li>
                    </ul>
                </p>
            </div>
            <div style="width:35%;float:right">
                <img src="img/donatorifrendici.jpg">
            </div>
        </div>
    </div><br><br>

    <!--- Welcome Section -->
    <div>
        <div style="position:absolute;width:26%;float:right;background-color:#e9ecef;padding:30px;border-radius:8px;">
            <h1>Trenutne zalihe krvi</h1><br>
            <p style="font-size: 17px">
                Na slikama prikazano je trenutačno stanje zaliha krvi prema krvnim grupama. <br><br>
                Optimalne količine su između vrijednosti označene kao <font style="color: #A60202">PREMALE</font> i <font style="color: #A60202">PREVELIKE</font> zalihe.
            </p>

        </div>
    </div>


    <div>
        <div id='supplies' onload></div>
        <script>
            $(function(){
                $('#supplies').load('zalihe.php');
            });
        </script>
    </div>
    <div style="width:70%;background-color:#e9ecef;padding:30px;border-radius:8px">
        <p style="font-size: 19px">
            Ako je trenutačna količina Vaše krvne grupe ispod oznake <font style="color: #A60202"> premale </font> zalihe, molimo Vas razmislite o donaciji!
        </p>
    </div>
    <!--- Three Column Section -->

    <!--- Two Column Section -->
    <div class="container-fluid padding" style="padding-top: 50px">
        <div class="row padding">
            <div class="col-lg-6">
                <img src="img/slika1.jpg" class="img-fluid" style="width:80%;border-radius:8px">
            </div>
            <div class="col-lg-6" style="margin-left:-130px;background-color:#e9ecef;border-radius:8px;height:300px;margin-top:16px;padding:30px">
                <h1>Zašto donirati?</h1><br>
                <p><font style="font-size: 18px">Opće je poznato da krv nije moguće proizvesti na umjetan način.
                        Jedini izvor toga lijeka je čovjek - DONOR KRVI, a 1 doza krvi moze spasiti čak 3 života!</font></p>
                <br>
                <a href="indexdonacija.php" class="btn btn-primary">Saznaj više</a>
            </div>
        </div>
    </div><br><br><br>



    <!--- Meet the team -->
    <div style="background-color: #e9ecef;">
    <div class="container-fluid padding">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">Kako doći do nas?</h1>
            </div>
        </div>
    </div>


    <!--- Cards -->
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/riteh.jpg" style="width:460px;height:300px">
                    <div class="card-body">
                        <h4 class="card-title">Glavni ured</h4>
                        <p class="card-text">Vukovarska ul. 58</p>
                        <a href="karta.php?naziv=Glavni ured&adresa=Vukovarska ul.58, Rijeka" class="btn btn-outline-secondary">Pokaži na karti</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/grobnik.jpg" style="width:460px;height:300px">
                    <div class="card-body">
                        <h4 class="card-title">Poslovnica - Grobnik</h4>
                        <p class="card-text">Dražičkih boraca 64</p>
                        <a href="karta.php?naziv=Poslovnica - Grobnik&adresa=Dražičkih boraca 64, Dražice" class="btn btn-outline-secondary">Pokaži na karti</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/benkovac.jpg" style="width:460px;height:300px">
                    <div class="card-body">
                        <h4 class="card-title">Poslovnica - Benkovac</h4>
                        <p class="card-text">Ante Starčević 10</p>
                        <a href="karta.php?naziv=Poslovnica - Benkovac&adresa=Ante Starčević 10, Benkovac" class="btn btn-outline-secondary">Pokaži na karti</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</body>
</html>













