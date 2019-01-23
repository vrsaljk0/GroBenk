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

    if (!$_SESSION['bolnica_loggedin']) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];

    echo'
        <html>
             <head><title>Profil bolnice</title></head>
             <body>
                 <div id="info">
                    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="200" height="200"><br><br>
                 </div>
                 
                 <div id="linkovi">
                    <a href="posalji_zahtjev.php" >Pošalji zahtjev&nbsp;</a><br><br>
                    <a href="otkazi_zahtjev.php" >Otkazi zahtjev&nbsp;</a><br><br>
                    <a href="bolnicka_statistika.php">&nbsp;Statistika&nbsp;</a><br><br>
                    <a href="bolnicke_postavke.php">&nbsp;Postavke&nbsp;</a><br><br>
                    <a href="forum.php">&nbsp;Forum&nbsp;</a><br><br>
                    <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>                          
                 </div>
             </body>';
?>