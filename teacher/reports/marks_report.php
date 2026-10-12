<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';


    $classId = (int)($_GET['class_id'] ?? 0);
    $subjectId= (int) ($_GET['subject_id'] ?? 0);
    $examType = $_GET['exam_type'] ?? '';

echo "Class ID received: " . $classId;

/// GETTING USER ID ///
$user_id = $_SESSION['user_id'];

// query to get teacher id using user id
$query = "SELECT teacher_id FROM
                     teachers
                   Where user_id = $user_id";
    $result = mysqli_query($conn, $query);
    $t = mysqli_fetch_assoc($result);
    $teacher_id = $t['teacher_id'];

// query to get assign classes by uisng teacher id
 $teacher_sql = "SELECT classes.class_name, classes.class_id, teacher_classes.teacher_id from
                    classes
                    LEFT join teacher_classes
                    on classes.class_id = teacher_classes.class_id
                    where teacher_classes.teacher_id = $teacher_id";
    $teacher_result = mysqli_query($conn, $teacher_sql);
    
    // // query to get exam type from marks table
    $exam_sql = "SELECT DISTINCT marks.exam_type FROM marks";
    $exam_result= mysqli_query($conn, $exam_sql);

    $subject_sql = "SELECT subject_id, subject_name from subjects where class_id = $classId ";
    $subject_result = mysqli_query($conn, $subject_sql);

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
<!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks Report</title>
    <style>
        @media print{
            body *{
                visibility: hidden;
            }

            #classTable,
            #classTable *{
                visibility: visible;
            }
            #classTable{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%

            }
        }
    </style>
   </head>
   <body>
        <?php include '../includes/navbar.php';?>
        <div class="container-fluid">
            <div class="row">
                <?php include '../includes/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 offset-md-3 offset-lg-2 mt-5 pt-4 mb-5">
            <br>
            <h2 class="mb-4 text-center rounded bg-dark text-white">Students Marks Report</h2>
            <form method="GET">
                <div class="d-flex align-item-center gap-4">
                    <div class="mb-4">
                    <label class="form-label ">Select a class</label>
</div>
                <div class="mb-4">
<select
    name="class_id"
    id="class_id"
    class="form-select"
    onchange="window.location.href='?class_id=' + this.value">
                           <option value="">Select A Class</option>
                   <?php if(mysqli_num_rows($teacher_result) >0){
                    while($class=mysqli_fetch_assoc($teacher_result)){
                        $selected = ($classId == $class['class_id']) ? 'selected' : '';
                        
                       
                   echo"<option value='{$class['class_id']}'$selected>
                    {$class['class_name']}
                   </option>";
                   
                   }
                   }   ?>
                    </select>
                </div>
                <!-- dynamic drop down of subject -->
                 <div>
                    <label class="form-label ">Select a subject</label>
</div>
                 <div class="mb-4">
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">Select Subject</option>
                   <?php if(mysqli_num_rows($subject_result) >0){
                    while($row=mysqli_fetch_assoc($subject_result)){
                        $selected = ($subjectId ==$row['subject_id']) ? 'selected' : '';
                   echo"<option value='{$row['subject_id']}'$selected>
                    {$row['subject_name']}
                   </option>";
                   
                   }
                   }   ?>
                    </select>
                </div>
                <!-- dynamic drop down of exam type -->
                 <div class="mb-4">
                    <select name="exam_type" id="exam_type" class="form-select">
                        <option value="">Select Exam Type</option>
                   <?php if(mysqli_num_rows($exam_result) >0){
                    while($row=mysqli_fetch_assoc($exam_result)){
                        $selected = ($examType == $row['exam_type'])? 'selected' : '';
                   echo"<option value='{$row['exam_type']}'$selected;>
                    {$row['exam_type']}
                   </option>";
                   
                   }
                   }   ?>
                    </select>
                </div>
                <div class="d-flex align-item-center gap-2 mb-4">
                    <button class="btn btn-dark" type="submit" name="submit">Generate Result Report</button>
                    <a href="reports_dashboard.php" class="btn btn-dark">Back</a>
                    <a href="export_marks_report.php?class_id=<?php echo $class_id;?>" class="btn btn-dark">Export to Excel</a>
                    <button class="btn btn-dark" onclick="window.print()">Print</button>
            </div>
                </div>
                 
            </form>
            <?php if ($examType != '') { ?>
    <h5 class="mb-3">
        Exam Type:
        <span class="badge bg-dark">
            <?php echo htmlspecialchars($examType); ?>
        </span>
    </h5>
<?php } ?>
            <table class="table table-dark table-hover table-striped">
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
               
            
</body>
</html>