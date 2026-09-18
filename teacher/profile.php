<?php

session_start();
include '../db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$q = "SELECT 
        users.Email,
        teachers.full_name,
        teachers.qualification,
        teachers.specialization,
        teachers.salary,
        teachers.joining_date
        FROM users
        INNER JOIN teachers
        ON users.Id = teachers.user_Id
        WHERE teachers.user_Id = $user_id";
$result = mysqli_query($conn, $q);
$teacher= mysqli_fetch_assoc($result);

?>
