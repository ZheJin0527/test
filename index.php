<?php
session_start();

// 如果已登录或记住我，跳转到 dashboard
if (isset($_SESSION['user_id']) || (isset($_COOKIE['user_id']) && isset($_COOKIE['username']))) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNZZ HOLDINGS</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="animation.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
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
    <div class="nav-item"><a href="about.html">关于我们</a></div>
    <div class="nav-item"><a href="tokyo-japanese-cuisine.html">旗下品牌</a></div>
    <div class="nav-item"><a href="joinus.html">加入我们</a></div>
  </nav>

  <!-- 右侧区域 -->
  <div class="right-section">
    <!-- 移动端隐藏 login，仅大屏显示 -->
    <a href="login.html" class="login-btn">LOGIN</a>

    <!-- 翻译按钮始终显示 -->
    <div class="language-switch">
      <a href="#" class="lang">EN | CN</a>
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
    </div>
  
  <div class="swiper">
  <div class="swiper-wrapper">

  <div class="swiper-slide">
  <section class="home">
    <div class="home-content hidden animate-on-scroll">
      <h1 class="scale-fade-in light-sweep-text">
  <span class="light-sweep">让空间温暖 <span style="font-size: 1.5em;">.</span> 让团队闪光</span>
</h1>
      <div class="decor-line scale-fade-in"></div>
      <p class="scale-fade-in">
        我们用细节构建舒适的氛围，在积极的文化中滋养每一份热情与专注。<br />
        我们相信，高效源于信任，创新源于自由。一支有温度的团队，<br />
        才能创造持续的价值，向着行业标杆的方向，稳步前行。
      </p>
    </div>
  </section>
  </div>

  <div class="swiper-slide">
  <section class="about-section">
  <div class="comprofile-section">
    <div class="comprofile-text">
        <p class="comprofile-subtitle animate-on-scroll slide-in-left delay-1">
            <span class="circle"></span>公司简介
        </p>
      <h2 class="comprofile-title animate-on-scroll slide-in-left delay-2">KUNZZ HOLDINGS</h2>
      <p class="comprofile-description animate-on-scroll slide-in-left delay-3">
        Kunzz Holdings 成立于2024年，初衷是为旗下业务建立统一的管理平台，提升资源整合效率。我们坚守“塑造积极向上和舒适的工作环境”为使命，持续推动组织氛围建设，成就更有温度的企业文化。我们信奉积极、高效、灵活、诚信的核心精神，始终以目标导向、理念一致为准则，追求卓越，勇于创新。
      </p>
    </div>
    <div class="comprofile-image animate-on-scroll rotate-3d-full">
      <!-- 你可以换成自己的图片 -->
      <img src="images/images/logo.png" alt="公司介绍图" />
    </div>
  </div>

  <div class="stats-section">
    <div class="stat-box">
      <div class="stat-number">2024</div>
      <div class="stat-label">成立年份</div>
    </div>
    <div class="divider"></div>
    <div class="stat-box">
      <div class="stat-number">3</div>
      <div class="stat-label">子公司数量</div>
    </div>
    <div class="divider"></div>
    <div class="stat-box">
      <div class="stat-number">60+</div>
      <div class="stat-label">员工数量</div>
    </div>
  </div> 
  </section>
  </div>

  <div class="swiper-slide">
  <section id="culture" class="culture-section">
    <div class="culture-left animate-on-scroll card-tilt-in-left">
      <div class="culture-card">
        <img src="images/images/积极向上 (1).png" alt="icon" class="culture-icon">
        <h3>积极向上</h3>
        <p>始终以正面心态面对挑战<br>在变化中寻找成长机会</p>
      </div>
      <div class="culture-card">
        <img src="images/images/高效执行 (1).png" alt="icon" class="culture-icon">
        <h3>高效执行</h3>
        <p>说到做到，快速响应<br>追求结果导向与行动力</p>
      </div>
      <div class="culture-card">
        <img src="images/images/灵活应变 (1).png" alt="icon" class="culture-icon">
        <h3>灵活应变</h3>
        <p>面对市场变化和问题<br>保持开放思维，快速调整策略</p>
      </div>
      <div class="culture-card">
        <img src="images/images/诚信待人 (1).png" alt="icon" class="culture-icon">
        <h3>诚信待人</h3>
        <p>以真诚与责任建立合作与信任<br>是我们最基本的做人原则</p>
      </div>
    </div>

    <div class="culture-right animate-on-scroll">
      <h2 class="culture-title animate-on-scroll culture-scale-fade delay-6">我们的核心价值<br>公司文化</h2>
      <p class="culture-description animate-on-scroll culture-scale-fade delay-7">
        在 Kunzz Holdings，我们相信文化决定高度。我们以目标为导向，理念为基石，打造一支具备高效执行力与高度协同精神的团队。
        我们提倡扁平沟通，尊重每一位成员的成长节奏，鼓励分享、学习与共创。在这里，每一份努力都能被看见，每一次突破都值得被鼓励。
      </p>
      <a href="about.html" class="culture-button animate-on-scroll culture-scale-fade delay-8">了解更多 &gt;&gt;</a>
    </div>
  </section>
  </div>
  
  <div class="swiper-slide footer-slide">
    <section class="scroll-buffer">
    <footer class="footer">
    <div class="footer-section">
      <h4><a href="index.php">首页</a></h4>
      <ul>
        <li><a href="#comprofile">公司简介</a></li>
        <li><a href="#culture">公司文化</a></li>
        <li><a href="#brands">旗下品牌</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="about.html">关于我们</a></h4>
      <ul>
        <li><a href="about.html#intro">集团简介</a></li>
        <li><a href="about.html#vision">信念与方向</a></li>
        <li><a href="about.html#values">核心价值观</a></li>
        <li><a href="about.html#timeline-1">发展历史</a></li>
      </ul>
    </div>

    <div class="footer-section">
      <h4>旗下品牌</h4>
      <ul>
        <li>TOKYO JAPANESE </br>CUISINE</li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="joinus.html">加入我们</a></h4>
      <ul>
        <li>招聘</li>
        <li><a href="joinus.html#contact">联系我们</a></li>
        
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
            <svg viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com" target="_blank" class="social-icon instagram" title="探索 Instagram 精彩">
            <svg viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
        </a>

        <!-- WhatsApp -->
        <a href="https://www.whatsapp.com" target="_blank" class="social-icon whatsapp" title="连接 WhatsApp">
            <svg viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
        </a>
    </div>
  
<script src="app.js"></script>
<script>
  const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');
const loginBtn = document.querySelector('.login-btn');

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
    bgImg.src = "images/images/封面7.png";

    bgImg.onload = function () {
      document.querySelector('.home-content').classList.remove('hidden');

      // 强制触发重绘，重新开始动画（可选，增强兼容性）
      void document.querySelector('.home-content').offsetWidth;

      // 添加动画类（如果你的 fade-in-up 是靠 JavaScript 加载）
      document.querySelector('.home-content h1').classList.add('scale-fade-in');
      document.querySelector('.home-content p').classList.add('scale-fade-in');
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
</body>
</html>
