<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>


<?php
    require_once "dbconnect.php";
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!$_SESSION['bolnica_loggedin']) header("Location:denied_permission.php");

    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];

    $date = date("Ymd");
    $idbolnica = $_SESSION['id'];

    $info ="select *from bolnica where  idbolnica = '$idbolnica'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);
    $naziv_bolnice = $row['naziv_bolnice'];

    if (isset($_POST['updejtaj'])) {
        $naziv_bolnice = $_POST['naziv_bolnice'];
        $grad = $_POST['grad'];
        $adresa_bolnice = $_POST['adresa_bolnice'];
        $postanski_broj = $_POST['postanski_broj'];
        $password = $_POST['password'];
        $flag = 0;
        $update_query = "update bolnica set naziv_bolnice = '$naziv_bolnice',grad ='$grad', adresa_bolnice = '$adresa_bolnice',
                            postanski_broj = '$postanski_broj' where idbolnica = '$idbolnica'";
        $update_run = mysqli_query($conn, $update_query);

        $trenutna = $_POST['trenutna'];
        $nova1 = $_POST['nova1'];
        $nova2 = $_POST['nova2'];
        if ($trenutna === $password and $nova1 === $nova2 and $nova1 != '') {
            $update_query = "update bolnica set password = '$nova1' where idbolnica = '$idbolnica'";
            $update_run = mysqli_query($conn, $update_query);
            $flag = 1;
        }

        if($flag == 1)$url = 'index.html';
        else $url = 'bolnicke_postavke.php';
        header("Location: $url");
    }


echo'
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
</head>

<div class="container">
    <form action="" method="POST">
      <h1>Uredi profil</h1>
      <hr>
        <div class="row">
            <div class="col-md-3">
            </div>

            <div class="col-md-9 personal-info">
            <h3>Osobni podaci</h3>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Naziv bolnice:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control" name="naziv_bolnice" value="'.$row['naziv_bolnice'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Grad:</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control"  name="grad" value="'.$row['grad'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Adresa:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="text" name="adresa_bolnice" value='.$row['adresa_bolnice'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 control-label">Poštanski broj:</label>
                  <div class="col-lg-8">
                    <input class="form-control" type="number" name="postanski_broj" value="'.$row['postanski_broj'].'">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Trenutna lozinka:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="trenutna" value='.$row['password'].'>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Nova lozinka:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="nova1">
                  </div>
                </div>
               <div class="form-group">
                  <label class="col-md-3 control-label">Potvrdite novu lozinku:</label>
                  <div class="col-md-8">
                    <input class="form-control" type="password" name="nova2">
                    <input class="form-control" type="hidden" name="password" value="' . $row['password'] . '"><br><br>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label"></label>
                  <div class="col-md-8">
                    <input type="submit" style="background: #DC0E0E; border: 1px solid #A60202;" class="btn btn-primary" name="updejtaj" value="Promijeni podatke">
                    <span></span>
                    <bottom><br><br><a href="donor.php?OIB='.$OIB.'">Nazad na moj profil</a></bottom>
                  </div>
                </div>
            </div>
        </div>
    </form>
</div>
<hr>  
';

?>