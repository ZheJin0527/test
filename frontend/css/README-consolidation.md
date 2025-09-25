# Frontend CSS 整合说明

## 概述
已将 `frontend` 目录下（除 `tokyo` 外）的所有 CSS 文件整合到 `frontend-main.css` 中，保持原有设计排版不变。

## 整合的文件
1. **animation.css** - 基础动画系统
2. **aboutanimation.css** - About页面动画
3. **joinusanimation.css** - Join Us页面动画
4. **responsive.css** - 响应式样式（空文件）

## 文件结构

### frontend-main.css 页面分类结构：

#### INDEX 页面样式
- 基础动画系统 (animate-on-scroll, fade-in-up)
- 滑入动画 (slide-in-left, slide-in-right)
- 缩放动画 (scale-fade-in, scale-out)
- 其他动画 (fade-in-down)
- 首页渐变效果 (home渐变覆盖层)

#### ABOUT 页面样式
- 图片3D旋转特效 (image-3d-rotate)
- Culture卡片倾斜进入特效 (card-tilt-in-left)
- 文字缩放滑入特效 (text-zoom-in-right)
- Culture内容缩放渐显特效 (culture-scale-fade)
- 360度3D旋转进场 (rotate-3d-full)

#### JOINUS 页面样式
- 导航栏动画系统 (navbar延迟淡入)
- 子元素渐进淡入效果
- 导航项目逐个淡入
- 右侧元素逐个淡入

#### 通用组件样式
- 社交侧边栏动画 (social-sidebar)
- 页面指示器动画 (page-indicator)
- 加载状态动画

#### ABOUT 页面动画
- About Banner内容动画
- Intro内容动画
- Vision内容滑下特效
- 时间线动画系统
- 标题、轨道、项目容器、圆点、导航箭头动画

#### JOINUS 页面动画
- 加入我们Banner动画
- 公司福利特效（从中心向两边展开）
- 我们的足迹标题特效
- 招聘职位标题特效
- 职位卡片瀑布式显示特效
- 联系信息进入动画

#### VALUES 页面样式
- Values卡片延迟进入特效
- Values内容缩放渐显特效

## 使用说明

### 动画类名使用：
- `.animate-on-scroll` - 基础滚动动画容器
- `.visible` - 可见状态类
- `.scale-fade-in` - 缩放淡入动画
- `.slide-in-left` / `.slide-in-right` - 左右滑入动画
- `.fade-in-up` / `.fade-in-down` - 上下淡入动画
- `.card-tilt-in-left` - 卡片倾斜进入
- `.text-zoom-in-right` - 文字缩放滑入
- `.culture-scale-fade` - Culture内容缩放
- `.values-scale-fade` - Values内容缩放

### 延迟类名：
- `.delay-1` 到 `.delay-10` - 动画延迟控制

### 加载状态类名：
- `.navbar-loaded` - 导航栏加载完成
- `.social-loaded` - 社交侧边栏加载完成
- `.indicator-loaded` - 页面指示器加载完成
- `.content-loaded` - 内容加载完成
- `.intro-loaded` - 介绍内容加载完成
- `.benefits-loaded` - 福利内容加载完成
- `.comphoto-loaded` - 公司照片加载完成
- `.job-table-loaded` - 职位表格加载完成
- `.jobs-loaded` - 职位列表加载完成
- `.contact-loaded` - 联系信息加载完成
- `.timeline-active` - 时间线激活状态

## 注意事项

1. **保持原有设计**：所有动画效果都保持原有的设计排版，没有改变任何视觉效果
2. **性能优化**：使用 `transform` 和 `opacity` 进行动画，确保性能
3. **响应式兼容**：所有动画都兼容现有的响应式断点系统
4. **JavaScript依赖**：部分动画需要JavaScript添加相应的加载状态类名来触发

## 文件大小
- 整合前：多个分散的CSS文件
- 整合后：单个 `frontend-main.css` 文件，约1100行代码
- 优势：减少HTTP请求，便于维护，统一管理

## 维护建议
1. 新增动画时，请按照现有分类结构添加到相应区域
2. 修改动画时，请保持注释清晰，便于定位
3. 删除动画时，请确保没有其他地方引用相关类名
4. 定期检查动画性能，避免过度使用复杂动画
