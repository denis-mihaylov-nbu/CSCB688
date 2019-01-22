<?php
include('../common/config.php');
session_start();

if (isset($_POST['court'])) {
    $court = $_POST['court'];

    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($court['id'] > 0) {
        $sql = "UPDATE court SET number='".$court['number']."', type='".$court['type']."', clubid='".$court['clubid']."' WHERE id='".$court['id']."'";
    } else {
        $sql = "INSERT INTO court (number, type, clubid) VALUES ('".$court['number']."','".$court['type']."','".$court['clubid']."')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>