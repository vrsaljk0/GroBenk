<?php
    require_once "dbconnect.php";
    session_start();
    $pretraga = $_GET['trazilica'];
    //echo $_SESSION['mojOIB'];

    /**
     * Pretraga donora
    */
    $donor = 0;
    echo'<p><b>Donori:</b></p>';
    $query = "SELECT *from donor WHERE (prebivaliste LIKE '%$pretraga%') OR (ime_prezime_donora LIKE '%$pretraga%')";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    while($row = mysqli_fetch_array($result)){
        //echo '<a href="publicprofile.php">'.$row['ime_prezime_donora'].'</a><br>';
        echo '<a href="publicprofile.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">'.$row['ime_prezime_donora'].'</a><br>';
        $donor = 1;
    }
    /**
     * Pretraga bolnica
     */
    $bolnica = 0;
    echo '<p><b>Bolnice:</b></p>';
    $query = "SELECT *from bolnica WHERE (grad LIKE '%$pretraga%') OR (naziv_bolnice LIKE '%$pretraga%')";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    while($row = mysqli_fetch_array($result)){
    //echo '<a href="publicprofile.php">'.$row['ime_prezime_donora'].'</a><br>';
        echo '<a href="publicbolnica.php?id_bolnice='.urlencode($row['idbolnica']).'">'.$row['naziv_bolnice'].'</a><br>';
        $bolnica = 1;
    }
    if(!$bolnica && !$donor) echo'Nazalost nema rezultata pretrage.';
?>