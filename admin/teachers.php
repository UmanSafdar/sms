<?php
include '../db_connect.php';

$query = "SELECT users.*, teachers.profile_status
          FROM users
          LEFT JOIN teachers ON users.Id = teachers.user_id
          WHERE users.Role = 'teacher'
          AND users.status = 'approved'
          AND (teachers.profile_status IS NULL 
               OR teachers.profile_status != 'complete')";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$teacher_query = "SELECT * FROM teachers WHERE profile_status ='complete'";
$teacher_result = mysqli_query($conn, $teacher_query);
if($teacher_query){
    echo "Success query";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>

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
                    <h4 class="mb-0">Approved Teacher Accounts</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <tr>
                            <td><?php echo $row['Id']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td>
                                <a href="teacher_profile.php?id=<?php echo $row['Id']; ?>"
                                   class="btn btn-primary btn-sm">
                                    Complete Profile
                                </a>
                            </td>
                        </tr>

                        <?php } }?>

                        </tbody>

                    </table>

                </div>
                
                 
            </div>
            <br>
<div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Teacher List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Teacher Name</th>
                                <th>Qualification</th>
                                <th>Joining Date</th>
                                <th>Salary</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        if(mysqli_num_rows($teacher_result) > 0){
                        while($row = mysqli_fetch_assoc($teacher_result)){
                        ?>

                        <tr>
                            <td><?php echo $row['teacher_id']; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['qualification'];?></td>
                            <td><?php echo $row['joining_date'];?></td>
                            <td><?php echo $row['salary'];?></td>
                            <td>
                                <a href="teachers.php?edit=<?php echo $row['teacher_id'];?>"
                                   class="btn btn-dark btn-sm">
                                    Edit
                                </a>
                                <a href="teachers.php?delete=<?php echo $row['teacher_id'];?>"
                                   class="btn btn-primary btn-sm"
                                   onclick="return confirm('Are you sure to delete ?')";>

                                    Delete
                                </a>
                            </td>
                        </tr>

                        <?php } }?>

                        </tbody>

                    </table>

                </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>