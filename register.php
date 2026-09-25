<?php
// Database connection ko is page ke sath link karna
require 'db_connect.php';
$message = "";

// Agar form submit (POST) kiya gaya hai
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Password ko secure (encrypt) karna taake database mein safe rahe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Database ke 'users' table mein data insert karne ki SQL query
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'donor')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert alert-success'>Registration Successful! Welcome to the platform.</div>";
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
    <title>Register - Charity Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Charity Platform</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Registration Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Donor Registration</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Success ya Error message yahan show hoga -->
                        <?php echo $message; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>