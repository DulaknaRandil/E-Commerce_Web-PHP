<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic Accessories Shop</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom styles can be added here */
        .hero {
            background-image: url('https://victra.com/wp-content/uploads/2023/09/Apple-Launch-Landing-Page2.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
        }
        .hero p {
            font-size: 1.5rem;
            margin-bottom: 3rem;
        }
        .featured-products .card {
            border: none;
            transition: transform 0.3s ease;
        }
        .featured-products .card:hover {
            transform: translateY(-10px);
        }
        .category-card .card {
            border: none;
            transition: transform 0.3s ease;
        }
        .category-card .card:hover {
            transform: scale(1.05);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 3rem 0;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Welcome to Electronic Accessories Shop</h1>
                    <p>Discover the best electronic accessories for your needs.</p>
                   
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="container mt-5">
        <h2 class="mb-4 text-center">Featured Products</h2>
        <div class="row">
            <?php
            $sqlFeatured = "SELECT * FROM items LIMIT 4"; // Adjusted query to select all items with a limit
            $resultFeatured = $conn->query($sqlFeatured);
            if ($resultFeatured->num_rows > 0) {
                while ($row = $resultFeatured->fetch_assoc()) {
                    echo "<div class='col-md-3'>";
                    echo "<div class='card mb-4 h-100'>";
                    echo "<img src='" . $row["imageUrl"] . "' class='card-img-top' alt='" . $row["name"] . "'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row["name"] . "</h5>";
                    echo "<p class='card-text'>" . $row["description"] . "</p>";
                    echo "<p class='text-primary'>" . $row["price"] . "</p>";
                    echo "<a href='product.php?id=" . $row["id"] . "' class='btn btn-primary'>View Details</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No featured products found.</p>";
            }
            ?>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="container mt-5">
        <h2 class="mb-4 text-center">Shop by Category</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card category-card text-center">
                    <div class="card-body">
                        <i class="bi bi-laptop" style="font-size: 4rem;"></i>
                        <h5 class="card-title mt-3">Laptops</h5>
                        <a href="categories.php?category=Laptops" class="btn btn-outline-primary btn-sm">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card category-card text-center">
                    <div class="card-body">
                        <i class="bi bi-phone" style="font-size: 4rem;"></i>
                        <h5 class="card-title mt-3">Mobile Phones</h5>
                        <a href="categories.php?category=Mobile%20Phones" class="btn btn-outline-primary btn-sm">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card category-card text-center">
                    <div class="card-body">
                        <i class="bi bi-watch" style="font-size: 4rem;"></i>
                        <h5 class="card-title mt-3">Watches</h5>
                        <a href="categories.php?category=Watches" class="btn btn-outline-primary btn-sm">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card category-card text-center">
                    <div class="card-body">
                        <i class="bi bi-headphones" style="font-size: 4rem;"></i>
                        <h5 class="card-title mt-3">Headphones</h5>
                        <a href="categories.php?category=Headphones" class="btn btn-outline-primary btn-sm">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
