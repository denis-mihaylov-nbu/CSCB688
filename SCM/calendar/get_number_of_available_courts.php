<?php
include('../common/session.php');

$workday_header = 'workday_header';
$weekend_header = 'weekend_header';

$workday_available = 'workday_available';
$weekend_available = 'weekend_available';

$workday_not_available = 'workday_not_available';
$weekend_not_available = 'weekend_not_available';

function isWeekend($date){
    $day = $date->format('N');
    return $day == 6 || $day == 7;
}


if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 0;
}

$date = new DateTime();
date_time_set($date ,8, 0, 0);
$date->modify('+'.($page*7).' day');

$result = array();
$rowArray = array();

for ($i=0; $i<8; $i++){
    $object = new stdClass();
    if ($i > 0){
        $object->timeslot = "0".$i;
        $object->value = $date->format('d/m/Y, l');
        if (isWeekend($date)){
            $object->class = $weekend_header;
        } else {
            $object->class = $workday_header;
        }
        $date->modify('+1 day');
    }

    array_push($rowArray, $object);
}
array_push($result, $rowArray);

$date->modify('-7 day');
for ($i=0; $i < 14; $i++){
    $rowArray = array();
    for ($j=0; $j < 8; $j++){
        $object = new stdClass();
        if ($j == 0){
            $object->value = $date->format('H:i');
            $object->class = $workday_header;
        } else {
            $timeslot = $date->format('d/m/Y H').":00";
            $ses_sql = mysqli_query($db,"select * from court where clubid = '$clubid' and number not in (select court_number from reservation where timeslot LIKE '$timeslot')");
            $courts = array();
            while($row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC)){
                $courts[] = $row;
            }
            $object->value = sizeof($courts);

            if (isWeekend($date)){
                if ($object->value > 0){
                    $object->class = $weekend_available;
                } else {
                    $object->class = $weekend_not_available;
                }
            } else {
                if ($object->value > 0){
                    $object->class = $workday_available;
                } else {
                    $object->class = $workday_not_available;
                }
            }
            $date->modify('+1 day');
        }

        array_push($rowArray, $object);
    }
    $date->modify('+1 hour');
    $date->modify('-7 day');
    array_push($result, $rowArray);
}

echo json_encode($result);


?>
