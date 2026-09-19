<?php
include '../db_connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM teachers WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

echo $teacher['full_name'];
echo $teacher['qualification'];
echo $teacher['specialization'];
echo $teacher['phone'];
echo $teacher['salary'];
echo $teacher['joining_date'];


?>