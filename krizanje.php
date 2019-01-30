<?php
/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 4.1.2019.
 * Time: 19:19
 */

require_once "dbconnect.php";
require_once "functions.php";
mysqli_set_charset($conn,"utf8");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($conn,$username);
$password = mysqli_real_escape_string ($conn, $password);

/*
 * 1. Provjeravam radi li se o donoru
 */

$query ="select *from donor where username = '$username' and password = '$password'";
$run = mysqli_query($conn, $query);
$result = $run or die ("Failed to query database". mysqli_error($conn));
$flag=0;
$row = mysqli_fetch_array($result);

if ($row['username'] == $username && $row['password'] == $password && ("" !== $username || "" !== $password) ) {
    $url = 'donor.php';
    $flag=1;
    $_SESSION['donor_loggedin'] = true;
    $_SESSION['id'] = $row['OIB_donora'];
    unset($_SESSION['admin_loggedin']);
    unset($_SESSION['bolnica_loggedin']);
}
else{
    $info ="select *from admin where username = '$username' and password = '$password'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));
    $row = mysqli_fetch_array($result);

    if ($row['username'] == $username && $row['password'] == $password && ("" !== $username || "" !== $password) ) {
        $url = "admin.php";
        $flag = 1;
        $_SESSION['admin_loggedin'] = true;
        unset($_SESSION['donor_loggedin']);
        unset($_SESSION['bolnica_loggedin']);
    }
    else{
        $info ="select *from bolnica where  idbolnica = '$username' and password = '$password'";
        $run = mysqli_query($conn, $info);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
        $row = mysqli_fetch_array($result);

        if ($row['idbolnica'] == $username && $row['password'] == $password && ("" !== $username || "" !== $password) ) {
            $url = 'bolnica.php';
            $flag = 1;
            $_SESSION['bolnica_loggedin'] = true;
            $_SESSION['id'] = $row['idbolnica'];
            $_SESSION['naziv_bolnice'] = $row['naziv_bolnice'];
            unset($_SESSION['donor_loggedin']);
            unset($_SESSION['admin_loggedin']);
        }
    }
}
if($flag) header("Location:$url");
else {
    echo '
    <link href="style.css" rel="stylesheet">
    <link href="popupstyle.css" rel="stylesheet">
    <link href="adminstyle.css" rel="stylesheet">
    <div style="background-color: #9F0A00; color:white;width:100%; height:20%;margin-top:100px;vertical-align: center;margin-left: 50px;radius:8px">
    <br><br><br>
        <h1 style="margin-left:100px;margin-top:25px">Pogresna lozinka ili username :-(</h1>
    </div>
    <a href="index.php" style="margin-left:48px;"><input type="submit" name="submit" class="zbtn" value="Vrati se" style="width:200px;height:60px"></a>';
}
?>
