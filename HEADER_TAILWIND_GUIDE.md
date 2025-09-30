# Header Tailwind 迁移指南

## ✅ 迁移完成

Header组件已成功从传统CSS迁移到Tailwind CSS，所有设计和功能保持不变。

## 📁 修改的文件

### 1. **配置文件**
- ✅ `frontend/tailwind.config.js` - 创建了Tailwind配置，添加了自定义颜色和样式
- ✅ `frontend/src/input.css` - 添加了所有header自定义组件类

### 2. **Header文件**
- ✅ `public/header.php` - 更新了HTML结构，使用Tailwind类
- ✅ `public/header.js` - 更新了JavaScript选择器以匹配新类名

### 3. **编译输出**
- ✅ `frontend/dist/output.css` - 编译后的Tailwind CSS文件

## 🎨 自定义颜色

```css
kunzz-orange: #FF5C00
kunzz-orange-hover: #d87b00
kunzz-dark: #2F2F2F
kunzz-border: #444
```

## 🔧 如何使用

### 开发模式（实时编译）
```bash
cd frontend
npm run dev
```

### 生产模式（压缩输出）
```bash
cd frontend
npm run build
```

## 📝 主要Tailwind类名

### Header容器
- `header-navbar-fixed` - 固定定位的导航栏

### 导航
- `header-nav-container` - 导航容器
- `header-nav-link` - 导航链接
- `header-nav-dropdown-trigger` - 下拉菜单触发器
- `header-nav-dropdown-content` - 下拉菜单内容

### 按钮
- `header-login-button` - 登录按钮
- `header-lang-button` - 语言切换按钮

### 下拉菜单
- `header-login-dropdown-wrapper` - 登录下拉包装器
- `header-login-dropdown-content` - 登录下拉内容
- `header-language-dropdown-content` - 语言下拉内容
- `header-dropdown-item` - 下拉菜单项

### 其他
- `header-logo-img` - Logo图片
- `header-hamburger-btn` - 移动端汉堡菜单
- `header-page-indicator-container` - 页面指示器容器
- `header-page-dot` - 页面指示点

## 🔄 响应式设计

所有响应式设计都使用`clamp()`函数保留，确保在不同屏幕尺寸下的完美显示：

- 移动端 (≤768px): 汉堡菜单、垂直导航
- 桌面端 (>768px): 水平导航、下拉菜单

## ⚠️ 重要提示

1. **修改后必须重新编译**: 每次修改`input.css`或`tailwind.config.js`后，运行`npm run build`
2. **引用路径**: Header引用的是`../frontend/dist/output.css`
3. **JavaScript兼容**: 所有JavaScript功能保持不变
4. **旧CSS文件**: `public/css/components/header.css`现在可以移除（建议先备份）

## 🚀 下一步

可以开始迁移其他组件：
- Footer (`public/footer.php`)
- Social (`public/social.php`)
- 其他页面组件

## 📖 参考

迁移过程的完整说明请查看：`TAILWIND_MIGRATION.md`
