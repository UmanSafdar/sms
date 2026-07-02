<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $class_name = trim($_POST['class_name']);
    $description = trim($_POST['description']);

    $q = "INSERT INTO classes (class_name, description)
          VALUES ('$class_name', '$description')";

    $r = mysqli_query($conn, $q);

   if ($r) {
    header("Location: classes.php?success=1");
    exit();
} else {
        echo "<div class='alert alert-danger text-center'>Something went wrong!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Classes Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include 'includes/navbar.php';
if (isset($_GET['success'])) {
    echo "<div class='alert alert-success'>Class Added Successfully!</div>";
}
?>


<div class="container-fluid">

    <div class="row">

        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-1">Classes Management</h2>
            <p class="text-muted mb-4">
                Add and manage all classes in the system.
            </p>

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add New Class</h5>
                </div>

                <div class="card-body">

                    <form action="" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Class Name</label>

                            <input
                                type="text"
                                name="class_name"
                                class="form-control"
                                placeholder="Enter Class Name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="4"
                                placeholder="Enter Description"
                                required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Add Class
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
        </div> <!-- End Content Column -->

    </div> <!-- End Row -->

</div> <!-- End Container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>