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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="navbar">
    <div class="logo-section">
        <img src="images/images/logo.png" alt="Logo" class="logo">
      <div class="company-name">
        <div>KUNZZ HOLDINGS</div>
        <div>SDN BHD</div>
      </div>
    </div>

    <nav class="nav-links">
      <div class="nav-item">
        <a href="index.php">首页</a>
      </div>
      <div class="nav-item">
        <a href="about.html">关于我们</a>
      </div>
      <div class="nav-item">
        <a href="tokyo-japanese-cuisine.html">旗下品牌</a>
      </div>
      <div class="nav-item">
        <a href="joinus.html">加入我们</a>
      </div>
    </nav>    

    <div class="right-section">
      <a href="login.html" class="login-btn">LOGIN</a>
      <div class="language-switch">
        <img src="images/images/翻译.png" alt="Icon" class="icon" />
        <a href="#" class="lang">EN | CN</a> 
      </div>
    </div>
  </header>
  
  <section class="home">
    <div class="home-content">
      <h1>让空间温暖，让团队闪光</h1>
      <p>
        我们用细节构建舒适的氛围，在积极的文化中滋养每一份热情与专注。<br />
        我们相信，高效源于信任，创新源于自由。<br />
        一支有温度的团队，才能创造持续的价值，向着行业标杆的方向，稳步前行。
      </p>
      <a href="#" class="home-button">了解我们</a>
    </div>
  </section>
  
  <section class="stats-section">
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
      <div class="stat-number">50+</div>
      <div class="stat-label">员工数量</div>
    </div>
  </section> 

  <section id="comprofile" class="comprofile-section">
    <div class="comprofile-text">
        <p class="comprofile-subtitle">
            <span class="circle"></span>公司简介
        </p>
      <h2 class="comprofile-title">KUNZZ HOLDINGS</h2>
      <p class="comprofile-description">
        Kunzz Holdings 成立于2024年，初衷是为旗下业务建立统一的管理平台，提升资源整合效率。我们坚守“塑造积极向上和舒适的工作环境”为使命，持续推动组织氛围建设，成就更有温度的企业文化。我们信奉积极、高效、灵活、诚信的核心精神，始终以目标导向、理念一致为准则，追求卓越，勇于创新。
      </p>
    </div>
    <div class="comprofile-image">
      <!-- 你可以换成自己的图片 -->
      <img src="images/images/大logo.png" alt="公司介绍图" />
    </div>
  </section>

  <section id="culture" class="culture-section">
    <div class="culture-left">
      <div class="culture-card">
        <img src="images/images/积极向上 (1).png" alt="icon" class="culture-icon">
        <h3>积极向上</h3>
        <p>始终以正面心态面对挑战，在变化中寻找成长机会</p>
      </div>
      <div class="culture-card">
        <img src="images/images/高效执行 (1).png" alt="icon" class="culture-icon">
        <h3>高效执行</h3>
        <p>说到做到，快速响应，追求结果导向与行动力</p>
      </div>
      <div class="culture-card">
        <img src="images/images/灵活应变 (1).png" alt="icon" class="culture-icon">
        <h3>灵活应变</h3>
        <p>面对市场变化和问题，保持开放思维，快速调整策略</p>
      </div>
      <div class="culture-card">
        <img src="images/images/诚信待人 (1).png" alt="icon" class="culture-icon">
        <h3>诚信待人</h3>
        <p>以真诚与责任建立合作与信任，是我们最基本的做人原则</p>
      </div>
    </div>
  
    <div class="culture-right">
      <h2 class="culture-title">我们的核心价值<br>公司文化</span></h2>
      <p class="culture-description">
        在 Kunzz Holdings，我们相信文化决定高度。我们以目标为导向，理念为基石，打造一支具备高效执行力与高度协同精神的团队。我们提倡扁平沟通，尊重每一位成员的成长节奏，鼓励分享、学习与共创。在这里，每一份努力都能被看见，每一次突破都值得被鼓励。
      </p>
      <a href="#" class="culture-button">了解更多 &gt;&gt;</a>
    </div>
  </section>
  
  <footer class="footer">
    <div class="footer-logo">
      <h1><img src="images/images/logo.png" alt="Logo" class="logo" />Kunzz Holdings <br />Sdn. Bhd.</h1>
      <p>25, Jln Tanjong 3, Taman Desa Cemerlang, <br />
        81800 Ulu Tiram, Johor Darul Ta'zim.</p>
      <p>&#128382;&nbsp; +60 123-456 789<br />
        &#128386;&nbsp; hello@kunzz.com</p>
    </div>

    <div class="footer-section">
      <h4><a href="index.php">首页</a></h4>
      <ul>
        <li><a href="#comprofile">公司简介</a></li>
        <li><a href="#culture">核心价值公司文化</a></li>
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
        <li>TOKYO JAPANESE CUISINE</li>
      </ul>
    </div>

    <div class="footer-section">
      <h4><a href="joinus.html">加入我们</a></h4>
      <ul>
        <li>招聘</li>
        <li><a href="joinus.html#contact">联系我们</a></li>
        <li>
          <span style="font-size: 16px; font-weight: bold; color: white;">关注我们</span>
          <div class="social-icons">
            <a href="#" target="_blank">
              <img src="images/images/fbicon.png" alt="Facebook" />
            </a>
            <a href="#" target="_blank">
              <img src="images/images/igicon.png" alt="Instagram" />
            </a>
            <a href="#" target="_blank">
              <img src="images/images/wsicon.png" alt="WhatsApp" />
            </a>
          </div>
        </li>
      </ul>
    </div>
  </footer>

  <button id="backToTop" onclick="scrollToTop()">&#8673;</button>
  
  <div class="footer-bottom">
    © 2025 Kunzz Holdings Sdn. Bhd. All rights reserved.
  </div>

<script src="app.js"></script>
</body>
</html>
