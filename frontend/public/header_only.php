<?php
/**
 * ========================================
 * Header Only - 仅包含 Header 部分
 * 用于已有 HTML 结构的页面
 * ========================================
 */

// 如果还没有 session，启动它
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 尝试包含媒体配置
if (!isset($mediaConfigIncluded) && file_exists('../../media_config.php')) {
    include_once '../../media_config.php';
    $mediaConfigIncluded = true;
}
?>

<!-- Header -->
<header class="sticky top-0 z-50 bg-kunzz-dark shadow-md">
    <nav class="w-full px-10 md:px-20 lg:px-28">
        <div class="flex items-center justify-between h-20 lg:h-24">
            
            <!-- Logo -->
            <div class="flex-shrink-0 animate-fade-in">
                <a href="index.php" class="flex items-center space-x-3 group">
                    <img 
                        src="../images/images/KUNZZ.png" 
                        alt="KUNZZ Logo" 
                        class="h-14 lg:h-16 w-auto transition-transform duration-300 group-hover:scale-110"
                    >
                    <span class="hidden xl:block text-white font-bold text-xl lg:text-2xl">
                        KUNZZ HOLDINGS
                    </span>
                </a>
            </div>

            <!-- 桌面导航 -->
            <div class="hidden lg:flex items-center space-x-10 xl:space-x-12">
                <a href="index.php" class="text-white hover:text-gray-300 transition-colors text-lg group relative">
                    首页
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="about.php" class="text-white hover:text-gray-300 transition-colors text-lg group relative">
                    关于我们
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                </a>
                
                <!-- 下拉菜单 - 旗下品牌 -->
                <div class="relative dropdown-container group">
                    <button class="text-white hover:text-gray-300 transition-colors text-lg flex items-center space-x-1">
                        <span>旗下品牌</span>
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute left-0 mt-3 w-64 bg-white rounded-lg shadow-strong opacity-0 invisible 
                                transform translate-y-2 transition-all duration-300 
                                group-hover:opacity-100 group-hover:visible group-hover:translate-y-0">
                        <a href="tokyo.php" class="block px-5 py-4 text-gray-700 hover:bg-kunzz-orange hover:text-white transition-colors duration-200 rounded-t-lg text-base">
                            Tokyo Japanese Cuisine
                        </a>
                        <a href="izakaya.php" class="block px-5 py-4 text-gray-700 hover:bg-kunzz-orange hover:text-white transition-colors duration-200 rounded-b-lg text-base">
                            Tokyo Izakaya
                        </a>
                    </div>
                </div>
                
                <a href="joinus.php" class="text-white hover:text-gray-300 transition-colors text-lg group relative">
                    加入我们
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-kunzz-orange transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>

            <!-- 右侧按钮 -->
            <div class="hidden lg:flex items-center space-x-5 xl:space-x-6">
                
                <!-- 登入按钮 -->
                <div class="relative dropdown-container login-dropdown">
                    <button class="btn-primary flex items-center space-x-2 px-8 py-3 text-lg">
                        <span>登入</span>
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute right-0 mt-3 w-48 bg-kunzz-dark rounded-lg shadow-strong opacity-0 invisible 
                                transform translate-y-2 transition-all duration-300 login-menu">
                        <a href="login.html" class="block px-5 py-3 text-white hover:bg-kunzz-orange transition-colors rounded-t-lg text-base">
                            员工登入
                        </a>
                        <a href="login.html" class="block px-5 py-3 text-white hover:bg-kunzz-orange transition-colors rounded-b-lg text-base">
                            会员登入
                        </a>
                    </div>
                </div>

                <!-- 语言切换 -->
                <div class="relative dropdown-container language-dropdown">
                    <button class="btn-secondary flex items-center space-x-2 px-8 py-3 text-lg">
                        <span class="language-text">中文</span>
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute right-0 mt-3 w-40 bg-white rounded-lg shadow-strong opacity-0 invisible 
                                transform translate-y-2 transition-all duration-300 language-menu">
                        <button class="language-option block w-full text-left px-5 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-t-lg text-base" data-lang="中文">
                            中文
                        </button>
                        <button class="language-option block w-full text-left px-5 py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-b-lg text-base" data-lang="English">
                            English
                        </button>
                    </div>
                </div>
            </div>

            <!-- 移动端汉堡菜单 -->
            <button class="lg:hidden text-white hover:text-kunzz-orange transition-colors duration-300" 
                    id="mobile-menu-btn">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- 移动端菜单 -->
        <div id="mobile-menu" class="lg:hidden hidden animate-slide-down">
            <div class="px-2 pt-2 pb-4 space-y-1 bg-kunzz-dark">
                <a href="index.php" class="block text-white hover:bg-kunzz-orange px-4 py-3 rounded-md transition-colors text-base">
                    首页
                </a>
                <a href="about.php" class="block text-white hover:bg-kunzz-orange px-4 py-3 rounded-md transition-colors text-base">
                    关于我们
                </a>
                <a href="#" class="block text-white hover:bg-kunzz-orange px-4 py-3 rounded-md transition-colors text-base">
                    旗下品牌
                </a>
                <a href="joinus.php" class="block text-white hover:bg-kunzz-orange px-4 py-3 rounded-md transition-colors text-base">
                    加入我们
                </a>
                
                <div class="border-t border-gray-600 pt-3 mt-3">
                    <div class="px-4 py-2 text-white font-semibold text-sm">登入</div>
                    <a href="login.html" class="block text-white hover:bg-kunzz-orange px-6 py-3 rounded-md transition-colors text-base">
                        员工登入
                    </a>
                    <a href="login.html" class="block text-white hover:bg-kunzz-orange px-6 py-3 rounded-md transition-colors text-base">
                        会员登入
                    </a>
                </div>
                
                <div class="border-t border-gray-600 pt-3 mt-3">
                    <div class="px-4 py-2 text-white font-semibold text-sm">语言 / Language</div>
                    <button class="mobile-lang-option block w-full text-left text-white hover:bg-kunzz-orange px-6 py-3 rounded-md transition-colors text-base" data-lang="中文">
                        中文
                    </button>
                    <button class="mobile-lang-option block w-full text-left text-white hover:bg-kunzz-orange px-6 py-3 rounded-md transition-colors text-base" data-lang="English">
                        English
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- 页面指示器（可选） -->
<?php if (isset($showPageIndicator) && $showPageIndicator): ?>
<div class="fixed left-6 top-1/2 -translate-y-1/2 z-[1000] flex flex-col gap-3 p-4 
            bg-black/30 border border-white/15 rounded-3xl backdrop-blur-md 
            opacity-50 hover:opacity-100 transition-opacity duration-500 hidden md:flex">
    <?php 
    $totalSlides = isset($totalSlides) ? $totalSlides : 4;
    for ($i = 0; $i < $totalSlides; $i++): 
    ?>
        <div class="w-2 h-2 rounded-full bg-white/80 border-2 border-white/80 cursor-pointer 
                    hover:scale-125 transition-all duration-300 
                    <?php echo $i === 0 ? 'active !h-10 !rounded-md' : ''; ?>" 
             data-slide="<?php echo $i; ?>">
        </div>
    <?php endfor; ?>
