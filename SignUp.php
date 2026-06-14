<?php
       // backend logic goes here
        
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

        <form action="" method="post">

            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname">
            </div>

            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname">
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