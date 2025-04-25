document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.querySelector(".navbar");
  let lastScrollTop = window.scrollY;

  const backToTopBtn = document.getElementById("backToTop"); // 回到顶部按钮

  window.addEventListener("scroll", function () {
      const scrollTop = window.scrollY;

      // 导航栏隐藏/显示逻辑
      if (scrollTop > lastScrollTop) {
          navbar.classList.add("nav-hidden"); // 向下滚动隐藏
      } else {
          navbar.classList.remove("nav-hidden"); // 向上滚动显示
      }

      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;

      // 回到顶部按钮显示/隐藏逻辑
      if (scrollTop > 100) {
          backToTopBtn.style.display = "block";
      } else {
          backToTopBtn.style.display = "none";
      }
  });

  // 导航链接点击高亮逻辑
  const links = document.querySelectorAll('.nav-links a');
  links.forEach(link => {
      link.addEventListener('click', (e) => {
          links.forEach(l => l.classList.remove('active'));
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

    const timelineEl = selectors.id.find(".timeline");

    // 添加圆圈
    if (timelineEl.find(".timeline-circle").length === 0) {
      timelineEl.append('<div class="timeline-circle"></div>');
    }

    // 添加进度条
    if (timelineEl.find(".timeline-progress").length === 0) {
      timelineEl.append('<div class="timeline-progress"></div>');
    }

    var circle = timelineEl.find(".timeline-circle");
    var progress = timelineEl.find(".timeline-progress");

    function updateScroll() {
      var pos = $(window).scrollTop();
      var windowHeight = $(window).height();
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

      var timelineTop = timelineEl.offset().top;
      var timelineHeight = timelineEl.height();
      var scrollCenter = $(window).scrollTop() + windowHeight / 2;
      var circleTop = scrollCenter - timelineTop;

      if (circleTop < 0) circleTop = 0;

      // ✅ 限制圆圈在 timeline 的 80% 以内
      const maxCircleTop = timelineHeight * 0.8;
      if (circleTop > maxCircleTop) circleTop = maxCircleTop;

      circle.css("top", circleTop + "px");
      progress.css("height", circleTop + "px");
    }

    $(window).on("scroll", updateScroll);
    updateScroll(); // 页面加载时也执行一次
  };
})(jQuery);

$(document).ready(function() {
  $("#timeline-1").timeline();
});

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}