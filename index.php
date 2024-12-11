<?php
date_default_timezone_set('Europe/Warsaw'); 
######################### VERSION ################################
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

require_once("teenycms-config.php");

$EN_settings_dir="versions/_engine_v".str_replace(".","_",VER)."/";
$settings_dir="versions/website_v".str_replace(".","_",VER)."/";
define('SETTINGSDIR',$settings_dir);
define('ENSETTINGSDIR',$EN_settings_dir);
##################################################################

// path to Smarty windows style
define('SMARTY_DIR', $EN_settings_dir."libs/");

require_once($EN_settings_dir."libs/class.EngineLite.php");
require_once($EN_settings_dir."libs/class.Additional.php");
require_once($EN_settings_dir."libs/class.SmartySetup.php");
require_once($EN_settings_dir."libs/class.PhpMailer.php");

//ladowanie podstron do szablonu index
include($settings_dir."module.php");
?>
