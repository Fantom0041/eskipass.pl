<?php
define('MODULE', 'boksy');
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."modules/".MODULE."/module/class.Boksy.php");
$o=new Boksy;
?>