<?php
require_once "dbconnect.php"; //fancy include just because I can

    $OIB = $_GET['OIB'];
    $password = $_GET['password'];

    //da se ne ubaci u bazu
    $OIB = stripcslashes($OIB);
    $password = stripcslashes($password);
    $OIB = mysqli_real_escape_string($conn,$OIB);
    $password = mysqli_real_escape_string ($conn, $password);


    $query ="select *from donor where OIB_donora = '$OIB' and password = '$password'";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysql_error());

    $row = mysqli_fetch_array($result);
    if ($row['OIB_donora'] == $OIB && $row['password'] == $password && ("" !== $OIB || "" !== $password) ) {
        echo "Dobrodošao ".$row['ime_prezime_donora']." !";
    } else {
        echo "Pogresna lozinka ili OIB!";
        exit;
    }
?>