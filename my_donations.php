<?php
session_start();
require 'db_connect.php';

// Check karna ke user login hai ya nahi
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// User ki sari donations fetch karne ki query (Campaigns table ke sath JOIN karke)
$sql = "SELECT donations.amount, donations.donation_date, campaigns.title 
        FROM donations 
        JOIN campaigns ON donations.campaign_id = campaigns.id 
        WHERE donations.user_id = '$user_id' 
        ORDER BY donations.donation_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History - Charity Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Charity Platform</a>
            <div>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="campaigns.php">Campaigns</a></li>
                    <li class="nav-item"><a class="nav-link active" href="my_donations.php">Donation History</a></li>
                    <li class="nav-item text-white me-3">
                        <span class="badge bg-success p-2">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </li>
                    <li class="nav-item"><a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary fw-bold">Aapki Donation History</h2>
        
        <div class="card shadow">
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Campaign Title</th>
                                    <th>Donated Amount (Rs)</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td class="text-success fw-bold">Rs. <?php echo number_format($row['amount'], 2); ?></td>
                                        <td class="text-muted"><?php echo $row['donation_date']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted fs-5">Aapne abhi tak koi donation nahi ki hai.</p>
                        <a href="campaigns.php" class="btn btn-primary mt-2">Explore Campaigns & Donate Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>