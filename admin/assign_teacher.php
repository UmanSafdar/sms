<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

include '../db_connect.php';


// ===========================
// ASSIGN TEACHER TO CLASS
// ===========================

if(isset($_POST['assign_teacher'])){

    $teacher_id = $_POST['teacher_id'];
    $class_id = $_POST['class_id'];


    // CHECK IF ALREADY ASSIGNED

    $check_sql = "SELECT *
                  FROM teacher_classes
                  WHERE teacher_id = '$teacher_id'
                  AND class_id = '$class_id'";

    $check_result = mysqli_query($conn, $check_sql);


    if(mysqli_num_rows($check_result) > 0){

        header("Location: assign_teacher.php?exists=1");
        exit();

    }


    // INSERT TEACHER-CLASS ASSIGNMENT

    $insert_sql = "INSERT INTO teacher_classes
                   (teacher_id, class_id)
                   VALUES
                   ('$teacher_id', '$class_id')";

    $insert_result = mysqli_query($conn, $insert_sql);


    if($insert_result){

        header("Location: assign_teacher.php?success=1");
        exit();

    }else{

        echo "Error: " . mysqli_error($conn);

    }

}


// ===========================
// FETCH ACTIVE TEACHERS
// ===========================

$teacher_sql = "SELECT teacher_id, full_name
                FROM teachers
                WHERE status = 'active'
                ORDER BY full_name";

$teacher_result = mysqli_query($conn, $teacher_sql);


// ===========================
// FETCH ACTIVE CLASSES
// ===========================

$class_sql = "SELECT class_id, class_name
              FROM classes
              WHERE status = 'active'
              ORDER BY class_name";

$class_result = mysqli_query($conn, $class_sql);


// ===========================
// FETCH ASSIGNED TEACHERS
// ===========================

$assigned_sql = "SELECT teacher_classes.id,
                        teachers.full_name,
                        classes.class_name
                 FROM teacher_classes
                 INNER JOIN teachers
                 ON teacher_classes.teacher_id = teachers.teacher_id
                 INNER JOIN classes
                 ON teacher_classes.class_id = classes.class_id
                 ORDER BY teachers.full_name, classes.class_name";

$assigned_result = mysqli_query($conn, $assigned_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Assign Teacher</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/my_sms/admin/includes/navbar.css">

    <link rel="stylesheet" href="/my_sms/admin/includes/sidebar.css">

</head>

<body>

<?php include 'includes/navbar.php'; ?>


<div class="container-fluid">

    <div class="row">

        <?php include 'includes/sidebar.php'; ?>


        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5 mt-5">


            <!-- SUCCESS MESSAGE -->

            <?php if(isset($_GET['success'])) { ?>

                <div class="alert alert-success">
                    Teacher assigned to class successfully.
                </div>

            <?php } ?>


            <!-- DUPLICATE MESSAGE -->

            <?php if(isset($_GET['exists'])) { ?>

                <div class="alert alert-warning">
                    This teacher is already assigned to this class.
                </div>

            <?php } ?>


            <!-- PAGE HEADING -->

            <h2 class="mb-4">
                Assign Teacher to Class
            </h2>


            <!-- ASSIGN TEACHER FORM -->

            <div class="card shadow-sm">

                <div class="card-body">

                    <form method="POST">


                        <!-- TEACHER -->

                        <div class="mb-3">

                            <label class="form-label">
                                Select Teacher
                            </label>

                            <select
                                name="teacher_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Select Teacher --
                                </option>


                                <?php while($teacher = mysqli_fetch_assoc($teacher_result)) { ?>

                                    <option value="<?php echo $teacher['teacher_id']; ?>">

                                        <?php echo $teacher['full_name']; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- CLASS -->

                        <div class="mb-3">

                            <label class="form-label">
                                Select Class
                            </label>

                            <select
                                name="class_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Select Class --
                                </option>


                                <?php while($class = mysqli_fetch_assoc($class_result)) { ?>

                                    <option value="<?php echo $class['class_id']; ?>">

                                        <?php echo $class['class_name']; ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <!-- BUTTON -->

                        <button
                            type="submit"
                            name="assign_teacher"
                            class="btn btn-primary"
                        >

                            Assign Teacher

                        </button>


                    </form>

                </div>

            </div>


            <!-- ASSIGNED TEACHERS -->

            <div class="card shadow-sm mt-4">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">
                        Assigned Teachers
                    </h5>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped text-center mb-0">

                            <thead class="table-dark">

                                <tr>

                                    <th>ID</th>

                                    <th>Teacher</th>

                                    <th>Class</th>

                                </tr>

                            </thead>


                            <tbody>


                                <?php if(mysqli_num_rows($assigned_result) > 0) { ?>


                                    <?php while($assigned = mysqli_fetch_assoc($assigned_result)) { ?>

                                        <tr>

                                            <td>
                                                <?php echo $assigned['id']; ?>
                                            </td>


                                            <td>
                                                <?php echo $assigned['full_name']; ?>
                                            </td>


                                            <td>
                                                <?php echo $assigned['class_name']; ?>
                                            </td>

                                        </tr>

                                    <?php } ?>


                                <?php } else { ?>

                                    <tr>

                                        <td colspan="3">

                                            No teacher has been assigned to a class yet.

                                        </td>

                                    </tr>

                                <?php } ?>


                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


        </main>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    setTimeout(function(){

        let alerts = document.querySelectorAll('.alert');

        alerts.forEach(function(alert){

            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";

            setTimeout(function(){
                alert.remove();
            }, 500);

        });

    }, 2000);

</script>

</body>

</html>