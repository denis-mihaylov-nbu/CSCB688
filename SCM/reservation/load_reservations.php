<?php
include('../common/session.php');

    $sql = "SELECT reservation.id, reservation.timeslot, reservation.court_number, club.name FROM reservation
                                            LEFT JOIN club ON club.id = reservation.clubid 
                                            WHERE clubid=".$clubid;

    if (isset($_GET['date'])){
        $sql = $sql.' AND timeslot LIKE "%'.$_GET['date'].'%"';
    }

    $ses_sql = mysqli_query($db, $sql);
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