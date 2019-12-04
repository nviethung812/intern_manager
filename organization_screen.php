<?php

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();

$organization_id = $_SESSION["id"];

$query = new MySQLDA();

$result = $query->select($intern_organization_requests, "*", "organization_id='" . $organization_id . "'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-colors-2019.css">
    <link rel="stylesheet" href="css/w3-colors-2018.css">
    <title>Organization Screen</title>
</head>

<body>
    <form class="" action="organization_new_request.php">
        <button>Create new request</button>
    </form>


    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $organization_id = $row["organization_id"];
            $subject = $row["subject"];
            $description = $row["short_description"];
            $amount = $row["amount"];
            $requestId = $row["id"];
            $statusValue = $row["status"];


            switch ($row["status"]) {
                case 1000:
                    $status = "Undone";
                    break;
                case 2000:
                    $status = "Waiting for approved";
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

            $str = '<form method="post" action="organization_edit_request.php"><div class="w3-card-4 " style="width:30%;">
                        <input type="hidden" name="request_id" value="'.$requestId.'">
                        <input type="hidden" name="subject" value="'.$subject.'">
                        <input type="hidden" name="description" value="'.$description.'">
                        <input type="hidden" name="amount" value="'.$amount.'">
                        <input type="hidden" name="status" value="'.$statusValue.'">
            
                        <header class="w3-container w3-blue">
                            <h2>' . $subject . '</h2>
                        </header>
                    
                        <div class="w3-container">
                            <p>Description: ' . $description . '<p>
                            <p>Amount: ' . $amount . '</p>
                        </div>
                    
                        <footer class="w3-container w3-blue">
                            <h5>Status: ' . $status . '</h5>
                            <button>Edit</button>
                        </footer>
                    </div></form><br>';

            echo $str;
        }
    }
    ?>

</body>

</html>