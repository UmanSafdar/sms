

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard</title>
</head>
<body>
    <?php include '../includes/navbar.php';?>
    <div class="container-fluid">
        <div class="row mb-4">
        <?php include '../includes/sidebar.php';?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">
                <h2 class="mt-4"> Report Dashboard </h2>

                <!-- Reports Grid -->
                <div class="row g-4">

                    <!-- Student Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Student Report</h4>
                                <p class="card-text flex-grow-1">
                                    View students information.
                                </p>
                                <div>
                                    <a href="student_report.php" class="btn btn-primary">View Report</a>
                                </div>
                            </div>

                        </div>
                    </div>
                        <!-- Student Attendance Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Student Attendance Report</h4>
                                <p class="card-text flex-grow-1">
                                    View students attendance information.
                                </p>
                                <div>
                                    <a href="attendance_report.php" class="btn btn-primary">View Report</a>
                                </div>
                            </div>

                        </div>
                    </div>
                        <!-- Student Marks Report -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title">Student Marks Report</h4>
                                <p class="card-text flex-grow-1">
                                    View students marks information.
                                </p>
                                <div>
                                    <a href="marks_report.php" class="btn btn-primary">View Report</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>  

            </main>
        </div>

    </div>
</body>
</html>