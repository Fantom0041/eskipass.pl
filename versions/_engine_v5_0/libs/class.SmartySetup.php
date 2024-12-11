<?php
require_once(SMARTY_DIR . 'Smarty.class.php');

class SmartySetup extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        global $settings_dir;
//        $this->config_dir = $settings_dir . 'configs';
//        $this->cache_lifetime = 0; //86400;
        $this->setTemplateDir($settings_dir);
        $this->setCompileDir('data/compile');
        $this->setCacheDir('data/cache');
        $this->setCaching(Smarty::CACHING_OFF);
        $this->setCompileCheck(true);
        $this->left_delimiter = '{{';
        $this->right_delimiter = '}}';
    }
}

class SmartySetupWebsite extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        global $settings_dir;
//        $this->config_dir = $settings_dir . 'configs';
//        $this->cache_lifetime = 0; //86400;
        $this->setTemplateDir('themes/' . THEME . '/templates');
        $this->setCompileDir('data/compile');
        $this->setCacheDir('data/cache');
        $this->setCaching(Smarty::CACHING_OFF);
        $this->setCompileCheck(true);
        $this->left_delimiter = '{{';
        $this->right_delimiter = '}}';
    }
}

?>