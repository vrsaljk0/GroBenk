
<?php
require_once "dbconnect.php";
session_start();

echo"Dobrodošao admine!";


if(isset($_GET['obavijest'])) {
    $grad = $_GET['grad'];
    $krvna_grupa = $_GET['kgrupa'];
    $tekst = $_GET['tekst'];

    $datum = date('Y-m-d');
    $status = 0;

    if ($krvna_grupa == '0' and $grad == '0') {
        $sql = "SELECT * from donor where 1";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if ($krvna_grupa == '0' and $grad != '0') {
        $sql = "SELECT * from donor where prebivaliste = '$grad'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if ($grad == '0' and $krvna_grupa != '0') {
        $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if ($krvna_grupa!= '0' and $grad != '0'){
        $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa' and prebivaliste = '$grad'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }

    while ($row = mysqli_fetch_array($run)) {
        $OIB = $row['OIB_donora'];
        $sqll = "INSERT INTO obavijesti (OIBdonora, tekst_obav, datum_obav, procitano) VALUES ('$OIB', '$tekst', '$datum', '$status')";
        $runn = mysqli_query($conn, $sqll);
        $resultt = $runn or die ("Failed to query database". mysqli_error($conn));
    }
    header("Location:admin.php");
}

echo '
        <html>
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
               <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
           </div>

           <div id="content7" class="toggle">
               Pošalji obavijest:
               
               <form id = "obavijest" method="GET" action="">
               <select id="kgrupa" name="kgrupa">
               <option value="0">-krvna grupa-</option>';
            $krvna_grupa = array("A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-");
            for ($i = 0; $i < 8; $i++) {
                echo '<option value='.$krvna_grupa[$i].'>'.$krvna_grupa[$i].'</option>';
            }

            echo'</select>';

        $query = "select * from donor group by prebivaliste";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database". mysqli_error($conn));

        echo'<select name="grad" id ="grad">
                           <option value="0">-grad-</option>';
        while ($row = mysqli_fetch_array($run)) {
            echo '<option value="'.$row['prebivaliste'].'">'.$row['prebivaliste'].'</option>';
        }
        echo '</select>
                      <br><textarea name="tekst" id="tekst" form="obavijest"></textarea><br>
                      <input type="submit" name="obavijest" value="Posalji obavijest">
                      </form>
                   </div>

                </html>';
        ?>