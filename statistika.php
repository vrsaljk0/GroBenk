<?php
    require_once "dbconnect.php";
    session_start();

    echo"Dobrodošao admine!";

    echo '
        <html>
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
               <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
           </div>';

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

                        echo'<br>Statistika za '.$month.'.mjesec '.$year.' .godine:';
                    } else {

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
                    echo'Generalna statistika:';
                }



                echo'
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

        </html>';
?>