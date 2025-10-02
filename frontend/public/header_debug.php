<!-- Header - 调试版本，所有元素都显示 -->
<header class="fixed top-0 w-full z-50 bg-[#2f2f2f] shadow-md">
    <nav class="w-full px-10 md:px-20 lg:px-28">
        <div class="flex items-center justify-between h-20 lg:h-24">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="index.php" class="flex items-center space-x-3">
                    <img 
                        src="../images/images/KUNZZ.png" 
                        alt="KUNZZ Logo" 
                        class="h-14 lg:h-16 w-auto"
                    >
                </a>
            </div>

            <!-- 桌面导航 - 直接显示，不隐藏 -->
            <div class="flex items-center space-x-6 lg:space-x-10">
                <a href="index.php" class="text-white hover:text-gray-300 transition-colors text-base lg:text-lg">首页</a>
                <a href="about.php" class="text-white hover:text-gray-300 transition-colors text-base lg:text-lg">关于我们</a>
                <a href="#" class="text-white hover:text-gray-300 transition-colors text-base lg:text-lg">旗下品牌</a>
                <a href="joinus.php" class="text-white hover:text-gray-300 transition-colors text-base lg:text-lg">加入我们</a>
            </div>

            <!-- 右侧按钮 - 直接显示，不隐藏 -->
            <div class="flex items-center space-x-3 lg:space-x-5">
                
                <!-- 登入按钮 -->
                <div class="relative login-dropdown">
                    <button class="flex items-center space-x-2 px-6 lg:px-8 py-2 lg:py-3 text-base lg:text-lg bg-[#ff5c00] hover:bg-[#f7931e] text-white rounded-[30px] border-2 border-[#ff5c00] transition-colors">
                        <span>登入</span>
                        <svg class="w-4 lg:w-5 h-4 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute right-0 mt-3 w-40 lg:w-48 bg-[#2f2f2f] rounded-lg shadow-lg opacity-0 invisible translate-y-2 transition-all duration-300 login-menu">
                        <a href="login.html" class="block px-4 lg:px-5 py-2 lg:py-3 text-white hover:bg-[#ff5c00] transition-colors rounded-t-lg text-sm lg:text-base">
                            员工登入
                        </a>
                        <a href="login.html" class="block px-4 lg:px-5 py-2 lg:py-3 text-white hover:bg-[#ff5c00] transition-colors rounded-b-lg text-sm lg:text-base">
                            会员登入
                        </a>
                    </div>
                </div>

                <!-- 语言切换 -->
                <div class="relative language-dropdown">
                    <button class="flex items-center space-x-2 px-6 lg:px-8 py-2 lg:py-3 text-base lg:text-lg bg-transparent border-2 border-[#ff5c00] text-white hover:bg-[#ff5c00] rounded-[30px] transition-colors">
                        <span class="language-text">中文</span>
                        <svg class="w-4 lg:w-5 h-4 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div class="absolute right-0 mt-3 w-36 lg:w-40 bg-white rounded-lg shadow-lg opacity-0 invisible translate-y-2 transition-all duration-300 language-menu">
                        <button class="language-option block w-full text-left px-4 lg:px-5 py-2 lg:py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-t-lg text-sm lg:text-base" data-lang="中文">
                            中文
                        </button>
                        <button class="language-option block w-full text-left px-4 lg:px-5 py-2 lg:py-3 text-gray-700 hover:bg-gray-100 transition-colors rounded-b-lg text-sm lg:text-base" data-lang="English">
                            English
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- 页面指示器 -->
<?php if (isset($showPageIndicator) && $showPageIndicator): ?>
<div class="fixed left-6 top-1/2 -translate-y-1/2 z-[1000] flex flex-col gap-3 p-4 bg-black/30 border border-white/15 rounded-3xl backdrop-blur-md opacity-50 hover:opacity-100 transition-opacity duration-500 hidden md:flex">
    <?php 
    $totalSlides = isset($totalSlides) ? $totalSlides : 4;
    for ($i = 0; $i < $totalSlides; $i++): 
    ?>
        <div class="header-page-dot w-2 h-2 rounded-full bg-white/80 border-2 border-white/80 cursor-pointer hover:scale-125 transition-all duration-300 <?php echo $i === 0 ? 'active !h-10 !rounded-md' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
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

languageOptions.forEach(option => {
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

// 页面指示器由 index.php 中的 swiper 配置处理
</script>
