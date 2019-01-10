<?php
	session_start();
	$OIB = $_SESSION['mojOIB'];
	require_once "dbconnect.php";
    //$_SEESION["current"] = $_SERVER['REQUEST_URI'];

echo '
<nav class="navbar navbar-expand-md navbar-light bg-white ">
<div class="container-fluid">
	<a class="navbar-brand" href="index.html"><img src="img/logo3_.png">&nbsp BloodBank GroBenk</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<form class="searchform" action="pretrazi.php" method="GET">
                	<input type="text" name = "trazilica" placeholder="Pretraži ostale donore">
                	<input class="submitsearch" type="submit" name="trazi" value="Traži">
                </form>
			</li>
			<li>
				<div class="dropdown_donor">';
				   $sql = "SELECT * from obavijesti where OIBdonora = '$OIB'";
                   $run = mysqli_query($conn, $sql);
                   $result = $run or die ("Failed to query database". mysqli_error($conn));
                   $class = 'far fa-bell';
                   $neprocitano = 0;
                   while($row = mysqli_fetch_array($result)){
                       if($row['procitano'] == 0) {
                           $class = 'fas fa-bell';
                           $neprocitano = 1;
                           break;
                       }
                   }
                   echo'<button class="dropbtn_donor"><i class="'.$class.'"></i></button>
				  <div class="dropdown-content_donor">';

                    $sql = "SELECT * from obavijesti where OIBdonora = '$OIB' and status='0'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database". mysqli_error($conn));
                    if($neprocitano){
                        echo'<form action="notification.php" method="POST">';
                        while($row = mysqli_fetch_array($result)){
                            echo '<p>'.$row['tekst_obav'].' '.$row['datum_obav'].'  <input type="checkbox" name="check_list[]" onclick="this.form.submit();" value='.$row['id_obavijesti'].'></p>';
                        }
                        echo '<input type="hidden" name="OIB" value="'.$OIB.'">
                    </form>';
                    }
                    else{
                        echo"Nema novih obavijesti";
                    }

				  echo'</div>
				</div>

				 <div class="dropdown_donor">
                  <button class="dropbtn_donor"><i class="far fa-envelope"></i></button>
                  <div class="dropdown-content_donor">
                  </div>
                </div>

				<div class="dropdown_donor">
				  <button class="dropbtn_donor"><i class="fas fa-user-circle"></i></button>
				  <div class="dropdown-content_donor">
				  	<a href="donor.php?OIB='.$OIB.'">Moj profil</a>
				    <a href="postavke.php?OIB_korisnika='.urlencode($OIB).'">Uredi profil</a> 
				    <a href="odjava.php">Odjavi se</a>
				  </div>
				</div>
			</li>
		</ul>
	</div>
</div>
</nav>';

?>


