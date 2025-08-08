<?php
session_start();

// 超时时间（秒）
define('SESSION_TIMEOUT', 60);

// 如果 session 存在，检查是否过期
if (isset($_SESSION['user_id'])) {

    // 如果超过 1 分钟没活动，并且没有记住我
    if (
        isset($_SESSION['last_activity']) &&
        (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) &&
        (!isset($_COOKIE['remember_token']) || $_COOKIE['remember_token'] !== '1')
    ) {
        // 清除 session
        session_unset();
        session_destroy();

        // 清除 cookie（可选）
        setcookie('user_id', '', time() - 60, "/");
        setcookie('username', '', time() - 60, "/");
        setcookie('remember_token', '', time() - 60, "/");

        // 跳转登录页
        header("Location: index.php");
        exit();
    }

    // 更新活动时间戳
    $_SESSION['last_activity'] = time();

} elseif (
    isset($_COOKIE['user_id']) &&
    isset($_COOKIE['username']) &&
    isset($_COOKIE['remember_token']) &&
    $_COOKIE['remember_token'] === '1'
) {
    // 记住我逻辑（恢复 session）
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['last_activity'] = time();
} else {
    // 没有 session，也没有有效 cookie
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$avatarLetter = strtoupper($username[0]);
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
    <div class="informationmenu-overlay"></div>

    <!-- 侧边菜单 -->
    <div class="informationmenu">
        <div class="informationmenu-header">
            <div class="user-avatar-dropdown">
            <div id="user-avatar" class="user-avatar"><?php echo $avatarLetter; ?></div>
        </div>
        </div>

        <div class="informationmenu-content">
            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="analytics-items">
                    仪表盘
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="analytics-items">
                    <div class="menu-item-wrapper">
                        <a href="kpi.html" class="informationmenu-item">
                            集团概览
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            工作表
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="kpiedit.html" class="informationmenu-item">
                            KPI数据上传
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="company-items">
                    Kunzz Holdings
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="company-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            企业蓝图
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            组织结构图
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            公司规划
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            公司福利
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            绩效考核
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="subcompany-items">
                    子公司
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="subcompany-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            J1
                            <span class="informationmenu-arrow">›</span>
                        </a>
                        <div class="submenu">
                            <div class="submenu-header">
                                <div class="submenu-title">J1</div>
                            </div>
                            <div class="submenu-content">
                                <a href="#" class="submenu-item">蓝图</a>
                                <a href="#" class="submenu-item">组织结构</a>
                                <a href="#" class="submenu-item">公司规则</a>
                                <a href="#" class="submenu-item">公司福利</a>
                                <a href="#" class="submenu-item">绩效考核</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            J2
                            <span class="informationmenu-arrow">›</span>
                        </a>
                        <div class="submenu">
                            <div class="submenu-header">
                                <div class="submenu-title">J2</div>
                            </div>
                            <div class="submenu-content">
                                <a href="#" class="submenu-item">蓝图</a>
                                <a href="#" class="submenu-item">组织结构</a>
                                <a href="#" class="submenu-item">公司规则</a>
                                <a href="#" class="submenu-item">公司福利</a>
                                <a href="#" class="submenu-item">绩效考核</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            J3
                            <span class="informationmenu-arrow">›</span>
                        </a>
                        <div class="submenu">
                            <div class="submenu-header">
                                <div class="submenu-title">J3</div>
                            </div>
                            <div class="submenu-content">
                                <a href="#" class="submenu-item">蓝图</a>
                                <a href="#" class="submenu-item">组织结构</a>
                                <a href="#" class="submenu-item">公司规则</a>
                                <a href="#" class="submenu-item">公司福利</a>
                                <a href="#" class="submenu-item">绩效考核</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="report-items">
                    报表
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="report-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            财务
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            业绩
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            桌子
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            工资
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="stock-items">
                    资源库
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="stock-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            碗碟
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            食品
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="resource-request-items">
                    资源申请
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="resource-request-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            资源请求
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            分配状态
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="vacation-items">
                    假期申请
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="vacation-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            申请请求
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            假期报表
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="account-items">
                    我的账号
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="account-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            个人资料
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            消息
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>

                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            资料修改
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="system-items">
                    系统设置
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="system-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            语言
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            权限
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-section">
                <div class="informationmenu-section-title" data-target="support-items">
                    帮助与支持
                    <span class="section-arrow">⮞</span>
                </div>
                <div class="dropdown-menu-items" id="support-items">
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            使用教学
                            <span class="informationmenu-arrow">›</span>
                        </a>
                    </div>
                    
                    <div class="menu-item-wrapper">
                        <a href="#" class="informationmenu-item">
                            问题库
                            <span class="informationmenu-arrow">›</span>
                        </a>                    
                    </div>
                </div>
            </div>

            <div class="informationmenu-footer">
                <button class="logout-btn" onclick="location.href='logout.php'">
                    登出
                </button>
            </div>
        </div>
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
    bgImg.src = "images/images/封面7.png";

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
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const avatar = document.getElementById("user-avatar");
    const dropdown = document.getElementById("dropdown-menu");

    avatar.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdown.classList.toggle("show");
    });

    document.addEventListener("click", () => {
      dropdown.classList.remove("show");
    });
  });
