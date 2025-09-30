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
    <header class="bg-[#2f2f2f] sticky top-0 z-50">
        <nav class="w-full px-10 md:px-20 lg:px-28">
            <div class="flex items-center justify-between h-20 lg:h-24">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.php" class="text-white text-2xl font-bold hover:text-gray-300 transition-colors">
                        <img src="../images/images/KUNZZ.png" alt="Logo" class="h-14 lg:h-16 w-auto">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-10 xl:space-x-12">
                    <a href="index.php" class="text-white hover:text-gray-300 transition-colors text-2xl">首页</a>
                    <a href="about.php" class="text-white hover:text-gray-300 transition-colors text-lg">关于我们</a>
                    <a href="#" class="text-white hover:text-gray-300 transition-colors text-lg">旗下品牌</a>
                    <a href="joinus.php" class="text-white hover:text-gray-300 transition-colors text-lg">加入我们</a>
                </div>

                <!-- Right Section -->
                <div class="hidden lg:flex items-center space-x-5 xl:space-x-6">
                    <!-- Login Dropdown -->
                    <div class="relative login-dropdown">
                        <button class="border-2 border-[#ff5c00] hover:border-[#f7931e] bg-[#ff5c00] hover:bg-[#f7931e] text-white transition-colors px-8 py-3 rounded-[30px] flex items-center space-x-2 text-lg">
                            <span>登入</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-3 w-48 bg-[#2f2f2f] rounded-lg shadow-lg opacity-0 invisible transition-all duration-200 login-menu">
                            <a href="login.html" class="block px-5 py-3 text-white hover:bg-[#ff5c00] text-base rounded-t-lg">员工登入</a>
                            <a href="login.html" class="block px-5 py-3 text-white hover:bg-[#ff5c00] text-base rounded-b-lg">会员登入</a>
                        </div>
                    </div>

                    <!-- Language Dropdown -->
                    <div class="relative language-dropdown">
                        <button class="border-2 border-[#ff5c00] text-white hover:bg-[#ff5c00] transition-colors px-8 py-3 rounded-[30px] flex items-center space-x-2 text-lg">
                            <span class="language-text">中文</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-3 w-40 bg-white rounded-lg shadow-lg opacity-0 invisible transition-all duration-200 language-menu">
                            <button class="block w-full text-left px-5 py-3 text-gray-800 hover:bg-gray-100 language-option text-base rounded-t-lg" data-lang="中文">中文</button>
                            <button class="block w-full text-left px-5 py-3 text-gray-800 hover:bg-gray-100 language-option text-base rounded-b-lg" data-lang="English">English</button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button class="text-white hover:text-gray-300 mobile-menu-btn">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden mobile-menu hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="index.php" class="block text-white hover:text-gray-300 px-3 py-2">首页</a>
                    <a href="about.php" class="block text-white hover:text-gray-300 px-3 py-2">关于我们</a>
                    <a href="#" class="block text-white hover:text-gray-300 px-3 py-2">旗下品牌</a>
                    <a href="joinus.php" class="block text-white hover:text-gray-300 px-3 py-2">加入我们</a>
                    
                    <div class="border-t border-gray-600 pt-2 mt-2">
                        <div class="px-3 py-2 text-white font-semibold">登入</div>
                        <a href="login.html" class="block text-white hover:text-gray-300 px-6 py-2">员工登入</a>
                        <a href="login.html" class="block text-white hover:text-gray-300 px-6 py-2">会员登入</a>
                    </div>
                    
                    <div class="border-t border-gray-600 pt-2 mt-2">
                        <div class="px-3 py-2 text-white font-semibold">语言 / Language</div>
                        <button class="block w-full text-left text-white hover:text-gray-300 px-6 py-2 mobile-lang-option" data-lang="中文">中文</button>
                        <button class="block w-full text-left text-white hover:text-gray-300 px-6 py-2 mobile-lang-option" data-lang="English">English</button>
                    </div>
                </div>
            </div>
        </nav>
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
