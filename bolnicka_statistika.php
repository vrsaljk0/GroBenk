<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<script>
    function Ulogirajme(){
        window.location.replace('boln_login.php');
    }
</script>

<?php
    require_once "dbconnect.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!$_SESSION['bolnica_loggedin']) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];
    $date = date("Ymd");
    $idbolnica = $_SESSION['id'];


    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
    $naziv_bolnice = $row['naziv_bolnice'];

    echo'
        <html>
             <head><title>Profil bolnice</title></head>
             <body>
                 <div id="info">
                    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="200" height="200"><br><br>
                
                 </div>
                 
                 <div id="linkovi">
                    <a href="posalji_zahtjev.php" >Pošalji zahtjev&nbsp;</a><br><br>
                    <a href="otkazi_zahtjev.php" >Otkazi zahtjev&nbsp;</a><br><br>
                    <a href="bolnicka_statistika.php">&nbsp;Statistika&nbsp;</a><br><br>
                    <a href="bolnicke_postavke.php">&nbsp;Postavke&nbsp;</a><br><br>
                    <a href="forum.php">&nbsp;Forum&nbsp;</a><br><br>
                    <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>                          
                 </div>';

                    if(isset($_POST['prikazi'])){

                    $datum = date('Y-m-d');
                    $year = $_POST['godina'];
                    if ($year == 0) goto jump;
                    echo '<h2>Statistika za '.$year.'.godinu:</h2>';

                    /***KRVNE GRUPE-ZAHTJEVI**/
                    $nemaKrvi = 0;
                    $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                    $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
                    $kol_krvip = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                    /***KOLICINE ZATRAŽENIH KRVNIH GRUPA***/
                    for ($i=0; $i<8; $i++) {
                        $sql = "select sum(kolicina_krvi_zaht) as suma from zahtjev where krvna_grupa_zaht='$krv[$i]' and id_bolnica='$idbolnica' and  
                                (select year (datum_zahtjeva)) = '$year' and datum_zahtjeva < '$datum' group by krvna_grupa_zaht";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        if ($row['suma'] == null) {
                            $kol_krvi[$i] = '0';
                        } else {
                            $kol_krvi[$i] = $row['suma'];
                            $kol_krvi[$i] = number_format((float)$kol_krvi[$i], 2, '.', '');
                            $nemaKrvi = 1;
                        }
                    }

                    /***UKUPNO PRIMLJENO KRVI***/
                    $nemaPrim = 0;
                        for ($i=0; $i<8; $i++) {
                            $sql = "select sum(kolicina_krvi_zaht) as suma from zahtjev where krvna_grupa_zaht='$krv[$i]' and id_bolnica='$idbolnica' and  
                                (select year (datum_zahtjeva)) = '$year' and datum_zahtjeva < '$datum' and odobreno = '1' group by krvna_grupa_zaht";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if ($row['suma'] == null) {
                                $kol_krvip[$i] = '0';
                            } else {
                                $kol_krvip[$i] = $row['suma'];
                                $kol_krvip[$i] = number_format((float)$kol_krvip[$i], 2, '.', '');
                                $nemaPrim = 1;
                            }
                        }
                    /*** ZAHTJEVI***/

                    $odobreni = 0;
                    $odbijeni = 0;
                    $nacekanju = 0;
                    $nemaZah = 0;

                    $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and (select year (datum_zahtjeva)) = '$year' and odobreno = '1'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $odobreni = $row['suma'];

                    $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and (select year (datum_zahtjeva)) = '$year' and odobreno = '-1'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $odbijeni = $row['suma'];

                    $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and (select year (datum_zahtjeva)) = '$year' and odobreno = '0'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $nacekanju = $row['suma'];

                    if (($odobreni + $odbijeni + $nacekanju)==0) $nemaZah = 1;

                    } else {
                        jump:
                        $datum = date('Y-m-d');

                        echo '<h2>Generalna statistika:</h2>';

                        /***KRVNE GRUPE-ZAHTJEVI**/
                        $nemaKrvi = 0;
                        $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                        /***KOLICINE ZATRAŽENIH KRVNIH GRUPA***/
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
                        for ($i=0; $i<8; $i++) {
                            $sql = "select sum(kolicina_krvi_zaht) as suma from zahtjev where krvna_grupa_zaht='$krv[$i]' and id_bolnica='$idbolnica' and  
                                datum_zahtjeva < '$datum' group by krvna_grupa_zaht";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if ($row['suma'] == null) {
                                $kol_krvi[$i] = '0';
                            } else {
                                $kol_krvi[$i] = $row['suma'];
                                $kol_krvi[$i] = number_format((float)$kol_krvi[$i], 2, '.', '');
                                $nemaKrvi = 1;
                            }
                        }

                        /***UKUPNO PRIMLJENO KRVI***/
                        $nemaPrim = 0;
                        $kol_krviP = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
                        for ($i=0; $i<8; $i++) {
                            $sql = "select sum(kolicina_krvi_zaht) as suma from zahtjev where krvna_grupa_zaht='$krv[$i]' and id_bolnica='$idbolnica' and  
                                datum_zahtjeva < '$datum' and odobreno = '1' group by krvna_grupa_zaht";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);

                            if ($row['suma'] == null) {
                                $kol_krvip[$i] = '0';
                            } else {
                                $kol_krvip[$i] = $row['suma'];
                                $kol_krvip[$i] = number_format((float)$kol_krvi[$i], 2, '.', '');
                                $nemaPrim = 1;
                            }
                        }

                        /*** ZAHTJEVI***/

                        $odobreni = 0;
                        $odbijeni = 0;
                        $nacekanju = 0;
                        $nemaZah = 0;

                        $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and odobreno = '1'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $odobreni = $row['suma'];

                        $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and odobreno = '-1'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $odbijeni = $row['suma'];

                        $sql = "select count(idzahtjev) as suma from zahtjev where datum_zahtjeva < '$datum' and odobreno = '0'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $nacekanju = $row['suma'];

                        if (($odobreni + $odbijeni + $nacekanju)==0) $nemaZah = 1;

                    }

                    echo'<table border="1">
                          <tr>';
                            $i = 0;
                            for ($i=0; $i<8; $i++) {
                                echo $krv[$i];
                                echo $kol_krvi[$i];
                                echo'<br>';
                            }
                          echo'</tr>
                        </table>
                        
                <form method="post" action="">
                <br>
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
                </form>';
                ?>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load("current", {"packages":["corechart"]});
                      google.charts.setOnLoadCallback(drawChart);
                
                      function drawChart() {
                            
                          var Apoz = <?php echo $kol_krvi[0]?>;
                          var Aneg = <?php echo $kol_krvi[1]?>;
                          var Bpoz = <?php echo $kol_krvi[2]?>;
                          var Bneg = <?php echo $kol_krvi[3]?>;
                          var ABpoz = <?php echo $kol_krvi[4]?>;
                          var ABneg = <?php echo $kol_krvi[5]?>;
                          var Opoz = <?php echo $kol_krvi[6]?>;
                          var Oneg = <?php echo $kol_krvi[7]?>;
                          var nemaKr = <?php echo $nemaKrvi?>;

                          if (nemaKr == 1) {
                              nemaKr = 0;
                          } else {
                              nemaKr = 1;
                          }
                        var data = google.visualization.arrayToDataTable([
                          ['Krvna grupa', 'Kolicina'],
                          ["A+", Apoz],
                          ["A-", Aneg],
                          ["B+", Bpoz],
                          ["B-", Bneg],
                          ["AB+", ABpoz],
                          ["AB-", ABneg],
                          ["0+", Opoz],
                          ["0-", Oneg],
                          ["Nema podataka", nemaKr]
                        ]);
                
                        var options = {
                          title: "Ukupno zatraženo"
                        };
                        var chart = new google.visualization.PieChart(document.getElementById("krv"));
                        chart.draw(data, options);

                          var odobreni = <?php echo $odobreni?>;
                          var odbijeni = <?php echo $odbijeni?>;
                          var nacekanju = <?php echo $nacekanju?>;
                          var nemaZah = <?php echo $nemaZah?>;

                          var data = google.visualization.arrayToDataTable([
                              ['Krvna grupa', 'Kolicina'],
                              ["Odobreni", odobreni],
                              ["Odbijeni", odbijeni],
                              ["Na čekanju", nacekanju],
                              ["Nema podataka", nemaZah]
                          ]);

                          var options = {
                              title: "Poslani zahtjevi"
                          };
                          var chart = new google.visualization.PieChart(document.getElementById("zahtjev"));
                          chart.draw(data, options);

                          var Apoz = <?php echo $kol_krvip[0]?>;
                          var Aneg = <?php echo $kol_krvip[1]?>;
                          var Bpoz = <?php echo $kol_krvip[2]?>;
                          var Bneg = <?php echo $kol_krvip[3]?>;
                          var ABpoz = <?php echo $kol_krvip[4]?>;
                          var ABneg = <?php echo $kol_krvip[5]?>;
                          var Opoz = <?php echo $kol_krvip[6]?>;
                          var Oneg = <?php echo $kol_krvip[7]?>;
                          var nemaPrim = <?php echo $nemaKrvi?>;

                          if (nemaPrim == 1) {
                              nemaPrim = 0;
                          } else {
                              nemaPrim = 1;
                          }
                          var data = google.visualization.arrayToDataTable([
                              ['Krvna grupa', 'Kolicina'],
                              ["A+", Apoz],
                              ["A-", Aneg],
                              ["B+", Bpoz],
                              ["B-", Bneg],
                              ["AB+", ABpoz],
                              ["AB-", ABneg],
                              ["0+", Opoz],
                              ["0-", Oneg],
                              ["Nema podataka", nemaKr]
                          ]);

                          var options = {
                              title: "Primljene zalihe"
                          };
                          var chart = new google.visualization.PieChart(document.getElementById("primljeno"));
                          chart.draw(data, options);
                      }
                
                
                    </script>
                
                    <table>
                        <tr>
                            <td><div id="krv" style="width: 400px; height: 225px;"></div></td>
                            <td><div id="zahtjev" style="width: 400px; height: 225px;"></div></td>
                            <td><div id="primljeno" style="width: 400px; height: 225px;"></div></td>
                        </tr>
                    </table>    
    
             </body>


