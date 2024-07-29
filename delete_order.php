<?php
// Include database connection file
include("conn.php");

// Start session


// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header("Location: dashboard.php?toastMessage=Order ID is required&toastType=error");
    exit();
}

$order_id = $_GET['id'];

// Delete order items first
$sqlDeleteOrderItems = "DELETE FROM order_items WHERE order_id = ?";
$stmtDeleteOrderItems = $conn->prepare($sqlDeleteOrderItems);
$stmtDeleteOrderItems->bind_param("i", $order_id);
$stmtDeleteOrderItems->execute();

// Delete order
$sqlDeleteOrder = "DELETE FROM orders WHERE id = ?";
$stmtDeleteOrder = $conn->prepare($sqlDeleteOrder);
$stmtDeleteOrder->bind_param("i", $order_id);
$stmtDeleteOrder->execute();

// Redirect back to dashboard with success message
header("Location: dashboard.php?toastMessage=Order deleted successfully&toastType=success");
exit();
?>
