<?php
// Function to validate email address
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate telephone number
function validatePhoneNumber($telephone)
{
    // Check if telephone starts with '+94' and has 11 digits in total
    return preg_match('/^\+94\d{9}$/', $telephone);
}

 include 'conn.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $province = $_POST["province"];
    $city = $_POST["city"];

    // Check if passwords match
    if ($password !== $password_confirmation) {
        $error_message = "Passwords do not match.";
    } else {
        // Validate email
        if (!validateEmail($email)) {
            $error_message = "Invalid email address.";
        } else {
            // Validate telephone number
            if (!validatePhoneNumber($telephone)) {
                $error_message = "Invalid telephone number.";
            } else {
                // Perform further validations and database insertion
                // Insert data into the users table
                $sql = "INSERT INTO user (Username, Password, EmailAddress, TelephoneNumber, Province, City) VALUES ('$username', '$password', '$email', '$telephone', '$province', '$city')";

                if ($conn->query($sql) === TRUE) {
                    $success_message = "New record created successfully";
                } else {
                    $error_message = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Linking Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        .dark-mode {
            background-color: #121212;
            color: white;
        }

        
        .card-body {
            padding: 15px;
        }
        .form-control, .form-select {
            padding: 0.5rem;
        }
    
    </style>
</head>

<body class="bg-light" id="body">



    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card w-100" style="max-width: 500px;">
            <div class="card-body">
                <h5 class="card-title text-center">Register</h5>
                <form method="POST" action="">
                    <!-- Success message -->
                    <?php if (!empty($success_message)) { ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Success!</strong> <?php echo $success_message; ?>
                        </div>
                    <?php } ?>
                    <!-- End of success message -->
                    <!-- Error message -->
                    <?php if (!empty($error_message)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error!</strong> <?php echo $error_message; ?>
                        </div>
                    <?php } ?>
                    <!-- End of error message -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="******************" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******************" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Telephone Number</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="+94" value="+94" required>
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-select" id="province" name="province" onchange="fetchCities()" required>
                            <option value="">Select Province</option>
                            <option value="Northern Province">Northern Province</option>
                            <option value="Eastern Province">Eastern Province</option>
                            <option value="Central Province">Central Province</option>
                            <option value="North Central Province">North Central Province</option>
                            <option value="North Western Province">North Western Province</option>
                            <option value="Sabaragamuwa Province">Sabaragamuwa Province</option>
                            <option value="Southern Province">Southern Province</option>
                            <option value="Uva Province">Uva Province</option>
                            <option value="Western Province">Western Province</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select class="form-select" id="city" name="city" required>
                            <option value="">Select City</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                        <a href="login.php" class="text-primary">Already have an account? Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <?php include 'footer.php'; ?>


    <script>
        function toggleDarkMode() {
            var body = document.getElementById("body");
            body.classList.toggle("dark-mode");
        }

        function fetchCities() {
            var province = document.getElementById("province").value;
            var citySelect = document.getElementById("city");
            // Clear existing options
            citySelect.innerHTML = "";
            // Add default option
            var defaultOption = document.createElement("option");
            defaultOption.text = "Select City";
            defaultOption.value = "";
            citySelect.add(defaultOption);
            // Add cities based on province
            var cities = [];
            if (province === "Northern Province") {
                cities = ["Jaffna", "Vavuniya", "Kilinochchi", "Mannar"];
            } else if (province === "Eastern Province") {
                cities = ["Trincomalee", "Batticaloa", "Ampara"];
            } else if (province === "Central Province") {
                cities = ["Kandy", "Matale", "Nuwara Eliya"];
            } else if (province === "North Central Province") {
                cities = ["Anuradhapura", "Polonnaruwa"];
            } else if (province === "North Western Province") {
                cities = ["Kurunegala", "Puttalam"];
            } else if (province === "Sabaragamuwa Province") {
                cities = ["Ratnapura", "Kegalle"];
            } else if (province === "Southern Province") {
                cities = ["Galle", "Matara", "Hambantota"];
            } else if (province === "Uva Province") {
                cities = ["Badulla", "Monaragala"];
            } else if (province === "Western Province") {
                cities = ["Colombo", "Gampaha", "Kalutara"];
            }

            // Add cities to select element
            for (var i = 0; i < cities.length; i++) {
                var option = document.createElement("option");
                option.text = cities[i];
                option.value = cities[i];
                citySelect.add(option);
            }
        }
    </script>



</body>

</html>

