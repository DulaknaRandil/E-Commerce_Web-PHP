<?php
include("conn.php");

// Initialize variables for form inputs
$name = $category = $description = $imageUrl = $price = "";
$toastMessage = "";
$toastType = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $category = htmlspecialchars(trim($_POST["category"]));
    $description = htmlspecialchars(trim($_POST["description"]));
    $imageUrl = htmlspecialchars(trim($_POST["image_url"]));
    $price = floatval($_POST["price"]);

    // Insert new item into database
    $sql = "INSERT INTO items (name, category, description, imageUrl, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("ssssd", $name, $category, $description, $imageUrl, $price);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Insertion successful
        header("Location: dashboard.php?toastMessage=" . urlencode("Item updated successfully.") . "&toastType=success");
        exit();
    } else {
        // Insertion failed
        header("Location: dashboard.php?toastMessage=" . urlencode("Error updating item. Please try again.") . "&toastType=error");
        exit();
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
    <title>Add Item</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Item</h5>
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

                    <!-- Item Form -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
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
