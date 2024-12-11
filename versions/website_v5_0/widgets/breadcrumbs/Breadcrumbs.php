<?php
class Breadcrumbs {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		
		$this->DisplayBreadcrumbs($params);
	}
	
	private function DisplayBreadcrumbs($params) {
		$this->tpl->assign("params", $params);
		$this->output = $this->tpl->fetch("widgets/breadcrumbs.tpl.php");
	}
}