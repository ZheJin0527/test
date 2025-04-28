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

    // 获取初始年份
    const firstYear = parseInt(selectors.item.eq(0).data("year")) || 2023;

    // 添加格子并设置初始为第一项年份
    if (timelineEl.find(".timeline-circle").length === 0) {
      timelineEl.append(`<div class="timeline-circle">${firstYear}</div>`);
    }

    // 添加进度条
    if (timelineEl.find(".timeline-progress").length === 0) {
      timelineEl.append('<div class="timeline-progress"></div>');
    }

    var circle = timelineEl.find(".timeline-circle");
    var progress = timelineEl.find(".timeline-progress");

    let currentYear = firstYear; // 当前显示年份

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

          // 获取当前项年份并更新格子（不加一）
          const targetYear = parseInt($(this).data("year"));
          if (!isNaN(targetYear) && targetYear !== currentYear) {
            currentYear = targetYear;
            circle.text(currentYear);
          }
        }
      });

      // 控制格子位置和进度条高度
      var timelineTop = timelineEl.offset().top;
      var timelineHeight = timelineEl.height();
      var scrollCenter = $(window).scrollTop() + windowHeight / 2;
      var circleTop = scrollCenter - timelineTop;

      if (circleTop < 0) circleTop = 0;

      const maxCircleTop = timelineHeight * 0.8;
      if (circleTop > maxCircleTop) circleTop = maxCircleTop;

      circle.css("top", circleTop + "px");
      progress.css("height", circleTop + "px");
    }

    $(window).on("scroll", updateScroll);
    updateScroll();
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


// Scroll Activated Number Counter for .stats-section
document.addEventListener("DOMContentLoaded", function () {
  const statSection = document.querySelector('.stats-section');
  const statNumbers = document.querySelectorAll('.stat-number');
  let hasAnimated = false; // 防止重复动画

  function animateCountUp(el, target, duration = 1000) {
    let startTime = null;

    function update(currentTime) {
      if (!startTime) startTime = currentTime;
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const current = Math.floor(progress * target);

      el.textContent = current.toLocaleString();

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        el.textContent = target.toLocaleString();
        if (el.getAttribute('data-target').includes('+')) {
          el.textContent += '+';
        }
      }
    }

    requestAnimationFrame(update);
  }

  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top < window.innerHeight &&
      rect.bottom > 0
    );
  }

  function handleScroll() {
    if (!hasAnimated && isInViewport(statSection)) {
      statNumbers.forEach(el => {
        const raw = el.textContent;
        const target = parseInt(raw.replace(/\D/g, '')); // 只取数字部分
        if (!isNaN(target)) {
          el.setAttribute('data-target', raw); // 保存原本带+的内容
          el.textContent = "0"; // 重置成0
          animateCountUp(el, target, 1000); // 开始动画
        }
      });
      hasAnimated = true;
    }
  }

  window.addEventListener('scroll', handleScroll);
  handleScroll(); // 预防页面一开始已经在 viewport
});



