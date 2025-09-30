<?php
/**
 * ========================================
 * 示例 Header - 完整的 Tailwind 响应式设计
 * ========================================
 * 功能：
 * 1. 响应式布局（移动端优先）
 * 2. Hover 动画效果
 * 3. 下拉菜单（桌面端）
 * 4. 汉堡菜单（移动端）
 * 5. 使用自定义 Tailwind class
 */

// Session 和配置
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNZZ HOLDINGS - Tailwind 示例</title>
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="frontend/dist/output.css" />
    
    <!-- 自定义字体 -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-inter bg-gray-50">
    
    <!-- ========================================
         Header - 粘性导航栏
         移动端：汉堡菜单
         桌面端：水平导航 + 下拉菜单
         ======================================== -->
    <header class="sticky top-0 z-50 bg-kunzz-dark shadow-md">
        <nav class="w-full px-4 sm:px-6 lg:px-20">
            <div class="flex items-center justify-between h-16 lg:h-20">
                
                <!-- ========== Logo - 左侧 ========== -->
                <div class="flex-shrink-0 animate-fade-in">
                    <a href="index.php" class="flex items-center space-x-2 group">
                        <img 
                            src="images/images/KUNZZ.png" 
                            alt="KUNZZ Logo" 
                            class="h-10 lg:h-12 w-auto transition-transform duration-300 group-hover:scale-110"
                        >
                        <span class="hidden sm:block text-white font-bold text-lg lg:text-xl">
                            KUNZZ HOLDINGS
                        </span>
                    </a>
                </div>

                <!-- ========== 桌面导航 - 中间 ========== -->
                <div class="hidden lg:flex items-center space-x-1 xl:space-x-4">
                    <a href="index.php" class="nav-link group relative">
                        首页
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="about.php" class="nav-link group relative">
                        关于我们
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    
                    <!-- 下拉菜单 - 旗下品牌 -->
                    <div class="relative dropdown-container group">
                        <button class="nav-link flex items-center space-x-1">
                            <span>旗下品牌</span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- 下拉菜单内容 -->
                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-strong opacity-0 invisible 
                                    transform translate-y-2 transition-all duration-300 
                                    group-hover:opacity-100 group-hover:visible group-hover:translate-y-0">
                            <a href="tokyo.php" class="block px-4 py-3 text-gray-700 hover:bg-kunzz-orange hover:text-white transition-colors duration-200 rounded-t-lg">
                                Tokyo Japanese Cuisine
                            </a>
                            <a href="izakaya.php" class="block px-4 py-3 text-gray-700 hover:bg-kunzz-orange hover:text-white transition-colors duration-200 rounded-b-lg">
                                Tokyo Izakaya
                            </a>
                        </div>
                    </div>
                    
                    <a href="joinus.php" class="nav-link group relative">
                        加入我们
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <!-- ========== 右侧按钮 ========== -->
                <div class="hidden lg:flex items-center space-x-3 xl:space-x-4">
                    
                    <!-- 登入按钮 + 下拉 -->
                    <div class="relative dropdown-container group">
                        <button class="btn-primary flex items-center space-x-2">
                            <span>登入</span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-strong opacity-0 invisible 
                                    transform translate-y-2 transition-all duration-300 
                                    group-hover:opacity-100 group-hover:visible group-hover:translate-y-0">
                            <a href="staff-login.php" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-t-lg">
                                员工登入
                            </a>
                            <a href="member-login.php" class="block px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-b-lg">
                                会员登入
                            </a>
                        </div>
                    </div>

                    <!-- 语言切换 -->
                    <div class="relative dropdown-container group">
                        <button class="btn-secondary flex items-center space-x-2">
                            <span class="language-text">中文</span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-strong opacity-0 invisible 
                                    transform translate-y-2 transition-all duration-300 
                                    group-hover:opacity-100 group-hover:visible group-hover:translate-y-0">
                            <button class="language-option block w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-t-lg" data-lang="中文">
                                中文
                            </button>
                            <button class="language-option block w-full text-left px-4 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-b-lg" data-lang="English">
                                English
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ========== 移动端汉堡菜单按钮 ========== -->
                <button class="lg:hidden text-white hover:text-kunzz-orange transition-colors duration-300" 
                        id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- ========== 移动端菜单 ========== -->
            <div id="mobile-menu" class="lg:hidden hidden animate-slide-down">
                <div class="px-2 pt-2 pb-4 space-y-1 bg-kunzz-dark">
                    <a href="index.php" class="block text-white hover:bg-kunzz-orange px-3 py-2 rounded-md transition-colors">
                        首页
                    </a>
                    <a href="about.php" class="block text-white hover:bg-kunzz-orange px-3 py-2 rounded-md transition-colors">
                        关于我们
                    </a>
                    <a href="brands.php" class="block text-white hover:bg-kunzz-orange px-3 py-2 rounded-md transition-colors">
                        旗下品牌
                    </a>
                    <a href="joinus.php" class="block text-white hover:bg-kunzz-orange px-3 py-2 rounded-md transition-colors">
                        加入我们
                    </a>
                    
                    <!-- 移动端登入选项 -->
                    <div class="border-t border-gray-600 pt-2 mt-2">
                        <div class="px-3 py-2 text-white font-semibold text-sm">登入</div>
                        <a href="staff-login.php" class="block text-white hover:bg-kunzz-orange px-6 py-2 rounded-md transition-colors">
                            员工登入
                        </a>
                        <a href="member-login.php" class="block text-white hover:bg-kunzz-orange px-6 py-2 rounded-md transition-colors">
                            会员登入
                        </a>
                    </div>
                    
                    <!-- 移动端语言选项 -->
                    <div class="border-t border-gray-600 pt-2 mt-2">
                        <div class="px-3 py-2 text-white font-semibold text-sm">语言 / Language</div>
                        <button class="mobile-lang-option block w-full text-left text-white hover:bg-kunzz-orange px-6 py-2 rounded-md transition-colors" data-lang="中文">
                            中文
                        </button>
                        <button class="mobile-lang-option block w-full text-left text-white hover:bg-kunzz-orange px-6 py-2 rounded-md transition-colors" data-lang="English">
                            English
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- ========================================
         主内容区域示例
         ======================================== -->
    <main class="min-h-screen">
        <!-- Hero Section -->
        <section class="section-container bg-gradient-to-r from-kunzz-orange to-kunzz-orange-light text-white">
            <div class="text-center space-y-6 animate-fade-in">
                <h1 class="text-responsive-3xl font-bold">
                    欢迎来到 KUNZZ HOLDINGS
                </h1>
                <p class="text-responsive-lg max-w-2xl mx-auto">
                    使用 Tailwind CSS 构建的现代化响应式网站
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <button class="btn-primary bg-white text-kunzz-orange hover:bg-gray-100">
                        了解更多
                    </button>
                    <button class="btn-secondary border-white text-white hover:bg-white hover:text-kunzz-orange">
                        联系我们
                    </button>
                </div>
            </div>
        </section>

        <!-- 卡片示例 -->
        <section class="section-container">
            <h2 class="heading-2 text-center mb-12">我们的优势</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="card animate-slide-up">
                    <h3 class="heading-3">响应式设计</h3>
                    <p class="paragraph">完美适配各种设备，从手机到桌面</p>
                </div>
                <div class="card animate-slide-up animation-delay-100">
                    <h3 class="heading-3">现代化UI</h3>
                    <p class="paragraph">使用 Tailwind CSS 构建美观界面</p>
                </div>
                <div class="card animate-slide-up animation-delay-200">
                    <h3 class="heading-3">高性能</h3>
                    <p class="paragraph">按需生成CSS，只包含使用的样式</p>
                </div>
            </div>
        </section>
    </main>

    <!-- ========================================
         JavaScript
         ======================================== -->
    <script>
        // 移动端菜单切换
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // 语言切换
        const languageText = document.querySelector('.language-text');
        const languageOptions = document.querySelectorAll('.language-option');
        const mobileLangOptions = document.querySelectorAll('.mobile-lang-option');
        
        [...languageOptions, ...mobileLangOptions].forEach(option => {
            option.addEventListener('click', () => {
                const lang = option.getAttribute('data-lang');
                if (languageText) {
                    languageText.textContent = lang;
                }
                localStorage.setItem('language', lang);
            });
        });

        // 加载保存的语言
        const savedLang = localStorage.getItem('language');
        if (savedLang && languageText) {
            languageText.textContent = savedLang;
        }
    </script>
</body>
</html>
