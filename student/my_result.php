<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <?php include 'includes/navbar.php';
    include 'includes/sidebar.php';?>
    <br><br><br>
    <main class="col-md-9 col-lg-10 offset-md-3 offset-lg-2 p-4 min-vh-100">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">My Result</h2>
                <p class="text-muted mb-0">
                    View your academic performance
                </p>
            </div>
        </div>

        <!-- Exam Selection -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <label for="exam_type" class="form-label fw-bold">
                    Select Exam Type
                </label>

                <select name="exam_type" id="exam_type" class="form-select">
                    <option value="">Choose Exam</option>
                    <option value="Monthly Test">Monthly Test</option>
                    <option value="Midterm">Midterm</option>
                    <option value="Final">Final</option>
                </select>

            </div>
        </div>

        <!-- Result Summary Cards -->
        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-book me-2"></i>Total Subjects
                        </h6>
                        <h3 class="fw-bold">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-clipboard-check me-2"></i>Total Marks
                        </h6>
                        <h3 class="fw-bold">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-award me-2"></i>Obtained Marks
                        </h6>
                        <h3 class="fw-bold">0</h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-graph-up-arrow me-2"></i>Percentage
                        </h6>
                        <h3 class="fw-bold">0%</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Result Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">Subject-wise Result</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Subject</th>
                                <th>Obtained Marks</th>
                                <th>Total Marks</th>
                                <th>Percentage</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Select an exam type to view your result.
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</main>
</body>
</html>