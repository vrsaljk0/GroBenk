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
/**
 * donor.php:
 * 1. Prikazuje osnovne informacije o donoru ✔
 * 2. Omogućava pretraživanje ostalih donora ✔
 * 3. Omogućava pregled profil ostalih donora ✔
 * 4. Sustav followinga/followersa ✔
 * 5. Sustav evenat-a ✔
 * 6. Uređivanje postavki računa ✔
 * 7. Sustav poruka
 * 8. Odjava ✔
 *
 * Što šteka ?
 * 1. sve slike profila se prikazuju sa istom širinom i visinom pa to izgleda usrano
 * 2. onclick gumb follow se ne promijeni odmah u unfollow: problem je što je tip inputa mora biti submit(jer šaljemo POST request), a submit se promijeni
 * samo na milisekundu #rip
 *********CODDE MAGIC STARTS HERE*******************/


/**
 * dbcconnect.php includam na početku svakog .php jer se u njemu radi konekcija s bazom.
 * functions.php sadrži dvije funkcije koje koristim u kodu, al sam ih radi preglednosti samo prebacila tamo
 */
    require_once "dbconnect.php"; //fancy include just because I can
    require_once "functions.php";
    echo "<link rel='stylesheet' type='text/css' href='style.css'>";

/**
 * Jednom kad sam se ulogirala želim sačuvati OIB donora i ako odem na neke druge stranice(tipa pregledavam drugog donora)
 * pa zato pokrećem session i pamtim current_page jer svaki donor ima različit page pa se ne mogu samo vratiti na donor.php
 * ako sam negdje drugo
 * iz login.html preko GET metode spremam OIB i password
 */

    session_start();
    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];
    $OIB = $_GET['OIB'];
    $password = $_GET['password'];
/**
 * iduća 4 reda sprječavaju "sql injections" o kojima ne znam još puno al znam da nam se lako hakira bazu haha. to ću na kraju finese dodavati
 * zasad nebitno
 */
    $OIB = stripcslashes($OIB);
    $password = stripcslashes($password);
    $OIB = mysqli_real_escape_string($conn,$OIB);
    $password = mysqli_real_escape_string ($conn, $password);
/**
 * $info upit dohvaća preko OIB sve informacije o ulogiranom donoru.
 */

    $info ="select *from donor where OIB_donora = '$OIB' and password = '$password'";
    $run = mysqli_query($conn, $info);
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

/**
 * 1. dolazim:
 * Donor označi željene lokacije putem checkboxa koji ima value idlokacije i po tome znam koji event je kliknut
 * Označene evente ubacujem u tablicu moj_event sa PRISUTNOSTI 0
 * PRISUTNOST 0 -> KLIKLA SAM DA DOLAZIM
 * PRISUTNOST 1 -> DONIRALA SAM KRV I ADMIN JE POTVRDIO MOJU DONACIJU
 * PRISUTNOST -1 -> KLIKLA SAM DA DOLAZIM AL IZ NEKOG RAZLOGA NISAM DONIRALA (BOLEST, NISAM SE POJAVILA, ADMIN ODBIO DONACIJU ITD)
 *
 * 2. otkazujem
 * U otkazujem se ispisuju svi eventi iz tablice moj_event koji imaju prisutnost 0 i koji su logično dalje od današnjeg datum(to su zakazani eventi)
 * opet preko checkboxa kojem u value spremam id lokacije brišem označene evente
 *
 * BITNO! ova dva ifa se moraju nalaziti iznad svega jer POST metoda automatski refresha stranicu i to nama paše jer želimo da nam se onclick npr.
 * maknu otkazani eventi i sad ako su ifovi gore ponovno će se izvršiti upiti za ispis toga, a ako je negdje dolje onda se izvrši samo kod ispod njih
 * valjda je to tako lol
 */


    if(isset($_POST['dolazim'])){
        if(!empty($_POST['check_list'])){
            foreach($_POST['check_list'] as $id) {
                $sql = "INSERT INTO moj_event values  ('$OIB', '$id', '0')";
                $run_sql = mysqli_query($conn, $sql);
                $result = $run or die ("Failed to query database". mysqli_error($conn));
            }
        }
    }

    if(isset($_POST['otkazi'])) {
        if (!empty($_POST['check_list'])) {
            foreach ($_POST['check_list'] as $id) {
                $sql = "DELETE FROM moj_event where OIB_donora_don = '$OIB' and id_lokacije= '$id' and prisutnost = '0'";
                $run_sql = mysqli_query($conn, $sql);
            }
        }
    }
