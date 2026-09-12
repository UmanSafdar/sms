<?php

include '../../db_connect.php';

$class_id = $_GET['class_id'] ?? '';


// Get classes for dropdown
$class_query = "SELECT * FROM classes ORDER BY class_name ASC";

$class_result = mysqli_query($conn, $class_query);


// Student query
$query = "SELECT 
            students.full_name,
            students.father_name,
            students.roll_no,
            students.gender,
            students.phone,
            classes.class_name

          FROM students

          LEFT JOIN classes
          ON students.class_id = classes.class_id

          WHERE students.profile_status = 'complete'";


// Apply class filter
if ($class_id != '') {

    $class_id = mysqli_real_escape_string($conn, $class_id);

    $query .= " AND students.class_id = '$class_id'";
}


$query .= " ORDER BY students.roll_no ASC";


$result = mysqli_query($conn, $query);

//Tell browser that this is an excle file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_report.xls");

// Excel Table

echo "Roll No\tStudent Name\tFather Name\tClass\tGender\tPhone\n";

while($student = mysqli_fetch_assoc($result)){
    echo $student['roll_no']."\t";
    echo $student['full_name']."\t";
    echo $student['father_name']."\t";
    echo $student['class_name']."\t";
    echo $student['gender']."\t";
    echo $student['phone']."\n";
}

?>