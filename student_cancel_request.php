<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

$query = new MySQLDA();

$requestId = $_POST["requestId"];
$studentId = $_POST["studentId"];

$condition = "organization_request_id = " . $requestId . " AND student_id = " . $studentId;

if ($query->delete($intern_student_register, $condition) == TRUE)
{
    echo "<script>alert('Cancel request success! Back to student screen ...'); 
                window.location.href='./student_screen.php'</script>";
}
?>