<?php

// 禁用页面缓存
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include_once 'media_config.php';
// 获取时间线数据
$timelineData = getTimelineConfig();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNZZ HOLDINGS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="aboutanimation.css" />
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
        <a href="tokyo-japanese-cuisine.php" class="nav-dropdown-item">Tokyo Japanese Cuisine</a>
        <a href="tokyo-izakaya.php" class="nav-dropdown-item">Tokyo Izakaya Japanese Cuisine</a>
      </div>
     </div>
    <div class="nav-item"><a href="joinus.php">加入我们</a></div>
  </nav>

  <!-- 右侧区域 -->
  <div class="right-section">
    <!-- 移动端隐藏 login，仅大屏显示 -->
    <div class="login-dropdown">
      <button class="login-btn" id="loginBtn">LOGIN</button>
        <div class="login-dropdown-menu" id="loginDropdownMenu">
          <a href="login.html" class="login-dropdown-item">员工登入</a>
          <a href="login.html" class="login-dropdown-item">会员登入</a>
        </div>
      </div>

    <!-- 翻译按钮始终显示 -->
    <div class="language-switch">
      <button class="lang" id="languageBtn">EN | CN</button>
        <div class="language-dropdown-menu" id="languageDropdownMenu">
          <a href="/en/" class="language-dropdown-item" data-lang="en">英文</a>
          <a href="/" class="language-dropdown-item" data-lang="cn">中文</a>
        </div>
      </div>

    <!-- hamburger 仅在小屏显示 -->
    <button class="hamburger" id="hamburger">&#9776;</button>
  </div>
</header>

<div class="page-indicator">
        <div class="page-dot active" data-slide="0"></div>
        <div class="page-dot" data-slide="1"></div>
        <div class="page-dot" data-slide="2"></div>
        <div class="page-dot" data-slide="3"></div>
        <div class="page-dot" data-slide="4"></div>
    </div>
    
<div class="swiper">
  <div class="swiper-wrapper">

  <div class="swiper-slide">
    <section class="aboutus-section">
    <div class="aboutus-banner">
        <?php echo getMediaHtml('about_background'); ?>
      <div class="aboutus-content">
        <h1>关于我们</h1>
        <p>深入了解 Kunzz Holdings 的初心与成长轨迹</p>
      </div>
    </div>

    <div class="aboutus-intro">
      <div class="intro-content">
        <h1>集团简介</h1>
        <p>
          Kunzz Holdings 是一家总部位于马来西亚的多元化控股集团，专注资源整合与效率提升，<br>
          为旗下公司提供战略支持与运营协同。我们致力于用心打造品牌，<br>
          激发团队潜力，助力企业在竞争中脱颖而出。
        </p>
      </div>
    </div>
