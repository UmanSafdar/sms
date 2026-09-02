<?php
include '../db_connect.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];


$query = "SELECT * FROM students WHERE  user_id ='$id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

}
else{
    echo "error";
}
if(isset($_POST['student_update'])){
    
            $Full_Name = $_POST['full_name'];
            $Father_Name = $_POST['father_name'];
            $Roll_No = $_POST['roll_no'];
            $Gender = $_POST['gender'];
            $DOB = $_POST['dob'];
            $Phone_No = $_POST['phone'];
            $Address = $_POST['address'];
            $Class_id = $_POST['class_id'];
            $Admission_Date = $_POST['admission_date'];
            //================
            //QUERY TO UPDATE STUDENT RECORD
            $update_student = "UPDATE students SET
              Full_Name = '$Full_Name',
    Father_Name = '$Father_Name',
    Roll_No = '$Roll_No',
    Gender = '$Gender',
    DOB = '$DOB',
    Phone = '$Phone_No',
    Address = '$Address',
    class_id = '$Class_id',
    Admission_Date = '$Admission_Date'
    WHERE user_id='$id'";
    $result_student=mysqli_query($conn, $update_student);
    if($result_student){
        // echo "Record Updated Successfully";
        header("Location: students.php?updated=1");
        exit();
    }
   else{ 
        echo "Error: " . mysqli_error($conn); 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Edit Student</title>
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
        <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid px-4 py-4">

    <div class="row">

    <div class="col-12">

            <div class="card shadow mb-4">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Update Student Profile</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="">

                        <div class="row">

                            <!-- Student Name -->
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">
                                    Student Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="full_name"
                                    name="full_name"
                                    required
                                    value="<?php echo $student['full_name'];?>"
                                >
                            </div>

                            <!-- Father Name -->
                            <div class="col-md-6 mb-3">
                                <label for="father_name" class="form-label">
                                    Father Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="father_name"
                                    name="father_name"
                                    required
                                    value="<?php echo $student['father_name'];?>"
                                >
                            </div>

                            <!-- Roll No -->
                            <div class="col-md-6 mb-3">
                                <label for="roll_no" class="form-label">
                                    Roll No
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="roll_no"
                                    name="roll_no"
                                    required
                                    value="<?php echo $student['roll_no'];?>"
                                >
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label d-block">
                                    Gender
                                </label>

                                <div class="form-check form-check-inline">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        id="male"
                                        value="Male"
                                        <?php if($student['gender']=='Male') echo 'checked';?>
                                        required
                                    >

                                    <label class="form-check-label" for="male">
                                        Male
                                    </label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        id="female"
                                        value="Female"
                                        <?php if($student['gender']=='Female') echo 'checked';?>
                                        required
                                    >

                                    <label class="form-check-label" for="female">
                                        Female
                                    </label>

                                </div>

                            </div>

                            <!-- DOB -->
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">
                                    Date of Birth
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="dob"
                                    name="dob"
                                    value="<?php echo $student['dob'];?>"
                                >
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    Phone No
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    value="<?php echo $student['phone'];?>"
                                >
                            </div>

                            <!-- Class -->
                            <div class="col-md-6 mb-3">
                                <label for="class_id" class="form-label">
                                    Class
                                </label>

                                <select
                                    class="form-select"
                                    id="class_id"
                                    name="class_id"
                                >
                                    <option value="">Select Class</option>
                         <!-- Classes from database -->
                            <?php
                                    $query = "SELECT class_id, class_name FROM classes";
                                    $class_query_result = mysqli_query($conn, $query);
                                    while($row=mysqli_fetch_assoc($class_query_result)){

                            ?>
                            <option value="<?php echo $row['class_id']; ?>"
                               <?php if($row['class_id']==$student['class_id']) echo 'selected';?>>
                                <?php echo $row['class_name']; ?>
                            </option>
                            <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Admission Date -->
                            <div class="col-md-6 mb-3">
                                <label for="admission_date" class="form-label">
                                    Admission Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="admission_date"
                                    name="admission_date"
                                    value="<?php  echo $student['admission_date'];?>"
                                >
                            </div>

                            <!-- Address -->
                            <div class="col-12 mb-3">

                                <label for="address" class="form-label">
                                    Address
                                </label>

                                <textarea
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    rows="3"
                                    
                                ><?php echo $student['address'];?></textarea>

                            </div>

                        </div>

                        <div class="mt-3">

                            <button
                                type="submit"
                                name="student_update"
                                class="btn btn-primary"
                            >
                                Update Student
                            </button>

                            <a
                                href="students.php"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>