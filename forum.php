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

    if(isset($_POST['komentar'])){
        $tekst = $_POST['tekst'];
        $sql = "INSERT INTO komentari values ('$naziv_bolnice', '$idbolnica', '$tekst', '$date')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }

echo'
        <html>
             <head><title>Profil bolnice</title></head>
             <body>
                 <div id="info">
                    <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="200" height="200"><br><br>
                
                 </div>
                 <div id="linkovi">
                    <a href="posalji_zahtjev.php" >Pošalji zahtjev&nbsp;</a><br><br>
                    <a href="otkazi_zahtjev.php" >Otkazi zahtjev&nbsp;</a><br><br>
                    <a href="bolnicka_statistika.php">&nbsp;Statistika&nbsp;</a><br><br>
                    <a href="bolnicke_postavke.php">&nbsp;Postavke&nbsp;</a><br><br>
                    <a href="forum.php">&nbsp;Forum&nbsp;</a><br><br>
                    <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>                          
                 </div>

         <div id="forum">Forumic<br><br>';
                    $sql = "SELECT * from komentari where idbolnica_bol = '$idbolnica'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    while($row = mysqli_fetch_array($run)){
                        echo '<i>'.$row['autor'].' komentirao je '. $row['datum_kom'].' :<br><br></i>';
                        echo $row['tekst_komentara'].'<br><br>';
                    }
                    echo'<textarea name="tekst" id="tekst" form="myform"></textarea>
                        <form action="" method="POST" id="myform">
                          <input type="submit" value="Komentiraj" name="komentar"> 
                        </form>
                <div>';

?>