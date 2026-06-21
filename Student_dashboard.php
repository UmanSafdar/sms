<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">
    <?php
    include 'navbar.php';
    ?>

<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-dark p-0">

            <div class="text-center text-white py-4 border-bottom">
                <h4>SMS Admin</h4>
            </div>

            <div class="list-group list-group-flush">

                <a href="admin_dashboard.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-gauge me-2"></i> Dashboard
                </a>

                <a href="students.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-user-graduate me-2"></i> Students
                </a>

                <a href="teachers.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Teachers
                </a>

                <a href="classes.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-school me-2"></i> Classes
                </a>

                <a href="subjects.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-book me-2"></i> Subjects
                </a>

                <a href="attendance.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-calendar-check me-2"></i> Attendance
                </a>

                <a href="fees.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-money-bill-wave me-2"></i> Fees
                </a>

                <a href="reports.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-chart-line me-2"></i> Reports
                </a>

                <a href="settings.php"
                   class="list-group-item list-group-item-action bg-dark text-white border-secondary">
                    <i class="fas fa-gear me-2"></i> Settings
                </a>

                <a href="logout.php"
                   class="list-group-item list-group-item-action bg-danger text-white">
                    <i class="fas fa-right-from-bracket me-2"></i> Logout
                </a>

            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard</h2>
                <span class="badge bg-primary fs-6">Welcome Admin</span>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3">

                <div class="col-md-6 col-lg-3">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <h3>150</h3>
                            <p class="mb-0">Students</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-bg-success">
                        <div class="card-body">
                            <h3>20</h3>
                            <p class="mb-0">Teachers</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <h3>10</h3>
                            <p class="mb-0">Classes</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-bg-info">
                        <div class="card-body">
                            <h3>35</h3>
                            <p class="mb-0">Subjects</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Activities -->
            <div class="card mt-4">
                <div class="card-header">
                    Recent Activities
                </div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>21-06-2026</td>
                            <td>New Student Registered</td>
                        </tr>

                        <tr>
                            <td>21-06-2026</td>
                            <td>Attendance Submitted</td>
                        </tr>

                        <tr>
                            <td>21-06-2026</td>
                            <td>Fee Payment Received</td>
                        </tr>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>