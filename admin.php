<?php
session_start();
require 'db_connect.php';

// Check karna ke user logged in hai aur uska role 'admin' hai
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";

// Nayi campaign insert karne ka code
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $goal_amount = $_POST['goal_amount'];

    $sql = "INSERT INTO campaigns (title, description, goal_amount, status) VALUES ('$title', '$description', '$goal_amount', 'active')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-success'>Nayi Campaign kamyabi se add ho gayi hai!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Charity Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Charity Platform (Admin Panel)</a>
            <div>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="campaigns.php">Campaigns</a></li>
                    <li class="nav-item text-white me-3">
                        <span class="badge bg-danger p-2">Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </li>
                    <li class="nav-item"><a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Admin Form Container -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white text-center">
                        <h4>Add New Charity Campaign</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $message; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Campaign Title</label>
                                <input type="text" name="title" class="form-control" placeholder="jaise: Winter Clothes Drive" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Campaign ki tafseel likhein..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Goal Amount (Rs)</label>
                                <input type="number" name="goal_amount" class="form-control" placeholder="jaise: 75000" required min="1">
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Publish Campaign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>