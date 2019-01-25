﻿<script>
function OdjaviMe(){
window.location.replace('donor.php');
}
</script>

<?php

require_once "dbconnect.php"; //fancy include just because I can
require_once "functions.php";
session_start();
$OIB = $_SESSION["mojOIB"];
if (!isset($_SESSION['donor_loggedin'])) header("Location:denied_permission.php");
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
    <base target="_self">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" href="/images/cp_ico.png">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
</head>';





if(isset($_POST['submit'])){
    $ime = $_POST['ime'];
    $krvna_grupa = $_POST['krvna_grupa'];
    $OIB_d = $_POST['OIB'];
    $username = $_POST['username'];
    $email = $_POST['mail'];
    $brojmob = $_POST['broj_mobitela'];
    $datum_rod= $_POST['datum'];
    $prebivaliste = $_POST['prebivaliste'];
    $postanskibr = $_POST['postanski'];
    $adresa = $_POST['adresa'];
    $trenutna = $_POST['trenutna'];
    $nova1 = $_POST['nova1'];
    $nova2 = $_POST['nova2'];
    $password = $_POST['password'];
    $image = $_FILES['image']['name'];
    $target = "donori/".basename($image);
    $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
    $flag = 0;
    if($filename !="") {
        $query = "UPDATE donor SET image = '$image'where OIB_donora='$OIB_d'";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database" . mysqli_error($conn));

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Podaci uspješno promijenjeni";
        } else {
            $msg = "Došlo je do greške obratite se administratoru";
        }
    }
    else {
        $query = "UPDATE donor SET OIB_donora = '$OIB_d', ime_prezime_donora = '$ime', datum_rodenja='$datum_rod',
                      prebivaliste = '$prebivaliste', postanski_broj='$postanskibr', broj_mobitela='$brojmob', mail_donora='$email',
                      adresa_donora='$adresa', krvna_grupa_don = '$krvna_grupa', username = '$username'
                      where OIB_donora='$OIB_d'";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database" . mysqli_error($conn));
    }

    if ($trenutna === $password and $nova1 === $nova2 and $nova1 != '' && $nova2!='') {
        $update_query = "update donor set password = '$nova1' where OIB_donora = '$OIB_d'";
        $update_run = mysqli_query($conn, $update_query);
        $flag = 1;

    }
    if($flag)$url = 'index.html';
    else $url = 'donor.php';
    header("Location: $url");
}


$info = "SELECT * FROM donor where OIB_donora = '$OIB'";
$run = mysqli_query($conn, $info);
$result = $run or die("Failed to query database");
$row = mysqli_fetch_array($result);
$OIB = $row['OIB_donora'];
echo '
<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
      <h1>Uredi profil</h1>
      <hr>
        <div class="row">
            <div class="col-md-3">
              <div class="text-center">
                <img src="donori/'.$row['image'].'" class="avatar img-thumbnail" alt="avatar">
                <h6>Promijeni sliku profila</h6>
                <input type="file" name = "image" class="form-control">
                <input type="hidden" name="image_text" value="'.$row['ime_prezime_donora'].'">
              </div>
            </div>

            <div class="col-md-9 personal-info">
            <h3>Osobni podaci</h3>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Ime i prezime:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control" name="ime" value="'.$row['ime_prezime_donora'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Krvna grupa:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control"  name="krvna_grupa" value="'.$row['krvna_grupa_don'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">OIB:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="OIB" value='.$row['OIB_donora'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Korisničko ime:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="username" value="'.$row['username'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">E-mail:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="mail" value='.$row['mail_donora'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Broj telefona:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="number" name="broj_mobitela" value='.$row['broj_mobitela'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Datum rođenja:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="date" name="datum" value='.$row['datum_rodenja'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Prebivalište:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="prebivaliste" value="'.$row['prebivaliste'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Poštanski broj:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="number" name="postanski" value='.$row['postanski_broj'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Adresa:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="adresa" value="'.$row['adresa_donora'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Lozinka:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="trenutna" value='.$row['password'].'>
                     <input type="hidden" name="password" value='.$row['password'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Nova lozinka:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="nova1">
                  </div>
                </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Potvrdite novu lozinku:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="nova2">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label"></label>
                  <div class="col-md-8">
                    <input type="submit" style="background: #DC0E0E; border: 1px solid #A60202;" class="btn btn-primary" name="submit" value="Promijeni podatke">
                    <span></span>
                    <bottom><br><br><a href="donor.php?OIB='.$OIB.'">Nazad na moj profil</a></bottom>
                  </div>
                </div>
            </div>
        </div>
    </form>
</div>
<hr>
';
?>


