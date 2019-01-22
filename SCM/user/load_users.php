<?php
include('../common/session.php');

    if ($clubid > 0){
        $ses_sql = mysqli_query($db,"SELECT * FROM user WHERE CLUBID=".$clubid);
    } else {
        $ses_sql = mysqli_query($db,"SELECT * FROM user");
    }
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