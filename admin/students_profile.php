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
$student_select ="SELECT *FROM users WHERE id = '$id'";
$result = mysqli_query($conn,$student_select);

if($result){
if(mysqli_num_rows($result) > 0){
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
                    <h4 class="mb-0">Complete Student Profile</h4>
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
                                ></textarea>

                            </div>

                        </div>

                        <div class="mt-3">

                            <button
                                type="submit"
                                name="save_student"
                                class="btn btn-primary"
                            >
                                Save Student
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

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>