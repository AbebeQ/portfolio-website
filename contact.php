<?php
// Configure error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php_errors.log');

// Start session
ini_set('session.save_path', '/tmp');
session_start();

// Set language from session or default to Amharic
$lang = $_SESSION['lang'] ?? 'am';
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $lang = $_GET['lang'];
}

// All languages use LTR direction
$dir = 'ltr';

// Generate CSRF token if not set
if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
        error_log("Contact.php - CSRF token generation failed: " . $e->getMessage());
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Contact - Abebe' => 'Contact - Abebe',
            'Abebe' => 'Abebe',
            'Home' => 'Home',
            'About' => 'About',
            'Resume' => 'Resume',
            'Portfolio' => 'Portfolio',
            'Contact' => 'Contact',
            'Register' => 'Register',
            'Login' => 'Login',
            'Language' => 'Language',
            'Copyright' => 'Copyright',
            'All Rights Reserved' => 'All Rights Reserved',
            'Favicon' => 'Favicon',
            'Apple Touch Icon' => 'Apple Touch Icon',
            'Contact Section Title' => 'Contact',
            'Contact Description' => 'Have questions or need assistance? and To hire me! I’d love to hear from you! please send your message by filling this form below.',
            'Address' => 'Address',
            'Address Value' => 'Addis Ababa, Ethiopia',
            'Call Us' => 'Call Us',
            'Email Us' => 'Email Us',
            'Your Name' => 'Your Name',
            'Your Email' => 'Your Email',
            'Subject' => 'Subject',
            'Message' => 'Message',
            'Send Message' => 'Send Message',
            'Loading' => 'Loading',
            'Invalid CSRF Token' => 'Invalid CSRF token. Please refresh the page and try again.',
            'All Fields Required' => 'All fields are required.',
            'Invalid Email Format' => 'Invalid email format.',
            'Database Connection Failed' => 'Database connection failed. Please try again later.',
            'Database Table Missing' => 'Database table form_data does not exist',
            'Database Prepare Failed' => 'Database prepare failed',
            'Message Saved Email Failed' => 'Message saved, but email could not be sent.',
            'Message Saved Email Disabled' => 'Message saved, but email sending is disabled.',
            'Message Sent Successfully' => 'Message sent successfully! A confirmation email has been sent.',
            'Failed to Save Message' => 'Failed to save message. Please try again.',
            'Server Error' => 'Server error: ',
            'Email Subject' => 'New Contact Form Submission: ',
            'Email Body' => "<h2>New Contact Form Submission</h2><p><strong>Name:</strong> %s</p><p><strong>Email:</strong> %s</p><p><strong>Subject:</strong> %s</p><p><strong>Message:</strong> %s</p>",
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Contact - Abebe' => 'ይደውሉ - አበበ',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Login' => 'ይግቡ',
            'Language' => 'ቋንቋ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Favicon' => 'ፋቪኮን',
            'Apple Touch Icon' => 'አፕል ታች አይኮን',
            'Contact Section Title' => 'ይደውሉ',
            'Contact Description' => 'ጥያቄዎች አሉዎት ወይም እርዳታ ይፈልጋሉ? እና እኔን ለመቅጠር! ከእርስዎ መስማት እፈልጋለሁ! እባክዎ ይህን ቅጽ በመሙላት መልእክትዎን ይላኩ።',
            'Address' => 'አድራሻ',
            'Address Value' => 'አዲስ አበባ፣ ኢትዮጵያ',
            'Call Us' => 'ይደውሉልን',
            'Email Us' => 'ኢሜይል ያድርጉልን',
            'Your Name' => 'የእርስዎ ስም',
            'Your Email' => 'የእርስዎ ኢሜይል',
            'Subject' => 'ርዕሰ ጉዳይ',
            'Message' => 'መልእክት',
            'Send Message' => 'መልእክት ላክ',
            'Loading' => 'በመጫን ላይ',
            'Invalid CSRF Token' => 'የማይሰራ ሲኤስአርኤፍ ቶከን። እባክዎ ገፁን ያድሱ እና እንደገና ይሞክሩ።',
            'All Fields Required' => 'ሁሉም መስኮች ያስፈልጋሉ።',
            'Invalid Email Format' => 'የማይሰራ ኢሜይል ቅርጸት።',
            'Database Connection Failed' => 'የውሂብ ግንኙነት አልተሳካም። እባክዎ ቆይተው እንደገና ይሞክሩ።',
            'Database Table Missing' => 'የውሂብ ሠንጠረዥ form_data የለም',
            'Database Prepare Failed' => 'የውሂብ ዝግጅት አልተሳካም',
            'Message Saved Email Failed' => 'መልእክት ተቀምጧል፣ ግን ኢሜይል መላክ አልተቻለም።',
            'Message Saved Email Disabled' => 'መልእክት ተቀምጧል፣ ግን ኢሜይል መላክ ተሰናክሏል።',
            'Message Sent Successfully' => 'መልእክት በተሳካ ሁኔታ ተልኳል! የማረጋገጫ ኢሜይል ተልኳል።',
            'Failed to Save Message' => 'መልእክት መቆጠብ አልተሳካም። እባክዎ እንደገና ይሞክሩ።',
            'Server Error' => 'የሰርቨር ስህተት: ',
            'Email Subject' => 'አዲስ የእውቂያ ቅጽ ማስገባት: ',
            'Email Body' => "<h2>አዲስ የእውቂያ ቅጽ ማስገባት</h2><p><strong>ስም:</strong> %s</p><p><strong>ኢሜይል:</strong> %s</p><p><strong>ርዕሰ ጉዳይ:</strong> %s</p><p><strong>መልእክት:</strong> %s</p>",
            'Abebe Bihonegn Wondie' => 'አበበ ቢሆነኝ ወንዴ'
        ],
        'af' => [
            'Contact - Abebe' => 'Maqaa - Abebe',
            'Abebe' => 'Abebe',
            'Home' => 'Mana',
            'About' => 'Waa\'ee',
            'Resume' => 'Gabaasa',
            'Portfolio' => 'Phootofolii',
            'Contact' => 'Maqaa',
            'Register' => 'Galmee',
            'Login' => 'Seenu',
            'Language' => 'Afaan',
            'Copyright' => 'Mirgoota',
            'All Rights Reserved' => 'Mirgoota Hunda Qaba',
            'Favicon' => 'Favicon',
            'Apple Touch Icon' => 'Apple Touch Icon',
            'Contact Section Title' => 'Maqaa',
            'Contact Description' => 'Gaaffii qabduu ykn deeggarsa barbaadduu? fi Naan bituu! Isin irraa dhagahuuf jaalladha! mee foorumii armaan gadii guutuudhaan ergaa keessan ergaa.',
            'Address' => 'Teessoo',
            'Address Value' => 'Addis Ababa, Itoophiyaa',
            'Call Us' => 'Nuuf Bilbili',
            'Email Us' => 'Nuuf Imeelii',
            'Your Name' => 'Maqaa Keessan',
            'Your Email' => 'Imeelii Keessan',
            'Subject' => 'Mata Duree',
            'Message' => 'Ergaa',
            'Send Message' => 'Ergaa Ergi',
            'Loading' => 'Fe\'amaa jira',
            'Invalid CSRF Token' => 'Tookanii CSRF toltuu miti. Maaloo fuula haaromsaa fi irra deebi\'aa yaalaa.',
            'All Fields Required' => 'Dirreewwan hundi barbaachisu.',
            'Invalid Email Format' => 'Formaatti imeelii toltuu miti.',
            'Database Connection Failed' => 'Walqabateen deetaa dadhabde. Maaloo yeroo biraa yaalaa.',
            'Database Table Missing' => 'Gabatee deetaa form_data hin jiru',
            'Database Prepare Failed' => 'Qophiin deetaa dadhabde',
            'Message Saved Email Failed' => 'Ergaa qabame, garuu imeelii erguu hin dandeenye.',
            'Message Saved Email Disabled' => 'Ergaa qabame, garuu erguun imeelii cufameera.',
            'Message Sent Successfully' => 'Ergaa milkiidhaan ergamte! Imeelii mirkaneeffannaa ergameera.',
            'Failed to Save Message' => 'Ergaa qabachuu hin dandeenye. Maaloo irra deebi\'aa yaalaa.',
            'Server Error' => 'Dogoggora sarvaraa: ',
            'Email Subject' => 'Galmee Foorumii Maqaa Haaraa: ',
            'Email Body' => "<h2>Galmee Foorumii Maqaa Haaraa</h2><p><strong>Maqaa:</strong> %s</p><p><strong>Imeelii:</strong> %s</p><p><strong>Mata Duree:</strong> %s</p><p><strong>Ergaa:</strong> %s</p>",
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'ti' => [
            'Contact - Abebe' => 'ይደውሉ - አበበ',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Login' => 'ይግቡ',
            'Language' => 'ቋንቋ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Favicon' => 'ፋቪኮን',
            'Apple Touch Icon' => 'አፕል ታች አይኮን',
            'Contact Section Title' => 'ይደውሉ',
            'Contact Description' => 'ጥያቄታት ኣለኹም ወይ ደገፍ የድልዩ፧ እና ንኣይ ንምቕጻል! ካብኩም ንምስማዕ ባህሪ ኣለኒ! በጃኹም ነዚ ቅጺ ብምምላእ መልእኽትኹም ስደዱ።',
            'Address' => 'ኣድራሻ',
            'Address Value' => 'ኣዲስ ኣበባ፣ ኢትዮጵያ',
            'Call Us' => 'ደውሉልና',
            'Email Us' => 'ኢመይል ግበሩልና',
            'Your Name' => 'ስምኩም',
            'Your Email' => 'ኢመይልኩም',
            'Subject' => 'ርእሰ ጉዳይ',
            'Message' => 'መልእኽቲ',
            'Send Message' => 'መልእኽቲ ላኣኽ',
            'Loading' => 'ይጽዕን ኣሎ',
            'Invalid CSRF Token' => 'ዘይሰርሕ ሲኤስአርኤፍ ቶከን። በጃኹም ገፁ ኣሓድሱ እና ዳግማይ ፈትኑ።',
            'All Fields Required' => 'ኩሉ መስኮታት የድልዩ።',
            'Invalid Email Format' => 'ዘይሰርሕ ኢመይል ቅርፂ።',
            'Database Connection Failed' => 'ናይ ዳታቤዝ ምትንኻፍ ኣይሰርሐን። በጃኹም ጸኒሕኩም ዳግማይ ፈትኑ።',
            'Database Table Missing' => 'ናይ ዳታቤዝ ሰንጠረዥ form_data የለን',
            'Database Prepare Failed' => 'ናይ ዳታቤዝ ምድላው ኣይሰርሐን',
            'Message Saved Email Failed' => 'መልእኽቲ ተቐምጠ፣ ግን ኢመይል ክልኣኽ ኣይተኻእለን።',
            'Message Saved Email Disabled' => 'መልእኽቲ ተቐምጠ፣ ግን ኢመይል ምልኣኽ ተኸልኪሉ ኣሎ።',
            'Message Sent Successfully' => 'መልእኽቲ ብዓወት ተላኢኹ! ናይ ምርግጋፂ ኢመይል ተላኢኹ ኣሎ።',
            'Failed to Save Message' => 'መልእኽቲ ምቕመጥ ኣይሰርሐን። በጃኹም ዳግማይ ፈትኑ።',
            'Server Error' => 'ናይ ሰርቨር ጌጋ: ',
            'Email Subject' => 'ኣዲስ ናይ እውቅያ ቅጺ ምሃብ: ',
            'Email Body' => "<h2>ኣዲስ ናይ እውቅያ ቅጺ ምሃብ</h2><p><strong>ስም:</strong> %s</p><p><strong>ኢመይል:</strong> %s</p><p><strong>ርእሰ ጉዳይ:</strong> %s</p><p><strong>መልእኽቲ:</strong> %s</p>",
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ]
    ];
    return $translations[$lang][$text] ?? $text;
}

