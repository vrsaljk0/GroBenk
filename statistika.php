<?php
    require_once ("dbconnect.php");
    session_start();
    if (!$_SESSION['admin_loggedin']) header("Location:denied_permission.php");

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
                    $datum = date('Y-m-d');
                    $year = $_GET['godina'];

                        /** ZALIHA KRVI*/
                        $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                        for ($i=0; $i<8; $i++) {
                            $sql = "select sum(kolicina_krvi_donacije) as suma from donacija where krvna_grupa_zal='$krv[$i]' 
                                        and (select extract(year from (select datum_dogadaja from lokacija where id_lokacije = idlokacija and datum_dogadaja < '$datum'))) = '$year' 
                                        group by krvna_grupa_zal";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            if ($row['suma'] == null) {
                                $kol_krvi[$i] = '0';
                            } else {
                                $kol_krvi[$i] = $row['suma'];
                            }

                        }

                        /** TOP 3 GRADA ZA EVENTE I OSTATAK*/
                        $sql = "select count(id_lokacije) as suma, grad from lokacija where extract(year from datum_dogadaja) = '$year'  
                                and datum_dogadaja < '$datum' group by grad order by suma desc limit 3";
                        $result = mysqli_query($conn, $sql);

                        $i = 0;
                        $suma = 0;

                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $lokacija[$i]['grad'] = $row['grad'];
                            $lokacija[$i]['suma'] = $row['suma'];
                            $i++;
                            $suma += $row['suma'];
                        }

                        $sql = "select count(id_lokacije) as suma from lokacija where extract(year from datum_dogadaja) = '$year' and datum_dogadaja < '$datum'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        
                        $lokacija[3]['grad'] = 'ostalo';
                        $lokacija[3]['suma'] = $row['suma'] - $suma;

                        /**BROJ DONACIJA USPJESNIH/ODBIJENIH/NISU_DOSLI DO SAD*/
                        $datum = date('Y-m-d');


                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                               (select extract(year from (select datum_dogadaja from lokacija where lokacija.id_lokacije = moj_event.id_lokacije))) = '$year' ) 
                                and (select datum_dogadaja from lokacija where datum_dogadaja < '$datum' and lokacija.id_lokacije = moj_event.id_lokacije) and prisutnost = 1";
                        $result = mysqli_query($conn, $sql);
                        $donirali = mysqli_num_rows($result);

                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                                                   (select extract(year from (select datum_dogadaja from lokacija where lokacija.id_lokacije = moj_event.id_lokacije))) = '$year' ) 
                                                    and (select datum_dogadaja from lokacija where datum_dogadaja < '$datum' and lokacija.id_lokacije = moj_event.id_lokacije) and prisutnost = -1";
                        $result = mysqli_query($conn, $sql);
                        $odbijeni = mysqli_num_rows($result);

                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where 
                                                   (select extract(year from (select datum_dogadaja from lokacija where lokacija.id_lokacije = moj_event.id_lokacije))) = '$year' ) 
                                                    and (select datum_dogadaja from lokacija where datum_dogadaja < '$datum' and lokacija.id_lokacije = moj_event.id_lokacije) and prisutnost = 0";
                        $result = mysqli_query($conn, $sql);
                        $nisu_dosli = mysqli_num_rows($result);

                        echo'<br><h3>Statistika za '.$year.' .godinu:</h3>';

                    } else {

                        /** ZALIHA KRVI*/
                        $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                        for ($i=0; $i<8; $i++) {
                            $sql = "select sum(kolicina_krvi_donacije) as suma from donacija where krvna_grupa_zal='$krv[$i]' 
                                    group by krvna_grupa_zal";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            if ($row['suma'] == null) {
                                $kol_krvi[$i] = '0';
                            } else {
                                $kol_krvi[$i] = $row['suma'];
                            }

                        }

                        /** TOP 3 GRADA ZA EVENTE I OSTATAK*/
                        $sql = "select count(id_lokacije) as suma, grad from lokacija group by grad order by suma desc limit 3";
                        $result = mysqli_query($conn, $sql);

                        $i = 0;
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $lokacija[$i]['grad'] = $row['grad'];
                            $lokacija[$i]['suma'] = $row['suma'];
                            $i++;
                        }

                        $sql = "select count(id_lokacije) as suma from lokacija where 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $lokacija[3]['grad'] = 'ostalo';
                        $lokacija[3]['suma'] = $row['suma'] - $lokacija[0]['suma'] - $lokacija[1]['suma'] - $lokacija[2]['suma'];

                        /**BROJ DONACIJA USPJESNIH/ODBIJENIH/NISU_DOSLI DO SAD*/
                        $datum = date('Y-m-d');


                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where datum_dogadaja < '$datum') and 
                                                                                            prisutnost = 1";
                        $result = mysqli_query($conn, $sql);
                        $donirali = mysqli_num_rows($result);

                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where datum_dogadaja < '$datum') and 
                                                                                                                    prisutnost = -1";
                        $result = mysqli_query($conn, $sql);
                        $odbijeni = mysqli_num_rows($result);

                        $sql = "select OIB_donora_don from moj_event where id_lokacije in (select id_lokacije from lokacija where datum_dogadaja < '$datum') and 
                                                                                                                    prisutnost = 0";
                        $result = mysqli_query($conn, $sql);
                        $nisu_dosli = mysqli_num_rows($result);

                    echo'<br><h3>Generalna statistika</h3>';
                }



                echo'
            
            <br>
            <form method="GET" action="">
                <select id="godina" name="godina">
                <option value="0">-odaberi godinu-</option>';

                $now = new \DateTime('now');
                $years = $now->format('Y')-4;
                for ($i = 0; $i < 5; $i++) {
                    echo '<option value='.$years.'>-'.$years.'.godina-</option>';
                    $years++;
                }
                ?>
            </select> <br>
            <input type="submit" name="prikazi" value="prikazi">
            </form></div><br>

    <!-- maznula odavde: https://developers.google.com/chart/interactive/docs/gallery/piechart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
            
          var Apoz = <?php echo $kol_krvi[0]; ?>;
          var Aneg = <?php echo $kol_krvi[1]?>;
          var Bpoz = <?php echo $kol_krvi[2]?>;
          var Bneg = <?php echo $kol_krvi[3]?>;
          var ABpoz = <?php echo $kol_krvi[4]?>;
          var ABneg = <?php echo $kol_krvi[5]?>;
          var Opoz = <?php echo $kol_krvi[6]?>;
          var Oneg = <?php echo $kol_krvi[7]?>;

        var data = google.visualization.arrayToDataTable([
          ['Krvna grupa', 'Kolicina'],
          ["A+", Apoz],
          ["A-", Aneg],
          ["B+", Bpoz],
          ["B-", Bneg],
          ["AB+", ABpoz],
          ["AB-", ABneg],
          ["0+", Opoz],
          ["0-", Oneg]
        ]);

        var options = {
          title: "Prikupljeno krvi"
        };
        var chart = new google.visualization.PieChart(document.getElementById("krv"));
        chart.draw(data, options);

          var suma0 = <?php echo $lokacija[0]['suma']; ?>;
          var suma1 = <?php echo $lokacija[1]['suma']; ?>;
          var suma2 = <?php echo $lokacija[2]['suma']; ?>;
          var suma3 = <?php echo $lokacija[3]['suma']; ?>;

          var lok0 = "<?php echo $lokacija[0]['grad']; ?>";
          var lok1 = "<?php echo $lokacija[1]['grad']; ?>";
          var lok2 = "<?php echo $lokacija[2]['grad']; ?>";
          var lok3 = "<?php echo $lokacija[3]['grad']; ?>";

      var data = google.visualization.arrayToDataTable([
          ['Grad', 'Postotak'],
          [lok0, suma0],
          [lok1, suma1],
          [lok2, suma2],
          [lok3, suma3]
      ]);

      var options = {
          title: "Lokacije evenata"
      };
      var chart = new google.visualization.PieChart(document.getElementById("lokacije"));
      chart.draw(data, options);

          var donirali = <?php echo $donirali; ?>;
          var odbijeni = <?php echo $odbijeni; ?>;
          var nisudosli = <?php echo $nisu_dosli; ?>;

          var data = google.visualization.arrayToDataTable([
              ['tekst', 'broj'],
              ["Donirali", donirali],
              ["Odbijeni", odbijeni],
              ["Nisu došli", nisudosli],
          ]);

          var options = {
              title: "Prijavljeni donori"
          };
          var chart = new google.visualization.PieChart(document.getElementById("donacije"));
          chart.draw(data, options);

      }


    </script>

    <table>
        <tr>
            <td><div id="krv" style="width: 400px; height: 225px;"></div></td>
            <td><div id="lokacije" style="width: 400px; height: 225px;"></div></td>
            <td><div id="donacije" style="width: 400px; height: 225px;"></div></td>
        </tr>
    </table>



        </html>
