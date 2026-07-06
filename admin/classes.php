<?php
include '../db_connect.php';

/* ===========================
   UPDATE CLASS
=========================== */
if (isset($_POST['update_class'])) {

    $class_id = $_POST['class_id'];
    $class_name = trim($_POST['class_name']);
    $class_description = trim($_POST['description']);

    if (empty($class_name) || empty($class_description)) {

        echo "<div class='alert alert-danger'>Please fill all fields.</div>";

    } else {

        $update_query = "UPDATE classes
                         SET class_name='$class_name',
                             description='$class_description'
                         WHERE class_id='$class_id'";

        $result = mysqli_query($conn, $update_query);

        if ($result) {
            header("Location: classes.php?updated=1");
            exit();
        } else {
            echo mysqli_error($conn);
        }
    }
}


/* ===========================
   LOAD DATA FOR EDIT
=========================== */
$edit_data = [];

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $qry = "SELECT * FROM classes WHERE class_id='$id'";
    $res = mysqli_query($conn, $qry);

    $edit_data = mysqli_fetch_assoc($res);
}


/* ===========================
   ADD CLASS
=========================== */
if (isset($_POST['add_class'])) {

    $class_name = trim($_POST['class_name']);
    $description = trim($_POST['description']);

    if (empty($class_name) || empty($description)) {

        echo "<div class='alert alert-danger'>Please fill all fields.</div>";

    } else {

        $q = "INSERT INTO classes(class_name,description)
              VALUES('$class_name','$description')";

        $r = mysqli_query($conn, $q);

        if ($r) {
            header("Location: classes.php?success=1");
            exit();
        } else {
            echo mysqli_error($conn);
        }
    }
}

        /* ===========================
        DELETE CLASS
        =========================== */
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM classes WHERE class_id ='$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    if($delete_result){
        
        header("Location: classes.php?deleted=1");
        exit();
    } 
}

/* ===========================
   DISPLAY ALL CLASSES
=========================== */

$query = "SELECT * FROM classes";
$result = mysqli_query($conn, $query);

if (!$result) {
    die(mysqli_error($conn));
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

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">

<div class="row">

<?php include 'includes/sidebar.php'; ?>

<div class="col-md-9 col-lg-10 p-4">

<?php

if(isset($_GET['success'])){
    echo "<div class='alert alert-success'>Class Added Successfully.</div>";
}

if(isset($_GET['updated'])){
    echo "<div class='alert alert-success'>Class Updated Successfully.</div>";
}
 if(isset($_GET['deleted'])){
        echo "<div class='alert alert-success'>Class Deleted Successfully.</div>";
    }

?>

<h2>Classes Management</h2>

<p class="text-muted">
Add and manage all classes in the system.
</p>

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">
<?php echo isset($_GET['edit']) ? "Update Class" : "Add New Class"; ?>
</h5>
</div>

<div class="card-body">

<form method="POST">

<input
type="hidden"
name="class_id"
value="<?php echo $edit_data['class_id'] ?? ''; ?>">

<div class="mb-3">

<label class="form-label">
Class Name
</label>

<input
type="text"
name="class_name"
class="form-control"
placeholder="Enter Class Name"
required
value="<?php echo $edit_data['class_name'] ?? ''; ?>">

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="4"
placeholder="Enter Description"
required><?php echo $edit_data['description'] ?? ''; ?></textarea>

</div>

<button
type="submit"
class="btn btn-primary"
name="<?php echo isset($_GET['edit']) ? 'update_class' : 'add_class'; ?>">

<?php echo isset($_GET['edit']) ? 'Update Class' : 'Add Class'; ?>

</button>

</form>

<hr>

<div class="card-header bg-primary text-white">
<h5 class="text-center">
Classes
</h5>
</div>

<table class="table table-bordered table-striped text-center mt-3">

<thead>

<tr>

<th>ID</th>
<th>Class</th>
<th>Description</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['class_id']; ?></td>

<td><?php echo $row['class_name']; ?></td>

<td><?php echo $row['description']; ?></td>

<td>

<a
href="classes.php?edit=<?php echo $row['class_id']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="classes.php?delete=<?php echo $row['class_id']; ?>"
class="btn btn-danger btn-sm"
onclick= "return confirm('Are Your Sure to Delete ?');">
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