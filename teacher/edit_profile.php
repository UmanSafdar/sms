<?php
include '../db_connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM teachers WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

//===========Update=============//
if($_SERVER['REQUEST_METHOD']== "POST"){
$full_name = $_POST['full_name'];
$qualification = $_POST['qualification'];
$specialization = $_POST['specialization'];
$phone = $_POST['phone'];
$salary = $_POST['salary'];
$joining_date = $_POST['joining_date'];

$update_profile = "UPDATE teachers SET 
                    full_name = '$full_name',
                    qualification = '$qualification',
                    specialization = '$specialization',
                    phone = '$phone',
                    salary = '$salary',
                    joining_date ='$joining_date'
                WHERE user_id = $user_id";
    $update_result = mysqli_query($conn,$update_profile);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Edit Profile</title>
</head>
<body>
     <?php include 'includes/navbar.php';?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php';?>
            
             <main class="col-md-9 col-lg-10 ms-auto p-4 pt-5 mt-5">
                 <?php
     if(isset($update_profile)){
        ?> <div class="alert alert-success"><?php echo "Profile Updated Successfully"?></div>
        <?php
     }?>
                <h2 class="text-center mb-4 bg-primary text-white">Edit Teacher Profile</h2>
    <form method="POST">
       
       
        <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="full_name"
        value="<?php echo $teacher['full_name'];?>"
        class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Qualification</label>
        <input type="text" name="qualification"
        value="<?php echo $teacher['qualification'];?>"
        class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization"
        value="<?php echo $teacher['specialization'];?>"
        class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone"
        value="<?php echo $teacher['phone'];?>"
        class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label">Salary</label>
        <input type="text" name="salary"
        value="<?php echo $teacher['salary'];?>"
        class="form-control">
        <div class="mb-3">
        <label class="form-label">Joining Date</label>
        <input type="text" name="joining_date"
        value="<?php echo $teacher['joining_date'];?>"
        class="form-control">
        </div>
        </div>
        <button type="submit" name="update_profile" class="btn btn-primary">
        Update Profile
    </button>
    </form>
</div>
</div>

</main>


</body>
</html>