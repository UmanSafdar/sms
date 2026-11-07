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
            <h5>Total Fees</h5>
            <h3>0</h3>
        </div>
    </div>
</div>
    <div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5>Paid Fees</h5>
            <h3>0</h3>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h5>Pending Fees</h5>
            <h3>0</h3>
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
                    <tr>
                        <td>1</td>
                        <td>January</td>
                        <td>12500</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Feburary</td>
                        <td>2500</td>
                        <td>Paid</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>March</td>
                        <td>1500</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>April</td>
                        <td>3500</td>
                        <td>Paid</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        
        </main>
    </div>
    </div>
    
</body>
</html>