// Initialize response
$response = ['success' => false, 'message' => ''];

try {
    // Load dependencies
    $autoload_path = 'vendor/autoload.php';
    $phpmailer_available = false;
    if (file_exists($autoload_path)) {
        require $autoload_path;
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $phpmailer_available = true;
            error_log("Contact.php - PHPMailer loaded successfully");
        } else {
            error_log("Contact.php - PHPMailer class not found");
        }
    } else {
        error_log("Contact.php - Autoload file not found: $autoload_path");
    }

    if (!file_exists('config.php')) {
        error_log("Contact.php - config.php not found");
        throw new Exception(translate('Server Error', $lang) . 'Configuration file missing');
    }
    require 'config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $response['message'] = translate('Invalid CSRF Token', $lang);
        } else {
            // Input validation
            $name = filter_var(trim($_POST['name'] ?? ''), FILTER_SANITIZE_STRING);
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
            $subject = filter_var(trim($_POST['subject'] ?? ''), FILTER_SANITIZE_STRING);
            $message = filter_var(trim($_POST['message'] ?? ''), FILTER_SANITIZE_STRING);

            // Validate inputs
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $response['message'] = translate('All Fields Required', $lang);
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = translate('Invalid Email Format', $lang);
            } else {
                // Database connection
                $conn = new mysqli(DB_CONFIG['servername'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['database']);
                if ($conn->connect_error) {
                    error_log("Contact.php - Connection failed: " . $conn->connect_error);
                    $response['message'] = translate('Database Connection Failed', $lang);
                } else {
                    // Verify table
                    $result = $conn->query("SHOW TABLES LIKE 'form_data'");
                    if ($result->num_rows === 0) {
                        error_log("Contact.php - Table form_data does not exist");
                        throw new Exception(translate('Database Table Missing', $lang));
                    }

                    // Insert form data
                    $stmt = $conn->prepare("INSERT INTO form_data (name, email, subject, message) VALUES (?, ?, ?, ?)");
                    if (!$stmt) {
                        error_log("Contact.php - Prepare failed: " . $conn->error);
                        throw new Exception(translate('Database Prepare Failed', $lang));
                    }
                    $stmt->bind_param("ssss", $name, $email, $subject, $message);
                    if ($stmt->execute()) {
                        // Regenerate CSRF token
                        try {
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        } catch (Exception $e) {
                            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
                        }

                        // Send email if PHPMailer is available
                        if ($phpmailer_available) {
                            try {
                                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                                $mail->SMTPDebug = 2;
                                $mail->Debugoutput = function($str, $level) {
                                    error_log("Contact.php - PHPMailer: $str");
                                };
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = true;
                                $mail->Username = SMTP_USERNAME;
                                $mail->Password = SMTP_PASSWORD;
                                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port = 587;
                                $mail->setFrom(SMTP_USERNAME, translate('Abebe', $lang) . ' Contact Form');
                                $mail->addAddress('bihonegnabebe9@gmail.com', translate('Abebe Bihonegn Wondie', $lang));
                                $mail->addReplyTo($email, $name);
                                $mail->isHTML(true);
                                $mail->Subject = translate('Email Subject', $lang) . $subject;
                                $mail->Body = sprintf(translate('Email Body', $lang), htmlspecialchars($name), htmlspecialchars($email), htmlspecialchars($subject), htmlspecialchars($message));
                                $mail->send();
                                error_log("Contact.php - Email sent successfully");
                                $response['success'] = true;
                                $response['message'] = translate('Message Sent Successfully', $lang);
                            } catch (Exception $e) {
                                error_log("Contact.php - Email sending failed: " . $e->getMessage());
                                $response['success'] = true;
                                $response['message'] = translate('Message Saved Email Failed', $lang);
                            }
                        } else {
                            $response['success'] = true;
                            $response['message'] = translate('Message Saved Email Disabled', $lang);
                        }
                    } else {
                        error_log("Contact.php - Execute failed: " . $stmt->error);
                        $response['message'] = translate('Failed to Save Message', $lang);
                    }
                    $stmt->close();
                    $conn->close();
                }
            }
        }
    }
} catch (Exception $e) {
    error_log("Contact.php - Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    $response['message'] = translate('Server Error', $lang) . htmlspecialchars($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo $dir; ?>">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo translate('Contact - Abebe', $lang); ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="<?php echo APP_DOMAIN; ?>/contact.php?lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/contact.php?lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/contact.php?lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/contact.php?lang=ti" rel="alternate" hreflang="ti">
  <link href="assets/img/favicon.png" rel="icon" title="<?php echo translate('Favicon', $lang); ?>">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" title="<?php echo translate('Apple Touch Icon', $lang); ?>">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="contact-page">
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
          <li><a href="contact.php" class="active"><i class="bi bi-envelope" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Contact', $lang); ?></a></li>
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
    <section id="contact" class="contact section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Contact Section Title', $lang); ?></h2>
        <p><?php echo translate('Contact Description', $lang); ?></p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-5">
            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3><?php echo translate('Address', $lang); ?></h3>
                  <p><?php echo translate('Address Value', $lang); ?></p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3><?php echo translate('Call Us', $lang); ?></h3>
                  <p><a href="tel:+251930559597">+251 930 559 597</a></p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3><?php echo translate('Email Us', $lang); ?></h3>
                  <p><a href="mailto:bihonegnabebe9@gmail.com">bihonegnabebe9@gmail.com</a></p>
                </div>
              </div>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126115.05952752134!2d38.69574337363253!3d8.963337304193292!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85cef5ab402d%3A0x8467b6b037a24d49!2sAddis%20Ababa!5e0!3m2!1sen!2set!4v1747223974158!5m2!1sen!2set" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
          <div class="col-lg-7">
            <form action="contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
              <?php if (!empty($response['message'])): ?>
                <div class="message <?php echo $response['success'] ? 'sent-message' : 'error-message'; ?>" style="display: block;">
                  <?php echo htmlspecialchars($response['message']); ?>
                </div>
              <?php endif; ?>
              <div class="row gy-4">
                <div class="col-md-6">
                  <label for="name-field" class="pb-2"><?php echo translate('Your Name', $lang); ?></label>
                  <input type="text" name="name" id="name-field" class="form-control" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                <div class="col-md-6">
                  <label for="email-field" class="pb-2"><?php echo translate('Your Email', $lang); ?></label>
                  <input type="email" class="form-control" name="email" id="email-field" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                <div class="col-md-12">
                  <label for="subject-field" class="pb-2"><?php echo translate('Subject', $lang); ?></label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                </div>
                <div class="col-md-12">
                  <label for="message-field" class="pb-2"><?php echo translate('Message', $lang); ?></label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <div class="loading" style="display: none;"><?php echo translate('Loading', $lang); ?></div>
                  <button type="submit" name="submit"><?php echo translate('Send Message', $lang); ?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
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
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>