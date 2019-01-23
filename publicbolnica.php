<?php

  require_once ("dbconnect.php");
  session_start();
  mysqli_set_charset($conn,"utf8");

  /** SESSION TIMEOUT */
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
  }
  $_SESSION['LAST_ACTIVITY'] = time();

  if (!$_SESSION['donor_loggedin']) header("Location:denied_permission.php");

  $id_bolnice = $_GET['id_bolnice'];
  $OIB = $_SESSION['mojOIB'];

  $query ="select * from donor where OIB_donora = '$OIB'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row_donor = mysqli_fetch_assoc($result);
  $ime = $row_donor['ime_prezime_donora'];
  $username = $row_donor['username'];
  $date = date('Y-m-d');

  $query ="select * from bolnica where idbolnica = '$id_bolnice'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);

  if(isset($_POST['komentar'])){
    $tekst = $_POST['tekst'];
    $sql = "INSERT INTO komentari values ('$username', '$ime', '$id_bolnice', '$tekst', '$date')";
    $run = mysqli_query($conn, $sql);
    $result = $run or die ("Failed to query database". mysqli_error($conn));
  }

  echo'<b>'.$row['naziv_bolnice'].'</b>
  <br>Grad:'.$row['grad'].'
  <br>Adresa:'.$row['adresa_bolnice'].'
  <br>Poštanski broj:'.$row['postanski_broj'].'<br><br>
  <h4>Aktualni eventi u okolici:</h4>';

  $sql = "SELECT * from lokacija where grad in (select grad from bolnica where idbolnica = '$id_bolnice') and 
          datum_dogadaja >= '$date'";
  $run = mysqli_query($conn, $sql);
  $result = $run or die ("Failed to query database". mysqli_error($conn));

  while($row = mysqli_fetch_array($run)){
    echo ' '.$row['datum_dogadaja'].' '. $row['naziv_lokacije'].'  '. $row['start'].'-'. $row['kraj'].'<br><br></i>';
  }

  echo'<br><br>
  <h4>Forum:</h4>';

  $sql = "SELECT * from komentari where idbolnica_bol = '$id_bolnice'";
  $run = mysqli_query($conn, $sql);
  $result = $run or die ("Failed to query database". mysqli_error($conn));

  while($row = mysqli_fetch_array($run)){
    if(is_numeric ($row['user_autora'])){ //radi se o bolnici
      echo '<a href="publicbolnica.php?id_bolnice='.urlencode($row['user_autora']).'">'.$row['autor'].'</a>';
    }
    else {
      $username = $row['user_autora'];
      $don = "SELECT * from donor where username = '$username'";
      $run2 = mysqli_query($conn, $don);
      $result = $run2 or die ("Failed to query database". mysqli_error($conn));
      $row_don = mysqli_fetch_array($run2);
      //echo '<img src="donori/'.$row_don['image'].'">';
      echo '<a href="publicprofile.php?username='.urlencode($username).'">'.$row['autor'].'</a>';
    }
    echo' komentirao je '.$row['datum_kom'].'<br><br>';
    echo $row['tekst_komentara'].'<br><br>';
  }
  echo'<textarea name="tekst" id="tekst" form="myform"></textarea>
                          <form action="" method="POST" id="myform">
                            <input type="submit" value="Komentiraj" name="komentar"> 
                          </form>
                          ';

?>


