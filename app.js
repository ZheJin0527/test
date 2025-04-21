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

  // 创建圆圈元素（只创建一次）
  if (selectors.id.find(".timeline-circle").length === 0) {
    selectors.id.find(".timeline").append('<div class="timeline-circle"></div>');
  }

  var circle = selectors.id.find(".timeline-circle");

  $(window).on("scroll", function() {
    var pos = $(this).scrollTop();
    var windowHeight = $(this).height();
    var windowMiddle = pos + windowHeight / 2;

    selectors.item.each(function() {
      var itemOffset = $(this).offset().top;
      var itemHeight = $(this).outerHeight();
      var itemMiddle = itemOffset + itemHeight / 2;

      if (Math.abs(itemMiddle - windowMiddle) < itemHeight / 2) {
        selectors.item.removeClass(selectors.activeClass);
        $(this).addClass(selectors.activeClass);
      }
    });

    // 🔶 让圆圈跟随 scroll 滑动，限制在时间轴内部
    var timelineTop = selectors.id.find(".timeline").offset().top;
    var timelineHeight = selectors.id.find(".timeline").height();
    var scrollCenter = $(window).scrollTop() + windowHeight / 2;
    var circleTop = scrollCenter - timelineTop;

    if (circleTop < 0) circleTop = 0;
    if (circleTop > timelineHeight) circleTop = timelineHeight;

    circle.css("top", circleTop + "px");
  });
};
})(jQuery);

$(document).ready(function() {
$("#timeline-1").timeline();
});

