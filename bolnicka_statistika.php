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
                 </div>
                  <div id="content2">
                  </br> Generalna statistika:';

                    $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica'";
                    $result = mysqli_query($conn, $sql);
                    $num_zahtjev= mysqli_num_rows($result);

                    $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica' and odobreno = '1'";
                    $result = mysqli_query($conn, $sql);
                    $num_odobreni= mysqli_num_rows($result);

                    $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica' and odobreno = '-1'";
                    $result = mysqli_query($conn, $sql);
                    $num_odbijeni= mysqli_num_rows($result);

                    $sql = "select * from zahtjev where id_bolnica = '$idbolnica' group by krvna_grupa_zaht order by krvna_grupa_zaht desc limit 1";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $naj_krvnag = $row['krvna_grupa_zaht'];

                    $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                    $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                    for ($i=0; $i<8; $i++) {
                        $sql = "select round(sum(kolicina_krvi_zaht)) as suma from zahtjev where id_bolnica = '$idbolnica' and krvna_grupa_zaht='$krv[$i]' group by krvna_grupa_zaht";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        if ($row['suma'] == null) {
                            $kol_krvi[$i] = '0';
                         } else {
                                $kol_krvi[$i] = $row['suma'];
                        }

                    }

                    echo'<table border="1">
                          <tr>
                            <th>Poslani zahtjevi</th>
                            <td>'.$num_zahtjev.'</td> 
                          </tr>
                          <tr>
                            <th>Odobreni zahtjevi</th>
                            <td>'.$num_odobreni.'</td> 
                          </tr>
                          <tr>
                            <th>Odbijeni zahtjevi</th>
                            <td>'.$num_odbijeni.'</td> 
                          </tr>
                          <tr>
                            <th>Najviše je bilo potrebno krvne grupe:</th>
                            <td>'.$naj_krvnag.'</td> 
                          </tr>
                        </table>
                        <br>Ukupno zatraženo:
                        <table border="1">
                          <tr>
                            <th>A+</th>
                            <td>'.$kol_krvi[0].' L</td> 
                            <th>A-</th>
                            <td>'.$kol_krvi[1].' L</td> 
                          </tr>
                          <tr>
                            <th>B+</th>
                            <td>'.$kol_krvi[2].' L</td> 
                            <th>B-</th>
                            <td>'.$kol_krvi[3].' L</td> 
                          </tr>
                          <tr>
                            <th>AB+</th>
                            <td>'.$kol_krvi[4].' L</td> 
                            <th>AB-</th>
                            <td>'.$kol_krvi[5].' L</td> 
                          </tr>
                          <tr>
                            <th>0+</th>
                            <td>'.$kol_krvi[6].' L</td> 
                            <th>0-</th>
                            <td>'.$kol_krvi[7].' L</td> 
                          </tr>
                        </table>
                  <form method="post" action=""">
            
                <br>
                <select id="mjesec" name="mjesec">
                <option value="0">-odaberi mjesec-</option>';
                    $mjesec = 1;
                    $mjesec_array = array("siječanj", "veljača", "ožujak", "travanj", "svibanj", "lipanj", "srpanj", "kolovoz", "rujan", "listopad", "studeni", "prosinac");
                    for ($i = 0; $i < 12; $i++) {
                        echo '<option value ='.$mjesec.'>-'.$mjesec_array[$i].'-</option>';
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
                </form>
                
                </div>
                  
                <div id="content20">';
                    if(isset($_POST['prikazi'])){
                        $month = $_POST['mjesec'];
                        $year = $_POST['godina'];

                        $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica' 
                                and (select extract(year from datum_zahtjeva)) = '$year' and (select extract(month from datum_zahtjeva)) = '$month'";
                        $result = mysqli_query($conn, $sql);
                        $num_zahtjev= mysqli_num_rows($result);

                        $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica' and odobreno = '1'
                                and (select extract(year from datum_zahtjeva)) = '$year' and (select extract(month from datum_zahtjeva)) = '$month'";
                        $result = mysqli_query($conn, $sql);
                        $num_odobreni= mysqli_num_rows($result);

                        $sql = "select id_bolnica from zahtjev where id_bolnica = '$idbolnica' and odobreno = '-1'
                                and (select extract(year from datum_zahtjeva)) = '$year' and (select extract(month from datum_zahtjeva)) = '$month'";
                        $result = mysqli_query($conn, $sql);
                        $num_odbijeni= mysqli_num_rows($result);

                        $sql = "select * from zahtjev where id_bolnica = '$idbolnica' and (select extract(year from datum_zahtjeva)) = '$year' and (select extract(month from datum_zahtjeva)) = '$month'
                                group by krvna_grupa_zaht order by krvna_grupa_zaht desc limit 1";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $naj_krvnag = $row['krvna_grupa_zaht'];

                        $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
                        $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

                        for ($i=0; $i<8; $i++) {
                            $sql = "select round(sum(kolicina_krvi_zaht)) as suma from zahtjev where id_bolnica = '$idbolnica' and krvna_grupa_zaht='$krv[$i]' 
                                    and (select extract(year from datum_zahtjeva)) = '$year' and (select extract(month from datum_zahtjeva)) = '$month' group by krvna_grupa_zaht";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            if ($row['suma'] == null) {
                                $kol_krvi[$i] = '0';
                            } else {
                                $kol_krvi[$i] = $row['suma'];
                            }

                        }

                        echo'Statistika za '.$month.'.mjesec '.$year.'. godine:
                            <table border="1">
                          <tr>
                            <th>Poslani zahtjevi</th>
                            <td>'.$num_zahtjev.'</td> 
                          </tr>
                          <tr>
                            <th>Odobreni zahtjevi</th>
                            <td>'.$num_odobreni.'</td> 
                          </tr>
                          <tr>
                            <th>Odbijeni zahtjevi</th>
                            <td>'.$num_odbijeni.'</td> 
                          </tr>
                          <tr>
                            <th>Najviše je bilo potrebno krvne grupe:</th>
                            <td>'.$naj_krvnag.'</td> 
                          </tr>
                        </table>
                        <br>Zatraženo:
                        <table border="1">
                          <tr>
                            <th>A+</th>
                            <td>'.$kol_krvi[0].' L</td> 
                            <th>A-</th>
                            <td>'.$kol_krvi[1].' L</td> 
                          </tr>
                          <tr>
                            <th>B+</th>
                            <td>'.$kol_krvi[2].' L</td> 
                            <th>B-</th>
                            <td>'.$kol_krvi[3].' L</td> 
                          </tr>
                          <tr>
                            <th>AB+</th>
                            <td>'.$kol_krvi[4].' L</td> 
                            <th>AB-</th>
                            <td>'.$kol_krvi[5].' L</td> 
                          </tr>
                          <tr>
                            <th>0+</th>
                            <td>'.$kol_krvi[6].' L</td> 
                            <th>0-</th>
                            <td>'.$kol_krvi[7].' L</td> 
                          </tr>
                        </table>';
                    }
             echo '</body>';

?>