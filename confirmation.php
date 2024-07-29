<?php
include("navbar.php");

// Fetch cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT items.id, items.name, items.price, cart.quantity 
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
    <title>Payment - EPIC STORE</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .payment-form {
            max-width: 600px;
            margin: auto;
        }
        .payment-form .form-group {
            margin-bottom: 20px;
        }
        .form-control[readonly] {
            background-color: #f1f1f1;
        }
        .btn-confirm {
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-confirm:hover {
            background-color: #218838;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5 payment-form">
    <h2>Payment</h2>
    <form action="order_confirmation.php" method="POST" id="payment-form">
        <h4 class="mb-3">Cart Summary</h4>
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
        <div class="input-group mb-4">
            <input type="text" class="form-control" value="Total Amount" aria-label="Total Amount" readonly>
            <span class="input-group-text">Rs</span>
            <span class="input-group-text"><?php echo number_format($total, 2); ?></span>
        </div>
        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
        
        <!-- Payment Gateway Integration UI -->
        <div class="form-group">
            <label for="card-element">Credit or Debit Card</label>
            <div id="card-element">
                <!-- Placeholder for the payment gateway UI -->
                <p>Payment Gateway Integration Placeholder</p>
            </div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit" class="btn-confirm btn-lg mt-3">Confirm Payment</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Stripe JS (optional, replace with your payment gateway integration) -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Placeholder for payment gateway integration script
</script>
</body>
</html>
