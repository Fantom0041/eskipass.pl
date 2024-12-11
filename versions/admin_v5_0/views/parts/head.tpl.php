<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
    {{$meta.meta}}

  <title>{{$meta.title}} | {{$siteName}}</title>

  <link rel="apple-touch-icon" href="{{$themedir}}assets/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="{{$themedir}}assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{$themedir}}assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{$themedir}}assets/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="{{$themedir}}assets/css/site.min.css">
  <link rel="stylesheet" href="{{$themedir}}assets/css/added.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="{{$themedir}}assets/vendor/flag-icon-css/flag-icon.css">

  <!-- Page -->
  {{$meta.css}}

  <!-- Fonts -->
  <link rel="stylesheet" href="{{$themedir}}assets/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="{{$themedir}}assets/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700'>
  <link rel="stylesheet" href="{{$siteUrl}}themes/eskipass/css/font-icons.css" type="text/css"/>

  <!--[if lt IE 9]>
    <script src="{{$themedir}}assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="{{$themedir}}assets/vendor/media-match/media.match.min.js"></script>
    <script src="{{$themedir}}assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

  <!-- Scripts -->
  <script language="javascript">
  var settings_dir='{{$themedir}}';
  </script>
  <script src="{{$themedir}}assets/vendor/modernizr/modernizr.js"></script>
  <script src="{{$themedir}}assets/vendor/breakpoints/breakpoints.js"></script>
  <script>
    Breakpoints();
  </script>
</head>