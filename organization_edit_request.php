<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

$requestId = $_POST["request_id"];
$subject = $_POST["subject"];
$description = $_POST["description"];
$amount = $_POST["amount"];
$status = $_POST["status"];

$query = new MySQLDA();

$resultAbility = $query->select($intern_ability_dictionary, "*", "");

$requireAbility = $query->select($intern_organization_request_abilities, "*", "organization_request_id = " . $requestId);
$abilityList = array();
while($row = $requireAbility->fetch_assoc())
{
    array_push($abilityList, [
        "ability_id" => $row["ability_id"],
        "ability_required" => $row["ability_required"],
        "note" => $row["note"]
    ]);
}

if (isset($_POST["apply_edit_request"])) 
{
    session_start();

    $query->delete($intern_organization_request_abilities, "organization_request_id = " . $requestId);
    if (isset($_POST["nameAbility"]))
    {
        $nameAbilities = $_POST["nameAbility"];
        $reqAbilities = $_POST["reqAbility"];
        $noteAbilities = $_POST["noteAbility"];

        foreach ($nameAbilities as $key => $value) 
        {
            $abilityData = [
                "organization_request_id" => $requestId,
                "ability_id" => $nameAbilities[$key],
                "ability_required" => $reqAbilities[$key],
                "note" => $noteAbilities[$key]
            ];
            $query->insert($intern_organization_request_abilities, $abilityData);
            
        }
    }

    $date_submitted = date("Y-m-d");

    $data = [
        "subject" => $subject,
        "short_description" => $description,
        "amount" => $amount,
        "date_submitted" => $date_submitted,
        "status" => $status
    ];
    
    if ($query->update($intern_organization_requests, $data, "id = ".$requestId) === TRUE) 
    {
        echo "<script>alert('Edit Success! Back to home screen ...'); 
                    window.location.href='./organization_screen.php'</script>";
    } 
    else 
    {
        echo "Edition failed!";
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
    <title>Edit Request</title>
</head>

<body>
    <form class="w3-left" action="organization_screen.php">
        <button class="w3-button w3-border w3-hover-blue">Back to home screen</button>
    </form>
    <div class="w3-margin-top w3-display-topmiddle w3-half">
        <form class="w3-container w3-card-4" method="post" action="">
            <input type="hidden" name="request_id" value="<?php echo $requestId;?>">
            <h2 class="w3-text-blue">Edit Request</h2>
            <p>
                <label class="w3-text-blue"><b>Title</b></label>
                <input class="w3-input w3-border" name="subject" type="text" value="<?php echo $subject; ?>"></p>
            <p>
                <label class="w3-text-blue"><b>Description</b></label>
                <input class="w3-input w3-border" name="description" type="text" value="<?php echo $description; ?>"></p>

            <p>
                <label class="w3-text-blue"><b>Amount</b></label>
                <input class="w3-input w3-border" name="amount" type="text" value="<?php echo $amount; ?>"></p>
            <p>
                <label class="w3-text-blue"><b>Ability</b></label>
                <?php 
                if ($resultAbility->num_rows > 0)
                {
                    while ($row = $resultAbility->fetch_assoc())
                    {   
                        $exists = FALSE;
                        foreach ($abilityList as $ability)
                        {
                            if ($row["id"] == $ability["ability_id"])
                            {
                                $exists = TRUE;
                                $data = $ability;
                                break;
                            }
                        }
                        if (!$exists)
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
                        else
                        {
                            echo '<div class="w3-row">
                                    <div class="w3-col w3-third" style="padding: 8px 0;">
                                        <input id="name_ability_'.$row["id"].'" class="w3-margin-left"  type="checkbox" name="nameAbility[]" onclick="clearForm(this);" value="'.$data["ability_id"].'" checked> '.$row["ability_name"].'<br>
                                    </div>
                                    <div class="w3-col w3-third w3-center">
                                        <input id="req_ability_'.$row["id"].'" class="w3-input w3-border" name="reqAbility[]" type="number" min="0" placeholder="'.$row["ability_note"].'" value="'.$data["ability_required"].'">
                                    </div>
                                    <div class="w3-col w3-third w3-center">
                                        <input id="note_ability_'.$row["id"].'" class="w3-input w3-border" name="noteAbility[]" type="text" placeholder="Additional note" value="'.$data["note"].'">
                                    </div>
                                </div>';
                        }
                        
                    }
                }
                
                ?>
            </p>
            <p>
                <label class="w3-text-blue"><b>Status</b></label>
                <select class="w3-select" name="status">
                    <option value="1000" <?php if ($status == 1000) echo "selected";?>>Undone</option>
                    <option value="2000" <?php if ($status == 2000) echo "selected";?>>Waiting for approve</option>
                    <option value="4000" <?php if ($status == 4000) echo "selected";?>>Stop register</option>
                </select>
            </p>
            <p>
                <input class="w3-btn w3-blue" type="submit" name="apply_edit_request" value="Apply"></p>
            
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

