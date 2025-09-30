// Header - Tailwind版本
document.addEventListener('DOMContentLoaded', function() {
    // Login dropdown hover
    const loginDropdown = document.querySelector('.login-dropdown');
    const loginMenu = document.querySelector('.login-menu');
    
    if (loginDropdown && loginMenu) {
        loginDropdown.addEventListener('mouseenter', () => {
            loginMenu.classList.remove('opacity-0', 'invisible');
            loginMenu.classList.add('opacity-100', 'visible');
        });
        
        loginDropdown.addEventListener('mouseleave', () => {
            loginMenu.classList.add('opacity-0', 'invisible');
            loginMenu.classList.remove('opacity-100', 'visible');
        });
    }

    // Language dropdown hover
    const languageDropdown = document.querySelector('.language-dropdown');
    const languageMenu = document.querySelector('.language-menu');
    
    if (languageDropdown && languageMenu) {
        languageDropdown.addEventListener('mouseenter', () => {
            languageMenu.classList.remove('opacity-0', 'invisible');
            languageMenu.classList.add('opacity-100', 'visible');
        });
        
        languageDropdown.addEventListener('mouseleave', () => {
            languageMenu.classList.add('opacity-0', 'invisible');
            languageMenu.classList.remove('opacity-100', 'visible');
        });
    }

    // Language switch
    const languageText = document.querySelector('.language-text');
    const languageOptions = document.querySelectorAll('.language-option');
    const mobileLangOptions = document.querySelectorAll('.mobile-lang-option');
    
    languageOptions.forEach(option => {
        option.addEventListener('click', () => {
            const lang = option.getAttribute('data-lang');
            if (languageText) {
                languageText.textContent = lang;
            }
            localStorage.setItem('language', lang);
        });
    });

    mobileLangOptions.forEach(option => {
        option.addEventListener('click', () => {
            const lang = option.getAttribute('data-lang');
            if (languageText) {
                languageText.textContent = lang;
            }
            localStorage.setItem('language', lang);
        });
    });

    // Load saved language
    const savedLang = localStorage.getItem('language');
    if (savedLang && languageText) {
        languageText.textContent = savedLang;
    }

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 页面指示器点击处理（如果存在）
    const pageDots = document.querySelectorAll('[data-slide]');
    pageDots.forEach(dot => {
        dot.addEventListener('click', function() {
            const slideIndex = this.getAttribute('data-slide');
            // 移除所有active类
            pageDots.forEach(d => d.classList.remove('active', '!h-10', '!rounded-md'));
            // 添加active到当前点击的
            this.classList.add('active', '!h-10', '!rounded-md');
            
            // 触发轮播切换事件（如果有轮播的话）
            const event = new CustomEvent('slideChange', { detail: { index: slideIndex } });
            document.dispatchEvent(event);
        });
    });
});

