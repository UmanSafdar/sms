<?php
include '../db_connect.php';


$query = "SELECT users.*, students.profile_status
    FROM users
    LEFT JOIN students ON users.Id = students.user_id
    WHERE users.Role = 'student'
    AND users.status = 'approved'
    AND (students.profile_status IS NULL OR students.profile_status != 'complete')
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));


}
/*==================
         =========== DELETE =========*/   
            if(isset($_GET['id'])){
    $delete_id = $_GET['id'];
    $delete_query = "UPDATE students SET student_status = 'disable' WHERE student_id ='$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    if(!$delete_result){
        
        echo "Error".mysqli_error();
    }}
$student_list ="SELECT students.* ,classes.class_name
FROM students
LEFT JOIN classes ON students.class_id = classes.class_id
 WHERE students.profile_status = 'complete' AND students.student_status = 'active'";
$result_list = mysqli_query($conn, $student_list);


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
        <?php include 'includes/navbar.php'; ?>
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Approved Student Accounts</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <tr>
                            <td><?php echo $row['Id']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td>
                                <a href="students_profile.php?id=<?php echo $row['Id']; ?>"
                                   class="btn btn-primary btn-sm">
                                    Complete Profile
                                </a>
                            </td>
                        </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>
                
            </div>
            <br> 
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Students List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>ADMISSION DATE</th>
                                <th>ROLL NO</th>
                                <th>STUDENT ID</th>
                                <th>STUDENT NAME</th>
                                <th>FATHER NAME</th>
                                <th>CLASS</th>
                                <th>ADDRESS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        while($row = mysqli_fetch_assoc($result_list)){
                        ?>

                        <tr>
                            <td><?php echo $row['admission_date']; ?></td>
                            <td><?php echo $row['roll_no']; ?></td>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['father_name']; ?></td>
                            <td><?php echo $row['class_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            
                            <td>
                                <a href="edit_student.php?id=<?php echo $row['user_id'];?>"
                                   class="btn btn-dark btn-sm">
                                    Edit
                                </a>
                                <a href="students.php?id=<?php echo $row['student_id'];?>"
                                   class="btn btn-danger btn-sm"
                                    onclick="return confirm('are you sure to delete!');">
                                    Delete
                                </a>
                            </td>
                        </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>
                
            </div>
            
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>