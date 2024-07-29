<?php include("conn.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>EPIC STORE.</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">EPIC STORE.</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home <span class="visually-hidden">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Categories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      </ul>
      <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-lg-auto">
        <form class="d-flex mb-2 mb-lg-0" action="categories.php" method="GET">
          <input class="form-control form-control-sm me-2" type="search" placeholder="Search" name="search">
          <button class="btn btn-secondary btn-sm" type="submit">Search</button>
        </form>
        <?php if ($isLoggedIn): ?>
          <div class="dropdown ms-lg-3">
            <a class="btn btn-secondary btn-sm dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($userData['Username'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <?php if ($userData['Username'] === 'Admin'): ?>
                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </div>
          <div class="d-flex mb-2 mb-lg-0"></div>
          <?php if ($userData['Username'] !== 'Admin'): ?>
            <div class="d-flex flex-lg-row align-items-lg-center ms-lg-auto">
            <a href="cart.php" class="btn btn-secondary btn-sm ms-lg-3">
              <i class="bi bi-cart"></i> Cart
            </a>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <a href="login.php" class="btn btn-secondary btn-sm ms-lg-3">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
