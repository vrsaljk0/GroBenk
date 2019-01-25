<?php
$percent = "20%";

require_once "dbconnect.php";
session_start();
mysqli_set_charset($conn,"utf8");

/** SESSION TIMEOUT */
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");

$_SESSION["current_page"] = $_SERVER['REQUEST_URI'];


/** ZALIHA KRVI*/
$nemaKrvi = 0;
$krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
$kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

for ($i=0; $i<8; $i++) {
    $sql = "select kolicina_grupe as kolicina from zaliha where krvna_grupa = '$krv[$i]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $kol_krvi[$i] = $row['kolicina'];
}
?>

    <head>
	<script src="jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="http://kbc-rijeka.hr/wp-includes/js/jquery/jquery.js?ver=1.11.3"></script>
	<link rel="stylesheet" href="http://kbc-rijeka.hr/wp-content/themes/medicenter-child/zalihe.css" type="text/css">
	<style>
	
    
	#supplies {
	    position: relative;
	    padding: 30px 0 30px 20px;
	    font-family: Arial, Helvetica, sans-serif;
	}

	#supplies .high {
	    position: relative;
	    float: left;
	    margin: 0 20px 20px 0;
	    width: 100px;
	    height: 2px;
	    background: #ffc000;
	}

	#supplies .high span {
	    font-size: 11px;
	    position: absolute;
	    top: -20px;
	}

	#supplies .low {
	    position: relative;
	    float: left;
	    width: 100px;
	    height: 2px;
	    background: #6dcff6;
	}

	#supplies .low span {
	    font-size: 11px;
	    position: absolute;
	    top: -20px;
	}

	#supplies .measure {
	    float: left;
	    position: relative;
	    margin: 30px 18px 30px 0;
	}

	#supplies .measure .top {
	    position: absolute;
	    left: -5px;
	    width: 20px;
	    height: 2px;
	    background: #ffc000;
	    z-index: 3;
	}

	#supplies .measure .bottom {
	    position: absolute;
	    left: -5px;
	    width: 20px;
	    height: 2px;
	    background: #6dcff6;
	    z-index: 3;
	}

	#supplies .measure .name {
	    position: absolute;
	    top: -20px;
	    left: 14px;
	    width: 32px;
	    font-size: 12px;
	    font-weight: bold;
	    text-align: center;
	    color: #000;
	}

	#supplies .measure .name.big {
	    font-size: 15px;
	    color: #cc1617;
	}

	#supplies .measure .warning {
	    position: absolute;
	    top: 20px;
	    left: 24px;
	    width: 14px;
	    height: 28px;
	    background: url(images/warning.png);
	    z-index: 3;
	}

	#supplies .measure .bag {
	    position: absolute;
	    top: 0;
	    left: 0;
	    width: 58px;
	    height: 100px;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/bag.png);
	    z-index: 2;
	}

	#supplies .measure .bag:after {
	    content: "";
	    position: absolute;
	    bottom: -18px;
	    left: 0;
	    width: 58px;
	    height: 18px;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/bag-bottom.png);
	    z-index: 2;
	}

	#supplies .measure .outer {
	    position: relative;
	    bottom: 0;
	    width: 58px;
	    height: 100px;
	    overflow: hidden;
	}

	#supplies .measure .inner {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: 50%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .innerapoz {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[0] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .inneraneg {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[1] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .innerbpoz {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[2] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .innerbneg {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[3] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .innerabpoz {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[4] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .innerabneg {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[5] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .inneropoz {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[6] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	#supplies .measure .inneroneg {
	    position: absolute;
	    bottom: 0;
	    width: 100%;
	    height: <?= $kol_krvi[7] ?>%;
	    background: url(http://kbc-rijeka.hr/wp-content/themes/medicenter-child/images/fill.png) no-repeat;
	    overflow: hidden;
	}
	</style>

</head>

<body>
<div id="supplies">
	<div class="high"><span>Prevelike zalihe</span></div>
	<div class="low"><span>Premale zalihe</span></div>
	<div style="clear: both;"></div>
		<div class="measure one">
		<div class="name">A+</div>
		<div class="top" style="bottom: 80px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="37" class="innerapoz"></div>
		</div>
		<div class="bottom" style="bottom: 32px"></div>
	</div>
		<div class="measure one">
		<div class="name">A-</div>
		<div class="top" style="bottom: 75px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="39" class="inneraneg"></div>
		</div>
		<div class="bottom" style="bottom: 23px"></div>
	</div>
		<div class="measure one">
		<div class="name">O+</div>
		<div class="top" style="bottom: 80px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="21" class="inneropoz"></div>
		</div>
		<div class="bottom" style="bottom: 36px"></div>
	</div>
		<div class="measure one">
		<div class="name">O-</div>
		<div class="top" style="bottom: 72px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="60" class="inneroneg"></div>
		</div>
		<div class="bottom" style="bottom: 20px"></div>
	</div>
		<div class="measure one">
		<div class="name">B+</div>
		<div class="top" style="bottom: 83px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="29" class="innerbpoz"></div>
		</div>
		<div class="bottom" style="bottom: 32px"></div>
	</div>
		<div class="measure one">
		<div class="name">B-</div>
		<div class="top" style="bottom: 80px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="50" class="innerbneg"></div>
		</div>
		<div class="bottom" style="bottom: 20px"></div>
	</div>
		<div class="measure one">
		<div class="name">AB+</div>
		<div class="top" style="bottom: 75px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="46" class="innerabpoz"></div>
		</div>
		<div class="bottom" style="bottom: 20px"></div>
	</div>
		<div class="measure one">
		<div class="name">AB-</div>
		<div class="top" style="bottom: 73px"></div>
		<div class="bag"></div>
		<div class="outer">
			<div data-percent="30" class="innerabneg"></div>
		</div>
		<div class="bottom" style="bottom: 20px"></div>
	</div>
		<div style="clear: both;"></div>
</div>
</body>


