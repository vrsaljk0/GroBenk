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


    $date = date("Ymd");
    $idbolnica = $_SESSION['id'];


    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
    $naziv_bolnice = $row['naziv_bolnice'];
    if(isset($_POST['posalji_zahtjev'])){
        $kolicina = $_POST['kolicina'];
        $krvna_grupa = $_POST['grupa'];
        $sql = "INSERT INTO zahtjev (id_bolnica, kolicina_krvi_zaht, krvna_grupa_zaht, datum_zahtjeva, odobreno) values ('$idbolnica', '$kolicina', '$krvna_grupa', '$date', '0')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }

    echo'
          <html>
                 <head><title>Profil bolnice</title></head>
                 <body>
                     <div id="info">
                        <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="200" height="200"><br><br>     
                     </div>
                        <a href="posalji_zahtjev.php" >Pošalji zahtjev&nbsp;</a><br><br>
                        <a href="otkazi_zahtjev.php" >Otkazi zahtjev&nbsp;</a><br><br>
                        <a href="bolnicka_statistika.php">&nbsp;Statistika&nbsp;</a><br><br>
                        <a href="bolnicke_postavke.php">&nbsp;Postavke&nbsp;</a><br><br>
                        <a href="forum.php">&nbsp;Forum&nbsp;</a><br><br>
                        <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>                          
                      <div id="posalji_zahtjev" align="center">
                        Pošalji novi zahtjev
                        <form action="" method="POST">
                            Kolicina potrebne krvi <input type="number" name="kolicina" step="0.01"><br><br>
                            Krvna grupa <input type="text" name="grupa"><br><br>
                            <input type="submit" name="posalji_zahtjev" value="Posalji zahtjev">
                      </form>'

?>