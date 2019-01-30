    <script  src="jquery-3.3.1.min.js">
        function ChangeButton(){
            var str = document.getElementById("button").innerHTML
            if(str == "Follow"){
                document.getElementById("button").innerHTML = "Unfollow";
            }
            else document.getElementById("button").innerHTML = "Follow"
        }
    </script>
<?php

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
    </head>';

    require_once "dbconnect.php";
    require_once "functions.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!isset($_SESSION['donor_loggedin'])) header("Location:denied_permission.php");

    $username = $_GET['username'];
    $OIB_donora =  $_SESSION['mojOIB'];

    $info = "SELECT *from donor WHERE username='$username'";
    $run = mysqli_query($conn, $info);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);
    $OIB_korisnika = $row['OIB_donora'];

    $query = "SELECT * FROM following WHERE  donor_OIB_donora = $OIB_donora and OIB_prijatelja = $OIB_korisnika";
    $run = mysqli_query($conn, $query);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);
    if(!$row) $str = "Follow";
    else $str = "Unfollow";
    /**
     * pri samom loadu stranicu provjeram follujem li tog korisnika već ili ne -> što će mi pisati na bottunu
     */
    echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('donornavbar.php');
    });
    </script>";

    if(isset($_POST['follow'])){
        /**
         * ako je onaj row od gore prazan znači klik na bottun mi treba followati tog donora
         * kod mene se doda OIB_korisnika u following tablicu a kod tog korisnika u followers tablicu
         */
        if(!$row) {
            //KOrisnik ide zapratiti prijatelj
            $query = "INSERT INTO following values ('$OIB_donora', '$OIB_korisnika')";
            $run = mysqli_query($conn, $query);
            if ($run) {
                echo "Sad pratite ovog korisnika";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
            //sad i taj prijatelj dobije novu vrijednost u svoj tablici followersa
            $query = "INSERT INTO followers values ('$OIB_korisnika', '$OIB_donora')";
            $run = mysqli_query($conn, $query);
        }
        else{ //ako već postoji znači da ga želim izbrisati

            $query = "DELETE FROM following WHERE  donor_OIB_donora = $OIB_donora and OIB_prijatelja = $OIB_korisnika";
            $run = mysqli_query($conn, $query);
            if ($run) {
                echo "Više ne pratite ovog korisnika";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
            //sad moram i kod drugog iz tablice izbrisati logično
            $query = "DELETE FROM followers WHERE  donor_OIB_donora = $OIB_korisnika and OIB_prijatelja = $OIB_donora";
            $run = mysqli_query($conn, $query);
        }
        $url = 'publicprofile.php?username='.urlencode($username);
        header("Location:$url");
    }

    /**
     * Prikazujem podatke o tom donoru
     */


    $query ="select *from donor where OIB_donora = '$OIB_korisnika'";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
   
    $star = '<i style="color:goldenrod;" class="fas fa-star"></i>';
    if(isset($_POST['posalji_poruku'])){
        $datum = date('Y-m-d H:i:s');
        $poruka = stripslashes(mysqli_real_escape_string($conn,$_POST['poruka']));

        if(strlen($poruka)>0) {
            $sql = "INSERT INTO obavijesti (OIBdonora, ID_posiljatelja, tekst_obav, datum_obav, procitano) values('$OIB_korisnika', '$OIB_donora', '$poruka', '$datum', '0')";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
            $url = 'publicprofile.php?username=' . urlencode($username);
            header("Location:$url");
        }
    }
    echo '
    <div class="profil-img">
        <img src="donori/'.$row['image'].'">
        <div class="profil-info">
            <div class="profil-title">';
                if($row['br_donacija'] <= 20) echo '<h1>'.$row['ime_prezime_donora'].''.$star.'</h1>';
                else if($row['br_donacija'] <= 30) echo '<h1>'.$row['ime_prezime_donora'].''.$star.''.$star.'</h1>';
                else if($row['br_donacija'] <= 50) echo '<h1>'.$row['ime_prezime_donora'].''.$star.''.$star.''.$star.'</h1>';
                echo '
                <form action="" method="POST">
                    <button class="submitsearch" type="submit" name="follow" id="button" onclick="ChangeButton()">'.$str.'</button>';
                    if($str == 'Unfollow'){
                        echo'<br><input type="text" style="margin-left:0;" name="poruka" placeholder="Pošalji kratku poruku"> 
                        <input type="submit" style="margin-left:0;" name="posalji_poruku" value="Pošalji">';
                    }
                echo'</form>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Ime i prezime:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['ime_prezime_donora'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Krvna grupa:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['krvna_grupa_don'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Korisnicko ime:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['username'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>E-mail:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['mail_donora'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Broj donacija:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['br_donacija'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Broj telefona:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['broj_mobitela'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Datum rođenja:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['datum_rodenja'].'</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Prebivalište:</label>
                </div>
                <div class="col-md-6">
                    <p class="info">'.$row['prebivaliste'].'</p>
                </div>
            </div>
          ';

    echo '
        </div>
    </div>
    ';
?>

