<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }

    function toggleVisibility(button) {
        if(button == "button1")var x = document.getElementById("pratim");
        else var x = document.getElementById("prate_me");

        if(x.style.display === "block") {
            x.style.display = "none";
        }
        else {
            x.style.display = "block";
        }
    }
</script>

<?php

    require_once "dbconnect.php"; //fancy include just because I can
    require_once "functions.php";
    session_start();

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];

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

    //za ispis pravilnog roda
    if(!strcmp($row['spol'],'Z')) $gender = 'la';
    else $gender = 'o';



    //prikaz osnovnih informacija o donoru
    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['profile_pic'] ).'"/><br><br>
          <b>' .$row['ime_prezime_donora'].'</b><br><br>
          Rođena: ' .$row['datum_rodenja'].'<br><br>
          Živi u mjestu: '. $row['prebivaliste']. '<br><br>
          Kontakt: '. $row['mail_donora']. '<br><br>';

    echo'<button id="button1"  onclick="toggleVisibility(this.id);">'; echo count_following($OIB); echo'</button>';
    echo'<button id="button2" onclick="toggleVisibility(this.id);">'; echo count_followers($OIB); echo'</button><br>';


    echo   '<b>'.$row['ime_prezime_donora'].' je donira'.$gender. ' ' .$row['br_donacija']. ' puta</b><br> čime je zasluži'.$gender. ' ' .$str. ' u našoj banci<br><br>


      <input type="submit" name="poruka" value="Moj Inbox"><br><br> 
      <input type="submit" name="postavke" value="Postavke"><br><br>
      <input type="submit" name="odjava" value="Odjavi se" onclick="OdjaviMe()"><br><br>
      ';


      //koga donor prati?
      //SELECT ime_prezime_donora from donor where OIB_donora in (select OIB_prijatelja from following where donor_OIB_donora = '$OIB')

      $upit = "SELECT ime_prezime_donora from donor where
               OIB_donora in (select OIB_prijatelja from following where
               donor_OIB_donora = '$OIB')";

      $rezultat = mysqli_query($conn, $upit);
      $following = array();
      if (mysqli_num_rows($rezultat) > 0) {
        while ($red = mysqli_fetch_assoc($rezultat)) {
            $following[] = $red;
        }
      }

      echo '<div hidden id="pratim" ><br><b>Prati:</b><br>';
      foreach ($following as $follow) {
        echo $follow['ime_prezime_donora'] . '<br>';
      } echo'</div>';


      $upit = "SELECT ime_prezime_donora from donor where
               OIB_donora in (select OIB_prijatelja from followers where
               donor_OIB_donora = '$OIB')";

      $rezultat = mysqli_query($conn, $upit);
      $followers = array();
      if (mysqli_num_rows($rezultat) > 0) {
            while ($red = mysqli_fetch_assoc($rezultat)) {
                $followers[] = $red;
            }
      }

      echo '<div hidden id="prate_me"><br><b>Prate je :</b><br>';
        foreach ($followers as $follow) {
            echo $follow['ime_prezime_donora'] . '<br>';
        }echo'</div>';
?>

