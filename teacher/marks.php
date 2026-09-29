<?php
//=============SESSION START============//
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
//////=========== Including Database Connection===========
include '../db_connect.php';
// =========Get Teacher Id using user id ============//
$user_id = $_SESSION['user_id'];
$select_sql = "SELECT teacher_id FROM teachers WHERE user_id= $user_id";
$result = mysqli_query($conn, $select_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];
//==========Getting Class id by using Teacher id===========
$class_sql = "SELECT class_id FROM teacher_classes WHERE teacher_id = $teacher_id";
$class_result = mysqli_query($conn, $class_sql);
$class = mysqli_fetch_assoc($class_result);
$class_id = $class['class_id'];
//========= Getting Class name using class id =========//
$className = "SELECT classes.class_id, classes.class_name FROM classes
INNER JOIN teacher_classes
ON classes.class_id = teacher_classes.class_id
WHERE teacher_classes.teacher_id= $teacher_id";
$class_result = mysqli_query($conn, $className);
$class = mysqli_fetch_assoc($class_result);
$class_Name = $class['class_name'];
?>
