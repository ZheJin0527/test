<?php
session_start();

// 如果已登录或记住我，跳转到 dashboard
if (isset($_SESSION['user_id']) || (isset($_COOKIE['user_id']) && isset($_COOKIE['username']))) {
    header("Location: dashboard.php");
    exit();
}
?>

<?php
$pageTitle = 'KUNZZ HOLDINGS';
$additionalCSS = ['animation.css'];
$showPageIndicator = true;
$totalSlides = 4;
include 'header.php';
?>

  
  <div class="swiper">
  <div class="swiper-wrapper">

  <div class="swiper-slide">
  <section class="home">
    <div class="home-content hidden animate-on-scroll">
      <h1 class="scale-fade-in">Make The Space Warm<br>Let The Team Shine</h1>
      <div class="decor-line scale-fade-in"></div>
      <p class="scale-fade-in">
        We build a comfortable atmosphere with details and nourish every passion and dedication in a positive culture.<br />
        We believe that efficiency comes from trust and innovation comes from freedom. A team with warmth, <br />
        can create sustained value and move steadily forward in the direction of the industry benchmark.
      </p>
    </div>
  </section>
  </div>

  <div class="swiper-slide">
  <section class="about-section" id="comprofile">
  <div class="comprofile-section">
    <div class="comprofile-text">
        <p class="comprofile-subtitle animate-on-scroll slide-in-left delay-1">
            <span class="circle"></span>Company Profile
        </p>
      <h2 class="comprofile-title animate-on-scroll slide-in-left delay-2">KUNZZ HOLDINGS</h2>
      <p class="comprofile-description animate-on-scroll slide-in-left delay-3">
        Kunzz Holdings was established in 2024 with the original intention of establishing a unified management platform for its businesses and improving the efficiency of resource integration. We adhere to the mission of "creating a positive and comfortable working environment", continue to promote the construction of organizational atmosphere, and achieve a warmer corporate culture. We believe in the core spirit of positivity, efficiency, flexibility, and integrity, always take goal orientation and consistent concepts as the criteria, pursue excellence, and be innovative.
      </p>
    </div>
    <div class="comprofile-image animate-on-scroll rotate-3d-full">
      <!-- 你可以换成自己的图片 -->
      <img src="https://kunzzgroup.com/images/images/logo.png" alt="公司介绍图" />
    </div>
  </div>

  <div class="stats-section">
    <div class="stat-box">
      <div class="stat-number">2023</div>
      <div class="stat-label">Year of Establishment</div>
    </div>
    <div class="divider"></div>
    <div class="stat-box">
      <div class="stat-number">3</div>
      <div class="stat-label">Number of Subsidiaries</div>
    </div>
    <div class="divider"></div>
    <div class="stat-box">
      <div class="stat-number">60+</div>
      <div class="stat-label">Number of Employees</div>
    </div>
  </div> 
  </section>
  </div>

  <div class="swiper-slide">
  <section id="culture" class="culture-section">
    <div class="culture-left animate-on-scroll card-tilt-in-left">
      <div class="culture-card">
        <img src="https://kunzzgroup.com/images/images/积极向上 (1).png" alt="icon" class="culture-icon">
        <h3>Positive</h3>
        <p>Stay Positive in Challenges<br>Embrace Change to Grow</p>
      </div>
      <div class="culture-card">
        <img src="https://kunzzgroup.com/images/images/高效执行 (1).png" alt="icon" class="culture-icon">
        <h3>Efficient</h3>
        <p>Say it, do it. Respond fast.<br>Result-Driven & Action-Oriented</p>
      </div>
      <div class="culture-card">
        <img src="https://kunzzgroup.com/images/images/灵活应变 (1).png" alt="icon" class="culture-icon">
        <h3>Flexible</h3>
        <p>Face Change and Challenges<br>Stay Open and Adjust Fast</p>
      </div>
      <div class="culture-card">
        <img src="https://kunzzgroup.com/images/images/诚信待人 (1).png" alt="icon" class="culture-icon">
        <h3>Honesty</h3>
        <p>Build Trust with Sincerity<br>is Our Core Principle</p>
      </div>
    </div>

    <div class="culture-right animate-on-scroll">
      <h2 class="culture-title animate-on-scroll culture-scale-fade delay-6">Our Core Values<br>Company Culture</h2>
      <p class="culture-description animate-on-scroll culture-scale-fade delay-7">
        At Kunzz Holdings, we believe that culture determines height. We are goal-oriented and based on ideas to build a team with efficient execution and high collaborative spirit.
        We advocate flat communication, respect the growth rhythm of each member, and encourage sharing, learning and co-creation. Here, every effort can be seen and every breakthrough is worth encouraging.
      </p>
      <a href="about.html" class="culture-button animate-on-scroll culture-scale-fade delay-8">Learn More &gt;&gt;</a>
    </div>
  </section>
  </div>
  
  <div class="swiper-slide footer-slide">
    <section class="scroll-buffer">
    <footer class="footer">
    <div class="footer-section">
      <h4><a href="index.php">Home</a></h4>
      <ul>
        <li><a href="#" onclick="goToSlide(1); return false;">Company Profile</a></li>
        <li><a href="#" onclick="goToSlide(2); return false;">Company Culture</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="about.html">About Us</a></h4>
      <ul>
        <li><a href="about.html#intro">Group Profile</a></li>
        <li><a href="about.html#vision">Beliefs & Direction</a></li>
        <li><a href="about.html#values">Our Core Values</a></li>
        <li><a href="about.html#timeline-1">Milestones</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4>Brands</h4>
      <ul>
        <li><a href="tokyo-japanese-cuisine.html">Tokyo Japanese </br>Cuisine</li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="joinus.html">Join Us</a></h4>
      <ul>
        <li><a href="joinus.html">Benefits</li>
        <li><a href="joinus.html#comphoto-container">Our Journey</li>
        <li><a href="joinus.html#particles">Open Positions</li>
        <li><a href="joinus.html#map">Contact Us</a></li>        
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
        <img src="https://kunzzgroup.com/images/images/fbicon.png" alt="Facebook">
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com" target="_blank" class="social-icon instagram" title="探索 Instagram 精彩">
        <img src="https://kunzzgroup.com/images/images/igicon.png" alt="Instagram">
    </a>

    <!-- WhatsApp -->
    <a href="https://www.whatsapp.com" target="_blank" class="social-icon whatsapp" title="连接 WhatsApp">
        <img src="https://kunzzgroup.com/images/images/wsicon.png" alt="WhatsApp">
    </a>
