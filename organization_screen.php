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
    <form class="w3-left" action="organization_new_request.php">
        <button class="w3-button w3-border w3-hover-blue">Create new request</button>
    </form>
    <form class="w3-right" action="login.php">
        <button class="w3-button w3-border w3-hover-red">Logout</button>
    </form>
    <br>
    <br>
    <br>
    <?php
    if ($result->num_rows > 0) 
    {
        $requests = '<table class="w3-table-all w3-hoverable">';
        $requests .= '<thead>
                        <tr class="w3-light-grey">
                            <th>Title</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>';

        while ($row = $result->fetch_assoc()) 
        {
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

            $requests .= '<tr>
                            <td>' . $subject . '</td>
                            <td>' . $description . '</td>
                            <td>' . $amount . '</td>
                            <td>' . $status . '</td>
                            <td>
                                <form method="post" action="organization_edit_request.php"><div style="width:30%;">
                                    <input type="hidden" name="request_id" value="'.$requestId.'">
                                    <input type="hidden" name="subject" value="'.$subject.'">
                                    <input type="hidden" name="description" value="'.$description.'">
                                    <input type="hidden" name="amount" value="'.$amount.'">
                                    <input type="hidden" name="status" value="'.$statusValue.'">
                                    <button class="w3-button w3-white w3-border w3-border-blue">Edit</button>
                                </form>
                            </td>
                        </tr>';  
        }
        $requests .= '</table>';
        echo $requests;
    }
    ?>

</body>

</html>