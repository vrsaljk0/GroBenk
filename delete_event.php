<?php
if(isset($_GET['idEvent'])) {
    require_once "dbconnect.php";

    $idLokacija = $_GET['idEvent'];
    $sql = "DELETE FROM lokacija WHERE id_lokacije = '".$idLokacija."'";
    $run_sql = mysqli_query($conn, $sql);

    if($run_sql) {
        header("Location:admin.php?keyword=&trazi=Traži");
    } else {
        echo "ERROR";
    }
}
//https://stackoverflow.com/questions/40479421/how-to-add-delete-button-in-my-php-rows
?>


