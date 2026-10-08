<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';
$class_id = "";
if(isset($_GET['class_id'])){
    $class_id = (int)$_GET['class_id'];
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report.xls");
if($class_id > 0) {
   $report_sql = " SELECT attendance.status,attendance.attendance_date,students.roll_no,students.full_name,students.father_name,subjects.subject_name,classes.class_name
FROM attendance
 JOIN students
ON attendance.student_id = students.student_id
JOIN subjects
ON attendance.subject_id = subjects.subject_id
JOIN classes
ON subjects.class_id = classes.class_id
WHERE classes.class_id = $class_id";}
else{
    $report_sql = " SELECT attendance.status,attendance.attendance_date,students.roll_no,students.full_name,students.father_name,subjects.subject_name,classes.class_name
FROM attendance
 JOIN students
ON attendance.student_id = students.student_id
JOIN subjects
ON attendance.subject_id = subjects.subject_id
JOIN classes
ON subjects.class_id = classes.class_id";
}
$report_result = mysqli_query($conn, $report_sql);

   ?>

<table border="1">  
    <tr><td colspan="8" style="text-align: center;">Student Attendance Report</td></tr> 
<tr>
                    <thead>
                        <td>#</td>
                        <td>Role No</td>
                        <td>Student Name</td>
                        <td>Father Name</td>
                        <td>Class</td>
                        <td>Subject</td>
                        <td>Attendance Date</td>
                        <td>Status</td>
                    </thead>
                </tr>
                
                <tbody>
    <?php 
    $counter =1;
    if(mysqli_num_rows($report_result) > 0){
        
        while($row = mysqli_fetch_assoc($report_result)){
            
            ?>
            <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['roll_no'];?></td>
                <td><?php echo $row['full_name'];?></td>
                <td><?php echo $row['father_name'];?></td>
                <td><?php echo $row['class_name'];?></td>
                <td><?php echo $row['subject_name'];?></td>
                <td><?php echo $row['attendance_date'];?></td>
                <td><?php echo $row['status'];?></td>
            </tr>
            <?php
            $counter++;
        }
    }?>
    </tbody>
</table>