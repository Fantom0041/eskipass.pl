<?php
class Header {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		
		$this->DisplayHeader($params);
	}
	
	private function DisplayHeader($params) {
				
		$this->tpl->assign("params", $params);
		$this->output = $this->tpl->fetch("widgets/header.tpl.php");
	}
}