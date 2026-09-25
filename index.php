<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity & Donation Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Dynamic Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Charity Platform</a>
            <div>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="my_donations.php">History</a></li>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <li class="nav-item">
        <a class="btn btn-outline-danger btn-sm ms-2" href="admin.php">Admin Panel</a>
    </li>
<?php endif; ?>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Jab User Login Hoga -->
                        <li class="nav-item text-white me-3">
                            <span class="badge bg-success p-2">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Jab User Login Nahi Hoga -->
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-2" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content (Hero Section) -->
    <div class="container mt-5 text-center">
        <div class="p-5 mb-4 bg-white rounded-3 shadow">
            <h1 class="display-5 fw-bold text-primary">Make a Difference Today</h1>
            <p class="col-md-8 mx-auto fs-5 mt-3 text-secondary">
                Aapka chota sa taawun (contribution) kisi ki zindagi badal sakta hai. 
                Hamare platform ka hissa banein aur zaroorat mandon ki madad karein.
            </p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="btn btn-primary btn-lg mt-4">Join as a Donor</a>
            <?php else: ?>
                <a href="campaigns.php" class="btn btn-success btn-lg mt-4">Explore Campaigns & Donate</a>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>