</section>
    </div>
  
    <div class="swiper-slide">
    <section id="vision" class="vision">
    <div class="vision-content animate-on-scroll vision-slide-down">
      <h1>我们的信念与方向</h1>
      <p>
        我们相信，所有伟大的成就，都始于一份清晰的信念。<br>
        使命、愿景、文化与价值观，是前进的灯塔，也是我们共同坚守的底线。<br>
        在这样的理念指引下，我们持续成长、持续突破、持续成就彼此。
      </p>

      <div class="vision-cards">
        <!-- Card 1 -->
        <div class="vision-card animate-on-scroll slide-in-left">
          <div class="vision-label">我们的使命</div>
          <h2>塑造积极向上和舒适的工作环境</h2>
          <p>
            在这里，我们相信好的工作环境，能孕育出更好的团队。<br>
            我们努力打造一个温暖、有温度、有归属感的空间，<br>
            让每位成员都能安心发挥，共同成长。<br>
            在这里，挑战不再冰冷，努力也值得被看见。
          </p>
        </div>

        <!-- Card 2 -->
        <div class="vision-card animate-on-scroll slide-in-right">
          <div class="vision-label">我们的愿景</div>
          <h2>打造高效且创新的团队，<br>为公司不断创造价值，成为行业标杆。</h2>
          <p>
            一个好团队，是企业价值持续创造的源头。唯有高效与创新并行，
            团队才能突破边界、成就非凡。我们正以坚实步伐，走在打造行业标杆的路上，
            用成就说话，用信念前行。
          </p>
        </div>
      </div>
    </div>
  </section>
  </div>

  <div class="swiper-slide">
  <section id="values" class="values-section">
        <div class="values-top animate-on-scroll">
            <h2 class="values-title animate-on-scroll values-scale-fade delay-3">我们的核心<span style="color: #FF5C00;">价值观</span></h2>
            <p class="values-description animate-on-scroll values-scale-fade delay-4">
                核心价值观，贯穿在每一份努力、每一个团队协作之中。
                它让我们在文化中凝聚一致，在挑战中保持信念，
                在成长中维持不变的初心。
            </p>
        </div>
      
        <div class="values-bottom animate-on-scroll card-tilt-in-left">
            <div class="values-card">
                <img src="images/images/目标导向.png" alt="icon" class="values-icon">
                <h3>目标导向</h3>
                <p>以结果为导向，聚焦关键任务，明确每一步的方向与意义。</p>
            </div>
            <div class="values-card">
                <img src="images/images/理念一致.png" alt="icon" class="values-icon">
                <h3>理念一致</h3>
                <p>保持高度共识，思想同频，目标一致，减少内耗。</p>
            </div>
            <div class="values-card">
                <img src="images/images/追求卓越.png" alt="icon" class="values-icon">
                <h3>追求卓越</h3>
                <p>不满足于完成任务，要追求干得更好，更高标准地完成目标，持续优化每项工作。</p>
            </div>
            <div class="values-card">
                <img src="images/images/创新精神.png" alt="icon" class="values-icon">
                <h3>创新精神</h3>
                <p>拥抱变化、敢于尝试，突破既有框架，不断探索新方法、新工具与新角度，推动企业成长。</p>
            </div>
        </div>
    </section>
  </div>

  <div class="swiper-slide">
  <section class="timeline-section" id="timeline-1">
        <h1>— 我们的发展历史 —</h1>
        
        <!-- 横向时间线导航 -->
        <div class="timeline-nav">
            <div class="nav-arrow prev" onclick="navigateTimeline('prev')">‹</div>
            <div class="nav-arrow next" onclick="navigateTimeline('next')">›</div>
            
            <div class="timeline-scroll-container">
                <div class="timeline-track"></div>
                <div class="timeline-items-container" id="timelineContainer">
                    <?php 
                    $index = 0;
                    foreach ($timelineData as $year => $data): 
                    ?>
                    <div class="timeline-item <?php echo $index === 0 ? 'active' : ''; ?>" data-year="<?php echo $year; ?>">
                        <div class="timeline-bullet"><?php echo $year; ?></div>
                    </div>
                    <?php 
                    $index++;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>

        <!-- 卡片容器 -->
        <div class="timeline-content-container">
            <div class="timeline-cards-wrapper">
                <?php 
                $index = 0;
                foreach ($timelineData as $year => $data): 
                    $itemClass = $index === 0 ? 'active' : ($index === 1 ? 'next' : 'hidden');
                ?>
                <!-- <?php echo $year; ?>年内容 -->
                <div class="timeline-content-item <?php echo $itemClass; ?>" data-year="<?php echo $year; ?>" data-index="<?php echo $index; ?>">
                    <div class="timeline-content" onclick="selectCard(<?php echo $year; ?>)">
                        <div class="timeline-image">
                            <img src="<?php echo $data['image_url']; ?>" alt="<?php echo $year; ?>年发展">
                        </div>
                        <div class="timeline-text">
                            <div class="year-badge"><?php echo $year; ?>年</div>
                            <h3><?php echo htmlspecialchars($data['title']); ?></h3>
                            <p><?php echo htmlspecialchars($data['description1']); ?></p>
                            <p><?php echo htmlspecialchars($data['description2']); ?></p>
                        </div>
                    </div>
                </div>
                <?php 
                $index++;
                endforeach; 
                ?>
            </div>
        </div>
    </section>
  </div>

  <div class="swiper-slide footer-slide">
    <section class="scroll-buffer">
    <footer class="footer">
    <div class="footer-section">
      <h4><a href="index.php">首页</a></h4>
      <ul>
        <li><a href="index.php#comprofile">公司简介</a></li>
        <li><a href="index.php#culture">公司文化</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="about.php">关于我们</a></h4>
      <ul>
        <li><a href="#" onclick="goToSlide(0); return false;">集团简介</a></li>
        <li><a href="#" onclick="goToSlide(1); return false;">信念与方向</a></li>
        <li><a href="#" onclick="goToSlide(2); return false;">核心价值观</a></li>
        <li><a href="#" onclick="goToSlide(3); return false;">发展历史</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4>旗下品牌</h4>
      <ul>
        <li><a href="tokyo-japanese-cuisine.php">TOKYO JAPANESE </br>CUISINE</li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="joinus.php">加入我们</a></h4>
      <ul>
        <li><a href="joinus.php">公司福利</li>
        <li><a href="joinus.php#comphoto-container">我们的足迹</li>
        <li><a href="joinus.php#particles">招聘的职位</li>
        <li><a href="joinus.php#map">联系我们</a></li>        
      </ul>
    </div>
  </footer>

  <button id="backToTop" onclick="scrollToTop()">&#8673;</button>
  
  <div class="footer-bottom">
    © 2025 Kunzz Holdings Sdn. Bhd. All rights reserved.
  </div>
  </section>
  </div>

  
  </div> <!-- 关闭 swiper-wrapper -->
