<script src="http://code.jquery.com/jquery-latest.js"></script>
<?php
    session_start();
    require_once "dbconnect.php";
    $flag = 3;
    mysqli_set_charset($conn,"utf8");

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        header("Location:odjava.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time();
    if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");

    if(isset($_POST['submit'])){
    $sist1 = $_POST['sist'];
    $dijast1 = $_POST['dijast'];
    $bpm1 = $_POST['bpm'];
    $datum1 = date('Y-m-d H:i:s');

    $query = "insert into pregled (bpm, sistolicki, datum, dijastolicki) values ('$bpm1', '$sist1', '$datum1', '$dijast1')";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database" . mysqli_error($conn));
    if ($bpm1 > 55 and $bpm1 < 85 and  $sist1 > 105 and $sist1 < 150 and $dijast1 > 60 and $dijast1 < 95) {
        $flag = 1;
    } else {
        $flag = 0;
    }
    }

    $sql = "select bpm, sistolicki, dijastolicki, datum from pregled order by datum desc limit 50";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    while ($row = mysqli_fetch_assoc($result))
    {
        $bpm[$i] = $row['bpm'];
        $sist[$i] = $row['sistolicki'];
        $dijast[$i] = $row['dijastolicki'];
        $i++;
    }
?>
<SCRIPT language="javascript">

    function myFunction() {
        document.getElementById("alert").style.display = "none";
    }
</SCRIPT>

<script>
    window.onload = function () {
        var bpm1 = <?php echo $bpm[0]?>;
        var bpm2 = <?php echo $bpm[1]?>;
        var bpm3 = <?php echo $bpm[2]?>;
        var bpm4 = <?php echo $bpm[3]?>;
        var bpm5 = <?php echo $bpm[4]?>;
        var bpm6 = <?php echo $bpm[5]?>;
        var bpm7 = <?php echo $bpm[6]?>;
        var bpm8 = <?php echo $bpm[7]?>;
        var bpm9 = <?php echo $bpm[8]?>;
        var bpm10 = <?php echo $bpm[9]?>;
        var sist1 = <?php echo $sist[0]?>;
        var sist2 = <?php echo $sist[1]?>;
        var sist3 = <?php echo $sist[2]?>;
        var sist4 = <?php echo $sist[3]?>;
        var sist5 = <?php echo $sist[4]?>;
        var sist6 = <?php echo $sist[5]?>;
        var sist7 = <?php echo $sist[6]?>;
        var sist8 = <?php echo $sist[7]?>;
        var sist9 = <?php echo $sist[8]?>;
        var sist10 = <?php echo $sist[9]?>;
        var dijast1 = <?php echo $dijast[0]?>;
        var dijast2 = <?php echo $dijast[1]?>;
        var dijast3 = <?php echo $dijast[2]?>;
        var dijast4 = <?php echo $dijast[3]?>;
        var dijast5 = <?php echo $dijast[4]?>;
        var dijast6 = <?php echo $dijast[5]?>;
        var dijast7 = <?php echo $dijast[6]?>;
        var dijast8 = <?php echo $dijast[7]?>;
        var dijast9 = <?php echo $dijast[8]?>;
        var dijast10 = <?php echo $dijast[9]?>;

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title:{
                //text: "Daily High Temperature at Different Beaches"
            },
            axisX: {
                //valueFormatString: "DD MMM,YY"
            },
            axisY: {
                //title: "Temperature (in °C)",
                includeZero: false,
                //suffix: " °C"
            },
            legend:{
                cursor: "pointer",
                fontSize: 16,
                itemclick: toggleDataSeries
            },
            toolTip:{
                shared: true
            },
            data: [{
                name: "BPM",
                type: "spline",
                //yValueFormatString: "#0.## °C",
                showInLegend: true,
                dataPoints: [
                        { x: 1, y: bpm1 },
                        { x: 2, y: bpm2 },
                        { x: 3, y: bpm3 },
                        { x: 4, y: bpm4 },
                        { x: 5, y: bpm5 },
                        { x: 6, y: bpm6 },
                        { x: 7, y: bpm7 },
                        { x: 8, y: bpm8 },
                        { x: 9, y: bpm9 },
                        { x: 10, y: bpm10 }
                ]
            },
                {
                    name: "Sistolički",
                    type: "spline",
                    //yValueFormatString: "#0.## °C",
                    showInLegend: true,
                    dataPoints: [
                        { x: 1, y: sist1 },
                        { x: 2, y: sist2 },
                        { x: 3, y: sist3 },
                        { x: 4, y: sist4 },
                        { x: 5, y: sist5 },
                        { x: 6, y: sist6 },
                        { x: 7, y: sist7 },
                        { x: 8, y: sist8 },
                        { x: 9, y: sist9 },
                        { x: 10, y:sist10 }
                    ]
                },
                {
                    name: "Dijastolički",
                    type: "spline",
                    //yValueFormatString: "#0.## °C",
                    showInLegend: true,
                    dataPoints: [
                        { x: 1, y: dijast1 },
                        { x: 2, y: dijast2 },
                        { x: 3, y: dijast3 },
                        { x: 4, y: dijast4 },
                        { x: 5, y: dijast5 },
                        { x: 6, y: dijast6 },
                        { x: 7, y: dijast7 },
                        { x: 8, y: dijast8 },
                        { x: 9, y: dijast9 },
                        { x: 10, y:dijast10 }
                    ]
                }]
        });
        chart.render();

        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }

    }
</script>

<?php



echo '
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
        <link href="adminstyle.css" rel="stylesheet">
    </head>';

echo "
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('adminnavbar.php');
    });
    </script>";

echo '
<div class="admin-content" >
        <ul class="nav nav-tabs" id="myTab" style="width:1050px;margin-left: -140px">
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Pretraži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dodajbolnicu.php">Dodaj bolnicu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pregled.php">Pregled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/GroBenk-Vol2/donacije.php?keyword=&trazi=Tra%C5%BEi">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>';



echo'

    <div style="width:30%;float:left;padding:50px;border-right: 3px solid #DC0E0E;margin-top: 30px;opacity:0.8">
        <img src="https://d29fhpw069ctt2.cloudfront.net/icon/image/120311/preview.svg" width="100%" >
    </div>
    <div style="width:25%;float:left;padding:50px;margin-top: 30px">
        <br>
        
        <form action="" method="POST">
        <h4>Tlak:</h4>
            <table style="width:500px;height:100px">
                <tr>
                    <td><label>Sistolički</label></td>
                    <td><input type="number" name="sist" required="" style="border-radius: 5px;"></td>
                </tr> 
                <tr>
                    <td><label>Dijastolički</label></td>
                    <td><input type="number" name="dijast" required="" style="border-radius: 5px;"></td>
                </tr>
             </table><br>
             <h4>Otkucaji srca:</h4>
             <table style="width:500px;height:50px">
                <tr>
                    <td><label>BPM</label></td>
                    <td><input type="number" name="bpm" required="" style="border-radius: 5px;"></td>
                </tr> 
             </table><br>
                <input type="submit" name="submit" class="zbtn" value="Pregledaj">
        </form>';
        
        if($flag == 1) {
            echo '
            <font color="#006400">
            Korisnik može donirati!
            </font>   
            ';
        }
        if ($flag == 0){
            echo '
            <font color="#b22222">
            Korisnik ne može donirati!
            </font>   
            ';
        }
        echo'</div>
        ';

echo'</div>

<div style="width:40%;float:left;padding:50px;margin-top: 30px">
        <h2>Statistika pregleda:</h2><br>
        
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</div>

<hr>  
';

?>