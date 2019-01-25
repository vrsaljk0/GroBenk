<?php
    require_once "dbconnect.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!isset($_SESSION['bolnica_loggedin'])) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];


    $date = date("Ymd");
    $idbolnica = $_SESSION['id'];


    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
    $naziv_bolnice = $row['naziv_bolnice'];
    if(isset($_POST['posalji_zahtjev'])){
        $kolicina = $_POST['kolicina'];
        $krvna_grupa = $_POST['grupa'];
        $sql = "INSERT INTO zahtjev (id_bolnica, kolicina_krvi_zaht, krvna_grupa_zaht, datum_zahtjeva, odobreno) values ('$idbolnica', '$kolicina', '$krvna_grupa', '$date', '0')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }

echo'
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
    <link href="bolnica_zahtjevstyle.css" rel="stylesheet">
</head>';

echo "
<div id='nav-placeholder' onload>
</div> 

<script>
$(function(){
  $('#nav-placeholder').load('bolnicanavbar.php');
});
</script>";

echo' 
 <div class="profil-img">
    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
    <div class="profil-info">
        <div class="profil-content">
            <ul class="nav nav-tabs" id="myTab" >
                <li class="nav-item">
                    <a class="nav-link" href="bolnicaopcenito.php">Općenito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forum.php">Forum</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link active" href="posalji_zahtjev.php">Pošalji zahtjev</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="otkazi_zahtjev.php">Otkaži zahtjev</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bolnicka_statistika.php">Statistika</a>
                </li>
            </ul>
        </div>

        <div class="col-md-8">


            <div class="form-style-6">
                <h1>Pošalji novi zahtjev</h1>
                <form action="" method="POST">
                <input type="number" name="kolicina" step="0.01" placeholder="Količina potrebne krvi (L)" />
                    <span class="select">
                        <select id="kgrupa" name="grupa">
                        <option value="0">Krvna grupa</option>';
                        $krvna_grupa = array("A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-");
                        for ($i = 0; $i < 8; $i++) {
                            echo '
                            <option value='.$krvna_grupa[$i].'>'.$krvna_grupa[$i].'</option>';
                        }
                        echo'
                        </select>
                    </span>
                    <input type="submit" class="zbtn" name="posalji_zahtjev" value="Pošalji zahtjev">
                </form>
            </div>
        </div>
    </div>
</div>';                          
?>