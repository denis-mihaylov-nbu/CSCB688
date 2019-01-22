<?php
include('../common/config.php');
session_start();

if (isset($_POST['club'])) {
    $club = $_POST['club'];

    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM CLUB WHERE id=".$club['id'];

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>