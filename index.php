<!DOCTYPE html>
<html lang="zh">
<head>
    <link rel="icon" type="image/png" href="images/images/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNZZ HOLDINGS</title>
    <style>
        /* 全局样式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            overflow-x: hidden; /* 防止水平滚动 */
            background-color: transparent;
            
            /* 让页面按整页滚动 */
            height: 100%;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
        }

        /* 导航栏 */
        #navbar {
            background-color: transparent;
            padding: 15px 0; /* 增加底部间距 */
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
        }

        /* 导航栏容器 */
        nav .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 3%;
            position: relative;
        }

        /* Logo 部分 */
        nav .logo-container {
            display: flex;
            align-items: center;
            margin-right: 20px;
            flex-shrink: 0;
        }

        /* Logo 文字 */
        nav .logo-text {
            font-size: clamp(1rem, 2vw, 2.5rem); /* 最大字体调整为 2.2rem */
            font-weight: bold;
            color: white;
            margin-left: 10px;
        }

        /* Logo 图片 */
        .logo-img {
            height: clamp(25px, 4.6vw, 65px); /* 最大高度调整为 65px */
            max-height: 75px;
        }

        /* 菜单部分 */
        nav .menu-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            gap: clamp(15px, 2.5vw, 30px); /* 初始间距适中 */
        }

        /* 菜单链接 */
        nav .menu-container a {
            color: white;
            text-decoration: none;
            font-size: clamp(1rem, 1.4vw, 1.8rem); /* 字体最小 1rem，逐步增大 */
        }

        /* 鼠标悬停时 */
        nav .menu-container a:hover {
            color: #FF5C00; 
            text-decoration: underline;
        }

        /* 按钮部分 */
        nav .buttons-container {
            display: flex;
            align-items: center;
            gap: clamp(8px, 2vw, 20px);  /* 调整按钮间距 */
            justify-content: flex-end;
        }

        /* 登录按钮 */
        .login-btn {
            background-color: #FF5C00;
            color: white;
            padding: clamp(5px, 0.8vw, 8px) clamp(8px, 1.2vw, 15px);  /* 更小的内边距 */
            text-decoration: none;
            border-radius: 25px;
            font-size: clamp(1rem, 1.4vw, 1.5rem);  /* 更小的字体大小 */

        }

        .login-btn:hover {
            background-color: #d87b00;
        }

        /* 翻译按钮 */
        .translate-btn {
            border-radius: 25px;  /* 圆角 */
            background-color: transparent;
            color: white;
            font-size: clamp(1rem, 1.4vw, 1.5rem);  /* 字体大小 */
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;  /* 垂直居中 */
            justify-content: flex-start; 
            gap: 0px;  /* 控制 logo 和文本之间的间距 */
            padding-left: 0px;  /* 减小左侧内边距 */
            padding-right: 20px;  /* 可以适当调整右边内边距 */
            overflow: visible;  /* 确保内容不会被隐藏 */
            white-space: nowrap;  /* 确保文本保持在一行 */
        }

        /* 翻译按钮中的 Logo 图片样式 */
        .translate-btn .translate-logo-img {
            width: clamp(30px, 4.8vw, 85px);  /* Logo 尺寸根据按钮大小调整 */
            height: clamp(30px, 4.8vw, 85px); /* 设置 Logo 高度 */
            object-fit: contain;  /* 保证 logo 按比例显示，避免变形 */
            margin-right: -10px; /* 让 logo 贴近文字 */
        }

        /* hover 效果 */
        .translate-btn:hover {
            color: #FF5C00; 
            text-decoration: underline;
        }

        /* 鼠标悬停时，让 logo 变成 #FF5C00 */
        .translate-btn:hover .translate-logo-img {
            filter: brightness(0) saturate(100%) invert(38%) sepia(99%) saturate(1450%) hue-rotate(4deg) brightness(101%) contrast(104%);
        }

        .nav-hidden {
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        nav {
            transition: transform 0.3s ease-in-out;
        }

        /* 版块样式 */
        section {
            width: 100vw;
            height: 100vh; /* 每个 section 占满整个屏幕 */
            padding: 40px 5%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-wrap: wrap;
            scroll-snap-align: start; /* 让滚动时对齐屏幕顶部 */
        }

        #home {
            position: relative;
            width: 100vw;
            height: 100vh; /* 让它始终占满整个视口 */
            display: flex;
            flex-direction: column; /* 让文字纵向排列 */
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding-left: 3%;
            box-sizing: border-box;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('images/images/会议室.jpg') center/cover no-repeat;
            background-size: cover;
        }

        /* 让标题字体更大 */
        #home h1 {
            font-size: clamp(3rem, 6vw, 10rem); /* 屏幕小就变小，大就变大 */
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* 让段落文字更大 */
        #home p {
            font-size: clamp(1.2rem, 1.2vw, 5rem);
            font-weight: bold;
            max-width: 80%; /* 限制文字宽度，避免太长 */
            margin: 0 auto 10px; /* 居中显示 */
            line-height: 1.8; /* 增加行间距 */
        }

        /* 按钮容器，让按钮居中 */
        .home-buttons {
            margin-top: 30px; 
            display: flex;
            gap: 20px; /* 按钮之间的间距 */
            justify-content: center; /* 让按钮居中 */
        }

        /* 按钮样式 */
        .btn {
            background-color: #FF5C00;
            color: white;
            padding: clamp(8px, 1vw, 16px) clamp(16px, 2vw, 32px); /* 根据屏幕大小调整内边距 */
            text-decoration: none;
            font-size: clamp(1rem, 2vw, 1.5rem); /* 自适应字体大小 */
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        /* 按钮鼠标悬停效果 */
        .btn:hover {
            background-color: #d87b00;
            transform: scale(1.05);
        }

        /* 了解我们按钮 */
        .btn-secondary {
            background-color: transparent;
            color: rgb(255, 255, 255);
            border: 2px solid #FF5C00;
        }

        /* 悬停时变色 */
        .btn-secondary:hover {
            background-color: rgb(235, 115, 3);
            color: white;
        }

        /* 让鼠标滚动一下就跳到下一页 */
        html {
            scroll-behavior: smooth; /* 平滑滚动 */
        }

        .scroll-down {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
            animation: bounce 1.5s infinite;
        }

        /* 让鼠标滚动一下就跳到下一页 */
        html {
            scroll-behavior: smooth;
        }

        .scroll-down {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
            animation: bounce 1.5s infinite;
        }

        /* 让箭头或者文字有轻微弹跳效果 */
        @keyframes bounce {
            0%, 100% {
                transform: translate(-50%, 0);
            }
            50% {
                transform: translate(-50%, -10px);
            }
        }


        #missions {
            min-height: 30vh;
            width: 100%;
            height: min(50vh, 400px); /* 让它跟 #home 一样大 */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            background: linear-gradient(to right, 
            rgba(244, 115, 32, 0.85), 
            rgba(254, 196, 20, 0.7)
        ), 
        url('images/images/办公区.jpg') center/cover no-repeat;
        }

        /* 确保文本不会太靠边 */
        #missions .text {
            max-width: 55%;
        }

        /* 文字大小和原来一样 */
        #missions h1 {
            color: white;
            font-size: clamp(2rem, 5vw, 4rem);
            font-weight: bold;
        }

        #missions p {
            color: white;
            font-size: clamp(1rem, 3vw, 2rem);
            font-weight: bold;
        }

        #about-us {
            background-color: transparent;
            color: black;
            display: flex;
            align-items: center;
            text-align: left;
            padding: 40px 5% 50px;  /* 使用百分比确保自适应 */
            gap: 30px;
            max-width: 100%;  /* 确保宽度不会超过屏幕 */
            box-sizing: border-box;  /* 包括padding在内的宽度计算 */
            margin: 0 auto;  /* 让内容居中 */
        }

        #about-us h1 {
            font-size: 4.0rem;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: -5px;
        }

        #about-us .text {
            flex: 1;
            padding: 5px 20px;
            font-size: 1.5rem;
            line-height: 1.8;
            font-weight: bold;
            margin-top: -5px;
        }

        #about-us .image {
            flex: 1;
            background: linear-gradient(to right, #F36F20 0%, #FFCB13 100%);
            min-height: 350px;
            height: auto;
            border-radius: 10px;
        }
        
        #values {
            display: flex;
            justify-content: space-around;
            text-align: center;
            padding: 80px 5%;  /* 修改为百分比，保持自适应 */
            align-items: stretch;
            max-width: 100%;  /* 确保不会超出屏幕宽度 */
            box-sizing: border-box;  /* 包括padding在内的宽度计算 */
        }

        .value-box {
            flex: 1;
            max-width: 350px;  /* 设定最大宽度，但不超过350px */
            margin: 0 15px;
            padding: 10px;
            background-color: transparent;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .value-box img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        .value-box h2 {
            font-size: 2.8rem;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .value-box p {
            font-size: 1.6rem;
            font-weight: bold;
            line-height: 1.2;
            padding: 5px 20px;
        }

        #history {
            width: 100vw;
            height: min(20vh, 200px); /* 让它更细 */
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 10px 20px;
            box-sizing: border-box;
            background: linear-gradient(to right, 
            rgba(245, 121, 31, 0.85), 
            rgba(253, 189, 21, 0.85)
        );
        }

        #history h2 {
            color: white;
            font-size: clamp(2rem, 5vw, 4rem); /* 响应式字体 */
            font-weight: bold;
            margin: 0; /* 避免额外的外边距 */
            padding-top: 5px 0; /* 轻微调整上下间距 */
        }  

        /* 时间轴整体 */
        .timeline {
            position: relative;
            width: 80%;
            margin: 50px auto;
        }

        /* 时间轴的中间虚线 */
        .timeline::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            width: 4px;
            height: 100%;
            border-left: 4px dashed #FFA500;
            transform: translateX(-50%);
            z-index: -1;
        }

        /* 时间轴项 */
        .timeline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 50px 0;
            width: 100%;
        }

        /* 2023 和 2025（照片左，文字右） */
        .timeline-item.left {
            flex-direction: row; /* 默认图片在左 */
        }

        /* 2024（文字左，照片右） */
        .timeline-item.right {
            flex-direction: row-reverse; /* 默认文字在左 */
        }

        /* 时间信息（年份+圆圈） */
        .timeline-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        /* 圆圈 */
        .circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(to bottom, #F67F1E, #FDB716);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        /* 年份 */
        .year {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* 默认虚线向左连接（适用于 2023 & 2025）*/
        .dashed-line {
            position: absolute;
            top: 50%;
            right: calc(50% + 10px); /* 让虚线从时间轴往左延伸 */
            transform: translateY(-50%);
            width: calc(50vw - 200px); /* 让虚线动态调整 */
            height: 4px;
            background: none;
            border-top: 4px dashed #FFA500;
            border-left: none;
            z-index: 1;
        }

        /* 2024（照片在右），虚线向右连接 */
        .timeline-item.right .dashed-line {
            left: calc(50% + 10px); /* 让虚线从时间轴向右延伸 */
            right: auto;
            transform: translateY(-50%);
            width: calc(50vw - 200px);
        }

        /* 小屏幕适配 */
        @media (max-width: 768px) {
            .dashed-line {
                width: calc(50vw - 120px); /* 确保小屏幕时虚线不会太长 */
            }

            .timeline-item.right .dashed-line {
                width: calc(50vw - 120px);
            }
        }

        /* 超小屏幕（480px 以下），改为上下布局 */
        @media (max-width: 480px) {
            .timeline-item {
                flex-direction: column;
                text-align: center;
            }

            .dashed-line {
                display: none; /* 超小屏幕时去掉虚线，防止错乱 */
            }
        }

        /* 让文字和图片容器自适应 */
        .timeline-content {
            flex: 1;
            max-width: 350px; /* 默认稍微小一点 */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        /* 文字大小自动适应 */
        .timeline-text {
            font-size: clamp(0.9rem, 1.5vw, 1.2rem); /* 让文字跟随屏幕变化 */
            text-align: center;
            color: #333;
        }

        /* 让图片大小随屏幕调整 */
        .timeline-img {
            width: 100%;
            max-width: clamp(200px, 25vw, 500px); /* 让图片更灵活 */
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        /* 小屏幕（768px 以下），进一步缩小 */
        @media (max-width: 768px) {
            .timeline-content {
                max-width: 280px;
            }

            .timeline-img {
                max-width: 220px;
            }
        }

        /* 超小屏幕（480px 以下），改为上下排列 */
        @media (max-width: 480px) {
            .timeline-item {
                flex-direction: column;
                text-align: center;
            }

            .timeline-content {
                max-width: 100%;
            }

            .timeline-img {
                max-width: 180px;
            }
        }

        /* 交换左右位置，使 2023 & 2025 的照片在左，文字在右 */
        .timeline-item.left .timeline-content:first-child {
            order: -1; /* 确保图片排在左边 */
        }

        .timeline-item.left .timeline-content:last-child {
            order: 1; /* 文字排在右边 */
        }

        /* 2024 文字在左，照片在右 */
        .timeline-item.right .timeline-content:first-child {
            order: 1; /* 文字在左 */
        }

        .timeline-item.right .timeline-content:last-child {
            order: -1; /* 照片在右 */
        }

        .container {
            display: flex;
            max-width: 85%;
            margin: 8vh auto; /* 上下间距加宽 */
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            padding: 20px 25px; /* 内边距稍微增加 */
            height: 60vh;
            min-height: 450px;
        }

        .contact-info {
            width: 35%;
            padding: 35px;
            background: #fff;
            font-family: 'Roboto', sans-serif; /* 选择更清晰的字体 */
        }

        .contact-info h2 {
            margin-bottom: 25px;
            font-size: 26px;
            font-family: 'Montserrat', sans-serif; /* 让标题更有设计感 */
            font-weight: bold;
            border-bottom: 3px solid #000;
            display: inline-block;
            padding-bottom: 5px;
        }

        .contact-info p {
            font-size: 20px; /* 适中，易读 */
            margin-bottom: 15px;
            font-family: 'Lato', sans-serif; /* 地址、邮箱等适合简洁的字体 */
            letter-spacing: 0.5px; /* 增加字距，提高可读性 */
            line-height: 1.6; /* 让内容看起来更整齐 */
        }

        .map-container {
            width: 65%;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        p {
            font-size: 20px;
            max-width: 800px;
        }
    </style>
</head>
<body>

<nav id="navbar">
    <div class="nav-container">
        <!-- Logo 部分 -->
        <div class="logo-container">
            <img src="images/images/logo.png" alt="Logo" class="logo-img">
            <span class="logo-text">KUNZZ HOLDINGS</span>
        </div>

        <!-- 菜单部分 -->
        <div class="menu-container">
            <a href="#home">首页</a>
            <a href="#about-us">关于我们</a>
            <a href="#brands">旗下品牌</a>
            <a href="#join-us">加入我们</a>
        </div>

        <!-- 按钮部分 -->
        <div class="buttons-container">
            <a href="#" class="login-btn">LOGIN</a> <!-- 登录按钮放左边 -->
            <button class="translate-btn">
                <img src="images/images/翻译.png" alt="Logo" class="translate-logo-img"> <!-- Logo 图片 -->
                EN / CN
            </button>
        </div>
    </div>
</nav>


<section id="home">
    <div>
        <h1>让空间温暖，让团队闪光</h1>
        <p>我们用细节构建舒适的氛围，在积极的文化中滋养每一份热情与专注。</p>
        <p>我们相信，高效源于信任，创新源于自由。</p>
        <p>一支有温度的团队，才能创造持续的价值，向着行业标杆的方向，稳步前行。</p>

        <!-- 按钮区域 -->
        <div class="home-buttons">
            <a href="#join-us" class="btn">加入我们</a>
            <a href="#about-us" class="btn btn-secondary">了解我们</a>
        </div>
    </div>
</section>

    <section id="about-us">
    <div class="text">
            <h1>关于我们</h1>
            <p>Kunzz Holdings Sdn. Bhd.是一家在于马来西亚的多元化控股管理公司，以创新和高效执行力赋能旗下业务稳健发展。公司业务覆盖营销策划、创意设计、财务咨询、及精品日式餐饮服务，我们致力于为子公司提供战略指引、资源共享、管理咨询及人才培养，助力旗下企业持续突破瓶颈，提升行业竞争力。</p>
        </div>
        <div class="image"></div>
    </section>

    <section id="missions">
        <div>
            <h1>我们的使命</h1>
            <p>塑造积极向上和舒适的工作环境</p>
        </div>
    </section>
    
    <section id="values">
        <div class="value-box">
            <img src="images/images/愿景图.jpg" alt="愿景">
            <h2>愿景</h2>
            <p>打造高效且创新的团队，为公司不断创造价值，成为行业标杆。</p>
        </div>
        <div class="value-box">
            <img src="images/images/文化图.jpg" alt="文化">
            <h2>文化</h2>
            <p>积极向上，高效执行，灵活应变，诚信待人。</p>
        </div>
        <div class="value-box">
            <img src="images/images/价值观图.jpg" alt="价值观">
            <h2>价值观</h2>
            <p>目标导向，理念一致，追求卓越，创新精神。</p>
        </div>
    </section>

    <section id="history">
        <h2>发展历史</h2>
    </section>

    <div class="timeline">
        <!-- 2023 -->
        <div class="timeline-item left">
            <div class="timeline-content image-content">
                <img src="images/images/2023发展.jpg" alt="2023发展" class="timeline-img">
            </div>
            <div class="timeline-info">
                <span class="year">2023</span>
                <div class="circle"></div>
                <div class="dashed-line"></div>
            </div>
            <div class="timeline-content text-content">
                <p class="timeline-text">Kunzz Holdings 成立，确立发展方向。</p>
            </div>
        </div>

        <!-- 2024 -->
        <div class="timeline-item right">
            <div class="timeline-content text-content">
                <p class="timeline-text">拓展业务，新增子公司，提升市场影响力。</p>
            </div>
            <div class="timeline-info">
                <span class="year">2024</span>
                <div class="circle"></div>
                <div class="dashed-line"></div>
            </div>
            <div class="timeline-content image-content">
                <img src="images/images/2024发展.jpg" alt="2024发展" class="timeline-img">
            </div>
        </div>

        <!-- 2025 -->
        <div class="timeline-item left">
            <div class="timeline-content image-content">
                <img src="images/images/2025发展.jpg" alt="2025发展" class="timeline-img">
            </div>
            <div class="timeline-info">
                <span class="year">2025</span>
                <div class="circle"></div>
                <div class="dashed-line"></div>
            </div>
            <div class="timeline-content text-content">
                <p class="timeline-text">计划进入国际市场，推动品牌全球化。</p>
            </div>
        </div>
    </div>

    <!-- 联系我们 -->
    <div class="container">
        <div class="contact-info">
            <h2>联系我们</h2>
            <p><strong>地址：</strong>25, Jln Tanjong 3, Taman Desa Cemerlang, 81800 Ulu Tiram, Johor Darul Ta'zim</p>
            <p><strong>邮箱：</strong>contact@kunzzholdings.com</p>
            <p><strong>电话：</strong>+60 123-456 789</p>
        </div>
        <div class="map-container">
        <iframe src="https://www.google.com/maps/d/embed?mid=1RrVHef5rpOnLfmBvdtZOd2RQYWz-56g&ehbc=2E312F&noprof=1" width="640" height="480"></iframe>
        </div>
    </div>
</div>

    <p style="text-align: center; font-size: 14px; color: #666; margin-top: 20px;">
        © 2025 Kunzz Holdings Sdn. Bhd. All rights reserved.
    </p>

    <!-- JavaScript 让鼠标滚轮滚一下直接跳到下一页 -->
    <script>
    document.addEventListener("wheel", (event) => {
        event.preventDefault(); // 禁止默认滚动行为

        let sections = document.querySelectorAll("section");
        let currentIndex = Math.round(window.scrollY / window.innerHeight); // 计算当前在哪个 section

        if (event.deltaY > 0 && currentIndex < sections.length - 1) {
            // 向下滚动
            window.scrollTo({
                top: (currentIndex + 1) * window.innerHeight,
                behavior: "smooth"
            });
        } else if (event.deltaY < 0 && currentIndex > 0) {
            // 向上滚动
            window.scrollTo({
                top: (currentIndex - 1) * window.innerHeight,
                behavior: "smooth"
            });
        }
    }, { passive: false });
    </script>

    <script>
    const navbar = document.getElementById("navbar");

    navbar.style.transition = "top 0.3s ease";  // 平滑过渡效果

    // 监听页面的滚动事件
    window.onscroll = function() {
        // 获取页面的滚动位置
        if (window.scrollY > 0) {
            // 当页面滚动时，隐藏导航栏
            navbar.style.top = "-120px"; // 隐藏导航栏（根据需要调整隐藏的高度）
        } else {
            // 当页面回到顶部时，显示导航栏
            navbar.style.top = "0"; // 导航栏恢复到顶部
        }
    };
    </script>


</body>
</html>
