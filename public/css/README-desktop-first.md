# KunzzWeb Desktop First 响应式设计指南

## 概述

本文档介绍 KunzzWeb 项目的 Desktop First 响应式断点体系，专为办公环境设计，主要用户使用电脑，分辨率从4K到小屏都有覆盖。

## 设计理念

- **Desktop First**: 以桌面端为基准，逐步适配小屏设备
- **办公环境优化**: 主要用户使用电脑，分辨率从4K到小屏
- **渐进式适配**: 从大屏到小屏，逐步优化用户体验

## 断点体系

### 标准断点 (Desktop First)

| 断点名称 | 像素值 | 设备类型 | 说明 |
|---------|--------|----------|------|
| **默认** | ≥1400px | 4K/2K显示器 | 您的3840×2160显示器 |
| `2k-down` | ≤1600px | 普通2K显示器 | 2560×1440等 |
| `desktop-down` | ≤1200px | 普通桌面/笔电 | 1920×1080等 |
| `tablet-down` | ≤992px | 大平板/小笔电 | iPad Pro等 |
| `mobile-lg-down` | ≤768px | 小平板/横屏手机 | iPad Mini等 |
| `mobile-down` | ≤576px | 小手机 | iPhone SE等 |

### 高度断点

| 断点名称 | 像素值 | 说明 |
|---------|--------|------|
| `height-short` | ≤600px | 短屏设备 |
| `height-medium` | ≤720px | 中等高度 |
| `height-tall` | ≥800px | 高屏设备 |

## 文件结构

```
public/css/
├── variables.css              # 断点变量定义
├── breakpoints.css           # 响应式工具类
├── global.css               # 全局样式
├── example-desktop-first.css # 使用示例
└── README-desktop-first.md   # 本文档
```

## 使用方法

### 1. 基本媒体查询 (Desktop First)

```css
/* 基础样式（默认4K/2K） */
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}

/* 2K显示器适配 */
@media screen and (max-width: 1600px) {
  .container {
    max-width: 1200px;
    padding: 0 1.5rem;
  }
}

/* 普通桌面适配 */
@media screen and (max-width: 1200px) {
  .container {
    max-width: 1000px;
    padding: 0 1.25rem;
  }
}

/* 平板适配 */
@media screen and (max-width: 992px) {
  .container {
    max-width: 100%;
    padding: 0 1rem;
  }
}

/* 手机适配 */
@media screen and (max-width: 768px) {
  .container {
    padding: 0 0.75rem;
  }
}

/* 小手机适配 */
@media screen and (max-width: 576px) {
  .container {
    padding: 0 0.5rem;
  }
}
```

### 2. 使用CSS变量

```css
/* 引入变量文件 */
@import url('./variables.css');

/* 使用断点变量 */
@media screen and (var(--media-2k-down)) {
  .container {
    max-width: 1200px;
  }
}

@media screen and (var(--media-desktop-down)) {
  .container {
    max-width: 1000px;
  }
}
```

### 3. 使用工具类

```css
/* 在HTML中直接使用工具类 */
<div class="desktop-4k-only">仅在4K/2K显示</div>
<div class="desktop-2k-only">仅在2K显示</div>
<div class="desktop-only">仅在桌面端显示</div>
<div class="tablet-only">仅在平板显示</div>
<div class="mobile-only">仅在手机显示</div>
```

## 最佳实践

### 1. Desktop First 设计流程

```css
/* 1. 先写默认样式（4K/2K） */
.card {
  padding: 2rem;
  margin: 1.5rem 0;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* 2. 逐步适配小屏 */
@media screen and (max-width: 1600px) {
  .card {
    padding: 1.75rem;
    margin: 1.25rem 0;
  }
}

@media screen and (max-width: 1200px) {
  .card {
    padding: 1.5rem;
    margin: 1rem 0;
    border-radius: 8px;
  }
}

@media screen and (max-width: 992px) {
  .card {
    padding: 1.25rem;
    margin: 0.75rem 0;
    border-radius: 6px;
  }
}

@media screen and (max-width: 768px) {
  .card {
    padding: 1rem;
    margin: 0.5rem 0;
    border-radius: 4px;
  }
}
```

### 2. 响应式网格系统

```css
/* 默认网格（4K/2K） */
.grid {
  display: grid;
  gap: 2rem;
  grid-template-columns: repeat(4, 1fr);
}

/* 2K显示器网格 */
@media screen and (max-width: 1600px) {
  .grid {
    gap: 1.5rem;
    grid-template-columns: repeat(4, 1fr);
  }
}

/* 普通桌面网格 */
@media screen and (max-width: 1200px) {
  .grid {
    gap: 1.25rem;
    grid-template-columns: repeat(3, 1fr);
  }
}

/* 平板网格 */
@media screen and (max-width: 992px) {
  .grid {
    gap: 1rem;
    grid-template-columns: repeat(2, 1fr);
  }
}

/* 手机网格 */
@media screen and (max-width: 768px) {
  .grid {
    gap: 0.75rem;
    grid-template-columns: 1fr;
  }
}
```

