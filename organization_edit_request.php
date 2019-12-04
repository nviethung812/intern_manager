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


if (isset($_POST["apply_edit_request"])) {
    session_start();

    $query = new MySQLDA();

    $date_submitted = date("Y-m-d");

    $data = [
        "subject" => $subject,
        "short_description" => $description,
        "amount" => $amount,
        "date_submitted" => $date_submitted,
        "status" => $status
    ];
    
    if ($query->update($intern_organization_requests, $data, "id = ".$requestId) === TRUE) {
        header("Location: " . $hostname . "organization_screen.php");
    } else {
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

<body class="w3-margin-top w3-display-topmiddle w3-half">
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
            <label class="w3-text-blue"><b>Status</b></label>
            <select class="w3-select" name="status">
                <option value="1000" <?php if ($status == 1000) echo "selected";?>>Undone</option>
                <option value="2000" <?php if ($status == 2000) echo "selected";?>>Waiting for approve</option>
                <option value="4000" <?php if ($status == 4000) echo "selected";?>>Stop register</option>
            </select>
            <p>
                <input class="w3-btn w3-blue" type="submit" name="apply_edit_request" value="Apply"></p>
    </form>
</body>

</html>

