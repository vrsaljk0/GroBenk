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
    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];
    $date = date("Ymd");
    $idbolnica = $_GET['idbolnice'];


    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);

    if(isset($_POST['posalji_zahtjev'])){
        $kolicina = $_POST['kolicina'];
        $krvna_grupa = $_POST['grupa'];
        $sql = "INSERT INTO zahtjev (id_bolnica, kolicina_krvi_zaht, krvna_grupa_zaht, datum_zahtjeva, odobreno) values ('$id_bolnica', '$kolicina', '$krvna_grupa', '$date', '0')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if(isset($_POST['otkazi_zahtjev'])){
        $id = $_POST['zahtjev'];
        //echo $id;
        $sql = "DELETE FROM zahtjev WHERE idzahtjev='$id'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if(isset($_POST['komentar'])){
        $tekst = $_POST['tekst'];
        $sql = "INSERT INTO komentari values ('$naziv_bolnice', '$id_bolnice', '$tekst', '$date')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    echo'
        <html>
             <head><title>Profil bolnice</title></head>
             <body>
                 <div id="info">
                    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="200" height="200"><br><br>
                
                 </div>
                 <div id="nav">
                    <a href="#content0" >Pošalji zahtjev&nbsp;</a><br><br>
                    <a href="#content1" >Otkazi zahtjev&nbsp;</a><br><br>
                    <a href="#content2">&nbsp;Statistika&nbsp;</a><br><br>
                    <a href="#content3">&nbsp;Postavke&nbsp;</a><br><br>
                    <a href="#content4">&nbsp;Forum&nbsp;</a><br><br>
                    <a href="" onclick="OdjaviMe();">&nbsp;Odjavi se&nbsp;</a>                          
                  </div>
                  <div id="content0" class="toggle" style="display:none" align="center">
                    Pošalji novi zahtjev
                    <form action="" method="POST">
                        Kolicina potrebne krvi <input type="number" name="kolicina" step="0.01"><br><br>
                        Krvna grupa <input type="text" name="grupa"><br><br>
                        <input type="submit" name="posalji_zahtjev" value="Posalji zahtjev">
                    </form>
                  </div>
                  <div id="content1" class="toggle" style="display:none" align="center">
                    Otkazi zahtjev';
                    $query = "SELECT *from zahtjev WHERE id_bolnica='$idbolnica' and  odobreno='0'";
                    $run = mysqli_query($conn, $query);
                    echo '<form action="" method="POST">
                                  <select name="zahtjev">';
                                        while ($row = mysqli_fetch_array($run)) {
                                            echo "<option value='" . $row['idzahtjev'] ."'>" . $row['kolicina_krvi_zaht'] ."l  " . $row['krvna_grupa_zaht']."</option>";
                                        }
                                        echo  '<input type="submit" name="otkazi_zahtjev" value="Otkazi"/>
                                    </select>
                           </form>';

                  echo '</div>
                  <div id="content2" class="toggle" style="display:none" align="middle">
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
                  
                <div id="content20" class="toggle2" style="display:none" align="middle">';
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
                  
                  echo'</div><div id="content3" class="toggle" style="display:none" align="middle">
                    <b>Uredi postavke:</b>';

                    $sql = "select * from bolnica where idbolnica = '$idbolnica'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $password = $row['password'];

                    echo'
                    <form action="" method="POST">
                    Naziv bolnice: <input type="text" name="naziv_bolnice" value="' . $row['naziv_bolnice'] . '"> <br><br>
                    Grad: <input type="text" name="grad" value="' . $row['grad'] . '"><br><br>
                    Adresa: <input type="text" name="adresa_bolnice" value="' . $row['adresa_bolnice'] . '"><br><br>
                    Poštanski broj: <input type="number" name="postanski_broj" value="' . $row['postanski_broj'] . '"><br><br><br>
                    
                    <b>Promjeni lozinku:</b><br>
                    Trenutna lozinka: <input type="password" name="trenutna" "><br><br> 
                    Nova lozinka:<input type="password" name="nova1" "><br><br> 
                    Ponovni upis nove lozinke:<input type="password" name="nova2" "><br><br> 
                    
                    <input type="submit" name="updejtaj" value="Spremi promjene">
                    </form>';

                    if (isset($_POST['updejtaj'])) {
                        $naziv_bolnice = $_POST['naziv_bolnice'];
                        $grad = $_POST['grad'];
                        $adresa_bolnice = $_POST['adresa_bolnice'];
                        $postanski_broj = $_POST['postanski_broj'];

                        $trenutna = $_POST['trenutna'];
                        $nova1 = $_POST['nova1'];
                        $nova2 = $_POST['nova2'];

                        $update_query = "update bolnica set naziv_bolnice = '$naziv_bolnice',grad ='$grad', adresa_bolnice = '$adresa_bolnice',
                        postanski_broj = '$postanski_broj' where idbolnica = '$idbolnica'";
                        $update_run = mysqli_query($conn, $update_query);

                        if ($trenutna === $password and $nova1 === $nova2 and !is_null($nova1)) {
                            $update_query = "update bolnica set password = '$nova1' where idbolnica = '$idbolnica'";
                            $update_run = mysqli_query($conn, $update_query);
                            echo '<script type="text/javascript">',
                            'Ulogirajme();',
                            '</script>'
                            ;
                        }
                    }

                  echo'</div>     
                   
                  <div id="content4" class="toggle" style="display:none">Forumic<br><br>';
                    $sql = "SELECT * from komentari where idbolnica_bol = '$idbolnica'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    while($row = mysqli_fetch_array($run)){
                        echo '<i>'.$row['autor'].' komentirao je '. $row['datum_kom'].' :<br><br></i>';
                        echo $row['tekst_komentara'].'<br><br>';
                    }
                    echo'<textarea name="tekst" id="tekst" form="myform"></textarea>
                        <form action="" method="POST" id="myform">
                          <input type="submit" value="Komentiraj" name="komentar"> 
                        </form>
                        ';
                  echo'</div>  
                 
                 <script src="http://code.jquery.com/jquery-latest.js"></script>   
                 <script  type="text/javascript">
                        $("#nav a").click(function(e){
                            e.preventDefault();
                            $(".toggle").hide();
                            $(".toggle2").hide();
                            var toShow = $(this).attr(\'href\');
                            $(toShow).show();
  
                        });
                            $("#content20").show();
                 </script>
             </body>';

?>