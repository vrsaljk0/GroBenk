<?php
    session_start();
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

    $id = $_GET['idEvent'];

    $sql = "SELECT * from lokacija where id_lokacije = '$id'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($run);

    echo 'Lokacija: '.$row['naziv_lokacije'].'<br>Datum: '.$row['datum_dogadaja'].'<br>Donori:<br><br>';

    $sql = "SELECT ime_prezime_donora from donor where OIB_donora in (select OIB_donora_don from
                                       moj_event where id_lokacije='$id' and prisutnost='1')";
    $run = mysqli_query($conn, $sql);
    $result = $run or die ("Failed to query database". mysqli_error($conn));
    while($row = mysqli_fetch_array($result)){
        echo $row['ime_prezime_donora'].'<br><br>';
    }

?>