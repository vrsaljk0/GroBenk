<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<script>
    function Ulogirajme(){
        window.location.replace('boln_login.php');
    }
</script>

<?php
    require_once "dbconnect.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!isset($_SESSION['bolnica_loggedin'])) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];

    echo '
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
        <link href="donorstyle.css" rel="stylesheet">
        <link href="bolnicastyle.css" rel="stylesheet">
    </head>';

    echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('bolnicanavbar.php');
    });
    </script>";

echo' 
 <div class="profil-img">
    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
    <div class="profil-info">
        <div class="profil-content">
            <ul class="nav nav-tabs" id="myTab" >
                <li class="nav-item">
                    <a class="nav-link active" href="bolnicaopcenito.php">Općenito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum.php">Forum</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="posalji_zahtjev.php">Pošalji zahtjev</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="otkazi_zahtjev.php">Otkaži zahtjev</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bolnicka_statistika.php">Statistika</a>
                </li>
            </ul>
        </div>
    </div>
</div>';
?>