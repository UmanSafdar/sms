<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';
$has_attendance = '';
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

    $has_attendance = mysqli_num_rows($attendance_result) > 0;


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
// query to get total absents
$absent_sql = "SELECT COUNT(*) AS total_absents
                    FROM attendance
                    WHERE student_id = $student_id and status = 'absent'";
$absent_result = mysqli_query($conn, $absent_sql);
if(!$absent_result){
    die("Query failed".mysqli_error($conn));
}
$absent = mysqli_fetch_assoc($absent_result);
// attendance percentage
if($total['total_attendance'] > 0){
$percentage = round(($present['total_present'] / $total['total_attendance'] )* 100 );
}
else{
    $percentage = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="container-fluid  ">
        <div class="row">
        
<main class="col-md-9 col-lg-10 offset-md-3 offset-lg-2 mt-5 border border-light rounded-4 shadow-sm p-3 bg-white min-vh-100">            <div class="container-fluid mt-5">
                <h2 class="fw-bold mb-3 rounded text-center text-white bg-dark p-4">Student Attendance</h2>
                <p class="text-muted mb-4">Student Attendance Summary </p>
                    <?php if (!$has_attendance): ?>
                        <div class="alert alert-info mt-3">
                            No attendance records found.
                        </div>
                    <?php endif; ?>
               
                <div class="row g-3 bg-light border rounded p-3">
                     <!-- Total Attendance Card  -->
                    <div class="col-12 col-sm-6 col-xl-3 ">
                        <div class="card shadow-sm border-0 ">
                    <div class="card-body ">
                       
                            <h6 class="card-title fw-bold">
                                 <i class="bi bi-calendar-check text-primary me-2"></i>
                                <strong>Total Attendance</strong></h6>
                           <p class="card-text fw-bold fs-3"><?php echo$total['total_attendance'];?></p> 
                        
                    </div>
                    </div>
</div>
                    <!-- Total Present Card  -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card shadow-sm border-0">
                    <div class="card-body ">
                       
                            <h6 class="card-title fw-bold">
                            <i class="bi bi-check-circle text-success me-2"></i>    
                            <strong>Total Present</strong></h6>
                           <p class="card-text fw-bold fs-3"><?php echo$present['total_present'];?></p> 
                        
                    </div>
                    </div> </div>

                    <!-- Total absent Card  -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card shadow-sm border-0">
                    <div class="card-body ">
                       
                            <h6 class="card-title fw-bold">
                            <i class="bi bi-x-circle text-danger me-2"></i>    
                            <strong>Total Absent</strong></h6>
                           <p class="card-text fw-bold fs-3"><?php echo$absent['total_absents'];?></p> 
                        
                    </div>
                    </div> </div>

                      <!-- Total absent Card  -->
                    <div class="col-12 col-sm-6 col-xl-3 ">
                        <div class="card shadow-sm border-0">
                    <div class="card-body ">
                       
                            <h6 class="card-title fw-bold">
                            <i class="bi bi-graph-up-arrow text-info me-2"></i>    
                            <strong>Attendance Percentage</strong></h6>
                           <p class="card-text fw-bold fs-3"><?php echo $percentage;?>
                           <span class="badge bg-primary">%</span></p> 
                        
                    </div>
                    </div> 
                </div>
                    
                
</div>
                </div>
            </div>
            </div>
        </main>
        </div>
      

</body>
</html>