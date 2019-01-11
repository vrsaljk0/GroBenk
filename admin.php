<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<?php
    require_once "dbconnect.php";
    session_start();

    echo"Dobrodošao admine!";


    if(isset($_GET['obavijest'])) {
        $grad = $_GET['grad'];
        $krvna_grupa = $_GET['kgrupa'];
        $tekst = $_GET['tekst'];

        $datum = date('Y-m-d');
        $status = 0;

        if ($krvna_grupa == '0' and $grad == '0') {
            $sql = "SELECT * from donor where 1";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }
        if ($krvna_grupa == '0' and $grad != '0') {
            $sql = "SELECT * from donor where prebivaliste = '$grad'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }
        if ($grad == '0' and $krvna_grupa != '0') {
            $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }
        if ($krvna_grupa!= '0' and $grad != '0'){
            $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa' and prebivaliste = '$grad'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }

        while ($row = mysqli_fetch_array($run)) {
            $OIB = $row['OIB_donora'];
            $sqll = "INSERT INTO obavijesti (OIBdonora, tekst_obav, datum_obav, procitano) VALUES ('$OIB', '$tekst', '$datum', '$status')";
            $runn = mysqli_query($conn, $sqll);
            $resultt = $runn or die ("Failed to query database". mysqli_error($conn));
        }
        header("Location:admin.php");
    }





    if(isset($_GET['delete_event'])){
        $id = $_GET['lokacije'];
        //echo $id;
        $sql = "DELETE FROM lokacija WHERE id_lokacije='$id'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
        //header("Location:admin.php");
    }
    if(isset($_GET['prihvati'])){
        if(!empty($_GET['check_list'])){
            foreach($_GET['check_list'] as $id) {
                $sql = "SELECT krvna_grupa_zaht, kolicina_krvi_zaht from zahtjev where idzahtjev = '$id'";
                $run = mysqli_query($conn, $sql);
                $result = $run or die ("Failed to query database". mysqli_error($conn));
                $row = mysqli_fetch_array($result);
                $krvna_gr = $row['krvna_grupa_zaht'];
                $kolicina_zahtjeva = $row['kolicina_krvi_zaht'];
                $sql2 = "SELECT *from zaliha where krvna_grupa = '$krvna_gr'";
                $run2 = mysqli_query($conn, $sql2);
                $result2 = $run2 or die ("Failed to query database". mysqli_error($conn));
                $row2 = mysqli_fetch_array($result2);
                $kolicina_zalihe = $row2['kolicina_grupe'];
                if($kolicina_zalihe >= $kolicina_zahtjeva){
                    $prihvati_zahtjev = "UPDATE zaliha SET kolicina_grupe = kolicina_grupe - '$kolicina_zahtjeva' where krvna_grupa = '$krvna_gr'";
                    $run = mysqli_query($conn, $prihvati_zahtjev);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    //GETaviti odobreno na 1 u tablici zahtjeva
                    $update_zahtjev = "UPDATE zahtjev SET odobreno = '1' WHERE idzahtjev = '$id'";
                    $run = mysqli_query($conn, $update_zahtjev);
                }
                else{
                    echo "Trenutno nema dovoljno krvi za ovaj zahtjev";
                }
            }

        }
        //header("Location:admin.php");
    }
    if(isset($_GET['odbij_zahtjev'])) {
        if (!empty($_GET['check_list'])) {
            foreach ($_GET['check_list'] as $id) {
                $sql = "UPDATE zahtjev SET odobreno = '-1' WHERE idzahtjev = '$id'";
                $run = mysqli_query($conn, $sql);
                $result = $run or die ("Failed to query database". mysqli_error($conn));
            }
        }
        //header("Location:admin.php");
    }
    echo '
        <html>
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="#content8">&nbsp;Statistika&nbsp;</a>
               <a href="" onclick="OdjaviMe();">&nbsp;Odjavi se&nbsp;</a>
           </div>

           <div id="content0" class="toggle" style="display:none">';
            echo '<br>Povijest događaja<br><br>';
            $date = date("Ymd");
            $query = "SELECT id_lokacije, naziv_lokacije, datum_dogadaja FROM lokacija where datum_dogadaja < '$date'";
            $run = mysqli_query($conn, $query);
            echo "<form action='' method='GET'>
                         <select name='lokacije'>";
                                while ($row = mysqli_fetch_array($run)) {
                                    echo "<option value='" . $row['id_lokacije'] ."'>" . $row['naziv_lokacije'] ."</option>";
                                }
                                echo  '<input type="submit" name="show_events" value="Pokazi donore"/>
                           </select>
                  </form>';
               echo '</div>

           <div id="content00" class="toggle2" style="display:none">';
                    if(isset($_GET['show_events'])){
                        $id = $_GET['lokacije'];
                        $sql = "SELECT * from lokacija where id_lokacije = '$id'";
                        $run = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($run);

                        echo 'Lokacija: '.$row['naziv_lokacije'].'<br>Datum: '.$row['datum_dogadaja'].'<br>Donori:<br><br>';

                        $sql = "SELECT ime_prezime_donora from donor where OIB_donora in (select OIB_donora_don from
                                   moj_event where id_lokacije='$id' and prisutnost='1')";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        while($row = mysqli_fetch_array($result)){
                            echo $row['ime_prezime_donora'].'<br><br>';
                        }
                }
            echo'</div>
            </div>
          

            <div id="content2" class="toggle" style="display:none">';
                $query = "SELECT id_lokacije, naziv_lokacije, datum_dogadaja FROM lokacija";
                $run = mysqli_query($conn, $query);
                echo"<br>Izbrisi neki event<br><br>";
                echo "<form action='' method='GET'>
                         <select name='lokacije'>";
                            while ($row = mysqli_fetch_array($run)) {
                            echo "<option value='" . $row['id_lokacije'] ."'>" . $row['naziv_lokacije'] ."</option>";
                            }
                            echo  '<input type="submit" name="delete_event" value="Izbrisi">';
                           echo "</select>
                         </form>";
                echo'</div>

            <div id="content3" class="toggle" style="display:none">
               <p>Danas se može donirati na sljedećim lokacijama:</p>';
                $date = date("Ymd");
                $query = "SELECT id_lokacije, naziv_lokacije, datum_dogadaja FROM lokacija where datum_dogadaja = '$date'";
                $run = mysqli_query($conn, $query);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

                echo "<form action='' method='GET'>
                           <select name='lok'>";
                            while ($row = mysqli_fetch_array($run)) {
                                echo "<option value='" . $row['id_lokacije'] ."'>" . $row['naziv_lokacije'] ."</option>";
                            }
                            echo  '<input type="submit" name="show" value="Pokazi donore">';
                            echo '</select>
                         </form>
            </div>
            
           <div id="content30" class="toggle2"style="display:none">';
                if(isset($_GET['show'])){
                    $id = $_GET['lok'];
                    $sql = "SELECT OIB_donora, ime_prezime_donora from donor where OIB_donora in
                           (SELECT OIB_donora_don from moj_event where id_lokacije='$id' and prisutnost='0')";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    echo "<form action='' method='GET'>
                               <br><br>
                               <select name='donacija'>";
                                    while ($row = mysqli_fetch_array($run)) {
                                        echo "<option value='" . $row['OIB_donora'] ."'>" . $row['ime_prezime_donora'] ."</option>";
                                    }

                                    echo  '<input type="hidden" value='.$id.' name="id_lokacije">
                                          <input type="submit" name="doniraj" value="Dodaj donaciju">
                                          <input type="submit" name="odbij" value="Odbij donaciju">';
                                    echo "</select>
                         </form>";
                    //unset($_GET['show']);
                }
            echo'</div>
           <div id="content31" class="toggle2">';
                    if(isset($_GET['odbij'])){
                        $OIB = $_GET['donacija'];
                        $id = $_GET['id_lokacije'];
                        $sql = "UPDATE moj_event SET prisutnost = '-1' WHERE OIB_donora_don = '$OIB' and id_lokacije='$id' and prisutnost = '0'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        header("Location:admin.php");
                    }
                    if(isset($_GET['doniraj'])){
                        $OIB = $_GET['donacija'];
                        $id = $_GET['id_lokacije'];
                        $sql = "SELECT *from donor where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);

                        echo'<form action="" method="GET">
                             <p>Dodaj novu donaciju</p>
                             Ime i prezime donora <input type="text" value="'.$row['ime_prezime_donora'].'" ><br><br>
                             OIB_donora <input type="text" name="OIB_don" value='.$row['OIB_donora'].'  ><br><br>
                             Krvna grupa donora <input type="text" name="krvna_grupa_don" value='.$row['krvna_grupa_don'].' ><br><br>
                             Količina krvi <input type="text" name="kol_krvi" step="0.01">
                             <input type="hidden" name="id_lokacije" value='.$id.'>
                             <input type="submit" name="unesi_donaciju">
                           </form>';
                        //header("Location:admin.php");

                    }
                    if(isset($_GET['unesi_donaciju'])){
                        $OIB = $_GET['OIB_don'];
                        $id = $_GET['id_lokacije'];
                        $kol = $_GET['kol_krvi'];
                        $grupa = $_GET['krvna_grupa_don'];

                        $sql = "INSERT into donacija (kolicina_krvi_donacije, krvna_grupa_zal, OIB_donora, idlokacija)
                                        values ( '$kol', '$grupa', '$OIB', '$id')";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE donor SET br_donacija = br_donacija+1 where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE moj_event SET prisutnost = '1' WHERE OIB_donora_don = '$OIB' AND id_lokacije='$id'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE zaliha set kolicina_grupe = kolicina_grupe + '$kol' where krvna_grupa = '$grupa'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        header("Location:admin.php");
                    }
            echo '</div>
            <div id="content4" class="toggle" style="display:none">';
                $zaliha_q = "SELECT * from zaliha";
                $run = mysqli_query($conn, $zaliha_q);
                $result = $run or die ("Failed to query database". mysqli_error($conn));
               // $red = mysqli_fetch_array($result);
                while($red = mysqli_fetch_array($result)){
                    echo $red['krvna_grupa'].' ' . $red['kolicina_grupe'].'<br><br>';
                }

             echo'</div>

           <div id="content5" class="toggle" style="display:none">Bolnički zahtjevi';
                $zahtjev_q = "SELECT  *from zahtjev, bolnica where zahtjev.odobreno = '0' and zahtjev.id_bolnica = bolnica.idbolnica ";
                $run = mysqli_query($conn, $zahtjev_q);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

                echo '<form action="" method="GET">
                       <b><p style="color:red;">Novi zahtjevi za krvlju</p></b>
                       <p>Bolnica&nbsp;&nbsp;Kolicina krvi&nbsp;&nbsp;Krvna grupa&nbsp;&nbsp;Datum zahtjevanja</p>';
                        while($row = mysqli_fetch_array($result)){
                            echo '<p>'.$row['naziv_bolnice'].' '.$row['kolicina_krvi_zaht'].'l '.$row['krvna_grupa_zaht'] .$row['datum_zahtjeva'].'<input type="checkbox" name="check_list[]" value='.$row['idzahtjev'].'></p>';
                        }
                        echo'<input type="submit" name="prihvati" value="Prihvati">
                            <input type="submit" name="odbij_zahtjev" value="Odbij">
                    </form>';
            echo '</div>
            
            <div id="content6" class="toggle" style="display:none">
            
            <br>
            <form method="GET" action="">
                <select id="id_donor" name="id_donor">
                <option value="0">-Ime Prezime-(ID)-</option>';
                    $preg_query = "select * from donor";
                    $result = mysqli_query($conn, $preg_query);
                    while($row = mysqli_fetch_assoc($result)) {
                        $id = $row['OIB_donora'];
                        $imeprez = $row['ime_prezime_donora'];
                        echo '<option value='.$id.'>'.$imeprez. '-(' .$id.')</option>';
                    }
                echo'</select> <br>        
           <input type="submit" name="submit" value="Uredi donora">
            </form></div><br>

             <div id="content60" class="toggle2" style="display:none">';
                if(isset($_GET['submit'])) {

                    $id_donor = $_GET['id_donor'];

                    $sql = "select * from donor where OIB_donora = '$id_donor'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    echo '<form action="" method="GET">
                            <br>Uredi GETavke donora:<br><br>
                            OIB <input type="text" name="id" value = "'.$id_donor.'" readonly><br><br>
                            Ime i prezime <input type="text" name="imeprez" value = "' . $row['ime_prezime_donora'] . '"><br><br> <!--value "" kako bi ispisalo cijeli string (inace do razmaka)-->
                            Krvna grupa 
                            <select id="krvna" name="krvna"> 
                            <option value="' . $row['krvna_grupa_don'] . '">' . $row['krvna_grupa_don'] . '</option>';
                    $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0-', '0+');
                    foreach ($krv as $value) {
                        echo '<option value=' . $value . '>' . $value . '</option>';
                    }

                    echo '</select><br><br>
                            Datum rođenja <input type="date" name="datum" value=' . $row['datum_rodenja'] . '> <br><br>
                            Prebivalište <input type="text" name="prebivaliste" value="' . $row['prebivaliste'] . '"><br><br>
                            Poštanski broj<input type="number" name="postanski_broj" value="' . $row['postanski_broj'] . '"><br><br>
                            Broj Mobitela<input type="number" name="mobitel" value="' . $row['broj_mobitela'] . '"><br><br> 
                            E-mail<input type="text" name="email" value="' . $row['mail_donora'] . '"><br><br> 
                            Spol<input type="text" name="spol" value="' . $row['spol'] . '"><br><br> 
                            Adresa<input type="text" name="adresa" value="' . $row['adresa_donora'] . '"><br><br> 
                            Username<input type="text" name="username" value="' . $row['username'] . '"><br><br> 
                            Password<input type="text" name="password" value="' . $row['password'] . '"><br><br> 
                            Broj donacija<input type="number" name="brdonacija" value="' . $row['br_donacija'] . '"><br><br> 
                            Slika profila<input type="text" name="profilna" value="' . $row['image'] . '"><br><br> 
                                  
                            <input type="submit" name="updejtaj" value="Spremi promjene"><br><br>
                        </form>';

                }
                if (isset($_GET['updejtaj'])) {
                        $id_donor = $_GET['id'];
                        $krvna_grupa_don = $_GET['krvna'];
                        $ime_prezime_donora = $_GET['imeprez'];
                        $datum_rodenja = $_GET['datum'];
                        $prebivaliste = $row['prebivaliste'];
                        $postanski_broj = $_GET['postanski_broj'];
                        $brojmobitela = $_GET['mobitel'];
                        $mail_donora = $_GET['email'];
                        $spol = $_GET['spol'];
                        $adresa_donora = $_GET['adresa'];
                        $username = $_GET['username'];
                        $password = $_GET['password'];
                        $br_donacija = $_GET['brdonacija'];
                        $image = $_GET['profilna'];

                        $update_query = "update donor set krvna_grupa_don = '$krvna_grupa_don',ime_prezime_donora ='$ime_prezime_donora', datum_rodenja = '$datum_rodenja',
                    prebivaliste = '$prebivaliste', postanski_broj = '$postanski_broj',broj_mobitela = '$brojmobitela', mail_donora = '$mail_donora',
                    spol = '$spol', adresa_donora = '$adresa_donora', username = '$username', password = '$password', br_donacija = '$br_donacija', image = '$image'
                    where OIB_donora = '$id_donor'";

                        $update_run = mysqli_query($conn, $update_query);
                    }


                echo'
            </div>
            
           <div id="content7" class="toggle" style="display:none">
               Pošalji obavijest:
               
               <form id = "obavijest" method="GET" action="">
               <select id="kgrupa" name="kgrupa">
               <option value="0">-krvna grupa-</option>';
                    $krvna_grupa = array("A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-");
                    for ($i = 0; $i < 8; $i++) {
                        echo '<option value='.$krvna_grupa[$i].'>'.$krvna_grupa[$i].'</option>';
                    }

                echo'</select>';

                $query = "select * from donor group by prebivaliste";
                $run = mysqli_query($conn, $query);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

                echo'<select name="grad" id ="grad">
                   <option value="0">-grad-</option>';
                            while ($row = mysqli_fetch_array($run)) {
                                echo '<option value="'.$row['prebivaliste'].'">'.$row['prebivaliste'].'</option>';
                            }
                            echo '</select>
              <br><textarea name="tekst" id="tekst" form="obavijest"></textarea><br>
              <input type="submit" name="obavijest" value="Posalji obavijest">
              </form>
           </div>
            
            <div id="content8" class="toggle" style="display:none">';

            $sql = "select id_lokacije from moj_event group by id_lokacije";
            $result = mysqli_query($conn, $sql);
            $num_events = mysqli_num_rows($result);

            $sql = "select OIB_donora_don from moj_event where prisutnost = 1";
            $result = mysqli_query($conn, $sql);
            $num_pdonation = mysqli_num_rows($result);

            $sql = "select OIB_donora_don from moj_event where prisutnost = -1";
            $result = mysqli_query($conn, $sql);
            $num_odonation = mysqli_num_rows($result);

            $sql = "select * from moj_event join donor on (OIB_donora = OIB_donora_don) where prisutnost = 1 group by krvna_grupa_don  order by krvna_grupa_don desc limit 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $naj_krvnag = $row['krvna_grupa_don'];

                echo'Generalna statistika:
                        <table border="1">
                          <tr>
                            <th>Održani eventi</th>
                            <td>'.$num_events.'</td> 
                          </tr>
                          <tr>
                            <th>Prikupljene donacije</th>
                            <td>'.$num_pdonation.'</td> 
                          </tr>
                          <tr>
                            <th>Odbijene donacije</th>
                            <td>'.$num_odonation.'</td> 
                          </tr>
                          <tr>
                            <th>Najviše je prikupljeno krvne grupe:</th>
                            <td>'.$naj_krvnag.'</td> 
                          </tr>
                        </table>
            
            <br>
            <form method="GET" action=""">
            
                
                <select id="mjesec" name="mjesec">
                <option value="0">-odaberi mjesec-</option>';
                    $mjesec = 1;
                    $mjesec_array = array("siječanj", "veljača", "ožujak", "travanj", "svibanj", "lipanj", "srpanj", "kolovoz", "rujan", "listopad", "studeni", "prosinac");
                    for ($i = 0; $i < 12; $i++) {
                        echo '<option value='.$mjesec.'>-'.$mjesec_array[$i].'-</option>';
                        $mjesec++;
                    }

                echo'</select> <br>
                
                <select id="godina" name="godina">
                <option value="0">-odaberi godinu-</option>';

                $now = new \DateTime('now');
                $years = $now->format('Y')-4;
                for ($i = 0; $i < 5; $i++) {
                    echo '<option value='.$years.'>-'.$years.'.godina-</option>';
                    $years++;
                }
                echo '</select> <br>
            <input type="submit" name="prikazi" value="prikazi">
            </form></div><br>

             <div id="content80" class="toggle2" style="display:none">';
                if(isset($_GET['prikazi'])){
                        //kako bi znali za koj mjesec i godinu racunamo mjesecnu statistiku:
                        /*$now = new \DateTime('now'); //ako zelimo sadasnjost
                        $month = $now->format('m');
                        $year = $now->format('Y');*/

                        $month = $_GET['mjesec'];
                        $year = $_GET['godina'];

                        //broj odrzanih evenata u tom razdoblju:
                        $sql = "select id_lokacije from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                                            (select extract(year from datum_dogadaja)) = '$year' and 
                                            (select extract(month from datum_dogadaja)) = '$month') group by id_lokacije";
                        $result = mysqli_query($conn, $sql);
                        $num_events = mysqli_num_rows($result);

                        //broj prikupljenih donacija u tom razdoblju:
                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                                                                    (select extract(year from datum_dogadaja)) = '$year' and 
                                                                    (select extract(month from datum_dogadaja)) = '$month') and 
                                                                    prisutnost = 1";
                        $result = mysqli_query($conn, $sql);
                        $num_pdonation = mysqli_num_rows($result);

                        //broj odbijenih donacija u tom razdoblju:
                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                                                                                (select extract(year from datum_dogadaja)) = '$year' and 
                                                                                (select extract(month from datum_dogadaja)) = '$month') and 
                                                                                 prisutnost = -1";
                        $result = mysqli_query($conn, $sql);
                        $num_odonation = mysqli_num_rows($result);

                        //najvise krvne grupe u tom razdoblju:
                        $sql = "select * from moj_event join donor on (OIB_donora = OIB_donora_don) where id_lokacije in (select id_lokacije from lokacija where 
                                                                                (select extract(year from datum_dogadaja)) = '$year' and 
                                                                                (select extract(month from datum_dogadaja)) = '$month')and 
                                                                                prisutnost = 1 group by krvna_grupa_don  order by krvna_grupa_don desc limit 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $naj_krvnag = $row['krvna_grupa_don'];

                        echo'<br>Statistika za '.$month.'.mjesec '.$year.' .godine:
                        <table border="1">
                          <tr>
                            <th>Održani eventi</th>
                            <td>'.$num_events.'</td> 
                          </tr>
                          <tr>
                            <th>Prikupljene donacije</th>
                            <td>'.$num_pdonation.'</td> 
                          </tr>
                          <tr>
                            <th>Odbijene donacije</th>
                            <td>'.$num_odonation.'</td> 
                          </tr>
                          <tr>
                            <th>Najviše je prikupljeno krvne grupe:</th>
                            <td>'.$naj_krvnag.'</td> 
                          </tr>
                        </table>
                ';
                    }
                echo'
            </div>
            
            
            
            
            <script src="http://code.jquery.com/jquery-latest.js"></script>   
            <script  type="text/javascript">
                $("#nav a").click(function(e){
                    e.preventDefault();
                    $(".toggle").hide();
                    $(".toggle2").hide();
                    var toShow = $(this).attr(\'href\');
                    $(toShow).show();
                    
                });
              //  $("#content0").show();        
                $("#content00").show();    
                $("#content30").show();
                $("#content80").show();
                $("#content60").show();
                $("#content10").show();
             </script>
        </html>';
?>