<?php
// Start session
session_start();

// Check if token and email are present
if (!isset($_GET['token']) || !isset($_GET['email'])) {
    die('Invalid request.');
}

$token = $_GET['token'];
$email = filter_var(trim($_GET['email']), FILTER_SANITIZE_EMAIL);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['new_password'] ?? '');

    if (empty($new_password) || strlen($new_password) < 8) {
        $response['message'] = 'Password must be at least 8 characters long.';
    } else {
        // Database connection
        require 'config.php';
        $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            $response['message'] = "Database connection failed. Please try again later.";
        } else {
            // Update the user's password directly in the users table
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $password_hash, $email);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Your password has been reset successfully. You can now log in.';
            } else {
                $response['message'] = 'Failed to update password. Please try again.';
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .reset-password-container {
            margin-top: 100px;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container reset-password-container">
        <h2 class="text-center">Reset Password</h2>
        <?php if (!empty($response['message'])): ?>
            <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo htmlspecialchars($response['message']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" name="new_password" required>
                <small class="form-text text-muted">Password must be at least 8 characters long.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
        <p class="text-center mt-3">Remembered your password? <a href="login.php">Login here</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>