<?php
    require_once ("dbconnect.php");
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

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
    <link href="adminstyle.css" rel="stylesheet">
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
                <a class="nav-link" href="eventi.php?keyword=&trazi=Traži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donacije.php?keyword=&trazi=Traži">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';

    $id = $_GET['idEvent'];
    $sql = "SELECT * from lokacija where id_lokacije = '$id'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($run);
echo '
<div style="border-right: none;" class="profil-img">
    <img src="lokacije/'.$row['image'].'">
    <div class="profil-info">
    <br><br>
        <div class="col-md-8">
            <div class="tab-content profile-tab" id="myTabContent">
                <div style="border-bottom: solid;" class="row">
                    <div style="border-bottom: none;" class="col-md-6">
                        <label style="width: 700px;" class="prevent">Lokacija: &nbsp'.$row['naziv_lokacije'].'</label>
                    </div>
                </div>
                <div style="border-bottom: solid;" class="row">
                    <div style="border-bottom: none;" class="col-md-6">
                        <label class="prevent">Datum: &nbsp'.$row['datum_dogadaja'].'</label>
                    </div>
                </div>
            </div>
        </div>';

         $sql = "SELECT * from donor where OIB_donora in (select OIB_donora_don from
                                       moj_event where id_lokacije='$id' and prisutnost='1')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
        echo'
        <br>
        <h2>Donirali su:</h2><br>
        <div class="popis">
        ';
        while($row = mysqli_fetch_array($result)){
            echo '
              <div class="follow-info">
                  <div class="follow-img">
                      <img src="donori/'.$row['image'].'">
                  </div>
                  <span>'.$row['ime_prezime_donora'].'</span>
              </div><br>
            ';
        }
        echo '
        </div>  
        <bottom><br><br><a href="eventi.php?keyword=&trazi=Traži">Nazad</a></bottom>
    </div>
    <div style="height:400px;">
    </div>
</div>';
?>