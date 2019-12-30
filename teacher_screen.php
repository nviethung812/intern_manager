<?php 

include_once "./DataAccess/MySQLDA.php";
include_once "./DataAccess/ConnectDB.php";
include_once "./Metadata/tablename.php";

session_start();
$teacher_id = $_SESSION["id"];
$query = new MySQLDA();
$result = $query->select($intern_organization_requests, "*", "status = 2000 or status = 3000 or status = 4000 or status = 5000 ORDER BY id DESC");

if (isset($_POST["request_reject"]))
{

    $requestId = $_POST["request_id"];

    $data = [
        "status" => 5000
    ];
    $condition = "id = " . $requestId;
    $query->update($intern_organization_requests, $data, $condition);
    header("Refresh:0");
}

if (isset($_POST["request_approve"]))
{

    $requestId = $_POST["request_id"];

    $data = [
        "status" => 3000
    ];
    $condition = "id = " . $requestId;
    $query->update($intern_organization_requests, $data, $condition);
    header("Refresh:0");
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
    <title>Teacher Screen</title>
</head>
<body>
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
                                <th>Organization</th>
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

                $waitingApproved = FALSE;

                switch ($row["status"]) {
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

                $detailButton = '
                    <form method="post" action="">
                        <input type="hidden" name="request_id" value="'.$requestId.'">
                        <button class="w3-button w3-white w3-border w3-border-blue w3-left w3-margin-right">Detail</button>
                    </form>
                ';

                $assignButton = '
                    <form method="post" action="">
                        <input type="hidden" name="request_id" value="'.$requestId.'">
                        <button class="w3-button w3-white w3-border w3-border-blue w3-left w3-margin-right">Assign</button>
                    </form>
                ';

                $org_result = $query->select($intern_organization_profile, "*", "id = " . $organization_id);
                $organization = $org_result->fetch_assoc();
                if ($row["status"] == 2000)
                {
                    $color = "style='color: red;'";
                }
                else if ($row["status"] == 5000)
                {
                    $color = "style='color: grey;'";
                }
                else
                {
                    $color = "style='color: black;'";
                }
                $requests .= '<tr>
                                <td ' . $color . '>' . $subject . '</td>
                                <td>' . $description . '</td>
                                <td>' . $organization["organization_name"] . '</td>
                                <td>' . $amount . '</td>
                                <td>' . $status . '</td>
                                <td>
                                    ' . $assignButton . $detailButton . '
                                </td>
                            </tr>';  
            }
            $requests .= '</table>';
            echo $requests;
        }
    ?>
</body>
</html>