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
        <link href="donorstyle.css" rel="stylesheet">
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
                <a class="nav-link active" href="eventi.php?keyword=&trazi=Traži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
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

<div class="col-md-8">';
    if(isset($_POST['delete'])){
        if (!empty($_POST['check_list'])) {
            foreach ($_POST['check_list'] as $id) {
                $sql = "DELETE from lokacija WHERE id_lokacije ='$id'";
                $run = mysqli_query($conn, $sql);
                $result = $run or die ("Failed to query database". mysqli_error($conn));

            }
        }
    }
    if(isset($_POST['submit_event'])){
        $datum = $_POST['datum'];
        $grad = $_POST['grad'];
        $lokacija = $_POST['lokacija'];
        $adresa = $_POST['adresa'];
        $postanski_broj = $_POST['postbroj'];
        $start = $_POST['startt'];
        $kraj = $_POST['kraj'];
        $image = $_FILES['image']['name'];
        $target = "lokacije/".basename($image);
        $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);

        $query = "INSERT into lokacija (grad, naziv_lokacije, adresa_lokacije, postanski_broj, datum_dogadaja, start, kraj, image) values ('$grad', '$lokacija', '$adresa', '$postanski_broj','$datum', '$start', '$kraj', '$image')";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database" . mysqli_error($conn));

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Podaci uspješno promijenjeni";
        } else {
            $msg = "Došlo je do greške";
        }

        header("Location:eventi.php?keyword=&trazi=Traži");
    }
    echo '
    <div id="content10" class="toggle" ><br><br>
                <form action="" method="POST" enctype="multipart/form-data">
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
                    <td><input type="file" name = "image" class="form-control"></td><br><br>
                    <input type="hidden" name="image_text" value="image_text">
                    <td><input type="submit" name="submit_event" value="Dodaj event"></td>
                </table>
            
        <form action="" method="GET">
            <input type="text" name = "keyword" placeholder="Pretraži evente">
            Nadolazeći eventi <input type="radio" name="buduci" value="buduci">
            Prošli eventi <input type="radio" name="prosli" value="prosli"">
            <input type="submit" name="trazi" value="Pretraži">
        </form>
        <form>

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
                <th>PODACI O EVENTU</th>
                <th>IZBRIŠI</th>
            </tr>';
            if(isset($_GET['trazi'])) {
            $radio = 0;
            $pretraga = $_GET['keyword'];
            $datum = date('Y-m-d');
            if(isset($_GET['buduci']) && $pretraga ==''){
                $query = "SELECT *from lokacija WHERE datum_dogadaja > '$datum' order by id_lokacije desc";
            }
           else if(isset($_GET['buduci']) && $pretraga !=''){
               $query = "SELECT *from lokacija WHERE ((grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')) AND (datum_dogadaja > '$datum') order by id_lokacije desc";
           }
            else if(isset($_GET['prosli']) && $pretraga !=''){
                $query = "SELECT *from lokacija WHERE ((grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')) AND (datum_dogadaja < '$datum') order by id_lokacije desc";
            }
            else if(isset($_GET['prosli']) && $pretraga ==''){
                $query = "SELECT *from lokacija WHERE datum_dogadaja < '$datum' order by id_lokacije desc";
            }
            else{
                $query = "SELECT *from lokacija WHERE (grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%') order by id_lokacije desc";
            }

            $run = mysqli_query($conn, $query);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
            echo '<div>';
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['datum_dogadaja'] > $datum) {
                    echo '
                    <tr bgcolor="#e6ffe6">
                        <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '<td><a href = "edit_event.php?idEvent='. $row["id_lokacije"].'">Uredi</a></td><td><input type="checkbox" class="case" name="check_list[]" value='.$row['id_lokacije'].' ></a></td>
                    </tr>';
                    } else {
                        echo '
                        <tr>
                            <td>' . $row['datum_dogadaja'] . '</td><td> ' . $row['grad'] . '</td><td>' . $row['naziv_lokacije'] . '</td><td>' . $row['adresa_lokacije'] . '</td><td>' . $row['postanski_broj'] . '</td><td>' . $row['start'] . '</td><td>' . $row['kraj'] . '<td><a href = "show_event.php?idEvent='. $row["id_lokacije"].'">Prikaži detaljnije</a></td><td></td>
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
    </div>
</div>';
?>