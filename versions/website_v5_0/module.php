<?php
$a=key($_GET); //module

if($a=='') $a='home';

if($a!='') {
	//list modules
	$modules = array();
	if ($handle = opendir($settings_dir.'modules/')) {
	    while (false !== ($entry = readdir($handle))) {
	        if ($entry != "." && $entry != "..") {
	            $modules[]=$entry;
	        }
	    }
	    closedir($handle);
	}
	if(!in_array($a,$modules)) $a='home'; 
	
	define('MODULE', $a);
	require_once($settings_dir."libs/class.Main.php");
	
	$obj = ucfirst($a);
	include($settings_dir.'modules/'.$a.'/'.$obj.'.php');
	$o=new $obj;
	if($o->output === false) {
		header('Location: /home');
	} else {
		echo $o->output;
	}	
}
?>