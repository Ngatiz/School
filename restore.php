<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "School";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['deleted_user'])) {
    $deletedUser = $_SESSION['deleted_user'];
    $name = $deletedUser['name'];
    $email = $deletedUser['email'];

    // Insert the deleted user back into the database
    $sql = "INSERT INTO users (name, email, created_at) VALUES ('$name', '$email', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        // Successfully restored
        unset($_SESSION['deleted_user']); // Clear the session variable
        header('Location: Users?restored=true'); // Redirect after restoring
        exit;
    } else {
        echo "Error restoring user: " . $conn->error;
    }
} else {
    header('Location: Users'); // Redirect back if no user to restore
    exit;
}
?>