</div>
<?php endif; ?>

<script>
// 登入下拉菜单
const loginDropdown = document.querySelector('.login-dropdown');
const loginMenu = document.querySelector('.login-menu');

if (loginDropdown && loginMenu) {
    loginDropdown.addEventListener('mouseenter', () => {
        loginMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
        loginMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
    });
    
    loginDropdown.addEventListener('mouseleave', () => {
        loginMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
        loginMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
    });
}

// 语言下拉菜单
const languageDropdown = document.querySelector('.language-dropdown');
const languageMenu = document.querySelector('.language-menu');

if (languageDropdown && languageMenu) {
    languageDropdown.addEventListener('mouseenter', () => {
        languageMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
        languageMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
    });
    
    languageDropdown.addEventListener('mouseleave', () => {
        languageMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
        languageMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
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

// 移动端菜单切换
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}

// 页面指示器点击
const pageDots = document.querySelectorAll('[data-slide]');
pageDots.forEach(dot => {
    dot.addEventListener('click', function() {
        const slideIndex = this.getAttribute('data-slide');
        pageDots.forEach(d => {
            d.classList.remove('active', '!h-10', '!rounded-md');
        });
        this.classList.add('active', '!h-10', '!rounded-md');
        
        const event = new CustomEvent('slideChange', { 
            detail: { index: parseInt(slideIndex) } 
        });
        document.dispatchEvent(event);
    });
});
</script>
