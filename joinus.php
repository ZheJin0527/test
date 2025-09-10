<?php
session_start();
include_once 'media_config.php';

// 禁用页面缓存
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNZZ HOLDINGS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="joinusanimation.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
        <div class="page-dot" data-slide="5"></div>
    </div>

<div class="swiper">
  <div class="swiper-wrapper">

  <div class="swiper-slide">
  <section class="joinus-section">
    <!-- 上半部分：加入我们 -->
    <div class="joinus-banner">
        <?php echo getMediaHtml('joinus_background', ['style' => 'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;']); ?>
        <div class="joinus-content">
            <h1>加入我们</h1>
            <p>在这里，你的努力不止换来薪资，更参与到品牌建设的每一步，一起迈向更大的舞台。</p>
        </div>
    </div>

    <!-- 下半部分：员工福利 -->
    <div class="benefits-wrapper" id="benefits">
      <h2>公司福利</h2>
      <div class="benefits-grid">
        <div class="benefit-item">
          <img src="images/images/带薪假期.png" alt="带薪假期">
          <p>带薪假期</p>
        </div>
        <div class="benefit-item">
          <img src="images/images/旅游奖励.png" alt="旅游奖励">
          <p>旅游奖励</p>
        </div>
        <div class="benefit-item">
          <img src="images/images/汽车奖励.png" alt="汽车奖励">
          <p>汽车奖励</p>
        </div>
        <div class="benefit-item">
          <img src="images/images/房子奖励.png" alt="房子奖励">
          <p>房子奖励</p>
        </div>
        <div class="benefit-item">
          <img src="images/images/年度绩效奖励.png" alt="年度绩效奖励">
          <p>年度绩效奖励</p>
        </div>
        <div class="benefit-item">
          <img src="images/images/专业培训与学习机会.png" alt="专业培训与学习机会">
          <p>专业培训与学习机会</p>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="swiper-slide">
<div class="comphoto-section" id="comphoto-container">
  <div class="comphoto-title">我们的足迹</div>
    </div>
    <div id="comphoto-modal" class="comphoto-modal">
        <span class="comphoto-close">&times;</span>
        <div class="comphoto-modal-content">
            <img id="comphoto-modal-img" src="" alt="放大的照片">
        </div>
    </div>
  </div>

<div class="swiper-slide">
  <div class="particles" id="particles"></div>

    <div class="job-section">
        <div class="job-table-container">
        <h2 class="job-table-title">目前在招聘的职位</h2>
        </div>
        
        <!-- 分类按钮 -->
        <div class="category-buttons">
            <button class="category-btn active" data-category="KUNZZHOLDINGS">KUNZZHOLDINGS</button>
            <button class="category-btn" data-category="TOKYO CUISINE">TOKYO CUISINE</button>
        </div>
        
        <div class="jobs-grid">
    <?php echo getJobsHtml(); ?>
    </div>
