<!DOCTYPE html>
<html dir="ltr" lang="en-US">
{{$header}}

<body class="stretched eskipass {{$theme_style}}">
    <div id="wrapper" class="clearfix">
        {{$topnav}}
        <section id="content">
            <div class="content-wrap">
                <div class="container clearfix">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3 class="mb-0">Zaloguj się</h3>
                                </div>
                                <div class="card-body">
                                    <form id="login-form" name="login-form" class="nobottommargin" action="{{$siteUrl}}login/process" method="post">
                                        {{if $error_message}}
                                        <div class="alert alert-danger">
                                            {{$error_message}}
                                        </div>
                                        {{/if}}
                                        
                                        <div class="form-group">
                                            <label for="login-form-username">Email:</label>
                                            <input type="email" id="login-form-username" name="email" class="form-control" required/>
                                        </div>

                                        <div class="form-group">
                                            <label for="login-form-password">Hasło:</label>
                                            <input type="password" id="login-form-password" name="password" class="form-control" required/>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="remember-me" name="remember">
                                                    <label class="custom-control-label" for="remember-me">Zapamiętaj mnie</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-right">
                                                <a href="{{$siteUrl}}reset-password" class="text-dark">Zapomniałeś hasła?</a>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Zaloguj się</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <p class="mb-0">Nie masz jeszcze konta? <a href="{{$siteUrl}}register">Zarejestruj się</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{$footer}}
        {{$scripts}}
    </div>
</body>
</html>


<style>

/* Login Form Styles */
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border-radius: 8px;
    margin-top: 50px;
    margin-bottom: 50px;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #eee;
    padding: 25px 15px;
}

.card-header h3 {
    color: #333;
    font-weight: 600;
}

.card-body {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    height: 45px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px 15px;
}

.form-control:focus {
    border-color: #1ABC9C;
    box-shadow: 0 0 0 0.2rem rgba(26,188,156,.25);
}

.button-black {
    width: 100%;
    height: 45px;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #eee;
    padding: 20px;
}

.custom-control-label {
    cursor: pointer;
}


</style>