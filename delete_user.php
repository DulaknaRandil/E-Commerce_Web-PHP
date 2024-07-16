<?php
include("conn.php");

// Check if user ID is provided via GET parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the user ID
    $user_id = intval($_GET['id']);

    // Delete user from database
    $sql = "DELETE FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Deletion successful
        $toastMessage = "User deleted successfully.";
        $toastType = "success";
    } else {
        // No user deleted
        $toastMessage = "Failed to delete user. Please try again.";
        $toastType = "error";
    }

    // Close statement
    $stmt->close();
} else {
    // No user ID provided
    $toastMessage = "User ID not provided.";
    $toastType = "error";
}

// Redirect to dashboard with toast message
header("Location: dashboard.php?toastMessage=" . urlencode($toastMessage) . "&toastType=" . urlencode($toastType));
exit();

?>
