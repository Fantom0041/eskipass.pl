<?php
//sekcja
define('SECTION', 'kategorie');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Kategorie.php");
$o=new Kategorie;

$id=intval($_GET[id]);
$del=intval($_GET[del]);
$review=intval($_GET[review]);
$l=intval($_GET[l]);

if($id>0) {
	$o->EditItem($_POST, $id);
} elseif($del>0) {
	$o->DeleteItem($del);
} else {
	$o->AddItem($_POST);
}
?>