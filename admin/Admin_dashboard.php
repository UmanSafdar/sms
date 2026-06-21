<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">

            <?php include 'includes/navbar.php'; ?>

            <div class="container">

                <h2 class="mb-4">Dashboard</h2>

                <div class="row g-3">

                    <div class="col-md-3">
                        <div class="card text-bg-primary">
                            <div class="card-body">
                                <h3>150</h3>
                                <p>Total Students</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-bg-success">
                            <div class="card-body">
                                <h3>20</h3>
                                <p>Total Teachers</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-bg-warning">
                            <div class="card-body">
                                <h3>10</h3>
                                <p>Total Classes</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-bg-info">
                            <div class="card-body">
                                <h3>35</h3>
                                <p>Total Subjects</p>
                            </div>
                        </div>
                    </div>

                </div>

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
                                    <td>Student Added</td>
                                </tr>

                                <tr>
                                    <td>21-06-2026</td>
                                    <td>Attendance Submitted</td>
                                </tr>

                                <tr>
                                    <td>21-06-2026</td>
                                    <td>Fee Received</td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

            <?php include 'includes/footer.php'; ?>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>