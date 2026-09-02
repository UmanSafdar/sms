<?php
include '../db_connect.php';
$student_query = "SELECT student_id, full_name FROM students";
$student_result = mysqli_query($conn, $student_query);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $student_id= $_POST['student_id'];
    $fee_amount = trim($_POST['fee_amount']);
    $status = trim($_POST['status']);
    $fee_month = trim($_POST['fee_month']);

    $fee_query= "INSERT INTO fees (student_id, fee_month, amount,status)
    VALUES('$student_id', '$fee_month', '$fee_amount','$status')";
    $fee_result = mysqli_query($conn, $fee_query);
    if($fee_result){
        echo "Success";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    <?php
include 'includes/navbar.php';
?>

<div class="container-fluid">
    <div class="row">

        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-9 col-lg-10">

            <div class="card-header bg-primary text-white">
    <h2 class="mb-0">Add Fee</h2>
</div>

            <div class="card">

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Student</label>

                            <select name="student_id" class="form-select">
                                <option value="">Select Student</option>
                                <?php while($student = mysqli_fetch_assoc($student_result)) {?>
                                <option value="<?php echo $student['student_id']?>">
                                    <?php echo $student['full_name'];?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Fee Month</label>

                            <select name="fee_month" class="form-select">
                                <option value="">Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Fee Amount</label>

                            <input type="number"
                                   name="fee_amount"
                                   class="form-control"
                                   placeholder="Enter fee amount">
                        </div>
                                        <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="Unpaid">Unpaid</option>
                        <option value="Paid">Paid</option>

                    </select>
                </div>


                        <button type="submit" class="btn btn-primary">
                            Save Fee
                        </button>

                        <a href="fees.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>