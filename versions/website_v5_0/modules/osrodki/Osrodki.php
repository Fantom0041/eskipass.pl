<?php
class Osrodki extends Main {
	
	public function __construct() {
		parent::__construct();
		if ($this->en->IsLoggedIn() == true) {
			//aktywna zakładka
			$this->tpl->assign("activetab", MODULE);
		}
		
		$this->tpl->assign("mod", $this);
		$this->tpl->assign("urlparam", $this->urlparam);

		switch($this->urlparam['a']) {
			default: $this->DisplayList(); 
		}
	}
	
	private function DisplayList() { 
		$this->headerparams['meta']['title'] = SITE_NAME." - ośrodki narciarskie";
		
		//slider główny
                $slider = $this->en->select("SELECT * FROM `".TABLE_PREFIX."glowna_slider` WHERE `ishidden`=0 AND `datastart`<=".time()." AND `datastop`>=".time()." ORDER BY `orderby` ASC, RAND() ASC");
                $this->tpl->assign('slider', $slider);
                
                
		
		$this->tpl->assign("header", $this->LoadWidget('header', $this->headerparams));
		$this->tpl->assign("topnav", $this->LoadWidget('topnav', $this->topnavparams));
		$this->tpl->assign("footer", $this->LoadWidget('footer', $this->footerparams));
                                
		$this->tpl->assign("breadcrumbs", $this->LoadWidget('breadcrumbs', $this->breadcrumbsparams));
		
		$this->output = $this->tpl->fetch("front-osrodki.tpl.php");
	}
}
?>
