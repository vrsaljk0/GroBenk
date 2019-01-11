<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<?php
    require_once "dbconnect.php";
    session_start();

    echo"Dobrodošao admine!";
    if(isset($_GET['prihvati'])){
        if(!empty($_GET['check_list'])){
            foreach($_GET['check_list'] as $id) {
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
    echo '
        <html>
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="#content8">&nbsp;Statistika&nbsp;</a>
               <a href="" onclick="OdjaviMe();">&nbsp;Odjavi se&nbsp;</a>
           </div>


           <div id="content5" class="toggle" >Bolnički zahtjevi';
                $zahtjev_q = "SELECT  *from zahtjev, bolnica where zahtjev.odobreno = '0' and zahtjev.id_bolnica = bolnica.idbolnica ";
                $run = mysqli_query($conn, $zahtjev_q);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

                echo '<form action="" method="GET">
                       <b><p style="color:red;">Novi zahtjevi za krvlju</p></b>
                       <p>Bolnica&nbsp;&nbsp;Kolicina krvi&nbsp;&nbsp;Krvna grupa&nbsp;&nbsp;Datum zahtjevanja</p>';
                        while($row = mysqli_fetch_array($result)){
                            echo '<p>'.$row['naziv_bolnice'].' '.$row['kolicina_krvi_zaht'].'l '.$row['krvna_grupa_zaht'] .$row['datum_zahtjeva'].'<input type="checkbox" name="check_list[]" value='.$row['idzahtjev'].'></p>';
                        }
                        echo'<input type="submit" name="prihvati" value="Prihvati">
                            <input type="submit" name="odbij_zahtjev" value="Odbij">
                    </form>';
            echo '</div>

        </html>';
?>