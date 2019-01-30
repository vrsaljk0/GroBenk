<?php

  require_once ("dbconnect.php");
  session_start();
  mysqli_set_charset($conn,"utf8");

  /** SESSION TIMEOUT */
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
  }
  $_SESSION['LAST_ACTIVITY'] = time();

  if (!isset($_SESSION['donor_loggedin'])) header("Location:denied_permission.php");

  $id_bolnice = $_GET['id_bolnice'];
  $OIB = $_SESSION['id'];
$_SESSION['vratime'] = $_SERVER['REQUEST_URI'];

  $query ="select * from donor where OIB_donora = '$OIB'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row_donor = mysqli_fetch_assoc($result);
  $ime = $row_donor['ime_prezime_donora'];
  $username = $row_donor['username'];

  $date = date('Y-m-d H:i:s');

  $query ="select * from bolnica where idbolnica = '$id_bolnice'";
  $run = mysqli_query($conn, $query);
  $result = $run or die ("Failed to query database". mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);

  if(isset($_POST['komentar'])){
    $tekst = $_POST['tekst'];
    if($tekst!=''){
      $sql = "INSERT INTO komentari values ('$username', '$ime', '$id_bolnice', '$tekst', '$date')";
      $run = mysqli_query($conn, $sql);
      $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    $url = 'publicforum.php?id_bolnice='.urlencode($id_bolnice);
    header("Location:$url");
  }
  $results_per_page = 3;
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
        <link href="bolnicastyle.css" rel="stylesheet">
    </head>';

echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('donornavbar.php');
    });
    </script>";

echo'
<div class="profil-img">
  <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg">
  <div class="profil-info">
    <div class="profil-title">
     <h1>'.$row['naziv_bolnice'].'<a href="karta.php?naziv='.$row['naziv_bolnice'].'&adresa='.$row['adresa_bolnice'].'"><img src="kontakt\lokacija.png" style="margin:0; width:50px;height:50px"></a></h1>
    </div>
    <div class="profil-content">
        <ul class="nav nav-tabs" id="myTab" >
            <li class="nav-item">
                <a class="nav-link" href="publicbolnica.php?id_bolnice='.urlencode($id_bolnice).'">Općenito</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="publicforum.php?id_bolnice='.urlencode($id_bolnice).'">Forum</a>
            </li>
        </ul>
    </div>
    <div class="col-md-8">';
        $sql = "SELECT * from komentari where idbolnica_bol = '$id_bolnice'";
        $run = mysqli_query($conn, $sql);
        $number_of_results = mysqli_num_rows($run);
        $number_of_pages = ceil($number_of_results/$results_per_page);
        $result = $run or die ("Failed to query database". mysqli_error($conn));

        if(!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $this_page_first_result = ($page-1)*$results_per_page;

        $sql = "SELECT * FROM komentari where idbolnica_bol = '$id_bolnice' order by datum_kom desc LIMIT " . $this_page_first_result . ',' . $results_per_page;
        $run = mysqli_query($conn, $sql);

        if($page == 1) {
        echo '
        <div class="com-box">
            <div class="row">
                <div style="border-style:none;" class="col-md-6">
                    <div class="widget-area no-padding blank">
                        <div class="status-upload">
                            <form action="" method="POST" id="myform">
                                <textarea name="tekst" id="tekst" form="myform" placeholder="Komentiraj..." ></textarea>
                                <input type="submit" value="Objavi" name="komentar"> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div><br><br><br><br><br>
        ';
        }
        while($row = mysqli_fetch_array($run)){
            $donor = 0;
            $bolnica = 0;
            echo '
            <div class="com-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="panel panel-white post panel-shadow">
                            <div class="post-heading">
                                <div class="pull-left image">';
                                 if(is_numeric ($row['user_autora'])) { 
                                    echo '
                                    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" class="img-circle avatar" alt="user profile image">';
                                    $bolnica = 1;
                                }
                                else {
                                    $username = $row['user_autora'];
                                    $don = "SELECT * from donor where username = '$username'";
                                    $run2 = mysqli_query($conn, $don);
                                    $result = $run2 or die ("Failed to query database" . mysqli_error($conn));
                                    $row_don = mysqli_fetch_array($run2);
                                    echo '<img src="donori/' . $row_don['image'] . '" class="img-circle avatar" alt="user profile image">';
                                    $donor = 1;
                                }
                                echo '
                                </div>
                                <div class="pull-left meta">
                                    <div class="title h5">';
                                        if($bolnica == 1){
                                          echo'<a href="publicbolnica.php?id_bolnice='.urlencode($row['user_autora']).'"><b>'.$row['autor'].'</b></a>';
                                        }
                                        else if($donor==1){
                                          echo'<a href="publicprofile.php?username='.urlencode($row['user_autora']).'"><b>'.$row['autor'].'</b></a>';
                                        }
                                        echo'
                                        komentira:
                                    </div>
                                    <h6 class="text-muted time">'. $row['datum_kom'].'</h6>
                                </div>
                            </div> 
                            <div class="post-description"> 
                                <p>'.$row['tekst_komentara'].'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            ';
        }
        echo '<div class="pagdiv">';
        $tmp = $page-1;
        $pocetak = floor(($tmp/4))*4+1;
        $tmp2 = $pocetak-1;
        if($pocetak+4 > $number_of_pages) $kraj = $number_of_pages+1;
        else $kraj = $pocetak+4;
        if($tmp2 > 3) {
            echo'
            <span class="pagination">
            <a href="publicforum.php?page=' . $tmp2 .'&id_bolnice='.urlencode($id_bolnice).'">&laquo;</a>
            </span>';
        }
        for($i=$pocetak;$i<$kraj;$i++) {
            echo '
            <span class="pagination">';
            if($i == $page) {
                echo '
                <a href="publicforum.php?page=' . $i .'&id_bolnice='.urlencode($id_bolnice).'" class="active">' . $i . '</a> ';
            }
            else {
                echo '
                <a href="publicforum.php?page=' . $i .'&id_bolnice='.urlencode($id_bolnice).'">' . $i . '</a>'; 
            }
            echo '</span>';
        }
        if($kraj <= $number_of_pages) {
            echo'
            <span class="pagination">
            <a href="publicforum.php?page=' . $kraj .'&id_bolnice='.urlencode($id_bolnice).'">&raquo;</a>
            </span>';
        }
        echo '
        </div>
    </div>
  </div>
</div>';
?>