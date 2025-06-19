<?php
// Start session and set save path for Docker compatibility
ini_set('session.save_path', '/tmp');
session_start();

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
$username = '';
$email = '';
$password = '';
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'am'; // Default to Amharic
$dir = in_array($lang, ['fa']) ? 'rtl' : 'ltr';

// Check for language selection
if (isset($_POST['lang'])) {
    $lang = $_POST['lang'];
    $_SESSION['lang'] = $lang;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $response['message'] = translate('Invalid CSRF token. Please refresh the page and try again.', $lang);
    } else {
        $username = filter_var(trim($_POST['username'] ?? ''), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            $response['message'] = translate('All fields are required.', $lang);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = translate('Invalid email format.', $lang);
        } elseif (strlen($password) < 8) {
            $response['message'] = translate('Password must be at least 8 characters long.', $lang);
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $verification_code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $code_expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);
            
            if ($conn->connect_error) {
                error_log("Connection failed: " . $conn->connect_error . " [Time: " . date('Y-m-d H:i:s') . "]");
                $response['message'] = translate('Database connection failed. Please try again later.', $lang);
            } else {
                $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $check_stmt->bind_param("ss", $username, $email);
                $check_stmt->execute();
                $check_stmt->store_result();
                
                if ($check_stmt->num_rows > 0) {
                    $response['message'] = translate('Username or email already exists.', $lang);
                } else {
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password, verification_code, code_expires_at, is_verified) VALUES (?, ?, ?, ?, ?, 0)");
                    $stmt->bind_param("sssss", $username, $email, $password_hash, $verification_code, $code_expires_at);
                    
                    if ($stmt->execute()) {
                        $username = '';
                        $email = '';
                        $password = '';
                        try {
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        } catch (Exception $e) {
                            error_log("CSRF token generation failed: " . $e->getMessage());
                            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
                        }
                        
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = SMTP_USERNAME;
                            $mail->Password = SMTP_PASSWORD;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom(SMTP_USERNAME, translate('Registration System', $lang));
                            $mail->addAddress($email, $username);

                            $mail->isHTML(true);
                            $mail->Subject = translate('Registration Confirmation', $lang);
                            $mail->Body = "
                                <h2>" . translate('Welcome Dear', $lang) . ", $username!</h2>
                                <p>" . translate('Your registration was successful!', $lang) . "</p>
                                <p>" . translate('Email', $lang) . ": $email</p>
                                <p>" . translate('Your verification code is', $lang) . ": <strong>$verification_code</strong></p>
                                <p>" . translate('Please click here to verify your email.', $lang) . " <a href='" . APP_DOMAIN . "/verify.php?code=$verification_code&email=$email'><button>" . translate('Click here', $lang) . "</button></a></p>
                            ";

                            $mail->send();
                            $response['success'] = true;
                            $response['message'] = translate('Registration successful! A confirmation email has been sent.', $lang);
                        } catch (Exception $e) {
                            error_log("Email sending failed: {$e->getMessage()}");
                            $response['message'] = translate('Registration successful, but email could not be sent. Please contact support.', $lang);
                        }
                    } else {
                        error_log("Registration failed: " . $stmt->error);
                        $response['message'] = translate('Registration failed. Please try again.', $lang);
                    }
                    $stmt->close();
                }
                $check_stmt->close();
                $conn->close();
            }
        }
    }
}

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Register - Abebe' => 'Register - Abebe',
            'Register' => 'Register',
            'Create your account to get started.' => 'Create your account to get started.',
            'Language' => 'Language',
            'Username' => 'Username',
            'Email' => 'Email',
            'Password' => 'Password',
            'Already have an account?' => 'Already have an account?',
            'Login here' => 'Login here',
            'Invalid CSRF token. Please refresh the page and try again.' => 'Invalid CSRF token. Please refresh the page and try again.',
            'All fields are required.' => 'All fields are required.',
            'Invalid email format.' => 'Invalid email format.',
            'Password must be at least 8 characters long.' => 'Password must be at least 8 characters long.',
            'Database connection failed. Please try again later.' => 'Database connection failed. Please try again later.',
            'Username or email already exists.' => 'Username or email already exists.',
            'Registration failed. Please try again.' => 'Registration failed. Please try again.',
            'Registration successful! A confirmation email has been sent.' => 'Registration successful! A confirmation email has been sent.',
            'Registration successful, but email could not be sent. Please contact support.' => 'Registration successful, but email could not be sent. Please contact support.',
            'Registration System' => 'Registration System',
            'Registration Confirmation' => 'Registration Confirmation',
            'Welcome Dear' => 'Welcome Dear',
            'Your registration was successful!' => 'Your registration was successful!',
            'Your verification code is' => 'Your verification code is',
            'Please click here to verify your email.' => 'Please click here to verify your email.',
            'Click here' => 'Click here',
            'Abebe' => 'Abebe',
            'Home' => 'Home',
            'About' => 'About',
            'Resume' => 'Resume',
            'Portfolio' => 'Portfolio',
            'Contact' => 'Contact',
            'Login' => 'Login',
            'Copyright' => 'Copyright',
            'All Rights Reserved' => 'All Rights Reserved',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Register - Abebe' => 'መመዝገብ - አበበ',
            'Register' => 'መመዝገብ',
            'Create your account to get started.' => 'ለመጀመር መለያዎን ይፍጠሩ።',
            'Language' => 'ቋንቋ',
            'Username' => 'ስም',
            'Email' => 'ኢሜይል',
            'Password' => 'የይለፍ ቃል',
            'Already have an account?' => 'መለያ አለዎት?',
            'Login here' => 'እዚህ ይግቡ',
            'Invalid CSRF token. Please refresh the page and try again.' => 'የማይሰራ CSRF ማስመሰያ። እባክዎ ገፁን ያድሱ እና እንደገና ይሞክሩ።',
            'All fields are required.' => 'ሁሉም መስኮች ያስፈልጋሉ።',
            'Invalid email format.' => 'የማይሰራ ኢሜይል ቅርጸት።',
            'Password must be at least 8 characters long.' => 'የይለፍ ቃል ቢያንስ 8 ቁምፊዎች መሆን አለበት።',
            'Database connection failed. Please try again later.' => 'የውሂብ ጎታ ግንኙነት አልተሳካም። እባክዎን ቆይተው ይሞክሩ።',
            'Username or email already exists.' => 'የተጠቃሚ ስም ወይም ኢሜይል ቀድሞ አለ።',
            'Registration failed. Please try again.' => 'የመዝገብ ሂደት አልተሳካም። እባክዎን እንደገና ይሞክሩ።',
            'Registration successful! A confirmation email has been sent.' => 'የመዝገብ ሂደት ተሳክቷል! እንደምርመራ ኢሜይል ተላክቷል።',
            'Registration successful, but email could not be sent. Please contact support.' => 'የመዝገብ ሂደት ተሳክቷል፣ ነገር ግን ኢሜይል ለመላክ አልቻለም። እባክዎን ድጋፍ ያግኙ።',
            'Registration System' => 'የመዝገብ ስርዓት',
            'Registration Confirmation' => 'የመዝገብ ማረጋገጫ',
            'Welcome Dear' => 'እንኳን ወዳጅ',
            'Your registration was successful!' => 'የመዝገብ ሂደት ተሳክቷል!',
            'Your verification code is' => 'የምርመራ ኮድዎ ነው',
            'Please click here to verify your email.' => 'እባክዎን ኢሜይልዎን ለማረጋገጥ እዚህ ይጫኑ።',
            'Click here' => 'እዚህ ይጫኑ',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Login' => 'ይግቡ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Abebe Bihonegn Wondie' => 'አበበ ቢሆነኝ ወንዴ'
        ],
        'af' => [
            'Register - Abebe' => 'Galmaa - Abebe',
            'Register' => 'Galmaa',
            'Create your account to get started.' => 'Akka jalqabdan hojii keessan uumaa.',
            'Language' => 'Afaan',
            'Username' => 'Maqaa',
            'Email' => 'Imeelii',
            'Password' => 'Jecha sirrii',
            'Already have an account?' => 'Akkaawuntii qabda?',
            'Login here' => 'Asitti seeni',
            'Invalid CSRF token. Please refresh the page and try again.' => 'Tookanii CSRF sirrii miti. Maaloo fuula kana haaromsaa fi irra deebi’aa yaali.',
            'All fields are required.' => 'Dirreewwan hundi ni barbaachisu.',
            'Invalid email format.' => 'Foormiin imeeliin sirrii miti.',
            'Password must be at least 8 characters long.' => 'Jechaan yeroo hunda 8 character hin caalle qaba.',
            'Database connection failed. Please try again later.' => 'Qidamni deetaa beeksisaa dadhabame. Maaloo yeroo biraatti yaali.',
            'Username or email already exists.' => 'Maqaa ykn imeelii duraan jira.',
            'Registration failed. Please try again.' => 'Galmeen ni kufte. Maaloo irra deebi’aa yaali.',
            'Registration successful! A confirmation email has been sent.' => 'Galmeen milkaa’e! Imeelii mirkaneessaa ergameera.',
            'Registration successful, but email could not be sent. Please contact support.' => 'Galmeen milkaa’e, garuu imeelii erguu hin dandeenye. Maaloo deeggarsa qunnamaa.',
            'Registration System' => 'Sirna Galmee',
            'Registration Confirmation' => 'Mirkaneessa Galmee',
            'Welcome Dear' => 'Baga Nagaan Dhuftan',
            'Your registration was successful!' => 'Galmeen keessan milkaa’eera!',
            'Your verification code is' => 'Koodiin mirkaneessaa keessan kan ta’e',
            'Please click here to verify your email.' => 'Maaloo asitti cuqaasaa imeelii keessan mirkaneessuuf.',
            'Click here' => 'Asitti cuqaasaa',
            'Abebe' => 'Abebe',
            'Home' => 'Mana',
            'About' => 'Waa\'ee',
            'Resume' => 'Gabaasa',
            'Portfolio' => 'Phootofolii',
            'Contact' => 'Maqaa',
            'Login' => 'Seeni',
            'Copyright' => 'Mirgoota',
            'All Rights Reserved' => 'Mirgoota Hunda Qaba',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'ti' => [
            'Register - Abebe' => 'መመዝገብ - ኣበበ',
            'Register' => 'መመዝገብ',
            'Create your account to get started.' => 'ንኽትጅምር ኣካውንትካ ፍጠር።',
            'Language' => 'ቋንቋ',
            'Username' => 'ስም',
            'Email' => 'ኢሜይል',
            'Password' => 'ፓስወርድ',
            'Already have an account?' => 'ኣካውንት ኣለካ ድዩ?',
            'Login here' => 'ኣብዚ እቶ',
            'Invalid CSRF token. Please refresh the page and try again.' => 'ዘይሰማማዒ CSRF ቶከን። በጃኹም ገፅ ምሕዳስ ግበሩ እንደገና ድማ ፈትኑ።',
            'All fields are required.' => 'ኩሉ መስኮታት የድልዩ።',
            'Invalid email format.' => 'ዘይሰማማዒ ቅርጸት ኢሜይል።',
            'Password must be at least 8 characters long.' => 'ፓስወርድ ብውሑዱ 8 ቁምፊታት ክኸውን ኣለዎ።',
            'Database connection failed. Please try again later.' => 'ግንኙነት መረብ ዶታቤዝ ኣይሰርሐን። በጃኹም ጸኒሕኩም ደጊምኩም ፈትኑ።',
            'Username or email already exists.' => 'ስም ተጠቃሚ ወይ ኢሜይል ቅድሚ ሕጂ ኣሎ።',
            'Registration failed. Please try again.' => 'መመዝገቢ ኣይሰርሐን። በጃኹም እንደገና ፈትኑ።',
            'Registration successful! A confirmation email has been sent.' => 'መመዝገቢ ተዓወተ! ናይ ምርግጋጽ ኢሜይል ተላኺኹ ኣሎ።',
            'Registration successful, but email could not be sent. Please contact support.' => 'መመዝገቢ ተዓወተ፣ ግን ኢሜይል ምልኣኽ ኣይኸኣለን። በጃኹም ንድጋፍ ተወከሱ።',
            'Registration System' => 'ስርዓት መመዝገቢ',
            'Registration Confirmation' => 'ምርግጋጽ መመዝገቢ',
            'Welcome Dear' => 'እንቋዕ ደሓን',
            'Your registration was successful!' => 'መመዝገብካ ተዓወተ!',
            'Your verification code is' => 'ኮድ ምርግጋጽካ እዚ እዩ',
            'Please click here to verify your email.' => 'በጃኹም ኢሜይልኩም ንምርግጋጽ ኣብዚ ጠውቑ።',
            'Click here' => 'ኣብዚ ጠውቑ',
            'Abebe' => 'ኣበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Login' => 'ይግቡ',
            'Copyright' => 'መሰል ቅዳሕ',
            'All Rights Reserved' => 'ኩሉ መሰላት ዝተሓለወ እዩ',
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ],
        'fa' => [
            'Register - Abebe' => 'ثبت‌نام - ابیبی',
            'Register' => 'ثبت‌نام',
            'Create your account to get started.' => 'برای شروع حساب کاربری خود را ایجاد کنید.',
            'Language' => 'زبان',
            'Username' => 'نام کاربری',
            'Email' => 'ایمیل',
            'Password' => 'رمز عبور',
            'Already have an account?' => 'قبلاً حساب کاربری دارید؟',
            'Login here' => 'اینجا وارد شوید',
            'Invalid CSRF token. Please refresh the page and try again.' => 'توکن CSRF نامعتبر است. لطفاً صفحه را تازه کنید و دوباره امتحان کنید.',
            'All fields are required.' => 'همه فیلدها الزامی هستند.',
            'Invalid email format.' => 'فرمت ایمیل نامعتبر است.',
            'Password must be at least 8 characters long.' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            'Database connection failed. Please try again later.' => 'اتصال به پایگاه داده ناموفق بود. لطفاً بعداً دوباره امتحان کنید.',
            'Username or email already exists.' => 'نام کاربری یا ایمیل قبلاً وجود دارد.',
            'Registration failed. Please try again.' => 'ثبت‌نام ناموفق بود. لطفاً دوباره امتحان کنید.',
            'Registration successful! A confirmation email has been sent.' => 'ثبت‌نام با موفقیت انجام شد! ایمیل تأیید ارسال شده است.',
            'Registration successful, but email could not be sent. Please contact support.' => 'ثبت‌نام با موفقیت انجام شد، اما ایمیل ارسال نشد. لطفاً با پشتیبانی تماس بگیرید.',
            'Registration System' => 'سیستم ثبت‌نام',
            'Registration Confirmation' => 'تأیید ثبت‌نام',
            'Welcome Dear' => 'خوش آمدید عزیز',
            'Your registration was successful!' => 'ثبت‌نام شما با موفقیت انجام شد!',
            'Your verification code is' => 'کد تأیید شما است',
            'Please click here to verify your email.' => 'لطفاً برای تأیید ایمیل خود اینجا کلیک کنید.',
            'Click here' => 'اینجا کلیک کنید',
            'Abebe' => 'ابیبی',
            'Home' => 'خانه',
            'About' => 'درباره',
            'Resume' => 'رزومه',
            'Portfolio' => 'پورتفولیو',
            'Contact' => 'تماس',
            'Login' => 'ورود',
            'Copyright' => 'کپی‌رایت',
            'All Rights Reserved' => 'همه حقوق محفوظ است',
            'Abebe Bihonegn Wondie' => 'ابیبی بیهونگن وندی'
        ]
    ];
    return $translations[$lang][$text] ?? $text;
}
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo $dir; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('Register - Abebe', $lang); ?></title>
    <meta name="description" content="Register for Abebe's portfolio website to access exclusive content.">
    <meta name="keywords" content="register, portfolio, Abebe, software engineer">
    <link href="<?php echo APP_DOMAIN; ?>/register.php?lang=en" rel="alternate" hreflang="en">
    <link href="<?php echo APP_DOMAIN; ?>/register.php?lang=am" rel="alternate" hreflang="am">
    <link href="<?php echo APP_DOMAIN; ?>/register.php?lang=af" rel="alternate" hreflang="af">
    <link href="<?php echo APP_DOMAIN; ?>/register.php?lang=ti" rel="alternate" hreflang="ti">
    <link href="<?php echo APP_DOMAIN; ?>/register.php?lang=fa" rel="alternate" hreflang="fa">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            margin-top: 100px;
            margin-bottom: 80px;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .language-dropdown {
            text-align: <?php echo $dir === 'rtl' ? 'left' : 'right'; ?>;
            margin-bottom: 20px;
        }
        <?php if ($dir === 'rtl'): ?>
        body, h2, p, label, .form-control {
            text-align: right;
        }
        .register-container {
            padding-right: 40px;
            padding-left: 20px;
        }
        .navmenu ul {
            flex-direction: row-reverse;
        }
        .header-social-links {
            margin-left: auto;
            margin-right: 10px;
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <header id="header" class="header d-flex align-items-center light-background sticky-top">
        <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename"><?php echo translate('Abebe', $lang); ?></h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php"><i class="bi bi-house" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Home', $lang); ?></a></li>
                    <li><a href="about.php"><i class="bi bi-info-circle" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('About', $lang); ?></a></li>
                    <li><a href="resume.php"><i class="bi bi-file-earmark-text" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Resume', $lang); ?></a></li>
                    <li><a href="portfolio.php"><i class="bi bi-images" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Portfolio', $lang); ?></a></li>
                    <li><a href="contact.php"><i class="bi bi-envelope" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Contact', $lang); ?></a></li>
                    <li>
                        <button style="background-color: green; border: none; border-radius: 20px; padding: 10px 20px;">
                            <a href="register.php" style="color: white; text-decoration: none;">
                                <i class="bi bi-person-plus-fill" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Register', $lang); ?>
                            </a>
                        </button>
                    </li>
                    <li>
                        <button style="background-color: blue; border: none; border-radius: 20px; padding: 10px 20px;">
                            <a href="login.php" style="color: white; text-decoration: none;">
                                <i class="bi bi-person-fill" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Login', $lang); ?>
                            </a>
                        </button>
                    </li>
                    <li class="dropdown">
                        <a href="#"><i class="bi bi-globe"></i> <?php echo translate('Language', $lang); ?> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="?lang=en">English</a></li>
                            <li><a href="?lang=am">አማርኛ</a></li>
                            <li><a href="?lang=af">Afan Oromo</a></li>
                            <li><a href="?lang=ti">Tigrinya</a></li>
                            <li><a href="?lang=fa">فارسی</a></li>
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <div class="header-social-links">
                <a href="https://twitter.com/AbebeB57015" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/abebe.bihonegn.2025" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/abebe.bihonegn.9/" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/abebe-bihonegn" class="linkedin"><i class="bi bi-linkedin"></i></a>
                <a href="https://t.me/bihonegn2112" class="telegram"><i class="bi bi-telegram"></i></a>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container register-container" data-aos="fade-up">
            <div class="text-center">
                <h2><?php echo translate('Register', $lang); ?></h2>
                <p class="text-muted"><?php echo translate('Create your account to get started.', $lang); ?></p>
            </div>

            <?php if (!empty($response['message'])): ?>
                <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                    <?php echo htmlspecialchars($response['message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" aria-label="Registration Form">
                 <div class="language-dropdown">
                    <label for="lang" class="form-label"><?php echo translate('Language', $lang); ?>:</label>
                    <select name="lang" id="lang" class="form-select" onchange="this.form.submit()">
                        <option value="en" <?php echo $lang === 'en' ? 'selected' : ''; ?>>English</option>
                        <option value="am" <?php echo $lang === 'am' ? 'selected' : ''; ?>>አማርኛ</option>
                        <option value="af" <?php echo $lang === 'af' ? 'selected' : ''; ?>>Afan Oromo</option>
                        <option value="ti" <?php echo $lang === 'ti' ? 'selected' : ''; ?>>Tigrinya</option>
                        <option value="fa" <?php echo $lang === 'fa' ? 'selected' : ''; ?>>فارسی</option>
                    </select>
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                
                <div class="mb-3">
                    <label for="username" class="form-label"><i class="bi bi-person"></i> <?php echo translate('Username', $lang); ?></label>
                    <input type="text" class="form-control" id="username" name="username" required value="<?php echo htmlspecialchars($username); ?>" aria-describedby="usernameHelp">
                    <div id="usernameHelp" class="form-text"><?php echo translate('Username', $lang); ?></div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope"></i> <?php echo translate('Email', $lang); ?></label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text"><?php echo translate('Email', $lang); ?></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="bi bi-lock"></i> <?php echo translate('Password', $lang); ?></label>
                    <input type="password" class="form-control" id="password" name="password" required aria-describedby="passwordHelp">
                    <div id="passwordHelp" class="form-text"><?php echo translate('Password must be at least 8 characters long.', $lang); ?></div>
                </div>
               
                <button type="submit" class="btn btn-primary w-100"><?php echo translate('Register', $lang); ?></button>
            </form>
            <p class="text-center mt-3"><?php echo translate('Already have an account?', $lang); ?> <a href="login.php"><?php echo translate('Login here', $lang); ?></a></p>
        </div>
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container">
            <div class="copyright text-center">
                <p>© <span><?php echo translate('Copyright', $lang); ?></span> <strong class="px-1 sitename"><?php echo translate('Abebe', $lang); ?></strong> <span><?php echo translate('All Rights Reserved', $lang); ?><br></span></p>
            </div>
            <div class="social-links d-flex justify-content-center">
                <a href="https://twitter.com/AbebeB57015"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.facebook.com/abebe.bihonegn.2025"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com/abebe.bihonegn.9/"><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/abebe-bihonegn"><i class="bi bi-linkedin"></i></a>
                <a href="https://t.me/bihonegn2112" class="telegram"><i class="bi bi-telegram"></i></a>
            </div>
            <div class="credits">
                <?php echo translate('Abebe Bihonegn Wondie', $lang); ?>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>