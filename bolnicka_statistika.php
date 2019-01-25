<script src="http://code.jquery.com/jquery-latest.js"></script>
<?php
    require_once "dbconnect.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!isset($_SESSION['bolnica_loggedin'])) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];
    $date = date("Ymd");
    $idbolnica = $_SESSION['id'];


    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
    $naziv_bolnice = $row['naziv_bolnice'];

   echo '
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>BloodBank</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
          <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
          <link href="style.css" rel="stylesheet">
          <link href="bolnica_zahtjevstyle.css" rel="stylesheet">
      </head>';

      echo "
      <div id='nav-placeholder' onload>
      </div> 

      <script>
      $(function(){
        $('#nav-placeholder').load('bolnicanavbar.php');
      });
      </script>";

  echo' 
   <div class="profil-img">
      <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
      <div class="profil-info">
          <div class="profil-content">
              <ul class="nav nav-tabs" id="myTab" >
                  <li class="nav-item">
                        <a class="nav-link" href="bolnicaopcenito.php">Općenito</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="forum.php">Forum</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="posalji_zahtjev.php">Pošalji zahtjev</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="otkazi_zahtjev.php">Otkaži zahtjev</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link active" href="bolnicka_statistika.php">Statistika</a>
                  </li>
              </ul>
          </div>

          <div class="col-md-8">';

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

                    echo'
                        
                <form method="post" action="">
                <br>
                <span class="select">
                <select id="godina" name="godina">
                <option value="0">-odaberi godinu-</option>';

                    $now = new \DateTime('now');
                    $years = $now->format('Y')-4;
                    for ($i = 0; $i < 5; $i++) {
                        echo '<option value='.$years.'>-'.$years.'.godina-</option>';
                        $years++;
                    }
                echo '</select></span> <br>
                <input type="submit" class="zbtn" name="prikazi" value="Prikaži">
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
          </div>
      </div>
  </div>

                    