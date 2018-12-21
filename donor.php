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
    echo "<link rel='stylesheet' type='text/css' href='style.css'>";
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
    $result = $run or die ("Failed to query database". mysqli_error($conn));

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
    echo '<div id="osnovne_informacije" class="left">
            <img src="data:image/jpeg;base64,'.base64_encode( $row['profile_pic'] ).'"/><br><br>
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
        </div>
      ';


    $upit = "select naziv_lokacije, datum_dogadaja from lokacija where idlokacija in 
            (SELECT id_lokacije from moj_event where moj_event.OIB_donora_don = '$OIB' and prisutnost = 1)";
    $rezultat = mysqli_query($conn, $upit);


    echo '<div id="povijest_donacija">
            <b><p style="color:green;">Povijest donacija</p></b>';
            echo'<table style="width:30%">
                 <tr><th align="left">Mjesto doniranja</th><th align="left">Datum doniranja</th></tr>';
                 while($row = mysqli_fetch_array($rezultat)){
                    echo '<tr><td>'.$row['naziv_lokacije'].'</td><td>'.$row['datum_dogadaja'].'</td><tr>';
                }
            echo'</table>    
           </div>';

    echo '<div id="povijest_donacija">
            <b><p">Zakazane donacije</p></b>
      </div>';

    $date = date("Ymd");

    $upit = "SELECT idlokacija, grad, naziv_lokacije, datum_dogadaja FROM lokacija WHERE grad IN (SELECT prebivaliste FROM donor WHERE OIB_donora = '$OIB')
             AND datum_dogadaja > '$date'";
    $run = mysqli_query($conn, $upit);
    $result = $run or die ("Failed to query database". mysqli_error($conn));


    echo '<div id="novi_eventi">
            <form action="" method="POST">
            <b><p style="color:red;">Doniraj krv, spasi zivot! (ilitiga novi eventi blizu donora)</p></b>';
            echo'<table style="width:30%">
                <tr><th align="left">Grad</th><th align="left">Mjesto</th><th align="left">Datum</th></tr>';
                while($row = mysqli_fetch_array($result)){
                    echo '<tr><td>'.$row['grad'].'</td><td>'.$row['naziv_lokacije'].'</td><td>'.$row['datum_dogadaja'].'</td><td><input type="submit" name="dolazim" value="Dolazim"></td></tr>';

                }
            echo'</table>
            </form>
        </div>';
        if(isset($_POST['dolazim'])){
           //kako da dobijem vrijednosti bas iz tog reda
        }

    $upit = "SELECT ime_prezime_donora, OIB_donora from donor where
               OIB_donora in (select OIB_prijatelja from following where
               donor_OIB_donora = '$OIB')";

    $rezultat = mysqli_query($conn, $upit);
    echo '<div hidden id="pratim" class="pratim"><br><b>Prati:</b><br>';
        while($row = mysqli_fetch_array($rezultat)){
            echo '<a href="publicprofile.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">'.$row['ime_prezime_donora'].'</a><br>';

        }
        echo'</div>';

    $upit = "SELECT ime_prezime_donora, OIB_donora from donor where
               OIB_donora in (select OIB_prijatelja from followers where
               donor_OIB_donora = '$OIB')";
    $rezultat = mysqli_query($conn, $upit);

    echo '<div hidden id="prate_me" class="prate_me"><br><b>Prate me:</b><br>';
            while($row = mysqli_fetch_array($rezultat)){
                echo '<a href="publicprofile.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">'.$row['ime_prezime_donora'].'</a><br>';
            }
            echo'</div>';
?>

