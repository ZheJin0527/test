# 🚀 Tailwind CSS 快速参考

## 📦 常用命令

```bash
# 开发模式（实时编译）
cd frontend && npm run dev

# 生产构建（压缩）
cd frontend && npm run build

# 调试构建（未压缩）
cd frontend && npm run build:debug
```

---

## 🎨 自定义颜色

| Class | 颜色值 | 用途 |
|-------|--------|------|
| `bg-kunzz-orange` | #FF5C00 | 主色 |
| `bg-kunzz-orange-hover` | #d87b00 | 悬停色 |
| `bg-kunzz-orange-light` | #f7931e | 浅橙色 |
| `bg-kunzz-dark` | #2F2F2F | 深灰色 |
| `border-kunzz-border` | #444 | 边框色 |

---

## 📏 响应式字体

| Class | 效果 |
|-------|------|
| `text-responsive-xs` | clamp(0.75rem, 2vw, 0.875rem) |
| `text-responsive-sm` | clamp(0.875rem, 2.5vw, 1rem) |
| `text-responsive-base` | clamp(1rem, 3vw, 1.125rem) |
| `text-responsive-lg` | clamp(1.125rem, 3.5vw, 1.5rem) |
| `text-responsive-xl` | clamp(1.5rem, 4vw, 2rem) |
| `text-responsive-2xl` | clamp(2rem, 5vw, 3rem) |
| `text-responsive-3xl` | clamp(2.5rem, 6vw, 4rem) |

---

## 📐 响应式间距

| Class | 效果 |
|-------|------|
| `p-responsive-xs` | clamp(0.25rem, 1vw, 0.5rem) |
| `m-responsive-sm` | clamp(0.5rem, 2vw, 1rem) |
| `p-responsive-md` | clamp(1rem, 3vw, 1.5rem) |
| `m-responsive-lg` | clamp(1.5rem, 4vw, 2rem) |
| `p-responsive-xl` | clamp(2rem, 5vw, 3rem) |
| `m-responsive-2xl` | clamp(3rem, 8vw, 5rem) |

---

## 🧩 预定义组件

### 按钮
```html
<button class="btn-primary">主按钮</button>
<button class="btn-secondary">次要按钮</button>
```

### 卡片
```html
<div class="card">
    卡片内容
</div>
```

### 输入框
```html
<input type="text" class="input-field" placeholder="输入内容" />
```

### 导航链接
```html
<a href="#" class="nav-link">导航</a>
```

### 标题
```html
<h1 class="heading-1">一级标题</h1>
<h2 class="heading-2">二级标题</h2>
<h3 class="heading-3">三级标题</h3>
```

### 段落
```html
<p class="paragraph">段落内容</p>
```

### Section容器
```html
<section class="section-container">
    内容区域
</section>
```

---

## 📱 响应式断点

```html
<!-- 移动端优先 -->
<div class="
    text-sm          /* 默认：小文字 */
    sm:text-base     /* ≥640px：正常文字 */
    md:text-lg       /* ≥768px：大文字 */
    lg:text-xl       /* ≥1024px：超大文字 */
    xl:text-2xl      /* ≥1280px：巨大文字 */
">
    响应式文字
</div>
```

---

## 🎭 工具类

### 文字渐变
```html
<h1 class="text-gradient">渐变文字</h1>
```

### 毛玻璃效果
```html
<div class="glass-effect">亮色毛玻璃</div>
<div class="glass-dark">暗色毛玻璃</div>
```

### 动画
```html
<div class="animate-fade-in">淡入动画</div>
<div class="animate-slide-up">上滑动画</div>
<div class="animate-slide-down">下滑动画</div>
```

### 动画延迟
```html
<div class="animate-slide-up animation-delay-100">延迟100ms</div>
<div class="animate-slide-up animation-delay-200">延迟200ms</div>
<div class="animate-slide-up animation-delay-300">延迟300ms</div>
```

---

## 💡 常用模式

### 响应式导航
```html
<nav>
    <!-- 移动端：隐藏 -->
    <div class="hidden lg:flex space-x-8">
        <a href="#">桌面导航</a>
    </div>
    
    <!-- 桌面端：隐藏 -->
    <button class="lg:hidden">☰</button>
</nav>
```

### 网格布局
```html
<div class="grid 
    grid-cols-1      /* 移动端：1列 */
    md:grid-cols-2   /* 平板：2列 */
    lg:grid-cols-3   /* 桌面：3列 */
    gap-6
">
    <div class="card">1</div>
    <div class="card">2</div>
    <div class="card">3</div>
</div>
```

### Flexbox居中
```html
<div class="flex justify-center items-center min-h-screen">
    <div>居中内容</div>
</div>
```

### 下拉菜单
```html
<div class="relative group">
    <button>菜单</button>
    <div class="absolute opacity-0 group-hover:opacity-100">
        <a href="#">选项1</a>
    </div>
</div>
```

### Hero Section
```html
<section class="section-container bg-gradient-to-r from-kunzz-orange to-kunzz-orange-light text-white">
    <h1 class="heading-1">大标题</h1>
    <p class="paragraph">描述文字</p>
</section>
```

---

## 🔍 调试技巧

### 1. 检查class是否生效
打开浏览器DevTools，查看元素的computed styles

### 2. 查看编译后的CSS
```bash
npm run build:debug
# 查看 frontend/dist/output.css
```

### 3. 确认文件被扫描
检查 `tailwind.config.js` 的 `content` 配置

### 4. 清除缓存
```bash
# 删除 dist/output.css 后重新构建
rm frontend/dist/output.css
npm run build
```

---

## ⚡ 性能提示

1. **只使用需要的class**
   - Tailwind会自动移除未使用的样式

2. **生产环境使用压缩**
   ```bash
   npm run build  # 自动压缩
   ```

3. **避免动态class**
   ```html
   <!-- ❌ 不好 -->
   <div class="${color}-500">
   
   <!-- ✅ 好 -->
   <div class="bg-kunzz-orange">
   ```

4. **使用组件类避免重复**
   ```css
   /* input.css */
   .my-button {
     @apply bg-kunzz-orange px-6 py-2 rounded;
   }
   ```

---

## 📚 快速链接

- [完整配置指南](TAILWIND_SETUP_GUIDE.md)
- [示例Header](EXAMPLE_HEADER.php)
- [Tailwind官方文档](https://tailwindcss.com/docs)

---

**快速上手，高效开发！** 🎉
