    $date = date("Ymd");

    $query = "SELECT idlocation, city, location_name, event_date FROM location WHERE city IN (SELECT city FROM donor WHERE OIB_donor = '$OIB')
              AND event_date > '$date'";
    $run = mysqli_query($conn, $query);
    $result = $run or die ("Failed to query database". mysqli_error($conn));


    echo '<div id="new_events">
        <form action="" method="POST">
            <b><p style="color:red;">New donation event!</p></b>';
            echo'<table style="width:30%">
                <tr><th align="left">City</th><th align="left">Place</th><th align="left">Date</th></tr>';
                while($row = mysqli_fetch_array($result)){
                    echo '<tr><td>'.$row['city'].'</td><td>'.$row['location_name'].'</td><td>'.$row['event_date'].'</td><td><input type="submit" name="coming" value="Coming"></td></tr>';
                }
            echo'</table>
        </form>
    </div>';
    if(isset($_POST['coming'])){
        //how to get the city, location_name and event_date of the row that I submited ?
    }