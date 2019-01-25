<?php
require_once "dbconnect.php";
session_start();
$OIB = $_SESSION['id'];
$info = "SELECT *from donor where OIB_donora = '$OIB'";
$run = mysqli_query($conn, $info);
$result = $run or die ("Failed to query database". mysqli_error($conn));
$row = mysqli_fetch_array($result);
$moje_ime = $row['ime_prezime_donora'];
echo 'ISPIS SVIH PORUKA<br><br><br>';

$sql = "SELECT * from obavijesti where OIBdonora ='$OIB' and ID_posiljatelja !='1'group by ID_posiljatelja";
$run = mysqli_query($conn, $sql);
$result = $run or die ("Failed to query database". mysqli_error($conn));

echo'  <div id="poruke">
            <a href="admin_history.php">ADMIN</a><br><br>';
            while($row = mysqli_fetch_array($result)){
                $OIB_prijatelja = $row['ID_posiljatelja'];
                $prijatelj = "SELECT * from donor where OIB_donora = '$OIB_prijatelja'";
                $run_prijatelj = mysqli_query($conn, $prijatelj);
                $result2 = $run_prijatelj or die ("Failed to query database". mysqli_error($conn));
                $row_prijatelj = mysqli_fetch_array($result2);
                $ime = $row_prijatelj['ime_prezime_donora'];
                $username_prijatelja = $row_prijatelj['username'];
            echo '<a href="user_history.php?username='.urlencode($username_prijatelja).'"><font color="FF00CC">'.$row_prijatelj['ime_prezime_donora'].'</font></a><br><br>';
            }
    echo '</div>';
?>