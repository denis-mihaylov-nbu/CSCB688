<?php
include('../common/session.php');
    $ses_sql = mysqli_query($db,"SELECT * FROM court_type ORDER BY id ASC");
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