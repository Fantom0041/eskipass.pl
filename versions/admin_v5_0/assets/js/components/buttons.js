/*!
 * remark v1.0.4 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("buttons", {
  mode: "api",
  defaults: {},
  api: function() {
    $(document).on('click.site.loading', '[data-loading-text]', function() {
      var $btn = $(this),
        text = $btn.text(),
        i = 20,
        loadingText = $btn.data('loadingText');

      $btn.text(loadingText + '(' + i + ')').css('opacity', '.6');

      var timeout = setInterval(function() {
        $btn.text(loadingText + '(' + (--i) + ')');
        if (i === 0) {
          clearInterval(timeout);
          $btn.text(text).css('opacity', '1');
        }
      }, 1000);
    });

    $(document).on('click.site.morebutton', '[data-more]', function() {
      var $target = $($(this).data('more'));
      $target.toggleClass('show');
    });
  }
});
