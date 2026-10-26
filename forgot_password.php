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
                                id="password"
                                name="password"
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
                                id="confirm_password"
                                name="confirm_password"
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
