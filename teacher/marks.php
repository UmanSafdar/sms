
<?php
// ================= SESSION START =================
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

// ================= DATABASE CONNECTION =================
include '../db_connect.php';

$user_id = (int) $_SESSION['user_id'];

$error = '';
$success = isset($_GET['saved']);
$selected_class_id = 0;

$classes = [];
$subjects = [];
$students = [];

// ================= GET TEACHER ID =================
$teacher_sql = "SELECT teacher_id
                FROM teachers
                WHERE user_id = $user_id";

$teacher_result = mysqli_query($conn, $teacher_sql);

if (!$teacher_result || mysqli_num_rows($teacher_result) == 0) {
    die("Teacher record not found.");
}

$teacher = mysqli_fetch_assoc($teacher_result);
$teacher_id = (int) $teacher['teacher_id'];

// ================= GET ASSIGNED CLASSES =================
$class_sql = "SELECT classes.class_id, classes.class_name
              FROM classes
              INNER JOIN teacher_classes
              ON classes.class_id = teacher_classes.class_id
              WHERE teacher_classes.teacher_id = $teacher_id";

$class_result = mysqli_query($conn, $class_sql);

while ($class = mysqli_fetch_assoc($class_result)) {
    $classes[] = $class;
}

// ================= GET SELECTED CLASS =================
if (isset($_POST['load_students']) || isset($_POST['save_marks'])) {
    $selected_class_id = (int) $_POST['class_id'];
}

// ================= VERIFY SELECTED CLASS =================
if ($selected_class_id > 0) {

    $check_sql = "SELECT class_id
                  FROM teacher_classes
                  WHERE teacher_id = $teacher_id
                  AND class_id = $selected_class_id";

    $check_result = mysqli_query($conn, $check_sql);

    if (!$check_result || mysqli_num_rows($check_result) == 0) {
        $error = "You are not assigned to this class.";
        $selected_class_id = 0;
    }
}

// ================= SAVE MARKS =================
if (isset($_POST['save_marks']) && $selected_class_id > 0) {

    $subject_id = (int) $_POST['subject_id'];
    $exam_type = $_POST['exam_type'] ?? '';
    $total_marks = $_POST['total_marks'] ?? '';
    $marks = $_POST['marks'] ?? [];

    $allowed_exams = ['Monthly Test', 'Midterm', 'Final'];

    // Validate exam type
    if (!in_array($exam_type, $allowed_exams, true)) {

        $error = "Please select a valid exam type.";

    }

    // Validate total marks
    elseif (!is_numeric($total_marks) || $total_marks <= 0) {

        $error = "Please enter valid total marks.";

    }

    // Validate subject
    else {

        $subject_check = "SELECT subject_id
                          FROM subjects
                          WHERE subject_id = $subject_id
                          AND class_id = $selected_class_id";

        $subject_check_result = mysqli_query($conn, $subject_check);

        if (!$subject_check_result || mysqli_num_rows($subject_check_result) == 0) {
            $error = "Invalid subject selected.";
        }
    }

    // ================= VALIDATE STUDENTS =================
    if ($error == '') {

        $total_marks = (float) $total_marks;

        $student_check = "SELECT student_id
                          FROM students
                          WHERE class_id = $selected_class_id
                          AND student_status = 'active'";

        $student_check_result = mysqli_query($conn, $student_check);

        $active_students = [];

        while ($row = mysqli_fetch_assoc($student_check_result)) {
            $active_students[] = (int) $row['student_id'];
        }

        if (empty($active_students) || !is_array($marks) ||
            count($marks) != count($active_students)) {

            $error = "Please enter marks for all active students.";
        }

        // Validate individual marks
        if ($error == '') {

            foreach ($active_students as $student_id) {

                if (!isset($marks[$student_id]) ||
                    !is_numeric($marks[$student_id]) ||
                    $marks[$student_id] < 0 ||
                    $marks[$student_id] > $total_marks) {

                    $error = "Please enter valid marks for every student. Marks cannot exceed total marks.";
                    break;
                }
            }
        }

        // ================= INSERT OR UPDATE MARKS =================
        if ($error == '') {

            mysqli_begin_transaction($conn);

            $exam_type = mysqli_real_escape_string($conn, $exam_type);

            $save_failed = false;

            foreach ($active_students as $student_id) {

                $student_id = (int) $student_id;
                $obtained_marks = (float) $marks[$student_id];

                $insert_sql = "INSERT INTO marks
                               (student_id, subject_id, exam_type, obtain_marks, total_marks)
                               VALUES
                               ($student_id, $subject_id, '$exam_type',
                               $obtained_marks, $total_marks)

                               ON DUPLICATE KEY UPDATE
                               obtain_marks = VALUES(obtain_marks),
                               total_marks = VALUES(total_marks)";

                $insert_result = mysqli_query($conn, $insert_sql);

                if (!$insert_result) {
                    $save_failed = true;
                    break;
                }
            }

            if ($save_failed) {

                mysqli_rollback($conn);

                $error = "Something went wrong while saving marks.";

            } else {

                mysqli_commit($conn);

                header("Location: marks.php?saved=1");
                exit();
            }
        }
    }
}

