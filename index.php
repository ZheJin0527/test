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
            padding: 0 20px; /* 移除内边距，直接控制高度 */
            position: fixed;
            width: 100%;
            max-width: 1920px; /* 设置为 Figma 提供的宽度 */
            height: 80px; /* 设置为 Figma 提供的高度 */
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
            max-width: 1920px;
            width: 100%;
            padding: 0 20px;  /* 增加左右内边距，保证内容不至于贴边 */
            position: relative;
            margin-left: 20px;
        }

        /* Logo 部分 */
        nav .logo-container {
            display: flex;
            align-items: center;

            flex-shrink: 0;
            padding: 0;
        }

        /* Logo 文字样式 */
        nav .logo-text {
            font-size: 16px; /* 增大字体大小以匹配 Figma 设计 */
            font-weight: bold;
            color: white;
            margin-left: 10px;
            padding: 0 20px 0 0;
            
            /* 定位调整 */
            position: absolute;  /* 使用绝对定位 */
            top: 22px;  /* 设置从顶部的距离为22px */
            left: 125px; /* 设置从左边的距离为125px */
            height: 34px; /* 设置高度为34px */
            box-sizing: border-box;  /* 确保宽高包含内边距和边框 */
        }


        /* Logo 图片样式 */
        .logo-img {
            width: 40px;  /* 设置宽度为40px */
            height: 40px; /* 设置高度为40px */
            position: absolute;  /* 使用绝对定位 */
            top: 22px;  /* 设置从顶部的距离为19px */
            left: 80px; /* 设置从左边的距离为80px */
        }


        /* 菜单容器样式 */
        nav .menu-container {
            position: relative;  /* 修改为相对定位 */
            max-width: 1920px;  /* 设置最大宽度为1920px */
            height: 22px;  /* 设置容器高度 */
            display: flex;
            justify-content: space-between;  /* 水平均匀分布菜单项 */
            gap: 20px;
            align-items: center;  /* 垂直居中 */
            padding: 15px 30px;  /* 设置内边距 */
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            border: 2px solid rgba(200, 200, 200, 0.5);
            box-sizing: border-box;
            margin: 0 auto;  /* 使容器在父元素中居中 */
            top: 22px;
        }

        /* 菜单链接 */
        nav .menu-container a {
            color: white;
            text-decoration: none;
            font-size: 16px; /* 增大菜单字体大小 */
            height: 22px; /* 固定高度 */
            line-height: 22px;  /* 确保文字垂直居中 */
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
            justify-content: flex-end;
            max-width: 1920px;  /* 设置最大宽度为 1920px */
            height: 40px;  /* 增加容器高度，保证按钮间距更加宽松 */
            gap: 32px;  /* 设置按钮之间的间距为 32px */
            position: absolute;  /* 使用绝对定位来放置容器 */
            padding-right: 30px;  /* 为容器添加右内边距，避免按钮靠边 */
            box-sizing: border-box;  /* 确保 padding 包含在总宽度内 */
            top: 22px;  /* 设置容器的 top 值为 26px */
            right: 0;  /* 使用 right: 0 来确保容器靠右对齐 */
            margin-right: 20px;
        }

        /* 登录按钮 */
        .login-btn {
            background-color: #FF5C00;
            color: white;
            width: 100px;  /* 设置按钮的宽度 */
            height: 40px;  /* 增加按钮的高度，让它看起来更加宽松 */
            padding: 0;  /* 去除原有的内边距，因为已经通过宽高定义按钮尺寸 */
            text-decoration: none;
            border-radius: 25px;  /* 保留原有的圆角 */
            font-size: 16px;
            display: flex;  /* 使用 flexbox 来确保按钮内容居中 */
            justify-content: center;  /* 水平居中 */
            align-items: center;  /* 垂直居中 */
        }


        .login-btn:hover {
            background-color: #d87b00;
        }

        /* 翻译按钮 */
        .translate-btn {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 8px;  /* 设置 Logo 和文本之间的间距为 8px */
            width: auto;  /* 根据内容自适应宽度 */
            height: 23px;  /* 设置按钮高度为 23px */
            font-size: 16px;  /* 设置字体大小为 16px */
            color: white;
            border: none;
            background-color: transparent;
            cursor: pointer;
            padding-left: 0;
            padding-right: 20px;
            overflow: visible;
            white-space: nowrap;
        }

        /* 翻译按钮中的 Logo 图片样式 */
        .translate-btn .translate-logo-img {
            width: 12px;  /* 设置 Logo 图片宽度为 12px */
            height: 12px;  /* 设置 Logo 图片高度为 12px */
            object-fit: contain;
            margin-right: 0;  /* 去除右边距 */
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
        
        #home {
            position: relative;
            width: 1920px;  /* 设置固定宽度为1920px */
            height: 1000px;  /* 高度为视口高度 */
            margin: 0 auto; /* 居中对齐 */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
            url('images/images/会议室.jpg') center/cover no-repeat; /* 背景图片 */
            background-size: cover;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding-left: 3%;
            box-sizing: border-box;
        }

        #home h1 {
    position: absolute;
    width: 1144px;  /* 保留 Figma 的宽度 */
    height: 101px;  /* 保留 Figma 的高度 */
    top: 352px;  /* 保留 Figma 的顶部位置 */
    left: 80px;  /* 保留 Figma 的左侧位置 */
    font-size: 100px;  /* 屏幕小就变小，大就变大 */
    font-family: 'Source Sans Pro', 'Noto Sans CJK SC', 'PingFang SC', 'Microsoft YaHei', sans-serif;
    font-weight: 900;
    line-height: 140%;
    letter-spacing: 1.4%;
    text-align: left;
    margin-bottom: 20px;  /* 增加底部间距，避免重叠 */
}

