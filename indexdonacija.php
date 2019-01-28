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
                    DARIVANJEM KRVI:
                    <ul>
                        <li> vršimo kontrolu vlastitog zdravlja te pomažemo napretku tuđeg</li>
                        <li> može se započeti i prestati u svako doba između 18 i 65 (70) godina života</li>
                        <li> ne nastaju nikakve štetne tjelesne promjene ili posljedice po organizam te ne šteti zdravlju ako se provedu svi propisani postupci pri odabiru darivatelja krvi</li>
                    </ul>
                    Svaka zdrava osoba pripadajuće dobi može bez opasnosti za svoje zdravlje darovati krv, 3 do 4 puta tijekom jedne godine.
                    Zdrav organizam darivatelja krvi vrlo brzo u potpunosti nadoknađuje količinu i sve sastavne dijelove darovane krvi:
                    već unutar 24 sata organizam nadoknadi tekući dio krvi - plazmu i njene sastojke, broj trombocita i leukocita.
                    Eritrociti se nadoknade unutar 4 do 6 tjedana.
                </p>
                </font>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
                <img src="img/zastodonirati.png" style="width:270px;height;270px;margin-left: -50px">
            </div>

        </div>
    </div>

    <!--- Welcome Section -->
    <div class="container-fluid padding">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">Doniraj s razlogom.</h1>
                <hr>
            </div>
            <div class="col-12">
                <p class="lead">Dobrodosli na nasu donorsku stranicu yoo supp ma man</p>
            </div>
        </div>
    </div>

    <!--- Three Column Section -->
    <div class="container-fluid padding">
        <div class="row text-center padding">
            <div class="col-xs-12 col-sm-16 col-md-4">
                <h3>A+</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>A-</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>B+</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>B-</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>0+</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>0-</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>AB+</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <h3>AB-</h3>
            </div>
        </div>
    </div>

    <!--- Two Column Section -->
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-lg-6">
                <h2>Lldnlnf</h2>
                <p>slgnlsfgaieufnsdbvsdsuososogsougn</p>
                <p>subgiwulebviuwvjdufrhuodčshuo</p>
                <p>sdjfbisbsuihfuosdfhosuvsoubvousbvosufuoshfuosdhvuodbvouabvuosbvuosfbvuosf</p>
                <br>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>
            <div class="col-lg-6">
                <img src="img/slika1.jpg" class="img-fluid">
            </div>
        </div>
    </div>

    <!--- Fixed background -->


    <!--- Emoji Section -->


    <!--- Meet the team -->
    <div class="container-fluid padding">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">Meet the hospitalsss</h1>
            </div>
        </div>
    </div>


    <!--- Cards -->
    <div class="container-fluid padding">
        <div class="row padding">
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/hospital.jpg">
                    <div class="card-body">
                        <h4 class="card-title">KBC Rijeka</h4>
                        <p class="card-text">PIifsibijfb</p>
                        <a href="#" class="btn btn-outline-secondary">See Location</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/hospital.jpg">
                    <div class="card-body">
                        <h4 class="card-title">KBC Sušak</h4>
                        <p class="card-text">PIifsibijfb</p>
                        <a href="#" class="btn btn-outline-secondary">See Location</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top" src="img/hospital.jpg">
                    <div class="card-body">
                        <h4 class="card-title">KBC Zadar</h4>
                        <p class="card-text">PIifsibijfb</p>
                        <a href="#" class="btn btn-outline-secondary">See Location</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>