</div>

    <!-- 弹窗表单 -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeForm()">&times;</span>
            <form id="jobApplicationForm" action="https://formsubmit.co/joeytan801@gmail.com" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_redirect" value="https://kunzzgroup.com/success.html">
                <input type="hidden" name="_captcha" value="false">
                <h2>申请职位</h2>
                <label>职位名称：</label>
                <input type="text" id="formPosition" name="position" readonly>
                <label>中文姓名：</label>
                <input type="text" name="chinese_name" required pattern="[\u4e00-\u9fa5]{2,}" title="请输入中文姓名（至少两个汉字）">
                <label>英文姓名：</label>
                <input type="text" name="english_name" required pattern="[A-Za-z ]{2,}" title="请输入英文姓名（只限英文字母）">
                <label>电子邮箱：</label>
                <input type="email" name="email" required>
                <label>电话号码：</label>
                <div class="phone-group">
                    <select name="country_code" required>
                        <option value="+60">马来西亚 (+60)</option>
                        <option value="+65">新加坡 (+65)</option>
                        <option value="+86">中国 (+86)</option>
                        <option value="+852">香港 (+852)</option>
                        <option value="+81">日本 (+81)</option>
                    </select>
                    <input type="tel" name="phone" required pattern="\d{1,10}" maxlength="10" title="请输入最多10位数字的电话号码">
                </div>
                <label>性别：</label>
                <select name="gender" required>
                    <option value="">请选择</option>
                    <option value="male">男</option>
                    <option value="female">女</option>
                    <option value="other">其他</option>
                </select>
                <label>上传简历（PDF，≤3MB）：</label>
                <input type="file" name="resume" id="resume" accept=".pdf" required>
                <button type="submit" class="submit-btn">提交申请</button>
            </form>
        </div>
    </div>
  </div>    

  <!-- 意见表格 -->
  <div class="swiper-slide">
  <div class="form-wrapper">
  <h2 class="main-title">请提供您宝贵的意见</h2>
  <section class="join-us-form"> 
    <form id="jobApplicationForm" action="https://api.web3forms.com/submit" method="POST" enctype="multipart/form-data">

      <!-- 中文姓名 + 性别 -->
      <div class="form-group-row">
        <div class="half-width">
          <label for="chineseName">中文姓名*</label>
          <input type="hidden" name="access_key" value="a18bc4c6-2f16-4861-8d10-a3de747cab50">
          <input type="hidden" name="redirect" value="https://kunzzgroup.com/success.html">
          <input type="text" id="chineseName" name="chineseName" placeholder="请输入中文姓名" required pattern="[\u4e00-\u9fa5]{2,}" title="请输入中文姓名（至少两个汉字）">
        </div>

        <div class="half-width">
          <label>性别*</label>
          <div class="gender-options">
            <label><input type="radio" name="gender" value="male" required> 男</label>
            <label><input type="radio" name="gender" value="female" required> 女</label>
          </div>
        </div>
      </div>

      <!-- 英文姓名 + 职位类别 -->
      <div class="form-group-row">
        <div class="half-width">
          <label for="englishName">英文姓名*</label>
          <input type="text" id="englishName" name="englishName" placeholder="请输入英文姓名" required pattern="[A-Za-z ]{2,}" title="请输入英文姓名（只限字母）">
        </div>
      </div>

      <!-- 手机号码 -->
      <div class="form-group">
        <label for="phone">手机号码*</label>
        <div class="phone-input">
          <select id="countryCode" name="countryCode" required>
            <option value="+60">马来西亚 (+60)</option>
            <option value="+65">新加坡 (+65)</option>
            <option value="+86">中国 (+86)</option>
            <option value="+852">香港 (+852)</option>
            <option value="+81">日本 (+81)</option>
            <!-- 可以加更多国家 -->
          </select>
          <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="请输入电话号码" required pattern="\d{1,10}" maxlength="10" inputmode="numeric" title="请输入正确手机号">
        </div>
      </div>

      <!-- 电子邮箱 -->
      <div class="form-group">
        <label for="email">电子邮箱*</label>
        <input type="email" id="email" name="email" placeholder="请输入邮箱地址" required pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" title="请输入正确邮箱地址">
      </div>

      <!-- 信息 -->
      <div class="form-group">
        <label for="message">信息*</label>
        <textarea id="message" name="message" rows="5" required></textarea>
      </div>

      <!-- 提交按钮 -->
      <div class="form-group">
        <button type="submit" class="submit-btn">提交</button>
      </div>
    </form>
</section>
</div>
</div>  

<div class="swiper-slide">
  <div class="contact-section-wrapper" id="map">
  <section class="contact-container">
  <div class="contact-info">
    <h2>联系我们</h2>
    <p>公司名称：Kunzz Holdings Sdn. Bhd.</p>
    <p>
      地址：
      <a href="javascript:void(0);" onclick="goToLocation()" class="no-style-link">
        25, Jln Tanjong 3, Taman Desa Cemerlang, 81800 Ulu Tiram, Johor Darul Ta'zim
      </a>
    </p>
    <p>电话：+60 13-553 5355</p>
    <p>邮箱：kunzzholdings@gmail.com</p>
    <p>营业时间：周一至周五 9AM-6PM</p>
  </div>

  <div class="map-container">
    <iframe
      id="custom-map"
      src="https://www.google.com/maps/d/embed?mid=1WGUSQUviVSNKcc7LNK-aSDA6j6S3EMc&ehbc=2E312F"
      width="640"
      height="480"
    ></iframe>
  </div>
