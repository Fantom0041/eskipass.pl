<?php
class Contact {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		                
		$this->DisplayContact($params);
	}
	
	private function DisplayContact($params) {

		$this->output = $this->tpl->fetch("widgets/contact.tpl.php");
	}
}