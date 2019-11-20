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
    <form class="w3-container w3-light-grey">
        <label>Start Date:</label>
        <input class="w3-input w3-border" type="text">

        <label>End Date:</label>
        <input class="w3-input w3-border" type="text">

        <label>Change status: </label>
        <select class="w3-select" name="option">
            <option value="" disabled selected>Choose your status</option>
            <option value="0">Waiting</option>
            <option value="1">Undone</option>
            <option value="2">Public</option>
        </select>
        <br>
        <br>
        <input type="submit" name="Submit">
    </form>
</body>
</html>