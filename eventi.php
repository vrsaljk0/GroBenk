<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>
<?php

session_start();
require_once ("dbconnect.php");

if(isset($_GET['submit_event'])){
    $grad = $_GET['grad'];
    $lokacija = $_GET['lokacija'];
    $adresa_lokacije = $_GET['adresa'];
    $postanskibr = $_GET['postbroj'];
    $datum_dogadaja= $_GET['datum'];
    $startt = $_GET['startt'];
    $kraj = $_GET['kraj'];
    $sql = "INSERT INTO lokacija (grad, naziv_lokacije, adresa_lokacije, postanski_broj, datum_dogadaja, start, kraj) 
                VALUES('$grad', '$lokacija', '$adresa_lokacije', '$postanskibr', '$datum_dogadaja', '$startt', '$kraj')";
    $run = mysqli_query($conn, $sql);
    $result = $run or die ("Failed to query database". mysqli_error($conn));
    header("Location:admin.php");
}

echo'
Dobrodošao admine!
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
               <a href="" onclick="OdjaviMe();">&nbsp;Odjavi se&nbsp;</a>
           </div>
          


<div id="content10" class="toggle" ><br><br>

    <form action="" method="GET">
        <input type="text" name = "keyword" placeholder="Pretraži evente">
        <input type="submit" name="trazi" value="Traži">
    </form>

    <table border="1">
        <tr>
            <th>DATUM</th>
            <th>GRAD</th>
            <th>LOKACIJA</th>
            <th>ADRESA</th>
            <th>POŠTANSKI BROJ</th>
            <th>POČINJE</th>
            <th>ZAVRŠAVA</th>
            <th>AŽURIRAJ?glupo zvuci</th>
        </tr>
        <tr>
            <form action="" method="GET">
                <td><input type="date" name = "datum" required=""></td>
                <td><input type="text" name = "grad" required=""></td>
                <td><input type="text" name = "lokacija" required=""></td>
                <td><input type="text" name = "adresa" required=""></td>
                <td><input type="number" name = "postbroj" required=""></td>
                <td><input type="time" name = "startt" required=""></td>
                <td><input type="time" name = "kraj" required=""></td>
                <td><input type="submit" name="submit_event" value="Dodaj event"></td>
            </form>
        </tr>';
        if(isset($_GET['trazi'])) {
        $datum = date('Y-m-d');
        $pretraga = $_GET['keyword'];
        $query = "SELECT *from lokacija WHERE (grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database" . mysqli_error($conn));

        echo '<div>';
            while ($row = mysqli_fetch_array($result)) {
            if ($row['datum_dogadaja'] < $datum) {
            echo '
            <tr>
                <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '</td><td><a href = "delete_event.php?idEvent='. $row["id_lokacije"].'">Izbrisi</a></td>
            </tr>';
            } else {
            echo '
            <tr>
                <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '</td><td><a href = "show_event.php?idEvent='. $row["id_lokacije"].'">Prikaži detaljnije</a></td>
            </tr>';
            }
            }
            }
            echo'</table>
</div>';


?>