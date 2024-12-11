<?php
//sekcja
define('MODULE', 'roles');
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."modules/".MODULE."/module/class.Roles.php");
$o=new Roles;
?>