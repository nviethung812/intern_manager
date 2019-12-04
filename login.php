<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-colors-2019.css">
    <link rel="stylesheet" href="css/w3-colors-2018.css">
    <title>Login</title>
</head>
<body class="w3-display-middle w3-half">
    <div class="w3-bar w3-black">
        <button id="tabStudent" class="w3-bar-item w3-button tablink w3-2018-nebulas-blue" onclick="openTab(event,'student')">Student</button>
        <button id="tabTeacher" class="w3-bar-item w3-button tablink" onclick="openTab(event,'teacher')">Teacher</button>
        <button id="tabOrganization" class="w3-bar-item w3-button tablink" onclick="openTab(event,'organization')">Organization</button>
    </div>

    <div id="student" class="user w3-border w3-animate-left"><?php include 'student_login.php';?></div>
    <div id="teacher" class="user w3-border w3-animate-left" style="display:none"><?php include 'teacher_login.php';?></div>
    <div id="organization" class="user w3-border w3-animate-left" style="display:none"><?php include 'organization_login.php';?></div>

    <script src="script/tab.js"></script>
</body>
</html>