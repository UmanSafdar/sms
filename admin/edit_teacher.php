<?php
include '../db_connect.php';
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $query = "SELECT * FROM teachers WHERE  teacher_id ='$id'";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);
if(isset($_POST['update_teacher'])){
    
            $Full_Name = $_POST['full_name'];
            $Qualification = $_POST['qualification'];
            $Specialization = $_POST['specialization'];
            $Phone_No = $_POST['phone'];
            $Salary = $_POST['salary'];
            $Joining_date = $_POST['joining_date'];
            //================
            //QUERY TO UPDATE STUDENT RECORD
            $update_teacher = "UPDATE teachers SET
              full_name = '$Full_Name',
            qualification = '$Qualification',
    specialization = '$Specialization',
    phone = '$Phone_No',
    salary = '$Salary',
    joining_date = '$Joining_date'
    
    WHERE teacher_id='$id'";
    $result_teacher=mysqli_query($conn, $update_teacher);
    if($result_teacher){
        echo "Record Updated Successfully";
        header("Location: teachers.php?updated=1");
        exit();
    }
else{
    echo "error";
}
      
}

}

    //     /* =========== DELETE =========*/   
    //         if(isset($_GET['id'])){
    // $delete_id = $_GET['id'];
    // $delete_query = "UPDATE students SET student_status = 'disable' WHERE student_id ='$delete_id'";
    // $delete_result = mysqli_query($conn, $delete_query);
    // if(!$delete_result){
        
    //     echo "Error".mysqli_error();
    // }}
// $student_list ="SELECT students.* ,classes.class_name
// FROM students
// LEFT JOIN classes ON students.class_id = classes.class_id
//  WHERE students.profile_status = 'complete' AND students.student_status = 'active'";
// $result_list = mysqli_query($conn, $student_list);


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">

            
                    <div class="container-fluid px-4 py-4">

    <div class="row">

    <div class="col-12">

            <div class="card shadow mb-4">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Complete Teacher Profile</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="">

                        <div class="row">

                            <!-- Teacher Name -->
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">
                                    Teacher Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="full_name"
                                    name="full_name"
                                    value="<?php echo $teacher['full_name'];?>"
                                    required
                                >
                            </div>

                            <!-- Qualification -->
                            <div class="col-md-6 mb-3">
                                <label for="qualification" class="form-label">
                                    Qualification
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="qualification"
                                    name="qualification"
                                    value="<?php echo $teacher['qualification'];?>"
                                    required
                                >
                            </div>

                            <!-- Specialization -->
                            <div class="col-md-6 mb-3">
                                <label for="roll_no" class="form-label">
                                    Specialization
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="specialization"
                                    name="specialization"
                                    value="<?php echo $teacher['specialization'];?>"
                                    required
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
                                    value="<?php echo $teacher['phone'];?>"
                                >
                            </div>
                             <!-- Salary -->
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label">
                                    Salary
                                </label>

                                <input
                                type="number"
                                    class="form-control"
                                    id="salary"
                                    name="salary"
                                    required
                                    value="<?php echo $teacher['salary'];?>"
                                >
                            </div>
                             <!-- Joining Date -->
                            <div class="col-md-6 mb-3">
                                <label for="admission_date" class="form-label">
                                    Joining Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="joining_date"
                                    name="joining_date"
                                    value="<?php echo $teacher['joining_date'];?>"
                                    required
                                >
                                <div class="mt-3">

                            <button
                                type="submit"
                                name="update_teacher"
                                class="btn btn-primary"
                            >
                                Update Profile
                            </button>

                            <a
                                href="teachers.php"
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

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>