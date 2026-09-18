<?php
session_start();

if(!isset($_SESSION['role'])|| $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
include '../db_connect.php';
include 'includes/navbar.php';
include 'includes/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- //including bootstrap link -->
     <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <!-- including css file -->
     <link 
        rel="stylesheet" 
        href="/my_sms/teacher/includes/teacher.css"
    >
    <title>Teacher Dashboard</title>
</head>
<body>
    
</body>
</html>