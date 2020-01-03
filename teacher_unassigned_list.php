<?php

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$query = new MySQLDA;
$requestId = $_POST["request_id"];

$students = $query->select($intern_students, "*", "");


$registered = $query->select($intern_student_register, "*", "organization_request_id = " . $requestId);

if (isset($_POST["apply_assign"]))
{
    $studentId = $_POST["student_id"];
    $submitDate = date("Y/m/d");
    $data = [
        "organization_request_id" => $requestId,
        "student_id" => $studentId,
        "create_date" => $submitDate,
        "end_date" => $submitDate,
        "start_date" => $submitDate,
        "status" => 1
    ];
    $query->insert($intern_organization_request_assignment, $data);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-colors-2019.css">
    <link rel="stylesheet" href="css/w3-colors-2018.css">
    <title>Teacher Assignment</title>
</head>
<body class="">
    <form class="w3-left" action="teacher_assign.php" method="POST">
        <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
        <button class="w3-margin-right w3-button w3-border w3-hover-blue">Back To Assign</button>
    </form>
    <div class="w3-container w3-display-topmiddle w3-margin-top w3-half">
        <h2 class="w3-center">
            Unassigned List
        </h2>
        <br>
        <ul class="w3-ul w3-card-4">
            <?php
            $count = 0;
            while ($row = $students->fetch_assoc())
            {
                $studentId = $row["id"];
                $checkAssign = $query->select($intern_organization_request_assignment, "*", "student_id = " . $studentId . " AND organization_request_id = " . $requestId);

                if ($checkAssign->num_rows > 0)
                {
                    
                }
                else
                {   
                    $count ++;
                    $name = $row["last_name"] . " " . $row["sur_name"] . " " . $row["first_name"];
                    echo
                    '<li class="w3-bar">
                        <form class="w3-right" action="" method="POST">
                            <input type="hidden" name="student_id" value="' . $studentId . '">
                            <input type="hidden" name="request_id" value="' . $requestId . '">
                            <input class="w3-margin-right w3-button w3-border w3-hover-blue" type="submit" name="apply_assign" value="Assign"></input>
                        </form>
                        <form class="w3-right" action="teacher_view_student.php" method="POST">
                            <input type="hidden" name="student_id" value="' . $studentId . '">
                            <input type="hidden" name="request_id" value="' . $requestId . '">
                            <input type="hidden" name="type" value="3">
                            <input class="w3-margin-right w3-button w3-border w3-hover-blue" type="submit" value="Detail"></input>
                        </form>
                        <img src="img/ava.png" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
                        <div class="w3-bar-item">
                            <span class="w3-large">' . $name . '</span><br>
                            <span>' . $row["student_code"] . '</span>
                        </div>
                    </li>';
                }
            }
            if ($count == 0)
            {
                echo "<br><h5 class='w3-center'>Unassigned list is empty.</h5><br>";
            }
            ?>

            
        </ul>
    </div>
</body>
</html>