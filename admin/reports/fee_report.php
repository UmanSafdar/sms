<?php

include '../../db_connect.php';


// =========================
// GET FILTER VALUES
// =========================

$class_id = $_GET['class_id'] ?? '';
$month    = $_GET['month'] ?? '';
$status   = $_GET['status'] ?? '';


// =========================
// GET CLASSES
// =========================

$class_query = "SELECT *
                FROM classes
                ORDER BY class_name ASC";

$class_result = mysqli_query($conn, $class_query);


// =========================
// MAIN FEE QUERY
// =========================

$query = "SELECT

            fees.fee_id,
            students.full_name,
            students.roll_no,
            classes.class_name,
            fees.fee_month,
            fees.amount,
            fees.payment_date,
            fees.status

          FROM fees

          INNER JOIN students
          ON fees.student_id = students.student_id

          LEFT JOIN classes
          ON students.class_id = classes.class_id

          WHERE 1=1";


// =========================
// CLASS FILTER
// =========================

if ($class_id != '') {

    $class_id = mysqli_real_escape_string($conn, $class_id);

    $query .= " AND students.class_id = '$class_id'";
}


// =========================
// MONTH FILTER
// =========================

if ($month != '') {

    $month = mysqli_real_escape_string($conn, $month);

    $query .= " AND fees.fee_month = '$month'";
}


// =========================
// STATUS FILTER
// =========================

if ($status != '') {

    $status = mysqli_real_escape_string($conn, $status);

    $query .= " AND fees.status = '$status'";
}


// =========================
// SORT RECORDS
// =========================

$query .= " ORDER BY fees.payment_date DESC";


// =========================
// EXECUTE FEE QUERY
// =========================

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Fee Query Error: " . mysqli_error($conn));
}

// =========================
// CALCULATE TOTAL AMOUNT
// =========================

$total_query = "SELECT

                    COALESCE(SUM(fees.amount), 0) AS total_amount

                FROM fees

                INNER JOIN students
                ON fees.student_id = students.student_id

                WHERE 1=1";


// =========================
// APPLY SAME FILTERS
// =========================

if ($class_id != '') {

    $total_query .= " AND students.class_id = '$class_id'";
}


if ($month != '') {

    $total_query .= " AND fees.fee_month = '$month'";
}


if ($status != '') {

    $total_query .= " AND fees.status = '$status'";
}


// =========================
// EXECUTE TOTAL QUERY
// =========================

$total_result = mysqli_query($conn, $total_query);
if (!$total_result) {
    die("Total Query Error: " . mysqli_error($conn));
}

$total_data = mysqli_fetch_assoc($total_result);
 

