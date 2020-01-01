<?php

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

$query = new MySQLDA();

$resultAbility = $query->select($intern_ability_dictionary, "*", "");

if (isset($_POST["apply_new_request"])) 
{
    session_start();

    $organization_id = $_SESSION["id"];
    $subject = $_POST["subject"];
    $short_description = $_POST["description"];
    $amount = $_POST["amount"];
    $date_submitted = date("Y-m-d");
    $status = $_POST["status"];

    $data = [
        "organization_id" => $organization_id,
        "subject" => $subject,
        "short_description" => $short_description,
        "amount" => $amount,
        "date_submitted" => $date_submitted,
        "status" => $status
    ];
    
    if ($query->insert($intern_organization_requests, $data) === TRUE) 
    {
        if (isset($_POST["nameAbility"]))
        {
            $nameAbilities = $_POST["nameAbility"];
            $reqAbilities = $_POST["reqAbility"];
            $noteAbilities = $_POST["noteAbility"];

            $requestId = $query->lastId();

            foreach ($nameAbilities as $key => $value) {
                $abilityData = [
                    "organization_request_id" => $requestId,
                    "ability_id" => $nameAbilities[$key],
                    "ability_required" => $reqAbilities[$key],
                    "note" => $noteAbilities[$key]
                ];

                $query->insert($intern_organization_request_abilities, $abilityData);
            }
        }
        header("Location: /organization_screen.php");
    } 
    else 
    {
        echo "Creation failed!";
    }
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
    <title>Organization New Request</title>
</head>

<body>
    <form class="w3-left" action="organization_screen.php">
        <button class="w3-button w3-border w3-hover-blue">Back to organization screen</button>
    </form>
    <div class="w3-margin-top w3-display-topmiddle w3-half">
        <form class="w3-container w3-card-4" method="post" action="">
            <h2 class="w3-text-blue">Create New Request</h2>
            <p>
                <label class="w3-text-blue"><b>Title</b></label>
                <input class="w3-input w3-border" required name="subject" type="text"></p>
            <p>
                <label class="w3-text-blue"><b>Description</b></label>
                <input class="w3-input w3-border" required name="description" type="text"></p>

            <p>
                <label class="w3-text-blue"><b>Amount</b></label>
                <input class="w3-input w3-border" required name="amount" type="text"></p>
            <p>
                <label class="w3-text-blue"><b>Ability</b></label>
            <?php 
            if ($resultAbility->num_rows > 0)
            {
                while ($row = $resultAbility->fetch_assoc())
                {
                    echo '<div class="w3-row">
                        <div class="w3-col w3-third" style="padding: 8px 0;">
                            <input id="name_ability_'.$row["id"].'" class="w3-margin-left"  type="checkbox" name="nameAbility[]" onclick="clearForm(this);" value="'.$row["id"].'"> '.$row["ability_name"].'<br>
                        </div>
                        <div class="w3-col w3-third w3-center">
                            <input id="req_ability_'.$row["id"].'" disabled class="w3-input w3-border" name="reqAbility[]" type="number" min="0" placeholder="'.$row["ability_note"].'">
                        </div>
                        <div class="w3-col w3-third w3-center">
                            <input id="note_ability_'.$row["id"].'" disabled class="w3-input w3-border" name="noteAbility[]" type="text" placeholder="Additional note">
                        </div>
                    </div>';
                }
            }
            
            ?>
            </p>

            <p>
                <label class="w3-text-blue"><b>Status</b></label>
                <select class="w3-select" name="status">
                    <option value="1000">Undone</option>
                    <option value="2000">Waiting for approve</option>
                    <option value="4000">Stop register</option>
                </select></p>
        
                <p>
                    <input class="w3-btn w3-blue" type="submit" name="apply_new_request" value="Apply"></p>
        </form>
    </div>
    

    <script src="script/jquery.min.js"></script>
    <script>
        function clearForm(check)
        {
            abilityValue = $(check).attr("id").substr(13);
            if (check.checked == true)
            {

                $("#req_ability_" + abilityValue).removeAttr("disabled");
                $("#note_ability_" + abilityValue).removeAttr("disabled");

            }
            else 
            {
                $("#req_ability_" + abilityValue).attr("disabled", true);
                $("#note_ability_" + abilityValue).attr("disabled", true);

                $("#req_ability_" + abilityValue).val("");
                $("#note_ability_" + abilityValue).val("");
            }
        }
    </script>
</body>

</html>

