<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher' ){
    header("Location: ../login.php");
    exit();
}

include '../../db_connect.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT users.email, users.role, teachers.full_name
          FROM users
          join teachers
          on teachers.user_id = users.id
          where teachers.user_id = $user_id";
$query_result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($query_result);

$message = '';
if(isset($_POST['change_password'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    $password_sql = "SELECT password from users where Id = $user_id";
    $result = mysqli_query($conn, $password_sql);
    $user= mysqli_fetch_assoc($result);
    if(!$user || !password_verify($current_password, $user['password'] )){
        $message="current password is incorrect";
    }
    else{
        if($new_password != $confirm_password){
            $message = "password does not match";
        }
        else{
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_password_sql = "UPDATE users
                                    set password = '$hashed_password'
                                    where Id = $user_id";
            $update_password_result = mysqli_query($conn, $update_password_sql);
            if($update_password_result){
                $message ="password updated successfully";
            }
            else{
                $message = "failed to update password";
            }
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
</head>
<body>

<?php include '../includes/navbar.php';?>
<div class="container-fluid">
    <div class="row">
<?php include '../includes/sidebar.php';?>
 
<main class="col-md-9 ms-sm-auto col-lg-10 offset-md-3 offset-lg-2 mt-5 pt-4 mb-5">
    <br>
    <h2 class="mb-4 text-center">Settings</h2>
   <div class="row g-4">
    <div class="card profile-card">
        <div class="card-header">
            <?php if(!empty($message)){?>
            <div class="alert alert-info alert-dismissible fade show" role="alert"> <?php echo htmlspecialchars($message);?>
                <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
            </div>
            <?php 
            }?>
          <h2 class="mb-4 bg-dark text-white p-2 rounded text-center">Account Information</h2>  
    </div>
    <div class="card-body">
        <p class="profile-info mb-4">
             <strong>Full Name:</strong>
             <?php echo htmlspecialchars($row['full_name']);?> </p>
        <p class="mb-4">
             <strong>Email Address:  </strong>
             <?php echo htmlspecialchars($row['email']);?> </p>
        <p class="mb-4">
            <strong>Role:   </strong> 
            <?php echo htmlspecialchars($row['role']);?> </p>

    </div>
</div>
<div class="card card-profile mt-4">
    <div class="card-header">
        <h2 class="bg-dark text-center rounded text-white p-2 mb-0 ">Change Password</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Current Password</label>
                <input type="password"
                name="current_password"
                class="form-control"
                required>
            </div>
              <div class="mb-4">
                <label class="form-label">New Password</label>
                <input type="password"
                name="new_password"
                class="form-control"
                required>
            </div>
              <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password"
                name="confirm_password"
                class="form-control"
                required>
            </div>
            <button class="btn btn-dark"
            type="submit"
            name="change_password">Update Password</button>
        </form>

    </div>


</div>
</main>
   </div>
</div>
</body>
</html>