### 3. 响应式文字大小

```css
/* 默认文字（4K/2K） */
.heading {
  font-size: 3rem;
  line-height: 1.2;
  margin-bottom: 1.5rem;
}

/* 2K显示器文字 */
@media screen and (max-width: 1600px) {
  .heading {
    font-size: 2.75rem;
    margin-bottom: 1.25rem;
  }
}

/* 普通桌面文字 */
@media screen and (max-width: 1200px) {
  .heading {
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }
}

/* 平板文字 */
@media screen and (max-width: 992px) {
  .heading {
    font-size: 2.25rem;
    margin-bottom: 0.875rem;
  }
}

/* 手机文字 */
@media screen and (max-width: 768px) {
  .heading {
    font-size: 2rem;
    margin-bottom: 0.75rem;
  }
}
```

## 常见模式

### 1. 响应式导航

```css
/* 默认导航（4K/2K） */
.navbar {
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar-nav {
  display: flex;
  gap: 2rem;
}

/* 2K显示器导航 */
@media screen and (max-width: 1600px) {
  .navbar {
    padding: 1.25rem 1.5rem;
  }
  
  .navbar-nav {
    gap: 1.5rem;
  }
}

/* 普通桌面导航 */
@media screen and (max-width: 1200px) {
  .navbar {
    padding: 1rem 1.25rem;
  }
  
  .navbar-nav {
    gap: 1.25rem;
  }
}

/* 平板导航 */
@media screen and (max-width: 992px) {
  .navbar {
    padding: 0.75rem 1rem;
  }
  
  .navbar-nav {
    gap: 1rem;
  }
}

/* 手机导航 - 汉堡菜单 */
@media screen and (max-width: 768px) {
  .navbar {
    padding: 0.5rem 0.75rem;
  }
  
  .navbar-nav {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #333;
    padding: 1rem;
  }
  
  .navbar-nav.active {
    display: flex;
  }
  
  .hamburger {
    display: block;
  }
}
```

### 2. 响应式按钮

```css
/* 默认按钮（4K/2K） */
.btn {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
}

/* 2K显示器按钮 */
@media screen and (max-width: 1600px) {
  .btn {
    padding: 0.625rem 1.25rem;
    font-size: 0.95rem;
  }
}

/* 普通桌面按钮 */
@media screen and (max-width: 1200px) {
  .btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
  }
}

/* 平板按钮 */
@media screen and (max-width: 992px) {
  .btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
  }
}

/* 手机按钮 */
@media screen and (max-width: 768px) {
  .btn {
    width: 100%;
    padding: 0.5rem;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
  }
}
```

## 调试技巧

### 1. 使用浏览器开发者工具

- 使用设备模拟器测试不同断点
- 检查媒体查询是否生效
- 验证响应式布局

### 2. 添加调试样式

```css
/* 调试用：显示当前断点 */
body::before {
  content: "4K/2K";
  position: fixed;
  top: 0;
  left: 0;
  background: green;
  color: white;
  padding: 0.25rem;
  z-index: 9999;
}

@media screen and (max-width: 1600px) {
  body::before {
    content: "2K";
    background: blue;
  }
}

@media screen and (max-width: 1200px) {
  body::before {
    content: "Desktop";
    background: orange;
  }
}

@media screen and (max-width: 992px) {
  body::before {
    content: "Tablet";
    background: purple;
  }
}

@media screen and (max-width: 768px) {
  body::before {
    content: "Mobile";
    background: red;
  }
}
```

## 性能优化

### 1. 避免不必要的媒体查询

```css
/* 好的做法：合并相关样式 */
@media screen and (max-width: 768px) {
  .mobile-only {
    display: block;
    padding: 1rem;
    margin: 0.5rem 0;
    font-size: 0.875rem;
  }
}

/* 避免：分散的媒体查询 */
.mobile-only {
  display: block;
}

@media screen and (max-width: 768px) {
  .mobile-only {
    padding: 1rem;
  }
}

@media screen and (max-width: 768px) {
  .mobile-only {
    margin: 0.5rem 0;
  }
}
```

### 2. 使用CSS变量

```css
:root {
  --desktop-padding: 2rem;
  --tablet-padding: 1.5rem;
  --mobile-padding: 1rem;
}

.container {
  padding: var(--desktop-padding);
}

@media screen and (max-width: 992px) {
  .container {
    padding: var(--tablet-padding);
  }
}

@media screen and (max-width: 768px) {
  .container {
    padding: var(--mobile-padding);
  }
}
```

## 兼容性

- 支持所有现代浏览器
- IE11+ 支持CSS自定义属性
- Desktop First 设计原则
- 适合办公环境使用
- 优化4K/2K显示器体验

## 更新日志

- **v1.0.0** - 初始版本，建立Desktop First断点体系
- 支持4K/2K到小手机的完整断点覆盖
- 提供CSS变量和工具类
- 包含使用示例和最佳实践
- 专为办公环境优化
