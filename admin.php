<?php
date_default_timezone_set('Europe/Warsaw'); 
######################### VERSION ################################
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

require_once("teenycms-config.php");

$EN_settings_dir="versions/_engine_v".str_replace(".","_",VER)."/";
$settings_dir="versions/admin_v".str_replace(".","_",VER)."/";
##################################################################

// path to Smarty windows style
define('SMARTY_DIR', $EN_settings_dir."libs/");
define('SETTINGSDIR', $settings_dir);
define('THEMEDIR', SITE_URL.$settings_dir);

require_once($EN_settings_dir."libs/class.EngineLite.php");
require_once($EN_settings_dir."libs/class.Additional.php");
require_once($EN_settings_dir."libs/class.SmartySetup.php");

//ladowanie podstron do szablonu index
include($settings_dir."module.php");
?>