<?php
include '../db_connect.php';

$query = "SELECT * FROM users WHERE Role='student' AND status='approved'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
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

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">

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

        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>