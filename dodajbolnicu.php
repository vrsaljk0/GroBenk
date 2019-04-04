<script src="http://code.jquery.com/jquery-latest.js"></script>

<SCRIPT language="javascript">

    function myFunction() {
        document.getElementById("alert").style.display = "none";
    }

</SCRIPT>

<?php

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();
$flag=0;
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
<div class="admin-content" >
        <ul class="nav nav-tabs" id="myTab" style="width:1050px;margin-left: -140px">
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Pretraži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dodajbolnicu.php">Dodaj bolnicu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pregled.php">Pregled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/GroBenk-Vol2/donacije.php?keyword=&trazi=Tra%C5%BEi">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $naziv = $_POST['naziv'];
    $grad = $_POST['grad'];
    $adresa = $_POST['adresa'];
    $pbroj = $_POST['pbroj'];
    $pass = $_POST['pass'];

    $query = "insert into bolnica values ('$id', '$naziv', '$grad', '$adresa', '$pbroj', '$pass')";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database" . mysqli_error($conn));

    if ($run) $flag=1;
}

echo'

    <div style="width:30%;float:left;padding:50px;border-right: 3px solid #DC0E0E;margin-top: 30px;opacity:0.8">
        <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="100%" >
    </div>
    <div style="width:69%;float:right;padding:50px;margin-top: 30px">
        <h2>Dodaj novu bolnicu</h2><br>
        
        <form action="" method="POST">
            <table style="width:500px;height:400px">
                <tr>
                    <td><label>ID</label></td>
                    <td><input type="number" name="id" required="" style="border-radius: 5px;"></td>
                </tr> 
                <tr>
                    <td><label>Naziv</label></td>
                    <td><input type="text" name="naziv" required="" style="border-radius: 5px;"></td>
                </tr>
                <tr>
                    <td><label>Grad</label></td>
                    <td><input type="text" name="grad" required="" style="border-radius: 5px;"></td>
                </tr> 
                <tr>  
                    <td><label>Adresa</label></td>
                    <td><input type="text" name="adresa" required="" style="border-radius: 5px;"></td>
                </tr> 
                <tr>   
                    <td><label>Poštanski broj</label></td>
                    <td><input type="number" name="pbroj" required="" style="border-radius: 5px;"></td>
                </tr> 
                <tr>    
                    <td><label>Password</label></td>
                    <td><input type="text" name="pass" required="" style="border-radius: 5px;"></td>
                 </tr> 
             </table><br>
                <input type="submit" name="submit" class="zbtn" value="Dodaj bolnicu">
        </form>';

        if ($flag) echo 'Bolnica '.$naziv.' je uspješno dodana.';
    echo'</div>

<hr>  
';

?>