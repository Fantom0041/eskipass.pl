<?php
//sekcja
define('MODULE', 'users');
require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."modules/".MODULE."/module/class.Users.php");
$o=new Users;
?>