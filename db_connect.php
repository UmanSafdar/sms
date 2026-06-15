<?php
$ServerName = "localhost";
$user = "root";
$password = "";
$db = "smsdb";

$conn = mysqli_connect($ServerName,$user,$password,$db);
if(!$conn){
    die("connection: fail".mysqli_connect_error());
}
else{
    // echo "connected";
}
?>