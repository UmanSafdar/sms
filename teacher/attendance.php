<?php
// ============ SESSION START ===========//
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
// ============= CONNECTING TO DATABASE============//
include '../db_connect.php';

//============== GETTING USER ID =============//
$user_id = $_SESSION['user_id'];

// =========== GETTING TEACHER ID ===========//
$teacher_sql = "SELECT teacher_id FROM teachers WHERE user_id = $user_id";
$result = mysqli_query($conn, $teacher_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];

// ============== GETTING ASSIGNED CLASSES ============== //

$class_sql = "SELECT classes.class_id, classes.class_name
             FROM teacher_classes
            INNER JOIN classes
               ON teacher_classes.class_id = classes.class_id
            WHERE teacher_classes.teacher_id = $teacher_id
";

$class_result = mysqli_query($conn, $class_sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/my_sms/teacher/includes/navbar.css">
    <link rel="stylesheet" href="/my_sms/teacher/includes/sidebar.css">

</head>
<body>
    <?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

    <div class="row">

        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">

            <h2 class="mb-4">Students Attendance</h2>
            <form class="form">
                <label class="form-label">Select Class</label>
                <select  class="form-select mb-3">
                        <option value="">Select Class</option>
                    </select>
                                    <label class="form-label">Select Subject</label>
                                    <select  class="form-select mb-3">
                                            <option value="">Select Subject</option>
                                        </select>
                <label class="form-label">Select Date</label>
                    <input type="date" class="form-control mb-3">
            </form>
            <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-dark">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Roll No</th>
                                <th>Student Name</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>1</td>
                            <td>10</td>
                            <td>A</td>
                            <td>
                                <select class="form-select">
                                    <option value="">Select Status</option>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option></select>
                            </td> </tr>
</tbody>
</table>
</div>
                    <button type="submit" class="btn btn-primary">Save Attendance</button>

</main>
    </div>
</div>
</body>
</html>