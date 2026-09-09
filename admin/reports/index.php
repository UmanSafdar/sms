<?php
include '../../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10 p-4">

                <!-- Navbar -->
                <?php include '../includes/navbar.php'; ?>

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h2>Reports</h2>
                </div>

                <!-- Reports Grid -->
                <div class="row g-4">

                    <!-- Student Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Student Report</h4>
                                <p class="card-text flex-grow-1">
                                    View students with their class and personal information.
                                </p>
                                <div>
                                    <a href="student_report.php" class="btn btn-primary">View Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Fee Report</h4>
                                <p class="card-text flex-grow-1">
                                    View fee payments, pending fees and payment status.
                                </p>
                                <div>
                                    <a href="fee_report.php" class="btn btn-success">View Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Class Report</h4>
                                <p class="card-text flex-grow-1">
                                    View classes and total number of students in each class.
                                </p>
                                <div>
                                    <a href="class_report.php" class="btn btn-warning text-white">View Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>