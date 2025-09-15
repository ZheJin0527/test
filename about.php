<?php
// 禁用页面缓存
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include_once 'media_config.php';
// 获取时间线数据
$timelineData = getTimelineConfig();

// 设置页面特定的变量
$pageTitle = 'KUNZZ HOLDINGS';
$additionalCSS = ['aboutanimation.css'];
$showPageIndicator = true;
$totalSlides = 5;

// 包含header
include 'header.php';
?>
    
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
                    <div class="timeline-content">
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
        
        // 缓存DOM元素，避免重复查询
        let navItems, container, cards;
        let containerWidth, itemWidth;
        
        // 拖拽相关变量 - 优化后的设置
        let isDragging = false;
        let startX = 0;
        let currentX = 0;
        let dragThreshold = 15;
        let hasTriggered = false;
        let dragStartTime = 0;
        let isAnimating = false;
        
        // 防抖函数
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        // 节流函数
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }
        
        // 初始化DOM元素缓存
        function initDOMCache() {
            navItems = document.querySelectorAll('.timeline-item');
            container = document.getElementById('timelineContainer');
            cards = document.querySelectorAll('.timeline-content-item');
            
            // 计算容器宽度
            if (container && container.parentElement) {
                containerWidth = container.parentElement.offsetWidth;
                itemWidth = 120;
            }
        }
        
        // 优化的导航更新函数
        function updateTimelineNav() {
            if (!navItems || !container) return;
            
            // 使用requestAnimationFrame优化性能
            requestAnimationFrame(() => {
                // 批量更新导航状态
                navItems.forEach((item, index) => {
                    item.classList.toggle('active', index === currentIndex);
                });

                // 计算位置
                const centerOffset = containerWidth / 2 - itemWidth / 2;
                const translateX = centerOffset - (currentIndex * itemWidth);
                
                // 使用transform3d启用硬件加速
                container.style.transform = `translate3d(${translateX}px, 0, 0)`;
            });
        }

        // 优化的卡片位置更新函数
        function updateCardPositions() {
            if (!cards) return;
            
            // 使用requestAnimationFrame优化性能
            requestAnimationFrame(() => {
                cards.forEach((card, index) => {
                    // 批量移除类名
                    card.className = card.className.replace(/active|prev|next|hidden|stack-hidden/g, '');
                    
                    if (index === currentIndex) {
                        card.classList.add('active');
                        card.style.zIndex = '10';
                    } else if (index === (currentIndex - 1 + totalItems) % totalItems) {
                        card.classList.add('prev');
                        card.style.zIndex = '5';
                    } else if (index === (currentIndex + 1) % totalItems) {
                        card.classList.add('next');
                        card.style.zIndex = '5';
                    } else {
                        card.classList.add('stack-hidden');
                        card.style.zIndex = '1';
                    }
                });
            });
        }

        // 优化的导航函数
        function navigateTimeline(direction) {
            if (isAnimating) return;
            
            isAnimating = true;
            
            if (direction === 'next') {
                currentIndex = (currentIndex + 1) % totalItems;
            } else {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            }
            
            // 批量更新，减少重排
            updateTimelineNav();
            updateCardPositions();
            
            // 使用requestAnimationFrame确保动画完成
            requestAnimationFrame(() => {
                setTimeout(() => {
                    isAnimating = false;
                }, 300);
            });
        }

        function selectCard(year) {
            if (isAnimating) return;
            
            const yearNum = parseInt(year);
            const index = years.indexOf(yearNum);
            
            if (index !== -1 && index !== currentIndex) {
                currentIndex = index;
                showTimelineItem(yearNum.toString());
            }
        }

        function showTimelineItem(year) {
            updateTimelineNav();
            updateCardPositions();
            currentIndex = years.indexOf(year);
        }

        // 优化的拖拽处理
        function handleDragStart(e) {
            if (isAnimating) return;
            
            const clickedCard = e.target.closest('.timeline-content-item');
            if (!clickedCard) return;
            
            isDragging = true;
            hasTriggered = false;
            dragStartTime = Date.now();
            startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
            
            // 使用CSS类而不是直接修改style
            document.body.classList.add('dragging');
            
            e.preventDefault();
            e.stopPropagation();
        }

        // 使用节流优化拖拽移动
        const throttledDragMove = throttle(function(e) {
            if (!isDragging || hasTriggered || isAnimating) return;
            
            currentX = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
            const deltaX = currentX - startX;
            const dragTime = Date.now() - dragStartTime;
            
            if (Math.abs(deltaX) >= dragThreshold && dragTime > 50) {
                hasTriggered = true;
                
                if (deltaX > 0) {
                    navigateTimeline('prev');
                } else {
                    navigateTimeline('next');
                }
                
                // 延迟结束拖拽
                setTimeout(() => {
                    handleDragEnd(e);
                }, 50);
            }
            
            e.preventDefault();
        }, 16); // 60fps

        function handleDragMove(e) {
            throttledDragMove(e);
        }

        function handleDragEnd(e) {
            if (!isDragging) return;
            
            isDragging = false;
            hasTriggered = false;
            dragStartTime = 0;
            
            // 移除CSS类
            document.body.classList.remove('dragging');
            
            startX = 0;
            currentX = 0;
        }

        // 优化的事件监听器
        let clickTimeout;

        // 使用事件委托优化性能
        document.addEventListener('mousedown', (e) => {
            const card = e.target.closest('.timeline-content-item');
            if (card && !isAnimating) {
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

        // 导航项点击 - 使用事件委托
        document.addEventListener('click', (e) => {
            const timelineItem = e.target.closest('.timeline-item');
            if (timelineItem && !isDragging && !isAnimating) {
                const index = Array.from(navItems).indexOf(timelineItem);
                if (index !== -1) {
                    currentIndex = index;
                    showTimelineItem(years[currentIndex]);
                }
                return;
            }
            
            // 卡片点击处理
            const card = e.target.closest('.timeline-content-item');
            if (card && !isDragging && !hasTriggered && !isAnimating) {
                const year = card.getAttribute('data-year');
                selectCard(year);
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

        // 使用防抖优化resize事件
        const debouncedResize = debounce(() => {
            if (!isAnimating) {
                // 重新计算容器宽度
                if (container && container.parentElement) {
                    containerWidth = container.parentElement.offsetWidth;
                }
                updateTimelineNav();
            }
        }, 250);

        window.addEventListener('resize', debouncedResize);

        // 初始化函数
        function initTimeline() {
            initDOMCache();
            updateTimelineNav();
            updateCardPositions();
        }

        // 页面加载完成后初始化
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTimeline);
        } else {
            initTimeline();
        }
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
</body>
</html>