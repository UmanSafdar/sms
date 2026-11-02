


<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}
include '../db_connect.php';
$user_id = $_SESSION['user_id']; // get user id from session variables
$student_sql = "SELECT 
              students.full_name,
              students.father_name,
              students.roll_no,
              students.gender,
              students.dob,
              students.phone,
              students.address,
              students.admission_date,
              students.student_status,
              
              users.Email,
              classes.class_name
          FROM students
          join users
          on students.user_id = users.Id
          join classes
          on students.class_id = classes.class_id
          where users.Id = $user_id";
$student_result = mysqli_query($conn, $student_sql);
if(!$student_result){
    echo"Query failed.".mysqli_error($conn);
}
$row = mysqli_fetch_assoc($student_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">
        <!-- CSS link  -->
         <link href="includes/profile.css" rel="stylesheet">
</head>

<body>

   <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid profile-container">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

           <main class="col-md-9 col-lg-10 offset-md-3 offset-lg-2 mt-5">
                <br><br><br>
                <h2 class="mb-4 profile-title">My Profile</h2>

                <div class="row g-4">

                    <!-- Teacher Information -->
                    <div class="col-md-4">
                        <!-- Added h-100 to make the card take full column height -->
                        <div class="card profile-card h-100">
                            <div class="card-body">
                                <h4 class="profile-card-title">
                                    Personal Information
                                    </h4>
                                    <p class="profile-info">
                                        <strong>Student Name: </strong>
                                    <?php echo $row['full_name']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Father Name: </strong>
                                    <?php echo $row['father_name']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Gender: </strong>
                                    <?php echo $row['gender']; ?>
                                </p>
                                 <p class="profile-info">
                                    <strong>DOB: </strong>
                                    <?php echo $row['dob']; ?>
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
                                    Academic Information
                                </h4>
                                <p class="profile-info">
                                    <strong>Roll No: </strong>
                                    <?php echo $row['roll_no']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Class: </strong>
                                    <?php echo $row['class_name']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Admission Date: </strong>
                                    <?php echo $row['admission_date']; ?>
                                </p>
                                <p class="profile-info">
                                    <strong>Status: </strong>
                                    <?php echo $row['student_status']; ?>
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
                                    Contact Information
                                </h4>
                                <p class="profile-info">
                                    <strong>Contact No: </strong>
                                    <?php echo $row['phone'];?>
                                </p>
                                
                                <p class="profile-info">
                                    <strong>Address: </strong>
                                    <?php echo $row['address']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>