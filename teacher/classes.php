<?php
session_start();

if(!isset($_SESSION['role'])|| $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
include '../db_connect.php';
$user_id = $_SESSION['user_id'];
$status_check = "SELECT status from teachers where user_id = '$user_id'";
$status_result = mysqli_query($conn, $status_check);
$teacher = mysqli_fetch_assoc($status_result);
if($teacher['status']!='active'){
    header("Location: profile.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Classes</title>
</head>
<body>
    <h1>Welcome</h1>
</body>
</html>