<?php
require_once "dbconnect.php";
$lokacija = "Vukovarska ul. 58, 51000, Rijeka";
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

<div id="slides" class="carousel slide" data-ride="carousel" data-interval="2000">
    <ul class="carousel-indicators">
        <li data-target="#slides" data-slide-to="0" class="active"></li>
        <li data-target="#slides" data-slide-to="1" ></li>
        <li data-target="#slides" data-slide-to="2" ></li>
    </ul>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="kontakt/krvv.jpg">
            <div class="carousel-caption">
                <h1>Kontaktirajte nas</h1>
                <h3>Dostupni smo vam 24 sata dnevno, svih 365 dana u godini.</h3>
            </div>
        </div>
        <div class="carousel-item">
            <img src="kontakt/svijet.jpg">
            <div class="carousel-caption">
                <h1>Koristite društvene mreže?</h1>
                <h2> Zapratite nas i prvi saznajte važne obavijesti i novosti!</h2>
                <a href="https://www.instagram.com/_grobenk_/?hl=hr" > <img src="kontakt\instagram.png" style="width:70px;height:70px"></a>
                <a href="https://www.facebook.com/GroBenk-2747386995485580/?modal=admin_todo_tour"> <img src="kontakt\facebook.png" style="width:70px;height:70px"></a>

            </div>
        </div>
        <div class="carousel-item">
            <img src="kontakt/novinari.jpg">
            <div class="carousel-caption">
                <h1>Novinarski i PR upiti</h1>
                <h2>Za sve novinarske i medijske upite i zahtjeve za sponzorstvo pošaljite nam e-mail.</h2>
                <img src="kontakt\gmail.png" style="width:70px;height:70px"> <font size="4">kontakt@grobenk.hr</font>
            </div>
        </div>
    </div>
</div>


<div style="padding:10px;width:100%;background-color:white;height:450px">

    <div style="padding:40px;width:25%;float:left;border-right: 6px solid #DC0E0E;">
    <table>
        <tr>
            <td style="background-color: #A60202" colspan="2"> <h2><font color="white">Glavni ured</font></h2></td>
        </tr>

        <tr>
            <td><img src="kontakt\lokacija.png" width="40"></td>
            <td style="text-align:left;">Vukovarska ul. 58, 51000, Rijeka</td>
        </tr>

        <tr>
            <td><img src="kontakt\gmail.png" width="40"> </td>
            <td style="text-align:left;">kontakt@grobenk.hr</td>
        </tr>

        <tr>
            <td><img src="kontakt\tel.png" width="35" style="margin-left: 5px"> </td>
            <td style="text-align:left;">051 651 444</td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="mapouter" style="margin-left: -100px">
                    <div class="gmap_canvas">
                        <iframe width="300" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=Vukovarska ul. 58, 51000, Rijeka&t=&z=7&ie=UTF8&iwloc=&output=embed&z=13" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://www.crocothemes.net"></a>
                    </div>
                    <style>
                        .mapouter{text-align:left;height:300px;width:300px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:300px;}
                    </style>
                </div>
            </td>
        </tr>
    </table> <br><br>

        <h5>Pronađite nas na društvenim mrežama:</h5>
        <div align="center">
            <a href="https://www.facebook.com/GroBenk-2747386995485580/?modal=admin_todo_tour"> <img src="kontakt\facebook.png" width="40"></a>
            <a href="https://www.instagram.com/_grobenk_/?hl=hr"> <img src="kontakt\instagram.png" width="40"></a>
        </div>

    </div>

    <div style="padding:40px;width:60%;float:left">
        <table style="table-layout: auto;" >
            <tr>
                <td style="background-color: #A60202" colspan="4"> <h2><font color="white">Poslovnice</font></h2></td>
            </tr>
        <tr>
            <td colspan="2"><h2>Grobnik</h2> </td>
            <td colspan="2"><h2>Benkovac</h2> </td>
        </tr>

        <tr>   
            <td ><img src="kontakt\lokacija.png" width="40"></td>
            <td style="text-align:left;">Dražičkih boraca 64</td>
            <td ><img src="kontakt\lokacija.png" width="40"></td>
            <td style="text-align:left;">Ante Starčević 10</td>
        </tr>
        <tr>
            <td><img src="kontakt\gmail.png" width="40"> </td>
            <td style="text-align:left;">grobnik@grobenk.hr</td>
            <td><img src="kontakt\gmail.png" width="40"> </td>
            <td style="text-align:left;">benkovac@grobenk.hr</td>
        </tr>
        <tr>
            <td><img src="kontakt\tel.png" width="35" style="margin-left: 5px"> </td>
            <td style="text-align:left;">051 296 992</td>
            <td><img src="kontakt\tel.png" width="35" style="margin-left: 5px"> </td>
            <td style="text-align:left;">023 229 923</td>
        </tr>

        <tr>
            <td colspan="2">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="500" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=Dražičkih boraca 64&t=&z=7&ie=UTF8&iwloc=&output=embed&z=13" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://www.crocothemes.net"></a>
                    </div>
                    <style>
                        .mapouter{text-align:center;height:300px;width:500px;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:500px;}
                    </style>
                </div>
            </td>

            <td colspan="2">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="500" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=Ante Starčević 10, benkovac&t=&z=7&ie=UTF8&iwloc=&output=embed&z=13" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://www.crocothemes.net"></a>
                    </div>
                    <style>
                        .mapouter{text-align:center;height:300px;width:500px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:500px;}
                    </style>
                </div>
            </td>

        </tr>
        </table>
    </div>

</div>


</body>





</html>













