<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=marks_report.xls");
 header("Pragma: no-cache");
header("Expires: 0");

$classId = (int)($_GET['class_id'] ?? 0);
    $subjectId= (int) ($_GET['subject_id'] ?? 0);
    $examType = $_GET['exam_type'] ?? '';
    $report_result = false;

if ($classId > 0 && $subjectId > 0 && $examType != '') {

    $report_sql = "SELECT
                        students.roll_no,
                        students.full_name,
                        students.father_name,
                        marks.obtain_marks
                    FROM marks
                    JOIN students
                        ON marks.student_id = students.student_id
                    JOIN subjects
                        ON marks.subject_id = subjects.subject_id
                    WHERE students.class_id = $classId
                    AND marks.subject_id = $subjectId
                    AND marks.exam_type = '" . mysqli_real_escape_string($conn, $examType) . "'";

    $report_result = mysqli_query($conn, $report_sql);
}
?>
<table border="1">
<tr>
    <th colspan="5">Student Marks Report</th>
</tr>
    <thead>
                <tr>
                    <td>#</td>
                    <td>Roll No</td>
                    <td>Student Name</td>
                    <td>Father Name</td>
                    <td>Obtain Marks</td>
                </tr>
                </thead>
                <tbody>
<?php
$counter = 1;

if ($report_result && mysqli_num_rows($report_result) > 0) {
    while ($r = mysqli_fetch_assoc($report_result)) {
?>
        <tr>
            <td><?php echo $counter++; ?></td>
            <td><?php echo htmlspecialchars($r['roll_no']); ?></td>
            <td><?php echo htmlspecialchars($r['full_name']); ?></td>
            <td><?php echo htmlspecialchars($r['father_name']); ?></td>
            <td><?php echo htmlspecialchars($r['obtain_marks']); ?></td>
        </tr>
<?php
    }
} elseif ($classId > 0 && $subjectId > 0 && $examType != '') {
?>
    <tr>
        <td colspan="5" class="text-center">No marks records found.</td>
    </tr>
<?php
}
?>
</tbody>

</table>