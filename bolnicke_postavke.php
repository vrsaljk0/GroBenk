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

    if (isset($_POST['updejtaj'])) {
        $naziv_bolnice = $_POST['naziv_bolnice'];
        $grad = $_POST['grad'];
        $adresa_bolnice = $_POST['adresa_bolnice'];
        $postanski_broj = $_POST['postanski_broj'];

        $update_query = "update bolnica set naziv_bolnice = '$naziv_bolnice',grad ='$grad', adresa_bolnice = '$adresa_bolnice',
                            postanski_broj = '$postanski_broj' where idbolnica = '$idbolnica'";
        $update_run = mysqli_query($conn, $update_query);
    }
    if (isset($_POST['promijeni_lozinku'])){
        $trenutna = $_POST['trenutna'];
        $nova1 = $_POST['nova1'];
        $nova2 = $_POST['nova2'];
        if ($trenutna === $password and $nova1 === $nova2 and !is_null($nova1)) {
            $update_query = "update bolnica set password = '$nova1' where idbolnica = '$idbolnica'";
            $update_run = mysqli_query($conn, $update_query);
            echo '<script type="text/javascript">',
            'Ulogirajme();',
            '</script>'
            ;
        }
    }


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
             
                  <div id="postavke" align="middle">
                    <b>Uredi postavke:</b>';

                    $sql = "select * from bolnica where idbolnica = '$idbolnica'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $password = $row['password'];

                    echo'
                    <form action="" method="POST">
                        Naziv bolnice: <input type="text" name="naziv_bolnice" value="' . $row['naziv_bolnice'] . '"> <br><br>
                        Grad: <input type="text" name="grad" value="' . $row['grad'] . '"><br><br>
                        Adresa: <input type="text" name="adresa_bolnice" value="' . $row['adresa_bolnice'] . '"><br><br>
                        Poštanski broj: <input type="number" name="postanski_broj" value="' . $row['postanski_broj'] . '"><br><br><br>
                        <input type="submit" name="updejtaj" value="Spremi promjene"><br></br>
                    </form>
                    <b>Promjeni lozinku:</b><br>
                    <form action="" method="POST">
                        Trenutna lozinka: <input type="password" name="trenutna" "><br><br> 
                        Nova lozinka:<input type="password" name="nova1" "><br><br> 
                        Ponovni upis nove lozinke:<input type="password" name="nova2" "><br><br> 
                        <input type="submit" name="promijeni_lozinku" value="Promijeni lozinku">
                    </form>';

                  echo'</div>     
             </body>';

?>