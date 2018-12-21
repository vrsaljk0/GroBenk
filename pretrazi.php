<?php
require_once "dbconnect.php";
session_start();

$pretraga = $_GET['trazilica'];

$query = "SELECT ime_prezime_donora, OIB_donora from donor WHERE (lower(ime_prezime_donora) LIKE '$pretraga%')";
$run = mysqli_query($conn, $query);
$result = $run or die ("Failed to query database". mysql_error());

$flag = 0;
while($row = mysqli_fetch_array($result)){
    //echo '<a href="publicprofile.php">'.$row['ime_prezime_donora'].'</a><br>';
    echo '<a href="publicprofile.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">'.$row['ime_prezime_donora'].'</a><br>';

}

if($run){
    echo "Uspjesna pretraga";
}
else {
    echo "error:" .mysqli_error($conn);
}
?>