<?php
// ============ SESSION START ===========//
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

// ============= CONNECTING TO DATABASE ============//
include '../db_connect.php';

//============== GETTING USER ID =============//
$user_id = (int)$_SESSION['user_id'];

// =========== GETTING TEACHER ID ===========//
$teacher_sql = "SELECT teacher_id FROM teachers WHERE user_id = $user_id";
$result = mysqli_query($conn, $teacher_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = (int)($teacher['teacher_id'] ?? 0);

// ============== GETTING ASSIGNED CLASSES ============== //
$class_sql = "SELECT classes.class_id, classes.class_name
              FROM teacher_classes
              INNER JOIN classes ON teacher_classes.class_id = classes.class_id
              WHERE teacher_classes.teacher_id = $teacher_id";
$class_result = mysqli_query($conn, $class_sql);

//=========== CAPTURE FILTER INPUT ==============//
$selected_class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$selected_subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : 0;
$selected_date = !empty($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : date('Y-m-d');

$subject_result = null;
$student_result = null;

//========================= Fetch Subjects if Class is Selected ==========//
if ($selected_class_id > 0) {
    $subject_sql = "SELECT subject_id, subject_name FROM subjects WHERE class_id = $selected_class_id";
    $subject_result = mysqli_query($conn, $subject_sql);
}

//========================= Fetch Students if Class is Selected ==========//
if ($selected_class_id > 0) {
    $student_sql = "SELECT student_id, full_name, roll_no FROM students WHERE class_id = $selected_class_id";
    $student_result = mysqli_query($conn, $student_sql);
}

// ================= Fetch Saved Attendance ================= //
$saved_attendance = [];
if ($selected_class_id > 0 && $selected_subject_id > 0 && !empty($selected_date)) {
    // Cast date to ensure strict date match YYYY-MM-DD
    $formatted_date = date('Y-m-d', strtotime($selected_date));
    
    $att_sql = "SELECT student_id, status FROM attendance 
                WHERE subject_id = $selected_subject_id 
                AND DATE(attendance_date) = '$formatted_date'";
    $att_res = mysqli_query($conn, $att_sql);
    
    if ($att_res) {
        while ($row = mysqli_fetch_assoc($att_res)) {
            // Force student_id to string key and trim status
            $s_id = (string)$row['student_id'];
            $saved_attendance[$s_id] = strtolower(trim($row['status']));
        }
    }
}
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

                <!-- Success / Error Alert Messages -->
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Attendance saved successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                

                <!-- FILTER FORM -->
                <form class="form mb-4" id="filterform" method="GET">
                    <!-- CLASS SELECTION -->
                    <label class="form-label">Select Class</label>
                    <select class="form-select mb-3" name="class_id" onchange="document.getElementById('filterform').submit()">
                        <option value="">Select Class</option>
                        <?php
                        if ($class_result && mysqli_num_rows($class_result) > 0) {
                            while ($class = mysqli_fetch_assoc($class_result)) {
                                $selected = ($class['class_id'] == $selected_class_id) ? 'selected' : '';
                                echo "<option value='{$class['class_id']}' $selected>{$class['class_name']}</option>";
                            }
                        }
                        ?>
                    </select>

                    <!-- SUBJECT SELECTION -->
                    <label class="form-label">Select Subject</label>
                    <select class="form-select mb-3" name="subject_id" onchange="document.getElementById('filterform').submit()">
                        <option value="">Select Subject</option>
                        <?php
                        if ($subject_result && mysqli_num_rows($subject_result) > 0) {
                            while ($subject = mysqli_fetch_assoc($subject_result)) {
                                $selected = ($subject['subject_id'] == $selected_subject_id) ? 'selected' : '';
                                echo "<option value='{$subject['subject_id']}' $selected>{$subject['subject_name']}</option>";
                            }
                        }
                        ?>
                    </select>

                    <!-- DATE SELECTION -->
                    <label class="form-label">Select Date</label>
                    <input type="date" class="form-control mb-3" name="date" value="<?php echo htmlspecialchars($selected_date); ?>" onchange="document.getElementById('filterform').submit()">
                </form>

                <!-- SAVE ATTENDANCE FORM -->
                <form action="save_attendance.php" method="POST">
                    <input type="hidden" name="class_id" value="<?php echo $selected_class_id; ?>">
                    <input type="hidden" name="subject_id" value="<?php echo $selected_subject_id; ?>">
                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($selected_date); ?>">

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
                                <?php 
                                $serial = 1;
                                if (!empty($student_result) && mysqli_num_rows($student_result) > 0) {
                                    while ($student = mysqli_fetch_assoc($student_result)) {
                                        $current_status = $saved_attendance[$student['student_id']] ?? 'present'; 
                                ?>
                                <tr>
                                    <td><?php echo $serial; ?></td>
                                    <td><?php echo htmlspecialchars($student['roll_no']); ?></td>
                                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                                    <td>
                                        <select name="attendance[<?php echo $student['student_id']; ?>]" class="form-select form-select-sm">
                                            
                                            <option value="present" <?php echo ($current_status === 'present') ? 'selected' : ''; ?>>Present</option>
                                            <option value="absent" <?php echo ($current_status === 'absent') ? 'selected' : ''; ?>>Absent</option>
                                        </select>
                                    </td>
                                </tr>   
                                <?php 
                                        $serial++;
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No students found or select a class first.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($selected_class_id > 0 && $selected_subject_id > 0 && !empty($student_result) && mysqli_num_rows($student_result) > 0): ?>
                        <button type="submit" name="save_attendance" class="btn btn-primary my-3">Save Attendance</button>
                    <?php endif; ?>
                </form>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>