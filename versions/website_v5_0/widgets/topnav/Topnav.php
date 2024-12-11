<?php
class Topnav {
	private $en = null;
	private $tpl = null;
	public $output = null;
	
	public function __construct($en, $tpl, $params) {
		$this->en = $en;
		$this->tpl = $tpl;
		                
		$this->DisplayTopnav($params);
	}
	
	private function DisplayTopnav($params) {
		$this->tpl->assign("params", $params);
		$this->tpl->assign("userPerm", $this->en->GetUserPerm());
		
//		$this->tpl->assign("active_accommodation", ACTIVE_ACCOMMODATION);
//		$this->tpl->assign("active_activity", ACTIVE_ACTIVITY);
//		$this->tpl->assign("active_events", ACTIVE_EVENTS);
//		$this->tpl->assign("active_service", ACTIVE_SERVICE);
//		$this->tpl->assign("active_schools", ACTIVE_SCHOOLS);
//		$this->tpl->assign("active_rentals", ACTIVE_RENTALS);
		                
		$this->output = $this->tpl->fetch("widgets/topnav.tpl.php");
	}
}