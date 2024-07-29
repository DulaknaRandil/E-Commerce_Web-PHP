<?php

include("conn.php"); // Make sure to include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_id"])) {
    $item_id = $_POST["item_id"];

    // Check if the cart session variable exists
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Add the item to the cart
    if (!in_array($item_id, $_SESSION["cart"])) {
        $_SESSION["cart"][] = $item_id;
    }

    // Redirect back to the previous page
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
}
?>
