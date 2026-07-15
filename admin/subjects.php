<?php
        include '../db_connect.php';
        $query = "SELECT class_id, class_name FROM classes";
        $result = mysqli_query($conn, $query);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $class_id = $_POST['class_id'];
            $Subject_name =$_POST['subject_name'];
            $Subject_code =$_POST['subject_code'];

            if(!empty($class_id) && !empty($Subject_name)&& !empty($Subject_code)){
                $Class_query = "INSERT INTO subjects (subject_name, subject_code, class_id) 
                VALUES('$Subject_name','$Subject_code','$class_id')";
                $Class_result = mysqli_query($conn,$Class_query);
                if($Class_result){
                    header("Location: subjects.php?success=1");
                    exit();
                    
                }
                else {
            echo mysqli_error($conn);
        }
            }
           
           

        }

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
                <?php if(isset($_GET['success'])){
                        echo'<div class="alert alert-success">Recode Inserted Successfully</div>'; 
                    } ?>

                <div class="card-header bg-primary text-white">
                   
                    
                    <h4 class="mb-0">Add Subject</h4>
                </div>

                <div class="card-body">

                    <form action="" method="POST">
                        

                        <div class="mb-3">
                            <label class="form-label">Class</label>
                        <select name="class_id" class="form-select">
                            
                                <option value="">Select Class</option>
                                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                                <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name'];?></option>
                                <?php } ?>
                               
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="subject_name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Code</label>
                            <input type="text" name="subject_code" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Add Subject
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