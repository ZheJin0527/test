<?php
// 获取当前页面路径用于高亮导航
$current_page = $_SERVER['REQUEST_URI'];
$base_path = '/frontend/public/';

// 导航菜单项
$nav_items = [
    ['url' => $base_path, 'label_zh' => '首页', 'label_en' => 'Home'],
    ['url' => $base_path . 'about.php', 'label_zh' => '关于我们', 'label_en' => 'About Us'],
    ['url' => $base_path . 'brands.php', 'label_zh' => '旗下品牌', 'label_en' => 'Our Brands'],
    ['url' => $base_path . 'careers.php', 'label_zh' => '加入我们', 'label_en' => 'Join Us']
];

// 语言设置（可以从 session 或 cookie 读取）
$current_lang = $_SESSION['lang'] ?? 'zh';
?>

<!-- Header with Glassmorphism Effect -->
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <!-- Glassmorphism Container -->
    <div class="glass-header backdrop-blur-md bg-white/70 border-b border-white/20 shadow-lg">
        <nav class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="<?php echo $base_path; ?>" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-105 transition-transform duration-300">
                            <span class="text-white font-bold text-xl">K</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="text-sm font-semibold text-gray-800 leading-tight">KUNZZ HOLDINGS</div>
                            <div class="text-xs text-gray-600">SDN BHD</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <?php foreach ($nav_items as $item): 
                        $is_active = ($current_page === $item['url'] || 
                                     ($item['url'] !== $base_path && strpos($current_page, $item['url']) === 0));
                        $label = $current_lang === 'zh' ? $item['label_zh'] : $item['label_en'];
                    ?>
                        <a href="<?php echo $item['url']; ?>" 
                           class="nav-link relative px-4 py-2 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:text-orange-600 hover:bg-white/50 <?php echo $is_active ? 'active text-orange-600' : ''; ?>">
                            <?php echo $label; ?>
                            <?php if ($is_active): ?>
                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-orange-600 rounded-full"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Right Side: Login & Language -->
                <div class="hidden lg:flex items-center space-x-3">
                    <!-- Login Button -->
                    <a href="<?php echo $base_path; ?>login.php" 
                       class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-full hover:shadow-lg hover:scale-105 transform transition-all duration-300">
                        <?php echo $current_lang === 'zh' ? '登入' : 'Login'; ?>
                    </a>
                    
                    <!-- Language Switcher -->
                    <div class="relative language-switcher">
                        <button id="lang-button" 
                                class="px-4 py-2.5 bg-white/50 hover:bg-white/70 text-gray-700 font-medium rounded-full transition-all duration-300 flex items-center space-x-2 border border-gray-200/50">
                            <span><?php echo $current_lang === 'zh' ? '中文' : 'EN'; ?></span>
                            <svg class="w-4 h-4 transform transition-transform duration-300" id="lang-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Language Dropdown -->
                        <div id="lang-dropdown" 
                             class="absolute right-0 mt-2 w-32 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-gray-200/50 overflow-hidden opacity-0 invisible transform scale-95 transition-all duration-300">
                            <a href="?lang=zh" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">中文</a>
                            <a href="?lang=en" class="block px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">English</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" 
                        class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-white/50 transition-colors duration-300">
                    <svg class="w-6 h-6" id="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6 hidden" id="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" 
         class="lg:hidden fixed inset-x-0 top-20 bg-white/95 backdrop-blur-lg border-b border-gray-200/50 shadow-2xl transform -translate-y-full opacity-0 invisible transition-all duration-300">
        <div class="container mx-auto px-4 py-6 space-y-1">
            <?php foreach ($nav_items as $item): 
                $is_active = ($current_page === $item['url'] || 
                             ($item['url'] !== $base_path && strpos($current_page, $item['url']) === 0));
                $label = $current_lang === 'zh' ? $item['label_zh'] : $item['label_en'];
            ?>
                <a href="<?php echo $item['url']; ?>" 
                   class="block px-4 py-3 text-gray-700 font-medium rounded-lg hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200 <?php echo $is_active ? 'bg-orange-50 text-orange-600' : ''; ?>">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>
            
            <div class="pt-4 border-t border-gray-200/50 space-y-3">
                <a href="<?php echo $base_path; ?>login.php" 
                   class="block text-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-full hover:shadow-lg transition-all duration-300">
                    <?php echo $current_lang === 'zh' ? '登入' : 'Login'; ?>
                </a>
                
                <div class="flex items-center justify-center space-x-2">
                    <a href="?lang=zh" class="px-6 py-2 text-gray-700 font-medium rounded-full hover:bg-gray-100 transition-colors duration-200 <?php echo $current_lang === 'zh' ? 'bg-gray-100 text-orange-600' : ''; ?>">中文</a>
                    <a href="?lang=en" class="px-6 py-2 text-gray-700 font-medium rounded-full hover:bg-gray-100 transition-colors duration-200 <?php echo $current_lang === 'en' ? 'bg-gray-100 text-orange-600' : ''; ?>">EN</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Spacer to prevent content from hiding under fixed header -->
<div class="h-20"></div>