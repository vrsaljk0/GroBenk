<?php
require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");


?>

<!DOCTYPE html>
<html lang="en">
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
    <link href="popupstyle.css" rel="stylesheet">
    <link href="adminstyle.css" rel="stylesheet">
</head>
<body>
<!-- Navigation -->
<div id="nav-placeholder">
</div>

<script>
    $(function(){
        $("#nav-placeholder").load("navbar.php");
    });
</script>

    <?php
        $naziv = $_GET['naziv'];
        $adresa = $_GET['adresa'];

        if (isset($_POST['submit'])) {
            $url = $_SESSION['vratime'];
            header("Location:$url");
        }

	echo '<br><br><br>
    <div style="width: 100%;background-color: #A60202;height:100px">
        <font style="color: white;font-size:60px;margin-left: 60px">'.$naziv.'</font>
    </div><br>
    <div>
        <div style="width: 30%;float:left;padding:60px">
            <h4>'.$adresa.'</h4><br>
            <form action="" method="POST">
                <input type="submit" name="submit" class="zbtn" value="Vrati se">
            </form>
        </div>
        
        <div class="mapouter" style="width:68%;float:right;background-color: #A60202;padding:5px;height:510px;margin-top: -5px">
        <div class="gmap_canvas">
            <iframe width="1000" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q='.$adresa.'&t=&z=7&ie=UTF8&iwloc=&output=embed&z=13" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            <a href="https://www.crocothemes.net"></a>
        </div>
        <style>
            .mapouter{text-align:right;height:500px;width:1000px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1000px;}
        </style>
        </div>
    </div>';
?>
