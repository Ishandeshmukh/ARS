<?php
// Connect to the database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'login';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo "failed to connect DB" . $conn->connect_error;
}

// Retrives division A.php variables
require_once "division A.php";

if (isset($_POST['submit'])) {
    var_dump($_POST);
    $maths = $_POST['numberAM'];
    $physics = $_POST['numberAP'];
    $chemistry = $_POST['numberAC'];
    $biology = $_POST['numberAB'];
    $english = $_POST['numberAE'];
    $rollnos = array_unique($_POST['rollnos']);

    $stmt = $conn->prepare("UPDATE divisionb SET maths = maths +?, physics = physics +?, chemistry = chemistry +?, biology = biology +?, english = english +? WHERE rollno =?");
    
    if ($stmt) {
        
        // Loop through each roll number and update the corresponding row with subject values
        foreach ($rollnos as $rollno) {
            echo "Updating roll number: ". $rollno. "<br>";
        
            // Prepare the SQL statement to update subject values
            $stmt = $conn->prepare("UPDATE divisionb SET maths = maths +?, physics = physics +?, chemistry = chemistry +?, biology = biology +?, english = english +? WHERE rollno =?");
        
            if ($stmt) {
                // Bind parameters to the prepared statement
                $stmt->bind_param("iiiiii", $maths, $physics, $chemistry, $biology, $english, $rollno);
        
                // Execute the statement
                if ($stmt->execute()) {
                    echo "Data updated successfully for roll number: ". $rollno. "<br>";
                } else {
                    echo "Error executing query for roll number: ". $rollno. " - ". $stmt->error. "<br>";
                }
        
                // Close the statement
                $stmt->close();
            } else {
                echo "Error preparing statement: ". $conn->error;
            }
        }
        
        // Close the statement
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Form submission not detected.";
}

// Redirect back to the form page
header('Location: division C.html');