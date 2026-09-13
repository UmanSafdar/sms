<?php

include '../../db_connect.php';


// =========================
// CLASS REPORT QUERY
// =========================

$query = "SELECT

            classes.class_id,
            classes.class_name,
            classes.description,
            COUNT(students.user_id) AS total_students

          FROM classes

          LEFT JOIN students
          ON classes.class_id = students.class_id
          AND students.profile_status = 'complete'

          GROUP BY
            classes.class_id,
            classes.class_name,
            classes.description

          ORDER BY classes.class_name ASC";


$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Class Report</title>


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

            #classTable,
            #classTable * {
                visibility: visible;
            }

            #classTable {

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

<?php include '../includes/navbar.php'; ?>


<div class="container-fluid">

    <div class="row">


        <!-- =========================
             SIDEBAR
        ========================= -->

        <?php include '../includes/sidebar.php'; ?>


        <!-- =========================
             MAIN CONTENT
        ========================= -->

        <div class="col-md-9 col-lg-10">


            <div class="container mt-5">


                <!-- =========================
                     PAGE HEADER
                ========================= -->

                <div class="d-flex justify-content-between align-items-center mb-4">


                    <h2>

                        Class Report

                    </h2>


                    <div>


                        <!-- BACK BUTTON -->

                        <a href="reports_dashboard.php"
                           class="btn btn-secondary">

                            Back

                        </a>


                        <!-- EXPORT BUTTON -->

                        <a href="export_class.php"
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
                     CLASS REPORT TABLE
                ========================= -->

                <div class="card shadow-sm">


                    <div class="card-body">


                        <h4 class="mb-3">

                            Class List

                        </h4>


                        <div class="table-responsive">


                            <table class="table table-bordered table-striped"
                                   id="classTable">


                                <!-- =========================
                                     TABLE HEADER
                                ========================= -->

                                <thead>


                                    <tr>

                                        <th>#</th>

                                        <th>Class Name</th>

                                        <th>Description</th>

                                        <th>Total Students</th>

                                    </tr>


                                </thead>



                                <!-- =========================
                                     TABLE BODY
                                ========================= -->

                                <tbody>


                                <?php

                                $counter = 1;


                                if (mysqli_num_rows($result) > 0) {


                                    while ($class = mysqli_fetch_assoc($result)) {

                                ?>


                                        <tr>


                                            <td>

                                                <?= $counter++; ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $class['class_name']
                                                ); ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $class['description']
                                                ); ?>

                                            </td>


                                            <td>


                                                <span class="badge bg-primary">

                                                    <?= $class['total_students']; ?>

                                                </span>


                                            </td>


                                        </tr>


                                <?php

                                    }


                                } else {

                                ?>


                                    <tr>


                                        <td colspan="4"
                                            class="text-center">

                                            No classes found.

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