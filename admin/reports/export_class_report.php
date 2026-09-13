<?php
include '../../db_connect.php';
// GET FILTER //

$class_id = $_GET['class_id'] ?? '';

// ==========Excel File ==========
 header("Content-Type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=class_report.xls");
 header("Pragma: no-cache");
header("Expires: 0");

 //===========Query============
 $query = "SELECT
            classes.class_id,
            classes.class_name,
            COUNT(students.student_id) AS total_students
            FROM classes
            LEFT JOIN students
            ON classes.class_id = students.class_id
            AND students.profile_status = 'complete'";
if($class_id != ''){
    $class_id = mysqli_real_escape_string($conn, $class_id);
    $query .= " WHERE classes.class_id ='$class_id'";
}

$query .= " GROUP BY
            classes.class_id,
            classes.class_name
            ORDER BY classes.class_id";
$result = mysqli_query($conn, $query);

// ==========Report==============
?>
<table border="1">
    <tr>
        <th colspan="3">Class Report</th>
    </tr>
    <tr>
         <th>S.No</th>
        <th>Class Name</th>
         <th>Total Students</th>
        
    </tr>
            <?php
            $count =1;
   while($row = mysqli_fetch_assoc($result)){
    ?>
    <tr>
        <td><?php echo $count++;?></td>
        <td><?php echo $row['class_name'];?></td>
        <td><?php echo $row['total_students'];?></td>
    </tr>
    <?php
   }        ?>
   </table>