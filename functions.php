<?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "grobenk";
$conn = mysqli_connect($servername, $username, $password, $database);

function count_following($OIB){
    $count_following = "SELECT COUNT(donor_OIB_donora) from following where donor_OIB_donora = $OIB";
    $run =  mysqli_query($GLOBALS['conn'], $count_following);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);
    echo 'Following('.$row[0].') ';
}
function count_followers($OIB){
    $count_followers = "SELECT COUNT(donor_OIB_donora) from followers where donor_OIB_donora = $OIB";
    $run =  mysqli_query($GLOBALS['conn'], $count_followers);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);
    echo 'Followers('.$row[0].') <br>';
}

?>