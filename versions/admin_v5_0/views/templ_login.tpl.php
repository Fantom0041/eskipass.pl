{{include file="views/parts/head.tpl.php"}}
<body class="page-login layout-full page-dark">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">>
    <div class="page-content vertical-align-middle">
      <div class="brand">
        <img class="brand-img" src="{{$siteUrl}}{{$settings_dir}}assets/images/logo@2x.png" alt="{{$siteName}}">
        <h2 class="brand-text">{{$siteName}}</h2>
      </div>
      <p>Zaloguj się na swoje konto</p>
      <form method="post" action="">
        <div class="form-group">
          <label class="sr-only" for="inputLogin">Login</label>
          <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Login">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputPassword">Hasło</label>
          <input type="password" class="form-control" id="inputPassword" name="passwd"
          placeholder="Password">
        </div>
        
        <button type="submit" class="btn btn-primary btn-block">Zaloguj się</button>
      </form>
      

      {{include file="views/parts/foot.tpl.php"}}
    </div>
  </div>
  <!-- End Page -->


  {{include file="views/parts/common.tpl.php"}}


</body>

</html>