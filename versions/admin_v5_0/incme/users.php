<?php
//sekcja
define('SECTION', 'users');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Users.php");
$o=new Users;

//kasowanie z listy
if($_POST[del]=="1") {
	$o->MultiDeleteItem($_POST[item]);
}

//gety z formularza
$s=intval($_GET[s]);
$strcount=intval($_GET[strcount]);
if($strcount==0) $strcount=20;
$upr=intval($_GET[upr]);
$o->ListUsers($upr,$strcount,$s);
?>