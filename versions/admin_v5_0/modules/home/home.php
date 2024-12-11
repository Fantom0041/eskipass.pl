<?php
define('MODULE', 'home');
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."modules/".MODULE."/module/class.Home.php");
$o=new Home;
?>