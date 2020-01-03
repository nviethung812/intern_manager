<?php

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();
$requestId = $_POST["request_id"];
$teacher_id = $_SESSION["id"];
$query = new MySQLDA();

$studentId = $_POST["student_id"];
$type = $_POST["type"];
$result = $query->select($intern_students, "*", "id = " . $studentId);
$student = $result->fetch_assoc();

$studentAbilities = $query->select($intern_students_ability, "*", "student_id = " . $studentId);
$studentName = $student["last_name"] . " " . $student["sur_name"] . " " . $student["first_name"];

if ($type == 1)
{
    $action = "teacher_assign.php";
}
else if ($type == 2)
{
    $action = "teacher_registered_list.php";
}
else
{
    $action = "teacher_unassigned_list.php";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-colors-2019.css">
    <link rel="stylesheet" href="css/w3-colors-2018.css">
    <title>Request Detail</title>
</head>
<body>
    <form class="w3-left" action="<?php echo $action;?>" method="POST">
        <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
        <button class="w3-button w3-border w3-hover-blue">Back to Assign</button>
    </form>

    <div class="w3-display-middle w3-half">
        <div class="w3-padding w3-card-4 w3-light-grey" style="width:100%">
            <div class="">
                <h3 class="w3-center"><?php echo $studentName;?></h3>
                <h5><?php echo "<b>Date of Birth:</b> " . $student["date_of_birth"]; ?></h5>
                <h5><?php echo "<b>Join Date:</b> " . $student["join_date"];?></h5>
                <h5><?php echo "<b>Class:</b> " . $student["class_name"]; ?></h5>
            </div>

            <h4><b>Ability</b></h5>
            <table class="w3-table-all w3-hoverable">
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                </tr>
                <?php
                    if ($studentAbilities->num_rows > 0)
                    {
                        while ($ability = $studentAbilities->fetch_assoc())
                        {
                            $result = $query->select($intern_ability_dictionary, "*", "id = " . $ability["ability_id"]);
                            $abilityInfo = $result->fetch_assoc();
                            echo '
                                <tr>
                                    <td>' . $abilityInfo["ability_name"] . '</td>
                                    <td>' . $ability["ability_rate"] . '</td>
                                </tr>
                            ';
                        }
                    }
                    else
                    {
                        echo '
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            ';
                    }
                
                ?>
            </table>
            <br>
            <br>
        </div>

    </div>
</body>
</html>