</div>
  
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
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const container = entry.target;

      if (entry.isIntersecting) {
        container.classList.add('visible');

        container.querySelectorAll('.scale-fade-in').forEach(el => {
          el.style.animation = 'none'; // 重置动画
          el.offsetHeight; // 触发重绘
          el.style.animation = ''; // 重新应用 CSS 动画
          el.style.animationPlayState = 'running';
        });

      } else {
        container.classList.remove('visible');

        container.querySelectorAll('.scale-fade-in').forEach(el => {
          el.style.animation = 'none'; // 停止当前动画
          el.style.opacity = '0'; // 恢复初始状态
          el.style.transform = 'translateY(20px)';
          el.offsetHeight; // 强制回流
          el.style.animation = '';
          el.style.animationPlayState = 'paused';
        });
      }
    });
  }, {
    threshold: 0.2
  });

  // 初始化：暂停动画并设置初始状态
  document.querySelectorAll('.animate-on-scroll').forEach(container => {
    container.querySelectorAll('.scale-fade-in').forEach(el => {
      el.style.animationPlayState = 'paused';
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
    });
    observer.observe(container);
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
                    updatePageIndicator(3); // 滑到最后一页
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
  window.addEventListener('load', () => {
    // 创建一个虚拟图片对象检测背景图是否加载完成
    const bgImg = new Image();
    bgImg.src = "https://kunzzgroup.com/images/images/封面7.png";

    bgImg.onload = function () {

      document.querySelector('.home').classList.add('gradient-loaded');
      
      document.querySelector('.home-content').classList.remove('hidden');

      // 强制触发重绘，重新开始动画（可选，增强兼容性）
      void document.querySelector('.home-content').offsetWidth;

      // 添加动画类（如果你的 fade-in-up 是靠 JavaScript 加载）
      document.querySelector('.home-content h1').classList.add('scale-fade-in');
      document.querySelector('.home-content p').classList.add('scale-fade-in');

      // 启动navbar动画 - 添加一个CSS类来触发动画
      document.querySelector('.navbar').classList.add('navbar-loaded');
      
      // 显示社交侧边栏
      document.querySelector('.social-sidebar').classList.add('social-loaded');
      
      // 显示页面指示器
      document.querySelector('.page-indicator').classList.add('indicator-loaded');
    };
  });
</script>
<script>
  function goToLocation() {
    const map = document.getElementById('custom-map');

    // ⚠️ 这里请替换成你 My Maps 中标记具体地点的链接（可以在地图中点击目标点 → 分享 → 嵌入地图 获取新的 URL）
    map.src = "https://www.google.com/maps/d/embed?mid=11C1m9L_Gcj_n8ynGotoCNc4rzq0FX54&ehbc=2E312F#target-location";
  }
</script>
<script>
  const bgMusic = document.getElementById('bgMusic');

  // 设置固定音量（例如 0.3 表示 30%）
  bgMusic.volume = 0.3;

  // 从 localStorage 恢复播放进度和状态
  const savedTime = localStorage.getItem('musicCurrentTime');
  const savedPlaying = localStorage.getItem('musicPlaying');

  if (savedTime) {
    bgMusic.currentTime = parseFloat(savedTime);
  }

  function tryPlay() {
    bgMusic.play().catch(() => {});
    localStorage.setItem('musicPlaying', 'true');
  }

  // 如果之前在播放，立即继续播放
  if (savedPlaying === 'true') {
    // 稍微延迟以确保音频加载完成
    setTimeout(tryPlay, 50);
  }

  // 用户交互时开始播放
  document.addEventListener('click', tryPlay, { once: true });
  document.addEventListener('keydown', tryPlay, { once: true });
  document.addEventListener('touchstart', tryPlay, { once: true });

  // 定期保存播放进度
  setInterval(() => {
    if (!bgMusic.paused) {
      localStorage.setItem('musicCurrentTime', bgMusic.currentTime);
      localStorage.setItem('musicPlaying', 'true');
    }
  }, 500);

  // 页面卸载前保存状态
  window.addEventListener('beforeunload', () => {
    localStorage.setItem('musicCurrentTime', bgMusic.currentTime);
    localStorage.setItem('musicPlaying', bgMusic.paused ? 'false' : 'true');
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
function goToCompanyProfile() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(1); // 跳转到第2个slide（公司简介）
  }
}

function goToCulture() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(2); // 跳转到第3个slide（公司文化）
  }
}
</script>
</body>
</html>
