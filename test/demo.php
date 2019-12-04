<?

$hostname = "172.19.0.2";
$username = "root";
$password = "mypass";
$database = "mysql_demo";


$connection = new mysqli($hostname, $username, $password, $database);


// $students = [
//     ["Peter", "A1"],
//     ["John", "A2"],
//     ["Mike", "A3"],

// ];

// foreach ($students as $key => $value) {
//     $sql = "INSERT INTO student (name, class) VALUES ('".$value[0]."', '".$value[1]."')";
//     $connection->query($sql);
// }


$sql = "SELECT * FROM student WHERE id = ?";

$stmt = $connection->prepare($sql);

$stmt->bind_param("i", $id);

$id = 2;

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        var_dump($row);
    }

}