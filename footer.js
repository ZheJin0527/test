// Footer相关JavaScript功能

// 返回顶部功能
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

// 跳转到指定slide功能（用于footer导航）
function goToSlide(slideIndex) {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(slideIndex);
  }
}

// 更具体的跳转函数
function goToCompanyProfile() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(1); // 跳转到第2个slide（公司简介）
  }
}

function goToCulture() {
  if (typeof swiper !== 'undefined') {
    swiper.slideTo(2); // 跳转到第3个slide（公司文化）
  }
}

// 返回顶部按钮的显示/隐藏逻辑
document.addEventListener('DOMContentLoaded', function() {
  const backToTopBtn = document.getElementById("backToTop");
  
  if (backToTopBtn) {
    window.addEventListener("scroll", function () {
      const scrollTop = window.scrollY;
      
      // 回到顶部按钮显示/隐藏逻辑
      if (scrollTop > 100) {
        backToTopBtn.style.display = "block";
      } else {
        backToTopBtn.style.display = "none";
      }
    });
  }
});
