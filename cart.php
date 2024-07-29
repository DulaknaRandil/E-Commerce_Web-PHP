<?php
include("navbar.php");

// Handle adding item to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];

    // Check if item is already in cart
    $sqlCheck = "SELECT * FROM cart WHERE user_id = ? AND item_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $user_id, $item_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Update quantity if item already in cart
        $sqlUpdate = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $user_id, $item_id);
        $stmtUpdate->execute();
    } else {
        // Add new item to cart
        $sqlInsert = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ii", $user_id, $item_id);
        $stmtInsert->execute();
    }

    header("Location: cart.php");
    exit();
}

// Handle removing items from cart
if (isset($_POST['remove_item_id'])) {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['remove_item_id'];

    // Remove item from cart
    $sqlDelete = "DELETE FROM cart WHERE user_id = ? AND item_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $user_id, $item_id);
    $stmtDelete->execute();

    header("Location: cart.php");
    exit();
}

// Handle updating item quantity
if (isset($_POST['quantities'])) {
    $user_id = $_SESSION['user_id'];
    foreach ($_POST['quantities'] as $item_id => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $sqlUpdate = "UPDATE cart SET quantity = ? WHERE user_id = ? AND item_id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("iii", $quantity, $user_id, $item_id);
            $stmtUpdate->execute();
        } else {
            // Remove item if quantity is 0 or less
            $sqlDelete = "DELETE FROM cart WHERE user_id = ? AND item_id = ?";
            $stmtDelete = $conn->prepare($sqlDelete);
            $stmtDelete->bind_param("ii", $user_id, $item_id);
            $stmtDelete->execute();
        }
    }
    header("Location: cart.php");
    exit();
}

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
    <title>Cart - EPIC STORE</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-controls button {
            border: none;
            background-color: #333;
            color: white;
            width: 35px;
            height: 35px;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .quantity-controls button:hover {
            background-color: #555;
        }
        .quantity-controls input {
            width: 60px;
            text-align: center;
            border: 1px solid #333;
            border-radius: 5px;
            margin: 0 5px;
            font-size: 16px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-remove {
            border: none;
            background: none;
            color: #dc3545;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .btn-remove:hover {
            color: #c82333;
        }
        .cart-total {
            font-size: 18px;
            font-weight: bold;
        }
        .btn-proceed {
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-proceed:hover {
            background-color: #218838;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Shopping Cart</h2>
    <?php if (empty($cart_items)): ?>
        <p class="text-center">Your cart is empty.</p>
    <?php else: ?>
        <form id="cart-form" action="cart.php" method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>Rs <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <div class="quantity-controls">
                                    <button type="button" onclick="changeQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                                    <input type="number" id="quantity-<?php echo $item['id']; ?>" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" readonly>
                                    <button type="button" onclick="changeQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                                </div>
                            </td>
                            <td>Rs <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <button type="button" class="btn-remove" onclick="removeItem(<?php echo $item['id']; ?>)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="input-group mb-3 cart-total">
                
            <input type="text" class="form-control" value="Total Amount" aria-label="Total Amount" readonly>
                <span class="input-group-text">Rs</span>
                <span class="input-group-text" ><?php echo number_format($total, 2); ?></span>
            </div>
            <a href="payment.php" class="btn btn-proceed">Proceed to Checkout</a>
        </form>
    <?php endif; ?>
</div>

<!-- JavaScript to handle quantity change and removal -->
<script>
    function changeQuantity(itemId, change) {
        var input = document.getElementById('quantity-' + itemId);
        var currentQuantity = parseInt(input.value);
        var newQuantity = Math.max(1, currentQuantity + change); // Ensure quantity is at least 1
        input.value = newQuantity;

        var form = document.getElementById('cart-form');
        var inputQuantity = form.querySelector('input[name="quantities[' + itemId + ']"]');
        if (inputQuantity) {
            inputQuantity.value = newQuantity;
        }
        form.submit(); // Automatically submit form to update cart
    }

    function removeItem(itemId) {
        if (confirm('Are you sure you want to remove this item?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'cart.php';
            
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_item_id';
            input.value = itemId;
            form.appendChild(input);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
