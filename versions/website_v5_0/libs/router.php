<?php

class router {

    static $en;

    public static function __activate($base) {
        self::$en = $base;
//        $arg = str_replace(array('&_rtd=-1', '&_rtd=1'), '', $_SERVER['REQUEST_URI']);
//
//        if ($arg != '')
//            $rt = "?" . $arg;
        
        $rt=ltrim(str_replace(array('&_rtd=-1', '&_rtd=1'), '', $_SERVER['REQUEST_URI']),'/');

        $router = self::$en->ROUTER;

        if ($_GET['_rtd'] != '') {
            $rtd = intval($_GET['_rtd']);
            switch ($rtd) {
                case '1':
                    if (self::$en->CURI == $rt)
                        break;
                    $router[] = self::$en->CURI . '&_rtd=-1';
                    break;

                case '-1':
                    if (self::$en->CURI == $rt)
                        break;
                    array_pop($router);
                    break;
            }
        }
        else {
            if($rt == ltrim(str_replace(array('&_rtd=-1', '&_rtd=1'), '', $router[count($router)-1]),'/')){
                array_pop($router);
            }
        }
        self::$en->CURI = $rt;
        self::$en->ROUTER = $router;
//        var_dump(self::$en->CURI, self::$en->ROUTER);
//        die();
        $rt_back = $router[count($router) - 1];
//        die(var_dump($rt_back));
        if($rt_back!==null){
        define('BACKLINK', SITE_URL.$rt_back);
        self::$en->BACKLINK = BACKLINK;
        }
        if (DEBUG)
            self::log_router();
    }

    public static function log_router() {
        $output = "start:" . date('d-m-Y H:i:s', time()) . "\nRouter:\n" . var_export(self::$en->ROUTER, TRUE) . "\n";
        $output .= "CURI:\n" . var_export(self::$en->CURI, TRUE) . "\n";
        $f = file_put_contents('myrouter.txt', $output);
    }

}
