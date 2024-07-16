<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Electronic Accessories Shop</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            color: #444;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
        }

        .jumbotron {
            background-color: #343a40;
            color: white;
            padding: 2rem;
            border-radius: 0.3rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .jumbotron h1 {
            font-size: 2.5rem;
        }

        .jumbotron p {
            font-size: 1.2rem;
        }

        .jumbotron hr {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .jumbotron a.btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .jumbotron a.btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .row {
            margin-top: 30px;
        }

        h2 {
            color: #343a40;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        .icon {
            font-size: 2rem;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">About Electronic Accessories Shop</h1>
            <p class="lead">Welcome to Electronic Accessories Shop, your one-stop destination for high-quality electronic accessories. We are passionate about providing the latest gadgets and accessories to enhance your digital lifestyle.</p>
            <hr class="my-4">
            <p>Our mission is to offer a curated selection of products that combine cutting-edge technology with exceptional design, ensuring that every purchase meets your expectations for quality and innovation.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="index.php" role="button">Browse Products</a>
            </p>
        </div>
<br>
        <div class="row">
            <div class="col-md-6">
                <h2><i class="bi bi-eye icon"></i> Our Vision</h2>
                <p>To become the leading provider of electronic accessories, recognized for our commitment to customer satisfaction, product innovation, and ethical business practices.</p>
            </div>
            <div class="col-md-6">
                <h2><i class="bi bi-shield icon"></i> Our Values</h2>
                <ul>
                    <li><strong>Quality:</strong> We prioritize quality in every product we offer.</li>
                    <li><strong>Innovation:</strong> Constantly seeking new technologies and trends.</li>
                    <li><strong>Customer Satisfaction:</strong> Ensuring every customer is delighted with their purchase.</li>
                    <li><strong>Integrity:</strong> Conducting business with honesty and transparency.</li>
                </ul>
            </div>
        </div>
<br>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2><i class="bi bi-people icon"></i> Our Team</h2>
                <p>Meet the dedicated team behind Electronic Accessories Shop:</p>
                <ul>
                    <li><strong>Dulakna Randil - Founder & CEO:</strong> Bringing over 15 years of experience in the tech industry.</li>
                    <li><strong>Deshan Sameera - Head of Operations:</strong> Ensuring smooth operations and logistics.</li>
                    <li><strong>Anuradha Dilshan - Customer Experience Manager:</strong> Focused on delivering exceptional service.</li>
                </ul>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
