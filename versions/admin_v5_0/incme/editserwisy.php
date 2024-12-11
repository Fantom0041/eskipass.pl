<?php
//sekcja
define('SECTION', 'serwisy');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Serwisy.php");
$o=new Serwisy;

$id=intval($_GET[id]);
$del=intval($_GET[del]);

if($id>0) {
	$o->EditItem($_POST, $_FILES, $id);
} elseif($del>0) {
	$o->DeleteItem($del);
} else {
	$o->AddItem($_POST, $_FILES);
}
?>