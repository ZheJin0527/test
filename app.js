document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.nav-links a');
  
    // 从 localStorage 中获取上次点击的路径
    const savedActive = localStorage.getItem('activeLink');
  
    // 获取当前页面路径（如 "about.html"）
    let currentPath = window.location.pathname.split('/').pop() || 'index.html';
  
    // 如果 savedActive 存在并且和当前页面路径一致，就高亮对应项
    if (savedActive && savedActive === currentPath) {
      links.forEach(link => {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath) {
          link.classList.add('active');
        }
      });
    }
  
    // 监听点击事件，设置 active 样式并保存到 localStorage
    links.forEach(link => {
      link.addEventListener('click', (e) => {
        const linkPath = link.getAttribute('href');
  
        // 点击时将当前路径保存到 localStorage
        localStorage.setItem('activeLink', linkPath);
      });
    });
  });
  