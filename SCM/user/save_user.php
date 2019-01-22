<?php
include('../common/config.php');
session_start();

if (isset($_POST['user'])) {
    $user = $_POST['user'];

    // Create connection
    $conn = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($user['id'] > 0) {
        $sql = "UPDATE user SET username='".$user['username']."', password='".$user['password']."', fname='".$user['fname'].
            "', lname='".$user['lname']."', clubid='".$user['clubid']."', role='".$user['role']."' WHERE id='".$user['id']."'";
    } else {
        $sql = "INSERT INTO user (username, password, fname, lname, role, clubid) 
                VALUES ('".$user['username']."','".$user['password']."','".$user['fname']."','".$user['lname']."','".$user['role']."',".$user['clubid'].")";
    }

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    $conn->close();
}
?>