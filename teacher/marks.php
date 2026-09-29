<?php
//=============SESSION START============//
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
//////=========== Including Database Connection===========
include '../db_connect.php';
$user_id = $_SESSION['user_id'];
echo $user_id;
$select_sql = "SELECT teacher_id FROM teachers WHERE user_id= $user_id";
$result = mysqli_query($conn, $select_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];
echo $teacher_id;
?>