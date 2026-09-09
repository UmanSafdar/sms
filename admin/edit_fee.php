<?php
include '../db_connect.php';
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $query = "SELECT * FROM fees WHERE fee_id ='$id'";
$result = mysqli_query($conn, $query);
$fee_query = mysqli_fetch_assoc($result);
if(isset($_POST['update_fee'])){
    
            $student_id= $_POST['student_id'];
            $fee_amount = trim($_POST['fee_amount']);
            $status = trim($_POST['status']);
            $fee_month = trim($_POST['fee_month']);
            //================
            //QUERY TO UPDATE STUDENT RECORD
            $update_fee = "UPDATE fees SET
              student_id = '$student_id',
            amount = '$fee_amount',
            status = '$status',
     fee_month= '$fee_month'
   WHERE fee_id='$id'";
    $result_fee = mysqli_query($conn, $update_fee);
    if($result_fee){
        echo "Record Updated Successfully";
        header("Location: fees.php?updated=1");
        exit();
    }
else{
    echo "error".mysqli_error($result_fee);
}     
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Edit Fees</title>
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
    <h2 class="mb-0">Update Fee</h2>
</div>

            <div class="card">

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Student</label>

                            <select name="student_id" class="form-select">
                                <option value="">Select Student</option>
                                <?php $student = "SELECT student_id, full_name FROM students";
                                        $q = mysqli_query($conn, $student);
                                        while($student = mysqli_fetch_assoc($q)) {?>
                                <option value="<?php echo $student['student_id']?>"
                                    <?php if($student['student_id']== $fee_query['student_id']) echo 'selected';?>>
                                    <?php echo $student['full_name'];?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Fee Month</label>

                            <select name="fee_month" class="form-select">
                                <option value="">Select Month</option>
                                <option value="January"
                                <?php if($fee_query['fee_month']=='January')echo 'selected';?>>January</option>
                                <option value="February"
                                <?php if($fee_query['fee_month']=='February')echo 'selected';?>>February</option>
                                <option value="March"
                                <?php if($fee_query['fee_month']=='March')echo 'selected';?>>March</option>
                                <option value="April"
                                <?php if($fee_query['fee_month']=='April')echo 'selected';?>>April</option>
                                <option value="May"
                                <?php if($fee_query['fee_month']=='May')echo 'selected';?>>May</option>
                                <option value="June"
                                <?php if($fee_query['fee_month']=='June')echo 'selected';?>>June</option>
                                <option value="July"
                                <?php if($fee_query['fee_month']=='July')echo 'selected';?>>July</option>
                                <option value="August"
                                <?php if($fee_query['fee_month']=='August')echo 'selected';?>>August</option>
                                <option value="September"
                                <?php if($fee_query['fee_month']=='September')echo 'selected';?>>September</option>
                                <option value="October"
                                <?php if($fee_query['fee_month']=='October')echo 'selected';?>>October</option>
                                <option value="November"
                                <?php if($fee_query['fee_month']=='November')echo 'selected';?>>November</option>
                                <option value="December"
                                <?php if($fee_query['fee_month']=='December')echo 'selected';?>>December</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Fee Amount</label>

                            <input type="number"
                                   name="fee_amount"
                                   class="form-control"
                                   value="<?php echo $fee_query['amount'];?>">
                        </div>
                                        <div class="mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="Unpaid"
                        <?php if($fee_query['status']== 'Unpaid')echo 'selected';?>>Unpaid</option>
                        <option value="Paid"
                        <?php if($fee_query['status']== 'Paid')echo 'selected';?>>Paid</option>

                    </select>
                </div>


                        <button type="submit" name="update_fee" class="btn btn-primary">
                            Update Fee
                        </button>

                        <a href="fees.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>
<?php } ?>
                </div>

            </div>

        </div>

    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>