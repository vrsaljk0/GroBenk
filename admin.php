<?php

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");
if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");
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
      $('#nav-placeholder').load('adminnavbar.php');
    });
    </script>";

echo '
<div class="admin-content">
        <ul class="nav nav-tabs" id="myTab" >
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Pretraži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donacije.php">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';
?>