<?php
$klucze = array_keys($_GET);
$mod = array_shift($klucze);

if ($mod != '') {
    //list modules
    $modules = array();
    if ($handle = opendir(SETTINGSDIR . 'modules/')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $modules[] = $entry;
            }
        }
        closedir($handle);
    }


    $_GET['method'] = 'list';
    if (isset($_GET['a'])) {
        $_GET['method'] = $_GET['a'];
    }

    if (in_array($mod, $modules)) {
        include(SETTINGSDIR . 'modules/' . $mod . '/' . $mod . '.php');
    }else{
        include(SETTINGSDIR . "modules/home/home.php");
    }

} else {

    include(SETTINGSDIR . "modules/home/home.php");
}
