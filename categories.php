<?php
// Include your database connection script
include("navbar.php");

// Initialize variables
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to retrieve categories
$sqlCategories = "SELECT DISTINCT category FROM items";
$resultCategories = $conn->query($sqlCategories);

// Query to retrieve items based on category and search term
$sqlItems = "SELECT * FROM items";

// Adjust the query based on category and search parameters
if (!empty($category)) {
    $sqlItems .= " WHERE category LIKE '%$category%'";
}

if (!empty($search)) {
    if (strpos($sqlItems, 'WHERE') !== false) {
        $sqlItems .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
    } else {
        $sqlItems .= " WHERE (name LIKE '%$search%' OR description LIKE '%$search%')";
    }
}

$resultItems = $conn->query($sqlItems);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Accessories Shop - <?php echo htmlspecialchars($category); ?></title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .search-form {
            margin-bottom: 2rem;
        }

        .search-form .form-control {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .search-form .btn-outline-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .search-form .btn-outline-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .card {
            transition: transform 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .category-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <!-- Search and Filter Section -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="categories.php" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search items..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                        
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Items Section -->
    <section class="container mt-3">
    
        <?php
        // Display items grouped by categories
        if ($resultCategories->num_rows > 0) {
            while ($catRow = $resultCategories->fetch_assoc()) {
                $currentCategory = $catRow['category'];
                // Query items for the current category
                $sqlItemsByCategory = "SELECT * FROM items WHERE category LIKE '%$currentCategory%'";
                if (!empty($search)) {
                    $sqlItemsByCategory .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
                }
                $resultItemsByCategory = $conn->query($sqlItemsByCategory);
                // Display category header and items
                if ($resultItemsByCategory->num_rows > 0) {
                    echo "<div class='category-header'>$currentCategory</div>";
                    echo "<div class='row'>";
                    while ($row = $resultItemsByCategory->fetch_assoc()) {
                        echo "<div class='col-md-4 col-sm-6'>";
                        echo "<div class='card mb-4'>";
                        echo "<img src='" . $row["imageUrl"] . "' class='card-img-top' alt='" . $row["name"] . "'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $row["name"] . "</h5>";
                        echo "<p class='card-text'>" . $row["description"] . "</p>";
                        echo "<p class='text-primary'>" . $row["price"] . "</p>";
                        echo "<a href='product.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>View Details</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>"; // Close row
                }
            }
        } else {
            echo "<div class='col-md-12 text-center'>";
            echo "<p>No categories found.</p>";
            echo "</div>";
        }
        ?>
    </section>
    <br>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
