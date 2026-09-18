<?php
session_start();

if(!isset($_SESSION['role'])|| $_SESSION['role'] != 'teacher'){
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
     <!-- //including bootstrap link -->
     <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <!-- including css file -->
     <link 
        rel="stylesheet" 
        href="teacher_dashboard.css"
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
                        <h2>0</h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Subjectss</h6>
                        <h2>0</h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Classes</h6>
                        <h2>0</h2>
                    </div>
                </div>
                 <div class="col-md-6 col-xl-3">
                    <div class="dashboard-card">
                        <h6>Total Classes</h6>
                        <h2>0</h2>
                    </div>
                </div>
                
            </div>
        </div>
</main>
</body>
</html>