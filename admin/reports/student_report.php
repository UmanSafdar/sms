<?php

include '../../db_connect.php';



// =========================
// GET SELECTED CLASS ID
// =========================

$class_id = $_GET['class_id'] ?? '';


// =========================
// GET CLASSES FOR DROPDOWN
// =========================

$class_query = "SELECT * 
                FROM classes 
                ORDER BY class_name ASC";

$class_result = mysqli_query($conn, $class_query);


// =========================
// STUDENT QUERY
// =========================

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


// =========================
// APPLY CLASS FILTER
// =========================

if ($class_id != '') {

    $class_id = mysqli_real_escape_string($conn, $class_id);

    $query .= " AND students.class_id = '$class_id'";
}


// =========================
// SORT STUDENTS
// =========================

$query .= " ORDER BY students.roll_no ASC";


// =========================
// EXECUTE QUERY
// =========================

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Report</title>


    <!-- =========================
         BOOTSTRAP
    ========================= -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">


    <!-- =========================
         PRINT CSS
    ========================= -->

    <style>

        @media print {

            body * {
                visibility: hidden;
            }

            #studentTable,
            #studentTable * {
                visibility: visible;
            }

            #studentTable {

                position: absolute;

                left: 0;

                top: 0;

                width: 100%;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->




<div class="container-fluid">

    <div class="row">
<?php include '../includes/navbar.php'; ?>

        <!-- =========================
             SIDEBAR
        ========================= -->

        <?php include '../includes/sidebar.php'; ?>


        <!-- =========================
             MAIN CONTENT
        ========================= -->

        <div class="col-md-9 col-lg-10 offset-md-2 mt-5">


            <div class="container mt-5">


                <!-- =========================
                     PAGE HEADER
                ========================= -->

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h2>

                        Student Report

                    </h2>


                    <div>


                        <!-- BACK BUTTON -->

                        <a href="reports_dashboard.php"
                           class="btn btn-secondary">

                            Back

                        </a>


                        <!-- EXPORT BUTTON -->

                        <a href="export_student.php?class_id=<?= $class_id; ?>"
                           class="btn btn-success">

                            Export to Excel

                        </a>


                        <!-- PRINT BUTTON -->

                        <button onclick="window.print()"
                                class="btn btn-dark">

                            Print

                        </button>


                    </div>

                </div>



                <!-- =========================
                     CLASS FILTER
                ========================= -->

                <div class="card shadow-sm mb-4">

                    <div class="card-body">


                        <form method="GET">


                            <div class="row align-items-end">


                                <!-- CLASS DROPDOWN -->

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



                                <!-- GENERATE BUTTON -->

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



                <!-- =========================
                     STUDENT REPORT
                ========================= -->

                <div class="card shadow-sm">

                    <div class="card-body">


                        <h4 class="mb-3">

                            Student List

                        </h4>


                        <div class="table-responsive">


                            <table class="table table-bordered table-striped"
                                   id="studentTable">


                                <!-- =========================
                                     TABLE HEADER
                                ========================= -->

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



                                <!-- =========================
                                     TABLE BODY
                                ========================= -->

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

                                                    <?= htmlspecialchars(
                                                        $student['roll_no']
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $student['full_name']
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $student['father_name']
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $student['class_name'] ?? 'Not Assigned'
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $student['gender']
                                                    ); ?>

                                                </td>


                                                <td>

                                                    <?= htmlspecialchars(
                                                        $student['phone']
                                                    ); ?>

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

        </div>


    </div>

</div>


<!-- =========================
     BOOTSTRAP JS
========================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>