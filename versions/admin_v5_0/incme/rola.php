<?php
//sekcja
define('SECTION', 'rola');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Users.php");
$o=new Users;
$o->ListRole();
?>