// Header - Tailwind版本 (使用group-hover，JavaScript仅处理移动端菜单)
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const languageBtn = document.getElementById('languageBtn');

    // 移动端汉堡菜单切换
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            navMenu.classList.toggle('-translate-y-full');
            navMenu.classList.toggle('translate-y-0');
            navMenu.classList.toggle('hidden');
            navMenu.classList.toggle('flex');
        });
    }

    // 语言切换更新按钮文字
    const languageItems = document.querySelectorAll('[data-lang]');
    languageItems.forEach(item => {
        item.addEventListener('click', function() {
            const selectedLang = this.getAttribute('data-lang');
            if (selectedLang === 'en') {
                languageBtn.textContent = 'English';
            } else {
                languageBtn.textContent = '中文';
            }
        });
    });

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