</div> <!-- 关闭 swiper -->

<div class="social-sidebar">
    <!-- Facebook -->
    <a href="https://www.facebook.com/share/16ZihY9RN6/" target="_blank" class="social-icon facebook" title="进入 Facebook 世界">
        <img src="images/images/fbicon.png" alt="Facebook">
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com" target="_blank" class="social-icon instagram" title="探索 Instagram 精彩">
        <img src="images/images/igicon.png" alt="Instagram">
    </a>

    <!-- WhatsApp -->
    <a href="https://www.whatsapp.com" target="_blank" class="social-icon whatsapp" title="连接 WhatsApp">
        <img src="images/images/wsicon.png" alt="WhatsApp">
    </a>
</div>
  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="app.js"></script>
<script>
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');
        const loginBtn = document.querySelector('.login-btn');

        // 登录下拉菜单元素
        const loginDropdownMenu = document.getElementById('loginDropdownMenu');

        // 语言切换下拉菜单元素
        const languageBtn = document.getElementById('languageBtn');
        const languageDropdownMenu = document.getElementById('languageDropdownMenu');

        function moveLoginBtn() {
            if (window.innerWidth <= 768) {
                if (!navMenu.contains(loginBtn)) {
                    navMenu.appendChild(loginBtn);
                }
            } else {
                // 如果宽度大于768，确保loginBtn在right-section中
                const rightSection = document.querySelector('.right-section');
                if (rightSection && !rightSection.contains(loginBtn)) {
                    rightSection.insertBefore(loginBtn, rightSection.firstChild);
                }
            }
        }

        // 点击汉堡切换菜单
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });

        // ========== 登录下拉菜单功能 ==========
        let loginHoverTimeout;

        // 鼠标进入登录按钮区域时显示下拉菜单
        loginBtn.addEventListener('mouseenter', function() {
            // 清除可能存在的隐藏延时
            clearTimeout(loginHoverTimeout);
            
            // 显示菜单
            loginDropdownMenu.classList.add('show');
            loginBtn.classList.add('active');
        });

        // 鼠标离开登录按钮区域时延迟隐藏下拉菜单
        loginBtn.addEventListener('mouseleave', function() {
            // 设置延时隐藏，给用户时间移动到下拉菜单
            loginHoverTimeout = setTimeout(() => {
                loginDropdownMenu.classList.remove('show');
                loginBtn.classList.remove('active');
            }, 100); // 200ms延迟
        });

        // 鼠标进入登录下拉菜单时保持显示
        loginDropdownMenu.addEventListener('mouseenter', function() {
            // 清除隐藏延时
            clearTimeout(loginHoverTimeout);
            
            // 确保菜单保持显示
            loginDropdownMenu.classList.add('show');
            loginBtn.classList.add('active');
        });

        // 鼠标离开登录下拉菜单时隐藏
        loginDropdownMenu.addEventListener('mouseleave', function() {
            loginDropdownMenu.classList.remove('show');
            loginBtn.classList.remove('active');
        });

        // 点击登录下拉菜单项时的处理
        const loginDropdownItems = document.querySelectorAll('.login-dropdown-item');
        loginDropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                console.log('选择了登录：', this.textContent);
                
                // 关闭下拉菜单
                loginDropdownMenu.classList.remove('show');
                loginBtn.classList.remove('active');
            });
        });

        // ========== 语言切换下拉菜单功能 ==========
        let languageHoverTimeout;

        // 鼠标进入语言按钮区域时显示下拉菜单
        languageBtn.addEventListener('mouseenter', function() {
            // 清除可能存在的隐藏延时
            clearTimeout(languageHoverTimeout);
            
            // 显示菜单
            languageDropdownMenu.classList.add('show');
            languageBtn.classList.add('active');
        });

        // 鼠标离开语言按钮区域时延迟隐藏下拉菜单
        languageBtn.addEventListener('mouseleave', function() {
            // 设置延时隐藏，给用户时间移动到下拉菜单
            languageHoverTimeout = setTimeout(() => {
                languageDropdownMenu.classList.remove('show');
                languageBtn.classList.remove('active');
            }, 200); // 200ms延迟
        });

        // 鼠标进入语言下拉菜单时保持显示
        languageDropdownMenu.addEventListener('mouseenter', function() {
            // 清除隐藏延时
            clearTimeout(languageHoverTimeout);
            
            // 确保菜单保持显示
            languageDropdownMenu.classList.add('show');
            languageBtn.classList.add('active');
        });

        // 鼠标离开语言下拉菜单时隐藏
        languageDropdownMenu.addEventListener('mouseleave', function() {
            languageDropdownMenu.classList.remove('show');
            languageBtn.classList.remove('active');
        });

        // 点击语言下拉菜单项时的处理
        const languageDropdownItems = document.querySelectorAll('.language-dropdown-item');
        languageDropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                console.log('选择了语言：', this.textContent);

                // 关闭下拉菜单（这仍然可以保留）
                languageDropdownMenu.classList.remove('show');
                languageBtn.classList.remove('active');
                
                // 更新语言按钮显示
                const selectedLang = this.getAttribute('data-lang');
                if (selectedLang === 'en') {
                    languageBtn.textContent = 'EN';
                } else {
                    languageBtn.textContent = 'CN';
                }
                
                // 关闭下拉菜单
                languageDropdownMenu.classList.remove('show');
                languageBtn.classList.remove('active');
                
                // 这里可以添加实际的语言切换逻辑
                console.log('切换到语言：', selectedLang);
            });
        });

        // ESC键关闭所有下拉菜单
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                loginDropdownMenu.classList.remove('show');
                loginBtn.classList.remove('active');
                languageDropdownMenu.classList.remove('show');
                languageBtn.classList.remove('active');
            }
        });

        // 点击页面其他地方关闭下拉菜单
        document.addEventListener('click', function(e) {
            // 如果点击的不是登录相关元素，关闭登录下拉菜单
            if (!loginBtn.contains(e.target) && !loginDropdownMenu.contains(e.target)) {
                loginDropdownMenu.classList.remove('show');
                loginBtn.classList.remove('active');
            }
            
            // 如果点击的不是语言相关元素，关闭语言下拉菜单
            if (!languageBtn.contains(e.target) && !languageDropdownMenu.contains(e.target)) {
                languageDropdownMenu.classList.remove('show');
                languageBtn.classList.remove('active');
            }
        });

        // 页面加载时处理
        window.addEventListener('DOMContentLoaded', moveLoginBtn);

        // 窗口大小改变时也处理，防止resize后login位置错乱
        window.addEventListener('resize', moveLoginBtn);
    </script>