// ================= GET SUBJECTS AND STUDENTS =================
if ($selected_class_id > 0) {

    // Get subjects
    $subject_sql = "SELECT subject_id, subject_name, subject_code
                    FROM subjects
                    WHERE class_id = $selected_class_id";

    $subject_result = mysqli_query($conn, $subject_sql);

    while ($subject = mysqli_fetch_assoc($subject_result)) {
        $subjects[] = $subject;
    }

    // Get active students
    $student_sql = "SELECT student_id, full_name, roll_no
                    FROM students
                    WHERE class_id = $selected_class_id
                    AND student_status = 'active'
                    ORDER BY roll_no";

    $student_result = mysqli_query($conn, $student_sql);

    while ($student = mysqli_fetch_assoc($student_result)) {
        $students[] = $student;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Marks</title>
</head>

<body>

<?php
include 'includes/navbar.php';
include 'includes/sidebar.php';
?>

<div class="container-fluid">
    <div class="row">

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">

            <h2 class="mb-4">Students Marks</h2>

            <!-- SUCCESS MESSAGE -->
            <?php if ($success) { ?>

                <div class="alert alert-success">
                    Marks saved successfully!
                </div>

            <?php } ?>

            <!-- ERROR MESSAGE -->
            <?php if ($error != '') { ?>

                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php } ?>

            <!-- CLASS SELECTION FORM -->
            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">Select Class</label>

                    <select name="class_id" class="form-select" required>

                        <option value="">Select Class</option>

                        <?php foreach ($classes as $class) { ?>

                            <option
                                value="<?php echo $class['class_id']; ?>"
                                <?php echo ($selected_class_id == $class['class_id']) ? 'selected' : ''; ?>>

                                <?php echo htmlspecialchars($class['class_name']); ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <button type="submit"
                        name="load_students"
                        class="btn btn-primary">

                    Load Students

                </button>

            </form>

            <!-- SUBJECTS AND STUDENTS -->
            <?php if ($selected_class_id > 0) { ?>

                <hr class="my-4">

                <?php if (empty($students)) { ?>

                    <div class="alert alert-warning">
                        No active students found in this class.
                    </div>

                <?php } elseif (empty($subjects)) { ?>

                    <div class="alert alert-warning">
                        No subjects found for this class.
                    </div>

                <?php } else { ?>

                    <form method="POST">

                        <input type="hidden"
                               name="class_id"
                               value="<?php echo $selected_class_id; ?>">

                        <!-- SUBJECT -->
                        <div class="mb-3">

                            <label class="form-label">Select Subject</label>

                            <select name="subject_id"
                                    class="form-select"
                                    required>

                                <option value="">Select Subject</option>

                                <?php foreach ($subjects as $subject) { ?>

                                    <option value="<?php echo $subject['subject_id']; ?>">

                                        <?php echo htmlspecialchars($subject['subject_name']); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- EXAM TYPE -->
                        <div class="mb-3">

                            <label class="form-label">Exam Type</label>

                            <select name="exam_type"
                                    class="form-select"
                                    required>

                                <option value="">Select Exam Type</option>
                                <option value="Monthly Test">Monthly Test</option>
                                <option value="Midterm">Midterm</option>
                                <option value="Final">Final</option>

                            </select>

                        </div>

                        <!-- TOTAL MARKS -->
                        <div class="mb-3">

                            <label class="form-label">Total Marks</label>

                            <input type="number"
                                   name="total_marks"
                                   class="form-control"
                                   placeholder="Enter Total Marks"
                                   min="1"
                                   step="any"
                                   required>

                        </div>

                        <!-- STUDENTS TABLE -->
                        <div class="table-responsive mt-4">

                            <table class="table table-hover table-bordered">

                                <thead class="table-dark">

                                    <tr>
                                        <th>#</th>
                                        <th>Roll No</th>
                                        <th>Student Name</th>
                                        <th>Obtain Marks</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    $counter = 1;

                                    foreach ($students as $student) {
                                    ?>

                                        <tr>

                                            <td><?php echo $counter++; ?></td>

                                            <td>
                                                <?php echo htmlspecialchars($student['roll_no']); ?>
                                            </td>

                                            <td>
                                                <?php echo htmlspecialchars($student['full_name']); ?>
                                            </td>

                                            <td>

                                                <input type="number"
                                                       name="marks[<?php echo $student['student_id']; ?>]"
                                                       class="form-control"
                                                       min="0"
                                                       step="any"
                                                       placeholder="Enter Marks"
                                                       required>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                        <button type="submit"
                                name="save_marks"
                                class="btn btn-dark mt-3">

                            Save Marks

                        </button>

                    </form>

                <?php } ?>

            <?php } ?>

        </main>

    </div>
</div>

</body>
</html>
