<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

$requestId = $_POST["requestId"];
$studentId = $_POST["studentId"];
$submitDate = date("Y/m/d");

$query = new MySQLDA();

$data = [
    "organization_request_id" => $requestId,
    "student_id" => $studentId,
    "submit_date" => $submitDate,
];

if ($query->insert($intern_student_register, $data) == TRUE)
{
    echo "<script>alert('Register Success! Back to student screen ...'); 
                window.location.href='/student_screen.php'</script>";
}
else
{
    echo "<script>alert('Register Fail! Back to student screen ...'); 
                window.location.href='/student_screen.php'</script>";
}


?>