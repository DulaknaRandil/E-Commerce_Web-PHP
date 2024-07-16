<?php
include("conn.php");

// Initialize variables for form inputs and toast message
$item_id = $name = $category = $description = $imageUrl = $price = "";
$toastMessage = "";
$toastType = "";

// Check if item ID is provided via GET parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the item ID
    $item_id = intval($_GET['id']);

    // Fetch item details from database
    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item found, fetch details
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $category = $row['category'];
        $description = $row['description'];
        $imageUrl = $row['imageUrl'];
        $price = $row['price'];
    } else {
        // Item not found
        $toastMessage = "Item not found.";
        $toastType = "error";
    }

    // Close statement
    $stmt->close();
}

// Handle form submission for updating item details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $item_id = intval($_POST["item_id"]);
    $name = htmlspecialchars(trim($_POST["name"]));
    $category = htmlspecialchars(trim($_POST["category"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $imageUrl = htmlspecialchars(trim($_POST["image_url"]));
    $price = floatval($_POST["price"]);

    // Update item details in the database
    $sql = "UPDATE items SET name = ?, category = ?, description = ?, imageUrl = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("ssssdi", $name, $category, $description, $imageUrl, $price, $item_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Update successful
        $toastMessage = "Item updated successfully.";
        $toastType = "success";
        header("Location: dashboard.php?toastMessage=" . urlencode($toastMessage) . "&toastType=" . urlencode($toastType));
        exit();
    } else {
        // Update failed
        $toastMessage = "Failed to update item. Please try again.";
        $toastType = "error";
    }

    // Close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Item</h5>
                </div>
                <div class="card-body">
                    <!-- Display Toast Message -->
                    <?php if (!empty($toastMessage)): ?>
                        <div class="toast show <?php echo ($toastType == 'success') ? 'bg-success' : 'bg-danger'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto"><?php echo ($toastType == 'success') ? 'Success' : 'Error'; ?></strong>
                                <small><?php echo date('H:i'); ?></small>
                                <button type="button" class="btn-close ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                <?php echo htmlspecialchars($toastMessage); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Item Edit Form -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($description); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($imageUrl); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $price; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Item</button>
                        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
