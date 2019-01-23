<?php

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!$_SESSION['admin_loggedin']) header("Location:denied_permission.php");

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
<div class="admin-content">
        <ul class="nav nav-tabs" id="myTab" >
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Tra%C5%BEi">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donacije.php">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>

<div id="d" class="col-md-8">';
    if(isset($_GET['prihvati'])){
        if(!empty($_GET['check_list'])){
            foreach($_GET['check_list'] as $id) {
                $now = date('Y-m-d');

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
                    /** obavijest za sve donore koji imaju tu krv a mogu donirat
                     */

                    $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_gr'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));

                    $OIB_obavijest[] = 0;
                    $i = 0;
                    while($row = mysqli_fetch_array($result)){
                        $oib = $row['OIB_donora'];

                        if ($row['spol'] == 'M') {
                            $sql2 = "select * from lokacija where id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$oib')
                                    order by datum_dogadaja desc limit 1";
                            $run2 = mysqli_query($conn, $sql2);
                            $result2 = $run2 or die ("Failed to query database". mysqli_error($conn));
                            $row2 = mysqli_fetch_assoc($result2);
                            $datum = $row2['datum_dogadaja'];

                                if (date('Y-m-d', strtotime("+3 months", strtotime($datum))) <= $now) {
                                    $OIB_obavijesti[$i] = $row['OIB_donora'];
                                    $i++;
                                }
                        } else {
                            $sql2 = "select * from lokacija where id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$oib')
                                     order by datum_dogadaja desc limit 1";
                            $run2 = mysqli_query($conn, $sql2);
                            $result2 = $run2 or die ("Failed to query database". mysqli_error($conn));
                            $row2 = mysqli_fetch_assoc($result2);
                            $datum = $row2['datum_dogadaja'];

                            if (date('Y-m-d', strtotime("+3 months", strtotime($datum))) <= $now) {
                                $OIB_obavijesti[$i] = $row['OIB_donora'];
                                $i++;
                            }
                        }
                    }
                    foreach ($OIB_obavijesti as $OIB) {
                        $tekst_obav = 'Trenutno je manjak vaše krvne grupe u zalihi. Razmislite o donaciji! Hvala!';
                        $sql = "insert into obavijesti (OIBdonora, tekst_obav, datum_obav, procitano) values ('$OIB', '$tekst_obav', '$now', '0')";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                    }

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
    $i = 0;
    echo '
   <div id="content5" class="toggle" >';
        $zahtjev_q = "SELECT  *from zahtjev, bolnica where zahtjev.odobreno = '0' and zahtjev.id_bolnica = bolnica.idbolnica ";
        $run = mysqli_query($conn, $zahtjev_q);
        $result = $run or die ("Failed to query database". mysqli_error($conn));

        echo '<form action="" method="GET">
               <table class="table table-fixed">
                    <thead class="t">
                        <tr class="trtr">
                            <th class="thth1">#</th>
                            <th class="thth">Bolnica</th>
                            <th class="thth">Količina krvi</th>
                            <th class="thth">Krvna grupa</th>
                            <th class="thth">Datum zahtijevanja</th>
                            <th class="thth2">✔</th>
                        </tr>
                    </thead>
                <tbody>';

                while($row = mysqli_fetch_array($result)){
                    $i++;
                    echo '
                        <tr class="trtrtr">
                            <td class="tdtd1">'.$i.'.</td>
                            <td class="tdtdb">'.$row['naziv_bolnice'].'</td>
                            <td class="tdtd">'.$row['kolicina_krvi_zaht'].' L</td>
                            <td class="tdtd">'.$row['krvna_grupa_zaht'].'</td>
                            <td class="tdtd">'.$row['datum_zahtjeva'].'</td>
                            <td class="tdtd1"><input type="checkbox" name="check_list[]" value='.$row['idzahtjev'].'></td>
                        </tr>
                    ';
                }
                echo '
                </tbody>
                </table>
                ';
                echo'<input type="submit" class="zbtn" style="margin-left:30%; margin-top:2%;" name="prihvati" value="Prihvati">
                    <input type="submit" class="zbtn" name="odbij_zahtjev" value="Odbij">
            </form>';
    echo '
    </div>
</div>';
?>
