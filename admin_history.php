<?php

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

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");
/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!$_SESSION['donor_loggedin']) header("Location:denied_permission.php");

echo "
    <div id='nav-placeholder' onload>
    </div>

    <script>
    $(function(){
      $('#nav-placeholder').load('donornavbar.php');
    });
    </script>";

$OIB = $_SESSION['id'];
$sql_korisnici = "SELECT * from obavijesti where OIBdonora ='$OIB' and ID_posiljatelja!='1' group by ID_posiljatelja";
$run_korisnici = mysqli_query($conn, $sql_korisnici);
$result_korisnici = $run_korisnici or die ("Failed to query database". mysqli_error($conn));
echo '
<div class="profil-img">
        <a href="admin_history.php">ADMIN</a><br><br>';
            while($row = mysqli_fetch_array($result_korisnici)){
                $OIB_prijatelja = $row['ID_posiljatelja'];
                $prijatelj = "SELECT * from donor where OIB_donora = '$OIB_prijatelja'";
                $run_prijatelj = mysqli_query($conn, $prijatelj);
                $result2 = $run_prijatelj or die ("Failed to query database". mysqli_error($conn));
                $row_prijatelj = mysqli_fetch_array($result2);
                $ime = $row_prijatelj['ime_prezime_donora'];
                $username_prijatelja = $row_prijatelj['username'];
            echo '<a href="user_history.php?username='.urlencode($username_prijatelja).'"><font color="FF00CC">'.$row_prijatelj['ime_prezime_donora'].'</font></a><br><br>';
            }
        echo'<div class="profil-info">
                <div class="col-md-8">';
                    $sql_admin = "SELECT * from obavijesti where OIBdonora = '$OIB' AND ID_posiljatelja = '1'";
                    $run_admin = mysqli_query($conn, $sql_admin);
                    $result_admin = $run_admin or die ("Failed to query database". mysqli_error($conn));
                    echo '<div class="profile-content">';
                    while($row_admin = mysqli_fetch_array($result_admin)){
                        echo $row_admin['datum_obav'].'  '.$row_admin['tekst_obav'].'<br><br>';
                    }
            echo'</div>
         </div>
    </div>';
?>


