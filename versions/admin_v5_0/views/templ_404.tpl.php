<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>404 | {{$siteName}}</title>

  <link rel="apple-touch-icon" href="{{$settings_dir}}assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="{{$settings_dir}}assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{$settings_dir}}assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/css/site.min.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/vendor/flag-icon-css/flag-icon.css">

  <!-- Page -->
  <link rel="stylesheet" href="{{$settings_dir}}assets/css/pages/errors.css">

  <!-- Fonts -->
  <link rel="stylesheet" href="{{$settings_dir}}assets/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="{{$settings_dir}}assets/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700'>

  <!--[if lt IE 9]>
    <script src="{{$settings_dir}}assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="{{$settings_dir}}assets/vendor/media-match/media.match.min.js"></script>
    <script src="{{$settings_dir}}assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

  <!-- Scripts -->
  <script src="{{$settings_dir}}assets/vendor/modernizr/modernizr.js"></script>
  <script src="{{$settings_dir}}assets/vendor/breakpoints/breakpoints.js"></script>
  <script>
    Breakpoints();
  </script>
</head>
<body class="page-error page-error-404 layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <header>
        <h1 class="animation-slide-top">404</h1>
        <p>Strona nie znaleziona!</p>
      </header>
      <p class="error-advise">ZGUBIŁEŚ SIĘ? ZNAJDŹ DROGĘ DO DOMU</p>
      <a class="btn btn-primary btn-round" href="{{$siteUrl}}">IDŹ DO STRONY GŁÓWNEJ</a>

      <footer class="page-copyright page-copyright-inverse">
        <p>by <a href="http://www.2inspired.eu/">2inspired</a></p>
        <p>© 2015. Wszystkie prawa zastrzeżone.</p>
        <div class="social">
          <a href="https://twitter.com/#!/2inspiredeu">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a href="http://www.facebook.com/2inspired.eu">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
        </div>
      </footer>
    </div>
  </div>
  <!-- End Page -->


  <!-- Core  -->
  <script src="{{$settings_dir}}assets/vendor/jquery/jquery.js"></script>
  <script src="{{$settings_dir}}assets/vendor/bootstrap/bootstrap.js"></script>
  <script src="{{$settings_dir}}assets/vendor/animsition/jquery.animsition.js"></script>
  <script src="{{$settings_dir}}assets/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="{{$settings_dir}}assets/vendor/mousewheel/jquery.mousewheel.js"></script>
  <script src="{{$settings_dir}}assets/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="{{$settings_dir}}assets/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

  <!-- Plugins -->
  <script src="{{$settings_dir}}assets/vendor/switchery/switchery.min.js"></script>
  <script src="{{$settings_dir}}assets/vendor/intro-js/intro.js"></script>
  <script src="{{$settings_dir}}assets/vendor/screenfull/screenfull.js"></script>
  <script src="{{$settings_dir}}assets/vendor/slidepanel/jquery-slidePanel.js"></script>

  <!-- Scripts -->
  <script src="{{$settings_dir}}assets/js/core.js"></script>
  <script src="{{$settings_dir}}assets/js/site.js"></script>

  <script src="{{$settings_dir}}assets/js/sections/menu.js"></script>
  <script src="{{$settings_dir}}assets/js/sections/menubar.js"></script>
  <script src="{{$settings_dir}}assets/js/sections/sidebar.js"></script>

  <script src="{{$settings_dir}}assets/js/configs/config-colors.js"></script>
  <script src="{{$settings_dir}}assets/js/configs/config-tour.js"></script>

  <script src="{{$settings_dir}}assets/js/components/asscrollable.js"></script>
  <script src="{{$settings_dir}}assets/js/components/animsition.js"></script>
  <script src="{{$settings_dir}}assets/js/components/slidepanel.js"></script>
  <script src="{{$settings_dir}}assets/js/components/switchery.js"></script>

  <!-- Scripts For This Page -->


  <script>
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
        Site.run();
      });
    })(document, window, jQuery);
  </script>


</body>

</html>