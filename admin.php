<?php

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");
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
                <a class="nav-link active" id="eventi-tab" data-toggle="tab" href="#eventi" role="tab" aria-controls="eventi" aria-selected="true">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="zahtjevi-tab" data-toggle="tab" href="#zahtjevi" role="tab" aria-controls="zahtjevi" aria-selected="false">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="donacije-tab" data-toggle="tab" href="#donacije" role="tab" aria-controls="donacije" aria-selected="false">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="obavijesti-tab" data-toggle="tab" href="#obavijesti" role="tab" aria-controls="obavijesti" aria-selected="false">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="statistika-tab" data-toggle="tab" href="#statistika" role="tab" aria-controls="statistika" aria-selected="false">Statistika</a>
            </li>
        </ul>
</div>

<div class="col-md-8">
    <div class="tab-content profile-tab" id="myTabContent">
        <div class="tab-pane fade show active" id="eventi" role="tabpanel">
            <script>
            $(function(){
              $("#eventi").load("eventi.php");
            });
            </script>
        </div>

        <div class="tab-pane fade" id="zahtjevi" role="tabpanel" aria-labelledby="zahtjevi-tab">
            <script>
            $(function(){
              $("#zahtjevi").load("zahtjevi.php");
            });
            </script>
        </div>

        <div class="tab-pane fade" id="donacije" role="tabpanel" aria-labelledby="donacije-tab">
            <script>
            $(function(){
              $("#donacije").load("donacije.php");
            });
            </script>
        </div>

        <div class="tab-pane fade" id="obavijesti" role="tabpanel" aria-labelledby="obavijesti-tab">
            <script>
            $(function(){
              $("#obavijesti").load("obavijesti.php");
            });
            </script>
        </div>

        <div class="tab-pane fade" id="statistika" role="tabpanel" aria-labelledby="statistika-tab">
            <script>
            $(function(){
              $("#statistika").load("statistika.php");
            });
            </script>
        </div>
    </div>
</div>';

?>