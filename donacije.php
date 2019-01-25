<script src="http://code.jquery.com/jquery-latest.js"></script>

<SCRIPT language="javascript">
    $(function(){

        $("#select_all").click(function () {
            $('.case').prop('checked', this.checked);
        });

        $(".case").click(function(){

            if($(".case").length == $(".case:checked").length) {
                $("#select_all").prop("checked", "checked");
            } else {
                $("#select_all").removeProp("checked");
            }

        });
    });
</SCRIPT>

<?php

require_once ("dbconnect.php");
session_start();
mysqli_set_charset($conn,"utf8");

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    header("Location:odjava.php");
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['admin_loggedin'])) header("Location:denied_permission.php");
?>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BloodBank</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <link href="style.css" rel="stylesheet">
        <link href="adminstyle.css" rel="stylesheet">
    </head>

   
    <div id='nav-placeholder' onload>
    </div> 

    <script>
    $(function(){
      $('#nav-placeholder').load('adminnavbar.php');
    });
    </script>


<div class="admin-content">
        <ul class="nav nav-tabs" id="myTab" >
            <li class="nav-item">
                <a class="nav-link" href="eventi.php?keyword=&trazi=Traži">Eventi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="zahtjevi.php">Zahtjevi</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="donacije.php?keyword=&trazi=Traži">Donacije</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="obavijesti.php">Obavijesti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistika.php">Statistika</a>
            </li>
        </ul>
</div>

<div class="col-md-8zal">
    <br><h3>Trenutno stanje zaliha:</h3>

