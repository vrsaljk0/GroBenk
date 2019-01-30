<?php
require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");

/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
?>

<link href="popupstyle.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<link href="donorstyle.css" rel="stylesheet">
<!-- Navigation -->

<nav class="navbar navbar-expand-md navbar-light bg-white ">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="img/logo3_.png">&nbsp BloodBank GroBenk</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="indexdonacija.php">Donacija</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                </li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['bolnica_loggedin']) and isset($_SESSION['id'])) {
                        $idbolnica = $_SESSION['id'];
                        echo '
                  <div class="dropdown_donor" style="margin-top: -10px">
                  <button class="dropbtn_donor"><i class="fas fa-hospital"></i></button>
                  <div class="dropdown-content_donor">
                    <a href="bolnica.php"><i class="fas fa-home"></i>&nbspMoj profil</a>
                    <a href="bolnicke_postavke.php?idbolnica='.urlencode($idbolnica).'"><i class="fas fa-cogs"></i>&nbspPostavke</a> 
                    <a href="odjava.php"><i class="fas fa-sign-out-alt"></i>&nbspOdjavi se</a>
                  </div>';
                    } else if (isset($_SESSION['admin_loggedin'])) {
                        echo'
                  <div class="dropdown_donor" style="margin-top: -10px">
                  <button class="dropbtn_donor"><i class="fa fa-user-plus" style="font-size:48px;"></i></button>
                  <div class="dropdown-content_donor">
                    <a href="admin.php"><i class="fas fa-home"></i>&nbspMoj profil</a>
                    <a href="odjava.php"><i class="fas fa-sign-out-alt"></i>&nbspOdjavi se</a>
                  </div>';
                    } else if (isset($_SESSION['donor_loggedin'])) {
                        $OIB = $_SESSION['id'];
                        $info ="select *from donor where OIB_donora = '$OIB'";
                        $run = mysqli_query($conn, $info);
                        $result = $run or die ("Failed to query database". mysqli_error($conn));
                        $row = mysqli_fetch_array($result);
                        $username = $row['username'];
                        echo'
                    <div class="dropdown_donor" style="cursor:pointer;">
					<button class="dropbtn_donor" style="margin-top: -10px"><i class="fas fa-user-circle"></i></button>
					<div class="dropdown_donor">
					  <h3 style="margin-top: -20px">'.$username.'</h3>
					</div>
					<div class="dropdown-content_donor">
					<a href="donor.php"><i class="fas fa-home"></i>&nbspMoj profil</a>
					<a href="postavke.php"><i class="fas fa-cogs"></i>&nbspUredi profil</a> 
					<a href="odjava.php"><i class="fas fa-sign-out-alt"></i>&nbspOdjavi se</a>
					</div>
				    </div>';
                    } else {
                        echo'<button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById(\'modal-wrapper\').style.display=\'block\'">SIGN IN</button>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--PopUp SignIn Form-->
<div id="modal-wrapper" class="modal">
    <form class="modal-content animate" action="krizanje.php" method="POST">

        <div class="imgcontainer">
            <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close Popup">&times;</span>
            <br><h1>Sign in</h1>
        </div>

        <div class="container">
            <div style="padding-top: 40%;" class="textboxlogin">
                <i class="fas fa-user-circle"></i>
                <input type="text" placeholder="Username" name="username" value="" required="">
            </div>

            <div class="textboxlogin">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="password" value="" required="">
            </div>
            <br>
            <input class="btnlogin" type="submit" name="submit" value="Prijavi se"><br>
            <br><br>
            <h6>Nemate račun?</h6> <a href="signup.php">Sign up</a>
        </div>

    </form>
</div>

<script>
    var modal = document.getElementById('modal-wrapper');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
