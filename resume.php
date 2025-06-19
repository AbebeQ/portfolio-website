<?php
// Start session
session_start();

// Set language from session or default to Amharic
$lang = $_SESSION['lang'] ?? 'am';
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $lang = $_GET['lang'];
}

// All languages use LTR direction
$dir = 'ltr';

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Resume - Abebe' => 'Resume - Abebe',
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
            'Resume Section Title' => 'Resume',
            'Resume Description' => 'Explore my educational background, professional experience, and certifications as a software engineer passionate about building innovative web solutions.',
            'Summary' => 'Summary',
            'Abebe Bihonegn Summary' => 'A dedicated Software Engineering graduate with expertise in web development, including PHP, JavaScript, and database management. Skilled in creating user-friendly applications and eager to contribute to innovative tech solutions.',
            'Address' => 'Addis Ababa, Ethiopia',
            'Phone' => '+251 930 559 597',
            'Email' => 'bihonegnabebe9@gmail.com',
            'Education' => 'Education',
            'BSc Software Engineering' => 'Bachelor of Science in Software Engineering',
            'Arba Minch University' => 'Arba Minch University, Arba Minch, Ethiopia',
            'Software Engineering Period' => '2019 - 2024',
            'Software Engineering Description' => 'Graduated with great achievement, completing courses in Web Design and Programming, Machine Learning, Software Testing, Data Structures, Cloud Computing, Entrepreneurship, and Critical Thinking.',
            'BSc Business Studies' => 'Bachelor of Science in Business Studies',
            'London Institute of Business Studies' => 'London Institute of Business Studies (Online)',
            'Business Studies Period' => '2022 - 2024',
            'Business Studies Description' => 'Completed an online degree in Business Studies, enhancing skills in management and entrepreneurship.',
            'Diploma Financial Accounting' => 'Diploma in Financial Accounting',
            'Alison' => 'Alison (Online)',
            'Financial Accounting Period' => '2024',
            'Financial Accounting Description' => 'Earned an online diploma in Financial Accounting from Alison.com, focusing on financial management principles.',
            'Professional Experience' => 'Professional Experience',
            'Freelance Web Developer' => 'Freelance Web Developer',
            'Freelance Period' => '2024 - Present',
            'Freelance Location' => 'Addis Ababa, Ethiopia',
            'Freelance Description' => '<ul><li>Developed a personal portfolio website using PHP, Bootstrap, and MySQL, implementing multilingual support and secure contact forms.</li><li>Designed responsive layouts for clients, ensuring cross-browser compatibility.</li><li>Integrated third-party APIs for enhanced functionality.</li></ul>',
            'Certifications' => 'Certifications',
            'Global Management Certification' => 'Global Management, Entrepreneurship and Innovation Advanced Program',
            'Global Management Institution' => 'Arizona State University, Thunderbird School of Global Management',
            'Global Management Date' => 'February 28, 2024',
            'Global Management Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Global Accounting Certification' => 'Global Accounting: Managing by the Numbers',
            'Global Accounting Date' => 'February 28, 2024',
            'Global Accounting Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Data Analytics Certification' => 'Data Analytics and Digital Transformation',
            'Data Analytics Date' => 'February 21, 2024',
            'Data Analytics Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Global Entrepreneurship Certification' => 'Global Entrepreneurship and Sustainable Business',
            'Global Entrepreneurship Date' => 'January 20, 2024',
            'Global Entrepreneurship Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Global Marketing Certification' => 'Global Marketing in a Digital Age',
            'Global Marketing Date' => 'January 31, 2024',
            'Global Marketing Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Global Leadership Certification' => 'Global Leadership and Personal Development',
            'Global Leadership Date' => 'January 8, 2024',
            'Global Leadership Description' => 'Earned as part of the Francis and Dionne Najafi 100 Million Learners Global Initiative.',
            'Dereja Academy Certification' => 'Dereja Academy Accelerator Program',
            'Dereja Academy Institution' => 'Dereja in partnership with Mastercard Foundation and Arba Minch University',
            'Dereja Academy Date' => '2023 - 2024',
            'Dereja Academy Description' => 'Completed a four-month program focused on professional development and entrepreneurship.',
            'Employability Skill Certification' => 'Employability Skill and Job Readiness',
            'Employability Skill Date' => '2023',
            'Employability Skill Description' => 'Completed training in partnership with Mastercard Foundation and Arba Minch University.',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Resume - Abebe' => 'የራሴ ዝርዝር - አበበ',
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
            'Resume Section Title' => 'የራሴ ዝርዝር',
            'Resume Description' => 'የትምህርት ታሪኬን፣ ሙያዊ ልምዶቼን እና የምስክር ወረቀቶቼን ለመፈተሽ እና ፈጠራ ያለው የድር መፍትሄዎችን ለመገንባት ያለኝን ፍላጎት ይመልከቱ።',
            'Summary' => 'ማጠቃለያ',
            'Abebe Bihonegn Summary' => 'በሶፍትዌር ኢንጂነሪንግ የተመረቀ ቁርጥ ያለ ባለሙያ ሲሆን በድር ገፅ ልማት፣ PHP፣ JavaScript እና የውሂብ ጎታ አስተዳደር ላይ እውቀት ያለው። ለተጠቃሚ ምቹ መተግበሪያዎችን በመፍጠር እና ለፈጠራ ቴክኖሎጂ መፍትሄዎች ለመዋጮ ዝግጁ ነው።',
            'Address' => 'አዲስ አበባ፣ ኢትዮጵያ',
            'Phone' => '+251 930 559 597',
            'Email' => 'bihonegnabebe9@gmail.com',
            'Education' => 'ትምህርት',
            'BSc Software Engineering' => 'የሳይንስ ባችለር በሶፍትዌር ኢንጂነሪንግ',
            'Arba Minch University' => 'አርባ ምንጭ ዩኒቨርሲቲ፣ አርባ ምንጭ፣ ኢትዮጵያ',
            'Software Engineering Period' => '2019 - 2024',
            'Software Engineering Description' => 'በታላቅ ስኬት ተመርቋል፣ በድር ገፅ ዲዛይንና ፕሮግራሚንግ፣ ማሽን ለርኒንግ፣ ሶፍትዌር ሙከራ፣ ዳታ መዋቅሮች፣ ክላውድ ኮምፒውቲንግ፣ ሥራ ፈጣሪነት እና ተግባቢ አስተሳሰብ ላይ ኮርሶችን ተምሯል።',
            'BSc Business Studies' => 'የሳይንስ ባችለር በቢዝነስ ጥናቶች',
            'London Institute of Business Studies' => 'ለንደን ኢንስቲትዩት ኦፍ ቢዝነስ ስተዲስ (ኦንላይን)',
            'Business Studies Period' => '2022 - 2024',
            'Business Studies Description' => 'በመስመር ላይ የቢዝነስ ጥናቶች ዲግሪ አጠናቋል፣ በአስተዳደር እና ሥራ ፈጣሪነት ላይ ችሎታዎችን አሻሽሏል።',
            'Diploma Financial Accounting' => 'ዲፕሎማ በፋይናንሺያል አካውንቲንግ',
            'Alison' => 'አሊሰን (ኦንላይን)',
            'Financial Accounting Period' => '2024',
            'Financial Accounting Description' => 'ከAlison.com በመስመር ላይ በፋይናንሺያል አካውንቲንግ ዲፕሎማ ተቀብሏል፣ በፋይናንስ አስተዳደር መርሆዎች ላይ ትኩረት በማድረግ።',
            'Professional Experience' => 'ሙያዊ ልምድ',
            'Freelance Web Developer' => 'ነፃ የድር ገፅ ገንቢ',
            'Freelance Period' => '2024 - አሁን',
            'Freelance Location' => 'አዲስ አበባ፣ ኢትዮጵያ',
            'Freelance Description' => '<ul><li>PHP፣ Bootstrap እና MySQLን በመጠቀም የግል ፖርትፎሊዮ ድር ገፅ ገንብቷል፣ ባለብዙ ቋንቋ ድጋፍ እና ደህንነቱ የተጠበቀ የእውቂያ ቅጾችን ተግባራዊ አድርጓል።</li><li>ለደንበኞች ምላሽ ሰጪ አቀማመጦችን ነድፏል፣ ተሻጋሪ የተጠቃሚ መዳረሻን በማረጋገጥ።</li><li>ለተሻሻለ ተግባር የሶስተኛ ወገን ኤፒአይዎችን አካቷል።</li></ul>',
            'Certifications' => 'ምስክር ወረቀቶች',
            'Global Management Certification' => 'ዓለም ለኸ ምሕደራ፣ ሥራ ፈጣሪነትና ፈጠራ ዝለመደ ፕሮግራም',
            'Global Management Institution' => 'ኣሪዞና ስቴት ዩኒቨርሲቲ፣ ትሕንደርበርድ ትምህርቲ ቤት ናይ ዓለም ለኸ ምሕደራ',
            'Global Management Date' => 'ፌብሩዋሪ 28, 2024',
            'Global Management Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Global Accounting Certification' => 'ዓለም ለኸ ኣካውንቲንግ፡ ብቁጽሪ ምሕደራ',
            'Global Accounting Date' => 'ፌብሩዋሪ 28, 2024',
            'Global Accounting Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Data Analytics Certification' => 'ዳታ ኣናሊቲክስን ዲጂታል ትራንስፎርሜሽንን',
            'Data Analytics Date' => 'ፌብሩዋሪ 21, 2024',
            'Data Analytics Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Global Entrepreneurship Certification' => 'ዓለም ለኸ ሥራ ፈጣሪነትን ቀጻልነት ዘለዎ ቢዝነስን',
            'Global Entrepreneurship Date' => 'ጃንዋሪ 20, 2024',
            'Global Entrepreneurship Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Global Marketing Certification' => 'ዓለም ለኸ ማርኬቲንግ ኣብ ዲጂታል ዘመን',
            'Global Marketing Date' => 'ጃንዋሪ 31, 2024',
            'Global Marketing Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Global Leadership Certification' => 'ዓለም ለኸ መሪሕነትን ውልቃዊ ምዕባለን',
            'Global Leadership Date' => 'ጃንዋሪ 8, 2024',
            'Global Leadership Description' => 'ከፍራንሲስን ዲዮንን ናጃፊ 100 ሚሊዮን ተማሃሮ ዓለም ለኸ ተበግሶ ከፍቲ ተቐባልኩ።',
            'Dereja Academy Certification' => 'ደረጃ ኣካዳሚ ኣክሰለሬተር ፕሮግራም',
            'Dereja Academy Institution' => 'ደረጃ ምስ ማስተርካርድ ፋውንዴሽንን ኣርባ ምንጭ ዩኒቨርሲቲን ብምትሕብራኽ',
            'Dereja Academy Date' => '2023 - 2024',
            'Dereja Academy Description' => 'ኣብ ሞያዊ ምዕባለን ሥራ ፈጣሪነትን ዝተመርከዘ ናይ ኣርባዕተ ወርሒ ፕሮግራም ፈጺሙ።',
            'Employability Skill Certification' => 'ብቕዓት ስራሕን ዝግጅነት ስራሕን',
            'Employability Skill Date' => '2023',
            'Employability Skill Description' => 'ምስ ማስተርካርድ ፋውንዴሽንን ኣርባ ምንጭ ዩኒቨርሲቲን ብምትሕብራኽ ተማሂሩ።',
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ]
    ];
    return $translations[$lang][$text] ?? $text;
}

