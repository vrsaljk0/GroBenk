<script src="http://code.jquery.com/jquery-latest.js"></script>
<SCRIPT language="javascript">
    function myFunction() {
        document.getElementById("alert").style.display = "none";
    }
    function myFunction2() {
        document.getElementById("alert2").style.display = "none";
    }
</SCRIPT>


<?php
require_once "dbconnect.php";
mysqli_set_charset($conn,"utf8");

if(isset($_POST['submit'])){
    $errorusername=0;
    $errorunos = 0;

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

    $provjera = "SELECT * from donor where username = '$username'";
    $run_provjera = mysqli_query($conn, $provjera);
    $result_provjera = $run_provjera or die ("Failed to query database". mysqli_error($conn));
    if(mysqli_num_rows($result_provjera) != 0){
        $errorusername = 1;
    }
    if (strpos($OIB, '"')!==false or strpos($ime, '"')!==false or $krvna_grupa=="0" or strpos($prebivaliste, '"')!==false or strpos($email, '"')!==false or
        strpos($adresa, '"')!==false or strpos($username, '"')!==false or strpos($lozinka, '"')!==false) {
        $errorunos = 1;
    }
    if ($errorusername == 0 and $errorunos==0){
        $reg_query="insert into donor values('$OIB','$krvna_grupa', '$ime', '$datum_rod', '$prebivaliste', '$postanskibr', '$brojmob','$email', '$spol','$adresa', '$username', '$lozinka', '0', '$image')";
        $reg_run=mysqli_query($conn, $reg_query);
        $result = $reg_run or die("Došlo je pogreške pokušajte ponovno!");

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Uspjesno registrirani!";
        }else{
            $msg = "Došlo je do greške obratite se administratoru";
            echo "error:" .mysqli_error($conn);
            echo ' '.$msg;
        }
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
  $("#nav-placeholder").load("navbar.php");
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
		<input type="number" placeholder="OIB"  name="oib" required=""><br>
	    </div>

        <div class=""><br>
            <select name="krvna_grupa" class="form-control" value="0" style="width: 100%;height:40px;background:url(img/background2.png);background-color: #A60202;color:white">';
                <option value="0">Krvna grupa</option>
                <?php
                $krvna_grupa = array("A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-");
                for ($i = 0; $i < 8; $i++) {
                    echo'<option value=' . $krvna_grupa[$i] . '>' . $krvna_grupa[$i] . '</option>';
                }

                ?>
            </select><br>
        </div>

        <div class="textboxreg">
	    <p>Datum rođenja:</p>
		<input type="date" name="datum_rod" required="" value=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="text" placeholder="Prebivalište"  name="prebivaliste" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="text" placeholder="Adresa"  name="adresa" required=""><br>
	    </div>

	    <div class="textboxreg">
		<input type="number" placeholder="Poštanski broj"  name="postanskibr" required=""><br>
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

    <?php
        if ($errorusername) {
            echo'
            <div class="alert" id = "alert" >
                <span class="closebtn" onclick = "myFunction();" >&times;</span >
            Takav username već postoji!</div >';
        }
        if ($errorunos) {
            echo'
                <div class="alert" id = "alert2" >
                    <span class="closebtn" onclick = "myFunction2();" >&times;</span >
                Pogreška u unosu!</div >';
        }
    ?>
</div>
</body>
</html>