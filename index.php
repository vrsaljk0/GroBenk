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
                <button type="button" class="btn btn-outline-light btn-lg" onclick="document.getElementById('id01').style.display='block'"">SIGN UP</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slide2.jpg">
            <div class="carousel-caption">
                <h1>Trenutne zalihe krvi</h1>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slide3.jpg">
            <div class="carousel-caption">
                <h1>Potrebna vam je krv?</h1>
                <button type="button" class="btn btn-outline-light btn-lg">Pošalji zahtjev</button>
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
                <p class="lead">BLablablalibla bla nesto o krvi i donorima and shit</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
                <a href="#"><button type="button" class="btn btn-outline-secondary btn-lg">Možda i tu sign in</button></a>
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

    <!--PopUp Sign in Form
    <div id="modal-wrapper" class="modal">
        <form class="modal-content animate" action="donor.php" method="GET">

            <div class="imgcontainer">
                <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close Popup">&times;</span>
                <br><h1>Sign in</h1>
            </div>

            <div class="container">
                <div style="padding-top: 40%;" class="textboxlogin">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" placeholder="Username" name="username" value="" required="">
                </div>

                <div class="textboxlogin">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" value="" required="">
                </div>
                <br>
                <input class="btnlogin" type="submit" name="submit" value="Prijavi se"><br>
                <br><br>
                <h6>Nemate račun?</h6> <a href="signup.php">Sign up</a>
            </div>

        </form>
    </div>

    <script>
    // Get the modal
    var modal = document.getElementById('modal-wrapper');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    </script>-->

    <!--- Two Column Section -->


    <!--- Connect -->


    <!--- Footer -->
    <!--<footer>
    <div class="container-fluid padding">
    <div class="row text-center">
        <div class="col-md-4">
            <img src="img/logo_.png">
            <hr class="light">
            <h5>&</h5>
        </div>
    </div>
    </div>
    </footer>
    -->
</div>
</body>
</html>