</script>
<script>
        const sidebar = document.querySelector('.informationmenu');
        const overlay = document.querySelector('.informationmenu-overlay');
        const userAvatar = document.getElementById('user-avatar');
        const closeBtn = document.querySelector('.informationmenu-close-btn');

        // 点击用户头像显示菜单
        userAvatar?.addEventListener('click', function() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
        });

        // 关闭菜单
        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            // 关闭所有下拉菜单
            document.querySelectorAll('.dropdown-menu-items').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.informationmenu-section-title').forEach(title => {
                title.classList.remove('active');
            });
        }

        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);

        // ESC键关闭菜单
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });

        // Section标题点击事件
        document.querySelectorAll('.informationmenu-section-title').forEach(title => {
            title.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetDropdown = document.getElementById(targetId);
                
                // 关闭其他section的下拉菜单
                document.querySelectorAll('.dropdown-menu-items').forEach(dropdown => {
                    if (dropdown.id !== targetId) {
                        dropdown.classList.remove('show');
                    }
                });
                
                // 移除其他section title的active状态
                document.querySelectorAll('.informationmenu-section-title').forEach(t => {
                    if (t !== this) {
                        t.classList.remove('active');
                    }
                });
                
                // 切换当前section
                this.classList.toggle('active');
                targetDropdown?.classList.toggle('show');
            });
        });

        // 菜单项点击效果
        document.querySelectorAll('.informationmenu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
        
                // 检查是否有真实的链接
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    // 有真实链接，允许正常跳转
                    window.location.href = href;
                    return;
                }
        
                // 没有真实链接的项目，阻止默认行为
                e.preventDefault();
        
                // 移除其他active状态
                document.querySelectorAll('.informationmenu-item').forEach(i => i.classList.remove('active'));
        
                // 添加active状态到当前项
                this.classList.add('active');
            });
        });

        // 修复后的子菜单项点击效果
        document.querySelectorAll('.submenu-item:not(.expandable)').forEach(item => {
            item.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
        
                // 检查是否有真实的链接
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    // 有真实链接，允许正常跳转
                    console.log('跳转到: ' + href);
                    // 移除 e.preventDefault()，让链接正常工作
                    window.location.href = href; // 手动跳转
                    return;
                }
        
                // 没有真实链接的项目，阻止默认行为并显示提示
                e.preventDefault();
                const itemText = this.textContent.replace('→', '').trim();
                alert('点击了子菜单项: ' + itemText);
            });
        });

        // 多级展开功能
        document.querySelectorAll('.submenu-item.expandable').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-target');
                const targetOptions = document.getElementById(targetId);
                
                // 收起所有其他的子选项
                document.querySelectorAll('.sub-options').forEach(options => {
                    if (options.id !== targetId) {
                        options.classList.remove('expanded');
                    }
                });
                
                // 移除所有其他expandable项的expanded类
                document.querySelectorAll('.submenu-item.expandable').forEach(expandableItem => {
                    if (expandableItem !== this) {
                        expandableItem.classList.remove('expanded');
                    }
                });
                
                // 切换当前项的展开状态
                this.classList.toggle('expanded');
                targetOptions?.classList.toggle('expanded');
            });
        });

        // 子选项点击效果
        document.querySelectorAll('.sub-option').forEach(option => {
            option.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // 检查是否有真实的链接
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    // 有真实链接，允许正常跳转
                    console.log('跳转到: ' + href);
                    return; // 不阻止默认行为
                }
                
                // 没有真实链接的项目
                e.preventDefault();
                const optionText = this.textContent.replace('·', '').trim();
                alert('点击了子选项: ' + optionText);
            });
        });

        // 增强子菜单hover效果
        document.querySelectorAll('.menu-item-wrapper').forEach(wrapper => {
            const submenu = wrapper.querySelector('.submenu');
            if (submenu) {
                // 鼠标进入菜单项区域
                wrapper.addEventListener('mouseenter', function() {
                    submenu.style.opacity = '1';
                    submenu.style.visibility = 'visible';
                    submenu.style.transform = 'translateX(0)';
                    submenu.style.pointerEvents = 'auto';
                });

                // 鼠标离开整个区域时隐藏
                wrapper.addEventListener('mouseleave', function(e) {
                    // 检查鼠标是否移向子菜单
                    setTimeout(() => {
                        if (!submenu.matches(':hover') && !wrapper.matches(':hover')) {
                            submenu.style.opacity = '0';
                            submenu.style.visibility = 'hidden';
                            submenu.style.transform = 'translateX(-50px)';
                            submenu.style.pointerEvents = 'none';
                        }
                    }, 100);
                });

                // 鼠标在子菜单上时保持显示
                submenu.addEventListener('mouseenter', function() {
                    this.style.opacity = '1';
                    this.style.visibility = 'visible';
                    this.style.transform = 'translateX(0)';
                    this.style.pointerEvents = 'auto';
                });

                submenu.addEventListener('mouseleave', function() {
                    this.style.opacity = '0';
                    this.style.visibility = 'hidden';
                    this.style.transform = 'translateX(-50px)';
                    this.style.pointerEvents = 'none';
                });
            }
        });

        console.log('点击Section + 悬停Submenu系统已加载完成');
    </script>
</body>
</html>
