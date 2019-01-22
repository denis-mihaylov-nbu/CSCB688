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
    if ($club['id'] > 0) {
        $sql = "UPDATE club SET name='".$club['name']."', address='".$club['address']."' WHERE id='".$club['id']."'";
    } else {
        $sql = "INSERT INTO club (name, address) VALUES ('".$club['name']."','".$club['address']."')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>