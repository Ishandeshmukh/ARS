<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host="localhost";
$user="root";
$pass="";
$db="login";

$conn = new Mysqli($host,$user,$pass,$db);

if($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if(isset($_POST['Login'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM teachers WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        if($row['password'] == $password) {
            // Redirect to the appropriate HTML file based on the teacher's division
            switch ($row['division']) {
                case 'A':
                    header("location: division A.html");
                    break;
                case 'B':
                    header("location: division B.html");
                    break;
                case 'C':
                    header("location: division C.html");
                    break;
                default:
                    echo "Invalid division";
            }
        } else {
            echo "Incorrect Email or Password";
        }
    } else {
        echo "Incorrect Email or Password";
}
}

if(isset($_POST['register'])) {
    $email=$_POST['email'];
    $password=$_POST['password'];
    $division=$_POST['division'];

    $stmt = $conn->prepare("INSERT INTO teachers (email, password, division) VALUES (?,?,?)");
    $stmt->bind_param("sss", $email, $password, $division);
    $stmt->execute();
}

?>