</section>
</div>
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
        <li><a href="about.php#intro">集团简介</a></li>
        <li><a href="about.php#vision">信念与方向</a></li>
        <li><a href="about.php#values">核心价值观</a></li>
        <li><a href="about.php#timeline-1">发展历史</a></li>
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
        <li><a href="#" onclick="goToSlide(0); return false;">公司福利</li>
        <li><a href="#" onclick="goToSlide(1); return false;">我们的足迹</li>
        <li><a href="#" onclick="goToSlide(2); return false;">招聘的职位</li>
        <li><a href="#" onclick="goToSlide(4); return false;">联系我们</a></li>        
      </ul>
    </div>
  </footer>

  <button id="backToTop" onclick="scrollToTop()">&#8673;</button>
  
  <div class="footer-bottom">
    © 2025 Kunzz Holdings Sdn. Bhd. All rights reserved.
  </div>
  </section>
  </div>
</div>

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

// AboutUs & JoinUs & CompPhoto & JobTable & JobCards & Contact 专用的 IntersectionObserver - 支持重复触发
const aboutObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        const target = entry.target;

        if (entry.isIntersecting) {
            // 直接触发动画，不再等待图片加载
            if (target.classList.contains('aboutus-banner')) {
                target.classList.add('content-loaded');
            } else if (target.classList.contains('aboutus-intro')) {
                target.classList.add('intro-loaded');
            } else if (target.classList.contains('joinus-banner')) {
                target.classList.add('joinus-loaded');
            } else if (target.classList.contains('benefits-wrapper')) {
                target.classList.add('benefits-loaded');
            } else if (target.id === 'comphoto-container') {
                // 为"我们的足迹"容器添加动画类
                target.classList.add('comphoto-loaded');
            } else if (target.classList.contains('job-table-container')) {
                // 为招聘职位容器添加动画类
                target.classList.add('job-table-loaded');
            } else if (target.classList.contains('jobs-grid')) {
                // 为职位卡片网格添加动画类
                target.classList.add('jobs-loaded');
            } else if (target.classList.contains('contact-section-wrapper')) {
                // 为联系我们区域添加动画类
                target.classList.add('contact-loaded');
            }
        } else {
            // 离开视窗时移除动画类，重置状态
            if (target.classList.contains('aboutus-banner')) {
                target.classList.remove('content-loaded');
            } else if (target.classList.contains('aboutus-intro')) {
                target.classList.remove('intro-loaded');
            } else if (target.classList.contains('joinus-banner')) {
                target.classList.remove('joinus-loaded');
            } else if (target.classList.contains('benefits-wrapper')) {
                target.classList.remove('benefits-loaded');
            } else if (target.id === 'comphoto-container') {
                // 离开视窗时移除动画类
                target.classList.remove('comphoto-loaded');
            } else if (target.classList.contains('job-table-container')) {
                // 离开视窗时移除动画类
                target.classList.remove('job-table-loaded');
            } else if (target.classList.contains('jobs-grid')) {
                // 离开视窗时移除动画类
                target.classList.remove('jobs-loaded');
            } else if (target.classList.contains('contact-section-wrapper')) {
                // 离开视窗时移除动画类
                target.classList.remove('contact-loaded');
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

    // 初始化 aboutus & joinus & comphoto & jobtable & jobcards & contact 观察器
    const aboutBanner = document.querySelector('.aboutus-banner');
    const aboutIntro = document.querySelector('.aboutus-intro');
    const joinusBanner = document.querySelector('.joinus-banner');
    const benefitsWrapper = document.querySelector('.benefits-wrapper');
    const compPhotoContainer = document.querySelector('#comphoto-container');
    const jobTableContainer = document.querySelector('.job-table-container');
    const jobsGrid = document.querySelector('.jobs-grid');
    const contactWrapper = document.querySelector('.contact-section-wrapper');
    
    if (aboutBanner) {
        aboutObserver.observe(aboutBanner);
    }
    
    if (aboutIntro) {
        aboutObserver.observe(aboutIntro);
    }

    if (joinusBanner) {
        aboutObserver.observe(joinusBanner);
    }

    if (benefitsWrapper) {
        aboutObserver.observe(benefitsWrapper);
    }

    // 添加"我们的足迹"容器的观察器
    if (compPhotoContainer) {
        aboutObserver.observe(compPhotoContainer);
    }

    // 添加招聘职位容器的观察器
    if (jobTableContainer) {
        aboutObserver.observe(jobTableContainer);
    }

    // 添加职位卡片网格的观察器
    if (jobsGrid) {
        aboutObserver.observe(jobsGrid);
    }

    // 添加联系我们区域的观察器
    if (contactWrapper) {
        aboutObserver.observe(contactWrapper);
    }

    // 初始化时间线观察器
    const timelineSection = document.querySelector('.timeline-section');
    if (timelineSection) {
        // 初始化时间线元素状态
        resetTimelineAnimation(timelineSection);
        timelineObserver.observe(timelineSection);
    }
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
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const homeContent = document.querySelector('.home-content');
    const navbar = document.querySelector('.navbar');
    const socialSidebar = document.querySelector('.social-sidebar');
    const pageIndicator = document.querySelector('.page-indicator');
    
    // 强制隐藏主内容，等待背景图加载
    if (homeContent) {
        homeContent.style.opacity = '0';
        homeContent.style.visibility = 'hidden';
        homeContent.style.transform = 'translateY(30px)';
    }
    
    console.log('开始加载背景图...');
    
    const bgImg = new Image();
    bgImg.src = "images/images/加入我们bg2.jpg";

    bgImg.onload = function () {
        console.log('背景图加载完成！开始显示动画');
        
        // 背景图加载完成后，立即触发导航栏等元素的动画
        if (navbar) {
            navbar.classList.add('navbar-loaded');
        }
        
        if (socialSidebar) {
            socialSidebar.classList.add('social-loaded');
        }
        
        if (pageIndicator) {
            pageIndicator.classList.add('indicator-loaded');
        }
        
        // 显示背景渐变
        const homeSection = document.querySelector('.home');
        if (homeSection) {
            homeSection.classList.add('gradient-loaded');
        }
        
        // 显示主要内容
        if (homeContent) {
            homeContent.style.opacity = '1';
            homeContent.style.visibility = 'visible';
            homeContent.style.transform = 'translateY(0)';
            homeContent.style.transition = 'all 0.8s ease-out';
            homeContent.classList.remove('hidden');
        }
    };
    
    bgImg.onerror = function () {
        console.error('背景图加载失败，但仍显示界面元素');
        
        // 即使背景图加载失败，也要显示界面元素
        if (navbar) {
            navbar.classList.add('navbar-loaded');
        }
        
        if (socialSidebar) {
            socialSidebar.classList.add('social-loaded');
        }
        
        if (pageIndicator) {
            pageIndicator.classList.add('indicator-loaded');
        }
        
        if (homeContent) {
            homeContent.style.opacity = '1';
            homeContent.style.visibility = 'visible';
            homeContent.style.transform = 'translateY(0)';
            homeContent.classList.remove('hidden');
        }
    };

    // 添加超时保护：如果5秒内背景图还没加载完成，强制显示所有元素
    setTimeout(() => {
        if (!navbar || !navbar.classList.contains('navbar-loaded')) {
            console.log('超时保护：强制开始动画');
            
            if (navbar) navbar.classList.add('navbar-loaded');
            if (socialSidebar) socialSidebar.classList.add('social-loaded');
            if (pageIndicator) pageIndicator.classList.add('indicator-loaded');
            
            if (homeContent && homeContent.style.opacity === '0') {
                homeContent.style.opacity = '1';
                homeContent.style.visibility = 'visible';
                homeContent.style.transform = 'translateY(0)';
                homeContent.classList.remove('hidden');
            }
        }
    }, 5000);
});
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
                    updatePageIndicator(5); // 滑到最后一页
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
const totalItems = 3;
const years = ['2022', '2023', '2025'];
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
    // 更新导航状态
    navItems.forEach((item, index) => {
        item.classList.toggle('active', index === currentIndex);
    });

    // 计算居中位置
    const containerWidth = container.parentElement.offsetWidth;
    const itemWidth = 120;
    const centerOffset = containerWidth / 2 - itemWidth / 2;
    const translateX = centerOffset - (currentIndex * itemWidth);
    
    container.style.transform = `translateX(${translateX}px)`;
}

