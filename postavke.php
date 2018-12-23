<?php
    require_once "dbconnect.php"; //fancy include just because I can
    require_once "functions.php";
    echo "<link rel='stylesheet' type='text/css' href='style.css'>";

    session_start();
    $OIB = $_GET['OIB_korisnika'];
    //echo $OIB;

    if(isset($_POST['submit'])){
        $OIB_d = $_POST['OIB'];
        $ime = $_POST['ime'];
        $datum_rod= $_POST['datum'];
        $prebivaliste = $_POST['prebivaliste'];
        $postanskibr = $_POST['postanski'];
        $brojmob = $_POST['broj_mobitela'];
        $email = $_POST['mail'];
        $spol = $_POST['spol'];
        $adresa = $_POST['adresa'];
        $lozinka = $_POST['password'];
        $image = $_FILES['image']['name'];
        $target = "donori/".basename($image);


        $query = "UPDATE donor SET OIB_donora = '$OIB_d', ime_prezime_donora = '$ime', datum_rodenja='$datum_rod',
                  prebivaliste = '$prebivaliste', postanski_broj='$postanskibr', broj_mobitela='$brojmob', mail_donora='$email',
                  spol='$spol', adresa_donora='$adresa', password='$lozinka',
                  image='$image'
                  where OIB_donora='$OIB_d'";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database". mysqli_error($conn));

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Podaci uspješno promijenjeni";
        }else{
            $msg = "Došlo je do greške obratite se administratoru";
        }
        echo "$msg";
    }


    $info = "SELECT * FROM donor where OIB_donora = '$OIB'";
    $run = mysqli_query($conn, $info);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);


    echo'<form action="" method="POST" enctype="multipart/form-data">
            <img src="donori/'.$row['image'].'" height="300" width="250"><br><br>
            <input type="file" name="image"><br><br>
            <input type="hidden" name="image_text" value='.$row['ime_prezime_donora'].'>
            OIB donora <input type="text" name="OIB" value='.$row['OIB_donora'].'><br><br>
            Ime i prezime <input type="text" name="ime" value="'.$row['ime_prezime_donora'].'"><br><br>
            Datum rođenja <input type="date" name="datum" value='.$row['datum_rodenja'].'><br><br>
            Prebivaliste <input type="text" name="prebivaliste" value="'.$row['prebivaliste'].'"><br><br>
            Postanski broj <input type="number" name="postanski" value='.$row['postanski_broj'].'><br><br>
            Broj mobitela  <input type="number" name="broj_mobitela" value='.$row['broj_mobitela'].'><br><br>    
            E-mail <input type="text" name="mail" value='.$row['mail_donora'].'><br><br>
            Spol <input type="text" name="spol" value='.$row['spol'].'><br><br>
            Adresa <input type="text" name="adresa" value="'.$row['adresa_donora'].'"><br><br>
            Password <input type="password" name="password" value='.$row['password'].'><br><br>
            <input type="submit" name="submit" value="Promijeni podatke">
          </form>
          <bottom><a href='.$_SESSION["current_page"].'>Nazad na moj profil</a></bottom>';

