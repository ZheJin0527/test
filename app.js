
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("jobApplicationForm");

  // 检查是否是从 success.html 页面跳转回来的
  const referrer = document.referrer;
  if (referrer.includes("success.html?from=form") && form) {
    form.reset();
  }
});