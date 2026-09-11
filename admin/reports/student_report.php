<?php

include '../../db_connect.php';

$class_id = $_GET['class_id'] ?? '';


// Get classes for dropdown
$class_query = "SELECT * FROM classes ORDER BY class_name ASC";

$class_result = mysqli_query($conn, $class_query);


// Student query
$query = "SELECT 
            students.full_name,
            students.father_name,
            students.roll_no,
            students.gender,
            students.phone,
            classes.class_name

          FROM students

          LEFT JOIN classes
          ON students.class_id = classes.class_id

          WHERE students.profile_status = 'complete'";


// Apply class filter
if ($class_id != '') {

    $class_id = mysqli_real_escape_string($conn, $class_id);

    $query .= " AND students.class_id = '$class_id'";
}


$query .= " ORDER BY students.roll_no ASC";


$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Student Report</h2>

        <div>

            <a href="reports_dashboard.php"
               class="btn btn-secondary">
                Back
            </a>

            <button onclick="window.print()"
                    class="btn btn-dark">
                Print
            </button>

        </div>

    </div>


    <!-- Filter -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <div class="col-md-6">

                        <label class="form-label">
                            Select Class
                        </label>

                        <select name="class_id"
                                class="form-select">

                            <option value="">
                                All Classes
                            </option>

                            <?php while ($class = mysqli_fetch_assoc($class_result)) { ?>

                                <option value="<?= $class['class_id']; ?>"
                                    <?= ($class_id == $class['class_id']) ? 'selected' : ''; ?>>

                                    <?= htmlspecialchars($class['class_name']); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div class="col-md-3">

                        <button type="submit"
                                class="btn btn-primary">

                            Generate Report

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- Report -->

    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="mb-3">
                Student List
            </h4>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>

                    <tr>

                        <th>#</th>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Gender</th>
                        <th>Phone</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php

                    $counter = 1;

                    if (mysqli_num_rows($result) > 0) {

                        while ($student = mysqli_fetch_assoc($result)) {

                    ?>

                        <tr>

                            <td>
                                <?= $counter++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['roll_no']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['full_name']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['father_name']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['class_name'] ?? 'Not Assigned'); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['gender']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['phone']); ?>
                            </td>

                        </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="7"
                                class="text-center">

                                No students found.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>