<?php
if(isset($_GET['idEvent'])) {
    require_once "dbconnect.php";
    mysqli_set_charset($conn, "utf8");

    $idLokacija = $_GET['idEvent'];
    $sql = "DELETE FROM lokacija WHERE id_lokacije = '" . $idLokacija . "'";
    $run_sql = mysqli_query($conn, $sql);

    if ($run_sql) {
        header("Location:admin.php?keyword=&trazi=Traži");
    } else {
        echo "ERROR";
    }
}
?>


