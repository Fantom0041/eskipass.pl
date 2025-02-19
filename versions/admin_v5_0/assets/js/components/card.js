/*!
 * remark v1.0.4 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("card", {
  mode: "init",
  defaults: {

  },
  init: function(context) {
    if (!$.fn.card) return;
    var defaults = $.components.getDefaults("card");

    $('[data-plugin="card"]', context).each(function() {
      var options = $.extend({}, defaults, $(this).data());

      if (options.target) {
        options.container = $(options.target);
      }
      $(this).card(options);
    });
  }
});
