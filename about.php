<?php
session_start();
require_once 'config.php';

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
            'About - Abebe' => 'About - Abebe',
            'Abebe' => 'Abebe',
            'Home' => 'Home',
            'About' => 'About',
            'Resume' => 'Resume',
            'Portfolio' => 'Portfolio',
            'Contact' => 'Contact',
            'Register' => 'Register',
            'Login' => 'Login',
            'Language' => 'Language',
            'About Me' => 'About Me',
            'Copyright' => 'Copyright',
            'All Rights Reserved' => 'All Rights Reserved',
            'Favicon' => 'Favicon',
            'Apple Touch Icon' => 'Apple Touch Icon',
            'Mobile App & Web Developer' => 'Mobile App & Web Developer.',
            'Hi, I am Abebe Bihonegn' => 'Hi, I am Abebe Bihonegn👋 I\'m a software developer engineer who has a passion to build and ship stuff.',
            'Birthdate' => 'Birthdate:',
            'Website' => 'Website:',
            'Phone' => 'Phone:',
            'City' => 'City:',
            'Age' => 'Age:',
            'Degree' => 'Degree:',
            'Email' => 'Email:',
            'Graduated' => 'I graduated with a BSc in Software Engineering from Arba Minch University, where I achieved a CGPA of 3.75.',
            'Code Quote' => '“Code is like humor. When you have to explain it, it’s bad.” Cory House',
            'Skills' => 'Skills',
            'I have the following skills' => 'I have the following skills:',
            'HTML' => 'HTML: 🌐',
            'CSS' => 'CSS: 🎨',
            'JavaScript' => 'JavaScript (JS): 📜',
            'Java' => 'Java: ☕️',
            'SQL' => 'SQL: 🗄️',
            'Cisco' => 'Cisco: 🖧',
            'Canva' => 'Canva: 🖌️',
            'PHP' => 'PHP: 🔧',
            'C++' => 'C++: ⚙️',
            'UI/UX' => 'UI/UX: 📐',
            'C#' => 'C#: 🖥️',
            'Photoshop' => 'Photoshop: 🖼️',
            'Dart' => 'Dart: 🎯',
            'Python' => 'Python: 🐍',
            'Facts' => 'Facts',
            'Facts Description' => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
            'Clients' => 'Clients',
            'Projects' => 'Projects',
            'Hours Of Support' => 'Hours Of Support',
            'Workers' => 'Workers',
            'Testimonials' => 'Testimonials',
            'Testimonials Description' => 'Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit',
            'Testimonial 1' => 'Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.',
            'Testimonial 2' => 'Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.',
            'Testimonial 3' => 'Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.',
            'Testimonial 4' => 'Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.',
            'Testimonial 5' => 'Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.'
        ],
        'am' => [
            'About - Abebe' => 'ስለ - አበበ',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Login' => 'ይግቡ',
            'Language' => 'ቋንቋ',
            'About Me' => 'ስለ እኔ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Favicon' => 'ፋቪኮን',
            'Apple Touch Icon' => 'አፕል ታች አይኮን',
            'Mobile App & Web Developer' => 'የሞባይል እቃ እና ድህረ ገጽ አስተናጋጅ.',
            'Hi, I am Abebe Bihonegn' => 'ሰላም እኔ አበበ ቢሆኔኝ ነኝ👋 እኔ የሶፍትዌር ገንቢ መሀንዲስ ነኝ ነገሮችን ለመስራት እና የመላክ ፍላጎት አለኝ።',
            'Birthdate' => 'የምርት ቀን:',
            'Website' => 'ድህረ ገጽ:',
            'Phone' => 'ስልክ:',
            'City' => 'ከተማ:',
            'Age' => 'ዕድሜ:',
            'Degree' => 'ዲግሪ:',
            'Email' => 'ኢሜይል:',
            'Graduated' => 'እኔ ከአርባ ምንች ዩኒቨርስቲ የሶፍትዌር ዲግሪ በ3.75 አበል ደረጃ ተመርቻለሁ.',
            'Code Quote' => '“ኮድ እንደ ድምፅ ነው። እንደ ለመግለጽ ይዘዋል።” ኮሪ ሃውስ',
            'Skills' => 'እውነታዎች',
            'I have the following skills' => 'እኔ እነዚህን እውነታዎች አለኝ:',
            'HTML' => 'HTML: 🌐',
            'CSS' => 'CSS: 🎨',
            'JavaScript' => 'JavaScript (JS): 📜',
            'Java' => 'Java: ☕️',
            'SQL' => 'SQL: 🗄️',
            'Cisco' => 'Cisco: 🖧',
            'Canva' => 'Canva: 🖌️',
            'PHP' => 'PHP: 🔧',
            'C++' => 'C++: ⚙️',
            'UI/UX' => 'UI/UX: 📐',
            'C#' => 'C#: 🖥️',
            'Photoshop' => 'Photoshop: 🖼️',
            'Dart' => 'Dart: 🎯',
            'Python' => 'Python: 🐍',
            'Facts' => 'እውነታዎች',
            'Facts Description' => 'አስፈላጊ ነገሮች እሱ ከነበረው መውጣት እና በእርግጥ በተለመደ መጠን ያለውን ማየት',
            'Clients' => 'ደንበኞች',
            'Projects' => 'ፕሮጀክቶች',
            'Hours Of Support' => 'የድጋፍ ሰዓቶች',
            'Workers' => 'ሰራተኞች',
            'Testimonials' => 'ምስክርነቶች',
            'Testimonials Description' => 'አስፈላጊ ነገሮች እሱ ከነበረው መውጣት እና በእርግጥ በተለመደ መጠን ያለውን ማየት',
            'Testimonial 1' => 'ፕሮኢን ኢያኩሊስ ፑሩስ ኮንሴኳት ሴም ኩሬ ዲግኒ ሲም ዶኔክ ፖርቲቶራ ኤንቱም ሱብሲፒት ሮንኩስ። አኩሳንቲየም ኳም፣ ኡልትሪሲየስ ኤገት ኢድ፣ አልኳም ኤገት ኒብ ኤት። ማኤሴን አልኳም፣ ሪሱስ አት ሴምፐር።',
            'Testimonial 2' => 'ኤክስፖርት ተምፖር ኢሉም ታመን ማሊስ ማሊስ ኤራም ኳኤ ኢሩሬ ኤሴ ላቦሬ ኳም ሲሉም ኳድ ሲሉም ኤራም ማሊስ ኳሮም ቬሊት ፎሬ ኤራም ቬሊት ሱንት አልኳ ኖስተር ፊጂያት ኢሩሬ አሜት ለጋም አኒም ኩልፓ።',
            'Testimonial 3' => 'ኤኒም ኒሲ ኳም ኤክስፖርት ዱይስ ላቦሬ ሲሉም ኳኤ ማግና ኤኒም ሲንት ኳሮም ኑላ ኳም ቬኒያም ዱይስ ሚኒም ተምፖር ላቦሬ ኳም ኤራም ዱይስ ኖስተር ኦተ አሜት ኤራም ፎሬ ኳይስ ሲንት ሚኒም።',
            'Testimonial 4' => 'ፉጂያት ኤኒም ኤራም ኳኤ ሲሉም ዶሎሬ ዶሎር አሜት ኑላ ኩልፓ ሙልቶስ ኤክስፖርት ሚኒም ፊጂያት ሚኒም ቬሊት ሚኒም ዶሎር ኤኒም ዱይስ ቬኒያም ኢፕሱም አኒም ማግና ሱንት ኤሊት ፎሬ ኳም ዶሎሬ ላቦሬ ኢሉም ቬኒያም።',
            'Testimonial 5' => 'ኳይስ ኳሮም አልኳ ሲንት ኳም ለጋም ፎሬ ሱንት ኤራም ኢሩሬ አልኳ ቬኒያም ተምፖር ኖስተር ቬኒያም ኤኒም ኩልፓ ላቦሬ ዱይስ ሱንት ኩልፓ ኑላ ኢሉም ሲሉም ፊጂያት ለጋም ኤሴ ቬኒያም ኩልፓ ፎሬ ኒሲ ሲሉም ኳይድ።'
        ],
        'af' => [
            'About - Abebe' => 'Waa\'ee - Abebe',
            'Abebe' => 'Abebe',
            'Home' => 'Mana',
            'About' => 'Waa\'ee',
            'Resume' => 'Gabaasa',
            'Portfolio' => 'Phootofolii',
            'Contact' => 'Maqaa',
            'Register' => 'Galmee',
            'Login' => 'Seenu',
            'Language' => 'Afaan',
            'About Me' => 'Ani Hunda',
            'Copyright' => 'Mirgoota',
            'All Rights Reserved' => 'Mirgoota Hunda Qaba',
            'Favicon' => 'Favicon',
            'Apple Touch Icon' => 'Apple Touch Icon',
            'Mobile App & Web Developer' => 'Hojjat Biiroo & Web Developer.',
            'Hi, I am Abebe Bihonegn' => 'Akkam, Ani Abebe Bihonegn👋 Ani software developer engineer kan fedhii ijaaruu fi erguuf fedhii qabudha.',
            'Birthdate' => 'Guyyaa Dhalootaa:',
            'Website' => 'Websayitii:',
            'Phone' => 'Bilbila:',
            'City' => 'Magala:',
            'Age' => 'Umuri:',
            'Degree' => 'Digirii:',
            'Email' => 'Imeelii:',
            'Graduated' => 'Ani BSc Software Engineering irraa Arba Minch University eega bu\'aa 3.75 argadhe.',
            'Code Quote' => '“Code is like humor. When you have to explain it, it’s bad.” Cory House',
            'Skills' => 'Ogummaa',
            'I have the following skills' => 'Ani ogummaa armaan gadi qabu:',
            'HTML' => 'HTML: 🌐',
            'CSS' => 'CSS: 🎨',
            'JavaScript' => 'JavaScript (JS): 📜',
            'Java' => 'Java: ☕️',
            'SQL' => 'SQL: 🗄️',
            'Cisco' => 'Cisco: 🖧',
            'Canva' => 'Canva: 🖌️',
            'PHP' => 'PHP: 🔧',
            'C++' => 'C++: ⚙️',
            'UI/UX' => 'UI/UX: 📐',
            'C#' => 'C#: 🖥️',
            'Photoshop' => 'Photoshop: 🖼️',
            'Dart' => 'Dart: 🎯',
            'Python' => 'Python: 🐍',
            'Facts' => 'Dhugaa',
            'Facts Description' => 'Qabeenya isaa fi alaa ba\'uuf deemuu kan danda\'u qabatee jira',
            'Clients' => 'Maamila',
            'Projects' => 'Pirojektoota',
            'Hours Of Support' => 'Sa\'aatii Deeggarsa',
            'Workers' => 'Hojjattoota',
            'Testimonials' => 'Ragaa',
            'Testimonials Description' => 'Qabeenya isaa fi alaa ba\'uuf deemuu kan danda\'u qabatee jira',
            'Testimonial 1' => 'Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.',
            'Testimonial 2' => 'Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.',
            'Testimonial 3' => 'Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.',
            'Testimonial 4' => 'Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.',
            'Testimonial 5' => 'Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.'
        ],
        'ti' => [
            'About - Abebe' => 'ስለ - አበበ',
            'Abebe' => 'አበበ',
            'Home' => 'መነሻ',
            'About' => 'ስለ',
            'Resume' => 'የራሴ ዝርዝር',
            'Portfolio' => 'ፖርትፎሊዮ',
            'Contact' => 'ይደውሉ',
            'Register' => 'መመዝገብ',
            'Login' => 'ይግቡ',
            'Language' => 'ቋንቋ',
            'About Me' => 'ስለ እኔ',
            'Copyright' => 'የቅጂ መብት',
            'All Rights Reserved' => 'ሁሉም መብቶች የተጠበቁ ናቸው',
            'Favicon' => 'ፋቪኮን',
            'Apple Touch Icon' => 'አፕል ታች አይኮን',
            'Mobile App & Web Developer' => 'የሞባይል እቃ እና ድህረ ገጽ አስተናጋጅ.',
            'Hi, I am Abebe Bihonegn' => 'ሰላም ኣነ ኣበበ ቢሆነኝ እየ👋 ኣነ ሶፍትዌር ዲቨሎፐር ኢንጂነር እየ ንብረት ናይ ምስራሕን ምልኣኽን ኒሕ ዘለኒ።',
            'Birthdate' => 'የምርት ቀን:',
            'Website' => 'ድህረ ገጽ:',
            'Phone' => 'ስልክ:',
            'City' => 'ከተማ:',
            'Age' => 'ዕድሜ:',
            'Degree' => 'ዲግሪ:',
            'Email' => 'ኢሜይል:',
            'Graduated' => 'እኔ ከአርባ ምንች ዩኒቨርስቲ የሶፍትዌር ዲግሪ በ3.75 አበል ደረጃ ተመርቻለሁ.',
            'Code Quote' => '“ኮድ እንደ ድምፅ ነው። እንደ ለመግለጽ ይዘዋል።” ኮሪ ሃውስ',
            'Skills' => 'እውነታዎች',
            'I have the following skills' => 'እኔ እነዚህን እውነታዎች አለኝ:',
            'HTML' => 'HTML: 🌐',
            'CSS' => 'CSS: 🎨',
            'JavaScript' => 'JavaScript (JS): 📜',
            'Java' => 'Java: ☕️',
            'SQL' => 'SQL: 🗄️',
            'Cisco' => 'Cisco: 🖧',
            'Canva' => 'Canva: 🖌️',
            'PHP' => 'PHP: 🔧',
            'C++' => 'C++: ⚙️',
            'UI/UX' => 'UI/UX: 📐',
            'C#' => 'C#: 🖥️',
            'Photoshop' => 'Photoshop: 🖼️',
            'Dart' => 'Dart: 🎯',
            'Python' => 'Python: 🐍',
            'Facts' => 'እውነታዎች',
            'Facts Description' => 'አስፈላጊ ነገሮች እሱ ከነበረው መውጣት እና በእርግጥ በተለመደ መጠን ያለውን ማየት',
            'Clients' => 'ደንበኞች',
            'Projects' => 'ፕሮጀክቶች',
            'Hours Of Support' => 'የድጋፍ ሰዓቶች',
            'Workers' => 'ሰራተኞች',
            'Testimonials' => 'ምስክርነቶች',
            'Testimonials Description' => 'አስፈላጊ ነገሮች እሱ ከነበረው መውጣት እና በእርግጥ በተለመደ መጠን ያለውን ማየት',
            'Testimonial 1' => 'ፕሮኢን ኢያኩሊስ ፑሩስ ኮንሴኳት ሴም ኩሬ ዲግኒ ሲም ዶኔክ ፖርቲቶራ ኤንቱም ሱብሲፒት ሮንኩስ። አኩሳንቲየም ኳም፣ ኡልትሪሲየስ ኤገት ኢድ፣ አልኳም ኤገት ኒብ ኤት። ማኤሴን አልኳም፣ ሪሱስ አት ሴምፐር።',
            'Testimonial 2' => 'ኤክስፖርት ተምፖር ኢሉም ታመን ማሊስ ማሊስ ኤራም ኳኤ ኢሩሬ ኤሴ ላቦሬ ኳም ሲሉም ኳድ ሲሉም ኤራም ማሊስ ኳሮም ቬሊት ፎሬ ኤራም ቬሊት ሱንት አልኳ ኖስተር ፊጂያት ኢሩሬ አሜት ለጋም አኒም ኩልፓ።',
            'Testimonial 3' => 'ኤኒም ኒሲ ኳም ኤክስፖርት ዱይስ ላቦሬ ሲሉም ኳኤ ማግና ኤኒም ሲንት ኳሮም ኑላ ኳም ቬኒያም ዱይስ ሚኒም ተምፖር ላቦሬ ኳም ኤራም ዱይስ ኖስተር ኦተ አሜት ኤራም ፎሬ ኳይስ ሲንት ሚኒም።',
            'Testimonial 4' => 'ፉጂያት ኤኒም ኤራም ኳኤ ሲሉም ዶሎሬ ዶሎር አሜት ኑላ ኩልፓ ሙልቶስ ኤክስፖርት ሚኒም ፊጂያት ሚኒም ቬ�لیት ሚኒም ዶሎር ኤኒም ዱይስ ቬኒያም ኢፕሱም አኒም ማግና ሱንት ኤሊት ፎሬ ኳም ዶሎሬ ላቦሬ ኢሉም ቬኒያም።',
            'Testimonial 5' => 'ኳይስ ኳሮም አልኳ ሲንት ኳም ለጋም ፎሬ ሱንት ኤራም ኢሩሬ አልኳ ቬኒያም ተምፖር ኖስተር ቬኒያም ኤኒም ኩልፓ ላቦሬ ዱይስ ሱንት ኩልፓ ኑላ ኢሉም ሲሉም ፊጂያት ለጋም ኤሴ ቬኒያም ኩልፓ ፎሬ ኒሲ ሲሉም ኳይድ።'
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
  <title><?php echo translate('About - Abebe', $lang); ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <!-- Hreflang for SEO -->
  <link href="<?php echo APP_DOMAIN; ?>/about.php?lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/about.php?lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/about.php?lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/about.php?lang=ti" rel="alternate" hreflang="ti">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" title="<?php echo translate('Favicon', $lang); ?>">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" title="<?php echo translate('Apple Touch Icon', $lang); ?>">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- Vendor CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <!-- Main CSS -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="about-page">
  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename"><?php echo translate('Abebe', $lang); ?></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php"><i class="bi bi-house" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('Home', $lang); ?></a></li>
          <li><a href="about.php" class="active"><i class="bi bi-info-circle" style="margin-right: 5px; font-size: 1.2em;"></i> <?php echo translate('About', $lang); ?></a></li>
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
    <section id="about" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('About', $lang); ?></h2>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4">
            <img src="assets/img/abebe exercisebook.jpg" class="img-fluid" alt="<?php echo translate('Abebe', $lang); ?>">
          </div>
          <div class="col-lg-8 content">
            <h2><?php echo translate('Mobile App & Web Developer', $lang); ?></h2>
            <p class="fst-italic py-3"><?php echo translate('Hi, I am Abebe Bihonegn', $lang); ?></p>
            <div class="row">
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>🎂 <?php echo translate('Birthdate', $lang); ?></strong> <span>17 January 1999</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>🌐 <?php echo translate('Website', $lang); ?></strong> <span><a href="https://abebebihonegn.netlify.app">abebebihonegn.netlify.app</a></span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>📞 <?php echo translate('Phone', $lang); ?></strong> <span><a href="tel:+251930559597">+251 930 559 597</a></span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>🏙️ <?php echo translate('City', $lang); ?></strong> <span>Addis Ababa, Ethiopia🇪🇹🌍</span></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>🎈 <?php echo translate('Age', $lang); ?></strong> <span>25</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>🎓 <?php echo translate('Degree', $lang); ?></strong> <span>BSc. in Software Engineering</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>✉️ <?php echo translate('Email', $lang); ?></strong> <span><a href="mailto:bihonegnabebe9@gmail.com">bihonegnabebe9@gmail.com</a></span></li>
                </ul>
              </div>
            </div>
            <p class="py-3"><?php echo translate('Graduated', $lang); ?></p>
            <h4>🚀 💻<?php echo translate('Code Quote', $lang); ?></h4>
          </div>
        </div>
      </div>
    </section>
    <section id="skills" class="skills section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Skills', $lang); ?></h2>
        <p><?php echo translate('I have the following skills', $lang); ?></p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row skills-content skills-animation">
          <div class="col-lg-6">
            <div class="progress">
              <span class="skill"><span><?php echo translate('HTML', $lang); ?></span> <i class="val">100%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('CSS', $lang); ?></span> <i class="val">90%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('JavaScript', $lang); ?></span> <i class="val">75%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Java', $lang); ?></span> <i class="val">75%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('SQL', $lang); ?></span> <i class="val">80%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Cisco', $lang); ?></span> <i class="val">65%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Canva', $lang); ?></span> <i class="val">100%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="progress">
              <span class="skill"><span><?php echo translate('PHP', $lang); ?></span> <i class="val">80%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('C++', $lang); ?></span> <i class="val">90%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('UI/UX', $lang); ?></span> <i class="val">95%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('C#', $lang); ?></span> <i class="val">30%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Photoshop', $lang); ?></span> <i class="val">20%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Dart', $lang); ?></span> <i class="val">75%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="progress">
              <span class="skill"><span><?php echo translate('Python', $lang); ?></span> <i class="val">45%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="stats" class="stats section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Facts', $lang); ?></h2>
        <p><?php echo translate('Facts Description', $lang); ?></p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
              <p><?php echo translate('Clients', $lang); ?></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
              <p><?php echo translate('Projects', $lang); ?></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
              <p><?php echo translate('Hours Of Support', $lang); ?></p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
              <p><?php echo translate('Workers', $lang); ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="testimonials" class="testimonials section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Testimonials', $lang); ?></h2>
        <p><?php echo translate('Testimonials Description', $lang); ?></p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo & Founder</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span><?php echo translate('Testimonial 1', $lang); ?></span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span><?php echo translate('Testimonial 2', $lang); ?></span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span><?php echo translate('Testimonial 3', $lang); ?></span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span><?php echo translate('Testimonial 4', $lang); ?></span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span><?php echo translate('Testimonial 5', $lang); ?></span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
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