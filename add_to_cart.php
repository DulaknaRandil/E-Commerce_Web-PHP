<?php
// Start the session

// Include database connection
include("conn.php");

// Check if the item ID is provided in the query string
if (isset($_GET['id'])) {
    $itemId = intval($_GET['id']); // Ensure the item ID is an integer

    // Initialize the cart in the session if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the item is already in the cart
    if (array_key_exists($itemId, $_SESSION['cart'])) {
        // If the item is already in the cart, increment its quantity
        $_SESSION['cart'][$itemId]++;
    } else {
        // Otherwise, add the item to the cart with quantity 1
        $_SESSION['cart'][$itemId] = 1;
    }

    // Redirect back to the referring page
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirectUrl");
    exit();
} else {
    // If no item ID is provided, redirect to the homepage
    header("Location: index.php");
    exit();
}
?>
