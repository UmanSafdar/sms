<?php
    //    $_SESSION_start();
    include 'db_connect.php';
       if($_SERVER["REQUEST_METHOD"]== "POST"){
        
        $email = $_POST['email'];
        $password = $_POST['pswd'];
        $cpassword = $_POST['cpswd'];
        $role = $_POST['role'];
        if($password != $cpassword){
            echo "password does not match";
        }
        if(empty($email)|| empty($password)|| empty($cpassword) || empty($role)){
            echo "all field are required";
        }
        else{
        
        $hpassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "SELECT * FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $query);
        
    if (mysqli_num_rows($result)>0) {
        echo"Email already Registered";
    }
    else{
        $insert_query="INSERT INTO users (Email, Password, Role) values('$email', '$hpassword', '$role')";
        mysqli_query($conn, $insert_query);
    
    if(mysqli_query($conn, $insert_query)){
        echo "Account Created Sussfully";
        header("location: login.php");
        exit();
    }
    else{
        echo "Error:".mysqli_error($conn);
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <?php
    include 'navbar.php'
    ?>
   <div class="register">

    <div class="card shadow p-4">

        <h2 class="text-center mb-4">Register</h2>

        <form action="register.php" method="post">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="pswd" class="form-label">Password</label>
                <input type="password" class="form-control" id="pswd" name="pswd">
            </div>

            <div class="mb-3">
                <label for="cpswd" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpswd" name="cpswd">
            </div>

            <div class="mb-4">
                <label for="role" class="form-label">Role</label>

                <select class="form-select" id="role" name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-success">
                    Create Account
                </button>
            </div>

        </form>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>