function updateCardPositions() {
    const cards = document.querySelectorAll('.timeline-content-item');
    
    cards.forEach((card, index) => {
        card.classList.remove('active', 'prev', 'next', 'hidden');
        
        if (index === currentIndex) {
            card.classList.add('active');
        } else if (index === (currentIndex - 1 + totalItems) % totalItems) {
            card.classList.add('prev');
        } else if (index === (currentIndex + 1) % totalItems) {
            card.classList.add('next');
        } else {
            card.classList.add('hidden');
        }
    });
}

function navigateTimeline(direction) {
    if (isAnimating) return; // 防止动画期间重复触发
    
    isAnimating = true;
    
    if (direction === 'next') {
        currentIndex = (currentIndex + 1) % totalItems;
    } else {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    }
    
    showTimelineItem(years[currentIndex]);
    
    // 动画完成后重置标志
    setTimeout(() => {
        isAnimating = false;
    }, 300); // 假设动画时长为300ms
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
  function goToLocation() {
    const map = document.getElementById('custom-map');

    // ⚠️ 这里请替换成你 My Maps 中标记具体地点的链接（可以在地图中点击目标点 → 分享 → 嵌入地图 获取新的 URL）
    map.src = "https://www.google.com/maps/d/embed?mid=1WGUSQUviVSNKcc7LNK-aSDA6j6S3EMc&ehbc=2E312F#target-location";
  }
</script>
<script>
        // 示例照片数组
        const photos = <?php echo json_encode(getCompanyPhotos()); ?>;
        const comphotoContainer = document.getElementById('comphoto-container');
        const comphotoModal = document.getElementById('comphoto-modal');
        const comphotoModalImg = document.getElementById('comphoto-modal-img');
        const comphotoModalContent = document.querySelector('.comphoto-modal-content');
        const comphotoCloseBtn = document.querySelector('.comphoto-close');

        // 照片数据存储
        const photoData = [];
        let currentClickedImg = null;
        let animationId = null;
        let isPaused = false;

        // 物理参数
        const PHOTO_WIDTH = 120;
        const PHOTO_HEIGHT = 80;
        const NAVBAR_HEIGHT = 80;
        const PHOTO_MARGIN = 10;

        // 存储已占用的位置
        const occupiedPositions = [];

        // 生成合适的斜线角度 - 确保明显的斜线运动
        function generateDiagonalAngle() {
            // 定义允许的角度范围，避免接近水平和垂直
            const minAngle = Math.PI / 6;  // 30度
            const maxAngle = Math.PI / 3;  // 60度
            
            // 随机选择四个象限之一
            const quadrant = Math.floor(Math.random() * 4);
            let baseAngle;
            
            switch(quadrant) {
                case 0: // 第一象限 (右上)
                    baseAngle = Math.random() * (maxAngle - minAngle) + minAngle;
                    break;
                case 1: // 第二象限 (左上)
                    baseAngle = Math.PI - (Math.random() * (maxAngle - minAngle) + minAngle);
                    break;
                case 2: // 第三象限 (左下)
                    baseAngle = Math.PI + (Math.random() * (maxAngle - minAngle) + minAngle);
                    break;
                case 3: // 第四象限 (右下)
                    baseAngle = 2 * Math.PI - (Math.random() * (maxAngle - minAngle) + minAngle);
                    break;
            }
            
            return baseAngle;
        }

        // 根据角度生成速度向量
        function generateVelocityFromAngle(angle) {
            const speed = 0.6;
            return {
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed
            };
        }

        // 修正反弹后的角度，确保保持斜线运动
        function correctBounceAngle(vx, vy, isHorizontalBounce) {
            let newVx = vx, newVy = vy;
            
            if (isHorizontalBounce) {
                newVx = -vx; // 水平反弹
            } else {
                newVy = -vy; // 垂直反弹
            }
            
            // 计算当前角度
            let currentAngle = Math.atan2(newVy, newVx);
            if (currentAngle < 0) currentAngle += 2 * Math.PI;
            
            // 检查角度是否太接近水平或垂直方向
            const tolerance = Math.PI / 8; // 22.5度的容差
            const horizontalAngles = [0, Math.PI, 2 * Math.PI];
            const verticalAngles = [Math.PI / 2, 3 * Math.PI / 2];
            
            let needsCorrection = false;
            
            // 检查是否太接近水平方向
            for (let hAngle of horizontalAngles) {
                if (Math.abs(currentAngle - hAngle) < tolerance) {
                    needsCorrection = true;
                    break;
                }
            }
            
            // 检查是否太接近垂直方向
            if (!needsCorrection) {
                for (let vAngle of verticalAngles) {
                    if (Math.abs(currentAngle - vAngle) < tolerance) {
                        needsCorrection = true;
                        break;
                    }
                }
            }
            
            if (needsCorrection) {
                // 重新生成一个合适的斜线角度
                const newAngle = generateDiagonalAngle();
                const velocity = generateVelocityFromAngle(newAngle);
                return { vx: velocity.vx, vy: velocity.vy };
            }
            
            return { vx: newVx, vy: newVy };
        }

        // 检查两个矩形是否重叠
        function isOverlapping(pos1, pos2, width, height, margin) {
            return !(pos1.x + width + margin < pos2.x || 
                    pos2.x + width + margin < pos1.x || 
                    pos1.y + height + margin < pos2.y || 
                    pos2.y + height + margin < pos1.y);
        }

        // 生成不重叠的随机位置
        function getRandomNonOverlappingPosition() {
            const boundaries = getBoundaries();
            let attempts = 0;
            const maxAttempts = 200;
            
            while (attempts < maxAttempts) {
                const x = Math.random() * (boundaries.right - boundaries.left) + boundaries.left;
                const y = Math.random() * (boundaries.bottom - boundaries.top) + boundaries.top;
                
                const newPos = { x, y };
                
                let overlaps = false;
                for (let occupiedPos of occupiedPositions) {
                    if (isOverlapping(newPos, occupiedPos, PHOTO_WIDTH, PHOTO_HEIGHT, PHOTO_MARGIN)) {
                        overlaps = true;
                        break;
                    }
                }
                
                if (!overlaps) {
                    occupiedPositions.push(newPos);
                    return newPos;
                }
                
                attempts++;
            }
            
            // 备选网格布局
            const cols = Math.floor((boundaries.right - boundaries.left) / (PHOTO_WIDTH + PHOTO_MARGIN));
            const index = occupiedPositions.length;
            const col = index % cols;
            const row = Math.floor(index / cols);
            
            const fallbackPos = {
                x: boundaries.left + col * (PHOTO_WIDTH + PHOTO_MARGIN),
                y: boundaries.top + row * (PHOTO_HEIGHT + PHOTO_MARGIN)
            };
            
            occupiedPositions.push(fallbackPos);
            return fallbackPos;
        }

        // 获取边界
        function getBoundaries() {
            return {
                left: 0,
                right: window.innerWidth - PHOTO_WIDTH,
                top: NAVBAR_HEIGHT,
                bottom: window.innerHeight - PHOTO_HEIGHT
            };
        }

        // 创建照片元素和数据
        function createComphoto(src, index) {
            const img = document.createElement('img');
            img.src = src;
            img.className = 'comphoto';
            img.loading = 'lazy';
            
            const pos = getRandomNonOverlappingPosition();
            
            // 生成斜线角度和速度
            const angle = generateDiagonalAngle();
            const velocity = generateVelocityFromAngle(angle);
            
            img.style.left = pos.x + 'px';
            img.style.top = pos.y + 'px';
            
            img.addEventListener('click', function() {
                openComphotoModal(this);
            });
            
            const photoInfo = {
                element: img,
                x: pos.x,
                y: pos.y,
                vx: velocity.vx,
                vy: velocity.vy,
                index: index
            };
            
            photoData.push(photoInfo);
            return img;
        }

        // 更新照片位置
        function updatePhotos() {
            if (isPaused) return;
            
            const boundaries = getBoundaries();
            
            photoData.forEach(photo => {
                photo.x += photo.vx;
                photo.y += photo.vy;
                
                let bounced = false;
                let isHorizontalBounce = false;
                
                // 检查水平边界碰撞
                if (photo.x <= boundaries.left || photo.x >= boundaries.right) {
                    photo.x = Math.max(boundaries.left, Math.min(boundaries.right, photo.x));
                    bounced = true;
                    isHorizontalBounce = true;
                }
                
                // 检查垂直边界碰撞
                if (photo.y <= boundaries.top || photo.y >= boundaries.bottom) {
                    photo.y = Math.max(boundaries.top, Math.min(boundaries.bottom, photo.y));
                    bounced = true;
                    isHorizontalBounce = false;
                }
                
                if (bounced) {
                    // 使用修正后的反弹角度
                    const correctedVelocity = correctBounceAngle(photo.vx, photo.vy, isHorizontalBounce);
                    photo.vx = correctedVelocity.vx;
                    photo.vy = correctedVelocity.vy;
                    
                    // 碰撞时改变边框颜色
                    photo.element.style.borderColor = `hsl(${Math.random() * 360}, 70%, 70%)`;
                }
                
                photo.element.style.left = photo.x + 'px';
                photo.element.style.top = photo.y + 'px';
            });
        }

        // 动画循环
        function animate() {
            updatePhotos();
            animationId = requestAnimationFrame(animate);
        }

        // 初始化照片
        function initComphoto() {
            photos.forEach((photo, index) => {
                const photoElement = createComphoto(photo, index);
                comphotoContainer.appendChild(photoElement);
            });
            
            animate();
        }

        // 暂停/恢复动画
        function pauseAnimation() {
            isPaused = true;
        }

        function resumeAnimation() {
            isPaused = false;
        }

        // 丝滑打开模态框
        function openComphotoModal(clickedImg) {
            currentClickedImg = clickedImg;
            pauseAnimation();

            const rect = clickedImg.getBoundingClientRect();
            comphotoModalImg.src = clickedImg.src;
            comphotoModal.style.display = 'block';
            
            comphotoModalContent.style.left = rect.left + 'px';
            comphotoModalContent.style.top = rect.top + 'px';
            comphotoModalContent.style.width = rect.width + 'px';
            comphotoModalContent.style.height = rect.height + 'px';
            comphotoModalContent.style.borderRadius = '8px';
            
            document.body.style.overflow = 'hidden';
            clickedImg.classList.add('comphoto-hidden');
            comphotoModalContent.offsetHeight;
            
            requestAnimationFrame(() => {
                comphotoModal.classList.add('show');
                
                const scaleMultiplier = 8;
                const targetWidth = rect.width * scaleMultiplier;
                const targetHeight = rect.height * scaleMultiplier;
                
                const maxWidth = window.innerWidth * 0.9;
                const maxHeight = window.innerHeight * 0.9;
                
                let finalWidth = targetWidth;
                let finalHeight = targetHeight;
                
                if (targetWidth > maxWidth || targetHeight > maxHeight) {
                    const scaleDownRatio = Math.min(
                        maxWidth / targetWidth,
                        maxHeight / targetHeight
                    );
                    finalWidth = targetWidth * scaleDownRatio;
                    finalHeight = targetHeight * scaleDownRatio;
                }
                
                const targetLeft = (window.innerWidth - finalWidth) / 2;
                const targetTop = (window.innerHeight - finalHeight) / 1.5;
                
                comphotoModalContent.style.left = targetLeft + 'px';
                comphotoModalContent.style.top = targetTop + 'px';
                comphotoModalContent.style.width = finalWidth + 'px';
                comphotoModalContent.style.height = finalHeight + 'px';
                comphotoModalContent.style.borderRadius = '12px';
            });
        }

        // 关闭模态框
        function closeComphotoModal() {
            if (currentClickedImg) {
                const rect = currentClickedImg.getBoundingClientRect();
                
                comphotoModalContent.style.left = rect.left + 'px';
                comphotoModalContent.style.top = rect.top + 'px';
                comphotoModalContent.style.width = rect.width + 'px';
                comphotoModalContent.style.height = rect.height + 'px';
                comphotoModalContent.style.borderRadius = '8px';
            }
            
            comphotoModal.classList.remove('show');
            
            setTimeout(() => {
                comphotoModal.style.display = 'none';
                document.body.style.overflow = 'hidden';
                
                if (currentClickedImg) {
                    currentClickedImg.classList.remove('comphoto-hidden');
                }
                
                resumeAnimation();
                currentClickedImg = null;
            }, 500);
        }

        // 窗口大小改变时重新定位照片
        function handleResize() {
            occupiedPositions.length = 0;
            
            photoData.forEach(photo => {
                const newPos = getRandomNonOverlappingPosition();
                photo.x = newPos.x;
                photo.y = newPos.y;
                photo.element.style.left = photo.x + 'px';
                photo.element.style.top = photo.y + 'px';
            });
        }

        // 事件监听器
        comphotoCloseBtn.addEventListener('click', closeComphotoModal);
        
        comphotoModal.addEventListener('click', function(e) {
            if (e.target === comphotoModal) {
                closeComphotoModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeComphotoModal();
            }
        });

        window.addEventListener('resize', handleResize);

        // 初始化
        initComphoto();
    </script>
    <script>
        // 粒子动画初始化
function initParticles() {
    const particles = document.getElementById('particles');
    const particleCount = 50;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.width = Math.random() * 4 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.animationDelay = Math.random() * 6 + 's';
        particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
        particles.appendChild(particle);
    }
}

