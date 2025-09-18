<?php
// Ensure variables exist when included from different pages
$username = isset($username) ? $username : (isset($_SESSION['username']) ? $_SESSION['username'] : 'User');
$position = isset($position) ? $position : ((isset($_SESSION['position']) && !empty($_SESSION['position'])) ? $_SESSION['position'] : 'User');
$avatarLetter = isset($avatarLetter) ? $avatarLetter : strtoupper(substr($username, 0, 1));
$canViewAnalytics = isset($canViewAnalytics) ? $canViewAnalytics : true;
?>

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
        setcookie('position', '', time() - 60, "/");
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
    $_SESSION['position'] = isset($_COOKIE['position']) ? $_COOKIE['position'] : null;
    $_SESSION['last_activity'] = time();
} else {
    // 没有 session，也没有有效 cookie
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
// 修改这行：检查position是否为空或null
$position = (!empty($_SESSION['position'])) ? $_SESSION['position'] : 'User';
$avatarLetter = strtoupper($username[0]);
// 添加权限检查 - 检查用户注册码
$canViewAnalytics = true; // 默认可以查看
if (isset($_SESSION['user_id'])) {
    $host = 'localhost';
    $dbname = 'u857194726_kunzzgroup';
    $dbuser = 'u857194726_kunzzgroup';
    $dbpass = 'Kholdings1688@';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $restrictedCodes = ['SUPPORT88','DESIGN88','PHOTO001']; // 限制访问的注册码
        $userId = $_SESSION['user_id'];
        
        $stmt = $pdo->prepare("SELECT registration_code FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $userCode = $stmt->fetchColumn();
        
        $canViewAnalytics = !($userCode && in_array($userCode, $restrictedCodes));
    } catch (PDOException $e) {
        $canViewAnalytics = true; // 出错时默认允许访问
    }
}
?>

<link rel="stylesheet" href="style.css" />
<style>
    /* 防止页面加载时的布局跳动 */
body {
    margin-left: 0;
}

body.has-sidebar {
    margin-left: 250px;
}

body.has-sidebar.sidebar-collapsed {
    margin-left: 70px;
}

/* 取消整页白色覆盖，但保留侧栏本体为白色卡片 */
.informationmenu {
    background: transparent !important; /* 容器透明，不再铺一层白底 */
    pointer-events: none;              /* 容器非交互，避免遮挡右侧内容点击 */
}
.informationmenu.show { background: transparent !important; }

/* 仅让侧栏内部结构保持白色背景并可交互 */
.informationmenu .informationmenu-header,
.informationmenu .informationmenu-content,
.informationmenu .informationmenu-footer {
    background: #ffffff;               /* 侧栏本体白底 */
    pointer-events: auto;              /* 本体可交互 */
}

/* 若有使用伪元素做遮罩，强制移除 */
.informationmenu::before,
.informationmenu::after { display: none !important; }

/* 页面内容右移，避免被侧栏覆盖 */
body.has-sidebar {
    margin-left: 250px; /* 与 .informationmenu 宽度一致 */
}
body.has-sidebar.sidebar-collapsed {
    margin-left: 70px; /* 收起时预留更小宽度 */
}
@media (max-width: 768px) {
    body.has-sidebar { margin-left: 0; }
    /* 移动端采用抽屉式覆盖显示 */
    .informationmenu.hide { transform: translateX(-100%); }
    .informationmenu.show { transform: translateX(0); }
}

/* 修复箭头图标被样式覆盖为横线的问题：强制使用文本箭头并移除背景/伪元素 */
.informationmenu .section-arrow,
.informationmenu .informationmenu-arrow {
    background: none !important;
    width: auto !important;
    height: auto !important;
    border: none !important;
    box-shadow: none !important;
    margin: 0 !important;
    padding: 0 !important;
    -webkit-mask: none !important;
    mask: none !important;
}
.informationmenu .section-arrow::before,
.informationmenu .informationmenu-arrow::before,
.informationmenu .section-arrow::after,
.informationmenu .informationmenu-arrow::after {
    content: none !important;
}
.informationmenu .section-arrow { font-size: 16px; line-height: 1; display: inline-block; }
.informationmenu .informationmenu-arrow { font-size: 18px; line-height: 1; display: inline-block; }

/* 按用户要求，隐藏“分组标题”的箭头，保留子项箭头 */
.informationmenu .section-arrow { display: none !important; }
</style>

<!-- 侧边菜单 -->
<div class="informationmenu">
    <div class="informationmenu-header">
        <div class="user-avatar-dropdown">
            <div id="user-avatar" class="user-avatar"><?php echo $avatarLetter; ?></div>
            <div class="user-info">
                <div class="user-name"><?php echo $username; ?></div>
                <div class="user-position"><?php echo $position; ?></div>
            </div>
        </div>

        <div class="sidebar-menu-hamburger" id="sidebarToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="informationmenu-content">
        <?php if ($canViewAnalytics): ?>
        <div class="informationmenu-section">
            <div class="informationmenu-section-title" data-target="analytics-items">
                <img src="images/images/运营分析与报表.png" alt="" class="section-icon">
                营收数据
                <span class="section-arrow">⮞</span>
            </div>
            <div class="dropdown-menu-items" id="analytics-items">
                <div class="menu-item-wrapper">
                    <a href="kpi.php" class="informationmenu-item">
                        KPI报表
                    </a>
                </div>
                <div class="menu-item-wrapper">
                    <a href="kpiedit.php" class="informationmenu-item">
                        数据上传
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="informationmenu-section">
            <div class="informationmenu-section-title" data-target="hr-items">
                <img src="images/images/人事与资源管理.png" alt="" class="section-icon">
                人事管理
            </div>
            <div class="dropdown-menu-items" id="hr-items">               
                <div class="menu-item-wrapper">
                    <a href="generatecode.php" class="informationmenu-item">
                        职员管理
                    </a>
                </div>
            </div>
        </div>

        <div class="informationmenu-section">
            <div class="informationmenu-section-title" data-target="resource-items">
                <img src="images/images/资源库管理.png" alt="" class="section-icon">
                资源总库
                <span class="section-arrow">⮞</span>
            </div>
            <div class="dropdown-menu-items" id="resource-items">               
                <div class="menu-item-wrapper">
                    <a href="stocklistall.php" class="informationmenu-item">
                        库存
                    </a>
                </div>
            </div>
        </div>

        <div class="informationmenu-section">
            <div class="informationmenu-section-title" data-target="photoupload-items">
                <img src="images/images/网页照片上传.png" alt="" class="section-icon">
                视觉管理
                <span class="section-arrow">⮞</span>
            </div>
            <div class="dropdown-menu-items" id="photoupload-items">
                <div class="menu-item-wrapper">
                    <a href="bgmusicupload.php" class="informationmenu-item">
                        背景音乐
                    </a>
                </div>

                <div class="menu-item-wrapper">
                    <a href="#" class="informationmenu-item">
                        首页
                        <span class="informationmenu-arrow">›</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-header">
                            <div class="submenu-title">首页</div>
                        </div>
                        <div class="submenu-content">
                            <a href="homepage1upload.php" class="submenu-item">第一页</a>
                        </div>
                    </div>
                </div>
                
                <div class="menu-item-wrapper">
                    <a href="#" class="informationmenu-item">
                        关于我们
                        <span class="informationmenu-arrow">›</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-header">
                            <div class="submenu-title">关于我们</div>
                        </div>
                        <div class="submenu-content">
                            <a href="aboutpage1upload.php" class="submenu-item">第一页</a>
                            <a href="aboutpage4upload.php" class="submenu-item">第四页</a>
                        </div>
                    </div>
                </div>

                <div class="menu-item-wrapper">
                    <a href="#" class="informationmenu-item">
                        旗下品牌
                        <span class="informationmenu-arrow">›</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-header">
                            <div class="submenu-title">旗下品牌</div>
                        </div>
                        <div class="submenu-content">
                            <a href="tokyopage1upload.php" class="submenu-item">第一页</a>
                            <a href="tokyopage5upload.php" class="submenu-item">第五页</a>
                        </div>
                    </div>
                </div>

                <div class="menu-item-wrapper">
                    <a href="#" class="informationmenu-item">
                        加入我们
                        <span class="informationmenu-arrow">›</span>
                    </a>
                    <div class="submenu">
                        <div class="submenu-header">
                            <div class="submenu-title">加入我们</div>
                        </div>
                        <div class="submenu-content">
                            <a href="joinpage1upload.php" class="submenu-item">第一页</a>
                            <a href="joinpage2upload.php" class="submenu-item">第二页</a>
                            <a href="joinpage3upload.php" class="submenu-item">第三页</a>
                        </div>
                    </div>
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

<script>
    const sidebar = document.querySelector('.informationmenu');
    // 移除遮罩层逻辑
    const overlay = null;
    const userAvatar = document.getElementById('user-avatar');
    const closeBtn = document.querySelector('.informationmenu-close-btn');

    // 点击用户头像显示菜单
    userAvatar?.addEventListener('click', function() {
        sidebar.classList.add('show');
    });

    // 关闭菜单
    function closeSidebar() {
        sidebar.classList.remove('show');
        // 无遮罩层
        // 关闭所有下拉菜单
        document.querySelectorAll('.dropdown-menu-items').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
        document.querySelectorAll('.informationmenu-section-title').forEach(title => {
            title.classList.remove('active');
        });
    }

    closeBtn?.addEventListener('click', closeSidebar);
    // 无遮罩层点击事件

    // ESC键关闭菜单
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    // Section标题点击事件
    document.querySelectorAll('.informationmenu-section-title').forEach(title => {
        title.addEventListener('click', function(e) {
            const targetId = this.getAttribute('data-target');
            const targetDropdown = document.getElementById(targetId);
    
            // 检查侧边栏是否处于收起状态
            if (sidebarMenu.classList.contains('collapsed')) {
                e.preventDefault();
                e.stopPropagation();
        
                // 展开侧边栏
                sidebarMenu.classList.remove('collapsed');
                sidebarToggle.classList.remove('collapsed');
        
                // 同时展开点击的选项
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
        
                // 激活当前section
                this.classList.add('active');
                targetDropdown?.classList.add('show');
        
                return false;
            }

            // 侧边栏已展开时的正常切换逻辑
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
<script>
    // 侧边栏收起/展开功能
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarMenu = document.querySelector('.informationmenu'); // 改名避免冲突

    sidebarToggle?.addEventListener('click', function(e) {
        e.stopPropagation(); // 防止事件冒泡

        // 如果正在收起侧边栏，清除所有激活状态
        if (!sidebarMenu.classList.contains('collapsed')) {
            // 关闭所有下拉菜单
            document.querySelectorAll('.dropdown-menu-items').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            // 移除所有section title的active状态
            document.querySelectorAll('.informationmenu-section-title').forEach(title => {
                title.classList.remove('active');
            });
            // 移除所有菜单项的active状态
            document.querySelectorAll('.informationmenu-item').forEach(item => {
                item.classList.remove('active');
            });
        }

        sidebarMenu.classList.toggle('collapsed');
        sidebarToggle.classList.toggle('collapsed');
        document.body.classList.toggle('sidebar-collapsed');
    });

    // 初始：为页面标记有侧栏，先禁用动画再启用
    document.addEventListener('DOMContentLoaded', function() {
        // 先禁用动画
        document.body.style.transition = 'none';
        document.body.classList.add('has-sidebar');
        
        // 强制重绘后重新启用动画
        document.body.offsetHeight; // 触发重绘
        setTimeout(() => {
            document.body.style.transition = 'margin-left 0.3s ease';
        }, 10);
    });
</script>

