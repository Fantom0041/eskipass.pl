<?php
define('MODULE', 'magazyn');
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."modules/".MODULE."/module/class.Magazyn.php");
$o=new Magazyn;
?>