<?php
// 启用错误显示
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once '../media_config.php';

// 设置页面特定的变量
$pageTitle = 'KUNZZ HOLDINGS';
$additionalCSS = ['css/frontend-main.css', 'css/animation.css'];
$showPageIndicator = true;
$totalSlides = 4;

// 包含header
include '../public/header.php';
?>

<div class="swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <section class="home">
        <div class="home-content">
          <h1>简单测试页面</h1>
          <p>如果你看到这个，说明基本结构正常！</p>
        </div>
      </section>
    </div>
  </div>
</div>

<script src="js/app.js"></script>
<script src="js/header.js"></script>
<script>
console.log("页面加载完成");
</script>
