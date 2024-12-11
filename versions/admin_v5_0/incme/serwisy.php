<?php
//sekcja
define('SECTION', 'serwisy');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Serwisy.php");
$o=new Serwisy;

//kasowanie z listy
if($_POST[del]=="1") {
	$o->MultiDeleteItem($_POST[item]);
}

//gety z formularza
$s=intval($_GET[s]);
$strcount=intval($_GET[strcount]);
if($strcount==0) $strcount=20;
$o->ListItems($strcount,$s);
?>