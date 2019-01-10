<?php
require_once "dbconnect.php"; 

if(isset($_POST['submit'])){
    $OIB = $_POST['oib'];
    $ime = $_POST['ime'];
    $krvna_grupa = $_POST['krvna_grupa'];
    $datum_rod= $_POST['datum_rod'];
    $prebivaliste = $_POST['prebivaliste'];
    $postanskibr = $_POST['postanskibr'];
    $brojmob = $_POST['brojmoba'];
    $email = $_POST['email'];
    $spol = $_POST['spol'];
    $adresa = $_POST['adresa'];
    $username = $_POST['username'];
    $lozinka = $_POST['lozinka'];
    $image = $_FILES['image']['name'];

    $target = "donori/".basename($image);

    $reg_query="insert into donor values('$OIB','$krvna_grupa', '$ime', '$datum_rod', '$prebivaliste', '$postanskibr', '$brojmob','$email', '$spol','$adresa', '$username', '$lozinka', '0', '$image')";
    $reg_run=mysqli_query($conn, $reg_query);
    $result = $reg_run or die("Failed to query database");

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Uspjesno registrirani!";
    }else{
        $msg = "Došlo je do greške obratite se administratoru";
        echo "error:" .mysqli_error($conn);
        echo ' '.$msg;
    }

}
?>

<html>
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
	<link href="signupstyle.css" rel="stylesheet">
</head>
<body class="bodyreg">

<!-- Navigation -->
<div id="nav-placeholder">
</div>

<script>
$(function(){
  $("#nav-placeholder").load("navbar.html");
});
</script>

<!--Signup form-->
<div class="reg-box">
	<form action="" method="POST" enctype="multipart/form-data">
		<h1>Sign up</h1>
		<div class="textboxreg">
			<input type="text" placeholder="Ime i prezime" name="ime" required=""><br>
		</div>

		<div class="textboxreg">
			<p>Spol:</p><br>
				<label class="containerreg"><p>Žensko</p>
  					<input type="radio" name="spol" value="Z">
  					<span class="checkmarkreg"></span>
				</label>

				<label class="containerreg"><p>Muško</p>
  					<input type="radio" name="spol" value="M">
  					<span class="checkmarkreg"></span>
				</label>
		</div>

		<div class="textboxreg">
		<input type="text" placeholder="OIB"  name="oib" required=""><br>
	    </div>

        <div class="textboxreg">
            <input type="text" placeholder="krvna_grupa"  name="krvna_grupa" required=""><br>
        </div>

        <div class="textboxreg">
	    <p>Datum rođenja:</p>
		<input type="date" placeholder="Datum rođenja"  name="datum_rod" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="text" placeholder="Prebivalište"  name="prebivaliste" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="text" placeholder="Adresa"  name="adresa" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="text" placeholder="Poštanski broj"  name="postanskibr" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="number" placeholder="Broj mobitela"  name="brojmoba" required=""><br>
	    </div>

	    <div class="textboxreg">	
	    <input type="email" placeholder="E-mail" name="email" required=""><br>
	    </div>

	    <div class="textboxreg">	
	    <input type="text" placeholder="username" name="username" required=""><br>
	    </div>

	    <div class="textboxreg">	
	    <input type="password" placeholder="Lozinka" name="lozinka" required=""><br>
	    </div>

	    <div class="textboxreg">	
	    <input type ="FILE" placeholder="Slika profila" name="image" required=""><br>
	    </div>

	    <input class="btnreg" type="submit" name="submit" value="Registriraj se"><br>
	</form>
</div>
</body>
</html>