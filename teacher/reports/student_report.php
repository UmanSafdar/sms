<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';  
$class_sql = "SELECT class_id, class_name 
                FROM classes";
$class_result = mysqli_query($conn, $class_sql);

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
                 
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <style>
        @media print{
            body * {
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
            <?php include '../includes/sidebar.php';?>
           <main class="col-md-9 ms-sm-auto col-lg-10 offset-md-3 offset-lg-2 mt-5 pt-4 mb-5">
           <br>
                <div class="rounded bg-dark text-white text-center"> 
                    <h2 class="mb-4">Student Information</h2> </div> 
                 <form method="GET">
                    
                    <div class=" d-flex align-items-center gap-3 ">
                    <label class="form-label mb-4"><b>Select Class</b></label>
                    <select name="class_id" id="class_id" style="width: 250px;" class="form-select mb-4">
                     <option 
                        value="">All Classes</option>
                    <?php
                    if(mysqli_num_rows($class_result) >0){
                        while($class = mysqli_fetch_assoc($class_result)){
                            $selected = ($class['class_id']== $class_id) ? 'selected' : '';
                            
                            echo "<option value='{$class['class_id']}'$selected>
                                {$class['class_name']}
                            </option>";
                            }
                            }?>
                    </select>
                    <div class="d-flex text-align-center gap-3 mb-4">
                   <button class="btn btn-dark mb-4" type="submit" name="submit">Generate Report</button>
                    <a href="reports_dashboard.php" class="btn btn-dark mb-4">Back</a>
                 <a href="export_student_report.php?class_id=<?php echo $class_id;?>" class="btn btn-dark mb-4">Export to Excel</a>
                  <button class="btn btn-dark mb-4" type="button" name="print" onclick="window.print()">Print Report</button>
                </div>
                 </div>

                 </form>
                 
                
                 
                        <!-- <h2 class="text center">Students BioData Information</h2> -->
                        <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="classTable">
                        <thead>
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
                           $counter++; }}
                                
                            else { ?>
                            <tr>
                                <td colspan="7"
                                            class="text-center">

                                            No students found.

                                        </td>
                                        <?php } ?>
                            </tr>
                     
                        </table>
                         
                    </div>
                 </main>

        </div>
    </div>
</body>
</html>