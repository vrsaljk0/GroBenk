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
                <a class="nav-link active" href="eventi.php?keyword=&trazi=Traži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donacije.php?keyword=&trazi=Traži">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';

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
<div class="eventi-table">
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="event-t">
        <br><span class="newevent">Dodaj novi event:</span>
            <tr>
                <th style="border-left: 2px solid #9F0A00;" class="tht";>DATUM</th>
                <th class="tht">GRAD</th>
                <th class="tht">LOKACIJA</th>
                <th class="tht">ADRESA</th>
                <th class="tht">POŠTANSKI BROJ</th>
                <th class="tht">POČINJE</th>
                <th class="tht">ZAVRŠAVA</th>
                <th style="border-right: 2px solid #9F0A00;" class="tht">SLIKA</th>
                <th style="border-right: 2px solid #9F0A00;" class="tht">  </th>
            </tr>
            <tr>
                <td style="border-left: 2px solid #9F0A00;"><input type="date" name = "datum" required=""></td>
                <td class="eventi-td1"><input type="text" name = "grad" required=""></td>
                <td><input type="text" name = "lokacija" required=""></td>
                <td><input type="text" name = "adresa" required=""></td>
                <td><input type="number" name = "postbroj" required="" style="width: 90px"></td>
                <td><input type="time" name = "startt" required=""></td>
                <td><input type="time" name = "kraj" required=""></td>
                <td style="border-right:2px solid #9F0A00;" style="width: 50px"><input type="file" name = "image" class="form-control"></td>
                <input type="hidden" name="image_text" value="image_text">
                <td style="border-style: none; padding-left: 10px;" ><input type="submit" class="zbtn" name="submit_event" value="Dodaj event"></td>
            </tr>
        </table>
    </form>

    <br><br>
    <form action="" method="GET">
        <input type="text" class="eventi-pretrazi" name = "keyword" placeholder="Pretraži evente">
        <span class="eventi-radio">
            <label class="containerreg"><span class="prevent">Nadolazeći eventi</span>
                <input type="radio" name="radio" value="buduci">
                <span class="checkmarkreg"></span>
            </label>

            <label class="containerreg"><span class="prevent">Prošli eventi</span>
                <input type="radio" name="radio" value="prosli"">
                <span class="checkmarkreg"></span>
            </label>
        </span>
    <input type="submit" class="zbtn" name="trazi" value="Pretraži">
    </form>



    <form action="" method="POST">
    <table style="margin-left:0px; width:100%; overflow:hidden;" class="table table-fixed">
        <thead class="t">
            <tr>
                <th style="width:10%;" class="thh">DATUM</th>
                <th class="thh" style = "width: 130px">GRAD</th>
                <th class="thh">LOKACIJA</th>
                <th class="thh">ADRESA</th>
                <th class="thh">POŠTANSKI BROJ</th>
                <th style="width:8%;" class="thh">POČINJE</th>
                <th style="width:8%;" class="thh">ZAVRŠAVA</th>
                <th class="thh" style = "width: 180px">PODACI O EVENTU</th>
                <th style="width:9%;" class="thh">IZBRIŠI</th>
            </tr>
        </thead>';



if(isset($_GET['trazi'])) {
    $radio = 0;
    $pretraga = $_GET['keyword'];
    $datum = date('Y-m-d');
    if(isset($_GET['radio']) and ($_GET['radio'])=='buduci' && $pretraga ==''){
        $query = "SELECT *from lokacija WHERE datum_dogadaja > '$datum' order by id_lokacije desc";
    }
    else if(isset($_GET['radio'])and ($_GET['radio'])=='buduci' && $pretraga !=''){
        $query = "SELECT *from lokacija WHERE ((grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')) AND (datum_dogadaja > '$datum') order by id_lokacije desc";
    }
    else if(isset($_GET['radio'])and ($_GET['radio'])=='prosli' && $pretraga !=''){
        $query = "SELECT *from lokacija WHERE ((grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%')) AND (datum_dogadaja < '$datum') order by id_lokacije desc";
    }
    else if(isset($_GET['radio'])and ($_GET['radio'])=='prosli' && $pretraga ==''){
        $query = "SELECT *from lokacija WHERE datum_dogadaja < '$datum' order by id_lokacije desc";
    }
    else{
        $query = "SELECT *from lokacija WHERE (grad LIKE '%$pretraga%') OR (naziv_lokacije LIKE '%$pretraga%') OR (adresa_lokacije LIKE '%$pretraga%') OR (postanski_broj LIKE '%$pretraga%') OR (datum_dogadaja LIKE '%$pretraga%') order by id_lokacije desc";
    }

    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database" . mysqli_error($conn));
    echo '<div>';
    while ($row = mysqli_fetch_array($result)) {
        $hours_start = date('H', strtotime($row['start']));
        $minutes_start = date('i', strtotime($row['start']));
        $hours_kraj = date('H', strtotime($row['kraj']));
        $minutes_kraj = date('i', strtotime($row['kraj']));
        if ($row['datum_dogadaja'] > $datum) {
            echo '
                        <tr bgcolor="#e6ffe6">
                            <td style="width:10%;" class="trr">' . $row['datum_dogadaja'] . '</td>
                            <td class="trr"> ' . $row['grad'] . '</td>
                            <td style="margin-left:5px;" class="trr">' . $row['naziv_lokacije'] . '</td>
                            <td class="trr">' . $row['adresa_lokacije'] . '</td>
                            <td style="margin-left:11px;" class="trr">' . $row['postanski_broj'] . '</td>
                            <td style="width:8%;" class="trr">' . $hours_start. ':'. $minutes_start .'</td>
                            <td style="width:8%;" class="trr">' . $hours_kraj. ':'. $minutes_kraj .'</td>
                            <td><a href = "edit_event.php?idEvent='. $row["id_lokacije"].'">Uredi</a></td>
                            <td style="float:right; width:9%;" class="trr"><input type="checkbox" style="margin-left:40px;" class="case" name="check_list[]" value='.$row['id_lokacije'].' ></td>
                        </tr>';
        } else {
            echo '
                        <tr>
                            <td style="width:10%;" class="trr">' . $row['datum_dogadaja'] . '</td>
                            <td class="trr"> ' . $row['grad'] . '</td>
                            <td style="margin-left:5px;" class="trr">' . $row['naziv_lokacije'] . '</td>
                            <td class="trr">' . $row['adresa_lokacije'] . '</td>
                            <td style="margin-left:11px;" class="trr">' . $row['postanski_broj'] . '</td>
                            <td style="width:8%;" class="trr">' . $hours_start. ':'. $minutes_start .'</td>
                            <td style="width:8%;" class="trr">' . $hours_kraj. ':'. $minutes_kraj .'</td>
                            <td><a href = "show_event.php?idEvent='. $row["id_lokacije"].'">Prikaži detaljnije</a></td>
                            <td></td>
                        </tr>';
        }
    }
}
echo'
                
            </table><br>
                <span class="prevent">Označi sve&nbsp</span>
                <input type="checkbox" name="select_all" id = "select_all"><br><br>
                <input type="submit" class="zbtn" name="delete" value="Izbriši evente">
            </form>
        </div>
    </div>
    <div style="height:200px;">
    </div>
</div>';
?>