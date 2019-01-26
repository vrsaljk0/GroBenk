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

if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");

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
    <base target="_self">
    <meta name="google" value="notranslate">
    <link rel="shortcut icon" href="/images/cp_ico.png">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
</head>';

   
    $id = $_GET['idEvent'];

    if(isset($_POST['uredi_event'])) {
        $id = $_POST['id'];
        $datum = $_POST['datum'];
        $grad = $_POST['grad'];
        $lokacija = $_POST['lokacija'];
        $adresa = $_POST['adresa'];
        $postbroj = $_POST['postbroj'];
        $startt = $_POST['startt'];
        $kraj = $_POST['kraj'];
        $image = $_FILES['image']['name'];
        $target = "lokacije/".basename($image);
        $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);

        if($filename !="") {
            $query = "UPDATE  lokacija SET image = '$image' where id_lokacije='$id'";
            $run = mysqli_query($conn, $query);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg = "Podaci uspješno promijenjeni";
            } else {
                $msg = "Došlo je do greške";
            }
        }
        else{
            $sql = "UPDATE lokacija SET datum_dogadaja = '$datum', grad = '$grad', naziv_lokacije = '$lokacija', adresa_lokacije = '$adresa', postanski_broj = '$postbroj',
                            start = '$startt', kraj = '$kraj' WHERE id_lokacije = '$id'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }
        header("Location:eventi.php?keyword=&trazi=Traži");
    }

    $sql = "SELECT * from lokacija where id_lokacije = '$id'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($run);

echo'
<div class="container">
    <form action=" "method="POST" enctype="multipart/form-data">
      <h1>Uredi event</h1>
      <hr>
        <div class="row">
            <div class="col-md-3">
             <div class="text-center">
                <img src="lokacije/'.$row['image'].'" class="avatar img-thumbnail" alt="avatar">
                <h6>Promijeni sliku profila</h6>
                <input type="file" name = "image" class="form-control">
                <input type="hidden" name="image_text" value="'.$row['naziv_lokacije'].'">
              </div>
            </div>

            <div class="col-md-9 personal-info">
                <div class="form-group">
                  <label class="col-lg-3 control-label">Datum:</label>
                  <div class="col-lg-8">
                    <input type="date" class="form-control" name = "datum" value="'.$row['datum_dogadaja'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Grad:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control"  name="grad" value="'.$row['grad'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Lokacija:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name = "lokacija" value="'.$row['naziv_lokacije'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Adresa:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name = "adresa" value="'.$row['adresa_lokacije'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Počinje:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="time" name = "startt" value="'.$row['start'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Završava:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="time" name = "kraj" value="'.$row['kraj'].'" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label"></label>
                  <div class="col-md-8">
                    <input type="submit" style="background: #9F0A00; border: 1px solid #A60202;" class="btn btn-primary" name="updejtaj" value="Promijeni podatke">
                    <span></span>
                    <bottom><br><br><a href="eventi.php?keyword=&trazi=Traži">Nazad</a></bottom>
                  </div>
                </div>
            </div>
        </div>
    </form>
</div>
<hr>  
';

?>