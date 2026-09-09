<?php
include '../db_connect.php';


$query = "SELECT 
            fees.fee_id,
            students.full_name,
            classes.class_name,
            fees.fee_month,
            fees.amount,
            fees.payment_date,
            fees.status
          
          FROM fees

          JOIN students 
          ON fees.student_id = students.student_id

          JOIN classes 
          ON students.class_id = classes.class_id";

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Fees</title>
</head>
<body>
      <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

            <?php include 'includes/sidebar.php'; ?>

            <div class="col-md-9 col-lg-10">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h2>Fee Management</h2>

                    <a href="add_fee.php" class="btn btn-primary">
                        Add Fee
                    </a>

                </div>

                <div class="card shadow-sm">

                    <div class="card-header">
                        <h5 class="mb-0">Fee Records</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>S.No</th>
                                    <th>Student</th>
                                    <th>Class</th>
                                    <th>Month</th>
                                    <th>Fee Amount</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                                <tr>
                                    <td><?php echo $row['fee_id'];?></td>
                                    <td><?php echo $row['full_name'];?></td>
                                    <td><?php echo $row['class_name'];?></td>
                                    <td><?php echo $row['fee_month'];?></td>
                                    <td><?php echo $row['amount'];?></td>
                                    <td><?php echo $row['payment_date'];?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Unpaid') { ?>

                                <span class="badge bg-danger">Unpaid</span>

                                <a href="update_fee_status.php?id=<?php echo $row['fee_id']; ?>"
                                class="btn btn-sm btn-success">
                                    Mark Paid
                                </a>

                            <?php } else { ?>

                                <span class="badge bg-success">Paid</span> </td>

                            <?php } ?>
                            <td>
                                <a href="edit_fee.php?edit=<?php echo $row['fee_id'];?>"
                            class="btn btn-danger btn-sm"
                            >Edit</td>
                            
                            <?php } } ?>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>