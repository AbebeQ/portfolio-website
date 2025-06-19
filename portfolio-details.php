<?php
// Start session
session_start();

// Set language from session or default to Amharic
$lang = $_SESSION['lang'] ?? 'am';
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    $lang = $_GET['lang'];
}

// Set direction based on language
$dir = in_array($lang, ['fa']) ? 'rtl' : 'ltr';

// Get project ID
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Project data
$projects = [
    1 => [
        'title_key' => 'Personal Portfolio Website',
        'description_key' => 'Portfolio Website Description',
        'image' => 'assets/img/portfolio/project-1.jpg',
        'details' => 'This project is a multilingual portfolio website showcasing my skills in web development. Built with PHP, Bootstrap, and MySQL, it features responsive design, secure contact forms, and session-based language switching.'
    ],
    2 => [
        'title_key' => 'Capstone Project',
        'description_key' => 'Capstone Project Description',
        'image' => 'assets/img/portfolio/project-2.jpg',
        'details' => 'A web-based portfolio management system developed as my final-year capstone project at Arba Minch University. It uses PHP and MySQL to manage dynamic content, with a focus on user-friendly interfaces.'
    ],
    3 => [
        'title_key' => 'Sample Mobile App',
        'description_key' => 'Mobile App Description',
        'image' => 'assets/img/portfolio/project-3.jpg',
        'details' => 'A mobile application developed during my Mobile Application Development course. Built with Java and Android Studio, it emphasizes intuitive user interfaces and efficient performance.'
    ],
    4 => [
        'title_key' => 'Database Project',
        'description_key' => 'Database Project Description',
        'image' => 'assets/img/portfolio/project-4.jpg',
        'details' => 'A student management system built with MySQL and PHP, designed to optimize data storage and retrieval. Developed as part of my Advanced Database Systems course.'
    ]
];

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Portfolio Details - Abebe' => 'Portfolio Details - Abebe',
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
            'Portfolio Details Title' => 'Portfolio Details',
            'Project Details' => 'Project Details',
            'Personal Portfolio Website' => 'Personal Portfolio Website',
            'Portfolio Website Description' => 'A multilingual portfolio website built with PHP, Bootstrap, and MySQL, featuring responsive design and secure contact forms.',
            'Capstone Project' => 'Capstone Project: Portfolio Management System',
            'Capstone Project Description' => 'A web-based portfolio management system developed as a final-year project, using PHP and MySQL for dynamic content management.',
            'Sample Mobile App' => 'Sample Mobile App',
            'Mobile App Description' => 'A mobile application developed during coursework, built with Java and Android Studio, focusing on user-friendly interfaces.',
            'Database Project' => 'Database Project: Student Management System',
            'Database Project Description' => 'A database-driven student management system built with MySQL and PHP, optimizing data storage and retrieval.',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Portfolio Details - Abebe' => 'የፖርትፎሊዮ ዝርዝሮች - አበበ',
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
            'Portfolio Details Title' => 'የፖርትፎሊዮ ዝርዝሮች',
            'Project Details' => 'የፕሮጀክት ዝርዝሮች',
            'Personal Portfolio Website' => 'የግል ፖርትፎሊዮ ድር ገፅ',
            'Portfolio Website Description' => 'PHP፣ Bootstrap እና MySQL በመጠቀም የተገነባ ባለብዙ ቋንቋ ፖርትፎሊዮ ድር ገፅ፣ ምላሽ ሰጪ ዲዛይን እና ደህንነቱ የተጠበቀ የእውቂያ ቅጾችን ያሳያል።',
            'Capstone Project' => 'የመጨረሻ ፕሮጀክት፡ የፖርትፎሊዮ አስተዳደር ስርዓት',
            'Capstone Project Description' => 'በመጨረሻ አመት ፕሮጀክት ሆኖ የተገነባ በድር ላይ የተመሰረተ የፖርትፎሊዮ አስተዳደር ስርዓት፣ PHP እና MySQL ለተለዋዋጭ ይዘት አስተዳደር ተጠቅሟል።',
            'Sample Mobile App' => 'የሞባይል መተግበሪያ ናሙና',
            'Mobile App Description' => 'በትምህርት ጊዜ የተገነባ ሞባይል መተግበሪያ፣ በጃቫ እና አንድሮይድ ስቱዲዮ የተሰራ፣ ለተጠቃሚ ምቹ በይነገፆች ላይ ትኩረት በማድረግ።',
            'Database Project' => 'የውሂብ ጎታ ፕሮጀክት፡ የተማሪ አስተዳደር ስርዓት',
            'Database Project Description' => 'MySQL እና PHP በመጠቀም የተገነባ በውሂብ ጎታ የሚመራ የተማሪ አስተዳደር ስርዓት፣ የውሂብ ማከማቻ እና መልሶ ማግኘትን በማመቻቸት።',
            'Abebe Bihonegn Wondie' => 'አበበ ቢሆነኝ ወንዴ'
        ],
        'af' => [
            'Portfolio Details - Abebe' => 'Waa\'ee Phootofolii - Abebe',
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
            'Portfolio Details Title' => 'Waa\'ee Phootofolii',
            'Project Details' => 'Waa\'ee Pirojeektii',
            'Personal Portfolio Website' => 'Weebii Phootofolii Dhuunfaa',
            'Portfolio Website Description' => 'Weebii phootofolii afaan hedduu qabu PHP, Bootstrap fi MySQL fayyadamuun ijaaramte, dizaayinii ribaansii fi foorumii qunnamtii amanaa qabu.',
            'Capstone Project' => 'Pirojeektii Xumuraa: Sirna Mijjeessaa Phootofolii',
            'Capstone Project Description' => 'Sirna mijjeessaa phootofolii weebii irratti hundaa’u bara xumuraa pirojeektii ta’ee ijaaramte, PHP fi MySQL fayyadamuun yoonteentii dabalataa mijjeessu.',
            'Sample Mobile App' => 'Naannoo Applikeeshinii Moobaayilii',
            'Mobile App Description' => 'Applikeeshinii moobaayilii yeroo barnootaa ijaaramte, Jaavaa fi Andirooyid Istuudiyoo fayyadamuun kan uumame, interfeeysii fayyadamtootaaf mijatu irratti xiyyeeffate.',
            'Database Project' => 'Pirojeektii Deetaa Biiznisii: Sirna Mijjeessaa Barataa',
            'Database Project Description' => 'Sirna mijjeessaa barataa deetaa biiznisii irratti hundaa’u MySQL fi PHP fayyadamuun ijaaramte, kuusaa deetaa fi deebisaa deetaa optimayize godhu.',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'ti' => [
            'Portfolio Details - Abebe' => 'ዝርዝር ፖርትፎሊዮ - ኣበበ',
            'Abebe' => 'ኣበበ',
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
            'Apple Touch Icon' => 'ኣፕል ታች ኣይኮን',
            'Portfolio Details Title' => 'ዝርዝር ፖርትፎሊዮ',
            'Project Details' => 'ዝርዝር ፕሮጀክቲ',
            'Personal Portfolio Website' => 'ውልቃዊ ፖርትፎሊዮ ወብ ሳይት',
            'Portfolio Website Description' => 'ብዙሕ ቛንቋታት ዘለዎ ፖርትፎሊዮ ወብ ሳይት ብPHP፣ Bootstrapን MySQLን ዝተሰርሐ፣ ምላሽ ዝህብ ዲዛይንን ውሕስነት ዘለዎ ቅጽ እውቅያን ዘለዎ።',
            'Capstone Project' => 'ፕሮጀክቲ መደብ መዛዘሚ፡ ስርዓት ምሕደራ ፖርትፎሊዮ',
            'Capstone Project Description' => 'ኣብ መወዳእታ ዓመት ከም ፕሮጀክቲ ዝተሰርሐ ብወብ ዝተመርከዘ ስርዓት ምሕደራ ፖርትፎሊዮ፣ PHPን MySQLን ተጠቒሙ ተለዋዋጢ ይዘት ንምሕደራ።',
            'Sample Mobile App' => 'መርኣዪ መተግበሪ ሞባይል',
            'Mobile App Description' => 'ኣብ መደብ ትምህርቲ ዝተሰርሐ መተግበሪ ሞባይል፣ ብጃቫን ኣንድሮይድ ስቱድዮን ዝተሰርሐ፣ ንተጠቀምቲ ምቹው በይነገፅ ላዕሊ ጌሩ።',
            'Database Project' => 'ፕሮጀክቲ ዳታቤዝ፡ ስርዓት ምሕደራ ተማሃሮ',
            'Database Project Description' => 'ብMySQLን PHPን ዝተሰርሐ ብዳታቤዝ ዝመርሕ ስርዓት ምሕደራ ተማሃሮ፣ ናይ ዳታ ምኽዛንን ምልስን ኣመቻቺዩ።',
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ],
        'fa' => [
            'Portfolio Details - Abebe' => 'جزئیات پورتفولیو - ابیبی',
            'Abebe' => 'ابیبی',
            'Home' => 'خانه',
            'About' => 'درباره',
            'Resume' => 'رزومه',
            'Portfolio' => 'پورتفولیو',
            'Contact' => 'تماس',
            'Register' => 'ثبت‌نام',
            'Login' => 'ورود',
            'Language' => 'زبان',
            'Copyright' => 'کپی‌رایت',
            'All Rights Reserved' => 'همه حقوق محفوظ است',
            'Favicon' => 'فاوآیکون',
            'Apple Touch Icon' => 'آیکون لمسی اپل',
            'Portfolio Details Title' => 'جزئیات پورتفولیو',
            'Project Details' => 'جزئیات پروژه',
            'Personal Portfolio Website' => 'وب‌سایت پورتفولیو شخصی',
            'Portfolio Website Description' => 'یک وب‌سایت پورتفولیو چندزبانه که با PHP، بوت‌استرپ و MySQL ساخته شده، دارای طراحی پاسخ‌گو و فرم‌های تماس امن.',
            'Capstone Project' => 'پروژه نهایی: سیستم مدیریت پورتفولیو',
            'Capstone Project Description' => 'یک سیستم مدیریت پورتفولیو مبتنی بر وب که به‌عنوان پروژه سال آخر توسعه یافته، با استفاده از PHP و MySQL برای مدیریت محتوای پویا.',
            'Sample Mobile App' => 'نمونه برنامه موبایل',
            'Mobile App Description' => 'یک برنامه موبایل که در طول دوره درسی توسعه یافته، با جاوا و اندروید استودیو ساخته شده، با تمرکز بر رابط‌های کاربرپسند.',
            'Database Project' => 'پروژه پایگاه داده: سیستم مدیریت دانشجو',
            'Database Project Description' => 'یک سیستم مدیریت دانشجو مبتنی بر پایگاه داده که با MySQL و PHP ساخته شده، بهینه‌سازی ذخیره و بازیابی داده‌ها.',
            'Abebe Bihonegn Wondie' => 'ابیبی بیهونگن وندی'
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
  <title><?php echo translate('Portfolio Details - Abebe', $lang); ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio-details.php?id=<?php echo $project_id; ?>&lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio-details.php?id=<?php echo $project_id; ?>&lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio-details.php?id=<?php echo $project_id; ?>&lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio-details.php?id=<?php echo $project_id; ?>&lang=ti" rel="alternate" hreflang="ti">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio-details.php?id=<?php echo $project_id; ?>&lang=fa" rel="alternate" hreflang="fa">
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
  <style>
    <?php if ($dir === 'rtl'): ?>
    body, h2, p, .portfolio-details h3 {
      text-align: right;
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
<body class="portfolio-details-page">
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
          <li><a href="portfolio.php" class="active"><i class="bi bi-images" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Portfolio', $lang); ?></a></li>
          <li><a href="contact.php"><i class="bi bi-envelope" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Contact', $lang); ?></a></li>
          <li>
            <button style="background-color: green; border: none; border-radius: 20px; padding: 10px 20px;">
              <a href="register.php" style="color: white; text-decoration: none;">
                <i class="bi bi-person-plus-fill" style="margin-right: 5px; font-size: 1.2em;"></i> <?