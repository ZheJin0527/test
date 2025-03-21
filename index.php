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
        }

        /* 导航栏 */
        nav {
            background-color: white;
            padding: 10px 60px;
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
        
        nav .logo {
            font-size: 24px;
            font-weight: bold;
            margin-right: auto;
        }

        nav .menu {
            display: flex;
            align-items: center;
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
            background-color: #f90;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .login-btn:hover {
            background-color: #d87b00;
        }

        /* 版块样式 */
        section {
            padding: 50px 10%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #home, #brands {
            background-color: #d67232;
            color: white;
            flex-direction: column;
            padding: 40px;
            width: 80%;
            margin: 40px auto;
            border-radius: 10px;
        }

        #about-us {
            background-color: white;
            color: black;
            display: flex;
            align-items: center;
            text-align: left;
            padding: 40px 10%;
        }

        #about-us .text {
            flex: 1;
            padding: 0 20px;
        }

        #about-us .image {
            flex: 1;
            background-color: #d67232;
            height: 200px;
        }

        #values {
            display: flex;
            justify-content: space-around;
            text-align: center;
            padding: 40px 10%;
        }

        .value-box {
            flex: 1;
            max-width: 250px;
            margin: 0 10px;
            padding: 0;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        .value-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .value-box h2, .value-box p {
            padding: 10px;
            margin: 0;
        }

        #history {
            text-align: center;
            background-color: #d67232;
            padding: 20px 0;
            color: white;
            font-size: 22px;
            font-weight: bold;
            width: 70%;
            margin: 40px auto;
            border-radius: 8px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        p {
            font-size: 16px;
            max-width: 800px;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo">KUNZZ HOLDINGS</div>
        <div class="menu">
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
        <div class="image"></div>
        <div class="text">
            <h1>关于我们</h1>
            <p>Kunzz Holdings Sdn. Bhd.是一家在于马来西亚的多元化控股管理公司，以创新和高效执行力赋能旗下业务稳健发展。公司业务覆盖营销策划、创意设计、财务咨询、及精品日式餐饮服务，我们致力于为子公司提供战略指引、资源共享、管理咨询及人才培养，助力旗下企业持续突破瓶颈，提升行业竞争力。</p>
        </div>
    </section>

    <section id="brands">
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

</body>
</html>