<script>
        // 通用的 animate-on-scroll observer（保持原有逻辑）
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const container = entry.target;

                if (entry.isIntersecting) {
                    container.classList.add('visible');

                    container.querySelectorAll('.scale-fade-in').forEach(el => {
                        el.style.animation = 'none';
                        el.offsetHeight;
                        el.style.animation = '';
                        el.style.animationPlayState = 'running';
                    });

                } else {
                    container.classList.remove('visible');

                    container.querySelectorAll('.scale-fade-in').forEach(el => {
                        el.style.animation = 'none';
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(20px)';
                        el.offsetHeight;
                        el.style.animation = '';
                        el.style.animationPlayState = 'paused';
                    });
                }
            });
        }, {
            threshold: 0.2
        });

        // AboutUs 专用的 IntersectionObserver - 支持重复触发
        const aboutObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const target = entry.target;

                if (entry.isIntersecting) {
                    // 直接触发动画，不再等待图片加载
                    if (target.classList.contains('aboutus-banner')) {
                        target.classList.add('content-loaded');
                    } else if (target.classList.contains('aboutus-intro')) {
                        target.classList.add('intro-loaded');
                    }
                } else {
                    // 离开视窗时移除动画类，重置状态
                    if (target.classList.contains('aboutus-banner')) {
                        target.classList.remove('content-loaded');
                    } else if (target.classList.contains('aboutus-intro')) {
                        target.classList.remove('intro-loaded');
                    }
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -10% 0px'
        });

        // 时间线专用的 IntersectionObserver - 支持重复触发
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const timelineSection = entry.target;

                if (entry.isIntersecting) {
                    // 进入视窗时启动时间线动画
                    timelineSection.classList.add('timeline-active');
                    resetAndStartTimelineAnimation(timelineSection);
                } else {
                    // 离开视窗时重置动画状态
                    timelineSection.classList.remove('timeline-active');
                    resetTimelineAnimation(timelineSection);
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -20% 0px'
        });

        // 重置并启动时间线动画
        function resetAndStartTimelineAnimation(timelineSection) {
            const title = timelineSection.querySelector('h1');
            const track = timelineSection.querySelector('.timeline-track');
            const container = timelineSection.querySelector('.timeline-items-container');
            const items = timelineSection.querySelectorAll('.timeline-item');
            const arrows = timelineSection.querySelectorAll('.nav-arrow');

            // 重置所有元素的动画
            [title, track, container, ...items, ...arrows].forEach(el => {
                if (el) {
                    el.style.animation = 'none';
                    el.offsetHeight; // 强制重排
                    el.style.animation = ''; // 恢复原始动画
                }
            });
        }

        // 重置时间线动画状态
        function resetTimelineAnimation(timelineSection) {
            const title = timelineSection.querySelector('h1');
            const track = timelineSection.querySelector('.timeline-track');
            const container = timelineSection.querySelector('.timeline-items-container');
            const items = timelineSection.querySelectorAll('.timeline-item');
            const arrows = timelineSection.querySelectorAll('.nav-arrow');

            // 重置标题
            if (title) {
                title.style.opacity = '0';
                title.style.transform = 'translateY(20px)';
            }

            // 重置轨道
            if (track) {
                track.style.transform = 'translateY(-50%) scaleX(0)';
            }

            // 重置容器
            if (container) {
                container.style.opacity = '0';
            }

            // 重置项目
            items.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.5) translateY(20px)';
            });

            // 重置箭头
            arrows.forEach(arrow => {
                arrow.style.opacity = '0';
                arrow.style.transform = 'translateY(-50%) scale(0.8)';
            });
        }

        // 初始化观察器
        document.addEventListener('DOMContentLoaded', () => {
            // 初始化通用 animate-on-scroll 观察器
            document.querySelectorAll('.animate-on-scroll').forEach(container => {
                container.querySelectorAll('.scale-fade-in').forEach(el => {
                    el.style.animationPlayState = 'paused';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                });
                observer.observe(container);
            });

            // 初始化 aboutus 观察器
            const aboutBanner = document.querySelector('.aboutus-banner');
            const aboutIntro = document.querySelector('.aboutus-intro');
            
            if (aboutBanner) {
                aboutObserver.observe(aboutBanner);
            }
            
            if (aboutIntro) {
                aboutObserver.observe(aboutIntro);
            }

            // 初始化时间线观察器
            const timelineSection = document.querySelector('.timeline-section');
            if (timelineSection) {
                // 初始化时间线元素状态
                resetTimelineAnimation(timelineSection);
                timelineObserver.observe(timelineSection);
            }

            // 页面加载完成后立即检查可见元素并触发动画
            setTimeout(() => {
                const banner = document.querySelector('.aboutus-banner');
                const intro = document.querySelector('.aboutus-intro');
                const timeline = document.querySelector('.timeline-section');
                
                if (banner && isElementInViewport(banner)) {
                    banner.classList.add('content-loaded');
                }
                
                if (intro && isElementInViewport(intro)) {
                    intro.classList.add('intro-loaded');
                }

                if (timeline && isElementInViewport(timeline)) {
                    timeline.classList.add('timeline-active');
                    resetAndStartTimelineAnimation(timeline);
                }
            }, 100); // 给DOM一点时间完成渲染
        });

        // 检查元素是否在视窗内
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top < (window.innerHeight || document.documentElement.clientHeight) &&
                rect.bottom > 0 &&
                rect.left < (window.innerWidth || document.documentElement.clientWidth) &&
                rect.right > 0
            );
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // 恢复到你原来的配置，只添加最小的修改
const swiper = new Swiper('.swiper', {
    direction: 'vertical',
    mousewheel: true,
    speed: 800,
    simulateTouch: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    // 添加这个配置来处理不同高度的slide
    slidesPerView: 'auto',
    spaceBetween: 0,
    on: {
        slideChange: function() {
            // 更新页面指示器
            updatePageIndicator(this.activeIndex);
        },
        // 添加这个事件来处理最后一页的特殊情况
        reachEnd: function() {
            // 确保最后一页正确显示
            this.allowTouchMove = true;
        },
        // 添加进度监听来处理最后一页的双向滑动
        setTransition: function(duration) {
            // 在过渡结束后检查进度
            setTimeout(() => {
                if (this.progress > 0.95) {
                    updatePageIndicator(4); // 滑到最后一页
                } else {
                    updatePageIndicator(this.activeIndex); // 从最后一页滑回来时用正常的activeIndex
                }
            }, duration + 50);
        }
    }
});

