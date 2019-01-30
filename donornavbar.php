<?php
require_once "dbconnect.php";
session_start();
$OIB = $_SESSION['id'];

/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!$_SESSION['donor_loggedin']) header("Location:denied_permission.php");

$info = "SELECT username from donor WHERE OIB_donora = '$OIB'";
$run = mysqli_query($conn, $info);
$result = $run or die ("Failed to query database". mysqli_error($conn));
$row = mysqli_fetch_array($result);
$username = $row['username'];

require_once "dbconnect.php";
mysqli_set_charset($conn,"utf8");
//$_SEESION["current"] = $_SERVER['REQUEST_URI'];

echo '
<html>
<head>
<style>
	<link href="cs.css" rel="stylesheet">
</style>
</head>

<nav class="navbar navbar-expand-md navbar-light bg-white ">
<div class="container-fluid">
	<a style="width:30%;" class="navbar-brand" href="index.php"><img src="img/logo3_.png">&nbsp BloodBank GroBenk</a>
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
					$sql = "SELECT * from obavijesti where OIBdonora = '$OIB' and procitano='0'";
					$run = mysqli_query($conn, $sql);
					$result = $run or die ("Failed to query database". mysqli_error($conn));
					$broj_obav = mysqli_num_rows($result);
					$class = 'far fa-bell';
					$neprocitano = 0;
					while($row = mysqli_fetch_array($result)){
					    if($row['procitano'] == 0) {
					        $class = 'fas fa-bell';
					        $neprocitano = 1;
					        break;
					    }
					}
					echo'
					<button class="dropbtn_donor"><i class="'.$class.'"></i></button>
						<div style="width:500px; max-height: 450px; overflow-y:scroll;" class="dropdown-content_donor">
						            <div style="text-align:center;" class="notify-drop-title">
						                <div style="border-bottom:solid; height:70px;">
						                    <br><h4>Obavijesti (<b>'.$broj_obav.'</b>)</h4>
						                </div>
						            </div>
						';
							//ajmo prvo obavijesti od admina
							$sql = "SELECT * from obavijesti where OIBdonora = '$OIB' and procitano='0' and ID_posiljatelja = '1'";
							$run = mysqli_query($conn, $sql);
							$result = $run or die ("Failed to query database". mysqli_error($conn));
							
							if($neprocitano){
							    if(mysqli_num_rows($result) != 0){
								    echo'
								    <form action="notification.php" method="POST">';
								    echo'<b>ADMIN</b><br>';
								    while($row = mysqli_fetch_array($result)){
								    	$d = $row['datum_obav'];
									    $day = date("d", strtotime($d));
									    $month = date("m", strtotime($d));
									    $year = date("Y", strtotime($d));
									    $hour = date("H", strtotime($d));
	    								$min = date("i", strtotime($d));
									echo '
					                 	<div>
						                    <span style="height:50px; width:50px; float:right;">
						                    	<input style="margin-top:5px;" class="squaredTwo" type="checkbox" name="check_list[]" onclick="this.form.submit();" value='.$row['id_obavijesti'].'>
						                    </span>

						                    <img style="width:50px; height:50px;" src="donori/admin.png">
											<span style="display: inline-block; width:350px; padding-left: 15px; margin-left:60px margin-right:60px;;">
											'.$row['tekst_obav'].'
											</span>
						                    	
						                    	<p style = "margin-left:10px; margin-top:10px;" class="time"><i>'.$day.'. '.$month.' '.$year.'. '.$hour.':'.$min.'</i></p>
					                    </div>
					                    <hr>';
								    }
								    echo '<input type="hidden" name="OIB" value="'.$OIB.'">
								    </form>';
								}
							}
							$sql = "SELECT * from obavijesti where OIBdonora = '$OIB' and procitano='0' and ID_posiljatelja != '1'";
							$run = mysqli_query($conn, $sql);
							$result = $run or die ("Failed to query database". mysqli_error($conn));
							if(mysqli_num_rows($result) != 0){
								if($neprocitano){
								    echo'
								    <form action="notification.php" method="POST">';
								    echo'<b>KORISNICI</b><br>';
								    while($row = mysqli_fetch_array($result)){
								    	$d = $row['datum_obav'];
									    $day = date("d", strtotime($d));
									    $month = date("m", strtotime($d));
									    $year = date("Y", strtotime($d));
									    $hour = date("H", strtotime($d));
	    								$min = date("i", strtotime($d));

								    	$OIB_prijatelja = $row['ID_posiljatelja'];
								    	$prijatelj = "SELECT * from donor where OIB_donora = '$OIB_prijatelja'";
										$run_prijatelj = mysqli_query($conn, $prijatelj);
										$result2 = $run_prijatelj or die ("Failed to query database". mysqli_error($conn));
										$row_prijatelj = mysqli_fetch_array($result2);
										$ime = $row_prijatelj['ime_prezime_donora'];
										$username_prijatelja = $row_prijatelj['username'];
										$image_prijatelja = $row_prijatelj['image'];
										echo '

										<div>
										<a href="publicprofile.php?username='.urlencode($username_prijatelja).'"><font color="DC0E0E">'.$row_prijatelj['ime_prezime_donora'].'</font></a>
						                    <span style="height:50px; width:50px; float:right;">
						                    	<input style="margin-top:5px;" class="squaredTwo" type="checkbox" name="check_list[]" onclick="this.form.submit();" value='.$row['id_obavijesti'].'>
						                    </span>

					                    <img style="width:50px; height:50px;" src="donori/'.$image_prijatelja.'">
										<span style="display: inline-block; width:350px; padding-left: 15px; margin-left:60px margin-right:60px;;">
										'.$row['tekst_obav'].'
										</span>
					                    	
					                    	<p style = "margin-left:10px; margin-top:10px;" class="time"><i>'.$day.'. '.$month.' '.$year.'. '.$hour.':'.$min.'</i></p>
					                    </div>
					                    <hr>';
					                    
								    }


								    echo '<a href="history.php">Prikaži sve</a>
								    <input type="hidden" name="OIB" value="'.$OIB.'">
								    </form>';
								}

							}
							else{
							    echo'Nema novih obavijesti
							       <a href="history.php">Prikaži sve</a>';
							}
						echo'
						</div>
				 </div>
				 

				<div class="dropdown_donor" style="cursor:pointer;">
					<button class="dropbtn_donor"><i class="fas fa-user-circle"></i></button>
					<div class="dropdown_donor">
					  <h3>'.$username.'</h3>
					</div>
					<div class="dropdown-content_donor">
					<a href="donor.php"><i class="fas fa-home"></i>&nbspMoj profil</a>
					<a href="postavke.php"><i class="fas fa-cogs"></i>&nbspUredi profil</a> 
					<a href="odjava.php"><i class="fas fa-sign-out-alt"></i>&nbspOdjavi se</a>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>
</nav>
</html>'
						;

?>


