<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';
if(!$conn){
    die("Connection Failed". mysqli_connect_error());
}
$user_id = (int)$_SESSION['user_id'];
// getting student id by using user id 
//query
$student_sql = "SELECT student_id
                FROM students
                WHERE user_id = $user_id";
$student_result = mysqli_query($conn, $student_sql);
if(!$student_result){
    die("Student Query Failed".mysqli_error($conn));
    
}
$student = mysqli_fetch_assoc($student_result);
if(!$student){
    die("No student record found");
}
$student_id = (int)$student['student_id'];


// ATTENDANCE QUERY
$attendance_sql = "SELECT * FROM attendance
                  Where student_id = $student_id";
$attendance_result = mysqli_query($conn, $attendance_sql);
if(!$attendance_result){
    die("Attendance query failed". mysqli_error($conn));
}
if(mysqli_num_rows($attendance_result) == 0){
    echo "No attendance Record Found";
}

// query to get total attendance
$total_sql = "SELECT COUNT(*) AS total_attendance
                    FROM attendance
                    WHERE student_id = $student_id";
$total_result = mysqli_query($conn, $total_sql);
if(!$total_result){
    die("Query failed".mysqli_error($conn));
}
$total = mysqli_fetch_assoc($total_result);

// query to get total presents
$present_sql = "SELECT COUNT(*) AS total_present
                    FROM attendance
                    WHERE student_id = $student_id and status = 'present'";
$present_result = mysqli_query($conn, $present_sql);
if(!$present_result){
    die("Query failed".mysqli_error($conn));
}
$present = mysqli_fetch_assoc($present_result);

echo"total Present". $present['total_present'];

// query to get total absents
$absent_sql = "SELECT COUNT(*) AS total_absents
                    FROM attendance
                    WHERE student_id = $student_id and status = 'absent'";
$absent_result = mysqli_query($conn, $absent_sql);
if(!$absent_result){
    die("Query failed".mysqli_error($conn));
}
$absent = mysqli_fetch_assoc($absent_result);

echo"total absent". $absent['total_absents'];

// attendance percentage

$percentage = round(($present['total_present'] / $total['total_attendance'] )* 100 );
echo $percentage;
?>