// 页面指示器功能
const pageDots = document.querySelectorAll('.page-dot');

// 点击圆点跳转到对应页面
pageDots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        swiper.slideTo(index);
    });
});

// 更新页面指示器状态
function updatePageIndicator(activeIndex) {
    pageDots.forEach((dot, index) => {
        if (index === activeIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

// 初始化页面指示器
updatePageIndicator(0);
    </script>
<script>
        // 页面加载完成后的处理 - 简化版本
        window.addEventListener('load', () => {
            // 启动navbar动画 - 页面加载完成就可以开始
            const navbar = document.querySelector('.navbar');
            if (navbar) navbar.classList.add('navbar-loaded');
            
            // 显示社交侧边栏
            const socialSidebar = document.querySelector('.social-sidebar');
            if (socialSidebar) socialSidebar.classList.add('social-loaded');
            
            // 显示页面指示器
            const pageIndicator = document.querySelector('.page-indicator');
            if (pageIndicator) pageIndicator.classList.add('indicator-loaded');
        });
    </script>
<script>
        let currentIndex = 0;
        let years = <?php echo json_encode(getTimelineYears()); ?>;
        let totalItems = years.length;
        const navItems = document.querySelectorAll('.timeline-item');
        const container = document.getElementById('timelineContainer');

        // 拖拽相关变量 - 优化后的设置
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let dragThreshold = 15; // 增加阈值，减少误触
        let hasTriggered = false;
        let dragStartTime = 0; // 记录拖拽开始时间
        let isAnimating = false; // 防止动画期间的操作冲突

        function updateTimelineNav() {
            const navItems = document.querySelectorAll('.timeline-item');
            
            // 更新导航状态
            navItems.forEach((item, index) => {
                item.classList.toggle('active', index === currentIndex);
            });

            // 平滑滚动到居中位置
            const containerWidth = container.parentElement.offsetWidth;
            const itemWidth = 120;
            const centerOffset = containerWidth / 2 - itemWidth / 2;
            const translateX = centerOffset - (currentIndex * itemWidth);
            
            // 使用CSS transition实现平滑滚动
            container.style.transition = 'transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            container.style.transform = `translateX(${translateX}px)`;
            
            // 清除transition，避免影响后续操作
            setTimeout(() => {
                container.style.transition = '';
            }, 400);
        }

        function updateCardPositions() {
            const cards = document.querySelectorAll('.timeline-content-item');
            
            cards.forEach((card, index) => {
                card.classList.remove('active', 'prev', 'next', 'hidden', 'stack-hidden');
                
                // 添加平滑过渡效果
                card.style.transition = 'all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                
                if (index === currentIndex) {
                    // 当前活动卡片
                    card.classList.add('active');
                    card.style.zIndex = '10';
                } else if (index === (currentIndex - 1 + totalItems) % totalItems) {
                    // 左侧卡片
                    card.classList.add('prev');
                    card.style.zIndex = '5';
                } else if (index === (currentIndex + 1) % totalItems) {
                    // 右侧卡片
                    card.classList.add('next');
                    card.style.zIndex = '5';
                } else {
                    // 其他卡片都隐藏在中间后面，形成堆叠效果
                    card.classList.add('stack-hidden');
                    card.style.zIndex = '1';
                }
            });
            
            // 清除transition，避免影响后续操作
            setTimeout(() => {
                cards.forEach(card => {
                    card.style.transition = '';
                });
            }, 400);
        }

        function navigateTimeline(direction) {
            if (isAnimating) return;
            
            isAnimating = true;
            
            if (direction === 'next') {
                currentIndex = (currentIndex + 1) % totalItems;
            } else {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            }
            
            updateTimelineNav();
            updateCardPositions();
            
            // 动画完成后重置标志
            setTimeout(() => {
                isAnimating = false;
            }, 400); // 增加到600ms匹配新的动画时长
        }

        function selectCard(year) {
            if (isAnimating) return;
            
            const index = years.indexOf(year.toString());
            if (index !== -1 && index !== currentIndex) {
                currentIndex = index;
                showTimelineItem(year.toString());
            }
        }

        function showTimelineItem(year) {
            updateTimelineNav();
            updateCardPositions();
            currentIndex = years.indexOf(year);
        }

        // 优化后的拖拽处理
        function handleDragStart(e) {
            if (isAnimating) return;
            
            const clickedCard = e.target.closest('.timeline-content-item');
            if (!clickedCard) return;
            
            isDragging = true;
            hasTriggered = false;
            dragStartTime = Date.now();
            startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
            
            document.body.style.cursor = 'grabbing';
            document.body.style.userSelect = 'none';
            
            e.preventDefault();
            e.stopPropagation();
        }

        function handleDragMove(e) {
            if (!isDragging || hasTriggered || isAnimating) return;
            
            currentX = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
            const deltaX = currentX - startX;
            const dragTime = Date.now() - dragStartTime;
            
            // 增加时间限制，避免过快触发
            if (Math.abs(deltaX) >= dragThreshold && dragTime > 50) {
                hasTriggered = true;
                
                if (deltaX > 0) {
                    navigateTimeline('prev');
                } else {
                    navigateTimeline('next');
                }
                
                // 延迟结束拖拽，给动画时间
                setTimeout(() => {
                    handleDragEnd(e);
                }, 50);
            }
            
            e.preventDefault();
        }

        function handleDragEnd(e) {
            if (!isDragging) return;
            
            isDragging = false;
            hasTriggered = false;
            dragStartTime = 0;
            
            document.body.style.cursor = '';
            document.body.style.userSelect = '';
            
            startX = 0;
            currentX = 0;
        }

        // 改进的事件监听器
        let clickTimeout;

        document.addEventListener('mousedown', (e) => {
            const card = e.target.closest('.timeline-content-item');
            if (card && !isAnimating) {
                // 清除之前的点击超时
                if (clickTimeout) {
                    clearTimeout(clickTimeout);
                }
                handleDragStart(e);
            }
        });

        document.addEventListener('mousemove', handleDragMove);
        document.addEventListener('mouseup', handleDragEnd);
        document.addEventListener('mouseleave', handleDragEnd);

        // 触摸事件
        document.addEventListener('touchstart', (e) => {
            const card = e.target.closest('.timeline-content-item');
            if (card && !isAnimating) {
                handleDragStart(e);
            }
        }, { passive: false });

        document.addEventListener('touchmove', handleDragMove, { passive: false });
        document.addEventListener('touchend', handleDragEnd);

        // 导航项点击
        navItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                if (!isDragging && !isAnimating) {
                    currentIndex = index;
                    showTimelineItem(years[currentIndex]);
                }
            });
        });

        // 优化的点击处理 - 添加延迟避免与拖拽冲突
        document.addEventListener('click', (e) => {
            if (isDragging || hasTriggered || isAnimating) return;
            
            const card = e.target.closest('.timeline-content-item');
            if (card && !card.classList.contains('active')) {
                // 添加小延迟确保不是拖拽操作
                clickTimeout = setTimeout(() => {
                    if (!isDragging) {
                        const year = card.getAttribute('data-year');
                        selectCard(year);
                    }
                }, 10);
            }
        });

        // 键盘导航
        document.addEventListener('keydown', (e) => {
            if (!isAnimating) {
                if (e.key === 'ArrowLeft') {
                    navigateTimeline('prev');
                } else if (e.key === 'ArrowRight') {
                    navigateTimeline('next');
                }
            }
        });

        // 防止文本选择
        document.addEventListener('selectstart', (e) => {
            if (isDragging) {
                e.preventDefault();
            }
        });

        // 初始化
        updateTimelineNav();
        updateCardPositions();

        // 窗口大小改变时重新计算位置
        window.addEventListener('resize', () => {
            if (!isAnimating) {
                setTimeout(() => {
                    updateTimelineNav();
                }, 100);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const bgMusic = document.getElementById('bgMusic');
        
        if (!bgMusic) {
            console.log('背景音乐元素未找到');
            return;
        }

        // 设置固定音量（例如 0.3 表示 30%）
        bgMusic.volume = 0.3;

        // 从 localStorage 恢复播放进度和状态
        const savedTime = localStorage.getItem('musicCurrentTime');
        const savedPlaying = localStorage.getItem('musicPlaying');
        const currentPage = window.location.pathname;

        if (savedTime) {
            bgMusic.currentTime = parseFloat(savedTime);
        }

        function tryPlay() {
            bgMusic.play().then(() => {
            localStorage.setItem('musicPlaying', 'true');
            localStorage.setItem('musicPage', currentPage);
            }).catch(error => {
            console.log('音乐播放失败:', error);
            });
        }

        // 如果之前在播放，立即继续播放
        if (savedPlaying === 'true') {
            // 稍微延迟以确保音频加载完成
            setTimeout(tryPlay, 100);
        }

        // 用户交互时开始播放
        const startEvents = ['click', 'keydown', 'touchstart'];
        const startPlay = () => {
            tryPlay();
            startEvents.forEach(event => {
            document.removeEventListener(event, startPlay);
            });
        };

        startEvents.forEach(event => {
            document.addEventListener(event, startPlay, { once: true });
        });

        // 定期保存播放进度
        setInterval(() => {
            if (!bgMusic.paused && bgMusic.currentTime > 0) {
            localStorage.setItem('musicCurrentTime', bgMusic.currentTime.toString());
            localStorage.setItem('musicPlaying', 'true');
            localStorage.setItem('musicPage', currentPage);
            }
        }, 1000);

        // 页面卸载前保存状态
        window.addEventListener('beforeunload', () => {
            if (bgMusic) {
            localStorage.setItem('musicCurrentTime', bgMusic.currentTime.toString());
            localStorage.setItem('musicPlaying', bgMusic.paused ? 'false' : 'true');
            localStorage.setItem('musicPage', currentPage);
            }
        });

        // 页面可见性变化时处理音乐
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
            // 页面变为可见时，检查是否应该继续播放
            const shouldPlay = localStorage.getItem('musicPlaying') === 'true';
            if (shouldPlay && bgMusic.paused) {
                tryPlay();
            }
            }
        });

        // 音乐加载错误处理
        bgMusic.addEventListener('error', (e) => {
            console.error('音乐加载失败:', e);
        });

        // 音乐加载成功处理
        bgMusic.addEventListener('loadeddata', () => {
            console.log('音乐加载完成');
        });
        });
    </script>
    <script>
        // 添加这个函数到你现有的JavaScript代码中
        function goToSlide(slideIndex) {
        if (typeof swiper !== 'undefined') {
            swiper.slideTo(slideIndex);
        }
        }

        // 或者，如果你想要更具体的跳转函数
        function goToAboutusIntro() {
        if (typeof swiper !== 'undefined') {
            swiper.slideTo(0);
        }
        }

        function goToVision() {
        if (typeof swiper !== 'undefined') {
            swiper.slideTo(1); // 跳转到第3个slide（公司文化）
        }
        }

        function goToValues() {
        if (typeof swiper !== 'undefined') {
            swiper.slideTo(2); // 跳转到第3个slide（公司文化）
        }
        }

        function goToTimeline() {
        if (typeof swiper !== 'undefined') {
            swiper.slideTo(3); // 跳转到第3个slide（公司文化）
        }
        }
    </script>
    <script>
    // 导航栏旗下品牌下拉菜单控制
    const navBrandsDropdown = document.querySelector('.nav-item.nav-dropdown');
    const navBrandsDropdownMenu = document.getElementById('brandsNavDropdownMenu');

    if (navBrandsDropdown && navBrandsDropdownMenu) {
        navBrandsDropdown.addEventListener('mouseenter', function() {
            navBrandsDropdownMenu.classList.add('show');
        });

        navBrandsDropdown.addEventListener('mouseleave', function() {
            navBrandsDropdownMenu.classList.remove('show');
        });
    }
</script>
</body>
</html>