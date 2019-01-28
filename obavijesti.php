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

    function myFunction() {
      document.getElementById("alert").style.display = "none";
    }

    function myFunctionerror() {
        document.getElementById("alerterror").style.display = "none";
    }

</SCRIPT>

<?php

require_once ("dbconnect.php");
session_start();
mysqli_set_charset($conn,"utf8");

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");

echo '
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BloodBank</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
                <a class="nav-link" href="eventi.php?keyword=&trazi=Tra%C5%BEi">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="donacije.php?keyword=&trazi=Traži">Donacije</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';

echo "
<div id='supplies' onload></div>
<script>
$(function(){
  $('#supplies').load('zalihe.php');
});
</script>"
;
$error=0;
echo '
<div class="col-md-8">';
if(isset($_GET['obavijest'])) {
    $grad = $_GET['grad'];
    $krvna_grupa = $_GET['kgrupa'];

    $tekst = $_GET['tekst'];

    $datum = date('Y-m-d');
    $status = 0;
    if (strlen($tekst)<5) {
        $error=1;
    } else {
        if ($krvna_grupa == '0' and $grad == '0') {
            $sql = "SELECT * from donor where 1";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
        }
        if ($krvna_grupa == '0' and $grad != '0') {
            $sql = "SELECT * from donor where prebivaliste = '$grad'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
        }
        if ($grad == '0' and $krvna_grupa != '0') {
            $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
        }
        if ($krvna_grupa != '0' and $grad != '0') {
            $sql = "SELECT * from donor where krvna_grupa_don = '$krvna_grupa' and prebivaliste = '$grad'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));
        }

        while ($row = mysqli_fetch_array($run)) {
            $OIB = $row['OIB_donora'];
            $sqll = "INSERT INTO obavijesti (OIBdonora, ID_posiljatelja, tekst_obav, datum_obav, procitano) VALUES ('$OIB', '1', '$tekst', '$datum', '$status')";
            $runn = mysqli_query($conn, $sqll);
            $resultt = $runn or die ("Failed to query database" . mysqli_error($conn));
        }
    }

    if($error) {
    echo'<div class="alert" id="alerterror">
          <span class="closebtn" onclick="myFunctionerror();">&times;</span> 
          Obavijest mora sadržavati minimalno 5 znakova.</div>';
    }
    else {
    echo '
    <div class="alert" id="alert">
      <span class="closebtn" onclick="myFunction();">&times;</span> 
      Obavijest: "'.$tekst.'" uspiješno poslana</div>';
    }

}

echo '
    <div id="content7" class="toggle_obavijesti">     
        <form id = "obavijest" method="GET" action="">
            <span class="select">
               <select id="kgrupa" name="kgrupa">
               <option value="0">Krvna grupa</option>

               ';
                $krvna_grupa = array("A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-");
                for ($i = 0; $i < 8; $i++) {
                    echo '
                    <option value='.$krvna_grupa[$i].'>'.$krvna_grupa[$i].'</option>';
                }

            echo'
                </select>
            </span>';

        $query = "select * from donor group by prebivaliste";
        $run = mysqli_query($conn, $query);
        $result = $run or die ("Failed to query database". mysqli_error($conn));

        echo'
        <span class="select">
            <select name="grad" id ="grad">
                <option value="0">Grad</option>';
        while ($row = mysqli_fetch_array($run)) {
            echo 
                '<option value="'.$row['prebivaliste'].'">'.$row['prebivaliste'].'</option>';
        }
            echo '
            </select>
        </span>
            <br><textarea placeholder="Napiši obavijest..." name="tekst" id="tekst" form="obavijest"></textarea><br>
            <input type="submit" class="newbutton" name="obavijest" value="Pošalji">
        </form>
    </div>
    <div style="height:200px;">
    </div>
</div>';
?>