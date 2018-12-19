<script>
    function OdjaviMe(){
        window.location.replace('odjava.php');
    }
</script>

<?php
/** donor.php ključni file!
 * 1.prikazati osnovne informacije o donoru -> ✓
 * 2.omogućiti pretraživavnje ostalih donora -> ✓
 * 3.followanje/unfollowanje ostalih donora -> ✓
 * 4.pregledati koje donore folujem -> -
 * 5.urediti postavke svog računa -> -
 * 6. poslati poruku ostalim korisnicima -> Z A J E B N O -
 * 7. ispisati povijest mojih donacija -> easy al still -
 * 8. označiti da dolazim na nove evente -> -
 * 9.odjava-> ✓
 *+10. da se ulogiraju s usernameom al to ću na kraju jer triba sve minjati onda rip
 */


require_once "dbconnect.php"; //fancy include just because I can
require_once "functions.php";
session_start();
/**
 * dbconnect.php služi za povezivanje s bazom
 * functions.php file sa funkcijama koje se ponavljaju u kodu to ću još urediti da kod bude pregledniji
 * kad se ulogiram želim da se zapamti s kojim sam se OIB ulogirala pa pokrećem session
 */

$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

/**
 * url donor.php za svakog donora izgleda drugačije i onda kad se krećem po ostalim stranicama i želim se vratiti nazad
 * ne mogu samo na donor.php pa u session varijablu current_page pamtim url
 */

$OIB = $_GET['OIB'];
$password = $_GET['password'];
/**
 * preko GET metode sam iz login.html dobila OIB i pass. (GET jer želimo pass sakriti u URL-U)
 */

//neke pizdarije koje očiste oib i password rekla bi čak nebitno za nas sad
$OIB = stripcslashes($OIB);
$password = stripcslashes($password);
$OIB = mysqli_real_escape_string($conn,$OIB);
$password = mysqli_real_escape_string ($conn, $password);

//tražim donora sa oib i pass u bazi
$query ="select *from donor where OIB_donora = '$OIB' and password = '$password'";
$run = mysqli_query($conn, $query);
$result = $run or die ("Failed to query database". mysqli_error($conn));

$row = mysqli_fetch_array($result); //dohvaćam sve takve

if ($row['OIB_donora'] == $OIB && $row['password'] == $password && ("" !== $OIB || "" !== $password) ) {
    echo "Dobrodošao ".$row['ime_prezime_donora']." !<br><br>";
    $_SESSION["OIB_donora"] = $OIB; //spremam session varijablu da je mogu kasnije koristiti
    $_SESSION["ime"] = $row['ime_prezime_donora'];
} else {
    echo "Pogresna lozinka ili OIB!";
    exit;
}
/**
 * sad slijedi dio sa izgledom koji treba ljepše izorganizirati u divove i pizdarije al zasad se fokusiram na funkcionalnost.
 */


//search bar koji preusmjeri na pretraži.php sa METODOM GET ZA KOJU TREBA IMATI INPUT TYPE SUBMIT
echo '<center>
        <form action="pretrazi.php" method="GET">
            <input type="text" name = "trazilica" placeholder="Pretraži ostale donore">
            <input type="submit" name="trazi" value="Traži">
        </form>
     </center>';

//sustav bodovanja onako od oka
if($row['br_donacija'] <= 20 ) $str = '*';
else if($row['br_donacija'] <= 30) $str='**';
else if($row['br_donacija'] <= 50) $str = '***';


    //prikaz osnovnih informacija o donoru
echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['profile_pic'] ).'"/><br><br>
      <b>' .$row['ime_prezime_donora'].'</b><br><br>';
echo'<a id="following" title="Click" href="#" onclick="PokaziFollowing()">'; echo count_following($OIB); echo'</a>';
echo'<a id="following" title="Click" href="#" onclick="PokaziFollowers()">'; echo count_followers($OIB); echo'</a>';

/*rezultat klikanja na linkove->ne radi! aaaa
$sql = "SELECT  donor.ime_prezime_donora from donor, following where followig.OIB_donora = $OIB and  donor.OIB_donora = OIB_prijatelja";
*/

echo  '
      <center>
      
      </center>
      Rođena: ' .$row['datum_rodenja'].'<br><br>
      Živi u mjestu: '. $row['prebivaliste']. '<br><br>
      Kontakt: '. $row['mail_donora']. '<br><br>
      <b>'.$row['ime_prezime_donora'].' je donirala ' .$row['br_donacija']. ' puta</b><br> čime je zaslužila ' .$str. ' u našoj banci<br><br>
      <input type="submit" name="poruka" value="Moj Inbox"><br><br> 
      <input type="submit" name="postavke" value="Postavke"><br><br>
      <input type="submit" name="odjava" value="Odjavi se" onclick="OdjaviMe()"><br><br>
           
      ';
?>
