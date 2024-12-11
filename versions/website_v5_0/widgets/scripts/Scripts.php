<?php
class Scripts {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		                
		$this->DisplayScripts($params);
	}
	
	private function DisplayScripts($params) {

		$this->output = $this->tpl->fetch("widgets/scripts.tpl.php");
	}
}