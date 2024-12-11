<!-- Core  -->
<script src="{{$themedir}}assets/vendor/jquery/jquery.js"></script>
<script src="{{$themedir}}assets/vendor/bootstrap/bootstrap.js"></script>
<script src="{{$themedir}}assets/vendor/animsition/jquery.animsition.js"></script>
<script src="{{$themedir}}assets/vendor/asscroll/jquery-asScroll.js"></script>
<script src="{{$themedir}}assets/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="{{$themedir}}assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="{{$themedir}}assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="{{$themedir}}assets/vendor/switchery/switchery.min.js"></script>
<script src="{{$themedir}}assets/vendor/intro-js/intro.js"></script>
<script src="{{$themedir}}assets/vendor/screenfull/screenfull.js"></script>
<script src="{{$themedir}}assets/vendor/slidepanel/jquery-slidePanel.js"></script>

<!-- Plugins For This Page -->
<script src="{{$themedir}}assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Scripts -->
<script src="{{$themedir}}assets/js/core.js"></script>
<script src="{{$themedir}}assets/js/site.js"></script>

<script src="{{$themedir}}assets/js/sections/menu.js"></script>
<script src="{{$themedir}}assets/js/sections/menubar.js"></script>
<script src="{{$themedir}}assets/js/sections/sidebar.js"></script>

<script src="{{$themedir}}assets/js/configs/config-colors.js"></script>
<script src="{{$themedir}}assets/js/configs/config-tour.js"></script>

<script src="{{$themedir}}assets/js/components/asscrollable.js"></script>
<script src="{{$themedir}}assets/js/components/animsition.js"></script>
<script src="{{$themedir}}assets/js/components/slidepanel.js"></script>
<script src="{{$themedir}}assets/js/components/switchery.js"></script>

<!-- Scripts For This Page -->
<script src="{{$themedir}}assets/js/components/jquery-placeholder.js"></script>

<script>
  (function(document, window, $) {
    'use strict';

    var Site = window.Site;
    $(document).ready(function() {
      Site.run();
    });
  })(document, window, jQuery);
</script>

<script>
//obsługa komunikatów z systemu
// $(document).ready(function(){
//   {{if $err}}
//     noty({text: '{{section name=id loop=$err}}{{$err[id]}}<br />{{/section}}', type: 'error'});
//   {{/if}}
//   {{if $update}}
//     noty({text: 'Rekord zmodyfikowany.', type: 'success'});
//   {{/if}}
//   {{if $create}}
//     noty({text: 'Rekord dodany.', type: 'success'});
//   {{/if}}
//   {{if $delete}}
//     noty({text: 'Rekord usunięty.', type: 'success'});
//   {{/if}}
// });
</script>