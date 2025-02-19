/*!
 * remark v1.0.4 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("taskList", {
  mode: "api",
  api: function() {
    $(document).on('change.site.task', '[data-role="task"]', function() {
      var $list = $(this),
        $checkbox = $list.find('[type="checkbox"]');
      if ($checkbox.is(':checked')) {
        $list.addClass('task-done');
      } else {
        $list.removeClass('task-done');
      }
    });

    $('[data-role="task"]').trigger('change.site.task');
  }
});
