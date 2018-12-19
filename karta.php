<?php

    require_once "dbconnect.php";
 
    $query = "SELECT DISTINCT naziv_lokacije FROM lokacija";
    $run = mysqli_query($conn, $query);
    $myval = "";
   
    echo "<form action='#' method=post>
    	  <select name='myval'>";
        while ($row = mysqli_fetch_array($run)) {
            echo "<option value='" . $row['naziv_lokacije'] ."'>" . $row['naziv_lokacije'] ."</option>";
        }
    echo  '<input type="submit" name="submit"/>';
    echo "</select>
          </form>";

    if(isset($_POST['submit'])){
  		$myval = $_POST['myval'];
  		echo $myval;
	}

	echo'<br><br>';

	$query2 = "SELECT adresa_lokacije FROM lokacija WHERE naziv_lokacije = '".$myval."'";
	$run2 = mysqli_query($conn, $query2);
	$row2 = mysqli_fetch_array($run2);
	echo $row2['adresa_lokacije'];

	echo '
	<br><br>
    <div class="mapouter">
	<div class="gmap_canvas">
		<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q='.$row2["adresa_lokacije"].'&t=&z=7&ie=UTF8&iwloc=&output=embed&z=13" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
		<a href="https://www.crocothemes.net"></a>
	</div>
	<style>
		.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}
	</style>
    </div>';
?>
