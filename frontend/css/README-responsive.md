# KUNZZ HOLDINGS - 响应式设计系统

## 📱 Desktop First 响应式断点

本项目采用 **Desktop First（桌面优先）** 的响应式设计策略，主要针对公司内部员工使用，默认设备为电脑。

### 🖥️ 断点设计

| 断点 | 屏幕尺寸 | 目标设备 | 容器宽度 | 说明 |
|------|----------|----------|----------|------|
| **默认** | ≥1400px | 4K/2K大屏显示器 | 1600px | 主要用户设备，最佳体验 |
| **Large** | ≤1600px | 普通2K显示器 | 1400px | 2K显示器适配 |
| **Desktop** | ≤1200px | 普通桌面/笔电 | 1140px | 标准桌面显示器 |
| **Tablet** | ≤992px | 大平板/小笔电 | 960px | 平板设备，字体缩小 |
| **Mobile** | ≤768px | 小平板/横屏手机 | 720px | 移动设备，字体更小 |
| **Small** | ≤576px | 小手机 | 100% | 小屏手机，字体最小 |

### 🎯 设计原则

#### 1. 容器宽度控制
```css
.container {
  max-width: 1600px;  /* 默认大屏 */
  margin: 0 auto;
  padding: 0 2rem;
}
```

#### 2. 字体大小渐进
- **大屏 (≥1400px)**: 标题 4rem，副标题 3.5rem
- **2K显示器 (≤1600px)**: 标题 3.5rem，副标题 3rem
- **桌面 (≤1200px)**: 标题 3rem，副标题 2.5rem
- **平板 (≤992px)**: 标题 2.75rem，副标题 2.25rem
- **手机 (≤768px)**: 标题 2.5rem，副标题 2rem
- **小手机 (≤576px)**: 标题 2rem，副标题 1.75rem

#### 3. 间距适配
- **大屏**: section padding 5rem
- **桌面**: section padding 4rem
- **平板**: section padding 3.5rem
- **手机**: section padding 3rem
- **小手机**: section padding 2rem

### 📐 布局变化

#### 网格布局适配
```css
/* 大屏：2列布局 */
.comprofile-section {
  grid-template-columns: 1fr 1fr;
}

/* 平板以下：单列布局 */
@media (max-width: 992px) {
  .comprofile-section {
    grid-template-columns: 1fr;
  }
}
```

#### 统计区域适配
```css
/* 大屏：水平排列 */
.stats-section {
  display: flex;
  flex-direction: row;
}

/* 平板以下：垂直排列 */
@media (max-width: 992px) {
  .stats-section {
    flex-direction: column;
  }
}
```

### 🎨 特殊适配

#### 横屏手机
```css
@media (max-height: 500px) and (orientation: landscape) {
  .home {
    min-height: 100vh;
  }
  .section {
    padding: 1rem 0;
  }
}
```

#### 高分辨率屏幕
```css
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  .culture-icon,
  .comprofile-image img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
  }
}
```

#### 可访问性支持
```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

### 🔧 使用方法

#### 1. 基础容器
```html
<div class="container">
  <!-- 内容会自动适配不同屏幕 -->
</div>
```

#### 2. 响应式图片
```html
<img src="image.jpg" alt="描述" class="responsive-image">
```

#### 3. 响应式网格
```html
<div class="responsive-grid">
  <div class="grid-item">内容1</div>
  <div class="grid-item">内容2</div>
</div>
```

### 📊 测试建议

#### 主要测试设备
1. **4K显示器** (3840×2160) - 主要用户设备
2. **2K显示器** (2560×1440) - 常见办公设备
3. **笔记本电脑** (1366×768, 1920×1080) - 便携设备
4. **iPad** (768×1024) - 平板设备
5. **iPhone** (375×667, 414×896) - 手机设备

#### 浏览器测试
- Chrome (推荐)
- Firefox
- Safari
- Edge

### 🚀 性能优化

#### 1. 图片优化
- 使用 WebP 格式
- 提供不同尺寸的图片
- 使用 `loading="lazy"` 延迟加载

#### 2. CSS优化
- 使用 CSS 变量减少重复
- 合并媒体查询
- 避免不必要的重绘

#### 3. 字体优化
- 使用 `font-display: swap`
- 预加载关键字体
- 提供字体回退方案

### 📝 维护指南

#### 添加新的响应式样式
1. 在 `responsive.css` 中添加新的媒体查询
2. 遵循 Desktop First 原则
3. 测试所有断点
4. 更新文档

#### 修改断点
1. 更新断点定义
2. 调整所有相关样式
3. 测试兼容性
4. 更新文档

### 🎯 最佳实践

1. **始终从大屏开始设计**
2. **使用相对单位** (rem, em, %)
3. **保持内容可读性**
4. **测试真实设备**
5. **考虑用户习惯**
6. **优化加载性能**

---

**更新时间**: 2024年  
**维护者**: KUNZZ HOLDINGS 开发团队
