<?php
// 启用错误显示
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting debug...<br>";

try {
    session_start();
    echo "Session started<br>";
    
    if (file_exists('../media_config.php')) {
        include_once '../media_config.php';
        echo "Media config included<br>";
    } else {
        echo "Media config NOT found<br>";
    }
    
    // 设置页面特定的变量
    $pageTitle = 'KUNZZ HOLDINGS';
    $additionalCSS = ['css/frontend-main.css', 'css/animation.css'];
    $showPageIndicator = true;
    $totalSlides = 4;
    
    echo "Variables set<br>";
    
    if (file_exists('../public/header.php')) {
        include '../public/header.php';
        echo "Header included<br>";
    } else {
        echo "Header NOT found<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} catch (Error $e) {
    echo "Fatal Error: " . $e->getMessage();
}
?>

<div class="swiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <section class="home">
        <div class="home-content">
          <h1>测试页面</h1>
          <p>如果你看到这个，说明PHP正在工作！</p>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
console.log("JavaScript is working!");
</script>
