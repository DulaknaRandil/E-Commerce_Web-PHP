<?php

include("conn.php");

// Handle updating item quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
        // Update item quantity in cart
        $sqlUpdate = "UPDATE cart SET quantity = ? WHERE user_id = ? AND item_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("iii", $quantity, $user_id, $item_id);
        $stmtUpdate->execute();
    } else {
        // Remove item from cart if quantity is 0
        $sqlDelete = "DELETE FROM cart WHERE user_id = ? AND item_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("ii", $user_id, $item_id);
        $stmtDelete->execute();
    }

    header("Location: cart.php");
    exit();
}
?>
