    <script  src="jquery-3.3.1.min.js">
        function ChangeButton(){
            var str = document.getElementById("button").innerHTML
            if(str == "Follow"){
                document.getElementById("button").innerHTML = "Unfollow";
            }
            else document.getElementById("button").innerHTML = "Follow"
        }
    </script>
<?php
    require_once "dbconnect.php";
    require_once "functions.php";
    session_start();

    $OIB_korisnika = $_GET['OIB_korisnika'];
    $OIB_donora =  $_SESSION['mojOIB'];

    $query = "SELECT * FROM following WHERE  donor_OIB_donora = $OIB_donora and OIB_prijatelja = $OIB_korisnika";
    $run = mysqli_query($conn, $query);
    $result = $run or die("Failed to query database");
    $row = mysqli_fetch_array($result);
    if(!$row) $str = "Follow";
    else $str = "Unfollow";
    /**
     * pri samom loadu stranicu provjeram follujem li tog korisnika već ili ne -> što će mi pisati na bottunu
     */

    if(isset($_POST['follow'])){
        /**
         * ako je onaj row od gore prazan znači klik na bottun mi treba followati tog donora
         * kod mene se doda OIB_korisnika u following tablicu a kod tog korisnika u followers tablicu
         */
        if(!$row) {
            //KOrisnik ide zapratiti prijatelj
            $query = "INSERT INTO following values ('$OIB_donora', '$OIB_korisnika')";
            $run = mysqli_query($conn, $query);
            if ($run) {
                echo "Sad pratite ovog korisnika";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
            //sad i taj prijatelj dobije novu vrijednost u svoj tablici followersa
            $query = "INSERT INTO followers values ('$OIB_korisnika', '$OIB_donora')";
            $run = mysqli_query($conn, $query);
        }
        else{ //ako već postoji znači da ga želim izbrisati

            $query = "DELETE FROM following WHERE  donor_OIB_donora = $OIB_donora and OIB_prijatelja = $OIB_korisnika";
            $run = mysqli_query($conn, $query);
            if ($run) {
                echo "Više ne pratite ovog korisnika";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
            //sad moram i kod drugog iz tablice izbrisati logično
            $query = "DELETE FROM followers WHERE  donor_OIB_donora = $OIB_korisnika and OIB_prijatelja = $OIB_donora";
            $run = mysqli_query($conn, $query);
        }
    }

    /**
     * Prikazujem podatke o tom donoru
     */
    $query ="select *from donor where OIB_donora = '$OIB_korisnika'";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $r = mysqli_fetch_array($result);
    if($r['br_donacija'] <= 20 ) $string = '*';
    else if($r['br_donacija'] <= 30) $string='**';
    else if($r['br_donacija'] <= 50) $string = '***';

    //prikaz osnovnih informacija o donoru
    echo '<form action="" method="POST">
            <img src="donori/'.$r['image'].'" height="300" width="250"><br><br>
            <b>' .$r['ime_prezime_donora'].'</b><br><br>';
            count_following($OIB_korisnika);
            count_followers($OIB_korisnika);
            echo'Rođena: ' .$r['datum_rodenja'].'<br><br>
            Živi u mjestu: '. $r['prebivaliste']. '<br><br>
            Kontakt: '. $r['mail_donora']. '<br><br>
            <b>'.$r['ime_prezime_donora'].' je donirala ' .$r['br_donacija']. ' puta</b><br> čime je zaslužila ' .$string. ' u našoj banci<br><br>
            <input type="submit" name="poruka" value="Pošalji poruku"><br><br> 
            <button type="submit" name="follow" id="button" onclick="ChangeButton()">'.$str.'</button><br><br>
          </form>';
    echo '<bottom><a href='.$_SESSION["current_page"].'>Nazad na moj profil</a></bottom>';
?>

