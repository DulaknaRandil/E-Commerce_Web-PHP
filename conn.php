<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "e-comdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isLoggedIn = false;
$userData = [];

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $isLoggedIn = true;
    $userId = $_SESSION['user_id'];
    $sql = "SELECT Username FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    
    // Check if the statement was prepared correctly
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the query was executed correctly
    if ($result === false) {
        die("Error executing the statement: " . $stmt->error);
    }

    // Fetch user data if the query was successful
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Save Username in the session data
        $_SESSION['username'] = $userData['Username'];
    } else {
        $isLoggedIn = false; // No user found with the given ID, treat as not logged in
    }

    $stmt->close();
}


?>
