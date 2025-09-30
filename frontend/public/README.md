# 📦 Frontend Public 组件

这个文件夹包含使用 Tailwind CSS 构建的可复用页面组件。

## 📁 文件结构

```
frontend/public/
├── header.php          # Header 导航栏组件
└── README.md          # 本说明文件
```

---

## 🎨 Header 组件

### 使用方法

#### 方式1：直接包含（推荐）
```php
<?php
// 在你的页面顶部
$pageTitle = "页面标题";  // 可选
$showPageIndicator = true;  // 可选，显示页面指示器
$totalSlides = 4;  // 可选，指示器数量

include 'frontend/public/header.php';
?>

<!-- 你的页面内容 -->
<main>
    <!-- 内容 -->
</main>
```

#### 方式2：作为模板的一部分
```php
<!DOCTYPE html>
<html>
<head>
    <?php include 'frontend/public/header.php'; ?>
</head>
<body>
    <!-- 内容 -->
</body>
</html>
```

---

## ⚙️ 配置选项

### 可用变量

| 变量 | 类型 | 默认值 | 说明 |
|------|------|--------|------|
| `$pageTitle` | string | 'KUNZZ HOLDINGS' | 页面标题 |
| `$additionalCSS` | array | - | 额外的CSS文件数组 |
| `$showPageIndicator` | boolean | false | 是否显示页面指示器 |
| `$totalSlides` | integer | 4 | 页面指示器数量 |

### 示例
```php
<?php
$pageTitle = "关于我们 - KUNZZ HOLDINGS";
$additionalCSS = ['css/custom.css', 'css/about.css'];
$showPageIndicator = true;
$totalSlides = 5;

include 'frontend/public/header.php';
?>
```

---

## 🎯 功能特性

### ✅ 已包含功能

1. **响应式设计**
   - 移动端：汉堡菜单
   - 桌面端：水平导航

2. **交互功能**
   - 登入下拉菜单（员工/会员）
   - 语言切换（中文/English）
   - 页面指示器（可选）

3. **动画效果**
   - Logo hover 缩放
   - 导航下划线动画
   - 下拉菜单滑入效果

4. **自动功能**
   - 语言选择保存到 localStorage
   - 滚动时 header 阴影变化
   - 页面指示器点击切换

---

## 🔧 自定义导航链接

修改 `header.php` 中的导航部分：

```php
<!-- 桌面导航 -->
<div class="hidden lg:flex items-center space-x-10 xl:space-x-12">
    <a href="index.php" class="...">首页</a>
    <a href="about.php" class="...">关于我们</a>
    <a href="brands.php" class="...">旗下品牌</a>
    <a href="joinus.php" class="...">加入我们</a>
</div>
```

---

## 🎨 自定义样式

### 使用 Tailwind 工具类
直接修改 class：
```html
<a href="#" class="text-white hover:text-gray-300 text-lg">链接</a>
```

### 使用预定义组件类
在 `frontend/src/input.css` 中定义：
```css
@layer components {
  .nav-link-custom {
    @apply text-white hover:text-kunzz-orange text-lg;
  }
}
```

---

## 📱 响应式断点

| 断点 | 屏幕宽度 | 显示 |
|------|----------|------|
| 默认 | < 1024px | 汉堡菜单 |
| `lg:` | ≥ 1024px | 水平导航 |
| `xl:` | ≥ 1280px | 更大间距 |

---

## 🔗 依赖

### CSS
- Tailwind CSS (`../dist/output.css`)
- Swiper CSS（可选）

### JavaScript
- jQuery 3.7.1
- 内置 vanilla JS 交互

### 字体
- Inter
- Source Sans Pro
- Noto Sans SC

---

## 🚀 完整页面示例

```php
<?php
// 配置
$pageTitle = "首页 - KUNZZ HOLDINGS";
$showPageIndicator = true;
$totalSlides = 4;

// 引入 Header
include 'frontend/public/header.php';
?>

<!-- 主内容 -->
<main class="min-h-screen">
    <!-- Hero Section -->
    <section class="section-container bg-gradient-to-r from-kunzz-orange to-kunzz-orange-light text-white">
        <h1 class="heading-1">欢迎来到 KUNZZ HOLDINGS</h1>
        <p class="paragraph">现代化的响应式设计</p>
    </section>

    <!-- 内容区域 -->
    <section class="section-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card">卡片1</div>
            <div class="card">卡片2</div>
            <div class="card">卡片3</div>
        </div>
    </section>
</main>

<!-- Footer（可选） -->
<footer class="bg-kunzz-dark text-white py-8">
    <div class="container mx-auto text-center">
        © 2025 KUNZZ HOLDINGS. All rights reserved.
    </div>
</footer>

</body>
</html>
```

---

## 📋 注意事项

1. **路径问题**
   - 确保 Tailwind CSS 路径正确：`../dist/output.css`
   - Logo 路径：`../../images/images/KUNZZ.png`

2. **编译 Tailwind**
   - 修改样式后运行：`cd frontend && npm run build`

3. **Session 管理**
   - Header 会自动启动 PHP session
   - 会尝试包含 `media_config.php`（如果存在）

4. **浏览器兼容**
   - 现代浏览器（Chrome, Firefox, Safari, Edge）
   - 需要 JavaScript 支持

---

## 🔄 更新日志

### v1.0.0 (当前版本)
- ✅ 初始版本
- ✅ 完整的响应式设计
- ✅ 登入和语言下拉菜单
- ✅ 页面指示器支持
- ✅ Tailwind CSS 集成

---

## 💡 提示

- 使用 `btn-primary` 和 `btn-secondary` 类创建一致的按钮
- 使用 `card` 类创建统一的卡片样式
- 使用 `section-container` 类创建标准的内容区域
- 查看 `TAILWIND_QUICK_REFERENCE.md` 了解更多工具类

---

**Happy Coding! 🎉**
