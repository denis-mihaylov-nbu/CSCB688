<?php
include('config.php');
session_start();

$user_check = $_SESSION['login_user'];

$ses_sql = mysqli_query($db,"select id, fname, lname, clubid, role from user where username = '$user_check' ");
if (!$ses_sql) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_session = $row['fname'].' '.$row['lname'];
$clubid = $row['clubid'];
$admin = $row['role'] == 2;
$userid = $row['id'];

if(!isset($_SESSION['login_user'])){
    header("location:index.php");
}
?>