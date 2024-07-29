<?php
include("navbar.php");

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // For simplicity, assume the payment is processed and successful
    // Implement your payment processing logic here

    // Clear the cart after successful payment
    $user_id = $_SESSION['user_id'];
    $sqlDeleteCart = "DELETE FROM cart WHERE user_id = ?";
    $stmtDeleteCart = $conn->prepare($sqlDeleteCart);
    $stmtDeleteCart->bind_param("i", $user_id);
    $stmtDeleteCart->execute();

    header("Location: confirmation.php"); // Redirect to a confirmation page or similar
    exit();
}

// Fetch cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT items.name, items.price, cart.quantity 
        FROM cart 
        JOIN items ON cart.item_id = items.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate total
$total = 0;
$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - EPIC STORE.</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container mt-5">
    <h2>Payment</h2>
    <form action="payment.php" method="POST">
        <h4>Cart Summary</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>Rs <?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>Rs <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="input-group mb-3">
        <input type="text" class="form-control" value="Total Amount" aria-label="Total Amount" readonly>
                <span class="input-group-text">Rs</span>
                <span class="input-group-text" ><?php echo number_format($total, 2); ?></span>
        </div>
        <button type="submit" class="btn btn-primary">Confirm Payment</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
