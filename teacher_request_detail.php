<?php

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();

$teacher_id = $_SESSION["id"];
$query = new MySQLDA();

$requestId = $_POST["request_id"];

$result = $query->select($intern_organization_requests, "*", "id = " . $requestId);
$request = $result->fetch_assoc();

switch ($request["status"]) {
    case 1000:
        $status = "Undone";
        break;
    case 2000:
        $status = "Waiting for approved";
        $waitingApproved = TRUE;
        break;
    case 3000:
        $status = "Waiting for registered";
        break;
    case 4000:
        $status = "Stop register";
        break;
    case 5000:
        $status = "Rejected";
        break;
}

$result = $query->select($intern_organization_profile, "*", "id = " . $request["organization_id"]);
$organization = $result->fetch_assoc();

$reqAbilities = $query->select($intern_organization_request_abilities, "*", "organization_request_id = " . $requestId);

$register = $query->select($intern_student_register, "*", "organization_request_id = " . $requestId);
if ($register->num_rows > 0)
{
    $registered = $register->num_rows;
}
else
{
    $registered = 0;
}

if (isset($_POST["request_reject"]))
{

    $requestId = $_POST["request_id"];

    $data = [
        "status" => 5000
    ];
    $condition = "id = " . $requestId;
    $query->update($intern_organization_requests, $data, $condition);
    header("Location: /teacher_screen.php");
}

if (isset($_POST["request_approve"]))
{

    $requestId = $_POST["request_id"];

    $data = [
        "status" => 3000
    ];
    $condition = "id = " . $requestId;
    $query->update($intern_organization_requests, $data, $condition);
    header("Location: /teacher_screen.php");
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
    <form class="w3-left" action="teacher_screen.php">
        <button class="w3-button w3-border w3-hover-blue">Back to Teacher screen</button>
    </form>

    <div class="w3-display-middle w3-half">
        <div class="w3-padding w3-card-4 w3-light-grey" style="width:100%">
            <div class="">
                <h3 class="w3-center"><?php echo $request["subject"];?></h3>
                <h5><?php echo "<b>Request Description:</b> " . $request["short_description"]; ?></h5>
                <h5><?php echo "<b>Organization:</b> " . $organization["organization_name"];?></h5>
                <h5><?php echo "<b>Amount:</b> " . $request["amount"]; ?></h5>
                <h5><?php echo "<b>Registered Student:</b> " . $registered; ?></h5>
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
            <?php
                if ($waitingApproved)
                {
                    echo '
                        <form method="post" action="">
                            <input type="hidden" name="request_id" value="'.$requestId.'">
                            <button name="request_approve" class="w3-button w3-white w3-border w3-border-blue w3-left w3-margin-right">Approve</button>
                            <button name="request_reject" class="w3-button w3-red w3-border w3-border-red">Reject</button>
                        </form>
                    ';
                }
            ?>
            <br>
        </div>

    </div>
</body>
</html>