<!--DRUGI DIO-->
<?php
    /** ZALIHA KRVI*/
    $nemaKrvi = 0;
    $krv = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', '0+', '0-');
    $kol_krvi = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);

    for ($i=0; $i<8; $i++) {
        $sql = "select kolicina_grupe as kolicina from zaliha where krvna_grupa = '$krv[$i]'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $kol_krvi[$i] = $row['kolicina'];
        if($kol_krvi[$i] > 100) $kol_krvi[$i] = 100;
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
        <div style="clear: both;">ssd</div>
</div>
<!--
<span class="percent"><?= $kol_krvi[0] ?>%</span>
<span class="percent"><?= $kol_krvi[1] ?>%</span>
<span class="percent"><?= $kol_krvi[2] ?>%</span>
<span class="percent"><?= $kol_krvi[3] ?>%</span>
<span class="percent"><?= $kol_krvi[4] ?>%</span>
<span class="percent"><?= $kol_krvi[5] ?>%</span>
<span class="percent"><?= $kol_krvi[6] ?>%</span>
<span class="percent"><?= $kol_krvi[7] ?>%</span>
-->
</div>
</body>

<!--TREĆI DIO-->
<?php
    $date = date("Y-m-d");

    $query = "select lokacija.naziv_lokacije, donor.OIB_donora, donor.ime_prezime_donora, donor.krvna_grupa_don from lokacija, donor, moj_event
              where lokacija.datum_dogadaja = '$date' and lokacija.id_lokacije = moj_event.id_lokacije and donor.OIB_donora = moj_event.OIB_donora_don and moj_event.prisutnost = '0'";
    $run = mysqli_query($conn, $query);
    if ($result = mysqli_num_rows($run) != 0) {

    echo'<div id="content30" class="toggle"  ><br><br>';
        echo '<form action="" method="GET">
            <input type="text" name = "keyword" placeholder="Pretraži donacije">
            <input type="submit" name="trazi" value="Traži">
        </form>
        
        <form action="" method="GET">
        <table border="1">
            <tr>
                <th>LOKACIJA</th>
                <th>OIB</th>
                <th>IME I PREZIME</th>
                <th>KRVNA GRUPA</th>
                <th>AŽURIRAJ?glupo zvuci</th>
            </tr>';
        if (isset($_GET['trazi'])) {
            $pretraga = $_GET['keyword'];
            $date = date("Y-m-d");

            $query = "select lokacija.naziv_lokacije, donor.OIB_donora, donor.ime_prezime_donora, donor.krvna_grupa_don from lokacija, donor, moj_event
                          where lokacija.datum_dogadaja = '$date' and lokacija.id_lokacije = moj_event.id_lokacije and donor.OIB_donora = moj_event.OIB_donora_don and moj_event.prisutnost = '0'
                          and ((lokacija.naziv_lokacije like '%$pretraga%') or (donor.ime_prezime_donora like '%$pretraga%') or (donor.krvna_grupa_don = '$pretraga'))";
            $run = mysqli_query($conn, $query);
            $result = $run or die ("Failed to query database" . mysqli_error($conn));


            while ($row = mysqli_fetch_array($result)) {
                echo '
                            <tr>
                                <td>' . $row['naziv_lokacije'] . '</td><td> ' . $row['OIB_donora'] . '</td><td>' . $row['ime_prezime_donora'] . '</td><td>' . $row['krvna_grupa_don'] . '</td><td><input type="checkbox" class="case" name="check_list[]" value=' . $row['OIB_donora'] . '></td>
                            </tr>';
            }
            echo '</table>

                    <input type="text" name="kolicina">
                    <input type="submit" name="doniraj" value="Unesi donaciju"><br>
                    <input type="submit" name="odbij" value="Odbij donaciju"><br><br>
                    Označi sve:
                    <input type="checkbox" name="select_all" id = "select_all">
                    
                </form>';
        }


        if (isset($_GET['doniraj'])) {
            $date = date("Ymd");
            $kol = $_GET['kolicina'];
            if (!empty($_GET['check_list'])) {

                foreach ($_GET['check_list'] as $OIB) {
                    $info = "select * from donor where OIB_donora = '$OIB'";
                    $run = mysqli_query($conn, $info);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));
                    $row = mysqli_fetch_array($result);
                    $krvna_grupa = $row['krvna_grupa_don'];


                    $lokacija = "select * from lokacija where datum_dogadaja = '$date' and
                                     id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$OIB')";

                    $run = mysqli_query($conn, $lokacija);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));
                    $row = mysqli_fetch_array($result);

                    $id_lokacije = $row['id_lokacije'];
                   # echo $id_lokacije;
                    //umetanje donacije u tablicu donacija

                    $sql = "INSERT into donacija (kolicina_krvi_donacije, krvna_grupa_zal, OIB_donora, idlokacija)
                                        values ( '$kol', '$krvna_grupa', '$OIB', '$id_lokacije')";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));

                    $sql = "UPDATE donor SET br_donacija = br_donacija+1 where OIB_donora = '$OIB'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));

                    $sql = "UPDATE moj_event SET prisutnost = '1' WHERE OIB_donora_don = '$OIB' AND id_lokacije='$id_lokacije'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));

                    $sql = "UPDATE zaliha set kolicina_grupe = kolicina_grupe + '$kol' where krvna_grupa = '$krvna_grupa'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));
                    #header("Location:donacije.php?keyword=&trazi=Traži");
                }
            }
        }
        if (isset($_GET['odbij'])) {
            $date = date("Ymd");
            if (!empty($_GET['check_list'])) {
                foreach ($_GET['check_list'] as $OIB) {
                    $lokacija = "select * from lokacija where datum_dogadaja = '$date' and
                                     id_lokacije in (select id_lokacije from moj_event where OIB_donora_don = '$OIB')";
                    $run = mysqli_query($conn, $lokacija);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));
                    $row = mysqli_fetch_array($result);
                    $id_lokacije = $row['id_lokacije'];

                    $sql = "UPDATE moj_event SET prisutnost = '-1' WHERE OIB_donora_don = '$OIB' and id_lokacije='$id_lokacije' and prisutnost = '0'";
                    $run = mysqli_query($conn, $sql);
                    $result = $run or die ("Failed to query database" . mysqli_error($conn));
                    header("Location:donacije.php?keyword=&trazi=Traži");

                }
            }
        }
    } else {
        echo 'neka poruka u stilu:<h3>Trenutno nema prijava za donaciju</h3>';
    }
?>