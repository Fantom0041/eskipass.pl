
<?php

class Userlogin extends Main
{
    public function __construct()
    {
        parent::__construct();
        
        // Set header title
        $this->headerparams['meta']['title'] = "Login - " . SITE_NAME;

        // Load required widgets
        $this->tpl->assign("header", $this->LoadWidget('header', $this->headerparams));
        $this->tpl->assign("topnav", $this->LoadWidget('topnav', $this->topnavparams));
        $this->tpl->assign("footer", $this->LoadWidget('footer', $this->footerparams));
        $this->tpl->assign("scripts", $this->LoadWidget('scripts', array()));

        // Handle form submission
        if (isset($_POST['login-form-submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            // Add your login logic here
        }

        // Check if session exists before accessing it
        if (isset($_SESSION) && array_key_exists('return_message', $_SESSION)) {
            $this->tpl->assign("return_message", '<div class="alert-'.$_SESSION['return_message'][1].' text-center">'.$_SESSION['return_message'][0].'</div>');
            unset($_SESSION['return_message']);
        }

        // Render the login template
        $this->output = $this->tpl->fetch("front-login.tpl.php");
    }
}

?>