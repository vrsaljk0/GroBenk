<?php
/**
 * Created by PhpStorm.
 * User: Korisnik
 * Date: 7.1.2019.
 * Time: 16:04
 */

require_once "dbconnect.php";

    $OIB = $_POST['OIB'];
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $id) {
            echo $id;
            $sql = "UPDATE obavijesti SET procitano='1' WHERE id_obavijesti='$id'";
            $run = mysqli_query($conn, $sql);
            $result = $run or die ("Failed to query database". mysqli_error($conn));
        }
    }
    $url = 'donor.php?OIB='.urlencode($OIB);
    header("Location:$url");




?>