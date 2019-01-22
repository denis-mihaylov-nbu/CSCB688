<?php
include('../common/session.php');
    if ($clubid > 0){
        $ses_sql = mysqli_query($db,"SELECT court.id, club.id AS club_id, club.name AS club_name, court.number, 
                                            court_type.id AS court_type, court_type.name AS court_type_name FROM court
                                            LEFT JOIN court_type ON court.type = court_type.id 
                                            LEFT JOIN club ON club.id = court.clubid 
                                            WHERE ID=".$clubid);
    } else {
        $ses_sql = mysqli_query($db,"SELECT court.id, club.id AS club_id, club.name AS club_name, court.number, 
                                            court_type.id AS court_type, court_type.name AS court_type_name FROM court
                                            INNER JOIN club ON club.id = court.clubid
                                            INNER JOIN court_type ON court.type = court_type.id");
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