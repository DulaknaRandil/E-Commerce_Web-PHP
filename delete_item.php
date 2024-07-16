<?php
include("conn.php");

// Check if item ID is provided and is valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $itemId = $_GET['id'];

    // Perform deletion
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("i", $itemId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Deletion successful
        $toastMessage = "Item deleted successfully.";
        $toastType = "success";
    } else {
        // No rows affected, deletion failed
        $toastMessage = "Failed to delete item. Please try again.";
        $toastType = "error";
    }

    // Close statement
    $stmt->close();

} else {
    // Redirect if item ID is not provided
    header("Location: dashboard.php");
    exit();
}

// Redirect back to dashboard with toast message
header("Location: dashboard.php?toastMessage=" . urlencode($toastMessage) . "&toastType=" . urlencode($toastType));
exit();
?>
