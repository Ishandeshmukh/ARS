<?php

// Connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo "Failed to connect DB" . $conn->connect_error;
}

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $rollno = $_POST['rollno'];
    $division = $_POST['division'];
    $password = $_POST['password'];

    // Duplicate checking for users table within the selected division
    $check = "SELECT * FROM users WHERE (email='$email' OR rollno='$rollno') AND division='$division'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Email Address or Roll no already exists in this division!');setTimeout(function(){window.location.href='register.html'},1000);</script>";
    } else {
        // Insertion of values into rows
        $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, rollno, division, password) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $rollno, $division, $password);

        if ($stmt->execute()) {
            // Insert roll no into appropriate division table
            $divisionTable = "division" . strtolower($division);
            $stmt2 = $conn->prepare("INSERT INTO $divisionTable(rollno) VALUES (?)");
            $stmt2->bind_param("s", $rollno);

            if (!$stmt2->execute()) {
                echo "Error executing statement: ";
            }
        } else {
            echo "Error executing statement: ";
        }

        // Move the redirection statement outside of the if block
        header("location: login.html");
    }
}

?>
