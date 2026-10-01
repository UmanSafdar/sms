<?php
//=============SESSION START============//
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}
//////=========== Including Database Connection===========
include '../db_connect.php';

if(isset($_POST['save_marks'])){
    $subject_id = $_POST['subject_id'];
    $exam_type = $_POST['exam_type'];
    $total_marks = $_POST['total_marks'];
    $marks = $_POST['marks'];
    foreach($marks as $student_id => $obtained_marks){

    
    $Insert_sql = "INSERT INTO marks(student_id, subject_id, exam_type, obtain_marks, total_marks)
                    Values($student_id, $subject_id, '$exam_type', $obtained_marks, $total_marks)";
    $Insert_result = mysqli_query($conn, $Insert_sql);
}}
// =========Get Teacher Id using user id ============//
$user_id = $_SESSION['user_id'];
$select_sql = "SELECT teacher_id FROM teachers WHERE user_id= $user_id";
$result = mysqli_query($conn, $select_sql);
$teacher = mysqli_fetch_assoc($result);
$teacher_id = $teacher['teacher_id'];
//==========Getting Class id by using Teacher id===========
$class_sql = "SELECT class_id FROM teacher_classes WHERE teacher_id = $teacher_id";
$class_result = mysqli_query($conn, $class_sql);
$class = mysqli_fetch_assoc($class_result);
$class_id = $class['class_id'];

//========= Getting Class name using class id =========//
$class_sql = "SELECT classes.class_id, classes.class_name FROM classes
INNER JOIN teacher_classes
ON classes.class_id = teacher_classes.class_id
WHERE teacher_classes.teacher_id= $teacher_id";
$class_result = mysqli_query($conn, $class_sql);
$class = mysqli_fetch_assoc($class_result);
$class_Name = $class['class_name'];

//////========== Getting Subject Id ===========//
$subject_sql = "SELECT subject_id, subject_name, subject_code
                FROM subjects WHERE class_id = $class_id";
$subject_result = mysqli_query($conn, $subject_sql);

//=========== Getting Students of Teacher's Classes============//
$student_sql = "SELECT student_id, full_name, roll_no
                FROM students
                WHERE class_id = $class_id
                AND  student_status = 'active'
                ORDER BY roll_no";
$student_result = mysqli_query($conn, $student_sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php';?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">
            <?php if(isset($Insert_result)){?>
        <div class="alert alert-success">Marks are Saved Successfully</div>
         <script>
                        setTimeout(function(){
                            window.location.href = 'marks.php';
                        }, 2000);
                    </script>
        <?php }?>
        <h2 class="mb-4"> Students Marks </h2>
        <form Method="POST">
        <div class="mb-3">
            <label class="form-label">
                Class
            </label>
            <input type="text"
            class="form-control"
            value = "<?php echo $class_Name;?>"
            readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">
                Subject
            </label>
            <select name="subject_id" class="form-select" required>
                <option value="">Select Subject</option>
            <?php if(mysqli_num_rows($subject_result) > 0){
                while($subject = mysqli_fetch_assoc($subject_result)){ ?>
            <option value="<?php echo $subject['subject_id']?>">
                <?php echo $subject['subject_name'];?>
            </option>
           <?php } ?>
            </select>
            <?php
                    }?>
        </div>
        <div class="mb-3">
            <label class="form-label">
                Exam Type
            </label>
            <select name="exam_type" class="form-select">
                <option value="">Select Subject</option>
                <option value="Monthly Exam">Monthly Exam</option>
                <option value="Midterm">Midterm</option>
                <option value="Finalterm">Final Term</option>
            </select>
        </div class="mb-3">
        <label class="form-label">Total Marks</label>
        <input type="text"
                name="total_marks"
                placeholder="Enter Total Marks"
                required
                min="1"
                class="form-control">
        <div>
            <div class="table-responsive mt-4">
                <table class="table table-hover">
                    <tr>
                        <thead>
                        <th>#</th>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>Obtain Marks</th>
                    </thead>
</tr>
                    <tbody>
                        <?php 
                        $counter = 1;
                        if(mysqli_num_rows($student_result) > 0){
                            while($student=mysqli_fetch_assoc($student_result)){ ?>
                           <tr>
                            <td><?php echo $counter;?></td>
                            <td><?php echo $student['roll_no'];?></td>
                            <td><?php echo $student['full_name'];?></td>
                            <td><input type="number"
                                        name="marks[<?php echo $student['student_id'];?>]"
                                        class="form-control"
                                        min="0"
                                        required>
                                       </td> </tr>
                          <?php    }

                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button class="btn btn-dark" type="submit" name="save_marks">Save Marks</button>
            </div>
            </form>
        </div>
    </main>
        </div>
    </div>
</body>
</html>