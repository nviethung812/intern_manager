<?php
// Check whether user input match data or not
function verify($type, $code){
    $connection = MySQLConnectivity::getInstance()->getConnection();
    
    // $type = 1: student
    // $type = 2: teacher
    // $type = 3: organization
    switch ($type) {
        case 1:
            $query = "SELECT * FROM intern_students WHERE student_code = '".$code."';";
            break;
        case 2:
            $query = "SELECT * FROM intern_students WHERE student_code = '".$code."';";
            break;
        case 3:
            $query = "SELECT * FROM intern_organization_profile WHERE tax_number = '".$code."';";
            break;
    }
    $result = $connection->query($query);
    return $result;
}