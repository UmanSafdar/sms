<?php

include '../../db_connect.php';

if(isset($_POST['update_setting'])){
    $School_Name = $_POST['school_name'];
    $Address = $_POST['address'];
    $Phone = $_POST['phone'];
    $Email = $_POST['email'];
    $Admin_Name = $_POST['admin_name'];
$update_query = "UPDATE settings SET
            school_name = '$School_Name',
            address = '$Address',
            phone = '$Phone',
            email = '$Email',
            admin_name = '$Admin_Name'
        WHERE setting_id = 1";
mysqli_query($conn, $update_query);
}

//==========GET SETTING===============//
$query = "SELECT * FROM settings WHERE setting_id = 1";
$result = mysqli_query($conn, $query);
$setting = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Settings</title>
</head>
<body>
    <div class="container-fluid">
    <?php include '../includes/navbar.php'; ?>
        <div class="row">
         <?php include '../includes/sidebar.php'?>
         <!-- //============MAIN CONTENT ============// -->
     <div class="col-md-9 col-lg-10 p-4">
        <h2 class="mb-4 bg-primary text-white text-center mx-auto">Settings</h2>
        <div class="card-shadow sm">
            <div class="card-header">
                <h5 class="mb-0">School Information</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <!-- SCHOOL NAME  -->
                     <div class="mb-3">
                     <label class="form-label"> School Name </label>
                     <input type="text"
                     name="school_name"
                     class="form-control"
                     value="<?php echo htmlspecialchars($setting['school_name']);?>">
                     </div>
                     <!-- ADDRESS  -->
                     <div class="mb-3">
                     <label class="form-label"> Address </label>
                     <input type="text"
                     name="address"
                     class="form-control"
                     value="<?php echo htmlspecialchars($setting['address']);?>">
                     </div>
                     <!-- PHONE  -->
                     <div class="mb-3">
                     <label class="form-label"> Phone </label>
                     <input type="text"
                     name="phone"
                     class="form-control"
                     value="<?php echo htmlspecialchars($setting['phone']);?>">
                     </div>
                     <!-- EMAIL  -->
                     <div class="mb-3">
                     <label class="form-label"> Email </label>
                     <input type="text"
                     name="email"
                     class="form-control"
                     value="<?php echo htmlspecialchars($setting['email']);?>">
                     </div>
                     <!-- ADMIN NAME  -->
                     <div class="mb-3">
                     <label class="form-label"> Admin Name </label>
                     <input type="text"
                     name="admin_name"
                     class="form-control"
                     value="<?php echo htmlspecialchars($setting['admin_name']);?>">
                     </div>
                     <button class="btn btn-primary" type="submit" name="update_setting">Update Settings</button>
                </form>
            </div>
        </div>
     </div>
     </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>