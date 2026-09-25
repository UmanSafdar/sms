<?php
// ============ SESSION START ===========//
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
// ============= CONNECTING TO DATABASE============//
include '../db_connect.php';

//============== GETTING USER ID =============//
$user_id = $_SESSION['user_id'];

// =========== GETTING TEACHER ID ===========//
$teacher_sql = "SELECT teacher_id FROM teachers WHERE user_id = $user_id";
$result = mysqli_query($conn, $teacher_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];

//=============GETTING ASSIGNED CLASSES==========//
$class_sql = "SELECT class_id FROM teacher_classes
                WHERE teacher_id = $teacher_id";
$class_result = mysqli_query($conn, $class_sql);
?>