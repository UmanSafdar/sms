<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT teacher_id FROM teachers
WHERE user_id = '$user_id'";
$result= mysqli_query($conn, $sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];

$student_sql = "SELECT  students.student_id,
                        students.full_name,
                        students.father_name,
                        students.roll_no,
                        students.gender,
                        students.phone,
                        classes.class_name
                FROM teacher_classes
                INNER JOIN classes
                ON teacher_classes.class_id = classes.class_id
                INNER JOIN students
                ON classes.class_id = students.class_id
                WHERE teacher_classes.teacher_id = $teacher_id
                ORDER BY classes.class_name, students.roll_no";
$student_result = mysqli_query($conn, $student_sql);
echo "Students found: " . mysqli_num_rows($student_result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>