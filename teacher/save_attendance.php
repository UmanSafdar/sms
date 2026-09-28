<?php
// ============ SESSION START ===========//
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

// ============= CONNECTING TO DATABASE ============//
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_attendance'])) {

    $class_id = isset($_POST['class_id']) ? (int)$_POST['class_id'] : 0;
    $subject_id = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : 0;
    $attendance_date = !empty($_POST['date'])
        ? mysqli_real_escape_string($conn, $_POST['date'])
        : date('Y-m-d');

    $attendance_data = $_POST['attendance'] ?? [];

    if ($class_id > 0 && $subject_id > 0 && !empty($attendance_data)) {
        foreach ($attendance_data as $student_id => $status) {

    $student_id = (int)$student_id;

    $status = mysqli_real_escape_string(
        $conn,
        strtolower($status)
    );

    if (in_array($status, ['present', 'absent'])) {

        $sql = "INSERT INTO attendance
                (student_id, subject_id, attendance_date, status)
                VALUES
                ($student_id, $subject_id, '$attendance_date', '$status')
                ON DUPLICATE KEY UPDATE
                status = '$status'";

        mysqli_query($conn, $sql);
    }
}