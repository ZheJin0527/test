<?php
// 检查是否已经启动了session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 包含媒体配置
if (!isset($mediaConfigIncluded)) {
    include_once 'media_config.php';
    $mediaConfigIncluded = true;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<body>
    <?php echo getBgMusicHtml(); ?>
    <header class="navbar">
        <!-- 左侧 logo 和公司名 -->
        <div class="logo-section">
            <a href="index.php">
                <img src="images/images/KUNZZ.png" alt="Logo" class="logo">
            </a>
        </div>

        <!-- 中间导航（默认显示，大屏） -->
        <nav class="nav-links" id="navMenu">
            <div class="nav-item"><a href="index.php">首页</a></div>
            <div class="nav-item"><a href="about.php">关于我们</a></div>
            <div class="nav-item nav-dropdown">
                <span class="nav-dropdown-trigger">旗下品牌</span>
                <div class="nav-dropdown-menu" id="brandsNavDropdownMenu">
                    <!-- <a href="tokyo-japanese-cuisine.php" class="nav-dropdown-item">Tokyo Japanese Cuisine</a>
                    <a href="tokyo-izakaya.php" class="nav-dropdown-item">Tokyo Izakaya Japanese Cuisine</a> -->
                </div>
            </div>
            <div class="nav-item"><a href="joinus.php">加入我们</a></div>
        </nav>

        <!-- 右侧区域 -->
        <div class="right-section">
            <!-- 移动端隐藏 login，仅大屏显示 -->
            <div class="login-dropdown">
                <button class="login-btn" id="loginBtn">登入</button>
                <div class="login-dropdown-menu" id="loginDropdownMenu">
                    <a href="login.html" class="login-dropdown-item">员工登入</a>
                    <a href="login.html" class="login-dropdown-item">会员登入</a>
                </div>
            </div>

            <!-- 翻译按钮始终显示 -->
            <div class="language-switch">
                <button class="lang" id="languageBtn">中文</button>
                <div class="language-dropdown-menu" id="languageDropdownMenu">
                    <a href="/" class="language-dropdown-item" data-lang="cn">中文</a>
                    <a href="/en/" class="language-dropdown-item" data-lang="en">English</a>
                </div>
            </div>

            <!-- hamburger 仅在小屏显示 -->
            <button class="hamburger" id="hamburger">&#9776;</button>
        </div>
    </header>

    <?php if (isset($showPageIndicator) && $showPageIndicator): ?>
    <div class="page-indicator">
        <?php 
        $totalSlides = isset($totalSlides) ? $totalSlides : 4;
        for ($i = 0; $i < $totalSlides; $i++): 
        ?>
            <div class="page-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
