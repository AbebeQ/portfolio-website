<?php
// Start session and set save path for Docker compatibility
ini_set('session.save_path', '/tmp');
session_start();

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
        error_log("CSRF token generation failed: " . $e->getMessage());
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $response['message'] = 'Invalid CSRF token. Please refresh the page and try again.';
    } else {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (empty($email)) {
            $response['message'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email format.';
        } else {
            // Database connection
            $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);
            
            if ($conn->connect_error) {
                error_log("Connection failed: " . $conn->connect_error);
                $response['message'] = "Database connection failed. Please try again later.";
            } else {
                // Check if email exists in users table
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Generate a unique token for password reset
                    $token = bin2hex(random_bytes(16));
                    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    // Prepare the reset link
                    $reset_link = "https://172.20.47.9/reset-password.php?token=$token&email=$email";

                    // Send email with reset link using PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = SMTP_USERNAME;
                        $mail->Password = SMTP_PASSWORD;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom(SMTP_USERNAME, 'Password Reset');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Request';
                        $mail->Body = "
                            <h2>Reset Your Password</h2>
                            <p>Click the link below to reset your password:</p>
                            <p><a href='$reset_link'>Reset Password</a></p>
                        ";

                        $mail->send();
                        $response['success'] = true;
                        $response['message'] = 'Password reset link has been sent to your email.';
                    } catch (Exception $e) {
                        error_log("Email sending failed: {$mail->ErrorInfo}");
                        $response['message'] = "Failed to send email. Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $response['message'] = 'No user found with this email.';
                }
                $stmt->close();
                $conn->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .forgot-password-container {
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
    <div class="container forgot-password-container">
        <h2 class="text-center">Forgot Password</h2>
        <?php if (!empty($response['message'])): ?>
            <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo htmlspecialchars($response['message']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
        </form>
        <p class="text-center mt-3">Remembered your password? <a href="login.php">Login here</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>