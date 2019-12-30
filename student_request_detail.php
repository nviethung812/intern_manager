<?php

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();

$student_id = $_SESSION["id"];
$query = new MySQLDA();

$requestId = $_POST["request_id"];

$result = $query->select($intern_organization_requests, "*", "id = " . $requestId);
$request = $result->fetch_assoc();

switch ($request["status"]) {
    case 3000:
        $status = "Waiting for registered";
        break;
    case 4000:
        $status = "Stop register";
        break;
}

$result = $query->select($intern_organization_profile, "*", "id = " . $request["organization_id"]);
$organization = $result->fetch_assoc();

$reqAbilities = $query->select($intern_organization_request_abilities, "*", "organization_request_id = " . $requestId);

$register = $query->select($intern_organization_request_assignment, "*", "organization_request_id = " . $requestId . " AND student_id = " . $student_id);
if ($register->num_rows > 0)
{
    $registered = TRUE;
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
    <form class="w3-left" action="student_screen.php">
        <button class="w3-button w3-border w3-hover-blue">Back to Student screen</button>
    </form>
    <?php if ($registered) echo 
    '<form class="w3-right" action="student_cancel_request.php" method="POST">
        <input type="hidden" name="requestId" value="' . $requestId . '">
        <input type="hidden" name="studentId" value="' . $student_id . '">
        <button class="w3-button w3-red">Cancel request</button>
    </form>';?>

    <div class="w3-display-middle w3-half">
        <div class="w3-padding w3-card-4 w3-light-grey" style="width:100%">
            <div class="">
                <h3 class="w3-center"><?php echo $request["subject"];?></h3>
                <h5><?php echo "<b>Request Description:</b> " . $request["short_description"]; ?></h5>
                <h5><?php echo "<b>Organization:</b> " . $organization["organization_name"];?></h5>
                <h5><?php echo "<b>Amount:</b> " . $request["amount"]; ?></h5>
                <h5><?php echo "<b>Status:</b> " . $status; ?></h5>

            </div>

            <h4><b>Required Ability</b></h5>
            <table class="w3-table-all w3-hoverable">
                <tr>
                    <th>Name</th>
                    <th>Required</th>
                    <th>Note</th>
                </tr>
                <?php
                    if ($reqAbilities->num_rows > 0)
                    {
                        while ($ability = $reqAbilities->fetch_assoc())
                        {
                            $result = $query->select($intern_ability_dictionary, "*", "id = " . $ability["ability_id"]);
                            $abilityInfo = $result->fetch_assoc();
                            echo '
                                <tr>
                                    <td>' . $abilityInfo["ability_name"] . '</td>
                                    <td>' . $ability["ability_required"] . '</td>
                                    <td>' . $ability["note"] . '</td>
                                </tr>
                            ';
                        }
                    }
                
                ?>
            </table>
            <br>
            <div class="w3-section w3-center">
                <button class="w3-button w3-blue" onclick="document.getElementById('id01').style.display='block'" <?php if ($registered) echo "disabled";?>><?php if ($registered) echo "Already registered"; else echo "Register";?></button>
            </div>
            <br>
        </div>

    </div>
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

        <div class="w3-center"><br>
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        </div>

            <?php include "student_register.php"?>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
        </div>

        </div>
    </div>
</body>
</html>