# KUNZZ HOLDINGS - 分散式响应式设计管理

## 📋 设计原则

本项目采用 **分散式响应式设计方案**，将响应式规则分散到不同的CSS文件中，便于维护和管理。

## 📁 文件分工

### 1. frontend-main.css
**职责：页面/组件特定的样式和响应式规则**

#### ✅ 应该包含：
- 页面基础样式（默认桌面优先）
- 页面/组件特定的响应式规则
- 组件在不同断点的布局变化

#### ❌ 不应该包含：
- 全局容器样式
- 全局字体缩放
- 全局排版调整

#### 示例：
```css
/* 首页样式 - 默认桌面优先 */
.home-content h1 {
  font-size: 4rem;
  font-weight: 700;
}

/* 首页特定响应式规则 */
@media (max-width: 1600px) {
  .home-content h1 {
    font-size: 3.5rem;
  }
}

@media (max-width: 1200px) {
  .home-content h1 {
    font-size: 3rem;
  }
}
```

### 2. responsive.css
**职责：全局通用的响应式规则**

#### ✅ 应该包含：
- 容器宽度控制 (`.container`)
- 全局字体缩放 (`body`, `h1-h6`)
- 全局排版调整 (`.section` padding)
- 通用工具类响应式

#### ❌ 不应该包含：
- 页面特定的组件样式
- 组件特定的布局变化
- 页面特有的响应式规则

#### 示例：
```css
/* 全局容器样式 */
.container {
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 2rem;
}

/* 全局字体样式 */
h1 { font-size: 3.5rem; line-height: 1.2; }
h2 { font-size: 3rem; line-height: 1.2; }

/* 全局响应式 */
@media (max-width: 1600px) {
  .container {
    max-width: 1400px;
    padding: 0 1.5rem;
  }
  
  h1 { font-size: 3rem; }
  h2 { font-size: 2.5rem; }
}
```

## 🎯 断点设计 (Desktop First)

| 断点 | 屏幕尺寸 | 目标设备 | 容器宽度 | 字体缩放 |
|------|----------|----------|----------|----------|
| **默认** | ≥1400px | 4K/2K大屏 | 1600px | 100% |
| **Large** | ≤1600px | 普通2K显示器 | 1400px | 90% |
| **Desktop** | ≤1200px | 普通桌面/笔电 | 1140px | 80% |
| **Tablet** | ≤992px | 大平板/小笔电 | 960px | 70% |
| **Mobile** | ≤768px | 小平板/横屏手机 | 720px | 60% |
| **Small** | ≤576px | 小手机 | 100% | 50% |

## 📝 编码规范

### 1. 默认样式
```css
/* ✅ 正确：在 main.css 中写默认样式，不用断点 */
.component {
  font-size: 2rem;
  padding: 2rem;
  display: grid;
  grid-template-columns: 1fr 1fr;
}
```

### 2. 局部响应式
```css
/* ✅ 正确：在 main.css 中写组件特定的响应式 */
@media (max-width: 992px) {
  .component {
    grid-template-columns: 1fr;
    padding: 1.5rem;
  }
}
```

### 3. 全局响应式
```css
/* ✅ 正确：在 responsive.css 中写全局响应式 */
@media (max-width: 1200px) {
  .container {
    max-width: 1140px;
  }
  
  h1 { font-size: 2.5rem; }
}
```

## 🔧 维护指南

### 添加新页面样式
1. 在 `frontend-main.css` 中添加页面基础样式
2. 在同一个文件中添加页面特定的响应式规则
3. 确保不包含全局规则

### 修改全局响应式
1. 在 `responsive.css` 中修改全局规则
2. 确保不影响页面特定样式
3. 测试所有断点

### 添加新断点
1. 在 `responsive.css` 中添加全局断点
2. 在 `frontend-main.css` 中添加页面特定断点
3. 更新文档

## 📊 文件结构示例

```
frontend/css/
├── frontend-main.css          # 页面样式 + 页面特定响应式
├── responsive.css             # 全局响应式规则
├── animation.css              # 动画样式
├── demo.css                   # 演示页面样式
└── README-distributed-responsive.md  # 本文档
```

## 🎨 样式优先级

1. **全局基础样式** (responsive.css 默认)
2. **页面基础样式** (frontend-main.css 默认)
3. **全局响应式** (responsive.css 媒体查询)
4. **页面响应式** (frontend-main.css 媒体查询)

## ⚠️ 注意事项

### 避免重复
- 不要在 `responsive.css` 中写页面特定样式
- 不要在 `frontend-main.css` 中写全局容器样式

### 保持一致性
- 使用相同的断点值
- 使用相同的命名规范
- 使用相同的注释格式

### 测试要求
- 测试所有断点
- 测试页面特定样式
- 测试全局样式影响

## 🚀 最佳实践

1. **先写默认样式，再写响应式**
2. **页面样式写在 main.css，全局样式写在 responsive.css**
3. **使用 CSS 变量保持一致性**
4. **添加详细注释说明用途**
5. **定期检查文件分工是否合理**

---

