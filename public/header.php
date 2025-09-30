<?php
// 检查是否已经启动了session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 包含媒体配置
if (!isset($mediaConfigIncluded)) {
    include_once '../media_config.php';
    $mediaConfigIncluded = true;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="/images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../frontend/dist/output.css" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'KUNZZ HOLDINGS'; ?></title>
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>" />
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter">
    <?php echo getBgMusicHtml(); ?>
    
    <!-- Header -->
    <header class="fixed top-0 left-0 w-full bg-[#2F2F2F] text-white z-[999] px-10 md:px-20 lg:px-28 py-4 md:py-5 flex items-center justify-between transition-transform duration-300 box-border">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="index.php">
                <img src="../images/images/KUNZZ.png" alt="Logo" class="h-12 md:h-14 lg:h-16 w-auto">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav id="navMenu" class="hidden md:flex items-center gap-8 lg:gap-12 ml-12 lg:ml-16 font-light text-base lg:text-lg h-full -translate-y-full md:translate-y-0 transition-transform duration-300
                    md:relative fixed top-20 left-0 w-full md:w-auto bg-[#2F2F2F] md:bg-transparent
                    flex-col md:flex-row pt-8 md:pt-0 pb-8 md:pb-0 px-8 md:px-0">
            <a href="index.php" class="text-white hover:bg-kunzz-orange hover:px-10 px-3 py-2 flex items-center transition-all duration-300 whitespace-nowrap">首页</a>
            <a href="about.php" class="text-white hover:bg-kunzz-orange hover:px-10 px-3 py-2 flex items-center transition-all duration-300 whitespace-nowrap">关于我们</a>
            
            <!-- Brands Dropdown -->
            <div class="relative flex items-center group">
                <span class="text-white hover:bg-kunzz-orange hover:px-10 px-3 py-2 flex items-center cursor-pointer transition-all duration-300 whitespace-nowrap">旗下品牌</span>
                <div id="brandsNavDropdownMenu" class="absolute top-full left-0 mt-3 min-w-[220px] bg-[#2F2F2F] rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                    <!-- <a href="tokyo-japanese-cuisine.php" class="block px-5 py-3 text-base text-white hover:bg-kunzz-orange border-b border-[#444] last:border-0 transition-colors">Tokyo Japanese Cuisine</a> -->
                </div>
            </div>
            
            <a href="joinus.php" class="text-white hover:bg-kunzz-orange hover:px-10 px-3 py-2 flex items-center transition-all duration-300 whitespace-nowrap">加入我们</a>
        </nav>

        <!-- Right Section -->
        <div class="flex items-center gap-5 md:gap-7">
            <!-- Login Button -->
            <div class="relative group">
                <button id="loginBtn" class="hidden md:flex items-center justify-center px-6 py-2.5 bg-kunzz-orange border border-kunzz-orange text-white rounded-full text-base hover:bg-kunzz-orange-hover transition-all duration-300 whitespace-nowrap">
                    登入
                </button>
                <div id="loginDropdownMenu" class="absolute top-full right-0 mt-3 w-32 bg-[#2F2F2F] rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                    <a href="login.html" class="block px-5 py-3 text-base text-white hover:bg-kunzz-orange border-b border-[#444] transition-colors">员工登入</a>
                    <a href="login.html" class="block px-5 py-3 text-base text-white hover:bg-kunzz-orange transition-colors">会员登入</a>
                </div>
            </div>

            <!-- Language Button -->
            <div class="relative group">
                <button id="languageBtn" class="flex items-center justify-center px-6 py-2.5 bg-transparent border border-kunzz-orange text-white rounded-full text-base hover:bg-kunzz-orange transition-all duration-300 whitespace-nowrap">
                    中文
                </button>
                <div id="languageDropdownMenu" class="absolute top-full right-0 mt-3 w-32 bg-[#2F2F2F] rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                    <a href="/" class="block px-5 py-3 text-base text-white hover:bg-kunzz-orange border-b border-[#444] transition-colors" data-lang="cn">中文</a>
                    <a href="/en/" class="block px-5 py-3 text-base text-white hover:bg-kunzz-orange transition-colors" data-lang="en">English</a>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <button id="hamburger" class="md:hidden text-3xl text-white">
                &#9776;
            </button>
        </div>
    </header>

    <!-- Page Indicator -->
    <?php if (isset($showPageIndicator) && $showPageIndicator): ?>
    <div class="fixed left-6 top-1/2 -translate-y-1/2 z-[1000] flex flex-col gap-3 p-4 bg-black/30 border border-white/15 rounded-3xl backdrop-blur-md opacity-50 hover:opacity-100 transition-opacity duration-500 hidden md:flex">
        <?php 
        $totalSlides = isset($totalSlides) ? $totalSlides : 4;
        for ($i = 0; $i < $totalSlides; $i++): 
        ?>
            <div class="w-2 h-2 rounded-full bg-white/80 border-2 border-white/80 cursor-pointer hover:scale-125 transition-all duration-300 <?php echo $i === 0 ? 'active !h-10 !rounded-md' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
