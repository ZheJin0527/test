/** @type {import('tailwindcss').Config} */
module.exports = {
  // 1. 按需扫描：只生成实际用到的class
  content: [
    // 扫描所有PHP文件（包括子目录）
    "../public/**/*.{php,html,js}",
    "../frontend/**/*.{php,html,js}",
    "../en/**/*.{php,html,js}",
    
    // 如果有其他目录，也可以添加
    "../*.{php,html}",
    
    // 注意：避免扫描node_modules，会严重影响性能
  ],

  // 2. 主题配置：自定义颜色、字体、间距等
  theme: {
    extend: {
      // ========== 自定义颜色 ==========
      colors: {
        // 品牌主色
        'kunzz-orange': '#FF5C00',
        'kunzz-orange-hover': '#d87b00',
        'kunzz-orange-light': '#f7931e',
        'kunzz-dark': '#2F2F2F',
        'kunzz-border': '#444',
        'kunzz-bg-light': '#f5f5f5',
      },

      // ========== 自定义字体 ==========
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
        'source': ['Source Sans Pro', 'sans-serif'],
        'noto': ['Noto Sans SC', 'sans-serif'],
      },

      // ========== 响应式字体大小（支持clamp） ==========
      fontSize: {
        // 使用clamp实现自动缩放
        'responsive-xs': 'clamp(0.75rem, 2vw, 0.875rem)',
        'responsive-sm': 'clamp(0.875rem, 2.5vw, 1rem)',
        'responsive-base': 'clamp(1rem, 3vw, 1.125rem)',
        'responsive-lg': 'clamp(1.125rem, 3.5vw, 1.5rem)',
        'responsive-xl': 'clamp(1.5rem, 4vw, 2rem)',
        'responsive-2xl': 'clamp(2rem, 5vw, 3rem)',
        'responsive-3xl': 'clamp(2.5rem, 6vw, 4rem)',
      },

      // ========== 自定义间距（支持clamp和vw） ==========
      spacing: {
        // 使用clamp的响应式间距
        'responsive-xs': 'clamp(0.25rem, 1vw, 0.5rem)',
        'responsive-sm': 'clamp(0.5rem, 2vw, 1rem)',
        'responsive-md': 'clamp(1rem, 3vw, 1.5rem)',
        'responsive-lg': 'clamp(1.5rem, 4vw, 2rem)',
        'responsive-xl': 'clamp(2rem, 5vw, 3rem)',
        'responsive-2xl': 'clamp(3rem, 8vw, 5rem)',
        
        // 基于视口的间距
        '5vw': '5vw',
        '10vw': '10vw',
        '15vw': '15vw',
        '20vw': '20vw',
      },

      // ========== 自定义宽度/高度 ==========
      width: {
        'responsive': 'clamp(20rem, 50vw, 60rem)',
      },
      height: {
        'header': 'clamp(3.5rem, 8vh, 5rem)',
        'hero': 'clamp(30rem, 80vh, 50rem)',
      },

      // ========== 自定义圆角 ==========
      borderRadius: {
        'button': 'clamp(1.25rem, 2.5vw, 1.875rem)',
      },

      // ========== 自定义阴影 ==========
      boxShadow: {
        'soft': '0 2px 15px rgba(0, 0, 0, 0.1)',
        'medium': '0 4px 25px rgba(0, 0, 0, 0.15)',
        'strong': '0 8px 40px rgba(0, 0, 0, 0.2)',
      },

      // ========== 动画 ==========
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.5s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },

      // ========== 容器配置 ==========
      container: {
        center: true,
        padding: {
          DEFAULT: '1rem',
          sm: '2rem',
          lg: '4rem',
          xl: '5rem',
          '2xl': '6rem',
        },
      },
    },
  },

  // 3. 插件
  plugins: [
    // 如果需要表单样式，可以添加：
    // require('@tailwindcss/forms'),
    // require('@tailwindcss/typography'),
  ],

  // 4. 重要选项
  important: false, // 保持false，避免样式优先级问题
  
  // 5. 开发体验优化
  corePlugins: {
    // 禁用不需要的功能以减小CSS体积
    // preflight: true, // 保持Tailwind的基础样式重置
  },
}