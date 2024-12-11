<?php
//sekcja
define('SECTION', 'users');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Users.php");
$o=new Users;

$id=intval($_GET[id]);
$del=intval($_GET[del]);

if($id>0) {
	$o->EditUser($_POST, $id);
} elseif($del>0) {
	$o->DeleteItem($del);
} else {
	$o->AddUser($_POST);
}
?>