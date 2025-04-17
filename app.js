document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.nav-links a');

    // 监听点击事件，设置 active 样式（不再使用 localStorage）
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            // 点击时移除所有链接的高亮
            links.forEach(l => l.classList.remove('active'));
            // 当前点击的链接添加高亮
            e.currentTarget.classList.add('active');
        });
    });
});
