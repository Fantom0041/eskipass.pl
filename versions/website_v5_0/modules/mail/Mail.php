<?php
/**
 * Created by PhpStorm.
 * User: czc13
 * Date: 2018-12-13
 * Time: 14:59
 */

class Mail extends Main
{
    public function __construct()
    {
        parent::__construct();
        if ($this->en->IsLoggedIn() == true) {
            //aktywna zakładka
            $this->tpl->assign("activetab", MODULE);
        }

        $this->tpl->assign("mod", $this);
        $this->tpl->assign("urlparam", $this->urlparam);

        switch ($this->urlparam['a']) {
            default:
                $this->SendMail();
        }
    }

    private function SendMail()
    {
        require_once ENSETTINGSDIR.'libs/class.Mailsend.php';
        $data = $_POST;
        if (!empty($data)) {
//            $returnMessage = ['Błąd wysyłki wiadomości','danger'];
            $returnMessage = ['Dziękujemy za wiadomość','success'];
            if (array_key_exists('template-contactform-botcheck', $data)) {
                if ($data['template-contactform-botcheck'] === '') {
                    if (array_key_exists('template-contactform-email', $data) && array_key_exists('template-contactform-message', $data)) {
                        $message = $data['template-contactform-email'] . '<br>' . $data['template-contactform-message'];
                        $conf = array(
                            'host' => 'mail.e-skipass.pl',
                            'port' => 587,
                            'auth' => true,
                            'smtpSecure' => 'tls',
                            'username' => 'zestrony@e-skipass.pl',
                            'password' => 'sqkSEZi!F93',
                            'replyTo' => $data['template-contactform-email']
                        );
                        $success = Mailsend::SendMessage(
                            "=?UTF-8?B?".base64_encode('Wiadomośc ze strony E-Skipass')."?=",
                            $message,
                            'biuro@e-skipass.pl',
                            $conf['username'],
                            'Strona E-Skipass',
                            'smtp',
                            $conf
                        );
                        if ($success) {
                            $returnMessage = ['Wiadomość wysłana pomyslnie','success'];
                        }
                    }
                }
            }
        }
        $_SESSION['return_message'] = $returnMessage;
        if($data['mail_back']){
            header('location:'.$data['mail_back']);
            die();
        }
        header('location:'.SITE_URL);
        die();
    }
}
