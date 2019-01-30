<?php

  require_once ("dbconnect.php");
  session_start();
  mysqli_set_charset($conn,"utf8");

  /** SESSION TIMEOUT */
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
  }
  $_SESSION['LAST_ACTIVITY'] = time();
  $_SESSION['vratime'] = $_SERVER['REQUEST_URI'];
  if (!isset($_SESSION['donor_loggedin'])) header("Location:denied_permission.php");

  $id_bolnice = $_GET['id_bolnice'];
  $OIB = $_SESSION['mojOIB'];

  $query ="select * from donor where OIB_donora = '$OIB'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row_donor = mysqli_fetch_assoc($result);
  $ime = $row_donor['ime_prezime_donora'];
  $username = $row_donor['username'];
  $date = date('Y-m-d');

  $query ="select * from bolnica where idbolnica = '$id_bolnice'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);

  if(isset($_POST['komentar'])){
    $tekst = $_POST['tekst'];
    if($tekst!=''){
      $sql = "INSERT INTO komentari values ('$username', '$ime', '$id_bolnice', '$tekst', '$date')";
      $run = mysqli_query($conn, $sql);
      $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
  }
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

echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('donornavbar.php');
    });
    </script>";

echo'
<div class="profil-img">
  <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
  <div class="profil-info">
    <div class="profil-title">
    <h1>'.$row['naziv_bolnice'].'<a href="karta.php?naziv='.$row['naziv_bolnice'].'&adresa='.$row['adresa_bolnice'].'"><img src="kontakt\lokacija.png" style="margin:0; width:50px;height:50px"></a></h1>
    </div>
    <div class="profil-content">
          <ul class="nav nav-tabs" id="myTab" >
              <li class="nav-item">
                  <a class="nav-link active" href="publicbolnica.php?id_bolnice='.urlencode($id_bolnice).'">Općenito</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="publicforum.php?id_bolnice='.urlencode($id_bolnice).'">Forum</a>
              </li>
          </ul>
      </div>
      <div class="col-md-8">
          <div class="tab-content profile-tab" id="myTabContent">
              <div class="row">
                  <div class="col-md-6">
                      <label>Naziv bolnice:</label>
                  </div>
                  <div class="col-md-6">
                      <p class="info">'.$row['naziv_bolnice'].'</p>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <label>Adresa:</label>
                  </div>
                  <div class="col-md-6">
                      <p class="info">'.$row['adresa_bolnice'].'</p>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <label>Grad:</label>
                  </div>
                  <div class="col-md-6">
                      <p class="info">'.$row['grad'].'</p>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <label>Poštanski broj:</label>
                  </div>
                  <div class="col-md-6">
                      <p class="info">'.$row['postanski_broj'].'</p>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>';
?>

