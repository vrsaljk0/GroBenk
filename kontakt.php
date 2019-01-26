<?php
require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");

/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:index.php");
}

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
    <link href="kontakt.css" rel="stylesheet">
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

<div class="" width="100%">
    <img src="kontakt/krvv.jpg" width="100%" height="400px">
</div>


<div style="border:1px solid black;padding:10px;width:85%;margin:0 auto;" >
    <h2>IN PROGRESS</h2>
    <a href="https://www.facebook.com/GroBenk-2747386995485580/?modal=admin_todo_tour"> <img src="kontakt\facebook.png" width="40"><br><br> </a>
    <img src="kontakt\gmail.png" width="40"> kontakt@grobenk.hr<br><br>
    <a href="https://www.instagram.com/_grobenk_/?hl=hr"> <img src="kontakt\instagram.png" width="40"><br><br> </a>
    <img src="kontakt\telefon.png" width="40"> 051234456<br><br>
    <img src="kontakt\lokacija.png" width="40">tu ce pisat lokacija, klikom na ikonicu ode na onu fancccy mapu?<br><br>
blabla
    <br><br><br><br><br><br><br><br>
</div>

<br>
<br>
<br>


    <div class="container-fluid padding">
        <div class="row welcome text-center">
            <div class="col-12">
                <h1 class="display-4">Meet the hospitalsss</h1>
            </div>
        </div>
    </div>



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













