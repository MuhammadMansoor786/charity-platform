<?php
session_start();
require 'db_connect.php';

$message = "";

// Agar user ne donation submit ki hai
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $campaign_id = $_POST['campaign_id'];
    $amount = $_POST['amount'];

    if ($amount > 0) {
        // Donations table mein record save karna
        $sql = "INSERT INTO donations (user_id, campaign_id, amount) VALUES ('$user_id', '$campaign_id', '$amount')";
        if ($conn->query($sql) === TRUE) {
            // Campaigns table mein raised_amount ko update karna
            $update_sql = "UPDATE campaigns SET raised_amount = raised_amount + $amount WHERE id = $campaign_id";
            $conn->query($update_sql);
            $message = "<div class='alert alert-success'>Shukriya! Aapki donation kamyabi se record ho gayi hai.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Barah-e-karam sahi amount enter karein.</div>";
    }
}

// Active campaigns database se fetch karna
$sql = "SELECT * FROM campaigns WHERE status = 'active'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaigns - Charity Platform</title>
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
                    <li class="nav-item"><a class="nav-link active" href="campaigns.php">Campaigns</a></li>
                   <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <li class="nav-item">
        <a class="btn btn-outline-danger btn-sm ms-2" href="admin.php">Admin Panel</a>
    </li>
<?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item text-white me-3">
                            <span class="badge bg-success p-2">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </li>
                        <li class="nav-item"><a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_donations.php">History</a></li>
                        <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary fw-bold">Active Charity Campaigns</h2>
        <?php echo $message; ?>

        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-dark fw-bold"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text text-secondary flex-grow-1"><?php echo htmlspecialchars($row['description']); ?></p>
                                
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <?php 
                                        $goal = $row['goal_amount'];
                                        $raised = $row['raised_amount'];
                                        $percentage = ($goal > 0) ? ($raised / $goal) * 100 : 0;
                                        if($percentage > 100) $percentage = 100;
                                    ?>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage; ?>%;">
                                            <?php echo round($percentage); ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        Goal: Rs. <?php echo number_format($goal, 2); ?> | Raised: Rs. <?php echo number_format($raised, 2); ?>
                                    </small>
                                </div>

                                <!-- Donation Form -->
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form method="POST" action="" class="mt-auto">
                                        <input type="hidden" name="campaign_id" value="<?php echo $row['id']; ?>">
                                        <div class="input-group mb-2">
                                            <input type="number" name="amount" class="form-control" placeholder="Amount (Rs)" required min="1">
                                            <button type="submit" class="btn btn-success">Donate</button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-dark w-100 mt-auto">Login to Donate</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted fs-5">Filhal koi active campaign mojood nahi hai.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>