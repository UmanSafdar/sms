<?php
include '../../db_connect.php';
//===========//
// =================GET FILTER VALUES ========
$class_id = $_GET['class_id'] ?? '';
$month = $_GET['fee_month'] ?? '';
$status = $_GET['status'] ?? '';
//=======
// FEE QUERY =======//
$query = "SELECT
            students.full_name,
            students.roll_no,
            fees.fee_month,
            fees.amount,
            fees.payment_date,
            fees.status FROM fees
            INNER JOIN students
            ON fees.student_id = students.student_id
            LEFT JOIN classes
            ON students.class_id = classes.class_id
            WHERE 1=1";
// CLASS FILTER
if($class_id !=''){
    $class_id = mysqli_real_escape_string($conn, $class_id);
    $query .= "AND students.class_id= '$class_id'";
}
// MONTH FILTER
if($month != ''){
    $month = mysqli_real_escape_string($conn,$month);
    $query .= "AND fees.fee_month = '$month'";
}
// STATUS FILTER
if($status != ''){
    $status = mysqli_real_escape_string($conn,$status);
    $query .= "AND fees.status = '$status'";
}
// SORT RECORD
$query .= " ORDER BY fees.payment_date DESC";
// QUERY EXECUTION
$result =mysqli_query($conn, $query);
// EXCEL HEADERS
header("Content-Type: application/vnd.ms-excel.xls");
header("Content-Disposition: attachment; filename=fee_report.xls");
// =========================
// EXCEL STYLE
// =========================

echo "

<style>

    table {

        border-collapse: collapse;

        width: 100%;

    }

    th, td {

        border: 1px solid black;

        padding: 8px;

    }

    th {

        font-weight: bold;

        background-color: #eeeeee;

    }

</style>

";


// =========================
// TABLE START
// =========================

echo "<table>";


// =========================
// TABLE HEADER
// =========================

echo "<tr>";

echo "<th>#</th>";

echo "<th>Student</th>";

echo "<th>Roll No</th>";

echo "<th>Class</th>";

echo "<th>Month</th>";

echo "<th>Amount</th>";

echo "<th>Payment Date</th>";

echo "<th>Status</th>";

echo "</tr>";


// =========================
// TABLE DATA
// =========================

$counter = 1;


while ($fee = mysqli_fetch_assoc($result)) {


    echo "<tr>";


    echo "<td>";

    echo $counter++;

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars($fee['full_name']);

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars($fee['roll_no']);

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars(
        $fee['class_name'] ?? 'Not Assigned'
    );

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars($fee['fee_month']);

    echo "</td>";


    echo "<td>";

    echo "Rs. " . number_format($fee['amount']);

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars($fee['payment_date']);

    echo "</td>";


    echo "<td>";

    echo htmlspecialchars($fee['status']);

    echo "</td>";


    echo "</tr>";

}


// =========================
// TABLE END
// =========================

echo "</table>";

?>

?>