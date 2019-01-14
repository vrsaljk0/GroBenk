<?php
    require_once ("dbconnect.php");
    echo'Dobrodošao admine!

    <div>
       <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
       <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
       <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
       <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
       <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
       <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
   </div><br><br>';
    /** kadgod se klikne na uredi_event link se sjebe i vise ne zna sta je idEvent
      stavila sam u formu hidden input jer inace nez kako da saljem taj id :((((  */

    if(isset($_GET['uredi_event'])) {
        $id = $_GET['id'];
        $datum = $_GET['datum'];
        $grad = $_GET['grad'];
        $lokacija = $_GET['lokacija'];
        $adresa = $_GET['adresa'];
        $postbroj = $_GET['postbroj'];
        $startt = $_GET['startt'];
        $kraj = $_GET['kraj'];

        $sql = "UPDATE lokacija SET datum_dogadaja = '$datum', grad = '$grad', naziv_lokacije = '$lokacija', adresa_lokacije = '$adresa', postanski_broj = '$postbroj',
                            start = '$startt', kraj = '$kraj' WHERE id_lokacije = '$id'";

        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    } else {
        $id = $_GET['idEvent'];
        echo $id;
    }

    $sql = "SELECT * from lokacija where id_lokacije = '$id'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($run);

    echo'<form action="" method="GET">
        
        <table border = "1">
        <tr>
            <th>DATUM</th>
            <th>GRAD</th>
            <th>LOKACIJA</th>
            <th>ADRESA</th>
            <th>POŠTANSKI BROJ</th>
            <th>POČINJE</th>
            <th>ZAVRŠAVA</th>
            <th>PRIKAŽI DETALJNIJE</th>
        </tr>
            <td><input type="date" name = "datum" value="'.$row['datum_dogadaja'].'" required=""></td>
            <td><input type="text" name = "grad" value="'.$row['grad'].'" required=""></td>
            <td><input type="text" name = "lokacija" value="'.$row['naziv_lokacije'].'" required=""></td>
            <td><input type="text" name = "adresa" value="'.$row['adresa_lokacije'].'" required=""></td>
            <td><input type="number" name = "postbroj" value="'.$row['postanski_broj'].'" required=""></td>
            <td><input type="time" name = "startt" value="'.$row['start'].'" required=""></td>
            <td><input type="time" name = "kraj" value="'.$row['kraj'].'" required=""></td>
            <td><input type="hidden" name = "id" value="'.$id.'" required=""></td>
            <td><input type="submit" name="uredi_event" value="Uredi"></td>
        </table>
        </form>';

?>