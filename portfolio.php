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

// Translation function
function translate($text, $lang) {
    $translations = [
        'en' => [
            'Portfolio - Abebe' => 'Portfolio - Abebe',
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
            'Portfolio Section Title' => 'Portfolio',
            'Portfolio Description' => 'Showcasing my software engineering projects from 2013-2016 E.C at Arba Minch University and an internship at Amhara Science & Technology, including desktop, web, mobile, and AI applications. As a UI/UX designer, I focused on user-centric design across all projects.',
            'Filter All' => 'All',
            'Filter Desktop' => 'Desktop',
            'Filter Web' => 'Web',
            'Filter Mobile' => 'Mobile',
            'Filter AI' => 'AI',
            'Cost Sharing Management System' => 'Cost Sharing Management System',
            'Cost Sharing Description' => 'Developed a system in C++ to manage cost sharing at Arba Minch University in 2013 E.C, showcasing proficiency in algorithmic thinking and low-level programming.',
            'Tour and Travel Management System' => 'Tour and Travel Management System',
            'Tour and Travel Description' => 'Created a web-based system using HTML, CSS, JS, and PHP for managing tours and travels at Arba Minch University in 2014 E.C, highlighting front-end and back-end development expertise. <a href="https://github.com/username/tour-and-travel-ethiopia">GitHub</a>',
            'Supermarket Billing System' => 'Supermarket Billing System',
            'Supermarket Billing Description' => 'Implemented a billing system in Java for a supermarket at Arba Minch University in 2015 E.C, demonstrating object-oriented programming skills. <a href="https://github.com/username/supermarket-billing-system-in-java">GitHub</a>',
            'Audio Book Application' => 'Audio Book Application for Visually Impaired',
            'Audio Book Description' => 'Developed an Android audio book application in Java during a 2015 E.C internship at Amhara Science & Technology, tailored for visually impaired students, emphasizing accessibility. <a href="https://github.com/username/audio-book-source-code">GitHub</a>',
            'Course Adviser' => 'Course Adviser',
            'Course Adviser Description' => 'Collaborated on a Prolog-based AI Course Adviser at Arba Minch University in 2014 E.C, showcasing teamwork and AI implementation skills. <a href="https://github.com/username/course-adviser">GitHub</a>',
            'Mental Health Tracker App' => 'Mental Health Tracker App',
            'Mental Health Tracker Description' => 'Developed a Flutter-based mental health tracker app as a final-year project at Arba Minch University in 2016 E.C, focusing on mobile development and mental health awareness. <a href="https://github.com/username/mental-health-tracker-flutter-app">GitHub</a>',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'am' => [
            'Portfolio - Abebe' => 'ፖርትፎሊዮ - አበበ',
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
            'Portfolio Section Title' => 'ፖርትፎሊዮ',
            'Portfolio Description' => 'ከ2013-2016 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ እና በአማራ ሳይንስ እና ቴክኖሎጂ ኢንተርንሺፕ ያከናወኳቸው የሶፍትዌር ኢንጂነሪንግ ፕሮጀክቶች፣ ዴስክቶፕ፣ ድር፣ ሞባይል እና ኤአይ መተግበሪያዎችን ያካትታል። እንደ UI/UX ዲዛይነር በሁሉም ፕሮጀክቶች ላይ ተጠቃሚን መሃል ያደረገ ዲዛይን ላይ አተኩራለሁ።',
            'Filter All' => 'ሁሉም',
            'Filter Desktop' => 'ዴስክቶፕ',
            'Filter Web' => 'ድር',
            'Filter Mobile' => 'ሞባይል',
            'Filter AI' => 'ኤአይ',
            'Cost Sharing Management System' => 'የወጪ መጋራት አስተዳደር ስርዓት',
            'Cost Sharing Description' => 'በ2013 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ የወጪ መጋራትን ለመቆጣጠር በC++ የተገነባ ስርዓት፣ በአልጎሪዝም አስተሳሰብ እና ዝቅተኛ ደረጃ ፕሮግራሚንግ ብቃትን ያሳያል።',
            'Tour and Travel Management System' => 'የጉዞ እና ጉዞ አስተዳደር ስርዓት',
            'Tour and Travel Description' => 'በ2014 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ ጉዞና ጉዞዎችን ለመቆጣጠር HTML፣ CSS፣ JS እና PHP በመጠቀም የተገነባ በድር ላይ የተመሰረተ ስርዓት፣ የፊት እና የኋላ ተርሚናል ልማት ብቃትን ያጎላል። <a href="https://github.com/username/tour-and-travel-ethiopia">GitHub</a>',
            'Supermarket Billing System' => 'የሱፐርማርኬት ቢሊንግ ስርዓት',
            'Supermarket Billing Description' => 'በ2015 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ ለሱፐርማርኬት በጃቫ የተገነባ ቢሊንግ ስርዓት፣ ነገር ተኮር ፕሮግራሚንግ ችሎታዎችን ያሳያል። <a href="https://github.com/username/supermarket-billing-system-in-java">GitHub</a>',
            'Audio Book Application' => 'ለእይታ ጉዳተኞች የድምፅ መጽሐፍ መተግበሪያ',
            'Audio Book Description' => 'በ2015 ዓ.ም በአማራ ሳይንስ እና ቴክኖሎጂ ኢንተርንሺፕ ወቅት ለእይታ ጉዳተኞች ተማሪዎች በጃቫ በአንድሮይድ የተገነባ የድምፅ መጽሐፍ መተግበሪያ፣ ተደራሽነትን ያጎላል። <a href="https://github.com/username/audio-book-source-code">GitHub</a>',
            'Course Adviser' => 'የኮርስ አማካሪ',
            'Course Adviser Description' => 'በ2014 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ በፕሮሎግ ቋንቋ ኤአይ ላይ የተመሰረተ የኮርስ አማካሪ በቡድን ተገንብቷል፣ የቡድን ሥራ እና ኤአይ ትግበራ ችሎታዎችን ያሳያል። <a href="https://github.com/username/course-adviser">GitHub</a>',
            'Mental Health Tracker App' => 'የአእምሮ ጤና መከታተያ መተግበሪያ',
            'Mental Health Tracker Description' => 'በ2016 ዓ.ም በአርባ ምንጭ ዩኒቨርሲቲ የመጨረሻ አመት ፕሮጀክት ሆኖ በፍሉተር የተገነባ የአእምሮ ጤና መከታተያ መተግበሪያ፣ በሞባይል ልማት እና አእምሮ ጤና ግንዛቤ ላይ ያተኩራል። <a href="https://github.com/username/mental-health-tracker-flutter-app">GitHub</a>',
            'Abebe Bihonegn Wondie' => 'አበበ ቢሆነኝ ወንዴ'
        ],
        'af' => [
            'Portfolio - Abebe' => 'Phootofolii - Abebe',
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
            'Portfolio Section Title' => 'Phootofolii',
            'Portfolio Description' => 'Pirojeektoota safitweerii koo 2013-2016 E.C Arba Minch Yuunivarsiitii fi Amhara Saayinsii fi Teknooloojii keessatti, deesktoop, weebii, moobaayilii fi AI applikeeshinoota qabatanii agarsiisu. Akkuma UI/UX dizaayinara pirojeektoota hunda irratti dizaayinii fayyadamtoota garaa godhe.',
            'Filter All' => 'Hunda',
            'Filter Desktop' => 'Deesktoop',
            'Filter Web' => 'Weebii',
            'Filter Mobile' => 'Moobaayilii',
            'Filter AI' => 'AI',
            'Cost Sharing Management System' => 'Sirna Mijjeessaa Qooda Baasii',
            'Cost Sharing Description' => '2013 E.C Arba Minch Yuunivarsiitii keessatti qooda baasii mijjeessuuf C++ keessatti sirna uume, algoriizimii yaaduu fi prograamii gadi aanaa keessatti dandeettii agarsiise.',
            'Tour and Travel Management System' => 'Sirna Mijjeessaa Imala fi Imala',
            'Tour and Travel Description' => '2014 E.C Arba Minch Yuunivarsiitii keessatti imala fi imaloota mijjeessuuf HTML, CSS, JS fi PHP fayyadamuun sirna weebii uume, dandeettii firoont-enn fi baak-enn agarsiise. <a href="https://github.com/username/tour-and-travel-ethiopia">GitHub</a>',
            'Supermarket Billing System' => 'Sirna Bilii Suupermaarkee',
            'Supermarket Billing Description' => '2015 E.C Arba Minch Yuunivarsiitii keessatti suupermaarkee bilii keessatti Jaavaa keessatti sirna uume, dandeettii prograamii wanta irratti hunde qabu agarsiise. <a href="https://github.com/username/supermarket-billing-system-in-java">GitHub</a>',
            'Audio Book Application' => 'Applikeeshinii Kitaaba Sagalee Qulqulluu',
            'Audio Book Description' => '2015 E.C Amhara Saayinsii fi Teknooloojii keessatti internishipii keessatti barattoota qulqulluu dhabanif Jaavaa keessatti Andirooyid applikeeshinii kitaaba sagalee uume, tajaajila qulqullummaa irratti xiyyeeffate. <a href="https://github.com/username/audio-book-source-code">GitHub</a>',
            'Course Adviser' => 'Gorsaa Gorsituu',
            'Course Adviser Description' => '2014 E.C Arba Minch Yuunivarsiitii keessatti Prolog afaan AI irratti hundaa’u gorsaa gorsituu gareen uume, hojii garaa fi dandeettii AI tajaajiluu agarsiise. <a href="https://github.com/username/course-adviser">GitHub</a>',
            'Mental Health Tracker App' => 'Applikeeshinii Seenaa Fayyaa Sammuu',
            'Mental Health Tracker Description' => '2016 E.C Arba Minch Yuunivarsiitii keessatti pirojeektii xumuraa ta’ee Flutter keessatti applikeeshinii seenaa fayyaa sammuu uume, misooma moobaayilii fi hubannoo fayyaa sammuu irratti xiyyeeffate. <a href="https://github.com/username/mental-health-tracker-flutter-app">GitHub</a>',
            'Abebe Bihonegn Wondie' => 'Abebe Bihonegn Wondie'
        ],
        'ti' => [
            'Portfolio - Abebe' => 'ፖርትፎሊዮ - ኣበበ',
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
            'Portfolio Section Title' => 'ፖርትፎሊዮ',
            'Portfolio Description' => 'ካብ 2013-2016 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲን ኣብ ኣማራ ሳይንስን ቴክኖሎጅን ኢንተርንሺፕ ዝተሰርሑ ፕሮጀክታተይ ሶፍትዌር ኢንጂነሪንግ፣ ዴስክቶፕ፣ ወብ፣ ሞባይልን ኤአይን መተግበሪታት ዘጠቓልል ዘርእየን ኣለኹ። ከም UI/UX ዲዛይነር ኣብ ኩሎም ፕሮጀክታት ተጠቃሚ ማእከል ዝገበረ ዲዛይን ኣተኲረ።',
            'Filter All' => 'ኩሉ',
            'Filter Desktop' => 'ዴስክቶፕ',
            'Filter Web' => 'ወብ',
            'Filter Mobile' => 'ሞባይል',
            'Filter AI' => 'ኤአይ',
            'Cost Sharing Management System' => 'ስርዓት ምሕደራ ወጻኢታት ምኻፍ',
            'Cost Sharing Description' => 'ኣብ 2013 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲ ወጻኢታት ምኻፍ ንምሕደራ ብC++ ዝተሰርሐ ስርዓት፣ ኣብ ኣልጎሪዝም ምሕሳብን ትሑት ደረጃ ፕሮግራሚንግን ብቕዓት ዘርእየን።',
            'Tour and Travel Management System' => 'ስርዓት ምሕደራ ጉዕዞን ጉዕዞታትን',
            'Tour and Travel Description' => 'ኣብ 2014 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲ ጉዕዞን ጉዕዞታትን ንምሕደራ HTML፣ CSS፣ JSን PHPን ተጠቒሙ ብወብ ዝተመርከዘ ስርዓት ተሰሪሑ፣ ቅድሚትን ድሕሪትን ተርሚናል ምዕባለ ብቕዓት ዘጎለ። <a href="https://github.com/username/tour-and-travel-ethiopia">GitHub</a>',
            'Supermarket Billing System' => 'ስርዓት ቢል ሱፐርማርኬት',
            'Supermarket Billing Description' => 'ኣብ 2015 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲ ንሱፐርማርኬት ቢል ኣብ ጃቫ ዝተሰርሐ ስርዓት፣ ነገር ኣተኲሩ ፕሮግራሚንግ ብቕዓት ዘርእየን። <a href="https://github.com/username/supermarket-billing-system-in-java">GitHub</a>',
            'Audio Book Application' => 'መተግበሪ መጻሕፍቲ ድምጺ ንዓይነ ስውራን',
            'Audio Book Description' => 'ኣብ 2015 ዓ.ም ኣብ ኣማራ ሳይንስን ቴክኖሎጅን ኢንተርንሺፕ ንዓይነ ስውራን ተማሃሮ ብጃቫ ኣብ ኣንድሮይድ ዝተሰርሐ መተግበሪ መጻሕፍቲ ድምጺ፣ ተደራሽነት ዘጎለ። <a href="https://github.com/username/audio-book-source-code">GitHub</a>',
            'Course Adviser' => 'ኣማኻሪ ኮርስ',
            'Course Adviser Description' => 'ኣብ 2014 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲ ብፕሮሎግ ቋንቋ ኤአይ ዝተመርከዘ ኣማኻሪ ኮርስ ብጉጅለ ተሰሪሑ፣ ምትሕብባር ጉጅለን ኤአይ ትግበራን ብቕዓት ዘርእየን። <a href="https://github.com/username/course-adviser">GitHub</a>',
            'Mental Health Tracker App' => 'መተግበሪ መከታተሊ ጥዕና ኣእምሮ',
            'Mental Health Tracker Description' => 'ኣብ 2016 ዓ.ም ኣብ ኣርባ ምንጭ ዩኒቨርሲቲ ከም ፕሮጀክቲ መደብ መዛዘሚ ብፍሉተር ዝተሰርሐ መተግበሪ መከታተሊ ጥዕና ኣእምሮ፣ ምዕባለ ሞባይልን ንጥዕና ኣእምሮ ምቕልባስን ኣተኲሩ። <a href="https://github.com/username/mental-health-tracker-flutter-app">GitHub</a>',
            'Abebe Bihonegn Wondie' => 'ኣበበ ቢሆነኝ ወንዴ'
        ],
        'fa' => [
            'Portfolio - Abebe' => 'پورتفولیو - ابیبی',
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
            'Portfolio Section Title' => 'پورتفولیو',
            'Portfolio Description' => 'نمایش پروژه‌های مهندسی نرم‌افزار من از سال‌های ۲۰۱۳-۲۰۱۶ ه.ش در دانشگاه آربا مینچ و کارآموزی در علوم و فناوری آمهارا، شامل برنامه‌های دسکتاپ، وب، موبایل و هوش مصنوعی. به‌عنوان طراح UI/UX، در تمام پروژه‌ها بر طراحی کاربرمحور تمرکز داشتم.',
            'Filter All' => 'همه',
            'Filter Desktop' => 'دسکتاپ',
            'Filter Web' => 'وب',
            'Filter Mobile' => 'موبایل',
            'Filter AI' => 'هوش مصنوعی',
            'Cost Sharing Management System' => 'سیستم مدیریت اشتراک هزینه',
            'Cost Sharing Description' => 'در سال ۲۰۱۳ ه.ش در دانشگاه آربا مینچ، سیستمی با ++C برای مدیریت اشتراک هزینه توسعه دادم که مهارت در تفکر الگوریتمی و برنامه‌نویسی سطح پایین را نشان می‌دهد.',
            'Tour and Travel Management System' => 'سیستم مدیریت تور و سفر',
            'Tour and Travel Description' => 'در سال ۲۰۱۴ ه.ش در دانشگاه آربا مینچ، سیستمی مبتنی بر وب با HTML، CSS، JS و PHP برای مدیریت تورها و سفرها ساختم که تخصص در توسعه فرانت‌اند و بک‌اند را برجسته می‌کند. <a href="https://github.com/username/tour-and-travel-ethiopia">GitHub</a>',
            'Supermarket Billing System' => 'سیستم صدور صورت‌حساب سوپرمارکت',
            'Supermarket Billing Description' => 'در سال ۲۰۱۵ ه.ش در دانشگاه آربا مینچ، سیستمی برای صدور صورت‌حساب سوپرمارکت با جاوا پیاده‌سازی کردم که مهارت‌های برنامه‌نویسی شیءگرا را نشان می‌دهد. <a href="https://github.com/username/supermarket-billing-system-in-java">GitHub</a>',
            'Audio Book Application' => 'برنامه کتاب صوتی برای دانش‌آموزان نابینا',
            'Audio Book Description' => 'در سال ۲۰۱۵ ه.ش طی کارآموزی در علوم و فناوری آمهارا، برنامه کتاب صوتی اندرویدی با جاوا برای دانش‌آموزان نابینا ساختم که بر دسترسی‌پذیری تأکید دارد. <a href="https://github.com/username/audio-book-source-code">GitHub</a>',
            'Course Adviser' => 'مشاور دوره',
            'Course Adviser Description' => 'در سال ۲۰۱۴ ه.ش در دانشگاه آربا مینچ، با همکاری تیمی یک مشاور دوره مبتنی بر هوش مصنوعی با پرولوگ ساختم که مهارت‌های کار تیمی و پیاده‌سازی هوش مصنوعی را نشان می‌دهد. <a href="https://github.com/username/course-adviser">GitHub</a>',
            'Mental Health Tracker App' => 'برنامه ردیاب سلامت روان',
            'Mental Health Tracker Description' => 'در سال ۲۰۱۶ ه.ش به‌عنوان پروژه نهایی در دانشگاه آربا مینچ، برنامه ردیاب سلامت روان با فلاتر ساختم که بر توسعه موبایل و آگاهی از سلامت روان تمرکز دارد. <a href="https://github.com/username/mental-health-tracker-flutter-app">GitHub</a>',
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
  <title><?php echo translate('Portfolio - Abebe', $lang); ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio.php?lang=en" rel="alternate" hreflang="en">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio.php?lang=am" rel="alternate" hreflang="am">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio.php?lang=af" rel="alternate" hreflang="af">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio.php?lang=ti" rel="alternate" hreflang="ti">
  <link href="<?php echo APP_DOMAIN; ?>/portfolio.php?lang=fa" rel="alternate" hreflang="fa">
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
    body, .portfolio-info h4, .portfolio-info p, .portfolio-filters li {
      text-align: right;
    }
    .portfolio-info {
      padding-right: 20px;
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
  <!-- =======================================================
  * Developer Name: Abebe Bihonegn
  * Updated: May 13 2025 with Bootstrap v5.3.3
  * Author: Abebe
  ======================================================== -->
</head>
<body class="portfolio-page">
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
    <section id="portfolio" class="portfolio section">
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo translate('Portfolio Section Title', $lang); ?></h2>
        <p><?php echo translate('Portfolio Description', $lang); ?></p>
      </div>
      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active"><?php echo translate('Filter All', $lang); ?></li>
            <li data-filter=".filter-desktop"><?php echo translate('Filter Desktop', $lang); ?></li>
            <li data-filter=".filter-web"><?php echo translate('Filter Web', $lang); ?></li>
            <li data-filter=".filter-mobile"><?php echo translate('Filter Mobile', $lang); ?></li>
            <li data-filter=".filter-ai"><?php echo translate('Filter AI', $lang); ?></li>
          </ul>
          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-desktop">
              <img src="assets/img/portfolio/project-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Cost Sharing Management System', $lang); ?></h4>
                <p><?php echo translate('Cost Sharing Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-1.jpg" title="<?php echo translate('Cost Sharing Management System', $lang); ?>" data-gallery="portfolio-gallery-desktop" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=1" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-web">
              <img src="assets/img/portfolio/project-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Tour and Travel Management System', $lang); ?></h4>
                <p><?php echo translate('Tour and Travel Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-2.jpg" title="<?php echo translate('Tour and Travel Management System', $lang); ?>" data-gallery="portfolio-gallery-web" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=2" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-desktop">
              <img src="assets/img/portfolio/project-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Supermarket Billing System', $lang); ?></h4>
                <p><?php echo translate('Supermarket Billing Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-3.jpg" title="<?php echo translate('Supermarket Billing System', $lang); ?>" data-gallery="portfolio-gallery-desktop" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=3" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-mobile">
              <img src="assets/img/portfolio/project-4.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Audio Book Application', $lang); ?></h4>
                <p><?php echo translate('Audio Book Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-4.jpg" title="<?php echo translate('Audio Book Application', $lang); ?>" data-gallery="portfolio-gallery-mobile" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=4" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-ai">
              <img src="assets/img/portfolio/project-5.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Course Adviser', $lang); ?></h4>
                <p><?php echo translate('Course Adviser Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-5.jpg" title="<?php echo translate('Course Adviser', $lang); ?>" data-gallery="portfolio-gallery-ai" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=5" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-mobile">
              <img src="assets/img/portfolio/project-6.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4><?php echo translate('Mental Health Tracker App', $lang); ?></h4>
                <p><?php echo translate('Mental Health Tracker Description', $lang); ?></p>
                <a href="assets/img/portfolio/project-6.jpg" title="<?php echo translate('Mental Health Tracker App', $lang); ?>" data-gallery="portfolio-gallery-mobile" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                <a href="portfolio-details.php?id=6" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
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