<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<?php

    require_once "dbconnect.php"; //fancy include just because I can
    session_start();

    $OIB = $_GET['OIB'];
    $password = $_GET['password'];

    //da se ne ubaci u bazu
    $OIB = stripcslashes($OIB);
    $password = stripcslashes($password);
    $OIB = mysqli_real_escape_string($conn,$OIB);
    $password = mysqli_real_escape_string ($conn, $password);


    $query ="select *from donor where OIB_donora = '$OIB' and password = '$password'";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysql_error());

    $row = mysqli_fetch_array($result);
    if ($row['OIB_donora'] == $OIB && $row['password'] == $password && ("" !== $OIB || "" !== $password) ) {
        echo "Dobrodošao ".$row['ime_prezime_donora']." !<br><br>";
        $_SESSION["OIB_donora"] = $OIB; //spremam session varijablu da je mogu kasnije koristiti
        $_SESSION["ime"] = $row['ime_prezime_donora'];
    } else {
        echo "Pogresna lozinka ili OIB!";
        exit;
    }
    //pretraživanje donora
    echo '<center>
            <form action="pretrazi.php" method="GET">
                <input type="text" name = "trazilica" placeholder="Pretraži ostale donore">
                <input type="submit" name="trazi" value="Traži">
            </form>
          </center>';

    //sustav bodovanja
    if($row['br_donacija'] <= 20 ) $str = '*';
    else if($row['br_donacija'] <= 30) $str='**';
    else if($row['br_donacija'] <= 50) $str = '***';


    //prikaz osnovnih informacija o donoru
echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['profile_pic'] ).'"/><br><br>
      <b>' .$row['ime_prezime_donora'].'</b><br><br>
      Rođena: ' .$row['datum_rodenja'].'<br><br>
      Živi u mjestu: '. $row['prebivaliste']. '<br><br>
      Kontakt: '. $row['mail_donora']. '<br><br>
      <b>'.$row['ime_prezime_donora'].' je donirala ' .$row['br_donacija']. ' puta</b><br> čime je zaslužila ' .$str. ' u našoj banci<br><br>
      <input type="submit" name="poruka" value="Moj Inbox"><br><br> 
      <input type="submit" name="postavke" value="Postavke"><br><br>
      <input type="submit" name="odjava" value="Odjavi se" onclick="OdjaviMe()"><br><br>
      ';
?>
