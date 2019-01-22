<?php
include('../common/config.php');
session_start();

    $ses_sql = mysqli_query($db,"select * from club_type");
    $myArray = array();
    while($row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC)){
        $myArray[] = $row;
    }

    $result = json_encode([]);
    if ($myArray != null) {
        $result = json_encode($myArray);
    }
    echo $result;

?>