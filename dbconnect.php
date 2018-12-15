<?php
/*podaci o serveru i tvoj username
imamo dva načina za stvoriti konekciju
mysqli (object-oriented) sa new
mysli (procedural)
više mi se sviđa procedural tako da fak you iva
*/
$servername = "localhost";
$username = "root";
$password = "";
$database = "grobenk";

//stvaram konekciju
$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    die("Connection failed: " .mysqli_connect_error());
}
/*
else{
    echo ("Faking konektovani");
}
*/
?>