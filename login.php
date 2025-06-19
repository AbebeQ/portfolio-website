<?php
// Start session
session_start();

require 'config.php'; // Load sensitive credentials

// Set language from session or default to Amharic (consistent with portfolio.php)
$lang = $_SESSION['lang'] ?? 'am';
if (isset($_POST['lang'])) {
    $lang = $_POST['lang'];
    $_SESSION['lang'] = $lang;
}

// Set direction based on language
$dir = in_array($lang, ['fa']) ? 'rtl' : 'ltr';

// CSRF token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialize response
$response = ['success' => false, 'message' => ''];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $response['message'] = translate('Invalid CSRF token.', $lang);
    } else {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $response['message'] = translate('All fields are required.', $lang);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = translate('Invalid email format.', $lang);
        } else {
            // Database connection
            $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);

            if ($conn->connect_error) {
                error_log("Connection failed: " . $conn->connect_error . " [Time: " . date('Y-m-d H:i:s') . "]");
                $response['message'] = translate('Database connection failed. Please try again later.', $lang);
            } else {
                // Prepare and execute statement
                $stmt = $conn->prepare("SELECT id, password, is_verified FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($user_id, $password_hash, $is_verified);
                    $stmt->fetch();

                    // Check if the user is verified
                    if (!$is_verified) {
                        $response['message'] = translate('Please verify your email before logging in.', $lang);
                    } elseif (password_verify($password, $password_hash)) {
                        // Successful login
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['email'] = $email;
                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);
                        header("Location: contact.php");
                        exit();
                    } else {
                        $response['message'] = translate('Invalid password.', $lang);
                    }
                } else {
                    $response['message'] = translate('No user found with this email.', $lang);
                }
                $stmt->close();
                $conn->close();
            }
        }
    }
}

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Login - Abebe' => 'Login - Abebe',
            'Login' => 'Login',
            'Please enter your credentials to continue.' => 'Please enter your credentials to continue.',
            'Language' => 'Language',
            'Email' => 'Email',
            'Password' => 'Password',
            'Don\'t have an account?' => 'Don\'t have an account?',
            'Register here' => 'Register here',
            'Forgot password?' => 'Forgot password?',
            'All fields are required.' => 'All fields are required.',
            'Invalid email format.' => 'Invalid email format.',
            'Database connection failed. Please try again later.' => 'Database connection failed. Please try again later.',
            'Please verify your email before logging in.' => 'Please verify your email before logging in.',
            'Invalid password.' => 'Invalid password.',
            'No user found with this email.' => 'No user found with this email.',
            'Invalid CSRF token.' => 'Invalid CSRF token.',
            'Abebe' => 'Abebe',
            'Home' => 'Home',
            'About' => 'About',
            'Resume' => 'Resume',
            'Portfolio' => 'Portfolio',
            'Contact' => 'Contact',
            'Register' => 'Register',
            'Copyright' => 'Copyright',
            'All Rights Reserved' => 'All Rights Reserved',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Login - Abebe' => 'ይግቡ - አበበ',
            'Login' => 'ይግቡ',
            'Please enter your credentials to continue.' => 'እባክዎን ለመቀጠል የእርስዎን ዝርዝሮች ያስገቡ።',
            'Language' => 'ቋንቋ',
            'Email' => 'ኢሜይል',
            'Password' => 'የይለፍ ቃል',
            'Don\'t have an account?' => 'መለያ የለዎትም?',
            'Register here' => 'እዚህ ይመዝገቡ',
            'Forgot password?' => 'የይለፍ ቃል ረስተዋል?',
            'All fields are required.' => 'ሁሉም መስኮች ያስፈልጋሉ።',
            'Invalid email format.' => 'የማይሰራ ኢሜይል ቅርጸት።',
            'Database connection failed. Please try again later.' => 'የውሂብ ጎታ ግንኙነት አልተሳካም። እባክዎን ቆይተው ይሞክሩ።',
            'Please verify your email before logging in.' => 'እባክዎን ከመግባትዎ በፊት ኢሜይልዎን ያረጋግጡ።',
            'Invalid password.' => 'የማይሰራ የይለፍ ቃል።',
            'No user found with this email.' => 'በዚህ ኢሜይል ምንም ተጠቃሚ አልተገኘም።',
            'Invalid CSRF token.' => 'የማይሰራ CSRF ማስመሰያ።',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Abebe Bihonegn Wondie' => 'አበበ ቢሆነኝ ወንዴ'
        ],
        'af' => [
            'Login - Abebe' => 'Seeni - Abebe',
            'Login' => 'Seeni',
            'Please enter your credentials to continue.' => 'Meeqa dhugaa dirqama keessan galchaa jiraachuu.',
            'Language' => 'Afaan',
            'Email' => 'Imeelii',
            'Password' => 'Jecha sirrii',
            'Don\'t have an account?' => 'Akkaawuntii hin qabduu?',
            'Register here' => 'Asitti galmaa\'i',
            'Forgot password?' => 'Jecha sirrii irraanfattee?',
            'All fields are required.' => 'Dirreewwan hundi ni barbaachisu.',
            'Invalid email format.' => 'Foormiin imeeliin sirrii miti.',
            'Database connection failed. Please try again later.' => 'Qidamni deetaa beeksisaa dadhabame. Maaloo yeroo biraatti yaali.',
            'Please verify your email before logging in.' => 'Maaloo imeeli keessan galchuu dura mirkaneessaa.',
            'Invalid password.' => 'Jecha sirrii miti.',
            'No user found with this email.' => 'Imeelii kanaa fayyadamtoota hin argamne.',
            'Invalid CSRF token.' => 'Tookanii CSRF sirrii miti.',
            'Abebe' => 'Abebe',
            'Home' => 'Mana',
            'About' => 'Waa\'ee',
            'Resume' => 'Gabaasa',
            'Portfolio' => 'Phootofolii',
            'Contact' => 'Maqaa',
            'Register' => 'Galmee',
            'Copyright' => 'Mirgoota',
            'All Rights Reserved' => 'Mirgoota Hunda Qaba',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'ti' => [
            'Login - Abebe' => 'ይግቡ - ኣበበ',
            'Login' => 'ይግቡ',
            'Please enter your credentials to continue.' => 'እባክዎን ምቕጻል ንምቕጻል ናይ እርስኻ ሓበሬታ ኣእቱ።',
            'Language' => 'ቋንቋ',
            'Email' => 'ኢሜይል',
            'Password' => 'ፓስወርድ',
            'Don\'t have an account?' => 'ኣካውንት የብልካን ዶ?',
            'Register here' => 'ኣብዚ ተመዝገብ',
            'Forgot password?' => 'ፓስወርድ ረሲዕካዮ?',
            'All fields are required.' => 'ኩሉ መስኮታት የድልዩ።',
            'Invalid email format.' => 'ዘይሰማማዒ ቅርጸት ኢሜይል።',
            'Database connection failed. Please try again later.' => 'ግንኙነት መረብ ዶታቤዝ ኣይሰርሐን። በጃኹም ጸኒሕኩም ደጊምኩም ፈትኑ።',
            'Please verify your email before logging in.' => 'በጃኹም ቅድሚ ምእታውኩም ኢሜይልኩም ተረጋግጹ።',
            'Invalid password.' => 'ዘይሰማማዒ ፓስወርድ።',
            'No user found with this email.' => 'በዚ ኢሜይል ዝተጠቃሚ ኣይተረኽበን።',
            'Invalid CSRF token.' => 'ዘይሰማማዒ CSRF ቶከን።',
            'Abebe' => 'ኣበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ],
        'fa' => [
            'Login - Abebe' => 'ورود - ابیبی',
            'Login' => 'ورود',
            'Please enter your credentials to ادامه.' => 'لطفاً اطلاعات خود را برای ادامه وارد کنید.',
            'Language' => 'زبان',
            'Email' => 'ایمیل',
            'Password' => 'رمز عبور',
            'Don\'t have an account?' => 'حساب کاربری ندارید؟',
            'Register here' => 'اینجا ثبت‌نام کنید',
            'Forgot password?' => 'رمز عبور را فراموش کرده‌اید؟',
            'All fields are required.' => 'همه فیلدها الزامی هستند.',
            'Invalid email format.' => 'فرمت ایمیل نامعتبر است.',
            'Database connection failed. Please try again later.' => 'اتصال به پایگاه داده ناموفق بود. لطفاً بعداً دوباره امتحان کنید.',
            'Please verify your email before logging in.' => 'لطفاً قبل از ورود، ایمیل خود را تأیید کنید.',
            'Invalid password.' => 'رمز عبور نامعتبر است.',
            'No user found with this email.' => 'کاربری با این ایمیل یافت نشد.',
            'Invalid CSRF token.' => 'توکن CSRF نامعتبر است.',
            'Abebe' => 'ابیبی',
            'Home' => 'خانه',
            'About' => 'درباره',
            'Resume' => 'رزومه',
            'Portfolio' => 'پورتفولیو',
            'Contact' => 'تماس',
            'Register' => 'ثبت‌نام',
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
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo translate('Login - Abebe', $lang); ?></title>
  <meta name="description" content="Login to Abebe's portfolio website to access exclusive content.">
  <meta name="keywords" content="login, portfolio, Abebe, software engineer">
  <link href="<?php echo APP_DOMAIN; ?>/login.php?lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/login.php?lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/login.php?lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/login.php?lang=ti" rel="alternate" hreflang="ti">
  <link href="<?php echo APP_DOMAIN; ?>/login.php?lang=fa" rel="alternate" hreflang="fa">
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
    .login-container {
      margin-top: 100px;
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
    .login-container {
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
    <div class="container login-container" data-aos="fade-up">
      <div class="text-center">
        <h2><?php echo translate('Login', $lang); ?></h2>
        <p class="text-muted"><?php echo translate('Please enter your credentials to continue.', $lang); ?></p>
      </div>

      <?php if (!empty($response['message'])): ?>
        <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-danger'; ?>" role="alert">
          <?php echo htmlspecialchars($response['message']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" aria-label="Login Form">
          <div class="language-dropdown">
          <label for="language" class="form-label"><?php echo translate('Language', $lang); ?>:</label>
          <select name="lang" id="language" class="form-select" onchange="this.form.submit()">
            <option value="en" <?php echo $lang === 'en' ? 'selected' : ''; ?>>English</option>
            <option value="am" <?php echo $lang === 'am' ? 'selected' : ''; ?>>አማርኛ</option>
            <option value="af" <?php echo $lang === 'af' ? 'selected' : ''; ?>>Afan Oromo</option>
            <option value="ti" <?php echo $lang === 'ti' ? 'selected' : ''; ?>>Tigrinya</option>
            <option value="fa" <?php echo $lang === 'fa' ? 'selected' : ''; ?>>فارسی</option>
          </select>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="mb-3">
          <label for="email" class="form-label"><i class="bi bi-envelope"></i> <?php echo translate('Email', $lang); ?></label>
          <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text"><?php echo translate('Please enter your credentials to continue.', $lang); ?></div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label"><i class="bi bi-lock"></i> <?php echo translate('Password', $lang); ?></label>
          <input type="password" class="form-control" id="password" name="password" required aria-describedby="passwordHelp">
          <div id="passwordHelp" class="form-text"><?php echo translate('Password', $lang); ?></div>
        </div>
      
        <button type="submit" class="btn btn-primary w-100"><?php echo translate('Login', $lang); ?></button>
      </form>
      <p class="text-center mt-3"><?php echo translate('Don\'t have an account?', $lang); ?> <a href="register.php"><?php echo translate('Register here', $lang); ?></a></p>
      <p class="text-center"><a href="forgot-password.php"><?php echo translate('Forgot password?', $lang); ?></a></p>
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