<?php
    session_start();
    if(!isset($_SESSION['role'])|| $_SESSION['role'] != 'teacher'){
        header("Location: ../login.php");
        exit();
    }

    include '../../db_connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT teacher_id FROM
                     teachers
                   Where user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $t = mysqli_fetch_assoc($result);
    $teacher_id = $t['teacher_id'];

    $teacher_sql = "SELECT classes.class_name, classes.class_id, teacher_classes.teacher_id from
                    classes
                    LEFT join teacher_classes
                    on classes.class_id = teacher_classes.class_id
                    where teacher_classes.teacher_id = $teacher_id";
    $teacher_result = mysqli_query($conn, $teacher_sql);
     $class_id = '';
   if(isset($_GET['class_id'])){
    
        $class_id = (int)$_GET['class_id'];
   }
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

   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Report</title>
    <style>
        @media print{
            body *{
                visibility: hidden;
            }

            #classTable,
            #classTable *{
                visibility: visible;
            }
            #classTable{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%

            }
        }
    </style>
   </head>
   <body>
        <?php include '../includes/navbar.php';?>
        <div class="container-fluid">
            <div class="row">
                <?php include '../includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 offset-md-3 offset-lg-2 mt-5 pt-4 mb-5">
            <br>
            <form method="GET">
                <div class="d-flex align-item-center gap-4">
                    <div >
                    <label class="form-label ">Select a class</label>
</div>
                <div class="mb-4">
                    <select name="class_id" id="class_id" class="form-select">
                        <option value="">Select All Classes</option>
                   <?php if(mysqli_num_rows($teacher_result) >0){
                    while($class=mysqli_fetch_assoc($teacher_result)){
                        $selected = ($class['class_name']) != "" ? 'selected' : '';
                        
                       
                   echo"<option value='{$class['class_id']}'$selected;>
                    {$class['class_name']}
                   </option>";
                   
                   }
                   }   ?>
                    </select>
                </div>
                <div class="d-flex align-item-center gap-3 mb-4">
                    <button class="btn btn-dark" type="submit" name="submit">Generate Attendance Report</button>
                    <a href="reports_dashboard.php" class="btn btn-dark">Back</a>
                    <a href="export_attendance_report.php?class_id=<?php echo $class_id;?>" class="btn btn-dark">Export to Excel</a>
                    <button class="btn btn-dark" onclick="window.print()">Print</button>
            </div>
                </div>
                 
            </form>
            <table class="reponsive table table-hover table-striped" id="classTable">
                
                
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
                <?php 
                $counter =1;
                if(mysqli_num_rows($report_result)>0){
                    while($report = mysqli_fetch_assoc($report_result)){
                        ?>
                        <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php echo $report['roll_no'];?></td>
                            
                            <td><?php echo $report['full_name'];?></td>
                            <td><?php echo $report['father_name'];?></td>
                            <td><?php echo $report['class_name'];?></td>
                            <td><?php echo $report['subject_name'];?></td>
                            <td><?php echo $report['attendance_date'];?></td>
                            <td><?php echo $report['status'];?></td>
                        </tr>
                        <?php
                        $counter++;
                    }
                    } else{?>
                    <tr><td colspan="8" class="text-center">No record found!</td>
                <?php }?></tr>
                   </table>
        </main>
        </div>
    </div>
   </body>
   </html>