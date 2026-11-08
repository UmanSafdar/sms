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
                        <div class="dashboard-card">
                            <h6>Classes</h6>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card">
                            <h6>Subjects</h6>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card">
                            <h6>Result</h6>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="dashboard-card">
                            <h6>Attendance</h6>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        </div>
    </div>

</body>
</html>