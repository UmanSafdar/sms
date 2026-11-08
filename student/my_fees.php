<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: ../login.php");
    exit();
}
include'../db_connect.php';
if(!$conn){
    die("Failed: ".mysqli_error($conn));
}
$user_id = $_SESSION['user_id']; 
$query = "SELECT student_id FROM students WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
if(!$result){
    die("Failed: ".mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$student_id = $row['student_id'];

$student_sql = "SELECT * FROM fees Where student_id = $student_id";
$student_result = mysqli_query($conn, $student_sql);
if(!$student_result){
    die("Failed: ".mysqli_error($conn));
}
$total_amount_sql = "SELECT SUM(amount) as total_fee
                     FROM fees WHERE student_id = $student_id";
$total_fees_result = mysqli_query($conn, $total_amount_sql);
if(!$total_fees_result){
    die("Failed: ".mysqli_error($conn));
}
$x = mysqli_fetch_assoc($total_fees_result);
$total_fees = $x['total_fee'];

$paid_amount_sql = "SELECT SUM(amount) as paid_fee
                     FROM fees WHERE student_id = $student_id
                     AND status = 'Paid'";
$paid_fees_result = mysqli_query($conn, $paid_amount_sql);
if(!$paid_fees_result){
    die("Failed: ".mysqli_error($conn));
}
$y = mysqli_fetch_assoc($paid_fees_result);
$paid_fees = $y['paid_fee'];

$pending_amount_sql = "SELECT SUM(amount) as pending_fee
                     FROM fees WHERE student_id = $student_id
                     AND status = 'Unpaid'";
$pending_fees_result = mysqli_query($conn, $pending_amount_sql);
if(!$pending_fees_result){
    die("Failed: ".mysqli_error($conn));
}
$z = mysqli_fetch_assoc($pending_fees_result);
$pending_fees = $z['pending_fee'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php';
    include 'includes/sidebar.php';?>
    <div class="container">
    <div class="row">
       
        <main class="col-md-9 col-lg-10 offset-md-3 offset-lg-2 p-5 min-vh-100 mt-5">
        <h3 class="rounded bg-dark text-center text-white mt-5">My Fees Status</h3>
        <div class="row">
            <div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center hover">
            <h5><strong>Total Fees</strong></h5>
            <h6><?php echo $total_fees;?></h6>
        </div>
    </div>
</div>
    <div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5><strong>Paid Fees</strong></h5>
            <h6><?php echo $paid_fees;?></h6>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5><strong>Pending Fees</strong></h5>
            <h6><?php if($pending_fees > 0)
                {
                    echo $pending_fees;
                }
                else{
                    echo"No pending Fees";
                }
                ?></h6>
        </div>
    </div>
</div>
        </div>
           
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="rounded bg-dark text-center text-white">All Fees Records</h4>
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Status</th>                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $counter =1;
                        if(mysqli_num_rows($student_result) >0){
                        while($r = mysqli_fetch_assoc($student_result)){?>
                    <tr>
                        <td><?php echo $counter;?></td>
                        <td><?php echo $r['fee_month'];?></td>
                        <td><?php echo $r['amount'];?></td>
                        <td><?php echo $r['status'];?></td>
                    </tr>
                    <?php
                    $counter++;
                        }}
                        else{
                        echo"<tr <td>colspan='4' class=' text-center'>No student record found!</td></tr>";
                           
                            }?>
                </tbody>
            </table>
        </div>
    </div>
        
        </main>
    </div>
    </div>
    
</body>
</html>