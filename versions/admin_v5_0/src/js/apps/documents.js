(function(document, window, $) {
  'use strict';

  window.AppDocuments = App.extend({
    affixHandle: function() {
      $('#articleAffix').affix({
        offset: {
          top: 210
        }
      });
    },
    scrollHandle: function() {
      $('body').scrollspy({
        target: '#articleAffix'
      });
    },
    run: function(next) {
      this.scrollHandle();
      this.affixHandle();

      next();
    }
  });
})(document, window, jQuery);
