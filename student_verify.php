<?php
include_once './DataAccess/ConnectDB.php';
include_once './Business/verify.php';
include_once './Metadata/hostname.php';

$student_code = $_POST['student_code'];

$result = verify(1, $student_code); // function in verify.php, check that for detail

if ($result->num_rows == 0) {
    // Send user to login page if no code found
    header("Location: " . $hostname . "login.php");
    exit();
} else {
    $row = $result->fetch_assoc();

    session_start();

    // Store user data to current session if login success
    $_SESSION["id"] = $row["id"];
    $_SESSION["code"] = $row["student_code"];
    $_SESSION["name"] = $row["first_name"];
    $_SESSION["type"] = 1;

    header("Location: " . $hostname . "student_screen.php");
    exit();
}
