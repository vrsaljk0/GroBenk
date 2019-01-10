<?php
require_once "dbconnect.php";
session_start();
$pretraga = $_GET['trazilica'];
$OIB = $_SESSION['mojOIB'];
//echo $_SESSION['mojOIB'];
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
/**
 * Pretraga donora
 */
$donor = 0;

$query = "SELECT *from donor WHERE (prebivaliste LIKE '%$pretraga%') OR (ime_prezime_donora LIKE '%$pretraga%') AND OIB_donora!='$OIB'";
$run = mysqli_query($conn, $query);
$result = $run or die ("Failed to query database". mysqli_error($conn));
echo '<h4 class="pretraga-title">Rezultati pretrage:</h4>';
echo '<div class="pretraga">';
while($row = mysqli_fetch_array($result)){
    //echo '<a href="publicprofile.php">'.$row['ime_prezime_donora'].'</a><br>';
    echo '
            <div class="pretraga-info">
                <div class="pretraga-img">
                    <img src="donori/'.$row['image'].'">
                </div>
                <a href="publicprofile.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">'.$row['ime_prezime_donora'].'</a><br>
            </div><br><br>
        ';
    $donor = 1;
}
echo '</div>';
/**
 * Pretraga bolnica
 */
$bolnica = 0;

$query = "SELECT *from bolnica WHERE (grad LIKE '%$pretraga%') OR (naziv_bolnice LIKE '%$pretraga%')";
$run = mysqli_query($conn, $query);
$result = $run or die ("Failed to query database". mysqli_error($conn));
echo '<div class="pretraga">';
while($row = mysqli_fetch_array($result)){
    //echo '<a href="publicprofile.php">'.$row['ime_prezime_donora'].'</a><br>';
    echo '
            <div class="pretraga-info">
                <div class="pretraga-img">
                  <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
                </div>
               <a href="publicbolnica.php?id_bolnice='.urlencode($row['idbolnica']).'">'.$row['naziv_bolnice'].'</a>
            </div><br><br>
        ';
    $bolnica = 1;
}
echo '</div>';
if(!$bolnica && !$donor) echo'Nažalost nema rezultata pretrage.';
?>