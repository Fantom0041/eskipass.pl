
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


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
            return;


        }

        // Render the login template
        $this->output = $this->tpl->fetch("front-login.tpl.php");

    }


    private function handleLogin() 
    {
        $response = ['success' => false, 'message' => ''];
        
        // Validate email
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Proszę podać prawidłowy adres email.';
            echo json_encode($response);
            return;
        }

        // // Validate password
        // if (!isset($_POST['password']) || strlen($_POST['password']) < 6) {
        //     $response['message'] = 'Hasło musi mieć co najmniej 6 znaków.';
        //     echo json_encode($response);
        //     return;
        // }

        $email = $_POST['email'];
        $password = $_POST['password'];

        
        // Add your actual login logic here
        // For example:
        // if ($this->authenticateUser($email, $password)) {
        //     $response['success'] = true;
        //     $response['message'] = 'Zalogowano pomyślnie.';
        // } else {
        //     $response['message'] = 'Nieprawidłowy email lub hasło.';
        // } $response['success'] = true;

        $response['success'] = true;
        $response['message'] = 'Zalogowano pomyślnie.';

        echo json_encode($response);
    }








}

?>