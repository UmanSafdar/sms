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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/my_sms/teacher/includes/navbar.css">
    <link rel="stylesheet" href="/my_sms/teacher/includes/sidebar.css">
    <title>Students</title>
</head>
<body>
    <!-- // including navbar  -->
    <?php include 'includes/navbar.php';?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php';?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">
                <h2 class="mb-4">My Students</h2>

                <?php 
               
                if(mysqli_num_rows($student_result)){ ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($student = mysqli_fetch_assoc($student_result)){?>
                            <tr>
                                <td> <?php echo $student['roll_no'];?></td>
                                <td><?php echo $student['full_name'];?></td>
                                <td><?php echo $student['father_name'];?></td>
                                <td><?php echo $student['class_name'];?></td>
                                <td><?php echo $student['gender'];?></td>
                                <td><?php echo $student['phone'];?></td>
                                
                            </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </div>
               <?php } else{?>
               <div class="alert alert-info">No Student Found.</div>
               <?php }?>
        </main>
        </div>
    </div>
</body>
</html>