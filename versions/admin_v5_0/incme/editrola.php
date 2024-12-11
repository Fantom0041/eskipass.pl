<?php
//sekcja
define('SECTION', 'rola');

require_once($settings_dir."libs/class.Main.php");
require_once($settings_dir."libs/class.Users.php");
$o=new Users;

$id=intval($_GET[id]);

if($id>0) {
	$o->EditRola($_POST, $id);
}
?>