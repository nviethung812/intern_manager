<?php

include_once './DataAccess/ConnectDB.php';
include_once './DataAccess/MySQLDA.php';
include_once './Metadata/tablename.php';

if (isset($_POST["apply_new_request"])) {
    session_start();

    $query = new MySQLDA();

    $organization_id = $_SESSION["id"];
    $subject = $_POST["title"];
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
    
    if ($query->insert($intern_organization_requests, $data) === TRUE) {
        echo '<script language="javascript">';
        echo 'alert("New Request Created!")';
        echo '</script>';
    } else {
        echo $connection->error;
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
    <title>Organization Screen</title>
</head>

<body class="w3-margin-top w3-display-topmiddle w3-half">
    <form class="w3-container w3-card-4" method="post" action="">
        <h2 class="w3-text-blue">Create New Request</h2>
        <p>
            <label class="w3-text-blue"><b>Title</b></label>
            <input class="w3-input w3-border" name="title" type="text"></p>
        <p>
            <label class="w3-text-blue"><b>Description</b></label>
            <input class="w3-input w3-border" name="description" type="text"></p>

        <p>
            <label class="w3-text-blue"><b>Amount</b></label>
            <input class="w3-input w3-border" name="amount" type="text"></p>

        <p>
            <label class="w3-text-blue"><b>Status</b></label>
            <select class="w3-select" name="status">
                <option value="1000">Undone</option>
                <option value="2000">Waiting for approve</option>
                <option value="4000">Stop register</option>
            </select>
            <p>
                <input class="w3-btn w3-blue" type="submit" name="apply_new_request" value="Apply"></p>
    </form>
</body>

</html>

