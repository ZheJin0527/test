document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    let lastScrollTop = window.scrollY;
  
    window.addEventListener("scroll", function () {
      const scrollTop = window.scrollY;
  
      if (scrollTop > lastScrollTop) {
        navbar.classList.add("nav-hidden"); // 向下滚动隐藏
      } else {
        navbar.classList.remove("nav-hidden"); // 向上滚动显示
      }
  
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
  });

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



(function($) {
    $.fn.timeline = function() {
      var selectors = {
        id: $(this),
        item: $(this).find(".timeline-item"),
        activeClass: "timeline-item--active"
      };
  
      selectors.item.eq(0).addClass(selectors.activeClass);
  
      var itemLength = selectors.item.length;
      $(window).scroll(function() {
        var max, min;
        var pos = $(this).scrollTop();
  
        selectors.item.each(function(i) {
          min = $(this).offset().top;
          max = $(this).height() + $(this).offset().top;
  
          if (i === itemLength - 2 && pos > min + $(this).height() / 2) {
            selectors.item.removeClass(selectors.activeClass);
            selectors.item.last().addClass(selectors.activeClass);
          } else if (pos <= max - 40 && pos >= min) {
            selectors.item.removeClass(selectors.activeClass);
            $(this).addClass(selectors.activeClass);
          }
        });
      });
    };
  })(jQuery);
  
  $(document).ready(function() {
    $("#timeline-1").timeline();
  });