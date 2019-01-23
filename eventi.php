
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

/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!$_SESSION['admin_loggedin']) header("Location:denied_permission.php");

if(isset($_POST['submit_event'])){
    $grad = $_POST['grad'];
    $lokacija = $_POST['lokacija'];
    $adresa_lokacije = $_POST['adresa'];
    $postanskibr = $_POST['postbroj'];
    $datum_dogadaja= $_POST['datum'];
    $startt = $_POST['startt'];
    $kraj = $_POST['kraj'];
    $image = $_FILES['image']['name'];
    $target = "lokacije/".basename($image);
    $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Podaci uspješno promijenjeni";
    } else {
        $msg = "Došlo je do greške";
    }

    echo $msg;

    $sql = "INSERT INTO lokacija (grad, naziv_lokacije, adresa_lokacije, postanski_broj, datum_dogadaja, start, kraj, image) 
                VALUES('$grad', '$lokacija', '$adresa_lokacije', '$postanskibr', '$datum_dogadaja', '$startt', '$kraj', '$image')";
    $run = mysqli_query($conn, $sql);
    $result = $run or die ("Failed to query database". mysqli_error($conn));



    header("Location:eventi.php?keyword=&trazi=Traži");
}
if(isset($_POST['delete'])){
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $id) {
            $sql = "DELETE from lokacija WHERE id_lokacije ='$id'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));

        }
    }
}
echo'
Dobrodošao admine!
            <div>
               <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
               <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
               <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
               <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
               <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
               <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
           </div>
           
<div id="content10" class="toggle" ><br><br>
            <form action="" "method="POST" enctype="multipart/form-data">
            <table border = "1">
            <tr>
                <th>DATUM</th>
                <th>GRAD</th>
                <th>LOKACIJA</th>
                <th>ADRESA</th>
                <th>POŠTANSKI BROJ</th>
                <th>POČINJE</th>
                <th>ZAVRŠAVA</th>
                <th>SLIKA</th>
            </tr>
                <td><input type="date" name = "datum" required=""></td>
                <td><input type="text" name = "grad" required=""></td>
                <td><input type="text" name = "lokacija" required=""></td>
                <td><input type="text" name = "adresa" required=""></td>
                <td><input type="number" name = "postbroj" required=""></td>
                <td><input type="time" name = "startt" required=""></td>
                <td><input type="time" name = "kraj" required=""></td>
                <input type="file" name = "image" class="form-control"><br><br>
                <input type="hidden" name="image_text" value="image_text">
                <td><input type="submit" name="submit_event" value="Dodaj event"></td>
            </table>
            </form>
    <form action="" method="GET">
        <input type="text" name = "keyword" placeholder="Pretraži evente">
        <input type="submit" name="trazi" value="Traži">
    </form>
    
    <form action="" method="POST">
    <table border="1">
        <tr>
            <th>DATUM</th>
            <th>GRAD</th>
            <th>LOKACIJA</th>
            <th>ADRESA</th>
            <th>POŠTANSKI BROJ</th>
            <th>POČINJE</th>
            <th>ZAVRŠAVA</th>
            <th>PRIKAŽI DETALJNIJE</th>
            <th>UREDI</th>
            <th>IZBRIŠI</th>
        </tr>';
        if(isset($_GET['trazi'])) {
        $datum = date('Y-m-d');
        $pretraga = $_GET['keyword'];
        $query = "SELECT *from lokacija WHERE (grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database" . mysqli_error($conn));

        echo '<div>';

            while ($row = mysqli_fetch_array($result)) {
                if ($row['datum_dogadaja'] > $datum) {
                echo '
                <tr>
                    <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '<td><a href = "show_event.php?idEvent='. $row["id_lokacije"].'">Prikaži detaljnije</a></td><td><a href = "edit_event.php?idEvent='. $row["id_lokacije"].'">Uredi</a></td><td><input type="checkbox" class="case" name="check_list[]" value='.$row['id_lokacije'].' ></a></td>
                </tr>';
                } else {
                    echo '
                    <tr>
                        <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '<td><a href = "show_event.php?idEvent='. $row["id_lokacije"].'">Prikaži detaljnije</a></td><td><a href = "edit_event.php?idEvent='. $row["id_lokacije"].'">Uredi</a></td><td></td>
                    </tr>';
                }
            }
        }
            echo'
            
        </table><br>
            Označi sve:
            <input type="checkbox" name="select_all" id = "select_all"><br><br>
            <input type="submit" name="delete" value="Izbrisi evente">
        </form>
</div>';


?>