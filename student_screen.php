<?php 

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();
$student_id = $_SESSION["id"];
$query = new MySQLDA();
$request = $query->select($intern_organization_requests, "*", "status = 3000");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-colors-2019.css">
    <link rel="stylesheet" href="css/w3-colors-2018.css">
    <title>Student Screen</title>
</head>
<body>
    <form class="w3-right" action="login.php">
        <button class="w3-button w3-border w3-hover-red">Logout</button>
    </form>
    <br>
    <br>
    <br>
    <?php
        if ($request->num_rows > 0) 
        {
            $requests = '<table class="w3-table-all w3-hoverable">';
            $requests .= '<thead>
                            <tr class="w3-light-grey">
                                <th>Title</th>
                                <th>Description</th>
                                <th>Organization</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>';

            while ($row = $request->fetch_assoc()) 
            {
                $organization_id = $row["organization_id"];
                $subject = $row["subject"];
                $description = $row["short_description"];
                $amount = $row["amount"];
                $requestId = $row["id"];
                $statusValue = $row["status"];

                switch ($row["status"]) {
                    case 3000:
                        $status = "Waiting for registered";
                        break;
                    case 4000:
                        $status = "Stop register";
                        break;
                }

                $result = $query->select($intern_organization_profile, "*", "id = " . $organization_id);
                $organization = $result->fetch_assoc();

                $requests .= '<tr>
                                <td>' . $subject . '</td>
                                <td>' . $description . '</td>
                                <td>' . $organization["organization_name"] . '</td>
                                <td>' . $amount . '</td>
                                <td>' . $status . '</td>
                                <td>
                                    <form method="post" action="student_request_detail.php">
                                        <input type="hidden" name="request_id" value="'.$requestId.'">
                                        <button class="w3-button w3-white w3-border w3-border-blue w3-left w3-margin-right">Detail</button>
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