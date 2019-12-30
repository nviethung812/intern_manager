<?php
include_once './DataAccess/ConnectDB.php';
include_once './Business/verify.php';

$organization_code = $_POST['organization_code'];

$result = verify(3, $organization_code); // function in verify.php, check that for detail

if ($result->num_rows == 0) 
{
    // Send user to login page if no code found
    header("Location: /login.php");
    exit();
} 
else 
{
    $row = $result->fetch_assoc();

    session_start();

    // Store user data to current session if login success
    $_SESSION["id"] = $row["id"];
    $_SESSION["code"] = $row["tax_number"];
    $_SESSION["name"] = $row["organization_name"];
    $_SESSION["type"] = 3;

    header("Location: /organization_screen.php");
    exit();
}
