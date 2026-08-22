<?php

// including database file and testing that either we are connect with db or not.
include '../db_connect.php';
if(!$conn){
    die("Connection Failed:");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    echo "error";
}
$teacher_select ="SELECT *FROM users WHERE id = '$id'";
$result = mysqli_query($conn,$teacher_select);

if($result){
if(mysqli_num_rows($result) > 0){


?>
<?php
        if($_SERVER['REQUEST_METHOD']== "POST"){
            if(isset($_GET['id'])){
              $id = $_GET['id'];
                        }
            $Full_Name = $_POST['full_name'];
            $Qualification = $_POST['qualification'];
            $Specialization = $_POST['specialization'];
            $Phone_No = $_POST['phone'];
            $Salary = $_POST['salary'];
            $Joining_date = $_POST['joining_date'];
            $check = "SELECT teacher_id FROM teachers where user_id = $id";
            $check_query = mysqli_query($conn, $check);
            $row =mysqli_num_rows($check_query);
            if($row> 0){
                echo "Record already exist";
            }
            else{

            
        $profile_query = "INSERT INTO teachers (user_id,full_name,qualification, specialization,phone,salary,joining_date)
                            VALUES('$id','$Full_Name', '$Qualification','$Specialization','$Phone_No','$Salary','$Joining_date')";
                           
        $presult = mysqli_query($conn, $profile_query);
        if($presult){
            
                     $update = "UPDATE teachers SET profile_status = 'complete'
                     WHERE user_id = $id";
                     mysqli_query($conn, $update);
                    echo "Record Saved Successfully";
                    //  header("Location: teacher.php");
                    //  exit();

            
        }
        

        }
        }
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

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Accounts Information</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <tr>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                             
                        </tr>

                        <?php }
                        }
} ?>

                        </tbody>

                    </table>
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
                                    id="qualificaation"
                                    name="qualification"
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
                                    placeholder="03XXXXXXXXX"
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
                                    required
                                >
                                <div class="mt-3">

                            <button
                                type="submit"
                                name="save_student"
                                class="btn btn-primary"
                            >
                                Save Profile
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