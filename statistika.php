<script src="http://code.jquery.com/jquery-latest.js"></script>

<SCRIPT language="javascript">
    $(function(){

        $("#select_all").click(function () {
            $('.case').prop('checked', this.checked);
        });

        $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
                $("#select_all").prop("checked", "checked");
            } else {
                $("#select_all").removeProp("checked");
            }

        });
    });
</SCRIPT>

<?php

require_once ("dbconnect.php");
session_start();
mysqli_set_charset($conn,"utf8");

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");

echo '
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BloodBank</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <link href="style.css" rel="stylesheet">
        <link href="adminstyle.css" rel="stylesheet">
    </head>';

    echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('adminnavbar.php');
    });
    </script>";

echo '
<div class="admin-content" >
        <ul class="nav nav-tabs" id="myTab" style="width:1050px;margin-left: -140px">
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Pretraži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dodajbolnicu.php">Dodaj bolnicu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pregled.php">Pregled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/GroBenk-Vol2/donacije.php?keyword=&trazi=Tra%C5%BEi">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>
<div style="margin-left:20%;" class="col-md-8">';
if(isset($_GET['prikazi'])){
                    $datum = date('Y-m-d');
                    $year = $_GET['godina'];
                    if ($year == 0) goto jump;
                        /** ZALIHA KRVI*/
                        $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
                        $nemaKrvi = 0;
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
                                $nemaKrvi = 1;
                            }
                        }
                      if ($nemaKrvi == 0) {
                          $nemaKrvi = 1;
                      } else {
                          $nemaKrvi = 0;
                      }

                        /** TOP 3 GRADA ZA EVENTE I OSTATAK*/

                        /** HARDCODE SRY*/
                      $lokacija[0]['grad'] = " ";
                      $lokacija[1]['grad'] = " ";
                      $lokacija[2]['grad'] = " ";
                      $lokacija[3]['grad'] = " ";
                      $lokacija[0]['suma'] = 0;
                      $lokacija[1]['suma'] = 0;
                      $lokacija[2]['suma'] = 0;
                      $lokacija[3]['suma'] = 0;

                        $nemaEvenata = 0;
                        $sql = "select count(id_lokacije) as suma, grad from lokacija where extract(year from datum_dogadaja) = '$year'  
                                and datum_dogadaja < '$datum' group by grad order by suma desc limit 3";
                        $result = mysqli_query($conn, $sql);

                        $i = 0;
                        $suma = 0;
                        $nemaEvenata = mysqli_num_rows($result);

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

                          if (($nisu_dosli + $odbijeni + $donirali) == 0) {
                              $nemaDonora = 1;
                          } else {
                              $nemaDonora = 0;
                          }

                        echo'<br><h2 style="margin-left: -16px"">Statistika za '.$year.' .godinu:</h2><br>';

                    } else {
                        jump:
                        /** ZALIHA KRVI*/
                        $nemaKrvi = 0;
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
                                $nemaKrvi = 1;
                            }
                        }
                      if ($nemaKrvi == 0) {
                          $nemaKrvi = 1;
                      } else {
                          $nemaKrvi = 0;
                      }

                        /** TOP 3 GRADA ZA EVENTE I OSTATAK*/
                      /** HARDCODE SRY*/
                      $lokacija[0]['grad'] = " ";
                      $lokacija[1]['grad'] = " ";
                      $lokacija[2]['grad'] = " ";
                      $lokacija[3]['grad'] = " ";
                      $lokacija[0]['suma'] = 0;
                      $lokacija[1]['suma'] = 0;
                      $lokacija[2]['suma'] = 0;
                      $lokacija[3]['suma'] = 0;

                        $sumaa = 0;
                        $nemaEvenata = 0;
                        $sql = "select count(id_lokacije) as suma, grad from lokacija group by grad order by suma desc limit 3";
                        $result = mysqli_query($conn, $sql);

                        $i = 0;

                      $nemaEvenata = mysqli_num_rows($result);

                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $lokacija[$i]['grad'] = $row['grad'];
                            $lokacija[$i]['suma'] = $row['suma'];
                            $i++;
                            $sumaa += $row['suma'];
                        }

                        $sql = "select count(id_lokacije) as suma from lokacija where 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $lokacija[3]['grad'] = 'ostalo';
                        $lokacija[3]['suma'] = $row['suma'] - $sumaa;


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

                        if (($nisu_dosli + $odbijeni + $donirali) == 0) {
                            $nemaDonora = 1;
                        } else {
                            $nemaDonora = 0;
                        }

                    echo'<br><h2 style="margin-left: -16px">Generalna statistika</h2><br>';
                }



                echo'
            
            
            <form method="GET" action="">
            <span class="select_statistika" style="margin-left: -16px;">
                <select id="godina" name="godina">
                <option value="0">Odaberi godinu</option>';
                $now = new \DateTime('now');
                $years = $now->format('Y')-4;
                for ($i = 0; $i < 5; $i++) {
                    echo '<option value='.$years.'>-'.$years.'.godina-</option>';
                    $years++;
                }
                ?>
                </select>
            </span>
            <input type="submit" class="zbtn" name="prikazi" value="Prikaži" style="position: absolute;height:48px">
            </form></div><br>

    <!-- maznula odavde: https://developers.google.com/chart/interactive/docs/gallery/piechart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
            
          var Apoz = <?php echo $kol_krvi[0]?>;;
          var Aneg = <?php echo $kol_krvi[1]?>;
          var Bpoz = <?php echo $kol_krvi[2]?>;;
          var Bneg = <?php echo $kol_krvi[3]?>;
          var ABpoz = <?php echo $kol_krvi[4]?>;
          var ABneg = <?php echo $kol_krvi[5]?>;;
          var Opoz = <?php echo $kol_krvi[6]?>;
          var Oneg = <?php echo $kol_krvi[7]?>;
          var nemaKr = <?php echo $nemaKrvi?>;

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
          title: "Prikupljeno krvi"
        };
        var chart = new google.visualization.PieChart(document.getElementById("krv"));
        chart.draw(data, options);

          var nemaEv = <?php echo $nemaEvenata?>;

          if (nemaEv == 0) {
              var data = google.visualization.arrayToDataTable([
                  ['Grad', 'Postotak'],
                  ["Nema podataka", 1]
              ]);

              var options = {
                  title: "Lokacije evenata"
              };

              var chart = new google.visualization.PieChart(document.getElementById("lokacije"));
              chart.draw(data, options);

          }
          if (nemaEv != 0){
              var suma0 = 0 + <?php echo $lokacija[0]['suma']; ?>;
              var suma1 = 0 + <?php echo $lokacija[1]['suma']; ?>;
              var suma2 = 0 + <?php echo $lokacija[2]['suma']; ?>;
              var suma3 = 0 + <?php echo $lokacija[3]['suma']; ?>;

              var lok0a = "<?php echo $lokacija[0]['grad']; ?>";
              var lok1a = "<?php echo $lokacija[1]['grad']; ?>";
              var lok2a = "<?php echo $lokacija[2]['grad']; ?>";
              var lok3a = "<?php echo $lokacija[3]['grad']; ?>";

              var data = google.visualization.arrayToDataTable([
                  ['Grad', 'Postotak'],
                  [lok0a, suma0],
                  [lok1a, suma1],
                  [lok2a, suma2],
                  [lok3a, suma3],
                  ["Nema podataka", 0]
              ]);

              var options = {
                  title: "Lokacije evenata"
              };

              var chart = new google.visualization.PieChart(document.getElementById("lokacije"));
              chart.draw(data, options);
          }

          var donirali = <?php echo $donirali; ?>;
          var odbijeni = <?php echo $odbijeni; ?>;
          var nisudosli = <?php echo $nisu_dosli; ?>;
          var nemaDo = <?php echo $nemaDonora ?>;

          var data = google.visualization.arrayToDataTable([
              ['tekst', 'broj'],
              ["Donirali", donirali],
              ["Odbijeni", odbijeni],
              ["Nisu došli", nisudosli],
              ["Nema podataka", nemaDo]
          ]);

          var options = {
              title: "Prijavljeni donori"
          };
          var chart = new google.visualization.PieChart(document.getElementById("donacije"));
          chart.draw(data, options);

      }


    </script>

    <table style="margin-left:15%;">
        <tr>
            <td><div id="krv" style="margin-left:60px;width: 400px; height: 225px;"></div></td>
            <td><div id="lokacije" style="margin-left:60px;width: 400px; height: 225px;"></div></td>
            <td><div id="donacije" style="margin-left:60px;width: 400px; height: 225px;"></div></td>
        </tr>
    </table>
</div>
<div style="height:200px;">
</div>
</html>
