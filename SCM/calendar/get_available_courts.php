<?php
include('../common/config.php');
session_start();

if (isset($_POST['timeslot'])) {
    $timeslot = $_POST['timeslot'];

    $ses_sql = mysqli_query($db,"select * from court INNER JOIN court_type ON court.type = court_type.id 
              where number not in (select court_number from reservation where timeslot LIKE '$timeslot')");
    $myArray = array();
    while($row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC)){
        $myArray[] = $row;
    }

    $result = json_encode([]);
    if ($myArray != null) {
        $result = json_encode($myArray);
    }
    echo $result;

}
?>