$total_amount = $total_data['total_amount'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Fee Report</title>


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

            #feeTable,
            #feeTable * {
                visibility: visible;
            }

            #feeTable {

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

                        Fee Report

                    </h2>


                    <div>


                        <!-- BACK BUTTON -->

                        <a href="reports_dashboard.php"
                           class="btn btn-secondary">

                            Back

                        </a>


                        <!-- EXPORT TO EXCEL -->

                        <a href="export_fee_report.php?class_id=<?= urlencode($class_id); ?>&month=<?= urlencode($month); ?>&status=<?= urlencode($status); ?>"
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
                     SUMMARY
                ========================= -->

                <div class="row mb-4">


                    <div class="col-md-4">


                        <div class="card shadow-sm">


                            <div class="card-body">


                                <h6>

                                    Total Fee Amount

                                </h6>


                                <h3>

                                    Rs. <?= number_format($total_amount); ?>

                                </h3>


                            </div>


                        </div>


                    </div>


                </div>



                <!-- =========================
                     FILTERS
                ========================= -->

                <div class="card shadow-sm mb-4">


                    <div class="card-body">


                        <form method="GET">


                            <div class="row">


                                <!-- =========================
                                     CLASS
                                ========================= -->

                                <div class="col-md-4">


                                    <label class="form-label">

                                        Class

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



                                <!-- =========================
                                     MONTH
                                ========================= -->

                                <div class="col-md-4">


                                    <label class="form-label">

                                        Month

                                    </label>


                                    <select name="month"
                                            class="form-select">


                                        <option value="">

                                            All Months

                                        </option>


                                        <?php

                                        $months = [

                                            'January',
                                            'February',
                                            'March',
                                            'April',
                                            'May',
                                            'June',
                                            'July',
                                            'August',
                                            'September',
                                            'October',
                                            'November',
                                            'December'

                                        ];


                                        foreach ($months as $m) {

                                        ?>


                                            <option value="<?= $m; ?>"
                                                <?= ($month == $m) ? 'selected' : ''; ?>>

                                                <?= $m; ?>

                                            </option>


                                        <?php } ?>


                                    </select>


                                </div>



                                <!-- =========================
                                     STATUS
                                ========================= -->

                                <div class="col-md-4">


                                    <label class="form-label">

                                        Status

                                    </label>


                                    <select name="status"
                                            class="form-select">


                                        <option value="">

                                            All Status

                                        </option>


                                        <option value="Paid"
                                            <?= ($status == 'Paid') ? 'selected' : ''; ?>>

                                            Paid

                                        </option>


                                        <option value="Unpaid"
                                            <?= ($status == 'Unpaid') ? 'selected' : ''; ?>>

                                            Unpaid

                                        </option>


                                    </select>


                                </div>


                            </div>



                            <!-- =========================
                                 BUTTONS
                            ========================= -->

                            <div class="mt-3">


                                <!-- GENERATE REPORT -->

                                <button type="submit"
                                        class="btn btn-success">

                                    Generate Report

                                </button>


                                <!-- RESET -->

                                <a href="fee_report.php"
                                   class="btn btn-outline-secondary">

                                    Reset

                                </a>


                            </div>


                        </form>


                    </div>


                </div>



                <!-- =========================
                     FEE TABLE
                ========================= -->

                <div class="card shadow-sm">


                    <div class="card-body">


                        <h4 class="mb-3">

                            Fee Transactions

                        </h4>


                        <div class="table-responsive">


                            <table class="table table-bordered table-striped"
                                   id="feeTable">


                                <!-- =========================
                                     TABLE HEADER
                                ========================= -->

                                <thead>


                                    <tr>

                                        <th>#</th>

                                        <th>Student</th>

                                        <th>Roll No</th>

                                        <th>Class</th>

                                        <th>Month</th>

                                        <th>Amount</th>

                                        <th>Payment Date</th>

                                        <th>Status</th>

                                    </tr>


                                </thead>



                                <!-- =========================
                                     TABLE BODY
                                ========================= -->

                                <tbody>


                                <?php

                                $counter = 1;


                                if (mysqli_num_rows($result) > 0) {


                                    while ($fee = mysqli_fetch_assoc($result)) {

                                ?>


                                        <tr>


                                            <td>

                                                <?= $counter++; ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $fee['full_name']
                                                ); ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $fee['roll_no']
                                                ); ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $fee['class_name'] ?? 'Not Assigned'
                                                ); ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $fee['fee_month']
                                                ); ?>

                                            </td>


                                            <td>

                                                Rs. <?= number_format(
                                                    $fee['amount']
                                                ); ?>

                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $fee['payment_date']
                                                ); ?>

                                            </td>


                                            <td>


                                                <?php if ($fee['status'] == 'Paid') { ?>


                                                    <span class="badge bg-success">

                                                        Paid

                                                    </span>


                                                <?php } else { ?>


                                                    <span class="badge bg-danger">

                                                        <?= htmlspecialchars(
                                                            $fee['status']
                                                        ); ?>

                                                    </span>


                                                <?php } ?>


                                            </td>


                                        </tr>


                                <?php

                                    }


                                } else {

                                ?>


                                        <tr>


                                            <td colspan="8"
                                                class="text-center">

                                                No fee records found.

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