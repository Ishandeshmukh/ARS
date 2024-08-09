<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "login";

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    echo("Connection failed: ". $conn->connect_error);
}

$sql = "SELECT rollno FROM divisionb";
$result = $conn->query($sql);

$response = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while ($rollno = $result->fetch_assoc()) {
        // Add all columns to the response array
        $response[] = $rollno;
    }
} else {
    // Add a message indicating no results
    $response[] = "No results";
}

// Send the response as JSON
echo json_encode($response);
?>