#home p {
    position: absolute;
    width: 864px;
    top: 533px;  /* 保持与 Figma 设计一致，段落开始位置 */
    left: 80px;
    font-family: 'Source Sans Pro', 'Noto Sans CJK SC', 'PingFang SC', 'Microsoft YaHei', sans-serif;
    font-weight: 300;
    font-size: 24px;
    line-height: 140%;
    letter-spacing: 0;
    margin: 0;
    padding: 0;
    text-align: left;
    white-space: normal;
}



        /* 按钮容器，让按钮居中 */
        .btn {
    position: absolute;
    top: 747px;
    left: 80px;
    width: 248px;
    height: 70px;
    border-radius: 10px;
    padding: 15px 60px;
    background-color: #FF5C00;
    color: white;
    font-size: 32px; /* Figma 字号 */
    font-family: 'Source Sans Pro', sans-serif; /* Figma 字体 */
    font-weight: 700; /* Figma 粗细 */
    line-height: 100%; /* Figma 行高 */
    letter-spacing: 0%; /* Figma 字间距 */
    text-align: center; /* Figma 对齐 */
    text-decoration: none;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background 0.3s ease, transform 0.2s ease;
}




        /* 按钮鼠标悬停效果 */
        .btn:hover {
            background-color: #d87b00;
            transform: scale(1.05);
        }
        
        h1 {
            font-size: 100px;
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
            <span class="logo-text">KUNZZ HOLDINGS<br>Sdn Bhd</span>
        </div>

        <!-- 菜单部分 -->
        <div class="menu-container">
            <a href="#home">首页</a>
            <div class="dropdown">
                <a href="#about-us">关于我们</a>
            </div>
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
            <p>我们用细节构建舒适的氛围，在积极的文化中滋养每一份热情与专注。我们相信，高效源于信任，创新源于自由。一支有温度的团队，才能创造持续的价值，向着行业标杆的方向，稳步前行。</p>
                <a href="#about-us" class="btn">了解我们</a>
        </div>
    </section>
    
    </body>
</html>