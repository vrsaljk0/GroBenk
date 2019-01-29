<?php

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");
/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['donor_loggedin'])) header("Location:denied_permission.php");

echo '
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BloodBank</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link href="style.css" rel="stylesheet">
    <link href="donorstyle.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
    <link href="tmp.css" rel="stylesheet">
</head>


</head>
<body>';
echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('donornavbar.php');
    });
    </script>";

$OIB = $_SESSION['id'];
$info = "SELECT *from donor where OIB_donora = '$OIB'";
$run = mysqli_query($conn, $info);
$result = $run or die ("Failed to query database". mysqli_error($conn));
$row = mysqli_fetch_array($result);
$moje_ime = $row['ime_prezime_donora'];

$sql = "SELECT * from obavijesti where OIBdonora ='$OIB' and ID_posiljatelja !='1'group by ID_posiljatelja";
$run = mysqli_query($conn, $sql);
$result = $run or die ("Failed to query database". mysqli_error($conn));


$sql_zadnja_admin = "SELECT * from obavijesti WHERE OIBdonora='$OIB' and ID_posiljatelja ='1' order by datum_obav DESC LIMIT 1";
$run_zadnja_admin = mysqli_query($conn, $sql_zadnja_admin);
$result_zadnja_admin =  $run_zadnja_admin or die ("Failed to query database". mysqli_error($conn));
$row_zadnja_admin = mysqli_fetch_array($result_zadnja_admin);
if(mysqli_num_rows($result_zadnja_admin) == 0){
    $zadnji_datum_admin = "";
    $zadnja_poruka_admin = "Trenutno nema poruka";
}
else{
    $zadnji_datum_admin = $row_zadnja_admin['datum_obav'];
    $zadnja_poruka_admin = $row_zadnja_admin['tekst_obav'];
}

echo '
<div class="container">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Povijest poruka</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Pretraži" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
            <div class="chat_list">

                <a href="admin_history.php">
                <div class="chat_people">
                    <div class="chat_img"> <img src="donori/admin.png"> </div>
                    <div class="chat_ib">
                      <h5>Admin <span class="chat_date">'.$zadnji_datum_admin.'</span></h5>
                      <p>'.$zadnja_poruka_admin.'</p>
                       
                    </div>
                </div>
                </a><br>';

while($row = mysqli_fetch_array($result)){
    $OIB_prijatelja = $row['ID_posiljatelja'];
    $prijatelj = "SELECT * from donor where OIB_donora = '$OIB_prijatelja'";
    $run_prijatelj = mysqli_query($conn, $prijatelj);
    $result2 = $run_prijatelj or die ("Failed to query database". mysqli_error($conn));
    $row_prijatelj = mysqli_fetch_array($result2);
    $ime = $row_prijatelj['ime_prezime_donora'];
    $username_prijatelja = $row_prijatelj['username'];

    $sql_zadnja = "SELECT * from obavijesti WHERE (OIBdonora = '$OIB' AND ID_posiljatelja = '$OIB_prijatelja') OR (OIBdonora = '$OIB_prijatelja' AND ID_posiljatelja ='$OIB') order by datum_obav DESC LIMIT 1";
    $run_zadnja = mysqli_query($conn, $sql_zadnja);
    $result_zadnja = $run_zadnja or die ("Failed to query database". mysqli_error($conn));
    $row_zadnja = mysqli_fetch_array($result_zadnja);


    echo '
                <a class="a" href="user_history.php?username='.urlencode($username_prijatelja).'">
                    <div class="chat_people">
                        <div class="chat_img"> <img src="donori/'.$row_prijatelj['image'].'"> </div>
                        <div class="chat_ib">
                          <h5>'.$row_prijatelj['ime_prezime_donora'].'<span class="chat_date">'.$row_zadnja['datum_obav'].'</span></h5>
                          <p>'.$row_zadnja['tekst_obav'].'</p>
                        </div>
                    </div>
                </a><br>';
}

echo'           </div>
            </div>
        </div>

        <div class="mesgs">
            <div class="msg_history">';


                    $sql_admin = "SELECT * from obavijesti where OIBdonora = '$OIB' AND ID_posiljatelja = '1'";
                    $run_admin = mysqli_query($conn, $sql_admin);
                    $result_admin = $run_admin or die ("Failed to query database". mysqli_error($conn));
                    echo '<div class="profile-content">';
                    while($row_admin = mysqli_fetch_array($result_admin)){
                        echo '<div class="incoming_msg">
                                <div class="incoming_msg_img"> <img src="donori/admin.png" alt="sunil"> </div>
                                    <div class="received_msg">
                                    <div class="received_withd_msg">
                                    <p>'.$row_admin['tekst_obav'].'</p>
                                    <span class="time_date"> '.$row_admin['datum_obav'].' |    June 9</span></div>
                                </div>
                            </div>
                            ';
                    }
            echo'</div>
         </div>
    </div>';
?>


