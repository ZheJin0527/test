<!DOCTYPE html>
<html lang="zh">
<head>
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
            background-color:rgb(245, 238, 231);
        }

        /* 导航栏 */
        nav {
            background-color: white;
            padding: 20px 60px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Logo 容器 */
        nav .logo {
            display: flex;
            align-items: center;
            font-size: 32px;
            font-weight: bold;
            margin-right: auto;
        }

        /* Logo 图片 */
        .logo-img {
            height: 50px; /* 让 Logo 图片高度与文字一致 */
            margin-right: 10px; /* 图片与文字间距 */
        }

        nav .menu {
            display: flex;
            align-items: center;
            margin-right: 50px;
        }

        nav a {
            color: black;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .login-btn {
            background-color: rgb(235, 115, 3);
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-btn:hover {
            background-color: #d87b00;
        }

        /* 翻译按钮 */
        .translate-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color:rgb(235, 115, 3);
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .translate-btn:hover {
            background-color: #d87b00;
        }

        /* 版块样式 */
        section {
            padding: 40px 5%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-wrap: wrap;
        }

        #home {
            position: relative;
            min-height: 35vh;
            width: 100vw;
            height: min(70vh, 600px); /* 让它更大，但最大不超过 700px */
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: white;
            text-align: left;
            padding-left: 3%;
            box-sizing: border-box;
            background: linear-gradient(to right, 
            rgba(245, 123, 31, 1) 0%, 
            rgba(255, 113, 6, 0.70) 57.73%, 
            rgba(255, 255, 255, 0.90) 100%
        ), url('images/images/会议室.jpg') center/cover no-repeat;
            background-size: cover;
        }

        /* 确保文本不会太靠边 */
        #home .text {
            max-width: 50%; /* 文字最多占50%屏幕宽度 */
            font-size: 1.8rem;
        }

        /* 让标题适应各种屏幕 */
        #home h1 {
            font-size: clamp(2rem, 5vw, 4rem); /* 根据屏幕大小自适应 */
            font-weight: bold;
        }

        #home p {
            font-size: clamp(1rem, 2vw, 1.5rem);
            font-weight: bold;
        }

        #missions {
            min-height: 30vh;
            width: 100vw;
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
            background-color: rgb(245, 238, 231);
            color: black;
            display: flex;
            align-items: center;
            text-align: left;
            padding: 40px 8% 50px;
            gap: 30px;
            max-width: 1200px; /* 限制最大宽度 */
            margin: 0 auto; /* 让内容居中 */
        }

        #about-us h1 {
            font-size: 4.0rem;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: -5px;
        }

        /* 文本区域 */
        #about-us .text {
            flex: 1;
            padding: 5px 20px;
            font-size: 1.5rem;
            line-height: 1.8;
            font-weight: bold;
            margin-top: -5px;
        }

        /* 图片区域 */
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
            padding: 80px 10%;
            align-items: stretch; /* 让所有子元素等高 */
        }

        .value-box {
            flex: 1;
            max-width: 350px;
            margin: 0 15px;
            padding: 10;
            background-color: rgb(245, 238, 231);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .value-box img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px; /* 让四个角都变圆 */
        }

        .value-box h2 {
            font-size: 2.8rem;  /* 标题放大 */
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px; /* 缩小标题与段落之间的间距 */
        }

        .value-box p {
            font-size: 1.6rem;  /* 段落字体加大 */
            font-weight: bold;
            line-height: 1.2;  /* 增加行距，提高可读性 */
            padding: 5px 20px;  /* 增加内边距 */
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

        /* 时间轴整体样式 */
        .timeline {
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: relative;
            width: 90%;
            margin: 50px auto 100px;
            padding: 10px 0;
        }

        /* 时间轴横线 */
        .timeline::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: black;
            z-index: -1;
        }

        /* 时间轴项目 */
        .timeline-item {
            text-align: center;
            position: relative;
            width: 30%;
        }

        /* 时间点（黑点在线上） */
        .circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(to bottom, #F67F1E, #FDB716);
            border-radius: 50%;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        /* 事件图片 */
        .timeline-img {
            width: 300px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
            margin: 0 auto;
            position: relative;
        }

        /* 让时间点连接到图片 */
        .timeline-item::after {
            content: "";
            position: absolute;
            left: 50%;
            width: 4px;
            height: 220px;
            background-color: black;
            transform: translateX(-50%);
            z-index: -1;
        }

        /* 让线从时间点向下连接到图片 */
        .timeline-item:nth-child(odd)::after {
            bottom: calc(48% + 8px);
        }

        .timeline-item:nth-child(even)::after {
            top: calc(50% + 8px);
        }

        /* 让 2023 和 2025 向上靠近时间轴 */
        .timeline-item:nth-child(odd) .year,
        .timeline-item:nth-child(odd) .timeline-text {
            position: relative;
            top: -80px; /* 向上移动 */
            font-weight: bold;
        }

        /* 让 2024 向下靠近时间轴 */
        .timeline-item:nth-child(even) .year,
        .timeline-item:nth-child(even) .timeline-text {
            position: relative;
            top: 80px; /* 向下移动 */
            font-weight: bold;
        }

        /* 年份 */
        .year {
            font-size: 1.6rem;
            display: block;
            margin-top: 10px;
            font-weight: 900;
            font-family: "Arial Black", Arial, sans-serif; /* 使用更粗的字体 */
        }

        /* 文字描述 */
        .timeline-text {
            font-size: 1.4rem;
            color: #333;
            margin-top: 5px;
        }

        /* 调整图片与线的距离 */
        .timeline-item:nth-child(odd) .timeline-img {
            margin-bottom: 250px;
        }

        .timeline-item:nth-child(even) .timeline-img {
            margin-top: 250px;
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

    <nav>
    <div class="logo">
        <img src="images/images/logo.png" alt="Logo" class="logo-img">
            KUNZZ HOLDINGS
        </div>
        <div class="menu">
            <button class="translate-btn">EN</button>
            <a href="#home">首页</a>
            <a href="#about-us">关于我们</a>
            <a href="#brands">旗下品牌</a>
            <a href="#" class="login-btn">登录</a>
        </div>
    </nav>

    <section id="home">
        <div>
            <h1>创造价值，引领未来</h1>
            <p>Kunzz Holdings 致力于培养精英团队，为子公司提供解决方案，激发无限可能</p>
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
    <div class="timeline-item">
        <img src="images/images/2023发展.jpg" alt="2023发展" class="timeline-img">
        <div class="circle"></div>
        <span class="year">2023</span>
        <p class="timeline-text">Kunzz Holdings 成立，确立发展方向。</p>
    </div>

    <!-- 2024 -->
    <div class="timeline-item">
    <p class="timeline-text">拓展业务，新增子公司，提升市场影响力。</p>
        <div class="circle"></div>
        <span class="year">2024</span>
        <img src="images/images/2024发展.jpg" alt="2024发展" class="timeline-img">
    </div>

    <!-- 2025 -->
    <div class="timeline-item">
        <img src="images/images/2025发展.jpg" alt="2025发展" class="timeline-img">
        <div class="circle"></div>
        <span class="year">2025</span>
        <p class="timeline-text">计划进入国际市场，推动品牌全球化。</p>
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

</body>
</html>
