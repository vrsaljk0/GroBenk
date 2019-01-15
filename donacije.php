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
    require_once "dbconnect.php";
    session_start();

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!$_SESSION['admin_loggedin']) header("Location:denied_permission.php");


    echo"Dobrodošao admine!";


    echo '
        <html>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
               <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
           </div>    
           
    <br><h3>Trenutno stanje zaliha:</h3>';

    $zaliha_q = "SELECT * from zaliha";
    $run = mysqli_query($conn, $zaliha_q);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    while($red = mysqli_fetch_array($result)){
        echo $red['krvna_grupa'].' ' . $red['kolicina_grupe'].'<br><br>';
    }

    echo'<div id="content30" class="toggle"  ><br><br>
        
        <form action="" method="GET">
            <input type="text" name = "keyword" placeholder="Pretraži donacije">
            <input type="submit" name="trazi" value="Traži">
        </form>
        
        <form action="" method="GET">
        <table border="1">
            <tr>
                <th>LOKACIJA</th>
                <th>OIB</th>
                <th>IME I PREZIME</th>
                <th>KRVNA GRUPA</th>
                <th>AŽURIRAJ?glupo zvuci</th>
            </tr>';
            if(isset($_GET['trazi'])) {
                $pretraga = $_GET['keyword'];
                $date = date("Ymd");


                /** STORYTIME:
                 *Nes je sjebano, unjela sam novi event i logicno nijedan donor nije bio prijavljen na njega. Pod donacijama mi se ponudio Jasmin,
                 *otisla sam na njegov profil i pod njegovim oznacenim eventima je bio taj event. WHY? nemam blage, id_lokacije tog event nije uopce bio u moj_event.
                 * id_lokacije nije foreign key u moj_event, mozda to????? al svjeednooo se to nebi smjelo dogadaat :(
                 */
                $query = "select lokacija.naziv_lokacije, donor.OIB_donora, donor.ime_prezime_donora, donor.krvna_grupa_don from lokacija, donor, moj_event
                          where lokacija.datum_dogadaja = '$date' and lokacija.id_lokacije = moj_event.id_lokacije and donor.OIB_donora = moj_event.OIB_donora_don and moj_event.prisutnost = '0'
                          and ((lokacija.naziv_lokacije like '%$pretraga%') or (donor.ime_prezime_donora like '%$pretraga%') or (donor.krvna_grupa_don = '$pretraga'))";
                $run = mysqli_query($conn, $query);
                $result = $run or die ("Failed to query database". mysqli_error($conn));


                    while ($row = mysqli_fetch_array($result)) {
                        echo '
                            <tr>
                                <td>' . $row['naziv_lokacije'] . '</td><td> ' . $row['OIB_donora'] . '</td><td>' . $row['ime_prezime_donora'] . '</td><td>' . $row['krvna_grupa_don'] . '</td><td><input type="checkbox" class="case" name="check_list[]" value='.$row['OIB_donora'].'></td>
                            </tr>';
                    }
                    echo'</table>

                    <input type="text" name="kolicina">
                    <input type="submit" name="doniraj" value="Unesi donaciju"><br>
                    <input type="submit" name="odbij" value="Odbij donaciju"><br><br>
                    Označi sve:
                    <input type="checkbox" name="select_all" id = "select_all">
                    
                </form>';



            }


            if(isset($_GET['doniraj'])) {
                $date = date("Ymd");
                $kol = $_GET['kolicina'];
                if (!empty($_GET['check_list'])) {

                    foreach ($_GET['check_list'] as $OIB) {
                        $info = "select * from donor where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $info);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);
                        $krvna_grupa = $row['krvna_grupa_don'];


                        $lokacija = "select * from lokacija where datum_dogadaja = '$date' and
                                     id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$OIB')";

                        $run = mysqli_query($conn, $lokacija);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);

                        $id_lokacije = $row['id_lokacije'];
                        echo $id_lokacije;
                        //umetanje donacije u tablicu donacija

                        $sql = "INSERT into donacija (kolicina_krvi_donacije, krvna_grupa_zal, OIB_donora, idlokacija)
                                        values ( '$kol', '$krvna_grupa', '$OIB', '$id_lokacije')";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE donor SET br_donacija = br_donacija+1 where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE moj_event SET prisutnost = '1' WHERE OIB_donora_don = '$OIB' AND id_lokacije='$id_lokacije'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));

                        $sql = "UPDATE zaliha set kolicina_grupe = kolicina_grupe + '$kol' where krvna_grupa = '$krvna_grupa'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        header("Location:donacije.php?keyword=&trazi=Traži");
                    }
                }
            }
            if(isset($_GET['odbij'])){
                $date = date("Ymd");
                if (!empty($_GET['check_list'])) {
                    foreach ($_GET['check_list'] as $OIB) {
                        $lokacija = "select * from lokacija where datum_dogadaja = '$date' and
                                     id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$OIB')";
                        $run = mysqli_query($conn, $lokacija);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);
                        $id_lokacije = $row['id_lokacije'];


                        $sql = "UPDATE moj_event SET prisutnost = '-1' WHERE OIB_donora_don = '$OIB' and id_lokacije='$id_lokacije' and prisutnost = '0'";
                        $run = mysqli_query($conn, $sql);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        header("Location:donacije.php?keyword=&trazi=Traži");

                    }
                }
            }

        echo '</html>';
?>