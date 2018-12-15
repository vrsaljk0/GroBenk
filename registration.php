<?php
require_once "dbconnect.php"; //fancy include just because I can

if(isset($_POST['submit'])){
    $OIB = $_POST['oib'];
    $ime = $_POST['ime'];
    $datum_rod= $_POST['datum_rod'];
    $prebivaliste = $_POST['prebivaliste'];
    $postanskibr = $_POST['postanskibr'];
    $brojmob = $_POST['brojmoba'];
    $email = $_POST['email'];
    $spol = $_POST['spol'];
    $adresa = $_POST['adresa'];
    $lozinka = $_POST['lozinka'];
    $user_pic = $_POST['user_pic'];

    $reg_query="insert into donor values('$OIB','$ime','$user_pic','$datum_rod', '$prebivaliste', '$postanskibr', '$brojmob','$email', '$spol','$adresa', '$lozinka', 0)";
    $reg_run=mysqli_query($conn, $reg_query);

    if($reg_run){
        echo "Zahvaljujemo na registraciji! ide neki kul js koji promijeni sve ovo dolje u sign in!";
    }
    else {
        echo "error:" .mysqli_error($conn);
    }
}
?>
<html>
<body>
    <form action="" method="POST">
         Ime i prezime:
        <input type="text" name="ime" required=""><br>
        Spol
        <style="text-align:center"> Žensko
        <input class="spol" type="radio" name="spol" value="Z">
        Muško <input class="spol" type="radio" name="spol" value="M" ><br>
        OIB
        <input type="number" name="oib" required=""><br>
        Datum rođenja
        <input type="date" name="datum_rod" required=""><br>
        Prebivalište
        <input type="text" name="prebivaliste" required=""><br>
        Adresa
        <input type="text" name="adresa" required=""><br>
        Poštanski broj
        <input type="number" name="postanskibr" required=""><br>
        Broj mobitela
        <input type="number" name="brojmoba" required=""><br>
        Email
        <input type="email" name="email" required=""><br>
        Lozinka
        <input type="password" name="lozinka" required=""><br>
        Vasa slika profila
        <input type ="FILE" name="user_pic" required="" ><br> <!-- ne znam kako sad prikazati tu učitanu sliku to je valjda jquery -->

        <input type="submit" name="submit" value="Posalji"><br>
        Već imate profil ? <a href="login.php">Ulogirajte se</a>
        </form>
</body>
</html>