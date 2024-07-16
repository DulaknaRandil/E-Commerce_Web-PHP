<?php
include("conn.php");

// Initialize variables for form inputs and toast message
$user_id = $username = $email = "";
$toastMessage = "";
$toastType = "";

// Check if user ID is provided via GET parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the user ID
    $user_id = intval($_GET['id']);

    // Fetch user details from database
    $sql = "SELECT * FROM user WHERE UserID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, fetch details
        $row = $result->fetch_assoc();
        $username = $row['Username'];
        $email = $row['EmailAddress'];
    } else {
        // User not found
        $toastMessage = "User not found.";
        $toastType = "error";
    }

    // Close statement
    $stmt->close();
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $user_id = intval($_POST["user_id"]);
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));

    // Update user details in the database
    $sql = "UPDATE user SET Username = ?, EmailAddress = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("ssi", $username, $email, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Update successful
        $toastMessage = "User updated successfully.";
        $toastType = "success";
        header("Location: dashboard.php?toastMessage=" . urlencode($toastMessage) . "&toastType=" . urlencode($toastType));
        exit();
    } else {
        // Update failed
        $toastMessage = "Failed to update user. Please try again.";
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
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit User</h5>
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

                    <!-- User Edit Form -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
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
