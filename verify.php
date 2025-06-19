<?php
session_start();
require 'config.php'; // Load sensitive credentials

$response = ['success' => false, 'message' => ''];

if (isset($_GET['email'])) {
    $email = filter_var(trim($_GET['email']), FILTER_SANITIZE_EMAIL);
} else {
    $response['message'] = 'No email provided.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = filter_var(trim($_POST['code']), FILTER_SANITIZE_STRING);
    
    // Database connection
    $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);
    
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        $response['message'] = "Database connection failed. Please try again later.";
    } else {
        // Check if the code exists and if it has expired
        $stmt = $conn->prepare("SELECT id, code_expires_at FROM users WHERE email = ? AND verification_code = ?");
        $stmt->bind_param("ss", $email, $code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $code_expires_at);
            $stmt->fetch();

            // Check if the code has expired
            if (new DateTime() > new DateTime($code_expires_at)) {
                $response['message'] = 'Your verification code has expired.';
            } else {
                // Update user to verified
                $update_stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
                $update_stmt->bind_param("s", $email);
                $update_stmt->execute();
                $response['success'] = true;
                $response['message'] = 'Email verified successfully! Thank you for verifying your registration.';
            }
        } else {
            $response['message'] = 'Invalid verification code.';
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <h2>Email Verification</h2>
    <?php if (!empty($response['message'])): ?>
        <div class="message <?php echo $response['success'] ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($response['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($email)): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email:<?php echo htmlspecialchars($email); ?></label>
        
            </div>
            <div class="form-group">
                <label for="code">Verification Code:</label>
                <input type="text" name="code" required>
            </div>
            <button type="submit">Verify</button>
        </form>
    <?php endif; ?>
</body>
</html>