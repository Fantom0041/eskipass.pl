<?php
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Settings.php");
$o=new Settings;

$o->EditItem($_POST);
?>