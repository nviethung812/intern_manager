<?php

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
$studentId = $_SESSION["id"];
$query = new MySQLDA();

$resultAbility = $query->select($intern_ability_dictionary, "*", "");

$studentAbility = $query->select($intern_students_ability, "*", "student_id = " . $studentId);
$abilityList = array();
while($row = $studentAbility->fetch_assoc())
{
    array_push($abilityList, [
        "ability_id" => $row["ability_id"],
        "ability_rate" => $row["ability_rate"],
    ]);
}


if (isset($_POST["apply_edit"])) 
{
    $query->delete($intern_students_ability, "student_id = " . $studentId);
    if (isset($_POST["nameAbility"]))
    {
        $nameAbilities = $_POST["nameAbility"];
        $reqAbilities = $_POST["reqAbility"];

        foreach ($nameAbilities as $key => $value) {
            $abilityData = [
                "student_id" => $studentId,
                "ability_id" => $nameAbilities[$key],
                "ability_rate" => $reqAbilities[$key],
            ];

            if ($query->insert($intern_students_ability, $abilityData) == TRUE)
            {
                echo "<script>alert('Edit Success! Back to student screen ...'); 
                    window.location.href='./student_screen.php'</script>";
            }
            
        }
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
    <title>Edit Ability</title>
</head>

<body>
    <form class="w3-left" action="student_screen.php">
        <button class="w3-button w3-border w3-hover-blue">Back to student screen</button>
    </form>
    <div class="w3-margin-top w3-display-topmiddle w3-half">
        <form class="w3-container w3-card-4" method="post" action="">
            <h2 class="w3-text-blue">Edit your ability</h2>
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
                                <div class="w3-col w3-half" style="padding: 8px 0;">
                                    <input id="name_ability_'.$row["id"].'" class="w3-margin-left"  type="checkbox" name="nameAbility[]" onclick="clearForm(this);" value="'.$row["id"].'"> '.$row["ability_name"].'<br>
                                </div>
                                <div class="w3-col w3-half w3-center">
                                    <input id="req_ability_'.$row["id"].'" disabled class="w3-input w3-border" name="reqAbility[]" type="number" min="0" placeholder="'.$row["ability_note"].'">
                                </div>
                            </div>';
                    }
                    else
                    {
                        echo '<div class="w3-row">
                                <div class="w3-col w3-half" style="padding: 8px 0;">
                                    <input id="name_ability_'.$row["id"].'" class="w3-margin-left"  type="checkbox" name="nameAbility[]" onclick="clearForm(this);" value="'.$data["ability_id"].'" checked> '.$row["ability_name"].'<br>
                                </div>
                                <div class="w3-col w3-half w3-center">
                                    <input id="req_ability_'.$row["id"].'" class="w3-input w3-border" name="reqAbility[]" type="number" min="0" placeholder="'.$row["ability_note"].'" value="'.$data["ability_rate"].'">
                                </div>
                            </div>';
                    }
                    
                }
            }
            
            ?>
            </p>
            <p>
                <input class="w3-btn w3-blue" type="submit" name="apply_edit" value="Apply"></p>
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

            }
            else 
            {
                $("#req_ability_" + abilityValue).attr("disabled", true);
                $("#req_ability_" + abilityValue).val("");
            }
        }
    </script>
</body>

</html>
