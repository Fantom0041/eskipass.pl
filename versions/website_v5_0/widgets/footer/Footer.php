<?php
class Footer {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		
		$this->DisplayFooter($params);
	}
	
	private function DisplayFooter($params) {
		$this->tpl->assign("params", $params);
		$this->output = $this->tpl->fetch("widgets/footer.tpl.php");
	}
}