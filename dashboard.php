<?php
// Include database connection file
include("conn.php");

// Start session


// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch session data
$username = $_SESSION['username'];
$userIcon = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSy7nFdX1g_CVR4WyP5LgKOGytP0J8PE53_RQ&s"; // Replace with actual user icon URL

// Query to fetch items from database
$sqlItems = "SELECT * FROM items";
$resultItems = $conn->query($sqlItems);

// Query to fetch users from database
$sqlUsers = "SELECT * FROM user";
$resultUsers = $conn->query($sqlUsers);
?>

<?php if (isset($_GET['toastMessage']) && !empty($_GET['toastMessage'])): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show <?php echo ($_GET['toastType'] == 'error') ? 'bg-danger' : 'bg-success'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto"><?php echo ($_GET['toastType'] == 'error') ? 'Error' : 'Success'; ?></strong>
                <small><?php echo date('H:i'); ?></small>
                <button type="button" class="btn-close ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?php echo htmlspecialchars($_GET['toastMessage']); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles for dark mode sidebar */
        #sidebar {
            background-color: #343a40; /* Dark background */
        }
        #sidebar .nav-link {
            color: #ffffff; /* White text */
        }
        #sidebar .nav-link.active {
            background-color: #495057; /* Active link background */
        }
        #sidebar .nav-link:hover {
            background-color: #495057; /* Hover effect */
        }
        .topbar {
            background-color: #343a40; /* Dark background for top bar */
            color: #ffffff; /* White text */
            padding: 15px; /* Padding for top bar */
        }
        .topbar img {
            border-radius: 50%; /* Round user icon */
        }
        .toast-container {
            z-index: 1055;
        }
        .dash{
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Top Navigation Bar -->
            <div class="col-12 topbar d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 dash ">Dashboard</h1>
                <div class="d-flex align-items-center">
                    <img src="<?php echo $userIcon; ?>" alt="User Icon" width="30" height="30" class="me-2">
                    <span class="me-3"><?php echo htmlspecialchars($username); ?></span>
                    <a href="index.php" class="btn btn-light btn-sm me-2">Home</a>
                    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
                </div>
            </div>

            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#items-section">
                                <i class="bi bi-box"></i> Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users-section">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h2 id="items-section">Items</h2>
                    <!-- Search Bar for Items -->
                    <div class="input-group mb-3">
                        <input type="text" id="itemSearch" class="form-control" placeholder="Search Items" aria-label="Search Items" aria-describedby="button-addon2">
                    </div>
                    <!-- Items Table -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Items List</h5>
                            <table class="table table-hover" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Output items data
                                    if ($resultItems->num_rows > 0) {
                                        while($row = $resultItems->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$row["id"]."</td>";
                                            echo "<td>".$row["name"]."</td>";
                                            echo "<td>".$row["category"]."</td>";
                                            echo "<td>".$row["description"]."</td>";
                                            echo "<td><img src='".$row["imageUrl"]."' style='max-width: 100px;' /></td>";
                                            echo "<td>".$row["price"]."</td>";
                                            echo "<td>";
                                            echo "<a href='edit_item.php?id=".$row["id"]."' class='btn btn-sm btn-primary'>Edit</a> ";
                                            echo "<br/><br/>";
                                            echo "<a href='delete_item.php?id=".$row["id"]."' class='btn btn-sm btn-danger'>Delete</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No items found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <a href="add_item.php" class="btn btn-success">Add New Item</a>
                        </div>
                    </div>

                    <hr class="mt-5">

                    <!-- Users Section -->
                    <h2 id="users-section">Users</h2>
                    <!-- Search Bar for Users -->
                    <div class="input-group mb-3">
                        <input type="text" id="userSearch" class="form-control" placeholder="Search Users" aria-label="Search Users" aria-describedby="button-addon2">
                    </div>
                    <!-- Users Table -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Users List</h5>
                            <table class="table table-hover" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Output users data
                                    if ($resultUsers->num_rows > 0) {
                                        while($row = $resultUsers->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$row["UserID"]."</td>";
                                            echo "<td>".$row["Username"]."</td>";
                                            echo "<td>".$row["EmailAddress"]."</td>";
                                            echo "<td>";
                                            echo "<a href='edit_user.php?id=".$row["UserID"]."' class='btn btn-sm btn-primary'>Edit</a> ";
                                            echo "<a href='delete_user.php?id=".$row["UserID"]."' class='btn btn-sm btn-danger'>Delete</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No users found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript for search functionality -->
    <script>
        document.getElementById('itemSearch').addEventListener('keyup', function() {
            var searchValue = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('#itemsTable tbody tr');
            tableRows.forEach(function(row) {
                var itemName = row.cells[1].textContent.toLowerCase();
                var itemCategory = row.cells[2].textContent.toLowerCase();
                var itemDescription = row.cells[3].textContent.toLowerCase();
                if (itemName.includes(searchValue) || itemCategory.includes(searchValue) || itemDescription.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.getElementById('userSearch').addEventListener('keyup', function() {
            var searchValue = this.value.toLowerCase();
            var tableRows = document.querySelectorAll('#usersTable tbody tr');
            tableRows.forEach(function(row) {
                var username = row.cells[1].textContent.toLowerCase();
                var userEmail = row.cells[2].textContent.toLowerCase();
                if (username.includes(searchValue) || userEmail.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
