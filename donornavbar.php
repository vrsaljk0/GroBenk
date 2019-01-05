<?php
	session_start();
	$OIB = $_SESSION['mojOIB'];
	require_once "dbconnect.php";


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
				<div class="dropdown_donor">
				  <button class="dropbtn_donor"><i class="far fa-bell"></i></button>
				  <div class="dropdown-content_donor">
				  </div>
				</div>

				<div class="dropdown_donor">
				  <button class="dropbtn_donor"><i class="far fa-envelope"></i></button>
				  <div class="dropdown-content_donor">
				  </div>
				</div>

				<div class="dropdown_donor">
				  <button class="dropbtn_donor"><i class="fas fa-user-circle"></i></button>
				  <div class="dropdown-content_donor">
				  	<a href='.$_SESSION["current_page"].'>Moj profil</a>
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


