<?php
        include '../db_connect.php';
        /* ===========================
   UPDATE SUBJECT
=========================== */

if (isset($_POST['update_subject'])) {

    $class_id = $_POST['class_id'];
    $subject_id = $_POST['subject_id'];
    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);

    if (empty($class_id) ||empty($subject_name) || empty($subject_code)) {

        echo "<div class='alert alert-danger'>Please fill all fields.</div>";

    } else {

        $update_subject = "UPDATE subjects
                         SET class_id = '$class_id',
                            subject_name='$subject_name',
                             subject_code='$subject_code'
                         WHERE subject_id='$subject_id'";

        $subject_result = mysqli_query($conn, $update_subject);

        if ($subject_result) {
            header("Location: subjects.php?updated=1");
            exit();
        } else {
            echo mysqli_error($conn);
        }
    }
}
/*============ EDIT RECORD ==============
==============              =============*/
        $edit_data = [];

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $qry = "SELECT * FROM subjects WHERE subject_id='$id'";
    $res = mysqli_query($conn, $qry);
    $edit_data = mysqli_fetch_assoc($res);
}
        $query = "SELECT class_id, class_name FROM classes";
        $result = mysqli_query($conn, $query);
        
            /* ===========================
   ADD CLASS
=========================== */
if (isset($_POST['add_subject'])) {
    $class_id = trim($_POST['class_id']);
    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);

    if (empty($class_id) || empty($subject_name)||empty($subject_code)) {

        echo "<div class='alert alert-danger'>Please fill all fields.</div>";

    } else {

        $q = "INSERT INTO subjects(subject_name,subject_code, class_id)
              VALUES('$subject_name','$subject_code', $class_id)";

        $r = mysqli_query($conn, $q);

        if ($r) {
            header("Location: subjects.php?success=1");
            exit();
        } else {
            echo mysqli_error($conn);
        }
    }
}
         /*==================
         =========== DELETE =========*/   
            if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = "DELETE FROM subjects WHERE subject_id ='$delete_id'";
    $delete_result = mysqli_query($conn, $delete_query);
    if($delete_result){
        
        header("Location: subjects.php?deleted=1");
        exit();
    } 
}
/*============DISPLAY =============
        ===================================*/
        
        
         $display_data = "SELECT subjects.subject_id,
                                    subjects.subject_name,
                                    subjects.subject_code,
                                    classes.class_name
                                    FROM subjects JOIN classes
                                    ON subjects.class_id = classes.class_id";
            $display_result= mysqli_query($conn, $display_data);
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>

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

            <!-- Add Subject Card -->
            <div class="card shadow mb-4">
                <?php if(isset($_GET['updated'])){
                        echo'<div class="alert alert-success">Recode updated Successfully</div>'; 
                    } ?>
                <?php if(isset($_GET['success'])){
                        echo'<div class="alert alert-success">Recode Inserted Successfully</div>'; 
                    } ?>
                    <?php if(isset($_GET['deleted'])){
                        echo'<div class="alert alert-success">Recode Deleted Successfully</div>'; 
                    } ?>

                <div class="card-header bg-primary text-white">
                   
                    
                    <h4>
<?php echo isset($_GET['edit']) ? "Update Subject" : "Add Subject"; ?>
</h4>
                </div>

                <div class="card-body">

                    <form action="" method="POST">
                        

                        <div class="mb-3">
                            <label class="form-label">Class</label>
                            <input
                                    type="hidden"
                                    name="subject_id"
                                    value="<?php echo $edit_data['subject_id'] ??''; ?>"
                                    >
                        <select name="class_id" class="form-select">
                            
                                <option value="">Select Class</option>
                                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                                <option value="<?php echo $row['class_id']; ?>"
                                <?php if (($edit_data['class_id'] ?? '') == $row['class_id']) echo 'selected'; ?>>

            <?php echo $row['class_name']; ?>
                            </option>
                                <?php } ?>
                               
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="subject_name" class="form-control" value ="<?php echo $edit_data['subject_name']?? '';?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Code</label>
                            <input type="text" name="subject_code" class="form-control" value="<?php echo $edit_data['subject_code']?? '';?>">
                        </div>

                        <button type="submit" class="btn btn-primary"
                            name="<?php echo isset($_GET['edit']) ? 'update_subject' : 'add_subject'; ?>">

<?php echo isset($_GET['edit']) ? 'Update Subject' : 'Add Subject'; ?>
                        </button>

                    </form>

                </div>
            </div>

            <!-- Subject Management Card -->
            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Subject Management</h4>
                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-hover align-middle">
                           
            
                            <thead class="table-dark">
                                <tr>
                                    <th>Subject Id</th>
                                    <th>Subject Name</th>
                                    <th>Subject Code</th>
                                    <th>Class</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                             <?php 
                             while($row = mysqli_fetch_assoc($display_result)){
                ?>
                                <!-- Example Row -->
                                <tr>
                                    <td><?php echo $row['subject_id'];?></td>
                                    <td><?php echo $row['subject_name'];?></td>
                                    <td><?php echo $row['subject_code'];?></td>
                                    <td><?php echo $row['class_name'];?></td>
                                    <td>

<a
href="subjects.php?edit=<?php echo $row['subject_id']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="subjects.php?delete=<?php echo $row['subject_id']; ?>"
class="btn btn-danger btn-sm"
onclick= "return confirm('Are Your Sure to Delete ?');">
Delete
</a>

</td>
                                </tr>
                                <?php } ?>
                                <!-- Data will come from database -->

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>