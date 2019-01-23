<?php
    require_once ("dbconnect.php");
    session_start();
    mysqli_set_charset($conn,"utf8");

    /** SESSION TIMEOUT */
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();

    if (!$_SESSION['admin_loggedin']) header("Location:denied_permission.php");
    echo'Dobrodošao admine!


    <div>
       <a href="eventi.php?keyword=&trazi=Traži" >Eventi&nbsp;</a>
       <a href="zahtjevi.php">&nbsp;Zahtjevi&nbsp;</a>
       <a href="donacije.php?keyword=&trazi=Traži">&nbsp;Donacije&nbsp;</a>
       <a href="obavijesti.php">&nbsp;Obavijesti&nbsp;</a>
       <a href="statistika.php">&nbsp;Statistika&nbsp;</a>
       <a href="odjava.php">&nbsp;Odjavi se&nbsp;</a>
   </div><br><br>';
    /** kadgod se klikne na uredi_event link se sjebe i vise ne zna sta je idEvent
      stavila sam u formu hidden input jer inace nez kako da saljem taj id :((((  */
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
    }

    $sql = "SELECT * from lokacija where id_lokacije = '$id'";
    $run = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($run);

    echo'<form action=" "method="POST" enctype="multipart/form-data">    
            DATUM <input type="date" name = "datum" value="'.$row['datum_dogadaja'].'" required=""><br><br>
            GRAD <input type="text" name = "grad" value="'.$row['grad'].'" required=""><br><br>
            LOKACIJA <input type="text" name = "lokacija" value="'.$row['naziv_lokacije'].'" required=""><br><br>
            ADRESA <input type="text" name = "adresa" value="'.$row['adresa_lokacije'].'" required=""><br><br>
            POŠTANSKI BROJ <input type="number" name = "postbroj" value="'.$row['postanski_broj'].'" required=""><br><br>
            POČINJE <input type="time" name = "startt" value="'.$row['start'].'" required=""><br><br>
            ZAVRŠAVA <input type="time" name = "kraj" value="'.$row['kraj'].'" required=""><br><br>
            <input type="hidden" name = "id" value="'.$id.'" required="">
            <img src="lokacije/'.$row['image'].'" class="avatar img-thumbnail" alt="avatar"><br><br>
            <input type="file" name = "image" class="form-control"><br><br>
            <input type="hidden" name="image_text" value="'.$row['naziv_lokacije'].'">
            <input type="submit" name="uredi_event" value="Spremi promjene"><br><br>
        </form>';

?>