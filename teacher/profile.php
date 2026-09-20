<?php

session_start();
include '../db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$q = "SELECT 
        users.Email,
        teachers.full_name,
        teachers.qualification,
        teachers.specialization,
        teachers.phone,
        teachers.salary,
        teachers.joining_date,
        teachers.status
        FROM users
        INNER JOIN teachers
        ON users.Id = teachers.user_Id
        WHERE teachers.user_Id = $user_id";

$result = mysqli_query($conn, $q);
$teacher = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="includes/profile.css" rel="stylesheet">
    <title>Teacher Profile</title>
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid profile-container">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 ms-auto p-4">
                <br><br><br>
                <h2 class="mb-4 profile-title">My Profile</h2>

                <div class="row g-4">

                    <!-- Teacher Information -->
                    <div class="col-md-4">
                        <!-- Added h-100 to make the card take full column height -->
                        <div class="card profile-card h-100">
                            <div class="card-body">
                                <h4 class="profile-card-title">
                                    <strong>Teacher Name: </strong>
                                    <?php echo $teacher['full_name']; ?>
                                </h4>
                                <p class="profile-info">
                                    <strong>Email: </strong>
                                    <?php echo $teacher['Email']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Role: </strong>
                                    Teacher
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="col-md-4">
                        <!-- Added h-100 to make the card take full column height -->
                        <div class="card profile-card h-100">
                            <div class="card-body">
                                <h4 class="profile-card-title">
                                    Professional Information
                                </h4>
                                <p class="profile-info">
                                    <strong>Qualification: </strong>
                                    <?php echo $teacher['qualification']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Specialization: </strong>
                                    <?php echo $teacher['specialization']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Phone No: </strong>
                                    <?php echo $teacher['phone']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Joining Date: </strong>
                                    <?php echo $teacher['joining_date']; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="col-md-4">
                        <!-- Added h-100 to make the card take full column height -->
                        <div class="card profile-card h-100">
                            <div class="card-body">
                                <h4 class="profile-card-title">
                                    Employment Information
                                </h4>
                                <p class="profile-info">
                                    <strong>Role: </strong>
                                    Teacher
                                </p>
                                <p class="profile-info">
                                    <strong>Salary: </strong>
                                    <?php echo $teacher['salary']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Status: </strong>
                                    <?php echo $teacher['status']; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Edit Profile Button -->
                <div class="profile-action mt-4">
                    <a href="edit_profile.php" class="btn btn-dark">
                        Edit Profile
                    </a>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