require 'config.php';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo $dir; ?>">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo translate('Resume - Abebe', $lang); ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="<?php echo APP_DOMAIN; ?>/resume.php?lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/resume.php?lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/resume.php?lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/resume.php?lang=ti" rel="alternate" hreflang="ti">
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
  <!-- =======================================================
  * Developer Name: Abebe Bihonegn
  * Updated: May 13 2025 with Bootstrap v5.3.3
  * Author: Abebe
  ======================================================== -->
</head>
<body class="resume-page">
  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename"><?php echo translate('Abebe', $lang); ?></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php"><i class="bi bi-house" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Home', $lang); ?></a></li>
          <li><a href="about.php"><i class="bi bi-info-circle" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('About', $lang); ?></a></li>
          <li><a href="resume.php" class="active"><i class="bi bi-file-earmark-text" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Resume', $lang); ?></a></li>
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
    <section id="resume" class="resume section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Resume Section Title', $lang); ?></h2>
        <p><?php echo translate('Resume Description', $lang); ?></p>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="resume-title"><?php echo translate('Summary', $lang); ?></h3>
            <div class="resume-item pb-0">
              <h4><?php echo translate('Abebe Bihonegn Wondie', $lang); ?></h4>
              <p><em><?php echo translate('Abebe Bihonegn Summary', $lang); ?></em></p>
              <ul>
                <li><?php echo translate('Address', $lang); ?></li>
                <li><?php echo translate('Phone', $lang); ?></li>
                <li><?php echo translate('Email', $lang); ?></li>
              </ul>
            </div>
            <h3 class="resume-title"><?php echo translate('Education', $lang); ?></h3>
            <div class="resume-item">
              <h4><?php echo translate('BSc Software Engineering', $lang); ?></h4>
              <h5><?php echo translate('Software Engineering Period', $lang); ?></h5>
              <p><em><?php echo translate('Arba Minch University', $lang); ?></em></p>
              <p><?php echo translate('Software Engineering Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('BSc Business Studies', $lang); ?></h4>
              <h5><?php echo translate('Business Studies Period', $lang); ?></h5>
              <p><em><?php echo translate('London Institute of Business Studies', $lang); ?></em></p>
              <p><?php echo translate('Business Studies Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Diploma Financial Accounting', $lang); ?></h4>
              <h5><?php echo translate('Financial Accounting Period', $lang); ?></h5>
              <p><em><?php echo translate('Alison', $lang); ?></em></p>
              <p><?php echo translate('Financial Accounting Description', $lang); ?></p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="resume-title"><?php echo translate('Professional Experience', $lang); ?></h3>
            <div class="resume-item">
              <h4><?php echo translate('Freelance Web Developer', $lang); ?></h4>
              <h5><?php echo translate('Freelance Period', $lang); ?></h5>
              <p><em><?php echo translate('Freelance Location', $lang); ?></em></p>
              <?php echo translate('Freelance Description', $lang); ?>
            </div>
            <h3 class="resume-title"><?php echo translate('Certifications', $lang); ?></h3>
            <div class="resume-item">
              <h4><?php echo translate('Global Management Certification', $lang); ?></h4>
              <h5><?php echo translate('Global Management Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Global Management Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Global Accounting Certification', $lang); ?></h4>
              <h5><?php echo translate('Global Accounting Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Global Accounting Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Data Analytics Certification', $lang); ?></h4>
              <h5><?php echo translate('Data Analytics Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Data Analytics Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Global Marketing Certification', $lang); ?></h4>
              <h5><?php echo translate('Global Marketing Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Global Marketing Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Global Entrepreneurship Certification', $lang); ?></h4>
              <h5><?php echo translate('Global Entrepreneurship Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Global Entrepreneurship Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Global Leadership Certification', $lang); ?></h4>
              <h5><?php echo translate('Global Leadership Date', $lang); ?></h5>
              <p><em><?php echo translate('Global Management Institution', $lang); ?></em></p>
              <p><?php echo translate('Global Leadership Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Dereja Academy Certification', $lang); ?></h4>
              <h5><?php echo translate('Dereja Academy Date', $lang); ?></h5>
              <p><em><?php echo translate('Dereja Academy Institution', $lang); ?></em></p>
              <p><?php echo translate('Dereja Academy Description', $lang); ?></p>
            </div>
            <div class="resume-item">
              <h4><?php echo translate('Employability Skill Certification', $lang); ?></h4>
              <h5><?php echo translate('Employability Skill Date', $lang); ?></h5>
              <p><em><?php echo translate('Dereja Academy Institution', $lang); ?></em></p>
              <p><?php echo translate('Employability Skill Description', $lang); ?></p>
            </div>
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
  <script src="assets/vendor/php-email-form/validate.js"></script>
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