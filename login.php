<?php
        session_start();
        include 'db_connect.php';
        //checking login info is submit
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // getting form data and removing extra spaces
            $email = trim($_POST['email']); 
            $pswd = trim($_POST['pswd']); 
        // checking that field are filled
        if(empty($email) || empty($pswd)){
            echo "Please fill all fields";
            exit();
        }
        $sql = "SELECT * FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $sql);
        // checking email id exits in database or not
        if(mysqli_num_rows($result)==0){
            echo "user does not exist";
            exit();
        }
        
            $row = mysqli_fetch_assoc($result);
        
        
        // password verifcation
        if(password_verify($pswd, $row['Password'])){
            
        // storing user info by using session
        
        $_SESSION['email'] = $row['Email'];
        $_SESSION['role'] = $row['Role'];
        if($row['Role']== "admin"){
            header("Location: admin/Admin_dashboard.php");
        exit();
        }
         if($row['Role']== "teacher"){
            header("Location: admin/Teacher_dashboard.php");
        exit();
        }
         if($row['Role']== "student"){
            header("Location: admin/Student_dashboard.php");
        exit();
        }
            
        }
        else{
    echo "Incorrect Password";
    exit();
}
 }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    
    include 'navbar.php'
    ?>
 <h1 class="text-center mt-5 fs-1">School Management System</h1>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">Login</h2>

                <form action="" method="post">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email ID</label>
                        <input type="email" class="form-control" required id="email" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="pswd" class="form-label">Password</label>
                        <input type="password" required class="form-control" id="pswd" name="pswd">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>