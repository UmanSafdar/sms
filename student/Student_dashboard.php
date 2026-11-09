<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://jsdelivr.net">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Link -->
     <link href="includes/student_dashboard.css" rel="stylesheet">
</head>
<body>

    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>
    <div class="container-fluid">
        <div class="row">
        

        <main class=" col-md-9 col-lg-10 offset-md-3 offset-lg-2 mt-5 border border-light rounded-4 shadow-sm p-4 bg-white">
            <div class="container-fluid mt-5">
                <h2 class="fw-bold mb-1 bg-dark text-white rounded text-center p-3">Student Dashboard</h2>
                <p class="text-muted mb-4">Welcome to Your Student Panel</p>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card p-5">
                            <i class="bi bi-mortarboard fs-1 text-primary"></i>
                                <h6>Fees</h6>
                                
                                <p>Your Fee Record</p>
                                <a href="my_fees.php">View Fees</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card p-5">
                        <i class="bi bi-book fs-1 text-success"></i> 
                        <h6>Personal Info</h6>
                        
                        <p>Your profile info</p>
                        <a href="my_profile.php">View Profile</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-file-earmark-bar-graph fs-1 text-warning"></i>
                                
                                <h6>Results</h6>
                                <h3>85%</h3>
                                <p>Your overall percentage</p>
                                <a href="my_result.php">View Results</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card p-4">
                            <i class="bi bi-calendar-check fs-1 text-danger"></i> 
                                <h6>Attendance</h6>
                                <h3>92%</h3>
                                <p>Your attendance percentage</p>
                                <a href="my_attendance.php">View Attendance</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
    </div>
<script src="https://jsdelivr.net" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>