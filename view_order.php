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

// Fetch order details
$sqlOrderDetails = "SELECT orders.id AS order_id, orders.order_date, orders.total_amount, user.Username AS customer_name
                    FROM orders 
                    JOIN user ON orders.user_id = user.UserID
                    WHERE orders.id = ?";
$stmtOrderDetails = $conn->prepare($sqlOrderDetails);
$stmtOrderDetails->bind_param("i", $order_id);
$stmtOrderDetails->execute();
$resultOrderDetails = $stmtOrderDetails->get_result();

if ($resultOrderDetails->num_rows == 0) {
    header("Location: dashboard.php?toastMessage=Order not found&toastType=error");
    exit();
}

$orderDetails = $resultOrderDetails->fetch_assoc();

// Fetch order items
$sqlOrderItems = "SELECT order_items.*, items.name 
                  FROM order_items 
                  JOIN items ON order_items.item_id = items.id 
                  WHERE order_items.order_id = ?";
$stmtOrderItems = $conn->prepare($sqlOrderItems);
$stmtOrderItems->bind_param("i", $order_id);
$stmtOrderItems->execute();
$resultOrderItems = $stmtOrderItems->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Order Details</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Order ID: <?php echo htmlspecialchars($orderDetails['order_id']); ?></h5>
                <p class="card-text"><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDetails['order_date']); ?></p>
                <p class="card-text"><strong>Customer Name:</strong> <?php echo htmlspecialchars($orderDetails['customer_name']); ?></p>
                <p class="card-text"><strong>Total Amount:</strong> Rs <?php echo htmlspecialchars($orderDetails['total_amount']); ?></p>
                <hr>
                <h5 class="card-title">Items in Order</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $resultOrderItems->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td>Rs <?php echo htmlspecialchars($row['price']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