// 修改后的toggleDetail函数，现在直接接收card元素
function toggleDetail(card) {
    const details = card.querySelector('.job-details');
    
    // 关闭其他已展开的卡片
    document.querySelectorAll('.job-details.show').forEach(detail => {
        if (detail !== details) {
            detail.classList.remove('show');
            const otherCard = detail.closest('.job-card');
            otherCard.classList.remove('expanded');
        }
    });
    
    // 切换当前卡片
    details.classList.toggle('show');
    card.classList.toggle('expanded');
}

function openForm(position) {
    document.getElementById('formPosition').value = position;
    document.getElementById('formModal').style.display = 'flex';
}

function closeForm() {
    document.getElementById('formModal').style.display = 'none';
}

// 点击弹窗外部关闭
window.onclick = function(event) {
    const modal = document.getElementById('formModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// 初始化
document.addEventListener('DOMContentLoaded', function() {
    initParticles();
    
    // 为所有job-card添加点击事件监听器
    document.querySelectorAll('.job-card').forEach(card => {
        card.addEventListener('click', function(event) {
            // 如果点击的是Apply按钮，不触发展开功能
            if (event.target.classList.contains('apply-btn') || 
                event.target.closest('.apply-btn')) {
                return;
            }
            
            // 调用toggleDetail函数
            toggleDetail(this);
        });
    });
    
    // 分类筛选功能
    initCategoryFilter();
});

// 分类筛选功能
function initCategoryFilter() {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const jobCards = document.querySelectorAll('.job-card');
    
    // 初始化时显示KUNZZHOLDINGS的职位
    filterJobsByCategory('KUNZZHOLDINGS');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // 移除所有按钮的active类
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            // 为当前按钮添加active类
            this.classList.add('active');
            
            const selectedCategory = this.getAttribute('data-category');
            filterJobsByCategory(selectedCategory);
        });
    });
    
    function filterJobsByCategory(selectedCategory) {
        // 筛选职位卡片
        jobCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            
            if (cardCategory === selectedCategory) {
                card.style.display = 'block';
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                // 添加动画效果
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
    }
}
    </script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".job-card");
  cards.forEach(card => {
    card.addEventListener("transitionend", (e) => {
      // 只在transform或opacity动画结束后添加 interactive 类
      if (e.propertyName === "transform" || e.propertyName === "opacity") {
        card.classList.add("interactive");
      }
    }, { once: true }); // once 确保只触发一次
  });
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
function goToBenefits() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(0);
  }
}

function goToComphoto() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(1);
  }
}

function goToJob() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(2);
  }
}

function goToMap() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(4); // 跳转到第3个slide（公司文化）
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