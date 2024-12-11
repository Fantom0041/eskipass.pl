<?php
class Main {
	public $en = null;
	public $app = null;
	public $output = null;
	public $urlparam = array();
	public $postparam = array();
	
	protected $tpl = null;
	protected $add = null;
	
	protected $cache_id="";
	
	protected $settings_dir = null;
	
	//widgets
	protected $topnavparams = array();
	protected $headerparams = array();
	protected $footerparams = array();
	protected $breadcrumbsparams = array();
	
	// error messages
	protected $error = null;
    
	public function __construct() {
            
	    $this->en = new Engine;
	    $this->add = new Additional;
                        
	    $this->UrlParams();
	    $this->PostParams();
	
	    $this->tpl = new SmartySetupWebsite;

	    $this->tpl->assign("module",MODULE);
	    
	    $this->SendSettings();
	    $this->SendEngineData();

	    $this->cache_id=md5("get:".serialize($_GET)."post:".serialize($_POST));
	    
	    //widgets
	    $this->WidgetsData();
		
	}
	
	private function WidgetsData() {
            
                require_once ENSETTINGSDIR.'libs/class.TextPages.php';
                $textpages = new TextPages();
                $textpages->init($this->en, $this->add);
		
		$params = $this->urlparam;
                
                //partnerzy
                $exclude = array(52);
                $partners = $this->en->select("SELECT * "
                        . "FROM `".TABLE_PREFIX."partners` "
                        . "WHERE `partnertype`=6 AND `active`=1 AND `domain` LIKE '%.e-skipass.pl%' AND `id` NOT IN(".implode(",", $exclude).") "
                        . "ORDER BY `name` ASC");
		
		
		$this->topnavparams = array(
                        'selected'=>MODULE,
                        'partners'=>$partners
		);
		
               
		 
		//meta
		$meta = array(
				"title" => SITE_NAME
		);
		$this->headerparams = array(
				//'load'=>'kutas.js',
				'meta'=>$meta
		);
		
		
		$this->footerparams = array(
                        'footerpages'=>$textpages->GetPageList('footer'),
                        'widget2'=>$textpages->GetPage('footer-col2','content'),
                        'partners'=>$partners
		);
		
	}

	protected function SendSettings() {
		global $settings_ver;
		global $settings_dir;
		
		$this->tpl->assign("parama", $_GET['a']);
		$this->tpl->assign("settings_ver", $settings_ver);
		$this->tpl->assign("settings_dir", SITE_URL.$settings_dir);
		$this->tpl->assign("siteUrl", SITE_URL);
		$this->tpl->assign("siteName", SITE_NAME);
		$this->tpl->assign("theme", THEME);
		
		$this->tpl->assign("themedir", SITE_URL.'themes/'.THEME.'/');
		
		$parseUrl = parse_url(SITE_URL);
		$this->tpl->assign("siteDomain", $parseUrl['host']);
	}

	protected function SendEngineData() {
		$this->tpl->assign("en", $this->en);
		$this->tpl->assign("add", $this->add);		
	}

	
	private function PostParams() {
		$this->postparam = $_POST;
		return false;
	}
	
	private function UrlParams() {
		$this->urlparam = $_GET;
		return false;
	}
	
	
	protected function LoadWidget($widget, $params) {
		$widgetsdir = SETTINGSDIR;
		$widgetsdiralt = SETTINGSDIR;

		$obj = ucfirst($widget);
		if(file_exists($widgetsdir.'widgets/'.$widget.'/'.$obj.'.php')) require_once($widgetsdir.'widgets/'.$widget.'/'.$obj.'.php');
		else require_once($widgetsdiralt.'widgets/'.$widget.'/'.$obj.'.php');
		$w = new $obj($this->en, $this->tpl, $params);
		return $w->output;
	}

	
	
	########### CURL
	protected function setCallback($func_name) {
	    $this->callback = $func_name;
	}
	
	protected function doRequest($method, $url, $vars) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    if ($method == 'POST') {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    }
	    $data = curl_exec($ch);
	    
	    if ($data) {
	        if ($this->callback)
	        {
	            $callback = $this->callback;
	            $this->callback = false;
	            return call_user_func($callback, $data);
	        } else {
	            return $data;
	        }
	    } else {
	        return curl_error($ch);
	    }
	    curl_close($ch);
	}
	
	protected function reqget($url) {
	    return $this->doRequest('GET', $url, 'NULL');
	}
	
	protected function reqpost($url, $vars) {
	    return $this->doRequest('POST', $url, $vars);
	}
	
	#ODMIANY
	public function Odmiana($text, $i) {
		$k=0;
		if($i==1) $k=0;
		elseif($i<5 && $i>0) $k=1;
		else $k=2;
		$ex = explode("|",$text);
		return $ex[$k];
	}
	
	
	
	#HELPERS
	protected function BezPL($tekst) {
		$s=array('ż','ź','ć','ń','ą','ś','ł','ę','ó','Ż','Ź','Ć','Ń','Ą','Ś','Ł','Ę','Ó');
		$z=array('z','z','c','n','a','s','l','e','o','Z','Z','C','N','A','S','L','E','O');
		return str_replace($s,$z,$tekst);
	}
	
	protected function ValidSlug($slug) {
		$regslug = "/^([_a-z0-9-]+)$/";
		if (preg_match($regslug, $slug)) return true;
		return false;
	}
	
}