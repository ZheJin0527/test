<?php
session_start();
include_once 'media_config.php';

// 禁用页面缓存
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 设置页面特定的变量
$pageTitle = 'KUNZZ HOLDINGS';
$additionalCSS = ['joinusanimation.css'];
$showPageIndicator = true;
$totalSlides = 6;

// 包含header
include 'header.php';
?>

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
        <div class="comphoto-ring-container">
            <div class="comphoto-ring" id="comphotoRing"></div>
        </div>
    </div>
        <div id="comphoto-modal" class="comphoto-modal">
            <span class="comphoto-close">&times;</span>
            <div class="comphoto-modal-content">
                <img id="comphoto-modal-img" src="" alt="放大的照片">
            </div>
        </div>
    </div>

<div class="swiper-slide">

    <div class="job-section">
        <div class="job-table-container">
            <h2 class="job-table-title">目前在招聘的职位</h2>
        </div>
    <div class ="jobs-wrapper">    
        <div class="jobs-container">
            <?php echo getJobsHtml(); ?>
        </div>
    </div>    
</div>

    <!-- 职位详情弹窗 -->
    <div id="jobDetailModal" class="modal">
        <div class="modal-content job-detail-modal">
            <span class="close-btn" onclick="closeJobDetail()">&times;</span>
            <div class="job-detail-content">
                <h2 id="jobDetailTitle">职位详情</h2>
                <div class="job-detail-meta">
                    <div class="job-detail-item">
                        <span class="job-detail-label">&#128101; 人数:</span>
                        <span id="jobDetailCount">-</span>
                    </div>
                    <div class="job-detail-item">
                        <span class="job-detail-label">&#128188; 工作经验:</span>
                        <span id="jobDetailExperience">-</span>
                        <span class="job-detail-label"> 年</span>
                    </div>
                    <div class="job-detail-item">
                        <span class="job-detail-label">&#128197; 发布:</span>
                        <span id="jobDetailPublishDate">-</span>
                    </div>
                    <div class="job-detail-item">
                        <span class="job-detail-label">🏷️ 公司:</span>
                        <span id="jobDetailCompany">-</span>
                    </div>
                    <div class="job-detail-item" id="jobDetailDepartment" style="display: none;">
                        <span class="job-detail-label">🏢 部门:</span>
                        <span id="jobDetailDepartmentValue">-</span>
                    </div>
                    <div class="job-detail-item" id="jobDetailSalary" style="display: none;">
                        <span class="job-detail-label">💰 薪资:</span>
                        <span id="jobDetailSalaryValue">-</span>
                    </div>
                </div>
                <div class="job-detail-description">
                    <h3>职位详情：</h3>
                    <p id="jobDetailDescription">-</p>
                </div>
                <div class="job-detail-address">
                    <h3>工作地址：</h3>
                    <p id="jobDetailAddress">-</p>
                </div>
                <div class="apply-btn-container">
                    <button class="apply-btn" onclick="openFormFromDetail()">申请职位</button>
                </div>
            </div>
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
<script src="header.js"></script>
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
        const comphotoRing = document.getElementById('comphotoRing');
        const comphotoModal = document.getElementById('comphoto-modal');
        const comphotoModalImg = document.getElementById('comphoto-modal-img');
        const comphotoModalContent = document.querySelector('.comphoto-modal-content');
        const comphotoCloseBtn = document.querySelector('.comphoto-close');
        let currentClickedImg = null;

        // 在圆环上布置图片
        function buildComphotoRing() {
            comphotoRing.innerHTML = '';
            const count = Math.min(photos.length, 14); // 最多14张一圈
            const radius = Math.min(comphotoRing.clientWidth, comphotoRing.clientHeight) / 2 - 20;
            for (let i = 0; i < count; i++) {
                const angle = (i / count) * Math.PI * 2;
                const x = Math.cos(angle) * radius;
                const y = Math.sin(angle) * radius;

                const item = document.createElement('div');
                item.className = 'comphoto-item';
                item.style.transform = `translate(-50%, -50%) translate(${x}px, ${y}px) rotate(${angle}rad)`;

                const img = document.createElement('img');
                img.src = photos[i];
                img.alt = '公司照片';
                img.loading = 'lazy';
                img.addEventListener('click', function(){ openComphotoModal(this); });

                item.appendChild(img);
                comphotoRing.appendChild(item);
            }
        }

        // 暂停/恢复旋转
        function pauseRing() { comphotoRing.classList.add('paused'); }
        function resumeRing() { comphotoRing.classList.remove('paused'); }

        // 丝滑打开模态框
        function openComphotoModal(clickedImg) {
            currentClickedImg = clickedImg;
            pauseRing();

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
                
                resumeRing();
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

        window.addEventListener('resize', buildComphotoRing);

        // 初始化
        buildComphotoRing();
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

// 存储职位数据的全局变量
let jobsData = {};

// 从服务器获取职位数据
async function loadJobsData() {
    try {
        console.log('开始加载职位数据...'); // 调试信息
        const response = await fetch('get_jobs_api.php');
        const data = await response.json();
        console.log('服务器返回的数据:', data); // 调试信息
        
        if (data.success && data.companies) {
            // 将职位数据存储到全局变量中
            jobsData = {};
            
            Object.values(data.companies).forEach(company => {
                company.jobs.forEach(job => {
                    jobsData[job.id] = {
                        title: job.title,
                        count: job.count,
                        experience: job.experience,
                        publish_date: job.publish_date,
                        company: company.name,
                        description: job.description,
                        address: job.address || '待定',
                        department: job.department || '',
                        salary: job.salary || ''
                    };
                });
            });
            
            console.log('职位数据加载完成:', jobsData); // 调试信息
        } else {
            console.error('服务器返回失败:', data.error); // 调试信息
            // 显示错误信息给用户
            showJobLoadError();
        }
    } catch (error) {
        console.error('加载职位数据失败:', error);
        // 显示错误信息给用户
        showJobLoadError();
    }
}

// 显示职位加载错误信息
function showJobLoadError() {
    const jobsGrid = document.querySelector('.jobs-grid');
    if (jobsGrid) {
        jobsGrid.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <h3>职位数据加载失败</h3>
                <p>请稍后刷新页面重试，或联系管理员检查后台职位配置。</p>
                <button onclick="location.reload()" style="
                    background: linear-gradient(135deg, #FF5C00 0%, #ff7a33 100%);
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 25px;
                    cursor: pointer;
                    margin-top: 10px;
                ">刷新页面</button>
            </div>
        `;
    }
}

// 获取职位数据的函数
function getJobData(jobId) {
    return jobsData[jobId] || null;
}

// 打开职位详情弹窗
function openJobDetail(jobId) {
    console.log('尝试打开职位详情:', jobId); // 调试信息
    const jobData = getJobData(jobId);
    console.log('职位数据:', jobData); // 调试信息
    
    if (!jobData) {
        console.log('未找到职位数据，使用默认数据'); // 调试信息
        // 使用默认数据作为后备
        const defaultData = {
            title: '职位详情',
            count: '1',
            experience: '1',
            publish_date: '2025-01-01',
            company: 'KUNZZHOLDINGS',
            description: '这是一个示例职位描述。',
            address: '待定'
        };
        
        document.getElementById('jobDetailTitle').textContent = defaultData.title;
        document.getElementById('jobDetailCount').textContent = defaultData.count;
        document.getElementById('jobDetailExperience').textContent = defaultData.experience;
        document.getElementById('jobDetailPublishDate').textContent = defaultData.publish_date;
        document.getElementById('jobDetailCompany').textContent = defaultData.company;
        document.getElementById('jobDetailDescription').textContent = defaultData.description;
        document.getElementById('jobDetailAddress').textContent = defaultData.address;
        
        // 隐藏部门和薪资信息
        document.getElementById('jobDetailDepartment').style.display = 'none';
        document.getElementById('jobDetailSalary').style.display = 'none';
    } else {
        // 填充弹窗数据
        document.getElementById('jobDetailTitle').textContent = jobData.title;
        document.getElementById('jobDetailCount').textContent = jobData.count;
        document.getElementById('jobDetailExperience').textContent = jobData.experience;
        document.getElementById('jobDetailPublishDate').textContent = jobData.publish_date;
        document.getElementById('jobDetailCompany').textContent = jobData.company;
        document.getElementById('jobDetailDescription').textContent = jobData.description;
        document.getElementById('jobDetailAddress').textContent = jobData.address;
        
        // 显示部门和薪资信息（如果有的话）
        if (jobData.department) {
            document.getElementById('jobDetailDepartmentValue').textContent = jobData.department;
            document.getElementById('jobDetailDepartment').style.display = 'flex';
        } else {
            document.getElementById('jobDetailDepartment').style.display = 'none';
        }
        
        if (jobData.salary) {
            document.getElementById('jobDetailSalaryValue').textContent = jobData.salary;
            document.getElementById('jobDetailSalary').style.display = 'flex';
        } else {
            document.getElementById('jobDetailSalary').style.display = 'none';
        }
    }
    
    // 显示弹窗
    document.getElementById('jobDetailModal').style.display = 'flex';
}

// 关闭职位详情弹窗
function closeJobDetail() {
    document.getElementById('jobDetailModal').style.display = 'none';
}

// 从详情弹窗打开申请表单
function openFormFromDetail() {
    const jobTitle = document.getElementById('jobDetailTitle').textContent;
    closeJobDetail();
    openForm(jobTitle);
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
    const formModal = document.getElementById('formModal');
    const jobDetailModal = document.getElementById('jobDetailModal');
    
    if (event.target == formModal) {
        formModal.style.display = 'none';
    }
    
    if (event.target == jobDetailModal) {
        jobDetailModal.style.display = 'none';
    }
}

// 初始化
document.addEventListener('DOMContentLoaded', function() {
    initParticles();
    
    // 加载职位数据
    loadJobsData();
    
    // 初始化职位点击功能
    initJobClickHandlers();
});

// 职位点击功能
function initJobClickHandlers() {
    // 使用事件委托来处理动态添加的职位卡片点击事件
    document.addEventListener('click', function(event) {
        const jobItem = event.target.closest('.job-item');
        if (jobItem) {
            const jobId = jobItem.getAttribute('data-job-id');
            if (jobId) {
                console.log('点击了职位:', jobId);
                openJobDetail(jobId);
            }
        }
    });
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

function resizeJobs() {
  const baseWidth = 1440;  // 设计稿宽度
  const baseHeight = 900;  // 设计稿高度
  const scaleX = window.innerWidth / baseWidth;
  const scaleY = window.innerHeight / baseHeight;
  const scale = Math.min(scaleX, scaleY);
  document.documentElement.style.setProperty("--scale", scale);
}
window.addEventListener("resize", resizeJobs);
resizeJobs();

</script>
</body>
</html>