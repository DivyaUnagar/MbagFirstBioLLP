(function ($) {
  window["cozyBlockScrollTopInit"] = (e) => {
    const n = e.replace(/-/gi, "_");
    const scrollTopClass = `#cozyBlock_${n}`;
    const cozyScrollTop = document.querySelector(scrollTopClass);

    function scrollFunction() {
      if (
        document.body.scrollTop > 10 ||
        document.documentElement.scrollTop > 10
      ) {
        cozyScrollTop.classList.add("visibility-visible");
        cozyScrollTop.classList.remove("visibility-hidden");
      } else {
        cozyScrollTop.classList.add("visibility-hidden");
        cozyScrollTop.classList.remove("visibility-visible");
      }
    }

    scrollFunction();
    window.onscroll = function () {
      scrollFunction();
    };

    cozyScrollTop.addEventListener("click", function () {
      jQuery("html, body").animate({ scrollTop: 0 }, 600);
      return false;
    });
  };
})(jQuery);
