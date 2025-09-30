/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "../public/**/*.{php,html,js}",
    "../frontend/*.{php,html,js}",
    "../frontend/css/**/*.css",
    "../en/**/*.{php,html,js}",
  ],
  theme: {
    extend: {
      colors: {
        'kunzz-orange': '#FF5C00',
        'kunzz-orange-hover': '#d87b00',
        'kunzz-dark': '#2F2F2F',
        'kunzz-border': '#444',
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
        'source': ['Source Sans Pro', 'sans-serif'],
        'noto': ['Noto Sans SC', 'sans-serif'],
      },
      backdropBlur: {
        'custom': 'clamp(0.6rem, 1.2vw, 0.8rem)',
      },
      fontSize: {
        'header-nav': 'clamp(0.75rem, 0.8vw + 0.3rem, 1rem)',
        'header-btn': 'clamp(0.75rem, 0.7vw + 0.5rem, 1rem)',
        'header-dropdown': 'clamp(0.75rem, 1vw, 0.875rem)',
        'header-company': 'clamp(0.625rem, 1.2vw, 0.8125rem)',
      },
      height: {
        'header': 'clamp(3rem, 8vh, 5rem)',
        'header-logo': 'clamp(2rem, 4vw, 3.25rem)',
      },
      width: {
        'header-right': 'clamp(12rem, 20vw, 13.8125rem)',
      },
      spacing: {
        'header-px': 'clamp(3rem, 8vw, 5rem)',
        'header-pl': 'clamp(2.5rem, 7vw, 4.375rem)',
        'header-gap': 'clamp(1.25rem, 3vw, 1.875rem)',
        'header-ml': 'clamp(1.5rem, 4vw, 2.25rem)',
      },
      borderRadius: {
        'header-btn': 'clamp(1.25rem, 2.5vw, 1.625rem)',
        'header-dropdown': 'clamp(0.4rem, 0.8vw, 0.6rem)',
        'header-indicator': 'clamp(1.25rem, 2.5vw, 1.75rem)',
      },
      borderWidth: {
        'header': 'clamp(0.05rem, 0.1vw, 0.08rem)',
      },
    },
  },
  plugins: [],
}
