<?php
session_start();

if(!isset($_SESSION['role'])|| $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
include '../db_connect.php';
$user_id = $_SESSION['user_id'];

$query = "SELECT COUNT(DISTINCT tc.class_id) AS total_classes
          FROM teachers t
          join teacher_classes tc
          on  t.teacher_id = tc.teacher_id 
          Where t.user_id = $user_id";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_classes = $row['total_classes'];

$subject_query = "SELECT COUNT(DISTINCT s.subject_id) AS total_subjects
          FROM teachers t
          join teacher_classes tc
          on  t.teacher_id = tc.teacher_id 
          join subjects s
          on tc.class_id = s.class_id
          Where t.user_id = $user_id";

$subject_result = mysqli_query($conn, $subject_query);
$subject = mysqli_fetch_assoc($subject_result);
$total_subjects = $subject['total_subjects'];

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_classes = $row['total_classes'];

$student_query = "SELECT COUNT(DISTINCT s.student_id) AS total_students
                  FROM teachers t
                  JOIN teacher_classes tc
                  ON t.teacher_id = tc.teacher_id
                  JOIN students s
                  ON tc.class_id = s.class_id
                  WHERE t.user_id = $user_id";

$student_result = mysqli_query($conn, $student_query);
$student_row = mysqli_fetch_assoc($student_result);

$total_students = $student_row['total_students'];

$attendance_query = "SELECT COUNT(DISTINCT a.attendance_id) AS total_attendance
                     FROM teachers t
                     JOIN teacher_classes tc
                     ON t.teacher_id = tc.teacher_id
                     JOIN students s
                     ON tc.class_id = s.class_id
                     JOIN attendance a
                     ON s.student_id = a.student_id
                     WHERE t.user_id = $user_id";

$attendance_result = mysqli_query($conn, $attendance_query);
$attendance_row = mysqli_fetch_assoc($attendance_result);

$total_attendance = $attendance_row['total_attendance'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- //including bootstrap link -->
     <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <!-- including css file -->
     <link 
        rel="stylesheet" 
        href="includes/teacher_dashboard.css"
    >
    <title>Teacher Dashboard</title>
</head>
<body>
    <?php include 'includes/navbar.php';
    include 'includes/sidebar.php';
    ?>
    <main class="main-content">
        <div class="container-fluid">
            <h2 class="fw-bold mb-1">Teacher Dashboard</h2>
            <p class="text-muted mb-4">Welcome to Your Teacher Pannel</p>
            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Classes</h6>
                        <h2><?php echo $total_classes; ?></h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Subjects</h6>
                        <h2><?php echo $total_subjects;?></h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Students</h6>
                        <h2><?php echo $total_students;?></h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Attendance</h6>
                        <h2><?php echo $total_attendance?></h2>
                    </div>
                </div>
                
            </div>
        </div>
</main>
</body>
</html>