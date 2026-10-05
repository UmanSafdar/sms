<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_report.xls");
 header("Pragma: no-cache");
header("Expires: 0");


//=============QUERY===========//
$class_id = '';
                 if(isset($_GET['class_id'])){
    $class_id = (int)$_GET['class_id'];}
   //============= QUERY TO SELECT STUDENTS INFORMATION =============//
   if($class_id >0){
    $student_sql = "SELECT students.roll_no,students.full_name,students.father_name,
                    students.gender,students.phone,classes.class_name FROM students
                    LEFT JOIN classes
                    ON classes.class_id = students.class_id
                    WHERE classes.class_id = $class_id";
    $student_result = mysqli_query($conn, $student_sql);
   }
   else{
             $student_sql = "SELECT students.roll_no,students.full_name,students.father_name,
                    students.gender,students.phone,classes.class_name FROM students
                    LEFT JOIN classes
                    ON classes.class_id = students.class_id
                    ORDER BY class_name ASC";
    $student_result = mysqli_query($conn, $student_sql);
   }
   //============ REPORT ================//
   
?>
<table border="1">
    
   <thead>
    <tr><th colspan = "7">Student Report</th></tr>
    <tr>
                                    <th>S.NO</th>
                                    <th>Roll No</th>
                                    <th>Student Name</th>
                                    <th>Father Name</th>
                                    <th>Gender</th>
                                    <th>Class</th>
                                    <th>Phone</th>
    </tr>
   </thead> 
   <tbody>
                                 <?php 
                                $counter = 1;
                                if(mysqli_num_rows($student_result) > 0 ){
                                while($student_info = mysqli_fetch_assoc($student_result)){
                                    ?>
                                    <tr>
                                    <td><?php echo $counter;?></td>
                                    <td><?php echo $student_info['roll_no'];?></td>
                                    <td><?php echo $student_info['full_name'];?></td>
                                    <td><?php echo $student_info['father_name'];?></td>
                                    <td><?php echo $student_info['gender'];?></td>
                                    <td><?php echo $student_info['class_name'];?></td>
                                    <td><?php echo $student_info['phone'];?></td>
                                
                            </tr>
                            <?php
                           $counter++; }} ?>
                           </tbody>
</table>
        
 