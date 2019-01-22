<?php
include('../common/config.php');
session_start();

if (isset($_POST['reservation'])) {
    $reservation = $_POST['reservation'];

    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO reservation (clubid, court_number, timeslot) 
            VALUES ('".$reservation['club']."', '".$reservation['court']."', '".$reservation['timeslot']."')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>