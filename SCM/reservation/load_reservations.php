<?php
include('../common/session.php');
    $ses_sql = mysqli_query($db,"SELECT * FROM reservation
                                            LEFT JOIN club ON club.id = reservation.clubid 
                                            WHERE clubid=".$clubid);
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