<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<?php
    require_once "dbconnect.php";
    session_start();
    $_SESSION["current_page"] = $_SERVER['REQUEST_URI'];
    $date = date("Ymd");

    $idbolnice = $_GET['idbolnice'];
    $password = $_GET['password'];

    $info ="select *from bolnica where  idbolnica = '$idbolnice' and password = '$password'";
    $run = mysqli_query($conn, $info);
    $result = $run or die ("Failed to query database". mysqli_error($conn));

    $row = mysqli_fetch_array($result);

    if ($row['idbolnica'] == $idbolnice && $row['password'] == $password && ("" !== $idbolnice || "" !== $password) ) {
        echo 'Profil '.$row['naziv_bolnice'];
        $id_bolnice = $row['idbolnica']; //trebat će za kasnije
        $naziv_bolnice = $row['naziv_bolnice'];
    } else {
        echo "Pogresna lozinka ili username!";
        exit;
    }
    if(isset($_POST['posalji_zahtjev'])){
        $kolicina = $_POST['kolicina'];
        $krvna_grupa = $_POST['grupa'];
        $sql = "INSERT INTO zahtjev (id_bolnica, kolicina_krvi_zaht, krvna_grupa_zaht, datum_zahtjeva, odobreno) values ('$id_bolnice', '$kolicina', '$krvna_grupa', '$date', '0')";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if(isset($_POST['otkazi_zahtjev'])){
        $id = $_POST['zahtjev'];
        //echo $id;
        $sql = "DELETE FROM zahtjev WHERE idzahtjev='$id'";
        $run = mysqli_query($conn, $sql);
        $result = $run or die ("Failed to query database". mysqli_error($conn));
    }
    if(isset($_POST['komentar'])){
        $tekst = $_POST['tekst'];
        $sql = "INSERT INTO komentari values ('$naziv_bolnice', '$id_bolnice', '$tekst', '$date')";
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
                 <div id="nav">
                    <a href="#content0" >Pošalji zahtjev&nbsp;</a><br><br>
                    <a href="#content1" >Otkazi zahtjev&nbsp;</a><br><br>
                    <a href="#content2">&nbsp;Statistika&nbsp;</a><br><br>
                    <a href="#content3">&nbsp;Postavke&nbsp;</a><br><br>
                    <a href="#content4">&nbsp;Forum&nbsp;</a><br><br>
                    <a href="" onclick="OdjaviMe();">&nbsp;Odjavi se&nbsp;</a>                          
                  </div>
                  <div id="content0" class="toggle" style="display:none" align="center">
                    Pošalji novi zahtjev
                    <form action="" method="POST">
                        Kolicina potrebne krvi <input type="number" name="kolicina" step="0.01"><br><br>
                        Krvna grupa <input type="text" name="grupa"><br><br>
                        <input type="submit" name="posalji_zahtjev" value="Posalji zahtjev">
                    </form>
                  </div>
                  <div id="content1" class="toggle" style="display:none" align="center">
                    Otkazi zahtjev';
                    $query = "SELECT *from zahtjev WHERE id_bolnica='$id_bolnice' and  odobreno='0'";
                    $run = mysqli_query($conn, $query);
                    echo '<form action="" method="POST">
                                  <select name="zahtjev">';
                                        while ($row = mysqli_fetch_array($run)) {
                                            echo "<option value='" . $row['idzahtjev'] ."'>" . $row['kolicina_krvi_zaht'] ."l  " . $row['krvna_grupa_zaht']."</option>";
                                        }
                                        echo  '<input type="submit" name="otkazi_zahtjev" value="Otkazi"/>
                                    </select>
                           </form>';

                  echo '</div>
                  <div id="content2" class="toggle" style="display:none">Statistika</div>
                  <div id="content3" class="toggle" style="display:none">Postavke</div>      
                  <div id="content4" class="toggle" style="display:none">Forumic<br><br>';
                    $sql = "SELECT * from komentari where idbolnica_bol = '$id_bolnice'";
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
                        ';
                  echo'</div>  
                 
                 <script src="http://code.jquery.com/jquery-latest.js"></script>   
                 <script  type="text/javascript">
                        $("#nav a").click(function(e){
                            e.preventDefault();
                            $(".toggle").hide();
                            var toShow = $(this).attr(\'href\');
                            $(toShow).show();
  
                        });
                 </script>
             </body>';



?>