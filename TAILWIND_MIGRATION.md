# Tailwind CSS 迁移说明

## 概述
本项目正在逐步从传统 CSS 迁移到 Tailwind CSS。第一步是将 header 组件迁移到 Tailwind。

## 已完成的迁移

### ✅ Header 组件 (public/header.php)
- **迁移时间**: 2025年9月30日
- **状态**: 已完成
- **设计**: 保持不变，所有视觉效果和响应式行为完全一致

#### 变更内容:
1. **CSS 文件**:
   - 替换 `header.css` → `../frontend/dist/output.css` (Tailwind)
   
2. **类名映射**:
   - `.header-navbar` → `.header-navbar-fixed`
   - `.header-logo-section` → `flex items-center`
   - `.header-logo` → `.header-logo-img`
   - `.header-nav-links` → `.header-nav-container`
   - `.header-nav-links a` → `.header-nav-link`
   - `.header-right-section` → `.header-right-container`
   - `.header-login-dropdown` → `.header-login-dropdown-wrapper`
   - `.header-login-btn` → `.header-login-button`
   - `.header-login-dropdown-menu` → `.header-login-dropdown-content`
   - `.header-login-dropdown-item` → `.header-dropdown-item`
   - `.header-language-switch` → `relative flex items-center`
   - `.header-lang` → `.header-lang-button`
   - `.header-language-dropdown-menu` → `.header-language-dropdown-content`
   - `.header-language-dropdown-item` → `.header-dropdown-item`
   - `.header-hamburger` → `.header-hamburger-btn`
   - `.header-nav-dropdown` → `relative`
   - `.header-nav-dropdown-menu` → `.header-nav-dropdown-content`
   - `.header-nav-dropdown-item` → `.header-nav-dropdown-item` (保持不变)
   - `.header-page-indicator` → `.header-page-indicator-container`

3. **JavaScript 更新**:
   - 更新选择器: `.nav-item.nav-dropdown` → `.header-nav-item.relative`

## Tailwind 配置

### 自定义颜色
```javascript
'kunzz-orange': '#FF5C00',
'kunzz-orange-hover': '#d87b00',
'kunzz-dark': '#2F2F2F',
'kunzz-border': '#444',
```

### 自定义组件类
所有 header 相关的样式都在 `frontend/src/input.css` 中的 `@layer components` 中定义，保持了原有的 clamp() 响应式设计。

## 如何编译 Tailwind CSS

### 开发模式 (实时监听)
```bash
cd frontend
npm run dev
```

### 生产模式 (压缩)
```bash
cd frontend
npm run build
```

## 待迁移组件

### 🔲 Footer
- 文件: `public/footer.php`
- CSS: `public/css/components/footer.css`

### 🔲 Social
- 文件: `public/social.php`
- CSS: `public/css/components/social.css`

### 🔲 其他页面
- Frontend 页面 (frontend/index.php, frontend/about.php, etc.)
- EN 页面 (en/index.php, en/about.php, etc.)

## 迁移原则

1. **保持设计不变**: 所有视觉效果必须与原设计完全一致
2. **响应式设计**: 保留所有 clamp() 和媒体查询
3. **渐进式迁移**: 一次迁移一个组件
4. **向后兼容**: 在完全迁移前，新旧系统可共存

## 注意事项

1. **Tailwind 配置**: 所有自定义配置在 `frontend/tailwind.config.js`
2. **构建输出**: 编译后的 CSS 在 `frontend/dist/output.css`
3. **内容扫描**: Tailwind 会扫描以下文件:
   - `../public/**/*.{php,html,js}`
   - `../frontend/*.{php,html,js}`
   - `../frontend/css/**/*.css`
   - `../en/**/*.{php,html,js}`

4. **性能优化**: 避免在 content 配置中包含 `node_modules`

## 开发建议

1. 每次修改后运行 `npm run build` 重新编译
2. 开发时可以使用 `npm run dev` 实时监听文件变化
3. 对于复杂的响应式设计，继续使用自定义组件类（在 `@layer components` 中）
4. 简单的样式可以直接使用 Tailwind 工具类
