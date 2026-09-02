<?php

include '../db_connect.php';

if (isset($_GET['id'])) {

    $fee_id = $_GET['id'];

    $query = "UPDATE fees
              SET status = 'Paid',
                  payment_date = CURDATE()
              WHERE fee_id = $fee_id";

    mysqli_query($conn, $query);

    header("Location: fees.php");
    exit();
}

?>