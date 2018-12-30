<?php
    require_once "dbconnect.php";
    session_start();
    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];

    $username = $_GET['username'];
    $password = $_GET['password'];

    $info ="select *from admin where username = '$username' and password = '$password'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);

    if ($row['username'] == $username && $row['password'] == $password && ("" !== $username || "" !== $password) ) {
        echo "Dobrodošao admine";
    } else {
        echo "Pogresna lozinka ili username!";
    exit;
    }
    if(isset($_POST['submit_event'])){
        $idlokacija = $_POST['idlokacija'];
        $grad = $_POST['grad'];
        $adresa_lokacije = $_POST['adresa_lokacije'];
        $postanskibr = $_POST['postanski_broj'];
        $datum_dogadaja= date('Y-m-d',strtotime($_POST['datum_dogadaja']));
        $sql = "INSERT INTO lokacija VALUES ('$idlokacija', '$grad', '$adresa_lokacije', '$postanskibr', '$postanskibr', '$datum_dogadaja')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if(isset($_POST['delete_event'])){
        $id = $_POST['lokacije'];
        //echo $id;
        $sql = "DELETE FROM lokacija WHERE idlokacija='$id'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }

    echo '
         <html>
             <div id="nav">
                <a href="#content0" >Pregledaj evente&nbsp;</a>
                <a href="#content1" >Dodaj event&nbsp;</a>
                <a href="#content2">&nbsp;Izbrisi event&nbsp;</a>
                <a href="#content3">&nbsp;Upravljaj donacijama(dodaj/odbij)&nbsp;</a>
                <a href="#content4">&nbsp;Pregledaj trenutnu zalihu krvi&nbsp;</a>
                <a href="#content5">&nbsp;Bolnički zahtjevi&nbsp;</a>
                <a href="#content6">&nbsp;Uredi postavke donora&nbsp;</a>
                <a href="#content7">&nbsp;Pošalji obavijest donorima&nbsp;</a>       
                <a href="#content8">&nbsp;Mjesecna statistika&nbsp;</a>                  
            </div>
            
            <div id="content0" class="toggle" style="display:none">';
            echo '<br>Povijest događaja<br><br>';
            $date = date("Ymd");
            $query = "SELECT idlokacija, naziv_lokacije, datum_dogadaja FROM lokacija where datum_dogadaja < '$date'";
            $run = mysqli_query($conn, $query);
            echo "<form action='' method='POST'>
                          <select name='lokacije'>";
                                while ($row = mysqli_fetch_array($run)) {
                                    echo "<option value='" . $row['idlokacija'] ."'>" . $row['naziv_lokacije'] ."</option>";
                                }
                                echo  '<input type="submit" name="show_events" value="Pokazi donore"/>
                            </select>
                   </form>';
               echo '</div>

            <div id="content00" class="toggle2" style="display:none">';
                    if(isset($_POST['show_events'])){
                        $id = $_POST['lokacije'];
                        $sql = "SELECT * from lokacija where idlokacija = '$id'";
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
            <div id="content1" class="toggle" style="display:none">
                <form action="" method="POST">
                    <br>Dodaj novi event:<br><br>
                    idlokacije <input type="number" name="idlokacija"><br><br>
                    Grad <input type="text" name="grad"><br><br>
                    Naziv lokacije <input type="text" name="grad"> <br><br>
                    Adresa <input type="text" name="adresa_lokacije"><br><br>
                    Poštanski broj<input type="text" name="postanski_broj"><br><br>
                    Datum<input type="date" name="datum_dogadaja"><br><br> 
                    <input type="submit" name="submit_event"><br><br>
                </form>
             </div>
             
             <div id="content2" class="toggle" style="display:none">';
                $query = "SELECT idlokacija, naziv_lokacije, datum_dogadaja FROM lokacija";
                $run = mysqli_query($conn, $query);
                echo"<br>Izbrisi neki event<br><br>";
                echo "<form action='' method='POST'>
                          <select name='lokacije'>";
                            while ($row = mysqli_fetch_array($run)) {
                            echo "<option value='" . $row['idlokacija'] ."'>" . $row['naziv_lokacije'] ."</option>";
                            }
                            echo  '<input type="submit" name="delete_event" value="Izbrisi">';
                           echo "</select>
                          </form>";
                echo'</div>

             <div id="content3" class="toggle" style="display:none">
                <p>Danas se može donirati na sljedećim lokacijama:</p>';
                $date = date("Ymd");
                $query = "SELECT idlokacija, naziv_lokacije, datum_dogadaja FROM lokacija where datum_dogadaja = '$date'";
                $run = mysqli_query($conn, $query);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

                echo "<form action='' method='POST'>
                            <select name='lok'>";
                            while ($row = mysqli_fetch_array($run)) {
                                echo "<option value='" . $row['idlokacija'] ."'>" . $row['naziv_lokacije'] ."</option>";
                            }
                            echo  '<input type="submit" name="show" value="Pokazi donore">';
                            echo "</select>
                          </form>";
            echo '</div>
            <div id="content30" class="toggle2"style="display:none">';
                if(isset($_POST['show'])){
                    $id = $_POST['lok'];
                    $sql = "SELECT OIB_donora, ime_prezime_donora from donor where OIB_donora in 
                            (SELECT OIB_donora_don from moj_event where id_lokacije='$id' and prisutnost='0')";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    echo "<form action='' method='POST'>
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
                    //unset($_POST['show']);
                }
            echo'</div>
            <div id="content31" class="toggle2">';
                    if(isset($_POST['odbij'])){
                        $OIB = $_POST['donacija'];
                        $id = $_POST['id_lokacije'];
                        $sql = "UPDATE moj_event SET prisutnost = '-1' WHERE OIB_donora_don = '$OIB' and id_lokacije='$id' and prisutnost = '0'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                    }
                    if(isset($_POST['doniraj'])){
                        $OIB = $_POST['donacija'];
                        $id = $_POST['id_lokacije'];
                        $sql = "SELECT *from donor where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);

                        echo'<form action="" method="POST">
                              <p>Dodaj novu donaciju</p>
                              Ime i prezime donora <input type="text" value="'.$row['ime_prezime_donora'].'" ><br><br>
                              OIB_donora <input type="text" name="OIB_don" value='.$row['OIB_donora'].'  ><br><br>
                              Krvna grupa donora <input type="text" name="krvna_grupa_don" value='.$row['krvna_grupa_don'].' ><br><br>
                              Količina krvi <input type="text" name="kol_krvi" step="0.01">  
                              <input type="hidden" name="id_lokacije" value='.$id.'>
                              <input type="submit" name="unesi_donaciju">
                            </form>';

                    }
                    if(isset($_POST['unesi_donaciju'])){
                        $OIB = $_POST['OIB_don'];
                        $id = $_POST['id_lokacije'];
                        $kol = $_POST['kol_krvi'];
                        $grupa = $_POST['krvna_grupa_don'];

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

                        //UPIT KOJI SINKRONIZIRA ZALIHU KRVI SA SVAKOM NOVOM DONACIJOM - KASNIJE ĆU

                    }
            echo '</div>
             <div id="content4" class="toggle" style="display:none">';
             /*   $query = "SELECT krvna_grupa_zal from zaliha_krvi";
                $run = mysqli_query($conn, $query);
                $result = $run or die ("Failed to query database". mysqli_error($conn));
                while($row = mysqli_fetch_array($run)) {
                    echo $row['krvna_grupa_zal'];
                }
                pizda mu materina
             */
            echo '</div>

            <div id="content5" class="toggle" style="display:none">Bolnički zahtjevi</div>
            <div id="content6" class="toggle" style="display:none">Postavke donora</div>
            <div id="content7" class="toggle" style="display:none">Obavijesti</div>
            
            <div id="content8" class="toggle" style="display:none">
            /** Previse mi se spava za pokusat skuzit ajax*/
                <script src=""http:/>/code.jquery.com/jquery-1.9.1.js"></script>
                <script>
                    function submit_form() {
                        
                    }
                </script>
            <br>
            <form method="post">
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
            <button type="button">Prikaži statistiku</button>
            </form><br>
            ';


            //kako bi znali za koj mjesec i godinu racunamo mjesecnu statistiku:
            $now = new \DateTime('now'); //ako zelimo sadasnjost
            $month = $now->format('m');
            $year = $now->format('Y');

            /**$month = $_POST['mjesec'];
            $year = $_POST['godina'];*/

            //broj odrzanih evenata u tom razdoblju:
            $sql = "select id_lokacije from moj_event where id_lokacije in (select idlokacija from lokacija where 
                                (select extract(year from datum_dogadaja)) = '$year' and 
                                (select extract(month from datum_dogadaja)) = '$month') group by id_lokacije";
            $result = mysqli_query($conn, $sql);
            $num_events = mysqli_num_rows($result);

            //broj prikupljenih donacija u tom razdoblju:
            $sql = "select OIB_donora_don from moj_event where id_lokacije in (select idlokacija from lokacija where 
                                                        (select extract(year from datum_dogadaja)) = '$year' and 
                                                        (select extract(month from datum_dogadaja)) = '$month') and 
                                                        prisutnost = 1";
            $result = mysqli_query($conn, $sql);
            $num_pdonation = mysqli_num_rows($result);

            //broj odbijenih donacija u tom razdoblju:
            $sql = "select OIB_donora_don from moj_event where id_lokacije in (select idlokacija from lokacija where 
                                                                    (select extract(year from datum_dogadaja)) = '$year' and 
                                                                    (select extract(month from datum_dogadaja)) = '$month') and 
                                                                     prisutnost != 1";
            $result = mysqli_query($conn, $sql);
            $num_odonation = mysqli_num_rows($result);

            //najvise krvne grupe u tom razdoblju:
            $sql = "select * from moj_event join donor on (OIB_donora = OIB_donora_don) where id_lokacije in (select idlokacija from lokacija where 
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
             </script>
        </html>';
?>