
<?php
include 'db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $pswd = $_POST['pswd'];
    $c_pswd = $_POST['c_pswd'];

    // Step 1: Check whether all fields are filled
    if (!empty($email) && !empty($pswd) && !empty($c_pswd)) {

        // Step 2: Check whether the email exists
        $email_query = "SELECT Id FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $email_query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {

                // Step 3: Check whether passwords match
                if ($pswd == $c_pswd) {

                    // Step 4: Check password length
                    if (strlen($pswd) >= 8) {

                        // Step 5: Hash the new password
                        $hash_pswd = password_hash($pswd, PASSWORD_DEFAULT);

                        // Step 6: Update the password
                        $user_id = $row['Id'];

                        $update_sql = "UPDATE users
                                       SET Password = '$hash_pswd'
                                       WHERE Id = $user_id";

                        $update_result = mysqli_query($conn, $update_sql);

                        if ($update_result) {
                            $message = "Password updated successfully.";
                        } else {
                            $message = "Unable to update password. Please try again.";
                        }

                    } else {
                        $message = "Password must be at least 8 characters long.";
                    }

                } else {
                    $message = "Passwords do not match.";
                }

            } else {
                $message = "Email not found.";
            }

        } else {
            $message = "Database query failed.";
        }

    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <title>Reset Password - SMS</title>
</head>

<body>

    <?php include 'navbar.php'; ?>
    <?php if($message){?>
<div class="alert alert-danger"><?php echo $message;}?></div>
    <h1 class="text-center mt-5 fs-1">Reset Your Password</h1>

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow p-4">
                    

                    <h3 class="text-center mb-4">Password Reset</h3>

                    <form action="" method="post">

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email ID
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your registered email"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="pswd"
                                name="pswd"
                                minlength="8"
                                placeholder="Enter new password"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="c_pswd"
                                name="c_pswd"
                                minlength="8"
                                placeholder="Confirm new password"
                                required>
                        </div>

                        <div class="d-grid">
                            <button type="submit"
                                    name="reset_password"
                                    class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>

                    </form>

                </div>

                <div class="text-center">
                    <a href="login.php" class="btn btn-primary btn-sm mt-3">
                        Back to Login
                    </a>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
