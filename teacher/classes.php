<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher'){
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';

$user_id = $_SESSION['user_id'];

/* Get teacher ID */
$teacher_sql = "SELECT teacher_id FROM teachers WHERE user_id = $user_id";
$teacher_result = mysqli_query($conn, $teacher_sql);

$teacher = mysqli_fetch_assoc($teacher_result);

$teacher_id = $teacher['teacher_id'];

/* Get classes assigned to this teacher */
$class_sql = "SELECT classes.class_id,
                     classes.class_name,
                     classes.description,
                     classes.status
              FROM teacher_classes
              INNER JOIN classes
              ON teacher_classes.class_id = classes.class_id
              WHERE teacher_classes.teacher_id = $teacher_id";

$class_result = mysqli_query($conn, $class_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Classes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/my_sms/teacher/includes/navbar.css">
    <link rel="stylesheet" href="/my_sms/teacher/includes/sidebar.css">

</head>

<body>

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

    <div class="row">

        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">

            <h2 class="mb-4">My Classes</h2>

            <div class="row">

                <?php if(mysqli_num_rows($class_result) > 0) { ?>

                    <?php while($class = mysqli_fetch_assoc($class_result)) { ?>

                        <div class="col-md-4 mb-4">

                            <div class="card shadow-sm h-100">

                                <div class="card-body">

                                    <h5 class="card-title">
                                        <?php echo $class['class_name']; ?>
                                    </h5>

                                    <p class="card-text">
                                        <?php echo $class['description']; ?>
                                    </p>

                                    <span class="badge bg-success">
                                        <?php echo $class['status']; ?>
                                    </span>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <div class="alert alert-info">
                        No classes have been assigned to you yet.
                    </div>

                <?php } ?>

            </div>

        </main>

    </div>

</div>

</body>

</html>