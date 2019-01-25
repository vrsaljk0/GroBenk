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
$datum = date('Y-m-d H:i:s');

echo 'ISPIS SVIH PORUKA<br><br><br>';
$info = "SELECT *from donor where OIB_donora = '$OIB'";
$run = mysqli_query($conn, $info);
$result = $run or die ("Failed to query database". mysqli_error($conn));
$row = mysqli_fetch_array($result);
$moje_ime = $row['ime_prezime_donora'];
$username = $_GET['username'];
//echo $username;
$prijatelj = "SELECT *from donor where username = '$username'";
$run2 = mysqli_query($conn, $prijatelj);
$result2 = $run2 or die ("Failed to query database". mysqli_error($conn));
$row2 = mysqli_fetch_array($result2);
$OIB_prijatelja = $row2['OIB_donora'];
$ime_prijatelja = $row2['ime_prezime_donora'];

if(isset($_POST['posalji_poruku'])){
    $tekst = $_POST['poruka'];
    $message = "INSERT INTO obavijesti (OIBdonora, ID_posiljatelja, tekst_obav, datum_obav, procitano) VALUES ('$OIB_prijatelja', '$OIB', '$tekst', '$datum', '0')";
    $run2 = mysqli_query($conn, $message);
    $result2 = $run or die ("Failed to query database". mysqli_error($conn));
    $url = 'user_history.php?username='.$username;
    header("Location:$url");
}
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
                    $poruke = "SELECT * from obavijesti WHERE (OIBdonora = '$OIB' AND ID_posiljatelja = '$OIB_prijatelja') OR (OIBdonora = '$OIB_prijatelja' AND ID_posiljatelja ='$OIB')";
                    $run_poruke = mysqli_query($conn, $poruke);
                    $result_poruke = $run_poruke or die ("Failed to query database". mysqli_error($conn));

                        while($row_poruke = mysqli_fetch_array($result_poruke)){
                            echo $row_poruke['datum_obav'].' ';
                            if($row_poruke['ID_posiljatelja'] == $OIB){
                                echo $moje_ime;
                            }
                            else echo $ime_prijatelja;
                            echo ': '.$row_poruke['tekst_obav'].'<br><br>';
                        }

                        echo'<form action="" method="POST">
                            <input type="text" placeholder="Posalji poruku" name="poruka">
                            <input type="submit" name="posalji_poruku" value="Posalji poruku">
                            </form>        
                </div>
        </div>
 </div>';

?>


