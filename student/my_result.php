<?php 
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}
include '../db_connect.php';
$exam_type = '';
if(isset($_GET['exam_type'])){
    $exam_type = $_GET['exam_type'];
}
$allowed_exams =['Monthly Test', 'Midterm', 'Final'];
if(!in_array($exam_type, $allowed_exams)){
    $exam_type = '';
}
$user_id = (int)$_SESSION['user_id'];

$query = "SELECT student_id FROM students
          Where user_id = $user_id";
$result = mysqli_query($conn, $query);
if(!$result){
    die("Error: ".mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
if(!$row){
    die("Student record not found");
}
$student_id = (int)$row['student_id'];
$total_subjects = 0;
$total_marks = 0;
$obtain_marks = 0;
$percentage = 0;
$marks_rows = [];

if ($exam_type) {

    $marks_query = "SELECT marks.obtain_marks, marks.total_marks,
                           subjects.subject_name
                    FROM marks
                    JOIN subjects
                    ON marks.subject_id = subjects.subject_id
                    WHERE marks.student_id = $student_id
                    AND marks.exam_type = '$exam_type'";

    $marks_result = mysqli_query($conn, $marks_query);

    if (!$marks_result) {
        die("Failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($marks_result)) {

        $marks_rows[] = $row;

        $total_subjects++;
        $total_marks += $row['total_marks'];
        $obtain_marks += $row['obtain_marks'];
    }

    if ($total_marks > 0) {
        $percentage = round(($obtain_marks * 100) / $total_marks, 2);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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
                <form method="GET" action="">
                <label for="exam_type" class="form-label fw-bold">
                    Select Exam Type
                </label>
                <div class="row g-2">
                    <div class="col-md-8">
                 <select name="exam_type" id="exam_type" class="form-select" required>
                    <option value="">Choose Exam</option>
                    <option value="Monthly Test"
                    <?php ($exam_type == 'Monthly Test') ? 'selected' : '';?>>Monthly Test</option>
                    <option value="Midterm">Midterm</option>
                    <?php ($exam_type == 'Midterm') ? 'selected' : '';?>
                    <option value="Final"
                    <?php ($exam_type == 'Final') ? 'selected' : '';?>>Final</option>
                </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            View Result
                        </button>
                    </div>
                </div>
</form>

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
                        <h3 class="fw-bold"><?php echo$total_subjects;?></h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-clipboard-check me-2"></i>Total Marks
                        </h6>
                        <h3 class="fw-bold"><?php echo $total_marks;?></h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-award me-2"></i>Obtained Marks
                        </h6>
                        <h3 class="fw-bold"><?php echo $obtain_marks;?></h3>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">
                            <i class="bi bi-graph-up-arrow me-2"></i>Percentage
                        </h6>
                        <h3 class="fw-bold"><?php echo $percentage;?></h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- Result Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0  d-flex justify-content-between align-items-center">
                    Subject-wise Result</h5>
                <br>
                <h5>Exam Type </h5>
                <?php if ($exam_type) { ?>
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6">
                            <?= htmlspecialchars($exam_type) ?>
                        </span>
                    </div>
                <?php } ?>
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

    <?php if (!$exam_type) { ?>

        <tr>
            <td colspan="5" class="text-center text-muted">
                Select an exam type to view your result.
            </td>
        </tr>

    <?php } elseif (empty($marks_rows)) { ?>

        <tr>
            <td colspan="5" class="text-center text-danger">
                No result found for this exam.
            </td>
        </tr>

    <?php } else { ?>

        <?php foreach ($marks_rows as $mark) { ?>

            <?php
            $subject_percentage = 0;

            if ($mark['total_marks'] > 0) {
                $subject_percentage = round(
                    ($mark['obtain_marks'] / $mark['total_marks']) * 100,2);
            }
            ?>

            <tr>
                <td><?= htmlspecialchars($mark['subject_name']) ?></td>

                <td><?= $mark['obtain_marks'] ?></td>

                <td><?= $mark['total_marks'] ?></td>

                <td><?= $subject_percentage ?>%</td>

                <td><?php if($percentage >45){
                    echo "Pass";}
                    else{
                        echo "Fail";}
                        ?></td>
            </tr>

        <?php } ?>

    <?php } ?>

</tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</main>
</body>
</html>