/**
 * Trazilica ispisuje popis ljudi koji sadrže nešto iz textboxa, fora je što je u upitu %izraz% pa bi za npr a izbacilo sve donore koji sadrže slovo a
 * na kraju bi mogla napraviti "naprednu tražilicu" npr po gradu, godinama itd...
 */
    echo '<center>
            <form action="pretrazi.php" method="GET">
                <input type="text" name = "trazilica" placeholder="Pretraži ostale donore">
                <input type="submit" name="trazi" value="Traži">
                </form>
          </center>';

/**
 * Glupi sustav bodovanja kojeg bi malo trebalo izmjeniti
 * Fora bi bilo dodati neki <img> umjesto samo $str
 */
    if($row['br_donacija'] <= 20 ) $str = '*';
    else if($row['br_donacija'] <= 30) $str='**';
    else if($row['br_donacija'] <= 50) $str = '***';

    //za ispis pravilnog roda
    if(!strcmp($row['spol'],'Z')) $gender = 'la';
    else $gender = 'o';
    //  <img src="data:image/jpeg;base64,'.base64_encode( $row['profile_pic'] ).'"/><br><br>
    //prikaz osnovnih informacija o donoru
    echo '<div id="osnovne_informacije" class="left">
            <img src="donori/'.$row['image'].'" height="300" width="250"><br><br>
            <b>' .$row['ime_prezime_donora'].'</b><br><br>
            Rođena: ' .$row['datum_rodenja'].'<br><br>
            Živi u mjestu: '. $row['prebivaliste']. '<br><br>
            Kontakt: '. $row['mail_donora']. '<br><br>';

            echo'<button id="button1"  onclick="toggleVisibility(this.id);">'; echo count_following($OIB); echo'</button>';
            echo'<button id="button2" onclick="toggleVisibility(this.id);">'; echo count_followers($OIB); echo'</button><br>';
            echo'<b>'.$row['ime_prezime_donora'].' je donira'.$gender. ' ' .$row['br_donacija']. ' puta</b><br> čime je zasluži'.$gender. ' ' .$str. ' u našoj banci<br><br>
                 <input type="submit" name="poruka" value="Moj Inbox"><br><br> 
                 <a href="postavke.php?OIB_korisnika='.urlencode($row['OIB_donora']).'">Uredi moj račun</a><br>   
                 <input type="submit" name="odjava" value="Odjavi se" onclick="OdjaviMe()"><br><br>
          </div>';

/**
 * Ispis povijesti donacija
 */
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

    /**
     * Ispis svih zakazanih donacija->PRISUTNOS 0 u tablici moj_event
     */

    $upit = "SELECT idlokacija, grad, naziv_lokacije, datum_dogadaja from lokacija where idlokacija in(
                         SELECT id_lokacije from moj_event where OIB_donora_don = '$OIB' and prisutnost = '0')";
    $run = mysqli_query($conn, $upit);
    $result = $run or die("Failed to query database". mysqli_error($conn));

    echo '<div id="zakazani_eventi">
            <form action="" method="POST">
                <b><p style="color:red;">Zakazane donacije</p></b>';
                while($row = mysqli_fetch_array($result)){
                    echo $row['naziv_lokacije'].' '.$row['datum_dogadaja'].'<input type="checkbox" name="check_list[]" value='.$row['idlokacija'].'><br>';
                }
                echo'<input type="submit" name="otkazi" value="Otkazi moj dolazak" onclick="Refresh();" >';
                echo'</form>
           </div>';

    /**
     * Ispish svih evenata NA KOJE JA MOGU DOĆI znači lokacije kojih nema u tablici moj_event i koje imaju isti grad ko moj
     * faking dobar upit
     */

    $date = date("Ymd");
    $dolazim = "SELECT idlokacija, grad, naziv_lokacije, datum_dogadaja FROM lokacija WHERE grad IN 
               (SELECT prebivaliste FROM donor WHERE OIB_donora = '$OIB') AND datum_dogadaja > '$date' AND idlokacija NOT IN 
               (SELECT id_lokacije from moj_event WHERE OIB_donora_don = '$OIB')";
    $run = mysqli_query($conn, $dolazim);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    echo '<div id="novi_eventi">
            <form action="" method="POST">
                <b><p style="color:red;">Doniraj krv, spasi zivot! (ilitiga novi eventi blizu donora)</p></b>';
                while($row_dolazim = mysqli_fetch_array($result)){
                    echo '<p id="Maja">'.$row_dolazim['naziv_lokacije'].' '.$row_dolazim['datum_dogadaja'].'<input type="checkbox" name="check_list[]" value='.$row_dolazim['idlokacija'].' onclick="Sakrij();"></p>';
                }
            echo'<input type="submit" name="dolazim" value="Dolazim">';
            echo'</form>
        </div>';

    /**
     * Sustav praćenja
     */
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
